<?php 

require '../TCPDF-master/tcpdf.php';
include '../includes/db.php';

    
  
      /////////////select from sestion be patione id //////////////
     


        $query=mysqli_query($conn,"select * from invoice  where name_ser  like 'book session' ");
  
        
       
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




$pdf =new tcpdf('p','mm','A4','UTF-8');
$pdf-> AddPage();
$pdf->SetFont('times','B',12);

$pdf->Image('includes/images/img_back_pdf.png',10,10,-300);
//$pdf->Image('pic2.jpg',10,2,40);


$pdf->Ln(27);




$pdf->Cell(100,8,'',0,0,'C',0);

$pdf->Cell(14,8,'date:',1,0,'C',0);

$pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
$pdf->Ln();
$colclat=0.0;
$pdf->Cell(30,8,'invoice id:',1,0,'C',0);
$pdf->Cell(30,8,'patione id:',1,0,'C',0);
$pdf->Cell(40,8,'name service:',1,0,'C',0);
$pdf->Cell(40,8,'coste service:',1,0,'C',0);

while( $pat_array=mysqli_fetch_array($query)){


    $pdf->Cell(30,8,$pat_array['invoice_id'],'B',0,'C',0);


$pdf->Cell(30,8,$pat_array['pat_id'],'B',0,'C',0);


$pdf->Cell(40,8,$pat_array['name_ser'],'B',0,'C',0);



$pdf->Cell(40,8,$pat_array['cost_ser'],'B',0,'C',0);

///////////////culclat total //////////
$colclat=$colclat+$pat_array['cost_ser'];

$pdf->Cell(30,8,$pat_array['invoice_date'],'B',1,'C',0);


}
$pdf->Ln();
$pdf->Cell(50,8,'total money is :',1,0,'C',0);
$pdf->Cell(50,8,$colclat,1,1,'C',0);
$pdf->Output();


?>