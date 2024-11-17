<?php 

require_once('TCPDF-master/tcpdf.php');




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

$pdf->SetFont('aealarabiya','',12);

while($pat_array_ses=mysqli_fetch_array($query)){


$pdf->Cell(30,8,'id number:',1,0,'C',0);
$pdf->Cell(30,8,'session id:',1,0,'C',0);
$pdf->Cell(30,8,'data now:',1,1,'C',0);
$pdf->Cell(30,8,$pat_array_ses['pat_id'],'B',0,'C',0);

$pdf->Cell(30,8,$pat_array_ses['id_session'],'B',0,'C',0);
$pdf->Cell(30,8,$pat_array_ses['date_now'],'B',1,'C',0);

$pdf->Cell(100,8,'',0,1,'C',0);
$pdf->Cell(30,8,'data pevor:',1,0,'C',0);
$pdf->Cell(30,8,'data next:',1,1,'C',0);
$pdf->Cell(30,8,$pat_array_ses['date_pev'],'B',0,'C',0);
$pdf->Cell(30,8,$pat_array_ses['date_next'],'B',1,'C',0);
$pdf->Cell(100,8,'',0,1,'C',0);


$pdf->Cell(30,10,'main_com:',1,0);
$pdf->MultiCell(140,24,$pat_array_ses['main_com'],'B','R');
$pdf->Cell(100,8,'',0,1,'C',0);

$pdf->Cell(30,10,'period_ill:',1,0);
$pdf->MultiCell(140,24,$pat_array_ses['period_ill'],'B','R');






$pdf->Ln();
}











$query=mysqli_query($conn,"select * from test_psychological
where pat_id='".$_GET['pat_id']."'");

$pdf->SetFont('aealarabiya','',12);

while($pat_array_ses=mysqli_fetch_array($query)){

  $pdf->Cell(60,8,'اختبــــأر نفسي ',0,0,'C',0);
$pdf->Cell(50,8,'رقم الاختبار',0,0,'C',0);
$pdf->Cell(40,8,$pat_array_ses['id_Psychological'],'B',1,'C',0);


$pdf->Cell(50,8,' اسم الاختبار  ',0,0,'C',0);
$pdf->Cell(120,8,$pat_array_ses['name_test'],'B',1,'C',0);

$pdf->Cell(50,8,'نتيجه الاختبار ',0,0,'C',0);
$pdf->Cell(30,8,$pat_array_ses['result'],0,1,'C',0);

$pdf->Cell(30,8,'ملاحظه',0,1,'C',0);

$pdf->Cell(189,8,$pat_array_ses['notes'],'B',1,'C',0);
$pdf->Cell(100,8,'',0,1,'C',0);


$pdf->Ln();
}










$query=mysqli_query($conn,"select * from blood_test
where pat_id='".$_GET['pat_id']."'");

$pdf->SetFont('aealarabiya','',12);

while($pat_array_ses=mysqli_fetch_array($query)){

  $pdf-> AddPage();
  $pdf->SetFont('aealarabiya','',16);
  $pdf->Cell(60,8,'اختبــــأر الدم ',0,0,'C',0);
  $pdf->Cell(60,8,'رقم اختبــــأر  ',0,0,'C',0);
  $pdf->Cell(60,8,$pat_array_ses['id_test'],0,1,'C',0);
  $pdf->SetFont('aealarabiya','',10);
  $pdf->Cell(30,8,'الاختبار ',0,0,'C',0);
  $pdf->Cell(30,8,'النتيجه الطبيعيه ',0,0,'C',0);
  $pdf->Cell(30,8,'نتيجه الفحص ',0,0,'C',0);
  $pdf->Cell(30,8,'الاختبار ',0,0,'C',0);
  $pdf->Cell(30,8,'النتيجه الطبيعيه ',0,0,'C',0);
  $pdf->Cell(30,8,'نتيجه الفحص ',0,1,'C',0);
  
  $pdf->Cell(30,8,'HB:',1,0,'C',0);
  $pdf->Cell(30,8,'M=13-18//F=11.5-16.6',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['hb'],0,0,'C',0);
  
  $pdf->Cell(30,8,'WBC:',1,0,'C',0);
  $pdf->Cell(30,8,'(4-10)',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['wbc'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'Neutrophil:',1,0,'C',0);
  $pdf->Cell(30,8,'(40-70)%',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['neutrophil'],0,0,'C',0);
  
  $pdf->Cell(30,8,'Lymphocyte:',1,0,'C',0);
  $pdf->Cell(30,8,'(20-40)%',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['lymphocyle'],0,1,'C',0);
  
  
  
  
  
  $pdf->Cell(30,8,'Monocyte:',1,0,'C',0);
  $pdf->Cell(30,8,'(2-10)%',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['monocyte'],0,0,'C',0);
  
  $pdf->Cell(30,8,'Eosinophil:',1,0,'C',0);
  $pdf->Cell(30,8,'(1-6)%',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['eosinophil'],0,1,'C',0);
  
  
  $pdf->Cell(30,8,'RBS:',1,0,'C',0);
  $pdf->Cell(30,8,'50-120 MG/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['rbs'],0,0,'C',0);
  
  $pdf->Cell(30,8,'Urea:',1,0,'C',0);
  $pdf->Cell(30,8,'10-50 NG/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['urea'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'Creatinine:',1,0,'C',0);
  $pdf->Cell(30,8,'M=0.7-1.4//F=0.6-1.3MG/D',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['creatinine'],0,0,'C',0);
  
  $pdf->Cell(30,8,'S.GOT:',1,0,'C',0);
  $pdf->Cell(30,8,'UP TO 37 U/L',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['s_got'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'S.GPT:',1,0,'C',0);
  $pdf->Cell(30,8,'UP TO 40 U/L',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['s_gpt'],0,0,'C',0);
  
  $pdf->Cell(30,8,'T.Brilirubin:',1,0,'C',0);
  $pdf->Cell(30,8,'UP TO 1.1 MG/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['total_bilirubin'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'D.Brilirubin:',1,0,'C',0);
  $pdf->Cell(30,8,'UP TO 0.25 MG/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['direct_briliubin'],0,0,'C',0);
  
  $pdf->Cell(30,8,'A.S.O:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['aso'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'C.R.P:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['crp'],0,0,'C',0);
  
  $pdf->Cell(30,8,'R.F:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['rf'],0,1,'C',0);
  
  
  $pdf->Cell(30,8,'W.T.Salmonella(O):',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['salrnonolls_o'],0,0,'C',0);
  
  $pdf->Cell(30,8,'W.T.Salmonella(H):',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['salrnonolls_h'],0,1,'C',0);
  
  
  $pdf->Cell(30,8,'W.T.Salmonella(A):',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['salrnonolls_a'],0,0,'C',0);
  
  $pdf->Cell(30,8,'W.T.Salmonella(B)e:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['salrnonolls_b'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'Marijuana:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['marijuana'],0,0,'C',0);
  
  $pdf->Cell(30,8,'Arnphetamin:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['amphetamin'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'Cocaine:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['cocaine'],0,0,'C',0);
  
  $pdf->Cell(30,8,'Heroin:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['heroin'],0,1,'C',0);
  
  
  $pdf->Cell(30,8,'PT Patient:',1,0,'C',0);
  $pdf->Cell(30,8,'PT CONTROL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['pt'],0,0,'C',0);
  
  $pdf->Cell(30,8,'PTT Patient:',1,0,'C',0);
  $pdf->Cell(30,8,'PTT CONTROL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ptt'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'INR:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['inr'],0,0,'C',0);
  
  $pdf->Cell(30,8,'ESR:',1,0,'C',0);
  $pdf->Cell(30,8,'M=UP TO 11//F=UP TO 19',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['esr'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'Malari:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['malari'],0,0,'C',0);
  
  $pdf->Cell(30,8,'Cholestrol:',1,0,'C',0);
  $pdf->Cell(30,8,'<200 MG/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['cholestrol'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'Triglyceride:',1,0,'C',0);
  $pdf->Cell(30,8,'<200 MG/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['triglyceride'],0,0,'C',0);
  
  $pdf->Cell(30,8,'HDL:',1,0,'C',0);
  $pdf->Cell(30,8,'<55 MG/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['hdl'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'LDL:',1,0,'C',0);
  $pdf->Cell(30,8,'<135 MG/LD',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ldl'],0,0,'C',0);
  
  $pdf->Cell(30,8,'Ca++:',1,0,'C',0);
  $pdf->Cell(30,8,'2.1-2.6 MMOL/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ca'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'K+:',1,0,'C',0);
  $pdf->Cell(30,8,'3.3-5.5 MMOL/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['k'],0,0,'C',0);
  
  $pdf->Cell(30,8,'Na+:',1,0,'C',0);
  $pdf->Cell(30,8,'130-490 MMOL/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['na'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'H.pylorl:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['h_pylorl'],0,0,'C',0);
  
  $pdf->Cell(30,8,'HIV:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['hiv'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'HBS-Ag:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['hbs_ag'],0,0,'C',0);
  
  $pdf->Cell(30,8,'HCV:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['hcv'],0,1,'C',0);
}




$pdf->Output();


?>