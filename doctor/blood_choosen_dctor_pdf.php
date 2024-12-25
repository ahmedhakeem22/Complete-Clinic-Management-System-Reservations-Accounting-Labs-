<?php
require_once __DIR__ . '/../vendor/autoload.php';

include '../includes/db.php';
date_default_timezone_set("Asia/Aden");

// -----------------------------------------------------------------------------
// دالة بسيطة لتنقية البيانات
// -----------------------------------------------------------------------------
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// -----------------------------------------------------------------------------
// مصفوفة للاختبارات المتاحة. المفتاح = رقم الاختبار، القيمة = اسمه
// -----------------------------------------------------------------------------
$testsMap = [
    1   => 'C.B.C',
    101 => 'HB',
    102 => 'WBC',
    2   => 'Platelats',
    3   => 'ESR',
    4   => 'Malaria',
    7   => 'CT',
    8   => 'PT',
    // 103 => 'INR', // مُعلق في الكود الأصلي، أضفه إذا أردت
    9   => 'BT',
    10  => 'Reticulocyte',
    11  => 'Sickling test',
    12  => 'PTT',
    13  => 'D_Dimer',
    14  => 'F.B.S',
    15  => 'R.B.S',
    16  => 'P.PBS',
    17  => 'HBA 1C',
    18  => 'KFT',
    104 => 'Urea',
    105 => 'Creatinine',
    19  => 'LFT',
    106 => 'S.Got',
    107 => 'S.Gpt',
    108 => 'Total Bilirubin',
    109 => 'Dirict Bilirubin',
    20  => 'ALK.Phospats',
    21  => 'Albumin',
    22  => 'Electrolytes',
    110 => 'Ca++',
    111 => 'K+',
    112 => 'Na+',
    113 => 'Cl-',
    114 => 'Mg++',
    23  => 'Cardiac Enzyme',
    115 => 'C.K',
    116 => 'CK-MG',
    117 => 'L.D.H',
    118 => 'Cholesterol',
    119 => 'Triglyceride',
    120 => 'LDL',
    121 => 'HDL',
    24  => 'Lipid',
    25  => 'Uricacid',
    26  => 'ASO',
    27  => 'C.R.P',
    28  => 'RF',
    29  => 'Widal Test',
    30  => 'Brucella',
    31  => 'BLOOD Group',
    32  => 'TB',
    122 => 'HIV',
    123 => 'HCV',
    124 => 'HBS-Ag',
    36  => 'VDRL',
    37  => 'H.PYLORI RB',
    38  => 'H.PYLORI AG',
    39  => 'T.Patinte',
    40  => 'Ethanol',
    41  => 'Diazepam',
    42  => 'Marijuana',
    43  => 'Tramedol',
    44  => 'Heroin',
    45  => 'Pethidine',
    46  => 'Cocaine',
    47  => 'Amphetamine',
    48  => 'T3',
    49  => 'T4',
    50  => 'TSH',
    51  => 'Prolactin',
    52  => 'PSA',
    53  => 'PS3',
    54  => 'Vit-B12',
    55  => 'Vit-D3',
    56  => 'CA 153',
    57  => 'CA 125',
];

// -----------------------------------------------------------------------------
$pat_date_now = date("Y-m-d");

if (isset($_GET['pat_id'])) {
    // ننقي المدخلات
    $pat_id = intval(test_input($_GET['pat_id'])); 
    $fname  = isset($_GET['fname']) ? test_input($_GET['fname']) : '';

    if (isset($_GET['test']) && is_array($_GET['test'])) {
        // تحويل القيم إلى أعداد صحيحة (حماية إضافية)
        $chose = array_map('intval', $_GET['test']);

        // جلب اسم المريض من قاعدة البيانات
        // مفضل استخدام الاستعلامات المجهزة (Prepared Statements)
        $query  = "SELECT fname FROM patinte WHERE pat_id = ?";
        $stmt   = $conn->prepare($query);
        $stmt->bind_param('i', $pat_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row    = $result->fetch_assoc();

        $row_fname = $row ? $row['fname'] : '';

        // إنشاء كائن TCPDF
        $pdf = new TCPDF('P', 'mm', 'A4', 'UTF-8', false);
        $pdf->AddPage();
        $pdf->SetFont('freeserif', '', 14);

        // خلفية
        $pdf->Image('includes/images/img_back_pdf.png', 10, 10, -300);

        // تنسيق العنوان والترويسة
        $pdf->Ln(27);
        $pdf->Cell(140, 8, '', 0, 0, 'C', 0);
        $pdf->Cell(14, 8, 'date:', 0, 0, 'C', 0);
        $pdf->Cell(28, 8, $pat_date_now, 0, 1, 'C', 0);
        $pdf->Ln();

        $pdf->Cell(300, 8, 'الدكتور : عمرو أحمـــد الخـــرساني', 0, 1, 'C', 0);
        $pdf->Ln(1);

        // معلومات المريض
        $pdf->Cell(5, 8, '', 0, 0, 'C', 0);
        $pdf->Cell(25, 8, 'Patinte ID :', 1, 0, 'C', 0);
        $pdf->Cell(15, 8, $pat_id, 1, 0, 'C', 0);
        $pdf->Cell(35, 8, 'Patinte Name :', 1, 0, 'C', 0);
        $pdf->Cell(50, 8, $row_fname, 1, 0, 'C', 0);
        $pdf->Cell(50, 8, ' اختبارات الدم المختاره', 1, 1, 'C', 0);

        // إدراج الاختبارات المختارة من المصفوفة
        foreach ($chose as $testId) {
            if (isset($testsMap[$testId])) {
                $pdf->Cell(5, 8, '', 0, 0, 'C', 0);
                $pdf->Cell(125, 8, '', 1, 0, 'C', 0);
                $pdf->Cell(50, 8, $testsMap[$testId], 1, 1, 'C', 0);
            }
        }

        // تفريغ المخزن المؤقت
        ob_end_clean();
        // إخراج الملف PDF للمتصفح
        $pdf->Output('blood_choosen_dctor_pdf.pdf', 'I');
        exit;
    } else {
        echo "الرجاء اختيار اختبارات الدم وإعادة المحاولة.";
    }
} else {
    echo "الرجاء إدخال معرف المريض وإعادة المحاولة.";
}

// للاختبار
var_dump(["data" => "demo"]);
