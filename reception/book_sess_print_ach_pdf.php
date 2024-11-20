<?php
// Suppress deprecated and notice warnings temporarily
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

require_once('../TCPDF-master/tcpdf.php');

// اتصال قاعدة البيانات عبر ملف db.php
include 'includes/db.php'; // Use a relative path

// تعيين الترميز إلى utf8mb4
mysqli_set_charset($conn, "utf8mb4");

// تحديد قاعدة البيانات
mysqli_select_db($conn, "najmdb");

// إعداد المنطقة الزمنية
date_default_timezone_set("Asia/Aden");
$pat_date_now = date("Y-m-d");

// دالة تنظيف المدخلات
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if (isset($_GET['pat_id']) && isset($_GET['fname'])) {
    // تنظيف المدخلات
    $pat_id = test_input($_GET['pat_id']);
    $fname = test_input($_GET['fname']);
    
    // معلومات الخدمة
    $name_ser = "Book Session";
    $cost_ser = 3000;

    // إدخال البيانات في جدول الفواتير
    $stmt = $conn->prepare("INSERT INTO invoice (pat_id, name_ser, cost_ser, invoice_date, fname) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $pat_id, $name_ser, $cost_ser, $pat_date_now, $fname);

    if (!$stmt->execute()) {
        die("Database error: " . $stmt->error);
    }

    // إغلاق الاتصال بقاعدة البيانات
    $stmt->close();
    $conn->close();

    // إنشاء فئة PDF
    class PDF extends TCPDF {
        // ترويسة الصفحة
        public function Header() {
            if (file_exists('includes/images/one.png')) {
                $this->Image('includes/images/one.png', 10, 10, 30);
            }
            $this->SetFont('helvetica', 'B', 16);
            $this->Cell(0, 15, 'Invoice - Thank You for Your Visit!', 0, 1, 'C');
        }

        // تذييل الصفحة
        public function Footer() {
            $this->SetY(-15);
            $this->SetFont('helvetica', 'I', 10);
            $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, 0, 'C');
            $this->SetY(-10);
            $this->SetFont('helvetica', '', 9);
            $this->Cell(0, 10, 'Thank you for choosing our services. We look forward to serving you again!', 0, 0, 'C');
        }
    }

    // إنشاء PDF
    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->AddPage();

    // إضافة صورة إذا كانت موجودة
    if (file_exists('includes/images/2.png')) {
        $pdf->Image('includes/images/2.png', 10, 60, 189);
    }

    // إعداد الخطوط
    $pdf->SetFont('dejavusans', '', 14);

    // إضافة تفاصيل الفاتورة بتنسيق أكثر تفاعلية
    $pdf->Ln(27);
    $pdf->SetFont('helvetica', 'B', 14);
    $pdf->Cell(0, 10, 'Invoice Details', 0, 1, 'C');
    $pdf->Ln(5);

    $pdf->SetFont('dejavusans', '', 12);
    $pdf->SetFillColor(230, 230, 230);
    
    $pdf->Cell(50, 10, 'Date:', 1, 0, 'L', true);
    $pdf->Cell(130, 10, $pat_date_now, 1, 1, 'L');
    $pdf->Ln(5);

    $pdf->Cell(50, 10, 'Patient ID:', 1, 0, 'L', true);
    $pdf->Cell(130, 10, $pat_id, 1, 1, 'L');
    $pdf->Ln(5);

    $pdf->Cell(50, 10, 'Name:', 1, 0, 'L', true);
    $pdf->Cell(130, 10, $fname, 1, 1, 'L');
    $pdf->Ln(5);

    $pdf->Cell(50, 10, 'Service Name:', 1, 0, 'L', true);
    $pdf->Cell(130, 10, $name_ser, 1, 1, 'L');
    $pdf->Ln(5);

    $pdf->Cell(50, 10, 'Service Cost:', 1, 0, 'L', true);
    $pdf->Cell(130, 10, number_format((float)$cost_ser, 2) . ' YER', 1, 1, 'L');
    $pdf->Ln(10);

    // إضافة رسالة شكر وتوقيع
    $pdf->SetFont('aealarabiya', 'I', 12);
    $pdf->MultiCell(0, 10, "نقدر ثقتكم بنا ونتطلع لرؤيتكم مرة أخرى قريبًا! إذا كان لديكم أي استفسارات، لا تترددوا في التواصل معنا.", 0, 'C');
    $pdf->Ln(15);
    
    $pdf->SetFont('helvetica', '', 12);
    $pdf->Cell(0, 10, 'Signature:', 0, 1, 'L');
    $pdf->Ln(15);
    $pdf->Cell(50, 10, '_____________________', 0, 1, 'L');
    
    // إخراج ملف PDF
    $pdf->Output('invoice.pdf', 'I');
} else {
    die('Patient data is missing.');
}
?>
