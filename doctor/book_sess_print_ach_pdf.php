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
    


$pat_id=$_GET['pat_id'];
$name_ser="book session";
$cost_ser=3000;
$stmt = $conn->prepare("INSERT INTO invoice ( pat_id ,name_ser,cost_ser,invoice_date)
        VALUES (?,?,?,? )");
        
        $stmt->bind_param("ssss",$pat_id,$name_ser,$cost_ser,$pat_date_now) ;
        $stmt->execute();

  
        class PDF extends tcpdf{
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
  
  

////////////////////////////////////////////




$pdf =new PDF('p','mm','A4','UTF-8');
$pdf-> AddPage();
$pdf->Image('includes/images/2.png',10,60,189);
$pdf->SetFont('times','B',12);
$pdf->Image('includes/images/img_back_pdf.png',10,10,-300);

//$pdf->Image('pic2.jpg',10,2,40);


$pdf->Ln(27);




$pdf->Cell(100,8,'',0,0,'C',0);

$pdf->Cell(14,8,'date:',1,0,'C',0);

$pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
$pdf->Ln();


$pdf->Cell(30,8,'patione id:',1,0,'C',0);
$pdf->Cell(40,8,'name service:',1,0,'C',0);
$pdf->Cell(40,8,'coste service:',1,0,'C',0);




    $pdf->Cell(30,8,$_GET['pat_id'],'B',0,'C',0);


$pdf->Cell(30,8,$name_ser,'B',0,'C',0);


$pdf->Cell(40,8,$cost_ser,'B',0,'C',0);






$pdf->Output();


?>