<?php 

include'includes/db.php';


$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "najmdb";

$mysqli = new mysqli($servername, $username, $password ,$dbname);



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


$s = "INSERT INTO mediciness (name_med,name_chemical,company,type,parcode) VALUES ";
for ($i = 0; $i < $_POST['numbers'] ; $i++) { 
    $s .="('".$_POST['name_med'][$i]."','".$_POST['name_chemical'][$i]."','".$_POST['company'][$i]."','".$_POST['type'][$i]."','".$_POST['parcode'][$i]."'),";
}

$s = rtrim($s,",");
if (!$mysqli->query($s))
echo $mysqli->error;
else 
echo "<script>alert('medicines has been inserted successfully')</script>";

    $mysqli->close();

?>
