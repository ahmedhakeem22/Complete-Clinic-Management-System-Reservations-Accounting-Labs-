<?php
require_once('TCPDF-master/tcpdf.php');



$pdf =new TCPDF('p','mm','A4','UTF-8');
$pdf-> AddPage();

include 'includes/db.php';

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "najmdb";

$mysqli = new mysqli($servername, $username, $password ,$dbname);


 date_default_timezone_set("Asia/Aden");
$date=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }



if ($mysqli->connect_errno)
    die("Connection failed: " .$mysqli->connect_error);
$s = "INSERT INTO sale_invoice (pat_id,fname,medicines_name,unit,sale_price,sale_date) VALUES ";
for ($i = 0; $i < $_POST['numbers'] ; $i++) { 
    $s .="('".$_POST['pat_id']."','".$_POST['fname']."','".$_POST['medicines_name'][$i]."','".$_POST['unit'][$i]."','".$_POST['sale_price'][$i]."','".$date."'),";
}

  
$s = rtrim($s,",");
if (!$mysqli->query($s))
echo $mysqli->error;
 

$total=0;
$pdf->SetFont('freeserif','',14);
$pdf->Cell(60,8,'فاتوره بيع',1,0,'C',0);
$pdf->Cell(40,8,'تاريخ ',1,0,'C',0);
$pdf->Cell(40,8,$date,1,1,'C',0);
$pdf->Cell(20,8,'',0,1,'C',0);
   
$pdf->SetFont('freeserif','',10);


$pdf->Cell(40,8,'رقم المريض ',1,0,'C',0);
$pdf->Cell(80,8,'اسم المريض ',1,1,'C',0);


$pdf->Cell(40,8,$_POST['pat_id'],1,0,'C',0);
$pdf->Cell(80,8,$_POST['fname'],1,1,'C',0);


$pdf->Cell(20,8,'م',1,0,'C',0);
$pdf->Cell(40,8,'اسم الدواء',1,0,'C',0);
$pdf->Cell(20,8,'الكمية',1,0,'C',0);
$pdf->Cell(40,8,'سعر البيع',1,1,'C',0);


for ($i = 0; $i < $_POST['numbers'] ; $i++) {
    $num=$i+1; 

    $pdf->SetFont('freeserif','',10);
    $pdf->Cell(20,8,$num,1,0,'C',0);
    $pdf->Cell(40,8,$_POST['medicines_name'][$i],1,0,'C',0);
    $pdf->Cell(20,8,$_POST['unit'][$i],1,0,'C',0);
    $pdf->Cell(40,8,$_POST['sale_price'][$i],1,1,'C',0);
 
 

    
$total=$total+$_POST['sale_price'][$i];
    
}
$pdf->SetFont('freeserif','',16);
$pdf->Cell(60,8,' اجمالي البيع',1,0,'C',0);
$pdf->Cell(30,8,$total,1,1,'C',0);

    $mysqli->close();
$pdf->Output();
?>