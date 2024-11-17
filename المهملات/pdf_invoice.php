<html>
      <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" href="icon1.png" type="image/png" sizes="16x16">
            <link rel="stylesheet" type="text/css" href="style.css">
            <title> Report </title>
            <script src=""></script>
        </head>


<body> 
      <header class="header">

            <div class="navbar">
                  <a href="Home.php">Home</a>
                  <a href="News.php">News</a>
                  <a href="contact.php">Contact</a>
                  <a href="About.php">About</a>
                  <div class="dropdown">
                    <button class="dropbtn">User 
                      <i class="fa fa-caret-down"></i>
                    </button>
                    <div class="dropdown-content">
                      <a href="Doctor.php">Doctor</a>
                      <a href="login.php">Resiption</a>
                      <a href="nafsi.php">المختبـــر النفسي</a>
                      <a href="blood.php">مختبـــر الدم</a>
                      <a href="pharm.php">الصيدليــة </a>

                    </div>
                  </div> 
                </div>

      </header>
        
<?php


$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "najmdb";
///////////////

////
//////////////

 
// Create connection
$conn = new mysqli($servername, $username, $password ,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{

 
  /////////////////date system ///////////////////////
  date_default_timezone_set("Asia/Aden");
  $pat_date=   date("Y-m-d h:i:sa");               
  function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
  
  
  
      /////////////select from sestion be patione id //////////////
      if(isset($_POST['Submit_pation'])){


      $r=mysqli_query($conn,"select * from invoice  where name_ser  like 'book session' ");

      
     
    




      }
          



   

$conn->close();
}
?>


       <main class="main">

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          
          <table id="mytable" cellspacing="15" cellpadding="0" >
          
          <tr>

          

          
              <td>
              <label for="no.p"> طباعه فواتير الدم : <pre></pre></label>
              </td>

              <td>
              <input type="submit" value="طباعه" name="Submit_pation">
              </td>

          </tr>

          </table>




    
      



          <?php
require_once 'dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$pdf=new Dompdf(); 
ob_start();
?>

<table class="borderjalsa2" cellspacing="15" cellpadding="0" style="top:20%;" >

<?php 
  
  while($row =mysqli_fetch_array($r)){
   
    echo "<tr>";
    echo "<td>" .$row['invoice_id']."</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>" .$row['pat_id']."</td>";
    echo "<td>" .$row['name_ser']."</td>";
    echo "<td>".$row['cost_ser']."</td>";
    echo "<td>" .$row['invoice_date']."</td>";
    
      
    echo "</tr>";
    
}
  
   
?> 

</table>

<?php
$html=ob_get_clean();
$pdf->loadHtml($html);
$pdf->setPaper('A4','landscape');
$pdf->render();
$pdf->stream('result.pdf',Array('Attachment'=>0));
?>


   </form>
   </main>

      <footer class="footer" >   
            
      </footer>
</body>
</html>