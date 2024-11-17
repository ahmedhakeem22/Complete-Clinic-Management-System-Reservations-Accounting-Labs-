<?php 

require 'TCPDF-master/tcpdf.php';

//concect db 
$servername = "127.0.0.1";
$username = "root";
$password = "";

// Create connection
$con = mysqli_connect($servername, $username, $password);



    mysqli_select_db($con,"najmdb");

    
        
/////////////////////date now //////////////////////
date_default_timezone_set("Asia/Aden");
$pat_date_now=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
    


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

          


$pdf =new PDF('p','mm','A4','UTF-8');

$pdf-> AddPage();
$pdf->Image('2.png',10,60,189);
$pdf->SetFont('times','B',12);

$pdf->SetFont('aealarabiya','',12);

//$pdf->Image('pic2.jpg',10,2,40);


$pdf->Ln(27);


$pdf->Cell(28,8,'NM_CLINIC',1,0,'C',0);

$pdf->Cell(100,8,'',0,0,'C',0);

$pdf->Cell(14,8,'date:',1,0,'C',0);

$pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
$pdf->Ln();

$pdf->Cell(30,8,'Patinte ID:',1,0,'C',0);
$pdf->Cell(30,8,'Patinte Name :',1,0,'C',0);
$pdf->Cell(30,8,'اسم العلاج :',1,0,'C',0);
$pdf->Cell(40,8,'Unit :',1,0,'C',0);
$pdf->Cell(40,8,' Sale Price :',1,0,'C',0);
        $pdf->Ln();

while( $pat_array=mysqli_fetch_array($r)){

    $pdf->Cell(30,8,$pat_array['pat_id'],'B',0,'C',0);
        $pdf->Cell(30,8,$pat_array['fname'],'B',0,'C',0);
                $pdf->Cell(30,8,$pat_array['medicines_name'],'B',0,'C',0);
    $pdf->Cell(30,8,$pat_array['unit'],'B',0,'C',0);
    $pdf->Cell(60,8,$pat_array['sale_price'],'B',0,'C',0);
    $pdf->Ln();

}
    $pdf->Ln();


$pdf->Output();

?>