<?php 

require_once('tcpdf.php');



//concect db 
$servername = "127.0.0.1";
$username = "root";
$password = "";

$conn = mysqli_connect($servername, $username, $password);
mysqli_select_db($conn,"najmdb");



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



//get data from db 

$query=mysqli_query($conn,"select * from session
where id_session='".$_GET['ses_id']."'   ");

$pat_array=mysqli_fetch_array($query);


$pdf= new PDF('p','mm','A4',true,'UTF-8',false);
$pdf-> AddPage();
$pdf->Image('2.png',10,60,189);

$pdf->SetFont('aealarabiya','',16);

//$pdf->Image('pic2.jpg',10,2,40);
$pdf->Ln(18);

$pdf->Cell(28,8,'NM_CLINIC',1,0,'C',0);

$pdf->Cell(100,8,'',0,0,'C',0);

$pdf->Cell(14,8,'date:',1,0,'C',0);

$pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(14,8,'data :',1,0,'C',0);
$pdf->Cell(35,8,$pat_array['date_now'],'B',0,'C',0);

/////////////////////

$ff=$pdf->GetStringWidth($$pat_array_ses['main_com']);
if($ff>500){
  $pdf->MultiCell(20,24,'main_com:',1,0,'C',0);
  $pdf->MultiCell(140,24,$pat_array_ses['main_com'],'B',1,'C',0);
}else{
  $pdf->MultiCell(20,8,'main_com:',1,0,'C',0);
  $pdf->MultiCell(140,8,$pat_array_ses['main_com'],'B',1,'C',0);
}

//////////////////////////

/////////////////////

$ff=$pdf->GetStringWidth($$pat_array_ses['period_ill']);
if($ff>500){
  $pdf->MultiCell(20,24,'data period_ill:',1,0,'C',0);
  $pdf->MultiCell(140,24,$pat_array_ses['period_ill'],'B',1,'C',0);
}else{
  $pdf->MultiCell(20,8,'data period_ill:',1,0,'C',0);
  $pdf->MultiCell(140,8,$pat_array_ses['period_ill'],'B',1,'C',0);
}

//////////////////////////
/////////////////////

$ff=$pdf->GetStringWidth($$pat_array_ses['sex_hist']);
if($ff>500){
  $pdf->MultiCell(20,24,'data sex_hist:',1,0,'C',0);
  $pdf->MultiCell(140,24,$pat_array_ses['sex_hist'],'B',1,'C',0);
}else{
  $pdf->MultiCell(20,8,'data sex_hist:',1,0,'C',0);
  $pdf->MultiCell(140,8,$pat_array_ses['sex_hist'],'B',1,'C',0);
}

//////////////////////////
/////////////////////

$ff=$pdf->GetStringWidth($$pat_array_ses['person_hist']);
if($ff>500){
  $pdf->MultiCell(20,24,'data person_hist:',1,0,'C',0);
  $pdf->MultiCell(140,24,$pat_array_ses['person_hist'],'B',1,'C',0);
}else{
  $pdf->MultiCell(20,8,'data person_hist:',1,0,'C',0);
  $pdf->MultiCell(140,8,$pat_array_ses['person_hist'],'B',1,'C',0);
}

//////////////////////////
/////////////////////

$ff=$pdf->GetStringWidth($$pat_array_ses['curr_hist']);
if($ff>500){
  $pdf->MultiCell(20,24,'data curr_hist:',1,0,'C',0);
  $pdf->MultiCell(140,24,$pat_array_ses['curr_hist'],'B',1,'C',0);
}else{
  $pdf->MultiCell(20,8,'data curr_hist:',1,0,'C',0);
  $pdf->MultiCell(140,8,$pat_array_ses['curr_hist'],'B',1,'C',0);
}

//////////////////////////
/////////////////////

$ff=$pdf->GetStringWidth($$pat_array_ses['last_hist']);
if($ff>500){
  $pdf->MultiCell(20,24,'data last_hist:',1,0,'C',0);
  $pdf->MultiCell(140,24,$pat_array_ses['last_hist'],'B',1,'C',0);
}else{
  $pdf->MultiCell(20,8,'data last_hist:',1,0,'C',0);
  $pdf->MultiCell(140,8,$pat_array_ses['last_hist'],'B',1,'C',0);
}

//////////////////////////

$pdf->Output();


?>