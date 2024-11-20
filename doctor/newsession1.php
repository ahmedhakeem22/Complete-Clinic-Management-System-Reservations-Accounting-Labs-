<?php include 'includes/templates/header.php';
include 'includes/templates/navbar.php';
?>

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

 
    $pat_idd=0;
  if(isset($_POST['show_det'])){
$pat_id=$_POST['pat_id'];
 
    /////////////////////////search jqury users//////////////////////////

    $r=mysqli_query($conn,"select fname,phone from patinte where pat_id=$pat_idd ");





   
 



  }
  
    date_default_timezone_set("Asia/Aden");
$pat_date=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

   


        if(isset($_POST['addsess'])){


        
        $pat_id=$_POST['pat_id'];

       // $date_now=$_POST['date_now'];
        
        $date_pev=$_POST['date_pev'];

        $date_next=$_POST['date_next'];

        $main_com=$_POST['main_com'];

        $period_ill=$_POST['period_ill'];

        $sex_hist=$_POST['sex_hist'];

        $person_hist=$_POST['person_hist'];

        $curr_hist=$_POST['curr_hist'];

        $last_hist=$_POST['last_hist'];

        $fam_hist=$_POST['fam_hist'];

        $work_hist=$_POST['work_hist'];
       
       
        $basic_dig=$_POST['basic_dig'];

        $type_dig=$_POST['type_dig'];
        
        $diff_dig=$_POST['diff_dig'];

        $appear=$_POST['appear'];

        $behav=$_POST['behav'];

        $connscien=$_POST['conscien'];

        $mood=$_POST['mood'];

        $killer=$_POST['killer'];

        $thin_shep=$_POST['thin_shep'];

        $thin_con=$_POST['thin_con'];

        $percep=$_POST['percep'];

        $memory=$_POST['memory'];
            
            $ability=$_POST['ability'];

        $fores=$_POST['fores'];

        $degree=$_POST['degree'];

    if (empty($_POST["pat_id"])) {
      $Pat_fname = "id pation  is required";
      echo $Pat_fname;
     }else {
    
        $stmt = $conn->prepare("INSERT INTO session (pat_id,date_now,date_pev,date_next,main_com,period_ill,sex_hist,person_hist,curr_hist,last_hist,fam_hist,work_hist,basic_dig,type_dig,diff_dig,appear,behav,conscien,mood,killer,thin_shep,thin_con,percep,memory,ability,fores,degree)
        VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        
        $stmt->bind_param("sssssssssssssssssssssssssss",$pat_id,$pat_date,$date_pev,$date_next,$main_com,$period_ill,$sex_hist,$person_hist,$curr_hist,$last_hist,$fam_hist,$work_hist,$basic_dig,$type_dig,$diff_dig,$appear,$behav,$connscien,$mood,$killer,$thin_shep,$thin_con,$percep,$memory,$ability,$fores,$degree) ;
        $stmt->execute();
        /*
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        
        
        //echo "New records created successfully";
        $stmt->close();
            }
        
        */
        
        }
        
    
        }





   

$conn->close();
}
?>


       <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      <main >

          <div>

            <table class="table" cellspacing="15" cellpadding="0" >

<tr>
          <!--  
             <td> <label for="no.p">  ID session: </label>
            <input type="number" id="IDsession" name="IDsession">
            </td>
          --> 

         <!--   <td> <label for="no.p">  No. session: </label>
            <input type="number" id="nosession" name="No_session">
            </td>

      -->

              <td> <label for="no.p1">  No. Patient: </label>
                <input type="number"  name="pat_id">
                </td>



            <td>
            <label for="current"> The current session date: </label>
            <?php echo $pat_date; ?>    
            </td>

           <td>
              <label for="previous"> Date of the previous session: </label>
              <input type="date" id="previousdate" name="date_pev">     
            </td>
              

              <td>
                <label for="next"> Date of the next session: </label>
                <input type="date" id="nextdate" name="date_next">     
                </td>
</tr>
			  </table>
</div>

            
<table class="table" cellspacing="15" cellpadding="0" >


         
 <?php 
  if($pat_idd>0){
while($row =mysqli_fetch_array($r)){
 
    echo "<tr>";
  
    echo "<td>" .$row['fname']."</td>";
    
    echo "<td>" .$row['phone']."</td>";
   
   
      
    echo "</tr>";
    
    
    }
  }
 
?>
	<tr>
              <td>
            <label for="complaint"> The main complaint:</label>
            <textarea id="" cols="" rows="" name="main_com" ></textarea>
              </td>
              <td>
                <label for="illness"> The period of illness:</label>
                <textarea id="" cols="" rows="" name="period_ill"></textarea>
              </td>
  <td>
    <label for="Sexual"> Sexual history:</label>
    <textarea id="" cols="" rows="" name="sex_hist"></textarea>
  </td>
		
  
</tr>
            
             
<tr>
<td>
    <label for="Personal"> Personal history:</label>
    <textarea id="" cols="" rows="" name="person_hist"></textarea>
  </td>
  <td>
    <label for="disease"> History of the current disease:</label>
    <textarea id="" cols="" rows="" name="curr_hist"></textarea>
  </td>
  <td>
    <label for="last"> History of the last illness:</label>
    <textarea id="" cols="" rows="" name="last_hist"></textarea>
  </td>

  <td>
    <label for="family"> History of family illness:</label>
    <textarea id="" cols="" rows="" name="fam_hist"></textarea>
  </td>
  
	   
</tr>

<tr>
<td>
    <label for="work"> Date of work:</label>
    <textarea id="" cols="" rows="" name="work_hist" ></textarea>
  </td>
<td>
            <label for="Basic"> Basic diagnosis:</label>
            <textarea id="" cols="" rows="" name="basic_dig" ></textarea>
            </td>

            <td>
              <label for="type"> The type of disease:</label>
              <textarea id="" cols="" rows="" name="type_dig"></textarea>
</td>
            
  <td>
    <label for="Differential"> Differential diagnosis:</label>
    <textarea id="" cols="" rows="" name="diff_dig"></textarea>
  </td>

	
<tr>
<td><label style="text-align: center;" > Mental state examination :</label></td></tr>

  <td>
	  
    <label for="appearance"> The appearance:</label>
    <textarea id="" cols="" rows="" name="appear"></textarea>
  </td>

 
</tr>



<tr>
	 <td>
    <label for="behavior"> The behavior:</label>
    <textarea id="" cols="" rows="" name="behav"></textarea>
  </td>
  <td>
    <label for="Conscience"> Conscience:</label>
    <textarea id="" cols="" rows="" name="conscien" ></textarea>
  </td>

  <td>
    <label for="Mood">Mood:</label>
    <textarea id="" cols="" rows="" name="mood"></textarea>
  </td>

  <td>
    <label for="killing">Thoughts of 
		suicide or killing:</label>
    <textarea id="" cols="" rows="" name="killer"></textarea>
  </td>
 
	
</tr>


<tr>
   <td>
    <label for="Thinking">Thinking shape:</label>
    <textarea id="" cols="" rows="" name="thin_shep"></textarea>
  </td>

  <td>
    <label for="content">Thinking content:<pre></pre></label>
    <textarea id="" cols="" rows="" name="thin_con"></textarea>
  </td>
	
  <td>
    <label for="perception">Perception:</label>
    <textarea id="" cols="" rows="" name="percep"></textarea>
  </td>

  <td>
    <label for="Memory">Memory:</label>
    <textarea id="" cols="" rows="" name="memory"></textarea>
  </td>
  <td>
    <label for="judge">The ability to judge:</label>
    <textarea id="" cols="" rows="" name="ability"></textarea>
  </td>
</tr>

<tr>

  <td>
    <label for="Foresight">Foresight:<pre></pre></label>
    <textarea id="" cols="50" rows="5" name="fores"></textarea>
  </td>
  <td>
    <label for="degree">Folstein's degree:<pre></pre></label>
    <input type="number" id="degree" name="degree">
  </td>
</tr>

 
  



            </table>




            <input class="btn btn-success" type="submit" value="Add session" title="Add Session" name="addsess" >


             <input class="btn btn-success" name="btn" type="button" onclick="window.location.href='blood.php'" value="Blood" />
            <input class="btn btn-success" name="btn" type="button" onclick="window.location.href='blood.php'" value="Nafsi" />   
             <input class="btn btn-success" name="btn" type="button" onclick="window.location.href='blood.php'" value="Medical Description" />
              
      </main>
      </form>
      <footer class="footer">

        <div class="line">
          <h1 style="text-align: center;"> Dr. Omar Al-Khursani Clinic </h1>
    </div>

      </footer>

      

</body>





</html>

