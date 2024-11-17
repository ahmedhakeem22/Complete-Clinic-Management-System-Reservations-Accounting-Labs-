<html>
<head>
<title> Add Test Blood </title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<meta charset="utf-8">
<meta  name="vieeport"  content="width=device-width, initial-scale=1.0">

<body > 

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
$pat_date=   date("Y-m-d h:i:sa");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

$pat_id=0;
  if(isset($_POST['sub1'])){
$pat_id=$_POST['pat_id'];
 
    /////////////////////////search jqury users//////////////////////////

    $r=mysqli_query($conn,"select fname,phone from patinte where pat_id=$pat_id ");





   
   //////////////////////////////////////


  }
 
   if(isset($_POST['sub'])){
      $pat_id=$_POST['pat_id'];
      $all= implode(',',$_POST['test']);
      $all1=explode(',',$all);
   

foreach ($all1 as $k) {
      echo $k;
      
        $stmt = $conn->prepare("INSERT INTO blood ( name_lab ,date_lab ,pat_id)
        VALUES ( ?,?,?)");
        
      
        $stmt->bind_param("sss",$k,$pat_date,$pat_id) ;
        $stmt->execute();
}



  
  }

$conn->close();

}
?>
<header>
    

</header>

      <main class="main" >

      <img src="List of Blood.jpg" alt="image" width="100%" height="45%">

      <!--
<table class="boold" cellspacing="15" cellpadding="0"  >

  <tr>
    <th style="text-align: center; font-size: 25px; ">  مختبر الدم  </th>
  </tr>
<tr>
  <td>
    <label for="Foresight">Name:<pre></pre></label>
    <textarea id="" cols="50" rows="5" ></textarea>
  </td>
</tr>
<tr>
  <td>
    <label for="Foresight">Marks:<pre></pre></label>
    <textarea id="" cols="50" rows="5" ></textarea>
  </td>
</tr>
<tr>
  <td>
    <label for="Foresight">Notes:<pre></pre></label>
    <textarea id="" cols="50" rows="5" ></textarea>
  </td>
</tr>
<tr>
  <td>
    <input type="submit" value="ok" style="width: 100%; height: auto; border-radius: 5px; color: white; background-color: blue; cursor: pointer; " >
  </td>
</tr>

-->
  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">

<input type="number" id="invoice" name="pat_id" > 
  <input  type="submit" value="submit" name="sub1">

  
 <?php 
  if(isset($_POST['sub1'])){
 
  if($pat_id>0){
while($row =mysqli_fetch_array($r)){
 
    echo "<br>";
  
    echo "<h1>" .$row['fname']."</h1>";
    
    echo "<h1>" .$row['phone']."</h1>";
   
   
      
    echo "</br>";
    
    
}
  }
  }
?>
</table>
      <!-- <img src="picnew.png" alt="image" width="100%" height="45%">-->
       <div class="boxlab">
           <h2 style="color:red;">A list of blood tests</h2>

         




               <div class="inputcheckbox">
<input type="checkbox" id="1"><label for="1">  HB </label>&nbsp;&nbsp;
<input type="checkbox" id="2"><label for="2">  WBC </label>&nbsp;&nbsp;
<input type="checkbox" id="3"><label for="3">  Neutrophil </label>&nbsp;&nbsp;
<input type="checkbox" id="4"><label for="4">  Lymphocyte </label>&nbsp;&nbsp;
<input type="checkbox" id="5"><label for="5">  Monocyte </label>&nbsp;&nbsp;
<input type="checkbox" id="6"><label for="6">  Eosinophil </label>&nbsp;&nbsp;
<input type="checkbox" id="7"><label for="7">  RBS </label>&nbsp;&nbsp;
<input type="checkbox" id="8"><label for="8">  Urea </label>&nbsp;&nbsp;
</div>
<br>
<div class="inputcheckbox">
<input type="checkbox" id="9"><label for="9"> Creatinine </label>&nbsp;&nbsp;
<input type="checkbox" id="10"><label for="10"> S.GOT </label>&nbsp;&nbsp;
<input type="checkbox" id="11"><label for="11"> S.GPT </label>&nbsp;&nbsp;
<input type="checkbox" id="12"><label for="12"> Total Brilirubin </label>&nbsp;&nbsp;
<input type="checkbox" id="13"><label for="13"> Direct Brilirubin  </label>&nbsp;&nbsp;
<input type="checkbox" id="14"><label for="14"> A.S.O </label>&nbsp;&nbsp;
<input type="checkbox" id="15"><label for="15"> C.R.P </label>&nbsp;&nbsp;
<input type="checkbox" id="16"><label for="16">R.F</label>&nbsp;&nbsp;
</div>
<br>
<div class="inputcheckbox">
<input type="checkbox" id="17"><label for="17"> Widal Test Salmonella (O) </label>&nbsp;&nbsp;
<input type="checkbox" id="18"><label for="18">Widal Test Salmonella (H)</label>&nbsp;&nbsp;
<input type="checkbox" id="19"><label for="19">Widal Test Salmonella (A)</label>&nbsp;&nbsp;
<input type="checkbox" id="20"><label for="20">Widal Test Salmonella (B)</label>&nbsp;&nbsp;
<input type="checkbox" id="21"><label for="21"> Marijuana </label>&nbsp;&nbsp;
<input type="checkbox" id="22"><label for="22"> Amphetamin </label>&nbsp;&nbsp;
<input type="checkbox" id="23"><label for="23"> Cocaine </label>&nbsp;&nbsp;
<input type="checkbox" id="24"><label for="24"> Heroin </label>&nbsp;&nbsp;
</div>
<br>
<div class="inputcheckbox">
<input type="checkbox" id="25"><label for="25"> PT Patient </label>&nbsp;&nbsp;
<input type="checkbox" id="26"><label for="26">PTT Patient</label>&nbsp;&nbsp;
<input type="checkbox" id="27"><label for="27">INR</label>&nbsp;&nbsp;
<input type="checkbox" id="28"><label for="28">ESR</label>&nbsp;&nbsp;
<input type="checkbox" id="29"><label for="29">Malari</label>&nbsp;&nbsp;
<input type="checkbox" id="30"><label for="30">Cholestrol</label>&nbsp;&nbsp;
<input type="checkbox" id="31"><label for="31">Triglyceride</label>&nbsp;&nbsp;
<input type="checkbox" id="32"><label for="32">HDL</label>&nbsp;&nbsp;
</div>
<br>
<div class="inputcheckbox">
<input type="checkbox" id="33"><label for="33">LDL</label>&nbsp;&nbsp;
<input type="checkbox" id="34"><label for="34">Ca++</label>&nbsp;&nbsp;
<input type="checkbox" id="35"><label for="35">K+</label>&nbsp;&nbsp;
<input type="checkbox" id="36"><label for="36">Na+</label>&nbsp;&nbsp;
<input type="checkbox" id="37"><label for="37">H.pylorl</label>&nbsp;&nbsp;
<input type="checkbox" id="38"><label for="38">HIV</label>&nbsp;&nbsp;
<input type="checkbox" id="39"><label for="39">HBS-Ag</label>&nbsp;&nbsp;
<input type="checkbox" id="40"><label for="40">HCV</label>&nbsp;&nbsp;
</div>

<br>
       <input class="submitnew" type="submit" value="submit" name="sub">
</div>
</form>

</div>
      </main>
         


<footer class="footer">

</footer>

</body>
</html>