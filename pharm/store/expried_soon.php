 
<?php


$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "najmdb";

 

$conn = new mysqli($servername, $username, $password ,$dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
  mysqli_select_db($conn,"najmdb");
 
    $r=mysqli_query($conn,"SELECT name_med,name_sinc,countity,num_bact,date_do,expired_date,date_buy,buy_price,copny_name,delegate,DATE_SUB(expired_date,INTERVAL 90 DAY) AS SubtractDate FROM buy_invpice  ");
   

$conn->close();
}
?>
