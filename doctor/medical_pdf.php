<?php 



require_once __DIR__ . '/../vendor/autoload.php';

$pdf =new TCPDF('p','mm','A4','UTF-8');
$pdf-> AddPage();
$pdf->SetFont('freeserif','',16);
$pdf->Image('includes/images/img_back_pdf.png',10,10,-300);

$pdf->Ln(27);




$pdf->Cell(189,8,' وصفه طبيه ','B',1,'C',0);

$pdf->MultiCell(189,120,$_GET['Medical'],0,'R');

$pdf->Output();


?>