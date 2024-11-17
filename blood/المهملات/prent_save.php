
<?php
require_once('../TCPDF-master/tcpdf.php');



$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "najmdb";

// Create connection
$conn = new mysqli($servername, $username, $password ,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
  
    date_default_timezone_set("Asia/Aden");
$pat_date=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


         $pat_idd=0;
  if(isset($_GET['Submit_pation'])){
$pat_idd=$_GET['pat_idd'];
     $r=mysqli_query($conn,"select fname,age,gander,phone from patinte where pat_idd=$pat_idd");
  }

    /////////////////insert_patient//////////////////
    if(isset($_GET['Submit'])){
        $pat_id= $_GET['pat_id'];
		$pat_hb= $_GET['hb'];
       $pat_wbc= $_GET['wbc'];
              $pat_neutrophil= $_GET['neutrophil'];
       $pat_lymphocyte= $_GET['lymphocyte'];
       $pat_monocyte= $_GET['monocyte'];
       $pat_esoinophil= $_GET['esoinophil'];

        $pat_platelats=$_GET['platelats'];
        $pat_esr=$_GET['esr'];
        $pat_malaria=$_GET['malaria'];
        $pat_ct=$_GET['ct'];
        $pat_pt=$_GET['pt'];
        $pat_inr=$_GET['inr'];
        $pat_bt=$_GET['bt'];
        $pat_reticulocyte=$_GET['reticulocyte'];
        $pat_sickling=$_GET['sickling'];
    $pat_ptt=$_GET['ptt'];
  $pat_d_dimer=$_GET['d_dimer'];
        $pat_fbs=$_GET['fbs'];
        $pat_rbs=$_GET['rbs'];
        $pat_p_pbs=$_GET['p_pbs'];
        $pat_hba=$_GET['hba'];
        $pat_urea=$_GET['urea'];
        $pat_creatinine=$_GET['creatinine'];
        $pat_s_got=$_GET['s_got'];
        $pat_s_gpt=$_GET['s_gpt'];
       $pat_total_bilirubin=$_GET['total_bilirubin'];
        $pat_dirict_bilirubin=$_GET['dirict_bilirubin'];
        $pat_alk_phospats=$_GET['alk_phospats'];
        $pat_albumin=$_GET['albumin'];
        $pat_ca=$_GET['ca'];
        $pat_k=$_GET['k'];
        $pat_na=$_GET['na'];
        $pat_cl=$_GET['cl'];
        $pat_mg=$_GET['mg'];
        $pat_ck=$_GET['ck'];
       $pat_ck_mb=$_GET['ck_mb'];
        $pat_ldh=$_GET['ldh'];
        $pat_cholesterol=$_GET['cholesterol'];
        $pat_triglyceride=$_GET['triglyceride'];
        $pat_ldl=$_GET['ldl'];
        $pat_hdl=$_GET['hdl'];
        $pat_uricacid=$_GET['uricacid'];
        $pat_t_patinte=$_GET['t_patinte'];
        $pat_aso=$_GET['aso'];
$pat_rf=$_GET['rf'];
        $pat_widal_test=$_GET['widal_test'];
        $pat_brucella=$_GET['brucella'];
        $pat_blood_group=$_GET['blood_group'];
        $pat_tb=$_GET['tb'];
        $pat_hiv=$_GET['hiv'];
        $pat_hcv=$_GET['hcv'];
        $pat_hbs_ag=$_GET['hbs_ag'];
        $pat_vdrl=$_GET['vdrl'];
        $pat_h_pylori_rb=$_GET['h_pylori_rb'];
        $pat_h_pylori_ag=$_GET['h_pylori_ag'];
        $pat_ethanol=$_GET['ethanol'];
        $pat_dlhjpam=$_GET['dlhjpam'];
        $pat_marijuana=$_GET['marijuana'];
        $pat_tramedol=$_GET['tramedol'];
        $pat_heroin=$_GET['heroin'];
        $pat_pethidine=$_GET['pethidine'];
        $pat_cocaine=$_GET['cocaine'];
        $pat_amphetamine=$_GET['amphetamine'];
        $pat_t3=$_GET['t3'];
        $pat_t4=$_GET['t4'];
        $pat_tsh=$_GET['tsh'];
        $pat_prolactin=$_GET['prolactin'];
        $pat_psa=$_GET['psa'];
        $pat_ps3=$_GET['ps3'];



    if (empty($_GET["pat_id"])) {
      $Pat_fname = "Patinte ID  is Required";
      echo $Pat_fname;
     }else {
    
     $insert_blood_test = " INSERT INTO blood_test (pat_id,hb,wbc,neutrophil,lymphocyte,monocyte,esoinophil,platelats,esr,malaria,ct,pt,inr,bt,reticulocyte,sickling,ptt,d_dimer,fbs,rbs,p_pbs,hba,urea,creatinine,s_got,s_gpt,total_bilirubin,dirict_bilirubin,alk_phospats,albumin,ca,k,na,cl,mg,ck,ck_mb,ldh,cholesterol,triglyceride,ldl,hdl,uricacid,t_patinte,aso,rf,widal_test,brucella,blood_group,tb,hiv,hcv,hbs_ag,vdrl,h_pylori_rb,h_pylori_ag,ethanol,dlhjpam,marijuana,tramedol,heroin,pethidine,cocaine,amphetamine,t3,t4,tsh,prolactin,psa,ps3,today_date)
      VALUES ('$pat_id','$pat_hb','$pat_wbc','$pat_neutrophil','$pat_lymphocyte','$pat_monocyte','$pat_esoinophil','$pat_platelats','$pat_esr','$pat_malaria','$pat_ct','$pat_pt','$pat_inr','$pat_bt','$pat_reticulocyte','$pat_sickling','$pat_ptt','$pat_d_dimer','$pat_fbs','$pat_rbs','$pat_p_pbs','$pat_hba','$pat_urea','$pat_creatinine','$pat_s_got','$pat_s_gpt','$pat_total_bilirubin','$pat_dirict_bilirubin','$pat_alk_phospats','$pat_albumin','$pat_ca','$pat_k','$pat_na','$pat_cl','$pat_mg','$pat_ck','$pat_ck_mb','$pat_ldh','$pat_cholesterol','$pat_triglyceride','$pat_ldl','$pat_hdl','$pat_uricacid','$pat_t_patinte','$pat_aso','$pat_rf','$pat_widal_test','$pat_brucella','$pat_blood_group','$pat_tb','$pat_hiv','$pat_hcv','$pat_hbs_ag','$pat_vdrl','$pat_h_pylori_rb','$pat_h_pylori_ag','$pat_ethanol','$pat_dlhjpam','$pat_marijuana','$pat_tramedol','$pat_heroin','$pat_pethidine','$pat_cocaine','$pat_amphetamine','$pat_t3','$pat_t4','$pat_tsh','$pat_prolactin','$pat_psa','$pat_ps3','$pat_date')";

$run_blood_test = mysqli_query($conn,$insert_blood_test);

/*  if($run_blood_test){

echo "<script>alert('blood_test has been inserted successfully')</script>";
///echo "<script>window.open('lab2.php','_self')</script>";
  }
  
else{
    echo "<script>alert(' ERROR ')</script>";
    echo "<script>window.open('lab2.php','_self')</script>";
  }
  */

     $s=mysqli_query($conn,"select fname,age,gander,phone from patinte where pat_id=$pat_id");


       
               
         
$pdf= new TCPDF('p','mm','A4',true,'UTF-8',false);
$pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();

while($row =mysqli_fetch_array($s)){
        $pdf->SetFillColor(50,200,200);
 $pdf->Cell(20,8,'Name :',1,0,'C','true');
 $pdf->Cell(45,8,$row['fname'],1,0,'C',0);

  $pdf->Cell(15,8,'Age :',1,0,'C','true');

 $pdf->Cell(20,8,$row['age'],1,0,'C',0);
  $pdf->Cell(20,8,'Gander:',1,0,'C','true');

 $pdf->Cell(10,8,$row['gander'],1,0,'C',0);
  $pdf->Cell(20,8,'Phone :',1,0,'C','true');

 $pdf->Cell(38,8,$row['phone'],1,0,'C',0);
  }


$pdf->Ln();
        $pdf->Ln(12);
$pdf->SetFillColor(214,214,194);

$pdf->Cell(62,8,'الاختبــــار ',1,0,'C','true');
$pdf->Cell(62,8,'نتيجـــة الفـــحص ',1,0,'C','true');
$pdf->Cell(62,8,'النتيجـــة الطبيعيـــه ',1,0,'C','true');

$pdf->Ln();

/*
$pdf->Cell(62,8,'الاختبار ',0,0,'C',0);
$pdf->Cell(62,8,'النتيجه الطبيعيه ',0,0,'C',0);
$pdf->Cell(62,8,'نتيجه الفحص ',0,1,'C',0);
*/



if(empty($pat_hb))
{

}
else
{
$pdf->Cell(62,8,'HB:',1,0,'C',0);
$pdf->Cell(62,8,$pat_hb,1,0,'C',0);
$pdf->Cell(62,8,'M=13-18//F=11.5-16.6',1,1,'C',0);
}

if(empty($pat_wbc))
{

}
else{
$pdf->Cell(62,8,'WBC :',1,0,'C',0);
$pdf->Cell(62,8,$pat_wbc,1,0,'C',0);
$pdf->Cell(62,8,'(4-10)',1,1,'C',0);


}

if(empty($pat_neutrophil))
{

}
else{
$pdf->Cell(62,8,'Neutrophil :',1,0,'C',0);
$pdf->Cell(62,8,$pat_neutrophil,1,0,'C',0);
$pdf->Cell(62,8,'(4-10)',1,1,'C',0);


}
if(empty($pat_lymphocyte))
{

}
else{
$pdf->Cell(62,8,'Lymphocyte :',1,0,'C',0);
$pdf->Cell(62,8,$pat_lymphocyte,1,0,'C',0);
$pdf->Cell(62,8,'(4-10)',1,1,'C',0);


}
if(empty($pat_monocyte))
{

}
else{
$pdf->Cell(62,8,'Monocyte :',1,0,'C',0);
$pdf->Cell(62,8,$pat_monocyte,1,0,'C',0);
$pdf->Cell(62,8,'(4-10)',1,1,'C',0);


}
if(empty($pat_esoinophil))
{

}
else{
$pdf->Cell(62,8,'Esoinophil :',1,0,'C',0);
$pdf->Cell(62,8,$pat_esoinophil,1,0,'C',0);
$pdf->Cell(62,8,'(4-10)',1,1,'C',0);


}


if(empty($pat_platelats))
{

}
else{
$pdf->Cell(62,8,'Platelats:',1,0,'C',0);
$pdf->Cell(62,8,'(40-70)%',1,0,'C',0);
$pdf->Cell(62,8,$pat_platelats,1,1,'C',0);


}
if(empty($pat_esr))
{

}
else{
$pdf->Cell(62,8,'ESR:',1,0,'C',0);
$pdf->Cell(62,8,$pat_esr,1,0,'C',0);
$pdf->Cell(62,8,'(20-40)%',1,1,'C',0);

}


if(empty($pat_malaria))
{

}
else{
$pdf->Cell(62,8,'Malaria:',1,0,'C',0);
$pdf->Cell(62,8,$pat_malaria,1,0,'C',0);
$pdf->Cell(62,8,'(2-10)%',1,1,'C',0);

}

if(empty($pat_ct))
{

}
else{
$pdf->Cell(62,8,'CT:',1,0,'C',0);
$pdf->Cell(62,8,$pat_ct,1,0,'C',0);
$pdf->Cell(62,8,'(1-6)%',1,1,'C',0);


}
if(empty($pat_pt))
{

}
else{
$pdf->Cell(62,8,'PT:',1,0,'C',0);
$pdf->Cell(62,8,$pat_pt,1,0,'C',0);
$pdf->Cell(62,8,'50-120 MG/DL',1,1,'C',0);

}

if(empty($pat_inr))
{

}
else{
$pdf->Cell(62,8,'INR :',1,0,'C',0);
$pdf->Cell(62,8,$pat_inr,1,0,'C',0);
$pdf->Cell(62,8,'10-50 NG/DL',1,1,'C',0);

}

if(empty($pat_bt))
{

}
else{
$pdf->Cell(62,8,'BT:',1,0,'C',0);
$pdf->Cell(62,8,$pat_bt,1,0,'C',0);
$pdf->Cell(62,8,'M=0.7-1.4//F=0.6-1.3MG/D',1,1,'C',0);

}

if(empty($pat_reticulocyte))
{

}
else{
$pdf->Cell(62,8,'Reticulocyte :',1,0,'C',0);
$pdf->Cell(62,8,$pat_reticulocyte,1,0,'C',0);
$pdf->Cell(62,8,'UP TO 37 U/L',1,1,'C',0);

}

if(empty($pat_sickling))
{

}
else{
$pdf->Cell(62,8,'Sickling Test :',1,0,'C',0);
$pdf->Cell(62,8,$pat_sickling,1,0,'C',0);
$pdf->Cell(62,8,'UP TO 40 U/L',1,1,'C',0);

}


if(empty($pat_ptt))
{

}
else{
$pdf->Cell(62,8,'PTT :',1,0,'C',0);
$pdf->Cell(62,8,$pat_ptt,1,0,'C',0);
$pdf->Cell(62,8,'UP TO 1.1 MG/DL',1,1,'C',0);

}

if(empty($pat_d_dimer))
{

}
else{
$pdf->Cell(62,8,'D_Dimer:',1,0,'C',0);
$pdf->Cell(62,8,$pat_d_dimer,1,0,'C',0);
$pdf->Cell(62,8,'UP TO 0.25 MG/DL',1,1,'C',0);

}
if(empty($pat_fbs))
{

}
else{
$pdf->Cell(62,8,'F.B.S :',1,0,'C',0);
$pdf->Cell(62,8,$pat_fbs,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_rbs))
{

}
else{
$pdf->Cell(62,8,'R.B.S :',1,0,'C',0);
$pdf->Cell(62,8,$pat_rbs,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_p_pbs))
{

}
else{
$pdf->Cell(62,8,'P.PBS :',1,0,'C',0);
$pdf->Cell(62,8,$pat_p_pbs,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_hba))
{

}
else{
$pdf->Cell(62,8,'HBA 1C :',1,0,'C',0);
$pdf->Cell(62,8,$pat_hba,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_urea))
{

}
else{
$pdf->Cell(62,8,'Urea :',1,0,'C',0);
$pdf->Cell(62,8,$pat_urea,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_creatinine))
{

}
else{
$pdf->Cell(62,8,'Creatinine :',1,0,'C',0);
$pdf->Cell(62,8,$pat_creatinine,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_s_got))
{

}
else{
$pdf->Cell(62,8,'S.Got :',1,0,'C',0);
$pdf->Cell(62,8,$pat_s_got,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_s_gpt))
{

}
else{
$pdf->Cell(62,8,'S.Gpt :',1,0,'C',0);
$pdf->Cell(62,8,$pat_s_gpt,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_total_bilirubin))
{

}
else{
$pdf->Cell(62,8,'Total Bilirubin :',1,0,'C',0);
$pdf->Cell(62,8,$pat_total_bilirubin,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);


}

if(empty($pat_direct_briliubin))
{

}
else{
$pdf->Cell(62,8,'Dirict Bilirubin :',1,0,'C',0);
$pdf->Cell(62,8,$pat_direct_briliubin,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_alk_phospats))
{

}
else{
$pdf->Cell(62,8,'ALK.Phospats :',1,0,'C',0);
$pdf->Cell(62,8,$pat_alk_phospats,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_albumin))
{

}
else{
$pdf->Cell(62,8,'Albumin :',1,0,'C',0);
$pdf->Cell(62,8,$pat_albumin,1,0,'C',0);
$pdf->Cell(62,8,'PT CONTROL',1,1,'C',0);

}
if(empty($pat_ca))
{

}
else{
$pdf->Cell(62,8,'Ca++ :',1,0,'C',0);
$pdf->Cell(62,8,$pat_ca,1,0,'C',0);
$pdf->Cell(62,8,'PTT CONTROL',1,1,'C',0);

}

if(empty($pat_k))
{

}
else{
$pdf->Cell(62,8,'K+ :',1,0,'C',0);
$pdf->Cell(62,8,$pat_k,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_na))
{

}
else{
$pdf->Cell(62,8,'Na+ :',1,0,'C',0);
$pdf->Cell(62,8,$pat_na,1,0,'C',0);
$pdf->Cell(62,8,'M=UP TO 11//F=UP TO 19',1,1,'C',0);

}

if(empty($pat_cl))
{

}
else{
$pdf->Cell(62,8,'Cl+ :',1,0,'C',0);
$pdf->Cell(62,8,$pat_cl,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_mg))
{

}
else{
$pdf->Cell(62,8,'Mg++:',1,0,'C',0);
$pdf->Cell(62,8,$pat_mg,1,0,'C',0);
$pdf->Cell(62,8,'<200 MG/DL',1,1,'C',0);

}

if(empty($pat_ck))
{

}
else{
$pdf->Cell(62,8,'C.K :',1,0,'C',0);
$pdf->Cell(62,8,$pat_ck,1,0,'C',0);
$pdf->Cell(62,8,'<200 MG/DL',1,1,'C',0);

}

if(empty($pat_ck_mb))
{

}
else{
$pdf->Cell(62,8,'CK-MB :',1,0,'C',0);
$pdf->Cell(62,8,$pat_ck_mb,1,0,'C',0);
$pdf->Cell(62,8,'<55 MG/DL',1,1,'C',0);

}

if(empty($pat_ldh))
{

}
else{
$pdf->Cell(62,8,'L.D.H :',1,0,'C',0);
$pdf->Cell(62,8,$pat_ldh,1,0,'C',0);
$pdf->Cell(62,8,'<135 MG/LD',1,1,'C',0);

}

if(empty($pat_cholesterol))
{

}
else{
$pdf->Cell(62,8,'Cholesterol :',1,0,'C',0);
$pdf->Cell(62,8,$pat_cholesterol,1,0,'C',0);
$pdf->Cell(62,8,'2.1-2.6 MMOL/DL',1,1,'C',0);


}

if(empty($pat_triglyceride))
{

}
else{
$pdf->Cell(62,8,'Triglyceride :',1,0,'C',0);
$pdf->Cell(62,8,$pat_triglyceride,1,0,'C',0);
$pdf->Cell(62,8,'3.3-5.5 MMOL/DL',1,1,'C',0);

}

if(empty($pat_ldl))
{

}
else{
$pdf->Cell(62,8,'LDL :',1,0,'C',0);
$pdf->Cell(62,8,$pat_ldl,1,0,'C',0);
$pdf->Cell(62,8,'162-490 MMOL/DL',1,1,'C',0);

}

if(empty($pat_hdl))
{

}
else{
$pdf->Cell(62,8,'HDL :',1,0,'C',0);
$pdf->Cell(62,8,$pat_hdl,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_uricacid))
{

}
else{
$pdf->Cell(62,8,'Uricacid :',1,0,'C',0);
$pdf->Cell(62,8,$pat_uricacid,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_t_patinte))
{

}
else{
$pdf->Cell(62,8,' T.Patinte :',1,0,'C',0);
$pdf->Cell(62,8,$pat_t_patinte,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_aso))
{

}
else{
$pdf->Cell(62,8,'ASO:',1,0,'C',0);
$pdf->Cell(62,8,$pat_aso,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_crp))
{

}
else{
$pdf->Cell(62,8,'C.R.P :',1,0,'C',0);
$pdf->Cell(62,8,$pat_crp,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_rf))
{

}
else{
$pdf->Cell(62,8,'RF :',1,0,'C',0);
$pdf->Cell(62,8,$pat_rf,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_widal_test))
{

}
else{
$pdf->Cell(62,8,' Widal Test  :',1,0,'C',0);
$pdf->Cell(62,8,$pat_widal_test,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_brucella))
{

}else{
$pdf->Cell(62,8,'Brucella A+M  :',1,0,'C',0);
$pdf->Cell(62,8,$pat_brucella,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}


if(empty($pat_blood_group))
{

}
else{
$pdf->Cell(62,8,'Blood Group :',1,0,'C',0);
$pdf->Cell(62,8,$pat_blood_group,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_tb))
{

}
else{
$pdf->Cell(62,8,'TB :',1,0,'C',0);
$pdf->Cell(62,8,$pat_tb,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_hiv))
{

}else{
$pdf->Cell(62,8,' HIV :',1,0,'C',0);
$pdf->Cell(62,8,$pat_hiv,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_hcv))
{

}

else{
$pdf->Cell(62,8,'HCV :',1,0,'C',0);
$pdf->Cell(62,8,$pat_hcv,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_hbs_ag))
{

}
else{
$pdf->Cell(62,8,'HBS.AG :',1,0,'C',0);
$pdf->Cell(62,8,$pat_hbs_ag,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_vdrl))
{

}

else{
$pdf->Cell(62,8,'VDRL :',1,0,'C',0);
$pdf->Cell(62,8,$pat_vdrl,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}

if(empty($pat_h_pylori_rb))
{

}

else{
$pdf->Cell(62,8,' H.PYLORI RB :',1,0,'C',0);
$pdf->Cell(62,8,$pat_h_pylori_rb,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);


}

if(empty($pat_h_pylori_ag))
{

}
else{
$pdf->Cell(62,8,'H.PYLORI AG  :',1,0,'C',0);
$pdf->Cell(62,8,$pat_h_pylori_ag,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}


if(empty($pat_ethanol))
{

}

else{
$pdf->Cell(62,8,'Ethanol :',1,0,'C',0);
$pdf->Cell(62,8,$pat_ethanol,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}
if(empty($pat_dlhjpam))
{

}

else{
$pdf->Cell(62,8,'Dlhjpam :',1,0,'C',0);
$pdf->Cell(62,8,$pat_dlhjpam,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}
if(empty($pat_marijuana))
{

}

else{
$pdf->Cell(62,8,'marijuana :',1,0,'C',0);
$pdf->Cell(62,8,$pat_marijuana,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}
if(empty($pat_tramedol))
{

}

else{
$pdf->Cell(62,8,'tramedol :',1,0,'C',0);
$pdf->Cell(62,8,$pat_tramedol,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}
if(empty($pat_heroin))
{

}

else{
$pdf->Cell(62,8,'heroin :',1,0,'C',0);
$pdf->Cell(62,8,$pat_heroin,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}
if(empty($pat_pethidine))
{

}

else{
$pdf->Cell(62,8,'pethidine :',1,0,'C',0);
$pdf->Cell(62,8,$pat_pethidine,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}
if(empty($pat_cocaine))
{

}

else{
$pdf->Cell(62,8,'cocaine :',1,0,'C',0);
$pdf->Cell(62,8,$pat_cocaine,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}
if(empty($pat_amphetamine))
{

}

else{
$pdf->Cell(62,8,'amphetamine :',1,0,'C',0);
$pdf->Cell(62,8,$pat_amphetamine,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}
if(empty($pat_t3))
{

}

else{
$pdf->Cell(62,8,'T3 :',1,0,'C',0);
$pdf->Cell(62,8,$pat_t3,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}
if(empty($pat_t4))
{

}

else{
$pdf->Cell(62,8,'T4 :',1,0,'C',0);
$pdf->Cell(62,8,$pat_t4,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}
if(empty($pat_tsh))
{

}

else{
$pdf->Cell(62,8,'TSH :',1,0,'C',0);
$pdf->Cell(62,8,$pat_tsh,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}
if(empty($pat_prolactin))
{

}

else{
$pdf->Cell(62,8,'Prolactin :',1,0,'C',0);
$pdf->Cell(62,8,$pat_prolactin,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}
if(empty($pat_psa))
{

}

else{
$pdf->Cell(62,8,'PSA :',1,0,'C',0);
$pdf->Cell(62,8,$pat_psa,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);

}
if(empty($pat_ps3))
{

}

else{
$pdf->Cell(62,8,'PS3 :',1,0,'C',0);
$pdf->Cell(62,8,$pat_ps3,1,0,'C',0);
$pdf->Cell(62,8,'',1,1,'C',0);
}
        $pdf->Ln();
                $pdf->Ln();



$pdf->Cell(50,8,'Lab :',0,0,'C',0);
$pdf->Cell(90,8,'',0,0,'C',0);
$pdf->Cell(50,8,' doctor :',0,1,'C',0);
//$pdf->Cell(40,8,'',0,1,'C',0);

 var_dump(array(
    "data" => "demo"
));

// Clean any content of the output buffer
ob_end_clean();

// Send the PDF !
$pdf->Output('lab3.pdf', 'I');





     }
            
        
  
  
     }
    
}
       

          
           

    
    $conn->close();

?>
