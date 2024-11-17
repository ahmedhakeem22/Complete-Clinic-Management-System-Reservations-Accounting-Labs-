
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

if(isset($_GET['pat_id'])){

         $pat_idd=0;
  if(isset($_GET['Submit_pation'])){
$pat_idd=$_GET['pat_idd'];
     $r=mysqli_query($conn,"select fname,age,gander,phone from patinte where pat_idd=$pat_idd");
  }





          
  if($pat_idd>0){
while($row =mysqli_fetch_array($r)){
 
    echo "<tr>";
    echo "<td> Name : " .$row['fname']."</td>";
      echo "<td> Age : " .$row['age']."</td>";
        echo "<td> Gander : " .$row['gander']."</td>";
          echo "<td> Phone : " .$row['phone']."</td>";
    echo "</tr>";
    
    
    }
  }
 
}

    $conn->close();


  ?>