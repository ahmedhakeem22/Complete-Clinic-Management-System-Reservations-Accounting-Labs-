<?php 
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', '0');

// بدء تخزين المخرجات قبل الإرسال للمتصفح
ob_start();
require_once __DIR__ . '/../vendor/autoload.php';
include '../includes/db.php';

      /////////////select from pay bill //////////////
     


        $query=mysqli_query($conn,"select * from provider");
  
        
       
      ////////////////////////////////////////////////
  
  
  
  
        
/////////////////////date now //////////////////////
date_default_timezone_set("Asia/Aden");
$pat_date_now=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
    
////////////////////////////////////////////
class PDF extends TCPDF{
  function Header(){
  $this->setfont('times','B',15);
  
  $this->cell(25);
  $this->Image('includes/images/one.png',10,10,30);
  $this->cell(100,10,'',0,1);
  }
  function Footer(){
    $this->SetY(-15);
    $this->setfont('times','B',15);
    $this->cell(0,10,'page'.$this->pageNo(),0,0,'C');
    }
  
  }

    
$pdf= new PDF('p','mm','A4',true,'UTF-8',false);
$pdf-> AddPage();
$pdf->Image('includes/images/2.png',10,60,189);

$pdf->SetFont('aealarabiya','',16);
$pdf->Image('includes/images/img_back_pdf.png',10,10,-300);
/*


$pdf =new FPDF('p','mm','A4','UTF-8');
$pdf-> AddPage();
$pdf->SetFont('arial','B',12);
*/

//$pdf->Image('pic2.jpg',10,2,40);


$pdf->Ln(27);




$pdf->Cell(100,8,'',0,0,'C',0);

$pdf->Cell(14,8,'date:',1,0,'C',0);

$pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
$pdf->Ln();
$colclat=0.0;
$pdf->Cell(40,8,'رقم السند',1,0,'C',0);

$pdf->Cell(60,8,'اسم العميل',1,0,'C',0);
$pdf->Cell(40,8,'المبلغ المدفوع',1,0,'C',0);
$pdf->Cell(40,8,'تاريخ الدفع',1,1,'C',0);
while( $pat_array=mysqli_fetch_array($query)){


    $pdf->Cell(40,8,$pat_array['id'],'B',0,'C',0);


$pdf->Cell(60,8,$pat_array['name_pro'],'B',0,'C',0);


$pdf->Cell(40,8,$pat_array['cost_ser'],'B',0,'C',0);

$colclat=$colclat+$pat_array['cost_ser'];


$pdf->Cell(50,8,'ملاحظه',1,1,'C',0);
$pdf->MultiCell(189,24,$pat_array['note'],'B','R');

///////////////culclat total //////////




}
$pdf->Ln();
$pdf->Cell(50,8,'total Amount is :',1,0,'C',0);
$pdf->Cell(50,8,$colclat,1,1,'C',0);
$pdf->Output();


?>