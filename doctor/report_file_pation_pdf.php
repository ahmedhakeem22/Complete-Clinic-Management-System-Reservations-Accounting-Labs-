<?php 

require_once('../TCPDF-master/tcpdf.php');


include '../includes/db.php';



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
            $this->cell(100,10,'',0,1);
            }
            function Footer(){
              $this->SetY(-15);
              $this->setfont('times','B',15);
              $this->cell(0,10,'page'.$this->pageNo(),0,0,'C');
              }
            
            }
  

  $id=$_GET['pat_id'];



$query=mysqli_query($conn,"select * from patinte
where pat_id='".$_GET['pat_id']."'   ");

$pat_array=mysqli_fetch_array($query);


$pdf= new PDF('p','mm','A4',true,'UTF-8',false);

$pdf->AddPage();

$pdf->Image('img_back_pdf.png',10,10,-300);

$pdf->SetFont('aealarabiya','',14);



$pdf->Ln(24);

$pdf->Cell(100,8,'',0,0,'C',0);

$pdf->Cell(30,8,'Date :',0,0,'C',0);

$pdf->Cell(28,8,$pat_date_now,0,1,'C',0);
$pdf->Ln();



$pdf->Cell(28,8,'ID :',0,0,'C',0);
$pdf->Cell(20,8,$pat_array['pat_id'],0,0,'C',0);

$pdf->Cell(20,8,'Name:',0,0,'C',0);
$pdf->Cell(80,8,$pat_array['fname'],0,0,'C',0);


$pdf->Cell(14,8,'Age:',0,0,'C',0);
$pdf->Cell(10,8,$pat_array['age'],0,1,'C',0);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(30,8,'Phone :',0,0,'C',0);
$pdf->Cell(35,8,$pat_array['phone'],0,0,'C',0);


$pdf->Cell(22,8,'Gander:',0,0,'C',0);
$pdf->Cell(22,8,$pat_array['gander'],0,0,'C',0);



$pdf->Cell(24,8,'Country :',0,0,'C',0);
$pdf->Cell(35,8,$pat_array['contry'],0,1,'C',0);
$pdf->Ln();
$pdf->Ln();


$pdf->Cell(20,8,'city:',0,0,'C',0);
$pdf->Cell(35,8,$pat_array['city'],0,0,'C',0);

$pdf->Cell(45,8,'Section ststes :',0,0,'C',0);
$pdf->Cell(35,8,$pat_array['soc_sts'],0,0,'C',0);

$pdf->Cell(30,8,'Children No. :',0,0,'C',0);
$pdf->Cell(6,8,$pat_array['chel_num'],0,1,'C',0);
$pdf->Ln();
$pdf->Ln();

$pdf->Cell(20,8,'Jop :',0,0,'C',0);
$pdf->Cell(35,8,$pat_array['jop'],0,0,'C',0);


$pdf->Cell(24,8,'Rigation :',0,0,'C',0);
$pdf->Cell(35,8,$pat_array['rig_pat'],0,0,'C',0);

$pdf->Cell(20,8,'Date :',0,0,'C',0);
$pdf->SetFont('aealarabiya','',10);
$pdf->Cell(30,8,$pat_array['date_com'],0,1,'C',0);
$pdf->Ln();
$pdf->Ln();









$query=mysqli_query($conn,"select * from session
where pat_id='".$_GET['pat_id']."'");

$pdf->SetFont('aealarabiya','',12);

while($pat_array_ses=mysqli_fetch_array($query)){
  $pdf->AddPage();

$pdf->Image('includes/images/img_back_pdf.png',10,10,-300);
$pdf->Ln(24);
$pdf->Ln(24);

  $pdf->Cell(30,8,'ID :',0,0,'C',0);
  $pdf->Cell(30,8,'Session ID:',0,0,'C',0);
  $pdf->Cell(30,8,'Data Session:',0,1,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['pat_id'],'B',0,'C',0);
  
  $pdf->Cell(30,8,$pat_array_ses['id_session'],'B',0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['date_now'],'B',0,'C',0);
  
  $pdf->Cell(100,8,'',0,1,'C',0);
 
  $pdf->Cell(60,8,'Data Next Session:',0,0,'C',0);
 
  $pdf->Cell(30,8,$pat_array_ses['date_next'],'B',1,'C',0);
  $pdf->Cell(100,8,'',0,1,'C',0);
  
  
  $pdf->Cell(50,10,'The main complaint:',0,0);
  $pdf->Ln();
  $pdf->MultiCell(189,24,$pat_array_ses['main_com'],'B','R');
  $pdf->Cell(100,8,'',0,1,'C',0);
  
  
  $pdf->Cell(30,10,'The period of illness:',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['period_ill'],'B','R');
  $pdf->Cell(100,8,'',0,1,'C',0);
  
  $pdf->Cell(30,10,'Sexual history:',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['sex_hist'],'B','R');
  $pdf->Cell(100,8,'',0,1,'C',0);
  
  $pdf->Cell(30,10,'Personal history:',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['person_hist'],'B','R');
  $pdf->Cell(100,8,'',0,1,'C',0);
  
  $pdf->Cell(30,10,'History of the current disease :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['curr_hist'],'B','R');
  $pdf->Cell(100,8,'',0,1,'C',0);
  
$pdf->AddPage();
$pdf->Image('includes/images/img_back_pdf.png',10,10,-300);
  $pdf->Ln(24);
$pdf->Ln(24);

  $pdf->Cell(30,10,'History of the last illness :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['last_hist'],'B','R');
  $pdf->Cell(100,8,'',0,1,'C',0);
  
  $pdf->Cell(30,10,'History of family illness :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['fam_hist'],'B','R');
  $pdf->Cell(100,8,'',0,1,'C',0);

  $pdf->Cell(30,10,'Date of work :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['work_hist'],'B','R');
    $pdf->Cell(100,8,'',0,1,'C',0);

  $pdf->Cell(30,10,'Basic diagnosis :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['basic_dig'],'B','R');
    $pdf->Cell(100,8,'',0,1,'C',0);



  $pdf->Cell(30,10,'Differential diagnosis :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['diff_dig'],'B','R');
    $pdf->Cell(100,8,'',0,1,'C',0);

    $pdf->AddPage();
$pdf->Image('includes/images/img_back_pdf.png',10,10,-300);
$pdf->Ln(24);
$pdf->Ln(24);

  $pdf->Cell(30,10,'The appearance :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['appear'],'B','R');
  $pdf->Cell(100,8,'',0,1,'C',0);

  $pdf->Cell(30,10,'The behavior :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['behav'],'B','R');
    $pdf->Cell(100,8,'',0,1,'C',0);



  $pdf->Cell(30,10,'Mood :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['mood'],'B','R');
    $pdf->Cell(100,8,'',0,1,'C',0);

  $pdf->Cell(30,10,'Thoughts of suicide or killing :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['killer'],'B','R');
    $pdf->Cell(100,8,'',0,1,'C',0);

  $pdf->Cell(30,10,'Thinking shape :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['thin_shep'],'B','R');
    $pdf->Cell(100,8,'',0,1,'C',0);
    $pdf->AddPage();
    $pdf->Image('includes/images/img_back_pdf.png',10,10,-300);
  $pdf->Ln(24);
$pdf->Ln(24);

  $pdf->Cell(30,10,'Thinking content :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['thin_con'],'B','R');
    $pdf->Cell(100,8,'',0,1,'C',0);

  
  $pdf->Cell(30,10,'Perception :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['percep'],'B','R');
  $pdf->Cell(100,8,'',0,1,'C',0);
  
  $pdf->Cell(30,10,'Memory :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['memory'],'B','R');
  $pdf->Cell(100,8,'',0,1,'C',0);
  
  $pdf->Cell(30,10,'The ability to judge :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['ability'],'B','R');
  $pdf->Cell(100,8,'',0,1,'C',0);

   $pdf->Cell(30,10,'The insight :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['insight'],'B','R');
  $pdf->Cell(100,8,'',0,1,'C',0);

  
  $pdf->Cell(30,10,'Foresight :',0,1);
  $pdf->MultiCell(189,24,$pat_array_ses['fores'],'B','R');
  $pdf->Cell(100,8,'',0,1,'C',0);
  
  $pdf->Cell(70,10,'Folstein,s degree :',0,0);
  $pdf->Cell(40,10,$pat_array_ses['degree'],0,1);
  $pdf->Cell(100,8,'',0,1,'C',0);
  
    
  $pdf->Cell(70,10,' Speech :',0,0);
  $pdf->Cell(40,10,$pat_array_ses['speech'],0,1);
  $pdf->Cell(100,8,'',0,1,'C',0);
  
  $pdf->Ln();





$pdf->Ln();
}









$query=mysqli_query($conn,"select * from test_psychological
where pat_id='".$_GET['pat_id']."'");

$pdf->SetFont('aealarabiya','',12);
$I=0;
while($pat_array_ses=mysqli_fetch_array($query)){
if ($I==4 || $I==0) {
  $pdf->AddPage();
  $pdf->Image('includes/images/img_back_pdf.png',10,10,-300);
  $I=0;
}
$I++;
$pdf->Ln(24);
$pdf->Ln(24);

  $pdf->Cell(60,8,'اختبــــأر نفسي ',0,0,'C',0);
$pdf->Cell(50,8,'رقم الاختبار',0,0,'C',0);
$pdf->Cell(40,8,$pat_array_ses['id_Psychological'],0,1,'C',0);


$pdf->Cell(50,8,' اسم الاختبار  ',0,0,'C',0);
$pdf->Cell(120,8,$pat_array_ses['name_test'],0,1,'C',0);

$pdf->Cell(50,8,'نتيجه الاختبار ',0,0,'C',0);
$pdf->Cell(30,8,$pat_array_ses['result'],0,1,'C',0);

$pdf->Cell(30,8,'ملاحظه',0,1,'C',0);

$pdf->Cell(189,8,$pat_array_ses['notes'],0,1,'C',0);
$pdf->Cell(100,8,'',0,1,'C',0);


$pdf->Ln();
}










$query=mysqli_query($conn,"select * from blood_test
where pat_id='".$_GET['pat_id']."'");

$pdf->SetFont('aealarabiya','',12);

while($pat_array_ses=mysqli_fetch_array($query)){

  $pdf->AddPage();
  $pdf->Image('includes/images/img_back_pdf.png',10,10,-300);
  $pdf->SetFont('aealarabiya','',16);
  $pdf->Ln(24);
$pdf->Ln(24);

  $pdf->Cell(60,8,'اختبــــأر الدم ',0,0,'C',0);
  $pdf->Cell(60,8,'رقم الاختبــــأر  ',0,0,'C',0);
  $pdf->Cell(60,8,$pat_array_ses['id_test'],0,1,'C',0);
  $pdf->SetFont('aealarabiya','',7);
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
  $pdf->Cell(30,8,$pat_array_ses['lymphocyte'],0,1,'C',0);
  
  
  
  
  
  $pdf->Cell(30,8,'Monocyte:',1,0,'C',0);
  $pdf->Cell(30,8,'(2-10)%',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['monocyte'],0,0,'C',0);
  
  $pdf->Cell(30,8,'Eosinophil:',1,0,'C',0);
  $pdf->Cell(30,8,'(1-6)%',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['esoinophil'],0,1,'C',0);
  
   $pdf->Cell(30,8,'Platelats:',1,0,'C',0);
  $pdf->Cell(30,8,'(1-6)%',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['platelats'],0,1,'C',0);
  
  
  $pdf->Cell(30,8,'ESR:',1,0,'C',0);
  $pdf->Cell(30,8,'M=UP TO 11//F=UP TO 19',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['esr'],0,1,'C',0);

 $pdf->Cell(30,8,'Malari:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['malaria'],0,0,'C',0);
  
   $pdf->Cell(30,8,'CT:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ct'],0,0,'C',0);
  
    
  $pdf->Cell(30,8,'PT Patient :',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['pt'],0,0,'C',0);
  
    
  $pdf->Cell(30,8,'PT Control :',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ptc'],0,0,'C',0);
  
    
  $pdf->Cell(30,8,'INR:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['inr'],0,0,'C',0);
  

    
  $pdf->Cell(30,8,'BT:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['bt'],0,0,'C',0);
  
  
  $pdf->Cell(30,8,'Reticulocyte:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['reticulocyte'],0,0,'C',0);
  
    $pdf->Cell(30,8,'Sickling:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['sickling'],0,0,'C',0);
  
     $pdf->Cell(30,8,'PTT Patinte:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ptt'],0,0,'C',0);

  $pdf->Cell(30,8,'PTT Control :',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['pttc'],0,0,'C',0);
   
       $pdf->Cell(30,8,'D_Dimer:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['d_dimer'],0,0,'C',0);
  
      $pdf->Cell(30,8,'F.B.S :',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['fbs'],0,0,'C',0);
  

  $pdf->Cell(30,8,'RBS:',1,0,'C',0);
  $pdf->Cell(30,8,'50-120 MG/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['rbs'],0,0,'C',0);
  
    $pdf->Cell(30,8,'P_PBS:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['p_pbs'],0,0,'C',0);
  
      $pdf->Cell(30,8,'HBA:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['hba'],0,0,'C',0);
  

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
  $pdf->Cell(30,8,$pat_array_ses['dirict_bilirubin'],0,0,'C',0);
  

    $pdf->Cell(30,8,'ALK-Phospats:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['alk_phospats'],0,0,'C',0);
  
   $pdf->Cell(30,8,'Albumin:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['albumin'],0,0,'C',0);
  
    $pdf->Cell(30,8,'Ca++:',1,0,'C',0);
  $pdf->Cell(30,8,'2.1-2.6 MMOL/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ca'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'K+:',1,0,'C',0);
  $pdf->Cell(30,8,'3.3-5.5 MMOL/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['k'],0,0,'C',0);
  
  $pdf->Cell(30,8,'Na+:',1,0,'C',0);
  $pdf->Cell(30,8,'130-490 MMOL/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['na'],0,1,'C',0);
  
    $pdf->Cell(30,8,'cl- :',1,0,'C',0);
  $pdf->Cell(30,8,'130-490 MMOL/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['cl'],0,1,'C',0);
  
    $pdf->Cell(30,8,'mg+:',1,0,'C',0);
  $pdf->Cell(30,8,'130-490 MMOL/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['mg'],0,1,'C',0);
  
  $pdf->Cell(30,8,'CK:',1,0,'C',0);
  $pdf->Cell(30,8,'130-490 MMOL/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ck'],0,1,'C',0);
  
  $pdf->Cell(30,8,'CK-MB:',1,0,'C',0);
  $pdf->Cell(30,8,'130-490 MMOL/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ck_mb'],0,1,'C',0);
  
  $pdf->Cell(30,8,'LDH :',1,0,'C',0);
  $pdf->Cell(30,8,'130-490 MMOL/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ldh'],0,1,'C',0);
  
    $pdf->Cell(30,8,'Cholesterol :',1,0,'C',0);
  $pdf->Cell(30,8,'130-490 MMOL/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['cholesterol'],0,1,'C',0);
  

      $pdf->Cell(30,8,'Triglyceride :',1,0,'C',0);
  $pdf->Cell(30,8,'130-490 MMOL/DL',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['triglyceride'],0,1,'C',0);
  
    
  $pdf->Cell(30,8,'LDL:',1,0,'C',0);
  $pdf->Cell(30,8,'<135 MG/LD',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ldl'],0,0,'C',0);
  
    
  $pdf->Cell(30,8,'HDL:',1,0,'C',0);
  $pdf->Cell(30,8,'<135 MG/LD',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['hdl'],0,0,'C',0);
  
    
  $pdf->Cell(30,8,'Uric Acid:',1,0,'C',0);
  $pdf->Cell(30,8,'<135 MG/LD',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['uricacid'],0,0,'C',0);
  
  $pdf->Cell(30,8,'T.Protine:',1,0,'C',0);
  $pdf->Cell(30,8,'<135 MG/LD',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['t_patinte'],0,0,'C',0);
  
  

  $pdf->Cell(30,8,'A.S.O:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['aso'],0,1,'C',0);
  
  
  $pdf->Cell(30,8,'C.R.P :',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['crp'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'R.F:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['rf'],0,1,'C',0);
  
  
  $pdf->Cell(30,8,'W.T.Salmonella(O):',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['salmon_o'],0,0,'C',0);
  
  $pdf->Cell(30,8,'W.T.Salmonella(H):',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['salmon_h'],0,1,'C',0);
  
  
  $pdf->Cell(30,8,'W.T.Salmonella(A):',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['salmon_a'],0,0,'C',0);
  
  $pdf->Cell(30,8,'W.T.Salmonella(B):',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['salmon_b'],0,1,'C',0);
  
  
  $pdf->Cell(30,8,'Abrotus:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['brucella_a'],0,0,'C',0);
  
  
  $pdf->Cell(30,8,'Maletenses:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['brucella_m'],0,0,'C',0);
  
  $pdf->Cell(30,8,'Blood Group:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['blood_group'],0,0,'C',0);
  
  $pdf->Cell(30,8,'TB:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['tb'],0,0,'C',0);
  


  $pdf->Cell(30,8,'HIV:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['hiv'],0,1,'C',0);
  
  
  $pdf->Cell(30,8,'HCV:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['hcv'],0,1,'C',0);
  
  $pdf->Cell(30,8,'HBS-Ag:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['hbs_ag'],0,0,'C',0);
  



$pdf->Cell(30,8,'Vdral:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['vdrl'],0,0,'C',0);
  

  
  $pdf->Cell(30,8,'H.pylori.Ab:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['h_pylori_rb'],0,0,'C',0);
  
  
  $pdf->Cell(30,8,'H.pylori.Ag:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['h_pylori_ag'],0,0,'C',0);



  $pdf->Cell(30,8,'Ethanol:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ethanol'],0,1,'C',0);
  
  
  
  $pdf->Cell(30,8,'Dlhjpam:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['dlhjpam'],0,0,'C',0);
  
  $pdf->Cell(30,8,'Marijuana:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['marijuana'],0,1,'C',0);
  

  $pdf->Cell(30,8,'Tramedol:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['tramedol'],0,1,'C',0);
  
   $pdf->Cell(30,8,'Heroin:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['heroin'],0,1,'C',0);
   $pdf->Cell(30,8,'Pethidine:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['pethidine'],0,1,'C',0);
   $pdf->Cell(30,8,'Cocaine:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['cocaine'],0,1,'C',0);
   $pdf->Cell(30,8,'Amphetamine:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['amphetamine'],0,1,'C',0);
   $pdf->Cell(30,8,'T3:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['t3'],0,1,'C',0);
   $pdf->Cell(30,8,'T4:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['t4'],0,1,'C',0);
   $pdf->Cell(30,8,'TSH:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['tsh'],0,1,'C',0);
   $pdf->Cell(30,8,'Prolactin:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['prolactin'],0,1,'C',0);
   $pdf->Cell(30,8,'PSA:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['psa'],0,1,'C',0);
   $pdf->Cell(30,8,'PS3:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ps3'],0,1,'C',0);
  $pdf->Cell(30,8,'Vit-B13:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['vitb'],0,1,'C',0);
  $pdf->Cell(30,8,'Vit-D3:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['vitd'],0,1,'C',0);
  $pdf->Cell(30,8,'CA 153:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ca153'],0,1,'C',0);
  $pdf->Cell(30,8,'CA 125:',1,0,'C',0);
  $pdf->Cell(30,8,'',0,0,'C',0);
  $pdf->Cell(30,8,$pat_array_ses['ca125'],0,1,'C',0);
}




$pdf->Output();


?>