<?php
// تعطيل الأخطاء التحذيرية (اختياري)
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', '0');

// بدء تخزين المخرجات قبل الإرسال للمتصفح
ob_start();

// استدعاء مكتبة TCPDF
require_once __DIR__ . '/../vendor/autoload.php';

// الاتصال بقاعدة البيانات
include '../includes/db.php';

/*
    نفترض أن هذه الصفحة تستقبل المعايير عبر $_GET
    تمامًا كما في box.php:
      - service_type
      - date_from
      - date_to
      - pat_id
    لتصفية النتائج.
*/

// الاستعلام الأساسي
$sql = "SELECT * FROM invoice WHERE 1=1";
$params = [];
$types  = '';

// إذا كان المستخدم قد أرسل فلاتر
if (isset($_GET['filter'])) {
    // نوع الخدمة
    if (!empty($_GET['service_type'])) {
        $sql      .= " AND name_ser = ?";
        $params[]  = $_GET['service_type'];
        $types    .= 's';
    }
    // تاريخ البداية
    if (!empty($_GET['date_from'])) {
        $sql      .= " AND invoice_date >= ?";
        $params[]  = $_GET['date_from'];
        $types    .= 's';
    }
    // تاريخ النهاية
    if (!empty($_GET['date_to'])) {
        $sql      .= " AND invoice_date <= ?";
        $params[]  = $_GET['date_to'];
        $types    .= 's';
    }
    // رقم المريض
    if (!empty($_GET['pat_id'])) {
        $sql      .= " AND pat_id = ?";
        $params[]  = $_GET['pat_id'];
        $types    .= 's';
    }
}

// ترتيب اختياري (حسب تاريخ الفاتورة تنازليًا مثلاً)
$sql .= " ORDER BY invoice_date DESC";

// تحضير الاستعلام
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die('Prepare failed: ' . htmlspecialchars($conn->error));
}

// ربط المعاملات إذا وُجدت
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// ----------------------------------------------
// إنشاء كلاس يرث من TCPDF لتطبيق الخلفية ونص الهيدر
// ----------------------------------------------
class MyPDF extends TCPDF
{
    public $reportDate = ''; // لتخزين تاريخ التقرير وعرضه في الهيدر
    
    // هيدر يتكرر بكل صفحة
    public function Header()
    {
        // 1) رسم الخلفية
        $bg_image = __DIR__ . '/includes/images/img_back_pdf.png'; // عدّل المسار بحسب مشروعك
        if (file_exists($bg_image)) {
            $pageWidth  = $this->getPageWidth();
            $pageHeight = $this->getPageHeight();
            // رسم الصورة لتغطي كامل الصفحة
            $this->Image(
                $bg_image,
                0,             // X
                0,             // Y
                $pageWidth,    // العرض = عرض الصفحة
                $pageHeight,   // الارتفاع = ارتفاع الصفحة
                '', '', '', 
                false,         // keepAspectRatio = false
                300,           // الدقة
                '', false, false, 0
            );
        }

        // 2) طباعة عنوان التقرير والتاريخ فوق الخلفية
        $this->SetXY(0, 30); // النقطة (0,10) من أعلى الزاوية اليسرى (بعد الهامش)
        $this->SetFont('aealarabiya', 'B', 14);
        $this->Cell(0, 10, 'تقرير الفواتير', 0, 1, 'C', false);

        // التاريخ
        $this->SetFont('aealarabiya', '', 12);
        $this->Cell(0, 8, 'التاريخ: ' . $this->reportDate, 0, 1, 'C', false);

        // مسافة بسيطة قبل بداية الجدول (يمكن تعديلها)
        $this->Ln(5);
    }

    // فوتر يتكرر بكل صفحة (اختياري)
    public function Footer()
    {
        // تحديد موضع في أسفل الصفحة
        $this->SetY(-10);
        $this->SetFont('aealarabiya','',10);
        $this->Cell(0, 10, 'صفحة ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
    }
}

// ----------------------------------------------
// إنشاء كائن PDF
// ----------------------------------------------
$pdf = new MyPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// تخزين تاريخ التقرير (مثلاً تاريخ اليوم)
$pdf->reportDate = date('Y-m-d');

// تعطيل الهوامش تمامًا ليظهر الغلاف على كل الصفحة
$pdf->SetMargins(0, 0, 0);
$pdf->SetAutoPageBreak(true, 0);

// تفعيل الهيدر والفوتر
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);

// إضافة صفحة أولى
$pdf->AddPage();

// دالة لطباعة عناوين الجدول
function printTableHeader($pdf)
{
    $pdf->Ln(50); // إضافة المسافة هنا
$pdf->SetFont('aealarabiya', 'B', 12);

// تعيين لون الخلفية
$pdf->SetFillColor(20, 230, 230); // اللون المطلوب

// إنشاء الخلايا مع تفعيل الخلفية
$pdf->Cell(10, 10, '', 0, 0); 
$pdf->Cell(30, 10, 'رقم الفاتورة',    1, 0, 'C', true);
$pdf->Cell(30, 10, 'رقم المريض',      1, 0, 'C', true);
$pdf->Cell(50, 10, 'اسم الخدمة',      1, 0, 'C', true);
$pdf->Cell(30, 10, 'التكلفة',         1, 0, 'C', true);
$pdf->Cell(50, 10, 'تاريخ الفاتورة', 1, 1, 'C', true);

}

// استدعاء الدالة لطباعة رأس الجدول
printTableHeader($pdf);

// متغير للتحكم بعدد السطور في كل صفحة
$rowsPerPage = 20;
$counter = 0;

// متغير لحساب الإجمالي (اختياري)
$totalAmount = 0.0;

$pdf->SetFont('aealarabiya','',12);

// طباعة النتائج
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 10, '', 0, 0); 
        $pdf->Cell(30, 10, $row['invoice_id'],        1, 0, 'C', false);
        $pdf->Cell(30, 10, $row['pat_id'],            1, 0, 'C', false);
        $pdf->Cell(50, 10, $row['name_ser'],          1, 0, 'C', false);
        $pdf->Cell(30, 10, number_format($row['cost_ser'],2), 1, 0, 'C', false);
        $pdf->Cell(50, 10, $row['invoice_date'],      1, 1, 'C', false);

        $totalAmount += floatval($row['cost_ser']);
        $counter++;

        // إذا وصلنا 20 صفًا، أضف صفحة جديدة
        if ($counter >= $rowsPerPage) {
            $pdf->AddPage();
            // إعادة طباعة رأس الجدول في الصفحة الجديدة
            printTableHeader($pdf);
            $counter = 0; 
        }
    }
} else {
    // لا توجد نتائج
    $pdf->Cell(0, 10, 'لا توجد نتائج مطابقة', 1, 1, 'C', false);
}

// طباعة الإجمالي في الأسفل
$pdf->Ln(5);

$pdf->Cell(50, 10, '', 0, 0);
$pdf->SetFillColor(255, 165, 0); // برتقالي
$pdf->SetFont('aealarabiya','',12);
$pdf->Cell(60, 10, number_format($totalAmount, 2), 1, 0, 'C', true); // تمكين الخلفية باستخدام true

// تعيين لون خلفية للخلية الثانية
$pdf->SetFillColor(20, 230, 230); // اللون المطلوب
$pdf->SetFont('aealarabiya','B',12);
$pdf->Cell(60, 10, 'إجمالي التكلفة:', 1, 1, 'C', true); // تمكين الخلفية باستخدام true


// تنظيف البافر (المخزن المؤقت) قبل الإخراج
ob_end_clean();
$pdf->Output('all_invoices_report.pdf','I');
exit;
