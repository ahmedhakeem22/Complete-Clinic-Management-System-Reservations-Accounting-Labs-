<?php 
require_once __DIR__ . '/../vendor/autoload.php';



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

$s = "INSERT INTO buy_invpice (date_buy,delegate,name_med,countity,expired_date,sale_price,buy_price) VALUES ";
for ($i = 0; $i < $_POST['numbers'] ; $i++) { 
    $s .="('".$date."','".$_POST['delegate']."','".$_POST['name_med'][$i]."','".$_POST['countity'][$i]."','".$_POST['expired_date'][$i]."','".$_POST['sale_price'][$i]."','".$_POST['buy_price'][$i]."'),";
}

 
$s = rtrim($s,",");
if (!$mysqli->query($s))
echo $mysqli->error;




$sum=0;
$total=0;
$pdf->SetFont('freeserif','',14);
$pdf->Cell(60,8,'فاتوره شراء',1,0,'C',0);
$pdf->Cell(40,8,'تاريخ ',1,0,'C',0);
$pdf->Cell(40,8,$date,1,1,'C',0);
$pdf->Cell(20,8,'',0,1,'C',0);
$pdf->Cell(60,8,'المــندوب',1,0,'C',0);
$pdf->Cell(60,8,$_POST['delegate'],1,1,'C',0);
$pdf->SetFont('freeserif','',10);

$pdf->Cell(20,8,'م',1,0,'C',0);
$pdf->Cell(40,8,'اسم الدواء',1,0,'C',0);
$pdf->Cell(20,8,'الكمية',1,0,'C',0);
$pdf->Cell(40,8,'سعر الشراء',1,0,'C',0);
$pdf->Cell(30,8,'الصلاحية',1,0,'C',0);
$pdf->Cell(30,8,'الاجمالي',1,1,'C',0);

for ($i = 0; $i < $_POST['numbers'] ; $i++) {
    $num=$i+1; 

    $pdf->SetFont('freeserif','',10);
    $pdf->Cell(20,8,$num,1,0,'C',0);
    $pdf->Cell(40,8,$_POST['name_med'][$i],1,0,'C',0);
    $pdf->Cell(20,8,$_POST['countity'][$i],1,0,'C',0);
    $pdf->Cell(40,8,$_POST['buy_price'][$i],1,0,'C',0);
 
    $pdf->Cell(30,8,$_POST['expired_date'][$i],1,0,'C',0);
$sum=$_POST['countity'][$i]*$_POST['buy_price'][$i];
    $pdf->Cell(30,8,$sum,1,1,'C',0);
$total=$total+$sum;
    
}
$pdf->SetFont('freeserif','',16);
$pdf->Cell(60,8,' اجمالي الشراء',1,0,'C',0);
$pdf->Cell(30,8,$total,1,1,'C',0);

    $mysqli->close();
$pdf->Output();
?>