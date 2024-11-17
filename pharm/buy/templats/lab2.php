<!DOCTYPE html>
<html>
<head>

<title> Insert test </title>



<link href="css/bootstrap.min.css" rel="stylesheet">

<link href="css/style.css" rel="stylesheet">
<link href="css/style1.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" >

</head>

<body> 

<?php


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


   
  $pat_id=0;
  if(isset($_POST['Submit_pation'])){
$pat_id=$_POST['pat_id'];
 
    /////////////////////////search jqury users//////////////////////////

    $r=mysqli_query($conn,"select fname,phone from patinte where pat_id=$pat_id");





   
   //////////////////////////////////////




  }








    /////////////////insert_patient//////////////////
    if(isset($_POST['Submit'])){
        $pat_id= $_POST['pat_id'];
		$pat_hb= $_POST['hb'];
       $pat_wbc= $_POST['wbc'];
        $pat_neutrophil=$_POST['neutrophil'];
        $pat_lymphocyle=$_POST['lymphocyle'];
        $pat_monocyte=$_POST['monocyte'];
        $pat_eosinophil=$_POST['eosinophil'];
        $pat_rbs=$_POST['rbs'];
        $pat_urea=$_POST['urea'];
        $pat_creatinine=$_POST['creatinine'];
        $pat_s_got=$_POST['s_got'];
        $pat_s_gpt=$_POST['s_gpt'];
    $pat_total_bilirubin=$_POST['total_bilirubin'];
  $pat_direct_briliubin=$_POST['direct_briliubin'];
        $pat_aso=$_POST['aso'];
        $pat_crp=$_POST['crp'];
        $pat_rf=$_POST['rf'];
        $pat_salrnonolls_o=$_POST['salrnonolls_o'];
        $pat_salrnonolls_h=$_POST['salrnonolls_h'];
        $pat_salrnonolls_a=$_POST['salrnonolls_a'];
        $pat_salrnonolls_b=$_POST['salrnonolls_b'];
        $pat_marijuana=$_POST['marijuana'];
       $pat_amphetamin=$_POST['amphetamin'];
        $pat_cocaine=$_POST['cocaine'];
        $pat_heroin=$_POST['heroin'];
        $pat_pt=$_POST['pt'];
        $pat_ptt=$_POST['ptt'];
        $pat_inr=$_POST['inr'];
        $pat_esr=$_POST['esr'];
        $pat_malari=$_POST['malari'];
        $pat_cholestrol=$_POST['cholestrol'];
        $pat_triglyceride=$_POST['triglyceride'];
       $pat_hdl=$_POST['hdl'];
        $pat_ldl=$_POST['ldl'];
        $pat_ca=$_POST['ca'];
        $pat_k=$_POST['k'];
        $pat_na=$_POST['na'];
        $pat_h_pylorl=$_POST['h_pylorl'];
        $pat_hiv=$_POST['hiv'];
        $pat_hbs_ag=$_POST['hbs_ag'];
        $pat_hcv=$_POST['hcv'];

    if (empty($_POST["pat_id"])) {
      $Pat_fname = "pation id  is required";
      echo $Pat_fname;
     }else {
    
     $insert_blood_test = "insert into blood_test (pat_id,hb,wbc,neutrophil,lymphocyle,monocyte,eosinophil,rbs,urea,creatinine,s_got,s_gpt,total_bilirubin,direct_briliubin,aso,crp,rf,salrnonolls_o,salrnonolls_h,salrnonolls_a,salrnonolls_b,marijuana,amphetamin,cocaine,heroin,pt,ptt,inr,esr,malari,cholestrol,triglyceride,hdl,ldl,ca,k,na,h_pylorl,hiv,hbs_ag,hcv) 
     values ('$pat_id','$pat_hb','$pat_wbc','$pat_neutrophil','$pat_lymphocyle','$pat_monocyte','$pat_eosinophil','$pat_rbs','$pat_urea','$pat_creatinine','$pat_s_got','$pat_s_gpt','$pat_total_bilirubin','$pat_direct_briliubin','$pat_aso','$pat_crp','$pat_rf','$pat_salrnonolls_o','$pat_salrnonolls_h','$pat_salrnonolls_a','$pat_salrnonolls_b','$pat_marijuana','$pat_amphetamin','$pat_cocaine','$pat_heroin','$pat_pt','$pat_ptt','$pat_inr','$pat_esr','$pat_malari','$pat_cholestrol','$pat_triglyceride','$pat_hdl','$pat_ldl','$pat_ca','$pat_k','$pat_na','$pat_h_pylorl','$pat_hiv','$pat_hbs_ag','$pat_hcv')";

$run_blood_test = mysqli_query($conn,$insert_blood_test);

if($run_blood_test){

echo "<script>alert('blood_test has been inserted successfully')</script>";

echo "<script>window.open('lab2.php','_self')</script>";

}

            }
        }

    $conn->close();





}
?>

    <main class="main">

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          
          <table id="mytable" cellspacing="15" cellpadding="0" >
          
          <tr>

            <td>
            <label for="no.p">  Patient No: </label>
            <input type="number" id="nosession" name="pat_id">
            </td>
        
              <td>
              <label for="no.p">Patient name: </label>
              </td>

              <td>
             &nbsp; <input type="submit" value="استعلام" class="btn btn-warning" name="Submit_pation">
              </td>
			  <td>
			  &nbsp; &nbsp; &nbsp;    <input type="submit" value="ادخال" class="btn btn-success" name="Submit">
</td>
					   
          </tr>
    
          <?php 
  if($pat_id>0){
while($row =mysqli_fetch_array($r)){
 
    echo "<tr>";
  
    echo "<td>" .$row['fname']."</td>";
    
    echo "<td>" .$row['phone']."</td>";
 
    echo "</tr>";
    }
  }
 
?>
			<br> <br>

          </table>
<table class="table table-borderless" >  
<tr>
 
	<td>
    <label for="hb"> HB :</label>
    <textarea id="" cols="" rows="" name="hb"></textarea>
  </td>
  <td>
    <label for="wbc"> WBC :</label>
    <textarea id="" cols="" rows="" name="wbc"></textarea>
  </td>
   <td>
    <label for="neutrophil"> Neutrophil :</label>
    <textarea id="" cols="" rows="" name="neutrophil"></textarea>
  </td>

      <td>
    <label for="lymphocyte"> Lymphocyte :</label>
    <textarea id="" cols="" rows="" name="lymphocyle"></textarea>
  </td>      
        <td>
    <label for="monocyte"> Monocyte : </label>
    <textarea id="" cols="" rows="" name="monocyte"></textarea>
  </td>   
  <td>
    <label for="eosinophil"> Eosinophil:</label>
    <textarea id="" cols="" rows="" name="eosinophil" ></textarea>
  </td>
</tr>

<tr>
<td>
            <label for="rbs"> RBS :</label>
            <textarea id="" cols="" rows="" name="rbs" ></textarea>
            </td>
<td>
              <label for="urea"> Urea :</label>
              <textarea id="" cols="" rows="" name="urea"></textarea>
              </td>
  <td>
    <label for="creatinine"> Creatinine :</label>
    <textarea id="" cols="" rows="" name="creatinine"></textarea>
  </td>

  <td>
    <label for="s_got"> S.GOT :</label>
    <textarea id="" cols="" rows="" name="s_got"></textarea>
  </td>

  <td>
    <label for="s_gpt"> S.GPT :</label>
    <textarea id="" cols="" rows="" name="s_gpt"></textarea>
  </td>



  <td>
    <label for="total brilirubin"> Total Brilirubin :</label>
    <textarea id="" cols="" rows="" name="total_bilirubin" ></textarea>
  </td>

  
</tr>

<tr>
<td>
    <label for="Direct Briliubin"> Direct Brilirubin :</label>
    <textarea id="" cols="" rows="" name="direct_briliubin"></textarea>
  </td>

  <td>
    <label for="A.S.O"> A.S.O :</label>
    <textarea id="" cols="" rows="" name="aso"></textarea>
  </td>
  <td>
    <label for="C.R.P"> C.R.P :</label>
    <textarea id="" cols="" rows="" name="crp"></textarea>
  </td>

  <td>
    <label for="R.F"> R.F :</label>
    <textarea id="" cols="" rows="" name="rf"></textarea>
  </td>
  <td>
    <label for="Widal Test Salmonella (O)"> Widal Test Salmonella (O) :</label>
    <textarea id="" cols="" rows="" name="salrnonolls_o"></textarea>
  </td>

  <td>
    <label for="Widal Test Salmonella (H)"> Widal Test Salmonella (H) :</label>
    <textarea id="" cols="" rows="" name="salrnonolls_h"></textarea>
  </td>
</tr>

<tr>

  <td>
    <label for="Widal Test Salmonella (A)"> Widal Test Salmonella (A) :</label>
    <textarea id="" cols="" rows="" name="salrnonolls_a"></textarea>
  </td>

  <td>
    <label for="Widal Test Salmonella (B)"> Widal Test Salmonella (B) :</label>
    <textarea id="" cols="" rows="" name="salrnonolls_b"></textarea>
  </td>
  <td>
    <label for="Marijuana"> Marijuana :</label>
    <textarea id="" cols="" rows="" name="marijuana"></textarea>
  </td>
<td>
  <label for="Amphetamin"> Amphetamin :</label>
    <textarea id="" cols="" rows="" name="amphetamin"></textarea>
  </td>

  <td>
    <label for="Cocaine"> Cocaine :</label>
    <textarea id="" cols="" rows="" name="cocaine"></textarea>
  </td>
  <td>
    <label for="Heroin"> Heroin :</label>
    <textarea id="" cols="" rows="" name="heroin"></textarea>
  </td>

</tr>

<tr>
    
    <td>
    <label for="PT"> PT Patient :</label>
    <textarea id="" cols="" rows="" name="pt"></textarea>
  </td>

    <td>
    <label for="PTT"> PTT Patient :</label>
    <textarea id="" cols="" rows="" name="ptt"></textarea>
  </td>

    <td>
    <label for="INR"> INR :</label>
    <textarea id="" cols="" rows="" name="inr"></textarea>
  </td>

  <td>
    <label for="ESR"> ESR :</label>
    <textarea id="" cols="" rows="" name="esr"></textarea>
  </td>

  <td>
    <label for="Malari"> Malari :</label>
    <textarea id="" cols="" rows="" name="malari"></textarea>
  </td>
  <td>
    <label for="Cholestrol"> Cholestrol :</label>
    <textarea id="" cols="" rows="" name="cholestrol"></textarea>
  </td>

</tr>



<tr>

    <td>
    <label for="Triglyceride"> Triglyceride :</label>
    <textarea id="" cols="" rows="" name="triglyceride"></textarea>
  </td>

    <td>
    <label for="HDL"> HDL :</label>
    <textarea id="" cols="" rows="" name="hdl"></textarea>
  </td>

    <td>
    <label for="LDL"> LDL :</label>
    <textarea id="" cols="" rows="" name="ldl"></textarea>
  </td>


 <td>
    <label for="Ca"> Ca++ :</label>
    <textarea id="" cols="" rows="" name="ca"></textarea>
  </td>

  <td>
    <label for="K"> K+ :</label>
    <textarea id="" cols="" rows="" name="k"></textarea>
  </td>
  <td>
    <label for="Na"> Na+ :</label>
    <textarea id="" cols="" rows="" name="na"></textarea>
  </td>

</tr>


<tr>

    <td>
    <label for="pylorl"> H.pylorl :</label>
    <textarea id="" cols="" rows="" name="h_pylorl"></textarea>
  </td>

    <td>
    <label for="HIV"> HIV :</label>
    <textarea id="hiv" cols="" rows="" name="hiv"></textarea>
  </td>

    <td>
    <label for="HBS"> HBS-Ag :</label>
    <textarea id="" cols="" rows="" name="hbs_ag"></textarea>
  </td>

    <td>
    <label for="HCV"> HCV :</label>
    <textarea id="" cols="" rows="" name="hcv"></textarea>
  </td>
</tr>

</table> 


   </form>


   </main>
            
           <footer>
            

           </footer> 
        
</body>

</html>



