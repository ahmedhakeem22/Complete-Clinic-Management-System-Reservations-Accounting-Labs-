
<?php

require_once('../TCPDF-master/tcpdf.php');


$servername = "127.0.0.1";
$username = "root";
$password = "root";
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
                $pat_ptc=$_GET['ptc'];
        $pat_inr=$_GET['inr'];
        $pat_bt=$_GET['bt'];
        $pat_reticulocyte=$_GET['reticulocyte'];
        $pat_sickling=$_GET['sickling'];
    $pat_ptt=$_GET['ptt'];
            $pat_pttc=$_GET['pttc'];
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
                $pat_crp=$_GET['crp'];
$pat_rf=$_GET['rf'];
        $pat_salmon_o=$_GET['salmon_o'];
                $pat_salmon_h=$_GET['salmon_h'];
        $pat_salmon_a=$_GET['salmon_a'];
        $pat_salmon_b=$_GET['salmon_b'];

        $pat_brucella_a=$_GET['brucella_a'];
                $pat_brucella_m=$_GET['brucella_m'];

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
        $pat_vitb=$_GET['vitb'];
        $pat_vitd=$_GET['vitd'];
        $pat_ca153=$_GET['ca153'];
        $pat_ca125=$_GET['ca125'];
        $pat_C = isset($_GET['dirict_bilirubin']) ? $_GET['dirict_bilirubin'] : null;




    if (empty($_GET["pat_id"])) {
      $Pat_fname = "Patinte ID  is Required";
      echo $Pat_fname;
     }else {
    
     $insert_blood_test = " INSERT INTO blood_test (pat_id,hb,wbc,neutrophil,lymphocyte,monocyte,esoinophil,platelats,esr,malaria,ct,pt,ptc,inr,bt,reticulocyte,sickling,ptt,pttc,d_dimer,fbs,rbs,p_pbs,hba,urea,creatinine,s_got,s_gpt,total_bilirubin,dirict_bilirubin,alk_phospats,albumin,ca,k,na,cl,mg,ck,ck_mb,ldh,cholesterol,triglyceride,ldl,hdl,uricacid,t_patinte,aso,crp,rf,salmon_o,salmon_h,salmon_a,salmon_b,brucella_a,brucella_m,blood_group,tb,hiv,hcv,hbs_ag,vdrl,h_pylori_rb,h_pylori_ag,ethanol,dlhjpam,marijuana,tramedol,heroin,pethidine,cocaine,amphetamine,t3,t4,tsh,prolactin,psa,ps3,vitb,vitd,ca153,ca125,today_date)
      VALUES ('$pat_id','$pat_hb','$pat_wbc','$pat_neutrophil','$pat_lymphocyte','$pat_monocyte','$pat_esoinophil','$pat_platelats','$pat_esr','$pat_malaria','$pat_ct','$pat_pt','$pat_ptc','$pat_inr','$pat_bt','$pat_reticulocyte','$pat_sickling','$pat_ptt','$pat_pttc','$pat_d_dimer','$pat_fbs','$pat_rbs','$pat_p_pbs','$pat_hba','$pat_urea','$pat_creatinine','$pat_s_got','$pat_s_gpt','$pat_total_bilirubin','$pat_C','$pat_alk_phospats','$pat_albumin','$pat_ca','$pat_k','$pat_na','$pat_cl','$pat_mg','$pat_ck','$pat_ck_mb','$pat_ldh','$pat_cholesterol','$pat_triglyceride','$pat_ldl','$pat_hdl','$pat_uricacid','$pat_t_patinte','$pat_aso','$pat_crp','$pat_rf','$pat_salmon_o','$pat_salmon_h','$pat_salmon_a','$pat_salmon_b','$pat_brucella_a','$pat_brucella_m','$pat_blood_group','$pat_tb','$pat_hiv','$pat_hcv','$pat_hbs_ag','$pat_vdrl','$pat_h_pylori_rb','$pat_h_pylori_ag','$pat_ethanol','$pat_dlhjpam','$pat_marijuana','$pat_tramedol','$pat_heroin','$pat_pethidine','$pat_cocaine','$pat_amphetamine','$pat_t3','$pat_t4','$pat_tsh','$pat_prolactin','$pat_psa','$pat_ps3','$pat_vitb','$pat_vitd','$pat_ca153','$pat_ca125','$pat_date')";

$run_blood_test = mysqli_query($conn,$insert_blood_test);


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


        while($row=mysqli_fetch_array($s)){
  $pdf->SetFillColor(169, 204, 227);
   $pdf->Cell(20,8,'Name :',1,0,'C','true');
   $pdf->Cell(45,8,$row['fname'],1,0,'C',0);
  $row_fname=$row['fname'];
    $pdf->Cell(15,8,'Age :',1,0,'C','true');
  
   $pdf->Cell(20,8,$row['age'],1,0,'C',0);
   $row_age=$row['age'];
    $pdf->Cell(20,8,'Gander:',1,0,'C','true');
  
   $pdf->Cell(10,8,$row['gander'],1,0,'C',0);
   $row_gander=$row['gander'];
    $pdf->Cell(20,8,'Phone :',1,0,'C','true');
  
   $pdf->Cell(35,8,$row['phone'],1,1,'C',0);
   $row_phone=$row['phone'];
    }


  $contant=0;

  if(!empty($pat_hb) || !empty($pat_wbc) || !empty($pat_neutrophil) || !empty($pat_lymphocyte) || !empty($pat_monocyte) || !empty($pat_esoinophil) ||  !empty($pat_platelats) || !empty($pat_esr) || !empty($pat_malaria) || !empty($pat_ct) || !empty($pat_pt) || !empty($pat_ptc) || !empty($pat_inr) || !empty($pat_bt) ||  !empty($pat_reticulocyte) || !empty($pat_sickling) || !empty($pat_ptt) || !empty($pat_pttc) ||  !empty($pat_d_dimer)  )
  {
   
  
  


$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();

/*
$pdf->Cell(62,8,'اختبار ',0,0,'C',0);
$pdf->Cell(62,8,'نتيجه طبيعيه ',0,0,'C',0);
$pdf->Cell(62,8,'نتيجه فحص ',0,1,'C',0);
*/




if(empty($pat_hb))
{

}
else
{

$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);

$pdf->Cell(62,8,'          HB',0,0,'L',0);
$pdf->Cell(62,8,$pat_hb,0,0,'C',0);
$pdf->MultiCell(62,8,'      M : 14 - 18  g/dl '."\n".'      F : 11.5 - 16.5  g/dl',0,'',1);
}

if(empty($pat_wbc))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
$pdf->Ln(2);

  $pdf->Cell(62,8,'          WBC',0,0,'L',0);
$pdf->Cell(62,8,$pat_wbc,0,0,'C',0);
$pdf->Cell(62,8,'      4 - 10  X10*9/L',0,1,'L',0);



}

if(empty($pat_neutrophil))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
$pdf->Ln(2);
$pdf->Cell(62,8,'          Neutrophil',0,0,'L',0);
$pdf->Cell(62,8,$pat_neutrophil,0,0,'C',0);
$pdf->Cell(62,8,'      40 - 70 %',0,1,'L',0);



}
if(empty($pat_lymphocyte))
{

}
else{
  $contant=$contant+1;
  if($contant==16){
 
    $contant=0;
    $pdf-> AddPage();
  
  
  
  
  $pdf->SetFont('aealarabiya','',14);
          $pdf->Image('img.png',10,10,-300);
  
          $pdf->Ln(42);
  
     
  $pdf->Cell(140,8,'',0,0,'C',0);
          
          $pdf->Cell(14,8,'Date :',0,0,'C',0);
          
          $pdf->Cell(28,8,$pat_date,0,1,'C',0);
          $pdf->Ln();
  
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);
  
  
    $pdf->Ln();
         
    $pdf->SetFillColor(214, 234, 248);
    $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
    $contant=$contant+1;
    $pdf->Cell(62,8,' Test ',1,0,'C','true');
    $pdf->Cell(62,8,' Result ',1,0,'C','true');
    $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
    $contant=$contant+1;
    $pdf->Ln();
  }
  $pdf->Ln(2);
  $pdf->Cell(62,8,'          Lymphocyte',0,0,'L',0);
$pdf->Cell(62,8,$pat_lymphocyte,0,0,'C',0);
$pdf->Cell(62,8,'      20 - 40 %',0,1,'L',0);

  }


if(empty($pat_monocyte))
{

}
else{
  $contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
  
}
$pdf->Ln(2);
$pdf->Cell(62,8,'          Monocyte',0,0,'L',0);
$pdf->Cell(62,8,$pat_monocyte,0,0,'C',0);
$pdf->Cell(62,8,'      2 - 10 %',0,1,'L',0);


}
if(empty($pat_esoinophil))
{

}
else{
  $contant=$contant+1;
  if($contant==16){
 
    $contant=0;
    $pdf-> AddPage();
  
  
  
  
  $pdf->SetFont('aealarabiya','',14);
          $pdf->Image('img.png',10,10,-300);
  
          $pdf->Ln(42);
  
     
  $pdf->Cell(140,8,'',0,0,'C',0);
          
          $pdf->Cell(14,8,'Date :',0,0,'C',0);
          
          $pdf->Cell(28,8,$pat_date,0,1,'C',0);
          $pdf->Ln();
  
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);
  
  
    $pdf->Ln();
         
    $pdf->SetFillColor(214, 234, 248);
    $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
    $contant=$contant+1;
    $pdf->Cell(62,8,' Test ',1,0,'C','true');
    $pdf->Cell(62,8,' Result ',1,0,'C','true');
    $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
    $contant=$contant+1;
    $pdf->Ln();
    
  
  }
$pdf->Ln(2);
$pdf->Cell(62,8,'          Esoinophil',0,0,'L',0);
$pdf->Cell(62,8,$pat_esoinophil,0,0,'C',0);
$pdf->Cell(62,8,'      1 - 6 %',0,1,'L',0);

  }



if(empty($pat_platelats))
{

}
else{

  $contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(100,100,100);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
  
}
$pdf->Ln(2);
$pdf->Cell(62,8,'          Platelats',0,0,'L',0);
$pdf->Cell(62,8,$pat_platelats,0,0,'C',0);
$pdf->Cell(62,8,'      150 - 450  X10*9 /L',0,1,'L',0);
}

if(empty($pat_esr))
{

}
else{
  $contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(100,50,80);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
  
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          ESR',0,0,'L',0);
$pdf->Cell(62,8,$pat_esr,0,0,'C',0);
$pdf->MultiCell(62,8,'      M : up to 11 mm/hr '."\n".'      F : up to 19 mm/hr ',0,'',1);

}



if(empty($pat_malaria))
{

}
else{

  $contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
  
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          Malaria',0,0,'L',0);
$pdf->Cell(62,8,$pat_malaria,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);


}

if(empty($pat_ct))
{

}
else{
  $contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
  

}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          CT',0,0,'L',0);
$pdf->Cell(62,8,$pat_ct,0,0,'C',0);
$pdf->Cell(62,8,'      > 10 Min',0,1,'L',0);


}
if(empty($pat_pt))
{

}
else{
  $contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
  
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          PT Patinte',0,0,'L',0);
$pdf->Cell(62,8,$pat_pt,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}

if(empty($pat_ptc))
{

}
else{
  $contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
  
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          PT Control',0,0,'L',0);
$pdf->Cell(62,8,$pat_ptc,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}


if(empty($pat_inr))
{

}
else{
  $contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
  
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          INR',0,0,'L',0);
$pdf->Cell(62,8,$pat_inr,0,0,'C',0);
$pdf->Cell(62,8,'      0.9 - 1.2',0,1,'L',0);

}


if(empty($pat_bt))
{

}
else{
  $contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
  

}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          BT',0,0,'L',0);
$pdf->Cell(62,8,$pat_bt,0,0,'C',0);
$pdf->Cell(62,8,'      > 9 Min',0,1,'L',0);

}

if(empty($pat_reticulocyte))
{

}
else{
  $contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
  

}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          Reticulocyte',0,0,'L',0);
$pdf->Cell(62,8,$pat_reticulocyte,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}


if(empty($pat_sickling))
{

}
else{
  $contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
  

}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          Sickling Test',0,0,'L',0);
$pdf->Cell(62,8,$pat_sickling,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}



if(empty($pat_ptt))
{

}
else{
  $contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
  
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          PTT Patinte',0,0,'L',0);
$pdf->Cell(62,8,$pat_ptt,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}

if(empty($pat_pttc))
{

}
else{
  $contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
  
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          PTT Control',0,0,'L',0);
$pdf->Cell(62,8,$pat_pttc,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}

if(empty($pat_d_dimer))
{

}
else{
  $contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'HAEMATOLOGY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
  

}
$pdf->Cell(62,8,'          D_Dimer',0,0,'L',0);
$pdf->Cell(62,8,$pat_d_dimer,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);
}



 
}







if(!empty($pat_fbs) || !empty($pat_rbs) || !empty($pat_p_pbs) || !empty($pat_hba) || !empty($pat_urea) || !empty($pat_creatinine) ||  !empty($pat_s_got) || !empty($pat_s_gpt) || !empty($pat_total_bilirubin) || !empty($pat_direct_briliubin) || !empty($pat_alk_phospats) || !empty($pat_albumin) || !empty($pat_ca) ||  !empty($pat_k) || !empty($pat_na) || !empty($pat_cl) ||  !empty($pat_mg) || !empty($pat_ck) || !empty($pat_ck_mb) || !empty($pat_ldh) || !empty($pat_cholesterol) || !empty($pat_triglyceride) || !empty($pat_ldl) ||!empty($pat_hdl) || !empty($pat_uricacid) || !empty($pat_t_patinte) )
{
 
$pdf->Ln();
     
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();

if(empty($pat_fbs))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          F.B.S',0,0,'L',0);
$pdf->Cell(62,8,$pat_fbs,0,0,'C',0);
$pdf->Cell(62,8,'      70 - 120 mg/dl',0,1,'L',0);
}



if(empty($pat_rbs))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
  $pdf->Ln(2);

$pdf->Cell(62,8,'          R.B.S',0,0,'L',0);
$pdf->Cell(62,8,$pat_rbs,0,0,'C',0);
$pdf->Cell(62,8,'      80 - 120 mg/dl',0,1,'L',0);

}


if(empty($pat_p_pbs))
{

}
else{

  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
  $pdf->Ln(2);

$pdf->Cell(62,8,'          P.PBS',0,0,'L',0);
$pdf->Cell(62,8,$pat_p_pbs,0,0,'C',0);
$pdf->Cell(62,8,'      80 - 120 mg/dl',0,1,'L',0);

}



if(empty($pat_hba))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
  $pdf->Ln(2);

$pdf->Cell(62,8,'          HBA 1C',0,0,'L',0);
$pdf->Cell(62,8,$pat_hba,0,0,'C',0);
$pdf->MultiCell(62,8,'      Non dibitc 2 - 5 %'."\n".'      Diabetic aduttless 7%',0,'',1);

}



if(empty($pat_urea))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          Urea',0,0,'L',0);
$pdf->Cell(62,8,$pat_urea,0,0,'C',0);
$pdf->Cell(62,8,'      10 - 50 mg/dl',0,1,'L',0);

}


if(empty($pat_creatinine))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          Creatinine',0,0,'L',0);
$pdf->Cell(62,8,$pat_creatinine,0,0,'C',0);
$pdf->MultiCell(62,8,'      M : 0.7 - 1.4 mg/dl '."\n".'      F : 0.6 - 1.3  mg/dl',0,'',1);


}

if(empty($pat_s_got))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          S.Got',0,0,'L',0);
$pdf->Cell(62,8,$pat_s_got,0,0,'C',0);
$pdf->Cell(62,8,'      up to 37 U/l',0,1,'L',0);

}


if(empty($pat_s_gpt))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          S.Gpt',0,0,'L',0);
$pdf->Cell(62,8,$pat_s_gpt,0,0,'C',0);
$pdf->Cell(62,8,'      up to 40 U/l',0,1,'L',0);

}


if(empty($pat_total_bilirubin))
{

}
else{
  $contant=$contant+1;
  if($contant==16){
 
    $contant=0;
    $pdf-> AddPage();
  
  
  
  
  $pdf->SetFont('aealarabiya','',14);
          $pdf->Image('img.png',10,10,-300);
  
          $pdf->Ln(42);
  
     
  $pdf->Cell(140,8,'',0,0,'C',0);
          
          $pdf->Cell(14,8,'Date :',0,0,'C',0);
          
          $pdf->Cell(28,8,$pat_date,0,1,'C',0);
          $pdf->Ln();
  
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);
  
  
    $pdf->Ln();
         
    $pdf->SetFillColor(214, 234, 248);
    $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
    $contant=$contant+1;
    $pdf->Cell(62,8,' Test ',1,0,'C','true');
    $pdf->Cell(62,8,' Result ',1,0,'C','true');
    $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
    $contant=$contant+1;
    $pdf->Ln();
  }
    $pdf->Ln(2);
$pdf->Cell(62,8,'          Total Bilirubin',0,0,'L',0);
$pdf->Cell(62,8,$pat_total_bilirubin,0,0,'C',0);
$pdf->Cell(62,8,'      up to 1.1 mg/dl',0,1,'L',0);

  }


if(empty($pat_dirict_bilirubin))
{

}
else{
  $contant=$contant+1;
  if($contant==16){
 
    $contant=0;
    $pdf-> AddPage();
  
  
  
  
  $pdf->SetFont('aealarabiya','',14);
          $pdf->Image('img.png',10,10,-300);
  
          $pdf->Ln(42);
  
     
  $pdf->Cell(140,8,'',0,0,'C',0);
          
          $pdf->Cell(14,8,'Date :',0,0,'C',0);
          
          $pdf->Cell(28,8,$pat_date,0,1,'C',0);
          $pdf->Ln();
  
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);
  
  
    $pdf->Ln();
         
    $pdf->SetFillColor(214, 234, 248);
    $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
    $contant=$contant+1;
    $pdf->Cell(62,8,' Test ',1,0,'C','true');
    $pdf->Cell(62,8,' Result ',1,0,'C','true');
    $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
    $contant=$contant+1;
    $pdf->Ln();
  }
      $pdf->Ln(2);
$pdf->Cell(62,8,'          Dirict Bilirubin',0,0,'L',0);
$pdf->Cell(62,8,$pat_dirict_bilirubin,0,0,'C',0);
$pdf->Cell(62,8,'      up to 0.25 mg/dl',0,1,'L',0);

}


if(empty($pat_alk_phospats))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();

       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);
       



  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
    $pdf->Ln(2);
$pdf->Cell(62,8,'          ALK.Phospats',0,0,'L',0);
$pdf->Cell(62,8,$pat_alk_phospats,0,0,'C',0);
$pdf->MultiCell(62,8,'      M : 45 - 115  U/l '."\n".'      F : 30 - 100 U/l',0,'',1);
}

if(empty($pat_albumin))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
    $pdf->Ln(2);
$pdf->Cell(62,8,'          Albumin',0,0,'L',0);
$pdf->Cell(62,8,$pat_albumin,0,0,'C',0);
$pdf->Cell(62,8,'      35 - 50 g/l',0,1,'L',0);
}


if(empty($pat_ca))
{

}
else{
  $contant=$contant+1;
  if($contant==16){
 
    $contant=0;
    $pdf-> AddPage();
  
  
  
  
  $pdf->SetFont('aealarabiya','',14);
          $pdf->Image('img.png',10,10,-300);
  
          $pdf->Ln(42);
  
     
  $pdf->Cell(140,8,'',0,0,'C',0);
          
          $pdf->Cell(14,8,'Date :',0,0,'C',0);
          
          $pdf->Cell(28,8,$pat_date,0,1,'C',0);
          $pdf->Ln();
  
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);
  
  
    $pdf->Ln();
         
    $pdf->SetFillColor(214, 234, 248);
    $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
    $contant=$contant+1;
    $pdf->Cell(62,8,' Test ',1,0,'C','true');
    $pdf->Cell(62,8,' Result ',1,0,'C','true');
    $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
    $contant=$contant+1;
    $pdf->Ln();
  }
      $pdf->Ln(2);
$pdf->Cell(62,8,'          Ca++',0,0,'L',0);
$pdf->Cell(62,8,$pat_ca,0,0,'C',0);
$pdf->Cell(62,8,'      8.2 - 10.5 mg/dl',0,1,'L',0);

}


if(empty($pat_k))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
    $pdf->Ln(2);
$pdf->Cell(62,8,'          K+',0,0,'L',0);
$pdf->Cell(62,8,$pat_k,0,0,'C',0);
$pdf->Cell(62,8,'      3.3 - 5.5 mmol/L',0,1,'L',0);


}

if(empty($pat_na))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
    $pdf->Ln(2);
$pdf->Cell(62,8,'          Na+',0,0,'L',0);
$pdf->Cell(62,8,$pat_na,0,0,'C',0);
$pdf->Cell(62,8,'      130 - 490 mmol/L',0,1,'L',0);

}



if(empty($pat_cl))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
    $pdf->Ln(2);
$pdf->Cell(62,8,'          Cl-',0,0,'L',0);
$pdf->Cell(62,8,$pat_cl,0,0,'C',0);
$pdf->Cell(62,8,'      98 - 109 mmd/L',0,1,'C',0);

}


if(empty($pat_mg))
{

}
else{
  $contant=$contant+1;
  if($contant==16){
 
    $contant=0;
    $pdf-> AddPage();
  
  
  
  
  $pdf->SetFont('aealarabiya','',14);
          $pdf->Image('img.png',10,10,-300);
  
          $pdf->Ln(42);
  
     
  $pdf->Cell(140,8,'',0,0,'C',0);
          
          $pdf->Cell(14,8,'Date :',0,0,'C',0);
          
          $pdf->Cell(28,8,$pat_date,0,1,'C',0);
          $pdf->Ln();
  
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);
  
  
    $pdf->Ln();
         
    $pdf->SetFillColor(214, 234, 248);
    $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
    $contant=$contant+1;
    $pdf->Cell(62,8,' Test ',1,0,'C','true');
    $pdf->Cell(62,8,' Result ',1,0,'C','true');
    $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
    $contant=$contant+1;
    $pdf->Ln();
  }
      $pdf->Ln(2);
$pdf->Cell(62,8,'          Mg++',0,0,'L',0);
$pdf->Cell(62,8,$pat_mg,0,0,'C',0);
$pdf->Cell(62,8,'      1.6 - 2.6 mg/dL',0,1,'L',0);

}


if(empty($pat_ck))
{

}
else{
  $contant=$contant+1;
  if($contant==16){
 
    $contant=0;
    $pdf-> AddPage();
  
  
  
  
  $pdf->SetFont('aealarabiya','',14);
          $pdf->Image('img.png',10,10,-300);
  
          $pdf->Ln(42);
  
     
  $pdf->Cell(140,8,'',0,0,'C',0);
          
          $pdf->Cell(14,8,'Date :',0,0,'C',0);
          
          $pdf->Cell(28,8,$pat_date,0,1,'C',0);
          $pdf->Ln();
  
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);
  
  
    $pdf->Ln();
         
    $pdf->SetFillColor(214, 234, 248);
    $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
    $contant=$contant+1;
    $pdf->Cell(62,8,' Test ',1,0,'C','true');
    $pdf->Cell(62,8,' Result ',1,0,'C','true');
    $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
    $contant=$contant+1;
    $pdf->Ln();
  }
      $pdf->Ln(2);
$pdf->Cell(62,8,'          C.K',0,0,'L',0);
$pdf->Cell(62,8,$pat_ck,0,0,'C',0);
$pdf->Cell(62,8,'      up to 240 U/L',0,1,'L',0);

}


if(empty($pat_ck_mb))
{

}
else{
  $contant=$contant+1;
  if($contant==16){
 
    $contant=0;
    $pdf-> AddPage();
  
  
  
  
  $pdf->SetFont('aealarabiya','',14);
          $pdf->Image('img.png',10,10,-300);
  
          $pdf->Ln(42);
  
     
  $pdf->Cell(140,8,'',0,0,'C',0);
          
          $pdf->Cell(14,8,'Date :',0,0,'C',0);
          
          $pdf->Cell(28,8,$pat_date,0,1,'C',0);
          $pdf->Ln();
  
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);
  
  
    $pdf->Ln();
         
    $pdf->SetFillColor(214, 234, 248);
    $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
    $contant=$contant+1;
    $pdf->Cell(62,8,' Test ',1,0,'C','true');
    $pdf->Cell(62,8,' Result ',1,0,'C','true');
    $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
    $contant=$contant+1;
    $pdf->Ln();
  }
      $pdf->Ln(2);
$pdf->Cell(62,8,'          CK-MB',0,0,'L',0);
$pdf->Cell(62,8,$pat_ck_mb,0,0,'C',0);
$pdf->Cell(62,8,'      up to 25 U/L',0,1,'L',0);

  }


if(empty($pat_ldh))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
    $pdf->Ln(2);
$pdf->Cell(62,8,'          L.D.H',0,0,'L',0);
$pdf->Cell(62,8,$pat_ldh,0,0,'C',0);
$pdf->Cell(62,8,'      230 - 460 U/L',0,1,'L',0);

}


if(empty($pat_cholesterol))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
    $pdf->Ln(2);
$pdf->Cell(62,8,'          Cholesterol',0,0,'L',0);
$pdf->Cell(62,8,$pat_cholesterol,0,0,'C',0);
$pdf->Cell(62,8,'      < 200 mg/dL',0,1,'L',0);

}


if(empty($pat_triglyceride))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
    $pdf->Ln(2);
$pdf->Cell(62,8,'          Triglyceride',0,0,'L',0);
$pdf->Cell(62,8,$pat_triglyceride,0,0,'C',0);
$pdf->Cell(62,8,'      < 200 mg/dL',0,1,'L',0);

}


if(empty($pat_ldl))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          LDL',0,0,'L',0);
$pdf->Cell(62,8,$pat_ldl,0,0,'C',0);
$pdf->Cell(62,8,'      < 135 mg/dL',0,1,'L',0);

}


if(empty($pat_hdl))
{

}
else{
  $contant=$contant+1;
  if($contant==16){
 
    $contant=0;
    $pdf-> AddPage();
  
  
  
  
  $pdf->SetFont('aealarabiya','',14);
          $pdf->Image('img.png',10,10,-300);
  
          $pdf->Ln(42);
  
     
  $pdf->Cell(140,8,'',0,0,'C',0);
          
          $pdf->Cell(14,8,'Date :',0,0,'C',0);
          
          $pdf->Cell(28,8,$pat_date,0,1,'C',0);
          $pdf->Ln();
  
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);
  
  
    $pdf->Ln();
         
    $pdf->SetFillColor(214, 234, 248);
    $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
    $contant=$contant+1;
    $pdf->Cell(62,8,' Test ',1,0,'C','true');
    $pdf->Cell(62,8,' Result ',1,0,'C','true');
    $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
    $contant=$contant+1;
    $pdf->Ln();
  }
    $pdf->Ln(2);

$pdf->Cell(62,8,'          HDL',0,0,'L',0);
$pdf->Cell(62,8,$pat_hdl,0,0,'C',0);
$pdf->Cell(62,8,'      < 55 mg/dL',0,1,'L',0);

}


if(empty($pat_uricacid))
{

}
else{
  
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



       
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);

 


  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          Uric Acid',0,0,'L',0);
$pdf->Cell(62,8,$pat_uricacid,0,0,'C',0);
$pdf->MultiCell(62,8,'      M : 3.5 - 7.0 mg/dL '."\n".'      F : 2.5 - 5.8  mg/dL',0,'',1);


}

if(empty($pat_t_patinte))
{

}
else{
  $contant=$contant+1;
  if($contant==16){
 
    $contant=0;
    $pdf-> AddPage();
  
  
  
  
  $pdf->SetFont('aealarabiya','',14);
          $pdf->Image('img.png',10,10,-300);
  
          $pdf->Ln(42);
  
     
  $pdf->Cell(140,8,'',0,0,'C',0);
          
          $pdf->Cell(14,8,'Date :',0,0,'C',0);
          
          $pdf->Cell(28,8,$pat_date,0,1,'C',0);
          $pdf->Ln();
  
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);
  
  
    $pdf->Ln();
         
    $pdf->SetFillColor(214, 234, 248);
    $pdf->Cell(186,8,'BIOCHEMEISTRY ',1,1,'C','true');
    $contant=$contant+1;
    $pdf->Cell(62,8,' Test ',1,0,'C','true');
    $pdf->Cell(62,8,' Result ',1,0,'C','true');
    $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
    $contant=$contant+1;
    $pdf->Ln();
  }
    $pdf->Ln(2);
$pdf->Cell(62,8,'          T.Protine',0,0,'L',0);
$pdf->Cell(62,8,$pat_t_patinte,0,0,'C',0);
$pdf->Cell(62,8,'      56 - 87 g/L',0,1,'L',0);

}



}


if(!empty($pat_aso) || !empty($pat_crp) || !empty($pat_rf) || !empty($pat_salmon_o) || !empty($pat_salmon_h) || !empty($pat_salmon_a) || !empty($pat_salmon_b) || !empty($pat_brucella_a) || !empty($pat_brucella_m) || !empty($pat_blood_group) ||  !empty($pat_tb) || !empty($pat_hiv) || !empty($pat_hcv) || !empty($pat_hbs_ag) || !empty($pat_vdrl) || !empty($pat_h_pylori_rb) || !empty($pat_h_pylori_ag)  )
{
 




$pdf->Ln();
     
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();

if(empty($pat_aso))
{

}
else{
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          ASO:',0,0,'L',0);
$pdf->Cell(62,8,$pat_aso,0,0,'C',0);
$pdf->Cell(62,8,'      < 200',0,1,'L',0);

}

if(empty($pat_crp))
{

}
else{
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          C.R.P',0,0,'L',0);
$pdf->Cell(62,8,$pat_crp,0,0,'C',0);
$pdf->Cell(62,8,'      < 1/6',0,1,'L',0);

}

if(empty($pat_rf))
{

}
else{
$contant=$contant+1;


if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          RF',0,0,'L',0);
$pdf->Cell(62,8,$pat_rf,0,0,'C',0);
$pdf->Cell(62,8,'      < 1/4',0,1,'L',0);

}

if(empty($pat_salmon_o))
{

}
else{
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
  $pdf->Ln(2);
  $pdf->Cell(62,8,'          Widal Test',0,1,'L',0);
$pdf->Cell(62,8,'          Salmonella (O)',0,0,'L',0);
$pdf->Cell(62,8,$pat_salmon_o,0,0,'C',0);
$pdf->Cell(62,8,'      < 1/80',0,1,'L',0);

}



if(empty($pat_salmon_h))
{

}
else{
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          Salmonella (H)',0,0,'L',0);
$pdf->Cell(62,8,$pat_salmon_h,0,0,'C',0);
$pdf->Cell(62,8,'      < 1/80',0,1,'L',0);

}





if(empty($pat_salmon_a))
{

}
else{
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
  $pdf->Ln(2);

$pdf->Cell(62,8,'          S.Para Typh (A)',0,0,'L',0);
$pdf->Cell(62,8,$pat_salmon_a,0,0,'C',0);
$pdf->Cell(62,8,'      < 1/80',0,1,'L',0);

}



if(empty($pat_salmon_b))
{

}
else{
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
  $pdf->Ln(2);

$pdf->Cell(62,8,'          S.Para Typh (B)',0,0,'L',0);
$pdf->Cell(62,8,$pat_salmon_b,0,0,'C',0);
$pdf->Cell(62,8,'      < 1/80',0,1,'L',0);

}



if(empty($pat_brucella_a))
{

}
else{
$contant=$contant+1;


if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          Brucella',0,1,'L',0);
$pdf->Cell(62,8,'          Abrotus',0,0,'L',0);
$pdf->Cell(62,8,$pat_brucella_a,0,0,'C',0);
$pdf->Cell(62,8,'      < 1/80',0,1,'L',0);

}



if(empty($pat_brucella_m))
{

}
else{
$contant=$contant+1;


if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
  $pdf->Ln(2);

$pdf->Cell(62,8,'          Maletenses',0,0,'L',0);
$pdf->Cell(62,8,$pat_brucella_m,0,0,'C',0);
$pdf->Cell(62,8,'      < 1/80',0,1,'L',0);

}




if(empty($pat_blood_group))
{

}
else{
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
  $pdf->Ln(2);
$pdf->Cell(62,8,'          Blood Group',0,0,'L',0);
$pdf->Cell(62,8,$pat_blood_group,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}

if(empty($pat_tb))
{

}
else{
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);
$pdf->Cell(62,8,'          TB',0,0,'L',0);
$pdf->Cell(62,8,$pat_tb,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}

if(empty($pat_hiv))
{

}
else{
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);

$pdf->Cell(62,8,'          HIV',0,0,'L',0);
$pdf->Cell(62,8,$pat_hiv,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}

if(empty($pat_hcv))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);

$pdf->Cell(62,8,'          HCV',0,0,'L',0);
$pdf->Cell(62,8,$pat_hcv,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}

if(empty($pat_hbs_ag))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);

$pdf->Cell(62,8,'          HBS.AG',0,0,'L',0);
$pdf->Cell(62,8,$pat_hbs_ag,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}

if(empty($pat_vdrl))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);

$pdf->Cell(62,8,'          VDRL',0,0,'L',0);
$pdf->Cell(62,8,$pat_vdrl,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}

if(empty($pat_h_pylori_rb))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);

$pdf->Cell(62,8,'          H.PYLORI Ab',0,0,'L',0);
$pdf->Cell(62,8,$pat_h_pylori_rb,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);


}

if(empty($pat_h_pylori_ag))
{

}
else{
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'SEROLOGY ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);

$pdf->Cell(62,8,'          H.PYLORI AG',0,0,'L',0);
$pdf->Cell(62,8,$pat_h_pylori_ag,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}
}

if(!empty($pat_ethanol) || !empty($pat_dlhjpam) || !empty($pat_marijuana) ||  !empty($pat_tramedol) || !empty($pat_heroin) || !empty($pat_pethidine) || !empty($pat_cocaine) || !empty($pat_amphetamine) )
{
 




  $pdf->Ln();
       
  $pdf->SetFillColor(214, 234, 248);
  $pdf->Cell(186,8,'DRUGS ',1,1,'C','true');
  $contant=$contant+1;
  $pdf->Cell(62,8,' Test ',1,0,'C','true');
  $pdf->Cell(62,8,' Result ',1,0,'C','true');
  $pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
  $contant=$contant+1;
  $pdf->Ln();
if(empty($pat_ethanol))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'DRUGS ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);
$pdf->Cell(62,8,'          Ethanol',0,0,'L',0);
$pdf->Cell(62,8,$pat_ethanol,0,0,'C',0);
$pdf->Cell(62,8,'      Up to 50 mg/dl',0,1,'L',0);

}
if(empty($pat_dlhjpam))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'DRUGS ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);

$pdf->Cell(62,8,'          Diazepam',0,0,'L',0);
$pdf->Cell(62,8,$pat_dlhjpam,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}
if(empty($pat_marijuana))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'DRUGS ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);
$pdf->Cell(62,8,'          Marijuana',0,0,'L',0);
$pdf->Cell(62,8,$pat_marijuana,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}
if(empty($pat_tramedol))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'DRUGS ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);
$pdf->Cell(62,8,'          Tramedol',0,0,'L',0);
$pdf->Cell(62,8,$pat_tramedol,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}
if(empty($pat_heroin))
{

}

else{
$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'DRUGS ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);

$pdf->Cell(62,8,'          Heroin',0,0,'L',0);
$pdf->Cell(62,8,$pat_heroin,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}
if(empty($pat_pethidine))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'DRUGS ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);

$pdf->Cell(62,8,'          Pethidine',0,0,'L',0);
$pdf->Cell(62,8,$pat_pethidine,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}
if(empty($pat_cocaine))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'DRUGS ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);

$pdf->Cell(62,8,'          Cocaine',0,0,'L',0);
$pdf->Cell(62,8,$pat_cocaine,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}
if(empty($pat_amphetamine))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'DRUGS ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Ln(2);
$pdf->Cell(62,8,'          Amphetamine',0,0,'L',0);
$pdf->Cell(62,8,$pat_amphetamine,0,0,'C',0);
$pdf->Cell(62,8,'      ',0,1,'L',0);

}


}






if(!empty($pat_t3) || !empty($pat_t4) || !empty($pat_tsh) || !empty($pat_prolactin) || !empty($pat_psa) || !empty($pat_ps3) || !empty($pat_vitb) || !empty($pat_vitd) || !empty($pat_ca153) || !empty($pat_ca125) )
{
 




$pdf->Ln();
  $contant=0;
  $pdf-> AddPage();
  
        $pdf->Image('img.png',10,10,-300);
$pdf->Ln(42);
  
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();
            
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'HARMONES ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();


if(empty($pat_t3))
{

}
else{

$contant=$contant+1;
if($contant>=12){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);
        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'HARMONES ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+8;
$pdf->Ln();
}
$pdf->Cell(62,8,'          T3',0,0,'C',0);
$pdf->Cell(62,8,$pat_t3,0,0,'C',0);
$pdf->MultiCell(62,8,'< 3d  (2.4 - 10.0 ) Pg/ml '."\n".'4 - 30d  (2.7 - 8.2 ) Pg/ml '."\n".'2 - 12m  (2.5 - 7.7 ) Pg/ml '."\n".'1 - 6y  (2.7 - 8.8 ) Pg/ml '."\n".'7 - 12y  (2.9 - 8.2 ) Pg/ml '."\n".'13 - 16y  (3.3 - 6.9 ) Pg/ml'."\n".'Adult  (2.02 - 4.43) Pg/ml',0,'',1);
$pdf->Ln(2);

}
if(empty($pat_t4))
{

}
else{

$contant=$contant+1;
if($contant>=12){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'HARMONES ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+8;
$pdf->Ln();
}
$pdf->Cell(62,8,'          T4',0,0,'C',0);
$pdf->Cell(62,8,$pat_t4,0,0,'C',0);
$pdf->MultiCell(62,8,'< 3d (1.1 - 1.30 )ng/dl'."\n".'4 - 30d (0.9 - 2.8 )ng/dl'."\n".'2 - 12m (0.7 - 2.3 )ng/dl'."\n".'1 - 6y (0.45 - 3.6 )ng/dl'."\n".'7 - 12y (0.8 - 1.7 )ng/dl'."\n".'13 - 16y (0.9 - 2.1 )ng/dl'."\n".'Adult (0.9 - 1.71) ng/dl',0,'',1);
$pdf->Ln(2);

}
if(empty($pat_tsh))
{

}
else{

$contant=$contant+1;
if($contant>=12){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'HARMONES ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+8;
$pdf->Ln();
}
$pdf->Cell(62,8,'          TSH',0,0,'C',0);
$pdf->Cell(62,8,$pat_tsh,0,0,'C',0);
$pdf->MultiCell(62,8,'< 3d (0.68 - 29 )mIU/ml'."\n".'4 - 30d (0.51 - 11 )mIU/ml'."\n".'2 - 12m (0.55 - 6.7 )mIU/ml'."\n".'1 - 6y (0.45 - 3.6 )mIU/ml'."\n".'7 - 12y (0.61 - 5.2 )mIU/ml'."\n".'13 - 16y(0.36 - 4.7 )mIU/ml'."\n".'Adult(0.23-3.8)mIU/ml',0,'',1);

}
if(empty($pat_prolactin))
{

}

else{
$contant=$contant+8;
if($contant>=12){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'HARMONES ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+2;
$pdf->Ln();
}
$pdf->Cell(62,8,'          Prolactin',0,0,'C',0);
$pdf->Cell(62,8,$pat_prolactin,0,0,'C',0);
$pdf->MultiCell(62,8,'      Adult'."\n".'      F : 3.4 - 24.1  ng/ml'."\n".'      M : 4.1 - 18.4  ng/ml',0,'',1);

}
if(empty($pat_psa))
{

}
else{

$contant=$contant+1;
if($contant==12){
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'HARMONES ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Cell(62,8,'          PSA Free',0,0,'C',0);
$pdf->Cell(62,8,$pat_psa,0,0,'C',0);
$pdf->Cell(62,8,'',0,1,'C',0);

}
if(empty($pat_ps3))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'HARMONES ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Cell(62,8,'         PSA Total',0,0,'C',0);
$pdf->Cell(62,8,$pat_ps3,0,0,'C',0);
$pdf->Cell(62,8,'',0,1,'C',0);
}

if(empty($pat_vitb))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'HARMONES ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Cell(62,8,'          Vit-B12',0,0,'C',0);
$pdf->Cell(62,8,$pat_vitb,0,0,'C',0);
$pdf->Cell(62,8,'',0,1,'C',0);
}

if(empty($pat_vitd))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'HARMONES ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Cell(62,8,'          Vit-D3',0,0,'C',0);
$pdf->Cell(62,8,$pat_vitd,0,0,'C',0);
$pdf->Cell(62,8,'',0,1,'C',0);
}

if(empty($pat_ca153))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'HARMONES ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Cell(62,8,'          CA 153',0,0,'C',0);
$pdf->Cell(62,8,$pat_ca153,0,0,'C',0);
$pdf->Cell(62,8,'',0,1,'C',0);
}

if(empty($pat_ca125))
{

}
else{

$contant=$contant+1;
if($contant==16){
 
 
  $contant=0;
  $pdf-> AddPage();




$pdf->SetFont('aealarabiya','',14);
        $pdf->Image('img.png',10,10,-300);

        $pdf->Ln(42);

   
$pdf->Cell(140,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'Date :',0,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,0,1,'C',0);
        $pdf->Ln();



      
  $pdf->SetFillColor(169, 204, 227);
        $pdf->Cell(20,8,'Name :',1,0,'C','true');
        $pdf->Cell(45,8,$row_fname,1,0,'C',0);
      
         $pdf->Cell(15,8,'Age :',1,0,'C','true');
       
        $pdf->Cell(20,8,$row_age,1,0,'C',0);
       
         $pdf->Cell(20,8,'Gander:',1,0,'C','true');
       
        $pdf->Cell(10,8,$row_gander,1,0,'C',0);
    
         $pdf->Cell(20,8,'Phone :',1,0,'C','true');
       
        $pdf->Cell(35,8,$row_phone,1,1,'C',0);



  
$pdf->Ln();
       
$pdf->SetFillColor(214, 234, 248);
$pdf->Cell(186,8,'HARMONES ',1,1,'C','true');
$contant=$contant+1;
$pdf->Cell(62,8,' Test ',1,0,'C','true');
$pdf->Cell(62,8,' Result ',1,0,'C','true');
$pdf->Cell(62,8,' Reference Values ',1,0,'C','true');
$contant=$contant+1;
$pdf->Ln();
}
$pdf->Cell(62,8,'          CA 125',0,0,'C',0);
$pdf->Cell(62,8,$pat_ca125,0,0,'C',0);
$pdf->Cell(62,8,'',0,1,'C',0);
}

}
        $pdf->Ln();

$pdf->Cell(50,8,'Lab :',0,0,'C',0);
$pdf->Cell(90,8,'',0,0,'C',0);
$pdf->Cell(50,8,' Doctor :',0,1,'C',0);
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
