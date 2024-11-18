<?php include 'templats/header.php';
	include 'templats/navbar.php';
	?>
        
<?php

include '../includes/db.php';

 
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

        $pat_id=$_POST['pat_id'];
        
    if (empty($_POST["pat_id"])) {
      $Pat_note = "Name is required";
      echo $Pat_note ;
     }else {

      $r=mysqli_query($conn,"select * from invoice  where pat_id= $pat_id ");

      
     }
    




      }
          

$conn->close();

?>


       <main class="main">

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          
          <table id="mytable" cellspacing="15" cellpadding="0" >
          
          <tr>

            <td>
            <label for="no.p">  Patient No: <pre></pre></label>
            <input type="number" id="nosession" name="pat_id">
            </td>
          

          
              <td>
              <label for="no.p">Patient name: <pre></pre></label>
              </td>

              <td>
              <input type="submit" value="Submit" name="Submit_pation">
              </td>

          </tr>

          </table>


<table class="borderjalsa2" cellspacing="15" cellpadding="0" style="top:20%;" >

<?php 
  
  while($row =mysqli_fetch_array($r)){
   
    echo "<tr>";
    echo "<td> INVOICE ID : " .$row['invoice_id']."</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td> Patinte ID : " .$row['pat_id']."</td>";
    echo "<td>" .$row['name_ser']."</td>";
    echo "<td>".$row['cost_ser']."</td>";
    echo "<td>" .$row['invoice_date']."</td>";
    
      
    echo "</tr>";
    
}
  
   
?> 

</table>


   </form>
   </main>

      <footer class="footer" >   
            
      </footer>
</body>
</html>