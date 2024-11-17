
<?php

include '../includes/db.php';

// $servername = "127.0.0.1";
// $username = "root";
// $password = "root";
// $dbname = "najmdb";

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
  if(isset($_POST['select'])){
$pat_id=$_POST['pat_id'];
 
    $s=mysqli_query($conn,"select * from blood_test where pat_id=$pat_id");
  }

}


  if($pat_id>0){
while($row = mysqli_fetch_array($s)){
 
    echo "<tr>";
    echo "<td> djgdhgdjhg " .$row['pat_id']."</td>";
    echo "</tr>";
    
    
    }
  }
 
?>


    $conn->close();
?>
