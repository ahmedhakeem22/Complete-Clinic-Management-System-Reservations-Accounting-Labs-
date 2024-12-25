<?php
// تضمين الملفات اللازمة
require_once __DIR__ . '/../vendor/autoload.php';
require_once '../includes/db.php'; // تأكد من أن مسار ملف قاعدة البيانات صحيح

// لا حاجة لـ 'use TCPDF;' لأن TCPDF في النطاق العام

// إنشاء كائن PDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->AddPage();
$pdf->Ln(42);
$pdf->SetFillColor(165, 225, 166);

// إضافة صورة الخلفية
// تأكد من أن مسار الصورة صحيح وأن الصورة خالية من مشاكل ملف التعريف اللوني
$pdf->Image('includes/images/img_back_pdf.png', 10, 10, 190, 0, 'PNG', '', '', false, 300, '', false, false, 0);

// تعيين المنطقة الزمنية
date_default_timezone_set("Asia/Aden");
$date = date("Y-m-d");

// دالة لتنقية المدخلات
function test_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// التأكد من أن النموذج تم إرساله عبر POST وأن الحقول المطلوبة موجودة
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['pat_id'], $_POST['med_name'], $_POST['quantity'], $_POST['usage'])) {
        $pat_id = test_input($_POST['pat_id']);
        $med_names = $_POST['med_name'];
        $quantities = $_POST['quantity'];
        $usages = $_POST['usage'];

        // التحقق من وجود المريض
        $s = mysqli_prepare($conn, "SELECT fname FROM patinte WHERE pat_id = ?");
        if (!$s) {
            die("خطأ في تحضير الاستعلام: " . $conn->error);
        }
        mysqli_stmt_bind_param($s, 'i', $pat_id);
        mysqli_stmt_execute($s);
        mysqli_stmt_bind_result($s, $row_fname);
        mysqli_stmt_fetch($s);
        mysqli_stmt_close($s);

        if (!$row_fname) {
            die("المريض غير موجود.");
        }

        // إعداد مصفوفة خيارات الاستخدام في الخادم
        $usageOptions = [
            1  => 'حبة قبل الفطور',
            2  => 'نصف حبة قبل الفطور',
            3  => 'حبة بعد الفطور',
            4  => 'نصف حبة بعد الفطور',
            5  => 'حبة قبل الغداء',
            6  => 'نصف حبة قبل الغداء',
            7  => 'حبة بعد الغداء',
            8  => 'نصف حبة بعد الغداء',
            9  => 'حبة قبل العشاء',
            10 => 'نصف حبة قبل العشاء',
            11 => 'حبة بعد العشاء',
            12 => 'نصف حبة بعد العشاء',
            13 => 'حبة قبل النوم',
            14 => 'نصف حبة قبل النوم',
            15 => 'حبة كل أسبوع',
            16 => 'مرتين في الأسبوع',
            // أضف المزيد من الخيارات حسب الحاجة
        ];

        // توليد PDF
        $pdf->SetFont('dejavusans', '', 22);
        $pdf->Cell(55, 8, '', 0, 0, 'C', 0);
        $pdf->Cell(80, 12, 'وصفـــة طبيـــة', 1, 1, 'C', 1);
        $pdf->SetFont('dejavusans', '', 12);
        $pdf->Cell(20, 8, '', 0, 1, 'C', 0);
        $pdf->SetFillColor(165, 225, 166);
        $pdf->Cell(5, 8, '', 0, 0, 'C', 0);

        $pdf->Cell(25, 8, 'رقم المريض', 1, 0, 'C', 1);
        $pdf->Cell(15, 8, $pat_id, 1, 0, 'C', 1);

        $pdf->Cell(25, 8, 'اسم المريض', 1, 0, 'C', 1);
        $pdf->Cell(60, 8, $row_fname, 1, 0, 'C', 1);

        $pdf->Cell(15, 8, 'تاريخ', 1, 0, 'C', 1);
        $pdf->Cell(35, 8, $date, 1, 1, 'C', 1);
        $pdf->Ln(10);

        $pdf->SetFillColor(171, 209, 254);
        $pdf->Cell(28, 8, '', 0, 0, 'C', 0);
        $pdf->Cell(80, 8, 'اســـم الـــدواء', 1, 0, 'C', 1);
        $pdf->Cell(50, 8, 'الكميـــة', 1, 1, 'C', 1);

        // إعداد استعلام الإدراج باستخدام Prepared Statements
        // تم تعديل العمود ليشمل fname وتصحيح اسم العمود countity إلى quantity إذا قمت بتعديل الجدول
        $stmt = $conn->prepare("INSERT INTO medical (pat_id, fname, med_name, usee, countity, date_t) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("خطأ في تحضير الاستعلام: " . $conn->error);
        }

        for ($j = 0; $j < count($med_names); $j++) {
            $med_name = test_input($med_names[$j]);
            $quantity = (int)test_input($quantities[$j]);
            $selected_usages = isset($usages[$j]) ? $usages[$j] : [];

            // توليد نص "طريقة الاستخدام"
            $medcal_skills = [];
            foreach ($selected_usages as $usage_id) {
                if (isset($usageOptions[$usage_id])) {
                    $medcal_skills[] = $usageOptions[$usage_id];
                }
            }
            $medcal_skills_str = implode(', ', $medcal_skills);

            // ربط المعاملات: pat_id (int), fname (string), med_name (string), usee (string), countity (int), date_t (string)
            $stmt->bind_param("isssis", $pat_id, $row_fname, $med_name, $medcal_skills_str, $quantity, $date);

            if (!$stmt->execute()) {
                echo "خطأ في الإدراج: " . $stmt->error;
            }

            // إعداد بيانات PDF
            $pdf->Cell(28, 8, '', 0, 0, 'C', 0);
            $pdf->SetFillColor(177, 232, 178);
            $pdf->Cell(80, 8, $med_name, 1, 0, 'C', 1);
            $pdf->Cell(50, 8, $quantity, 1, 1, 'C', 1);

            $pdf->SetFillColor(211, 247, 212);
            $pdf->Cell(28, 8, '', 0, 0, 'C', 0);
            $pdf->Cell(130, 8, $medcal_skills_str, 1, 1, 'C', 1);
        }

        $stmt->close();

        $pdf->SetFont('freeserif', '', 14);

        // تنظيف محتويات البوفر
        if (ob_get_length()) {
            ob_end_clean();
        }

        // إرسال الـ PDF للمستخدم
        $pdf->Output('sale.pdf', 'I');
    } else {
        die("بيانات النموذج غير كاملة.");
    }
} else {
    die("طريقة الطلب غير صالحة.");
}
?>
