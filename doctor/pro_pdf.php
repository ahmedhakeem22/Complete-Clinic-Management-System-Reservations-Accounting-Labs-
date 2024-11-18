<?php 

require 'TCPDF-master/tcpdf.php';
include '../includes/db.php';

    
        
/////////////////////date now //////////////////////
date_default_timezone_set("Asia/Aden");
$pat_date_now=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
    


$name_pro=$_GET['name_pro'];
$cost_ser=$_GET['cost_ser'];
$note=$_GET['note'];


$stmt = $conn->prepare("INSERT INTO provider (name_pro,cost_ser,note,date_pro)
        VALUES (?,?,?,? )");
        
        $stmt->bind_param("ssss",$name_pro,$cost_ser,$note,$pat_date_now) ;
        $stmt->execute();

  
        class PDF extends tcpdf{
            function Header(){
            $this->setfont('times','B',15);
            
            $this->cell(25);
            $this->Image('one.png',10,10,30);
            $this->cell(100,10,'',0,1);
            }
            function Footer(){
              $this->SetY(-15);
              $this->setfont('times','B',15);
              $this->cell(0,10,'page'.$this->pageNo(),0,0,'C');
              }
            
            }
  
  

////////////////////////////////////////////




$pdf =new PDF('p','mm','A4','UTF-8');
$pdf-> AddPage();
$pdf->Image('2.png',10,60,189);
$pdf->SetFont('times','B',12);

$pdf->Image('img_back_pdf.png',10,10,-300);
//$pdf->Image('pic2.jpg',10,2,40);


$pdf->Ln(27);




$pdf->Cell(100,8,'',0,0,'C',0);

$pdf->Cell(14,8,'date:',1,0,'C',0);

$pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
$pdf->Ln();

$pdf->SetFont('aealarabiya','',12);

$pdf->Cell(60,8,'اسم العميل','B',0,'C',0);
$pdf->Cell(60,8,'المبلغ المدفوع','B',1,'C',0);






$pdf->Cell(60,8,$name_pro,'B',0,'C',0);


$pdf->Cell(60,8,$cost_ser,'B',1,'C',0);
$pdf->Cell(50,8,'ملاحظه',1,1,'C',0);
$pdf->MultiCell(189,24,$note,'B','R');




$pdf->Output();


?>