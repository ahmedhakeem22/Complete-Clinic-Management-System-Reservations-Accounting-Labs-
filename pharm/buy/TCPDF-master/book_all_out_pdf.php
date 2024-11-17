<?php 

require_once('tcpdf.php');

//concect db 
$servername = "127.0.0.1";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password);



    mysqli_select_db($conn,"najmdb");

    
  
      /////////////select from pay bill //////////////
     


        $query=mysqli_query($conn,"select * from Pay_bill");
  
        
       
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

    
$pdf= new PDF('p','mm','A4',true,'UTF-8',false);
$pdf-> AddPage();
$pdf->Image('2.png',10,60,189);

$pdf->SetFont('aealarabiya','',16);

/*


$pdf =new FPDF('p','mm','A4','UTF-8');
$pdf-> AddPage();
$pdf->SetFont('arial','B',12);
*/

//$pdf->Image('pic2.jpg',10,2,40);


$pdf->Ln(18);


$pdf->Cell(28,8,'NM_CLINIC',1,0,'C',0);

$pdf->Cell(100,8,'',0,0,'C',0);

$pdf->Cell(14,8,'date:',1,0,'C',0);

$pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
$pdf->Ln();
$colclat=0.0;
$pdf->Cell(30,8,'Pay_bill id:',1,0,'C',0);

$pdf->Cell(40,8,'name service:',1,0,'C',0);
$pdf->Cell(40,8,'coste amount:',1,0,'C',0);
$pdf->Cell(50,8,'date done service :',1,1,'C',0);
while( $pat_array=mysqli_fetch_array($query)){


    $pdf->Cell(30,8,$pat_array['bill_id'],'B',0,'C',0);


$pdf->Cell(30,8,$pat_array['recip_name'],'B',0,'C',0);


$pdf->Cell(40,8,$pat_array['amount'],'B',0,'C',0);

$colclat=$colclat+$pat_array['amount'];

$pdf->Cell(40,8,$pat_array['bill_date'],'B',1,'C',0);

///////////////culclat total //////////




}
$pdf->Ln();
$pdf->Cell(50,8,'total Amount is :',1,0,'C',0);
$pdf->Cell(50,8,$colclat,1,1,'C',0);
$pdf->Output();


?>