<html>
      <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" href="icon1.png" type="image/png" sizes="16x16">
            <link rel="stylesheet" type="text/css" href="style.css">
            <title> Book a session </title>
            <script src=""></script>
        </head>


<body> 

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
// mysqli_select_db($conn,"najmdb"); //

    date_default_timezone_set("Asia/Aden");
$pat_date=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }




$pat_id=0;
  if(isset($_POST['ok'])){
$pat_id=$_POST['pat_id'];
 
    /////////////////////////search jqury users//////////////////////////

    $r=mysqli_query($conn,"select fname,phone from patinte where pat_id=$pat_id ");




   
   //////////////////////////////////////




  }
if(isset($_POST['add_sess'])){
$pat_id=$_POST['pat_id'];
$name_ser="book session";
$cost_ser=3000;
$stmt = $conn->prepare("INSERT INTO invoice ( pat_id ,name_ser,cost_ser,invoice_date)
        VALUES (?,?,?,? )");
        
        $stmt->bind_param("ssss",$pat_id,$name_ser,$cost_ser,$pat_date) ;
        $stmt->execute();


       require 'C:\xampp\htdocs\fpdf.php';
      mysqli_select_db($conn,"najmdb");




        $pdf =new FPDF('p','mm','A4','UTF-8');
        $pdf-> AddPage();
      
        $pdf->SetFont('times','B',14);
      
      
        $pdf->Image('pic2.jpg',10,2,40);
        $pdf->Ln(18);
        
        $pdf->Cell(28,8,'najm_web',1,0,'C',0);
        
        $pdf->Cell(100,8,'',0,0,'C',0);
        
        $pdf->Cell(14,8,'date:',1,0,'C',0);
        
        $pdf->Cell(28,8,$pat_date,1,1,'C',0);
        $pdf->Ln();
        $pdf->Ln();
      
        
      $pdf->Cell(28,8,'id number:',1,0,'C',0);
      $pdf->Cell(20,8,$pat_id,'B',0,'C',0);
      
      $pdf->Cell(15,8,'name service :',1,0,'C',0);
      $pdf->Cell(100,8,$name_ser,'B',0,'C',0);
      
      
      $pdf->Cell(14,8,'close service :',1,0,'C',0);
      $pdf->Cell(10,8,$cost_ser,'B',1,'C',0);
      $pdf->Ln();
      $pdf->Ln();
      
      
      $pdf->Output();
      
    


}
$conn->close();
}
?>
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
       <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

      <main class="main">

      
           
                  <img src="booksession.jpg" alt="image" width="100%" height="auto">


<table cellspacing="15" cellpadding="0" >
<tr>
 
    <th> Patinte No. </th>
    
</tr>

<tr>
 
    <td> <input type="number" id="Patinte" name="pat_id" >  </td>
    
    <td> <button type="submit" id="add" aria-placeholder="Add" name="add_sess"> Book a Session </td>
    <td> <button type="submit" id="deleate" aria-placeholder="deleate" name="ok" > Delate </td>





</tr>
 <?php 
  if(isset($_POST['ok'])){
  if($pat_id>0){
while($row =mysqli_fetch_array($r)){
 
    echo "<tr>";
  
    echo "<td>" .$row['fname']."</td>";
    
    echo "<td>" .$row['phone']."</td>";
   
   
      
    echo "</tr>";
    
    
    }
  }
  }
?>
</table>




      </main>

</form>
      <footer class="footer">

        <!--
<p id="demo"></p>

            <script>
            var d = new Date();
            document.getElementById("demo").innerHTML = d;
            </script>
        -->    
            

      </footer>

      

</body>





</html>

