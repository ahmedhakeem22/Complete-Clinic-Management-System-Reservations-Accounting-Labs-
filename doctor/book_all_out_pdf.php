<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', '0');
require_once __DIR__ . '/../vendor/autoload.php';

// الاتصال بقاعدة البيانات
include '../includes/db.php';

date_default_timezone_set("Asia/Aden");
$current_date = date("Y-m-d");

/**
 * دالة بسيطة لتعقيم المدخلات
 */
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

/**
 * تمديد كلاس TCPDF لإضافة خلفية ونص متكرر في كل صفحة
 */
class PDF extends TCPDF {
    // متغيّر عام للاحتفاظ بتاريخ التقرير
    public $reportDate = '';

    // دالة الهيدر (تعاد في كل صفحة تلقائيًّا)
    public function Header() {
      // رسم الخلفية
      $image_file = __DIR__ . '/includes/images/img_back_pdf.png';
      if (file_exists($image_file)) {
          $pageWidth  = $this->getPageWidth();
          $pageHeight = $this->getPageHeight();
          $this->Image($image_file, 0, 0, $pageWidth, $pageHeight, '', '', '', false, 300, '', false, false, 0);
      }
  
      // تحريك المؤشر إلى الأسفل أكثر
      // زِد قيمة Y لينزل النص حسب الحاجة
      $this->SetXY(10, 35);
  
      // العبارة: كشف مخرجات الصندوق
      $this->SetFont('aealarabiya', '', 14);
      $this->Cell(110, 10, 'كشف مخرجات الصندوق', 0, 0, 'C');
  
      // التاريخ
      $this->SetFont('aealarabiya', '', 12);
      $this->Cell(40, 10, $this->reportDate, 1, 0, 'C');
      $this->Cell(30, 10, 'التاريخ:', 1, 1, 'C');
  
      // يمكنك أيضًا إضافة سطر فارغ إضافي إذا احتجت مزيدًا من الفراغ
      $this->Ln(20); 
  }
  

    // دالة الفوتر (تعاد في كل صفحة تلقائيًّا)
    public function Footer() {
        // تحديد المكان 15 ملم من أسفل الصفحة
        $this->SetY(-15);
        $this->SetFont('dejavusans', 'B', 10);
        $this->Cell(0, 10, 'صفحة ' . $this->PageNo(), 0, 0, 'C');
    }
}

// إنشاء كائن PDF
$pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false);

// إيصال التاريخ إلى داخل الكلاس
$pdf->reportDate = $current_date;

// إلغاء الهوامش لتغطية الخلفية كامل الصفحة (إن أردت)
$pdf->SetMargins(0, 0, 0);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);
$pdf->SetAutoPageBreak(TRUE, 0);

// تفعيل الهيدر والفوتر
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true);

// إضافة صفحة
$pdf->AddPage();

// (اختياري) إذا رغبت بترك مسافة من الأعلى قبل بقية البيانات
// يمكنك الاكتفاء بالمسافة التي تركتها في الهيدر (Ln(10)).
// أو تضيف هنا مسافة أخرى:

// مثلاً سنجلب بيانات من Pay_bill
$query = mysqli_query($conn, "SELECT * FROM Pay_bill");

// إعدادات جدول أو نصوص أخرى ...
$pdf->SetFont('aealarabiya', '', 12);

function addTableHeader($pdf) {
  $pdf->Ln(50); // إضافة المسافة هنا
    $pdf->SetFont('aealarabiya', '', 12);
    $pdf->SetFillColor(20, 230, 230);
    $pdf->Cell(20, 10, '', 0, 0); 
    $pdf->Cell(20, 10, 'رقم الفاتورة', 1, 0, 'C', true);
    $pdf->Cell(80, 10, 'اسم الخدمة', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'المبلغ', 1, 0, 'C', true);
    $pdf->Cell(40, 10, 'التاريخ', 1, 1, 'C', true);
}

addTableHeader($pdf);

$counter = 0;
$maxPerPage = 18;
$total_amount = 0;

while ($row = mysqli_fetch_array($query)) {
    if ($counter >= $maxPerPage) {
        $pdf->AddPage();
        addTableHeader($pdf);
        $counter = 0;
    }

    $pdf->Cell(20, 10, '', 0, 0);
    $pdf->Cell(20, 10, $row['bill_id'], 1, 0, 'C');
    $pdf->Cell(80, 10, $row['recip_name'], 1, 0, 'C');
    $pdf->Cell(40, 10, number_format($row['amount'], 2), 1, 0, 'C');
    $pdf->Cell(40, 10, $row['bill_date'], 1, 1, 'C');

    $total_amount += $row['amount'];
    $counter++;
}

// طباعة إجمالي المبلغ
$pdf->Ln(10);
$pdf->SetFont('aealarabiya', 'B', 12);
$pdf->Cell(50, 10, '', 0, 0);

$pdf->SetFillColor(255, 165, 0); // برتقالي
$pdf->Cell(50, 10, number_format($total_amount, 2), 1, 0, 'C', true); // تفعيل التعبئة
$pdf->SetFillColor(20, 230, 230);
$pdf->Cell(80, 10, 'إجمالي المبلغ:', 1, 1, 'C', true);



// إخراج ملف الـ PDF للمتصفح
$pdf->Output();
?>
