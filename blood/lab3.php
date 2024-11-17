<!DOCTYPE html>
<html>
<head>

<title> Insert test </title>

<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>

<link href="css/bootstrap.min.css" rel="stylesheet">

<link href="css/style.css" rel="stylesheet">
<link href="css/style1.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" >

</head>
<body >
	<?php



if(!isset($_SESSION['u_name'])){

echo "<script>window.open('login.php','_self')</script>";

}

else {
?>
<?php include 'templats/navbar.php';
	?>
	<?php


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


   
  $pat_id=0;
  if(isset($_POST['Submit_pation'])){
$pat_id=$_POST['pat_id'];
 
    /////////////////////////search jqury users//////////////////////////

    $r=mysqli_query($conn,"select fname,phone from patinte where pat_id=$pat_id ");





   
   //////////////////////////////////////




  }







	   


if(isset($_POST['submit'])){

$pat_id=$_POST['pat_id'];
		
		$Pat_hb=$_POST['hb'];

       $pat_wbc=$_POST['wbc'];

        $pat_neutrophil=$_POST['neutrophil'];

        $pat_lymphocyle=$_POST['lymphocyle'];

        $pat_monocyte=$_POST['monocyte'];

        $pat_eosinophil=$_POST['eosinophil'];

        $pat_rbs=$_POST['rbs'];

        $Pat_urea=$_POST['urea'];

        $pat_creatinine=$_POST['creatinine'];

        $pat_s_got=$_POST['s_got'];

        $Pat_s_gpt=$_POST['s_gpt'];

       $pat_total_bilirubin=$_POST['total_bilirubin'];

        $pat_direct_briliubin=$_POST['direct_briliubin'];

        $pat_aso=$_POST['aso'];

        $pat_crp=$_POST['crp'];

        $pat_rf=$_POST['rf'];

        $pat_salrnonolls_o=$_POST['salrnonolls_o'];

        $Pat_salrnonolls_h=$_POST['salrnonolls_h'];

        $pat_salrnonolls_a=$_POST['salrnonolls_a'];


        $pat_salrnonolls_b=$_POST['salrnonolls_b'];

        $Pat_marijuana=$_POST['marijuana'];

       $pat_amphetamin=$_POST['amphetamin'];

        $pat_cocaine=$_POST['cocaine'];

        $pat_heroin=$_POST['heroin'];

        $pat_pt=$_POST['pt'];

        $pat_ptt=$_POST['ptt'];

        $pat_inr=$_POST['inr'];

        $Pat_esr=$_POST['esr'];

        $pat_malari=$_POST['malari'];


        $pat_cholestrol=$_POST['cholestrol'];

        $Pat_triglyceride=$_POST['triglyceride'];

       $pat_hdl=$_POST['hdl'];

        $pat_ldl=$_POST['ldl'];

        $pat_ca=$_POST['ca'];

        $pat_k=$_POST['k'];

        $pat_na=$_POST['na'];

        $pat_h_pylorl=$_POST['h_pylorl'];

        $Pat_hiv=$_POST['hiv'];

        $pat_hbs_ag=$_POST['hbs_ag'];

        $pat_hcv=$_POST['hcv'];
       
if (empty($_POST["pat_id"])) {
      $Pat_fname = "pation id  is required";
      echo $Pat_fname;
     }else{


$insert_blood_test = "insert into blood_test (pat_id,hb,wbc,neutrophil,lymphocyle,monocyte,eosinophil,rbs,urea,creatinine,s_got,s_gpt,total_bilirubin,direct_briliubin,aso,crp,rf,salrnonolls_o,salrnonolls_h,salrnonolls_a,salrnonolls_b,marijuana,amphetamin,cocaine,heroin,pt,ptt,inr,esr,malari,cholestrol,triglyceride,hdl,ldl,ca,k,na,h_pylorl,hiv,hbs_ag,hcv) values ('$pat_id','$pat_hb','$pat_wbc','$pat_neutrophil','$pat_lymphocyle','$pat_monocyte','$pat_eosinophil','$pat_rbs','$pat_urea','$pat_creatinine','$pat_s_got','$pat_s_gpt','$pat_total_bilirubin','$pat_direct_briliubin','$pat_aso','$pat_crp','$pat_rf','$pat_salrnonolls_o','$pat_salrnonolls_h','$pat_salrnonolls_a','$pat_salrnonolls_b','$pat_marijuana','$pat_amphetamin','$pat_cocaine','$pat_heroin','$pat_pt','$pat_ptt','$pat_inr','$pat_esr','$pat_malari','$pat_cholestrol','$pat_triglyceride','$pat_hdl','$pat_ldl','$pat_ca' ,'$pat_k','$pat_na','$pat_h_pylorl','$pat_hiv','$pat_hbs_ag','$pat_hcv')";

$run_blood_test = mysqli_query($con,$insert_blood_test);

if($run_blood_test){

echo "<script>alert('blood_test has been inserted successfully')</script>";

echo "<script>window.open('index.php?lab3','_self')</script>";

}

}}
?>
<div class="row"><!-- row Starts -->

<div class="col-lg-12 "><!-- col-lg-12 Starts -->

<ol class="breadcrumb"><!-- breadcrumb Starts -->

<li class="active">

<i class="fa fa-dashboard"> </i> 

</li>

</ol><!-- breadcrumb Ends -->

</div><!-- col-lg-12 Ends -->

</div><!-- row Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >Patient No: </label>

<div class="col-md-6" >

<input type="number" name="pat_id" class="form-control"  >

</div>
<label class="col-md-12 control-label" >Patient name:</label>

<div class="col-md-6" >

<input type="submit" value="Submit" name="Submit_pation" class="form-control"  >

</div>
</div><!-- form-group Ends -->
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
<div class="row"><!-- 2 row Starts --> 

<div class="  col-md-2 col-sm-3"><!-- col-lg-12 Starts -->

<div class="panel panel-default"><!-- panel panel-default Starts -->


<div class="panel-body"><!-- panel-body Starts -->

<form class="form-horizontal" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

	
<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >HB </label>

<div class="col-md-6" >

<input type="text" name="hb" class="form-control"  >

</div>

</div><!-- form-group Ends -->


<div class="form-group" ><!-- form-group Starts -->
<label class="col-md-12 control-label" >WBC </label>
<div class="col-md-6" >

<input type="text" name="wbc" class="form-control"  >

</div>

</div><!-- form-group Ends -->
	
<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >Neutrophil </label>

<div class="col-md-6" >

<input type="text" name="neutrophil" class="form-control" >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >Lymphocyte Price </label>

<div class="col-md-6" >

<input type="text" name="lymphocyle" class="form-control"  >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >Monocyte </label>

<div class="col-md-6" >

<input type="text" name="monocyte" class="form-control"  >
</div>

</div><!-- form-group Ends -->
<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" > Eosinophil </label>

<div class="col-md-6" >

<input type="text" name="eosinophil" class="form-control"  >

</div>

</div><!-- form-group Ends -->
	<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" > RBS </label>

<div class="col-md-6" >

<input type="text" name="rbs" class="form-control"  >

</div>

</div><!-- form-group Ends -->

</form><!-- form-horizontal Ends -->

</div><!-- panel-body Ends -->

</div><!-- panel panel-default Ends -->

</div><!-- col-lg-12 Ends -->
<div class="  col-md-2 col-sm-3"><!-- col-lg-12 Starts -->

<div class="panel panel-default"><!-- panel panel-default Starts -->


<div class="panel-body"><!-- panel-body Starts -->

<form class="form-horizontal" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >Urea </label>

<div class="col-md-6" >

<input type="text" name="urea" class="form-control"  >

</div>

</div><!-- form-group Ends -->


<div class="form-group" ><!-- form-group Starts -->
<label class="col-md-12 control-label" >Creatinine </label>
<div class="col-md-6" >

<input type="text" name="creatinine" class="form-control"  >

</div>

</div><!-- form-group Ends -->
	
<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >S.GOT </label>

<div class="col-md-6" >

<input type="text" name="s_got" class="form-control" >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" > S.GPT </label>

<div class="col-md-6" >

<input type="text" name="s_gpt" class="form-control"  >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >Total Brilirubin </label>

<div class="col-md-6" >

<input type="text" name="total_bilirubin" class="form-control"  >

</div>

</div><!-- form-group Ends -->



<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >Direct Brilirubin </label>

<div class="col-md-6" >

<input type="text" name="direct_briliubin" class="form-control"  >

</div>

</div><!-- form-group Ends -->
<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" > A.S.O </label>

<div class="col-md-6" >

<input type="text" name="aso" class="form-control"  >

</div>

</div><!-- form-group Ends -->


</form><!-- form-horizontal Ends -->

</div><!-- panel-body Ends -->

</div><!-- panel panel-default Ends -->

</div><!-- col-lg-12 Ends -->
	<div class="  col-md-2 col-sm-3"><!-- col-lg-12 Starts -->

<div class="panel panel-default"><!-- panel panel-default Starts -->

<div class="panel-body"><!-- panel-body Starts -->

<form class="form-horizontal" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >C.R.P </label>

<div class="col-md-6" >

<input type="text" name="crp" class="form-control"  >

</div>

</div><!-- form-group Ends -->


<div class="form-group" ><!-- form-group Starts -->
<label class="col-md-12 control-label" >  R.F </label>
<div class="col-md-6" >

<input type="text" name="rf" class="form-control"  >

</div>

</div><!-- form-group Ends -->
	
<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >Widal Test Salmonella (O) </label>

<div class="col-md-6" >

<input type="text" name="salrnonolls_o" class="form-control" >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >Widal Test Salmonella (H)</label>

<div class="col-md-6" >

<input type="text" name="salrnonolls_h" class="form-control"  >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >Widal Test Salmonella (A) </label>

<div class="col-md-6" >

<input type="text" name="salrnonolls_a" class="form-control"  >

</div>

</div><!-- form-group Ends -->



<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" > Widal Test Salmonella (B) </label>

<div class="col-md-6" >

<input type="text" name="salrnonolls_b" class="form-control"  >

</div>

</div><!-- form-group Ends -->
	
<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" > Marijuana  </label>

<div class="col-md-6" >

<input type="text" name="marijuana" class="form-control"  >

</div>

</div><!-- form-group Ends -->
</form><!-- form-horizontal Ends -->

</div><!-- panel-body Ends -->

</div><!-- panel panel-default Ends -->

</div><!-- col-lg-12 Ends -->
	<div class="  col-md-2 col-sm-3"><!-- col-lg-12 Starts -->

<div class="panel panel-default"><!-- panel panel-default Starts -->


<div class="panel-body"><!-- panel-body Starts -->

<form class="form-horizontal" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >Amphetamin </label>

<div class="col-md-6" >

<input type="text" name="amphetamin" class="form-control"  >

</div>

</div><!-- form-group Ends -->


<div class="form-group" ><!-- form-group Starts -->
<label class="col-md-12 control-label" >Cocaine </label>
<div class="col-md-6" >

<input type="text" name="heroin" class="form-control"  >

</div>

</div><!-- form-group Ends -->
	
<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >PTT Patient </label>

<div class="col-md-6" >

<input type="text" name="ptt" class="form-control" >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >INR </label>

<div class="col-md-6" >

<input type="text" name="inr" class="form-control"  >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >Malari </label>

<div class="col-md-6" >

<input type="text" name="malari" class="form-control"  >

</div>

</div><!-- form-group Ends -->



<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" > Cholestrol </label>

<div class="col-md-6" >

<input type="text" name="cholestrol" class="form-control"  >

</div>

</div><!-- form-group Ends -->
	
<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" > Triglyceride </label>

<div class="col-md-6" >

<input type="text" name="triglyceride" class="form-control"  >

</div>

</div><!-- form-group Ends -->
</form><!-- form-horizontal Ends -->

</div><!-- panel-body Ends -->

</div><!-- panel panel-default Ends -->

</div><!-- col-lg-12 Ends -->
	<div class="  col-md-2 col-sm-3"><!-- col-lg-12 Starts -->

<div class="panel panel-default"><!-- panel panel-default Starts -->


<div class="panel-body"><!-- panel-body Starts -->

<form class="form-horizontal" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >HDL </label>

<div class="col-md-6" >

<input type="text" name="hdl" class="form-control"  >

</div>

</div><!-- form-group Ends -->


<div class="form-group" ><!-- form-group Starts -->
<label class="col-md-12 control-label" >LDL </label>
<div class="col-md-6" >

<input type="text" name="ldl" class="form-control"  >

</div>

</div><!-- form-group Ends -->
	
<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >Ca++</label>

<div class="col-md-6" >

<input type="text" name="ca" class="form-control" >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >K+</label>

<div class="col-md-6" >

<input type="text" name="k" class="form-control"  >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >Na+ </label>

<div class="col-md-6" >

<input type="text" name="na" class="form-control"  >

</div>

</div><!-- form-group Ends -->



<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" > H.pylorl </label>

<div class="col-md-6" >

<input type="text" name="h_pylorl" class="form-control"  >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" > HIV </label>

<div class="col-md-6" >

<input type="text" name="hiv" class="form-control"  >

</div>

</div><!-- form-group Ends -->

</form><!-- form-horizontal Ends -->

</div><!-- panel-body Ends -->

</div><!-- panel panel-default Ends -->

</div><!-- col-lg-12 Ends -->
	<div class="  col-md-2 col-sm-3"><!-- col-lg-12 Starts -->

<div class="panel panel-default"><!-- panel panel-default Starts -->


<div class="panel-body"><!-- panel-body Starts -->

<form class="form-horizontal" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" >HBS-Ag </label>

<div class="col-md-6" >

<input type="text" name="hbs_ag" class="form-control"  >

</div>

</div><!-- form-group Ends -->


<div class="form-group" ><!-- form-group Starts -->
<label class="col-md-12 control-label" >HCV </label>
<div class="col-md-6" >

<input type="text" name="hcv" class="form-control"  >

</div>



</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-12 control-label" > Heroin </label>

<div class="col-md-6" >

<input type="text" name="heroin" class="form-control"  >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-6 control-label" ></label>

<div class="col-md-6" >

<input type="submit" name="submit" value="Insert blood_test" class="btn btn-primary " >

</div>

</div><!-- form-group Ends -->
</form><!-- form-horizontal Ends -->

</div><!-- panel-body Ends -->

</div><!-- panel panel-default Ends -->

</div><!-- col-lg-12 Ends -->
	
</div><!-- 2 row Ends --> 
	 
</body>
</html>
<?php } ?>