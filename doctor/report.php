<html>
      <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="icon" href="icon1.png" type="image/png" sizes="16x16">
            <link rel="stylesheet" type="text/css" href="style.css">
            <title> Report of session </title>
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

        $pat_id=$_POST['pat_id'];
        
    if (empty($_POST["pat_id"])) {
      $Pat_note = "Name is required";
      echo $Pat_note ;
     }else {

      $r=mysqli_query($conn,"select * from session where pat_id= $pat_id ");

      
     }
    




      }
          



   

$conn->close();
}
?>


       <main class="main">

                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
          
          <table id="mytable" cellspacing="15" cellpadding="0" >
          
          <tr>

            <td>
            <label for="no.p">  Patient No: <pre></pre></label>
            <input type="number" id="nopatent" name="pat_id">
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

<tr>

            <td>
            <label for="current"> The current session date: <pre></pre></label>
            </td>

          <td>
          <label for="previous"> Date of the previous session: <pre></pre></label>
          </td>
              

              <td>
              <label for="next"> Date of the next session: <pre></pre></label>
              </td>  

</tr>
<tr>
 <td>
 <label for="complaint"> The main complaint:<pre></pre></label>
 </td>
              <td>
              <label for="illness"> The period of illness:<pre></pre></label>
              </td>
              <td>

  <label for="Sexual"> Sexual history:<pre></pre></label>
  </td>
  </tr>
<tr>
 <td>
 <label for="Personal"> Personal history:<pre></pre></label>
 </td>            
 <td>
 <label for="disease"> History of the current disease:<pre></pre></label>
 </td>
 <td>
 <label for="last"> History of the last illness:<pre></pre></label>
  </td>
</tr>

              
<tr>
  <td>
    <label for="family"> History of family illness:<pre></pre></label>
  </td>
  <td>
    <label for="work"> Date of work:<pre></pre></label>
  </td>

  <td>
  <label for="Basic"> Basic diagnosis:<pre></pre></label>
  </td>

  </tr>

<tr>

  <td>
  <label for="type"> The type of disease:</label>
   </td>

<td>
<label for="Differential"> Differential diagnosis:<pre></pre></label>
</td>

</tr>
<tr>
<td style="text-align: right; color:red;" > Mental state examination :</td>
</tr>

<tr>
  <td>
  <label for="appearance"> The appearance:<pre></pre></label>
</td>

  <td>
    <label for="behavior"> The behavior:<pre></pre></label>
  </td>
  <td>
    <label for="Conscience"> Conscience:<pre></pre></label>
  </td>
</tr>


<tr>
  
  <td>
    <label for="Mood">Mood:<pre></pre></label>
  </td>

  <td>
    <label for="killing">Thoughts of suicide or killing:<pre></pre></label>
  </td>
  <td>
    <label for="Thinking">Thinking shape:<pre></pre></label>
  </td>
  </tr>

  
<tr>
  <td>
    <label for="content">Thinking content:<pre></pre></label>
  </td>
  <td>
    <label for="perception">Perception:<pre></pre></label>
  </td>
  <td>
    <label for="Memory">Memory:<pre></pre></label>
  </td>
</tr>

<tr>
<td>
    <label for="judge">The ability to judge:<pre></pre></label>
  </td>
  <td>
    <label for="Foresight">Foresight:<pre></pre></label>
  </td>
  <td>
    <label for="degree">Folstein's degree:<pre></pre></label>
  </td>
</tr>

<tr>
  <td style="text-align: right;" > فحص الدم :</td>    
</tr>
<tr>
    <td style="text-align: right;" > نتيجة الفحص :</td>
        <td style="text-align: right;" > نتيجة الفحص :</td>    
</tr>


<tr>
  <td style="text-align: right;" > الفحص النفسي :</td>
</tr>

<tr>
    <td style="text-align: right;" > نتيجة الفحص :</td>
        <td style="text-align: right;" > نتيجة الفحص :</td>    
</tr>


<tr>
<td>
<input type="submit" value="Submit" name="Submit">
 </td>
</tr>




          <?php 
  
  while($row =mysqli_fetch_array($r)){
   


    echo "<tr>";
    echo "<td>  Session ID :  "  .$row['id_session']. "</td>";
    echo "<tr>";
    echo "<td>" .$row['date_pev']."</td>";
    echo "<td>" .$row['date_next']."</td>";
    echo "<td>".$row['main_com']."</td>";
    echo "</tr>";
    echo "<tr>";

    echo "<td>" .$row['period_ill']."</td>";
    echo "<td>" .$row['sex_hist']."</td>";
    echo "<td>" .$row['person_hist']."</td>";
      
    echo "</tr>";
    
    echo "<tr>";
    echo "<td>" .$row['curr_hist']."</td>";
    echo "<td>" .$row['last_hist']."</td>";
    echo "<td>".$row['fam_hist']."</td>";

    echo "</tr>";
    echo "<tr>";
    echo "<td>" .$row['work_hist']."</td>";
    echo "<td>" .$row['basic_dig']."</td>";
    echo "<td>" .$row['type_dig']."</td>";
      
    echo "</tr>";
    
    echo "<tr>";
    echo "<td>" .$row['diff_dig']."</td>";
    echo "<td>" .$row['appear']."</td>";
    echo "<td>".$row['behav']."</td>";


    echo "</tr>";
    echo "<tr>";
    echo "<td>" .$row['conscien']."</td>";
    echo "<td>" .$row['mood']."</td>";
    echo "<td>" .$row['killer']."</td>";
      
    echo "</tr>";
     
    
    echo "<tr>";
    echo "<td>" .$row['thin_shep']."</td>";
    echo "<td>" .$row['thin_con']."</td>";
    echo "<td>".$row['percep']."</td>";

    echo "</tr>";
    echo "<tr>";
    echo "<td>" .$row['memory']."</td>";
    echo "<td>" .$row['ability']."</td>";
    echo "<td>" .$row['fores']."</td>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>" .$row['degree']."</td>";
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