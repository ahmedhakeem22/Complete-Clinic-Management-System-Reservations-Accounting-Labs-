<?php
// شغل الـ session في حال كنت تحتاجه
// session_start();

// تحميل مكتبة TCPDF (تأكد من صحة المسار)
require_once __DIR__ . '/../vendor/autoload.php';

// تضمين ملف الاتصال بقاعدة البيانات
include '../includes/db.php';

/**
 * دالة تنظيف المدخلات
 */
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// ضبط المنطقة الزمنية
date_default_timezone_set("Asia/Aden");
$pat_date_now = date("Y-m-d");

// نبدأ بفحص معاملات GET الأساسية
if (!isset($_GET['pat_id'])) {
    exit("الرجاء تمرير رقم المريض (pat_id) للمحاولة مرة أخرى.");
}

// نستخرج المعطيات المطلوبة من $_GET بطريقة آمنة
$pat_id = test_input($_GET['pat_id']);

// (اختياري) إذا كنت تريد استخدام fname القادم من GET
// تأكد أنه فعلاً مرسل من الـ URL
$fname = "";
if (isset($_GET['fname'])) {
    $fname = test_input($_GET['fname']);
}

// هنا نتأكد هل تم تمرير الفحوصات المحددة (test)
if (!isset($_GET['test'])) {
    exit("الرجاء تحديد فحوصات الدم (test) للمحاولة مرة أخرى.");
}

// نجلب الـ array الذي يحتوي على قيم الفحوصات المختارة
$chose = $_GET['test'];
$c = count($chose);

// نجلب اسم المريض من جدول patinte
// لاحظ هنا أننا استعضنا عن استخدام $_GET['fname'] بقراءة الاسم من الجدول
$queryGetName = "SELECT fname FROM patinte WHERE pat_id = ?";
$stmtGetName = $conn->prepare($queryGetName);
$stmtGetName->bind_param("i", $pat_id);
$stmtGetName->execute();
$resultGetName = $stmtGetName->get_result();

if ($resultGetName->num_rows > 0) {
    $row = $resultGetName->fetch_assoc();
    $row_fname = $row['fname'];
} else {
    // في حال لم يتم العثور على هذا المريض
    exit("رقم المريض غير موجود في قاعدة البيانات.");
}

// نعرف متغيرات سنستخدمها لاحقًا
$name_ser = "book blood";
$total = 0.0;

// ننشئ كائن TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

// إعدادات أساسية للـ PDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('د. عمرو أحمد الخرساني');
$pdf->SetTitle('Blood Tests');
$pdf->SetSubject('Blood Tests Invoice');
$pdf->SetKeywords('TCPDF, PDF, invoice, blood, tests');

// إضافة صفحة
$pdf->AddPage();

// اختيار الخط (تأكد من توافر freeserif مثلاً ضمن مكتبتك)
$pdf->SetFont('freeserif', '', 13);

// تفريغ أي مخرجات في البافر قبل الطباعة
ob_clean();

// يمكن وضع خلفية أو صورة
// تأكد من صحة المسار للصورة
$pdf->Image('includes/images/img_back_pdf.png', 10, 10, -300);

// مسافة للأسفل
$pdf->Ln(27);

// الطباعة: التاريخ
$pdf->Cell(140, 8, '', 0, 0, 'C', 0);
$pdf->Cell(20, 8, 'Date :', 0, 0, 'C', 0);
$pdf->Cell(28, 8, $pat_date_now, 0, 1, 'C', 0);
$pdf->Ln();

// اسم الطبيب
$pdf->Cell(300, 8, 'الدكتور : عمرو أحمـــد الخـــرساني', 0, 0, 'C', 0);
$pdf->Ln();

// عنوان الجدول
$pdf->SetFillColor(247, 224, 211);
$pdf->Cell(25, 8, 'Patient ID', 1, 0, 'C', true);
$pdf->Cell(60, 8, 'Patient Name', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Service', 1, 0, 'C', true);
$pdf->Cell(60, 8, 'الفحوصات المختارة', 1, 1, 'C', true);

// محتوى الجدول للسطر الأول
$pdf->SetFont('freeserif','',12);
$pdf->Cell(25, 8, $pat_id, 1, 0, 'C', 0);
$pdf->Cell(60, 8, $row_fname, 1, 0, 'C', 0);
$pdf->Cell(40, 8, $name_ser, 'B', 0, 'C', 0);

/**
 * دالة مساعدة: تعيد اسم الفحص + سعره.
 * في حال رغبت بالتعديل أو إضافة فحوصات جديدة، أضفها هنا.
 */
function getTestInfoById($testId) {
    switch ($testId) {
        case 1:   return ['C.B.C', 1500];
        case 101: return ['HB', 500];
        case 102: return ['WBC', 500];
        case 2:   return ['Platelats', 500];
        case 3:   return ['ESR', 500];
        case 4:   return ['Malaria', 1000];
        case 7:   return ['CT', 400];
        case 8:   return ['PT', 1500];
        case 9:   return ['BT', 400];
        case 10:  return ['RETICULOCYTE', 1000];
        case 11:  return ['Sickling test', 2000];
        case 12:  return ['PTT', 1500];
        case 13:  return ['D_Dimer', 8000];
        case 14:  return ['F.B.S', 600];
        case 15:  return ['R.B.S', 600];
        case 16:  return ['P.PBS', 600];
        case 17:  return ['HBA 1C', 4000];
        case 18:  return ['KFT', 2000];
        case 104: return ['Urea', 1000];
        case 105: return ['Creatinine', 1000];
        case 19:  return ['LFT', 3500];
        case 106: return ['S.Got', 900];
        case 107: return ['S.Gpt', 900];
        case 108: return ['Total Bilirubin', 900];
        case 109: return ['Dirict Bilirubin', 900];
        case 20:  return ['ALK.Phospats', 1000];
        case 21:  return ['Albumin', 1000];
        case 22:  return ['Electrolytes', 7500];
        case 110: return ['Ca++', 1500];
        case 111: return ['K++', 1500];
        case 112: return ['Na++', 1500];
        case 113: return ['Cl++', 1500];
        case 114: return ['Mg++', 1500];
        case 23:  return ['Cardiac Enzyme', 6000];
        case 115: return ['C.K', 2000];
        case 116: return ['CM-MB', 2000];
        case 117: return ['L.D.H', 2000];
        case 24:  return ['Lipid', 7000];
        case 118: return ['Cholesterol', 1800];
        case 119: return ['Triglyceride', 1800];
        case 120: return ['LDL', 1800];
        case 121: return ['HDL', 1800];
        case 25:  return ['Uric Acid', 1500];
        case 39:  return ['T.Protine', 1500];
        case 26:  return ['ASO', 1500];
        case 27:  return ['C.R.P', 1500];
        case 28:  return ['RF', 1500];
        case 29:  return ['Widal test', 1500];
        case 30:  return ['Brucella A+M', 1500];
        case 31:  return ['BLOOD Group', 600];
        case 32:  return ['TB', 2000];
        case 33:  return ['Viral Marker', 6000];
        case 122: return ['HIV', 2000];
        case 123: return ['HCV', 2000];
        case 124: return ['HBS-Ag', 2000];
        case 36:  return ['VDRL', 2000];
        case 37:  return ['H.PYLORI RB', 2500];
        case 38:  return ['H.PYLORI AG', 3500];
        case 40:  return ['Ethanol', 8000];
        case 41:  return ['Diazepam', 8000];
        case 42:  return ['Marijuana', 8000];
        case 43:  return ['Tramedol', 8000];
        case 44:  return ['Heroin', 8000];
        case 45:  return ['Pethidine', 8000];
        case 46:  return ['Cocaine', 8000];
        case 47:  return ['Amphetamine', 8000];
        case 48:  return ['T3', 3000];
        case 49:  return ['T4', 3000];
        case 50:  return ['TSH', 3000];
        case 51:  return ['Prolactin', 3000];
        case 52:  return ['PSA Free', 4000];
        case 53:  return ['PSA Total', 4000];
        case 54:  return ['Vit-B12', 4000];
        case 55:  return ['Vit-D3', 12000];
        case 56:  return ['CA 153', 5000];
        case 57:  return ['CA 125', 5000];
    }
    // في حال لم نجد الفحص في القائمة
    return ['Unknown Test', 0];
}

// نبدأ الطباعة للسطر الثاني وما بعده
for ($i = 0; $i < $c; $i++) {
    // جلب المعلومات
    $testId = $chose[$i];
    list($testName, $testCost) = getTestInfoById($testId);

    // نجمع التكلفة الكلية
    $total += $testCost;

    // نطبع الخلية في الـ PDF
    $pdf->Cell(60, 8, $testName, 1, 1, 'C', 0);
    // بعد الطباعة، نطبع خلية فارغة للسطر الجديد (حتى يستمر الجدول بشكل مرتب)
    $pdf->Cell(125, 8, '', 1, 0, 'C', 0);
}

// طباعة الإجمالي
$pdf->SetFont('freeserif', '', 16);
$pdf->SetFillColor(240, 240, 239);
$pdf->Cell(30, 8, 'Total', 1, 0, 'C', true);
$pdf->Cell(30, 8, $total, 1, 1, 'C', true);

// الآن نحفظ البيانات في جدول الفواتير (invoice)
// تأكد أن الجدول يقبل الحقل fname إذا كنت تريد حفظه
// إذا لم يكن في الجدول أو كان NULL مسموحاً به يمكنك إزالته/تعديله
$insertQuery = "INSERT INTO invoice (pat_id, fname, name_ser, cost_ser, invoice_date)
                VALUES (?,?,?,?,?)";
$stmtInsert = $conn->prepare($insertQuery);
$stmtInsert->bind_param("issss", $pat_id, $row_fname, $name_ser, $total, $pat_date_now);

try {
    $stmtInsert->execute();
} catch (Exception $e) {
    // أي خطأ في عملية الإدخال
    exit("حصل خطأ أثناء إدخال البيانات في الفاتورة: " . $e->getMessage());
}

// إنهاء وإخراج الملف PDF في نافذة المتصفح
// يفضل قبل الإخراج النهائي تنظيف البافر
ob_end_clean();
$pdf->Output('choess_blood_box.pdf', 'I');

// لإظهار أي بيانات للتجربة أو الديباغ:
var_dump([
    "data" => "demo",
    "pat_id" => $pat_id,
    "fname_from_db" => $row_fname,
    "total_cost" => $total
]);
