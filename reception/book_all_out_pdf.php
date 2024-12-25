<?php 

require_once __DIR__ . '/../vendor/autoload.php';

// الاتصال بقاعدة البيانات عبر ملف db.php
include '../includes/db.php';

// اختيار قاعدة البيانات
mysqli_select_db($conn, "najmdb");

$query = mysqli_query($conn, "SELECT * FROM Pay_bill");

date_default_timezone_set("Asia/Aden");
$pat_date_now = date("Y-m-d");

class PDF extends TCPDF {
    function Header() {
        $this->SetFont('times', 'B', 15);
        $this->Cell(25);
        $this->Image('includes/images/one.png', 10, 10, 30);
        $this->Cell(100, 10, '', 0, 1);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('times', 'B', 15);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// إنشاء الكائن
$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->Image('includes/images/2.png', 10, 60, 189);

$pdf->SetFont('aealarabiya', '', 16);
$pdf->Image('includes/images/img_back_pdf.png', 10, 10, -300);
$pdf->Ln(27);

// باقي الكود لإعداد البيانات
$pdf->Cell(100, 8, '', 0, 0, 'C', 0);
$pdf->Cell(14, 8, 'Date:', 1, 0, 'C', 0);
$pdf->Cell(28, 8, $pat_date_now, 1, 1, 'C', 0);
$pdf->Ln();

$colclat = 0.0; // إجمالي المبلغ
$pdf->Cell(30, 8, 'Pay Bill ID:', 1, 0, 'C', 0);
$pdf->Cell(40, 8, 'Name Service:', 1, 0, 'C', 0);
$pdf->Cell(40, 8, 'Cost Amount:', 1, 0, 'C', 0);
$pdf->Cell(40, 8, 'Bill Date:', 1, 1, 'C', 0);

while ($pat_array = mysqli_fetch_array($query)) {
    $pdf->Cell(30, 8, $pat_array['bill_id'], 'B', 0, 'C', 0);
    $pdf->Cell(40, 8, $pat_array['recip_name'], 'B', 0, 'C', 0);
    $pdf->Cell(40, 8, $pat_array['amount'], 'B', 0, 'C', 0);
    $pdf->Cell(40, 8, $pat_array['bill_date'], 'B', 1, 'C', 0);
    $colclat += $pat_array['amount'];
}

$pdf->Ln();
$pdf->Cell(50, 8, 'Total Amount is:', 1, 0, 'C', 0);
$pdf->Cell(50, 8, number_format($colclat, 2), 1, 1, 'C', 0);

$pdf->Output();

?>
