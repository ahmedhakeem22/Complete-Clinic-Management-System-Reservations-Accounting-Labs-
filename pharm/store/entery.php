<?php
  include '../../includes/db.php';


$mysqli = new mysqli($servername, $username, $password ,$dbname);
$num_rand=rand(100,1000000);
 date_default_timezone_set("Asia/Aden");
$date=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }



if ($mysqli->connect_errno)
    die("Connection failed: " .$mysqli->connect_error);
 

$s = "INSERT INTO mediciness (name_med,name_chemical,company,delegate) VALUES ";
for ($i = 0; $i < $_POST['numbers'] ; $i++) { 
    $s .="('".$_POST['name_med'][$i]."','".$_POST['name_chemical'][$i]."','".$_POST['company'][$i]."','".$_POST['delegate'][$i]."'),";

}

  
$s = rtrim($s,",");
if (!$mysqli->query($s)){
echo $mysqli->error;
}
else{
    echo "<script>alert(' تم ادخال الادوية الى المخزن بنجاح ')</script>";
    echo "<script>window.open('pageentry.php','_self')</script>";
  }
$mysqli->close();
?>