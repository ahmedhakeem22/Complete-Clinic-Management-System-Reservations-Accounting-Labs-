<?php
// choess_blood_box_pdf.php

// 1) استدعاء مكتبة TCPDF (تأكد من وجودها عبر Composer أو في مجلد vendor)
require_once __DIR__ . '/../vendor/autoload.php';

// 2) استدعاء ملف الاتصال بقاعدة البيانات
include '../includes/db.php';

// ضبط المنطقة الزمنية
date_default_timezone_set("Asia/Aden");
$pat_date_now = date("Y-m-d");

// دالة بسيطة للتصفية
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// تحقق من مدخلات pat_id
if (!isset($_POST['pat_id']) || empty($_POST['pat_id'])) {
    echo "Please provide Patinte ID.";
    exit;
}
$pat_id = test_input($_POST['pat_id']);

// تحقق من وجود اختبارات مختارة
if (!isset($_POST['test']) || !is_array($_POST['test']) || count($_POST['test']) === 0) {
    echo "Please choose at least one test.";
    exit;
}
$chose = $_POST['test'];

// جلب اسم المريض
$stmt_name = $conn->prepare("SELECT fname FROM patinte WHERE pat_id = ?");
$stmt_name->bind_param("i", $pat_id);
$stmt_name->execute();
$result_name = $stmt_name->get_result();
$row_name    = $result_name->fetch_assoc();

if (!$row_name) {
    echo "Patient not found in the database.";
    exit;
}
$row_fname = $row_name['fname'];

// جلب بيانات الاختبارات
$placeholders = rtrim(str_repeat('?,', count($chose)), ',');
$sql_tests = "SELECT test_id, test_name, price FROM tests WHERE test_id IN ($placeholders)";
$stmt_tests = $conn->prepare($sql_tests);

$types = str_repeat('i', count($chose));
$stmt_tests->bind_param($types, ...$chose);
$stmt_tests->execute();
$result_tests = $stmt_tests->get_result();

// حساب المجموع
$testsData = [];
$total = 0;
while ($row = $result_tests->fetch_assoc()) {
    $testsData[] = $row;
    $total += $row['price'];
}

// إدخال سجل الفاتورة (اختياري)
$name_ser = "Blood Tests";
$cost_ser = $total;

$stmt_invoice = $conn->prepare("
    INSERT INTO invoice (pat_id, name_ser, cost_ser, invoice_date, fname)
    VALUES (?,?,?,?,?)
");
$stmt_invoice->bind_param("issss", $pat_id, $name_ser, $cost_ser, $pat_date_now, $row_fname);
$stmt_invoice->execute();

// ============= إنشاء مستند PDF =============
$pdf = new TCPDF('P','mm','A4','UTF-8');

// (1) تعطيل الترويسة والتذييل (إن أردت ملء الصفحة بالكامل)
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// (2) تعطيل كسر الصفحة التلقائي والهوامش (لملء الصفحة بالكامل بالخلفية)
$pdf->SetAutoPageBreak(false, 0);
$pdf->SetMargins(0, 0, 0);

// أضف الصفحة
$pdf->AddPage();

// (3) وضع الصورة كخلفية تغطي كامل الصفحة
// A4 عرضها 210mm وطولها 297mm في الوضع العمودي
// تأكّد من أن مسار الصورة صحيح بالنسبة لهذا الملف
$pdf->Image(
    'includes/images/img_back_pdf.png',  // المسار
    0,                                  // إحداثي X
    0,                                  // إحداثي Y
    210,                                // عرض الصورة بالـ mm
    297,                                // طول الصورة بالـ mm
    '',                                 // صيغة الصورة (تلقائي)
    '',                                 // رابط (غير مطلوب)
    '',                                 // إعادة التحجيم
    false,                              // دقّة (keep aspect ratio) - false يعني اننا نضبطها يدويًا
    300,                                // دقّة الصورة
    '',                                 // محاذاة (left/top)
    false,                              // منطق حجم الصفحة
    false,                              // تمييز الصورة في المخرجات
    0                                   // زاوية الدوران
);

// بعد وضع الخلفية، يمكننا إعادة ضبط الهوامش لو احتجنا مساحة للطباعة
$pdf->SetMargins(10, 30, 10);
$pdf->SetAutoPageBreak(true, 10);

// الآن نضيف النصوص/الجداول فوق الصورة
$pdf->Ln(40); // مسافة علوية مثلاً

// إعداد الخط
$pdf->SetFont('freeserif','',13);

// مثال: طباعة التاريخ
$pdf->Cell(140,8,'',0,0,'C',0);
$pdf->Cell(20,8,'Date :',0,0,'C',0);
$pdf->Cell(28,8,$pat_date_now,0,1,'C',0);

$pdf->Ln();

// اسم الطبيب مثلاً
$pdf->Cell(300,8,'الدكتور : عمرو أحمد الخرساني',0,0,'C',0);
$pdf->Ln(10);

// رأس الجدول
$pdf->SetFillColor(247, 224, 211);
$pdf->Cell(25,8,'Patient ID',1,0,'C',true);
$pdf->Cell(60,8,'Patient Name',1,0,'C',true);
$pdf->Cell(40,8,'Service',1,0,'C',true);
$pdf->Cell(60,8,'الاختبارات المختارة',1,1,'C',true);

// الصف الأول
$pdf->SetFont('freeserif','',12);
$pdf->Cell(25,8,$pat_id,1,0,'C',0);
$pdf->Cell(60,8,$row_fname,1,0,'C',0);
$pdf->Cell(40,8,'Blood Tests',1,0,'C',0);

// طباعة أسماء الاختبارات في الأسطر التالية
$first = true;
foreach ($testsData as $testItem) {
    if (!$first) {
        // إن لم يكن السطر الأول، نضيف خلايا فارغة (لإكمال الجدول)
        $pdf->Cell(125, 8, '', 1, 0, 'C', 0);
    }
    $pdf->Cell(60, 8, $testItem['test_name'], 1, 1, 'C', 0);
    $first = false;
}

// طباعة الإجمالي
$pdf->SetFont('freeserif','',16);
$pdf->SetFillColor(240, 240, 239);
$pdf->Cell(30, 8, 'Total', 1, 0, 'C', true);
$pdf->Cell(30, 8, $total, 1, 1, 'C', true);

// تنظيف أي محتوى سابق في الـ buffer
ob_end_clean();

// عرض الملف في المتصفح
$pdf->Output('invoice_blood_tests.pdf', 'I');
exit;
