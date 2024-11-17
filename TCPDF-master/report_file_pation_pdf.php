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



  $id=$_GET['pat_id'];


$query=mysqli_query($conn,"select * from patinte
where pat_id='".$_GET['pat_id']."'   ");

$pat_array=mysqli_fetch_array($query);


$pdf= new TCPDF('p','mm','A4',true,'UTF-8',false);
$pdf-> AddPage();

$pdf->SetFont('aealarabiya','',16);

//$pdf->Image('pic2.jpg',10,2,40);
$pdf->Ln(18);

$pdf->Cell(28,8,'najm_web',1,0,'C',0);

$pdf->Cell(100,8,'',0,0,'C',0);

$pdf->Cell(14,8,'date:',1,0,'C',0);

$pdf->Cell(28,8,$pat_date_now,1,1,'C',0);
$pdf->Ln();



$pdf->Cell(28,8,'id number:',1,0,'C',0);
$pdf->Cell(20,8,$pat_array['pat_id'],'B',0,'C',0);

$pdf->Cell(15,8,'name:',1,0,'C',0);
$pdf->Cell(100,8,$pat_array['fname'],'B',0,'C',0);


$pdf->Cell(14,8,'age:',1,0,'C',0);
$pdf->Cell(10,8,$pat_array['age'],'B',1,'C',0);
$pdf->Ln();

$pdf->Cell(45,8,'phone number:',1,0,'C',0);
$pdf->Cell(35,8,$pat_array['phone'],'B',0,'C',0);


$pdf->Cell(22,8,'gander:',1,0,'C',0);
$pdf->Cell(22,8,$pat_array['gander'],'B',0,'C',0);



$pdf->Cell(24,8,'contry :',1,0,'C',0);
$pdf->Cell(35,8,$pat_array['contry'],'B',1,'C',0);
$pdf->Ln();



$pdf->Cell(20,8,'city:',1,0,'C',0);
$pdf->Cell(35,8,$pat_array['city'],'B',0,'C',0);

$pdf->Cell(45,8,'section ststes :',1,0,'C',0);
$pdf->Cell(35,8,$pat_array['soc_sts'],'B',0,'C',0);

$pdf->Cell(45,8,'children number :',1,0,'C',0);
$pdf->Cell(6,8,$pat_array['chel_num'],'B',1,'C',0);

$pdf->Ln();

$pdf->Cell(20,8,'jop :',1,0,'C',0);
$pdf->Cell(35,8,$pat_array['jop'],'B',0,'C',0);


$pdf->Cell(24,8,'rigation :',1,0,'C',0);
$pdf->Cell(35,8,$pat_array['rig_pat'],'B',0,'C',0);

$pdf->Cell(35,8,'date coming : ',1,0,'C',0);

$pdf->Cell(50,8,$pat_array['date_com'],'B',1,'C',0);
$pdf->Ln();


$query=mysqli_query($conn,"select * from session
where pat_id='".$_GET['pat_id']."'");
$ff=0;
while($pat_array_ses=mysqli_fetch_array($query)){


$pdf->Cell(28,8,'id number:',1,0,'C',0);
$pdf->Cell(15,8,'session id:',1,0,'C',0);
$pdf->Cell(14,8,'data now:',1,0,'C',0);
$pdf->Cell(20,8,$pat_array_ses['pat_id'],'B',0,'C',0);

$pdf->Cell(20,8,$pat_array_ses['id_session'],'B',0,'C',0);
$pdf->Cell(20,8,$pat_array_ses['date_now'],'B',1,'C',0);

$pdf->Cell(100,8,'',0,0,'C',0);
$pdf->Cell(20,8,'data pevor:',1,0,'C',0);
$pdf->Cell(20,8,'data next:',1,0,'C',0);
$pdf->Cell(20,8,$pat_array_ses['date_pev'],'B',0,'C',0);
$pdf->Cell(20,8,$pat_array_ses['date_next'],'B',0,'C',0);
$pdf->Cell(100,8,'',0,0,'C',0);



$ff=$pdf->GetStringWidth($pat_array_ses['main_com']);
if($ff>500){
  $pdf->MultiCell(20,24,'main_com:',1,0,'C',0);
  $pdf->MultiCell(140,24,$pat_array_ses['main_com'],'B',1,'C',0);
}else{
  $pdf->MultiCell(20,8,'main_com:',1,0,'C',0);
  $pdf->MultiCell(140,8,$pat_array_ses['main_com'],'B',1,'C',0);
}



$ff=$pdf->GetStringWidth($pat_array_ses['period_ill']);
if($ff>500){
  $pdf->MultiCell(20,24,'data period_ill:',1,0,'C',0);
  $pdf->MultiCell(140,24,$pat_array_ses['period_ill'],'B',1,'C',0);
}else{
  $pdf->MultiCell(20,8,'data period_ill:',1,0,'C',0);
  $pdf->MultiCell(140,8,$pat_array_ses['period_ill'],'B',1,'C',0);
}



$ff=$pdf->GetStringWidth($pat_array_ses['sex_hist']);
if($ff>500){
  $pdf->MultiCell(20,24,'data sex_hist:',1,0,'C',0);
  $pdf->MultiCell(140,24,$pat_array_ses['sex_hist'],'B',1,'C',0);
}else{
  $pdf->MultiCell(20,8,'data sex_hist:',1,0,'C',0);
  $pdf->MultiCell(140,8,$pat_array_ses['sex_hist'],'B',1,'C',0);
}



$ff=$pdf->GetStringWidth($pat_array_ses['person_hist']);
if($ff>500){
  $pdf->MultiCell(20,24,'data person_hist:',1,0,'C',0);
  $pdf->MultiCell(140,24,$pat_array_ses['person_hist'],'B',1,'C',0);
}else{
  $pdf->MultiCell(20,8,'data person_hist:',1,0,'C',0);
  $pdf->MultiCell(140,8,$pat_array_ses['person_hist'],'B',1,'C',0);
}



$ff=$pdf->GetStringWidth($pat_array_ses['curr_hist']);
if($ff>500){
  $pdf->MultiCell(20,24,'data curr_hist:',1,0,'C',0);
  $pdf->MultiCell(140,24,$pat_array_ses['curr_hist'],'B',1,'C',0);
}else{
  $pdf->MultiCell(20,8,'data curr_hist:',1,0,'C',0);
  $pdf->MultiCell(140,8,$pat_array_ses['curr_hist'],'B',1,'C',0);
}


$ff=$pdf->GetStringWidth($pat_array_ses['last_hist']);
if($ff>500){
  $pdf->MultiCell(20,24,'data last_hist:',1,0,'C',0);
  $pdf->MultiCell(140,24,$pat_array_ses['last_hist'],'B',1,'C',0);
}else{
  $pdf->MultiCell(20,8,'data last_hist:',1,0,'C',0);
  $pdf->MultiCell(140,8,$pat_array_ses['last_hist'],'B',1,'C',0);
}


$pdf->Ln();
}
$pdf->Output();


?>