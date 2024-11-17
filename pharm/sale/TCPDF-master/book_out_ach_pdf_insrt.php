<?php 


require_once('tcpdf.php');

//concect db 
$servername = "127.0.0.1";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password);



    mysqli_select_db($conn,"najmdb");

    
        
/////////////////////date now //////////////////////
date_default_timezone_set("Asia/Aden");
$pat_date_now=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  class PDF extends FPDF{
    function Header(){
    $this->setfont('Arial','B',15);
    
    $this->cell(25);
    $this->Image('one.png',10,10,30);
    $this->cell(100,10,'',0,1);
    }
    function Footer(){
      $this->SetY(-15);
      $this->setfont('Arial','B',15);
      $this->cell(0,10,'page'.$this->pageNo(),0,0,'C');
      }
    
    }
  
    
$pdf= new TCPDF('p','mm','A4',true,'UTF-8',false);
$pdf-> AddPage();
$pdf->Image('2.png',10,60,189);

$pdf->SetFont('aealarabiya','',16);


$recip_name=$_GET['recip_name'];
$amount=$_GET['amount'];

$stmt = $conn->prepare("INSERT INTO Pay_bill (  recip_name,amount,bill_date)
        VALUES (?,?,? )");
        
        $stmt->bind_param("sss",$recip_name,$amount,$pat_date_now) ;
        $stmt->execute();

  
  
  
  

////////////////////////////////////////////



//$pdf->Image('pic2.jpg',10,2,40);


$pdf->Ln(18);


$pdf->Cell(28,8,'NM_CLINIC',1,0,'C',0);

$pdf->Cell(100,8,'',0,0,'C',0);

$pdf->Cell(14,8,'date:',1,0,'C',0);

$pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
$pdf->Ln();



$pdf->Cell(40,8,'recip name:',1,0,'C',0);
$pdf->Cell(40,8,'coste :',1,0,'C',0);
$pdf->Cell(50,8,'date now  :',1,1,'C',0);



    $pdf->Cell(30,8,$_GET['recip_name'],'B',0,'C',0);


$pdf->Cell(30,8,$_GET['amount'],'B',0,'C',0);






$pdf->Cell(40,8,$pat_date_now,'B',0,'C',0);




$pdf->Output();

/*

<?php 

require 'fpdf.php';

//concect db 
$servername = "127.0.0.1";
$username = "root";
$password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password);



    mysqli_select_db($conn,"najmdb");

    
        
/////////////////////date now //////////////////////
date_default_timezone_set("Asia/Aden");
$pat_date_now=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
    

$recip_name=$_GET['recip_name'];
$amount=$_GET['amount'];

$stmt = $conn->prepare("INSERT INTO Pay_bill (  recip_name,amount,bill_date)
        VALUES (?,?,? )");
        
        $stmt->bind_param("sss",$recip_name,$amount,$pat_date_now) ;
        $stmt->execute();

  
  
  
  

////////////////////////////////////////////




$pdf =new FPDF('p','mm','A4','UTF-8');
$pdf-> AddPage();
$pdf->SetFont('arial','B',12);


//$pdf->Image('pic2.jpg',10,2,40);


$pdf->Ln(18);


$pdf->Cell(28,8,'najm_web',1,0,'C',0);

$pdf->Cell(100,8,'',0,0,'C',0);

$pdf->Cell(14,8,'date:',1,0,'C',0);

$pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
$pdf->Ln();



$pdf->Cell(40,8,'recip name:',1,0,'C',0);
$pdf->Cell(40,8,'coste :',1,0,'C',0);
$pdf->Cell(50,8,'date now  :',1,1,'C',0);



    $pdf->Cell(30,8,$_GET['recip_name'],'B',0,'C',0);


$pdf->Cell(30,8,$_GET['amount'],'B',0,'C',0);






$pdf->Cell(40,8,$pat_date_now,'B',0,'C',0);




$pdf->Output();


?>*/

?>