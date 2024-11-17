




 <html>



      <head>
            <title></title>
            <meta http-equiv="Content-Type" content="text/html" charset="utf-8" >
            <meta name="viewport" content="width=device-width , initial-scale=1, shrink-to-fit=no">
            <link rel="icon" href="icon1.png" type="image/png" sizes="16x16">
            <link rel="stylesheet" type="text/css" href="style.css">
        </head>


<body> 

<?php

/*
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





   
   //////////////////////////////////////




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

        $conscien=$_POST['conscien'];

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
        
        $stmt->bind_param("sssssssssssssssssssssssssss",$pat_id,$pat_date,$date_pev,$date_next,$main_com,$period_ill,$sex_hist,$person_hist,$curr_hist,$last_hist,$fam_hist,$work_hist,$basic_dig,$type_dig,$diff_dig,$appear,$behav,$conscien,$mood,$killer,$thin_shep,$thin_con,$percep,$memory,$ability,$fores,$degree) ;
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
        
        
        
        }
        
    
        }
*/











   
 


/*

   

$conn->close();
}
*/
?>

      <header class="header" id="content">

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
                      <a href="#">Doctor</a>
                      <a href="login.php">Resiption</a>
                      <a href="#">المختبر النفسي</a>
                      <a href="#">مختبر الدم</a>
                    </div>
                  </div> 
                </div>

      </header>
      
      <main class="main">

        <img src="img/pic5.jpg" alt="image" width="100%" height="45%">
        
       









          <div>



          <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

            <table cellspacing="15" cellpadding="0" >

<tr>
          <!--  
             <td> <label for="no.p">  ID session: <pre></pre></label>
            <input type="number" id="IDsession" name="IDsession">
            </td>
          

            <td> <label for="no.p">  No. session: <pre></pre></label>
            <input type="number" id="nosession" name="No_session">
            </td>
-->
      
              <td> <label for="no.p1">  No. Patient: <pre></pre></label>
                <input type="number"  name="pat_id">
                </td>


            <td>
            <label for="current"> The current session date: <pre></pre></label>
            </td>

           <td>
              <label for="previous"> Date of the previous session: <pre></pre></label>
              <input type="date" id="previousdate" name="date_pev">     
            </td>
              

              <td>
                <label for="next"> Date of the next session: <pre></pre></label>
                <input type="date" id="nextdate" name="date_next">     
                </td>
</tr>

</div>

            </table>
<table cellspacing="15" cellpadding="0" >

<tr>
         
 
              <td>
            <label for="complaint"> The main complaint:<pre></pre></label>
            <textarea id="complaint" cols="" rows="" name="main_com" ></textarea>
              </td>
              <td>
                <label for="illness"> The period of illness:<pre></pre></label>
                <textarea id="" cols="" rows="" name="period_ill"></textarea>
              </td>
</tr>

              
<tr>
  <td>
    <label for="Sexual"> Sexual history:<pre></pre></label>
    <textarea id="" cols="" rows="" name="sex_hist"></textarea>
  </td>
  <td>
    <label for="Personal"> Personal history:<pre></pre></label>
    <textarea id="" cols="" rows="" name="person_hist"></textarea>
  </td>
</tr>
            
             
<tr>
  <td>
    <label for="disease"> History of the current disease:<pre></pre></label>
    <textarea id="" cols="" rows="" name="curr_hist"></textarea>
  </td>
  <td>
    <label for="last"> History of the last illness:<pre></pre></label>
    <textarea id="" cols="" rows="" name="last_hist"></textarea>
  </td>
</tr>

              
<tr>
  <td>
    <label for="family"> History of family illness:<pre></pre></label>
    <textarea id="" cols="" rows="" name="fam_hist"></textarea>
  </td>
  <td>
    <label for="work"> Date of work:<pre></pre></label>
    <textarea id="" cols="" rows="" name="work_hist" ></textarea>
  </td>
</tr>


<tr>

            <td>
            <label for="Basic"> Basic diagnosis:<pre></pre></label>
            <textarea id="" cols="" rows="" name="basic_dig" ></textarea>
            </td>

            <td>
              <label for="type"> The type of disease:</label>
              <textarea id="" cols="" rows="" name="type_dig"></textarea>
</td>
              <!--
            <select id="status" name="type" style="width: 110px;">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </td>
          -->
</tr>

<tr>

  <td>
    <label for="Differential"> Differential diagnosis:<pre></pre></label>
    <textarea id="" cols="" rows="" name="diff_dig"></textarea>
  </td>

</tr>

<tr>
  <td style="text-align: right;" > Mental state examination :</td>
</tr>

<tr>
  <td>
    <label for="appearance"> The appearance:<pre></pre></label>
    <textarea id="" cols="" rows="" name="appear"></textarea>
  </td>

  <td>
    <label for="behavior"> The behavior:<pre></pre></label>
    <textarea id="" cols="" rows="" name="behav"></textarea>
  </td>
</tr>



<tr>
  <td>
    <label for="Conscience"> Conscience:<pre></pre></label>
    <textarea id="" cols="" rows="" name="conscien" ></textarea>
  </td>

  <td>
    <label for="Mood">Mood:<pre></pre></label>
    <textarea id="" cols="" rows="" name="mood"></textarea>
  </td>
</tr>

<tr>
  <td>
    <label for="killing">Thoughts of suicide or killing:<pre></pre></label>
    <textarea id="" cols="" rows="" name="killer"></textarea>
  </td>
  <td>
    <label for="Thinking">Thinking shape:<pre></pre></label>
    <textarea id="" cols="" rows="" name="thin_shep"></textarea>
  </td>
</tr>


<tr>
  <td>
    <label for="content">Thinking content:<pre></pre></label>
    <textarea id="" cols="" rows="" name="thin_con"></textarea>
  </td>
  <td>
    <label for="perception">Perception:<pre></pre></label>
    <textarea id="" cols="" rows="" name="percep"></textarea>
  </td>
</tr>

<tr>
  <td>
    <label for="Memory">Memory:<pre></pre></label>
    <textarea id="" cols="" rows="" name="memory"></textarea>
  </td>
  <td>
    <label for="judge">The ability to judge:<pre></pre></label>
    <textarea id="" cols="" rows="" name="ability"></textarea>
  </td>
</tr>

  <td>
    <label for="Foresight">Foresight:<pre></pre></label>
    <textarea id="" cols="50" rows="5" name="fores"></textarea>
  </td>
  <td>
    <label for="degree">Folstein's degree:<pre></pre></label>
    <input type="number" id="degree" name="degree">
  </td>
</tr>


</tr>


            </table>




            <input class="submitjalsa" type="submit" value="Add session" title="Add Session" name="addsess" >
            </form>
            </div>
            <div>

             <form  action="Blood_ses_pdf.php" method="get">
       <h1>   pation id  :  <h1>
       <input type="number" id="Patinte" name="pat_id" >
       <h1> chosse the test bloode   <h1>
    
       <input type="checkbox" name="test[]" value="1" > test 1 <br/> 
       
       <input type="checkbox" name="test[]" value="2" > test 2 <br/> 

       <input type="checkbox" name="test[]" value="3" > test 3 <br/> 

       <input type="checkbox" name="test[]" value="4" > test 4 <br/> 

       <input type="checkbox" name="test[]" value="5" > test 5 <br/> 

       <input type="checkbox" name="test[]" value="6" > test 6 <br/> 
       
       <input type="checkbox" name="test[]" value="7" > test 7 <br/> 

       <input type="checkbox" name="test[]" value="8" > test 8 <br/> 

       <input type="checkbox" name="test[]" value="9" > test 9 <br/> 

       <input type="checkbox" name="test[]" value="10" > test 10 <br/> 

    
    <button type="submit"  aria-placeholder="Add" name="add_sess">Blood_ses_pdf
    
    </form>
    </div>
    <div>

            <form  action="Nafsi_ses_pdf.php" method="get">
       <h1>   pation id  :  <h1>
       <input type="number" id="Patinte" name="pat_id" >
       <h1> chosse the test bloode   <h1>
    
       <input type="checkbox" name="test[]" value="1" > test 1 <br/> 
       
       <input type="checkbox" name="test[]" value="2" > test 2 <br/> 

       <input type="checkbox" name="test[]" value="3" > test 3 <br/> 

       <input type="checkbox" name="test[]" value="4" > test 4 <br/> 

       <input type="checkbox" name="test[]" value="5" > test 5 <br/> 

       <input type="checkbox" name="test[]" value="6" > test 6 <br/> 
       
       <input type="checkbox" name="test[]" value="7" > test 7 <br/> 

       <input type="checkbox" name="test[]" value="8" > test 8 <br/> 

       <input type="checkbox" name="test[]" value="9" > test 9 <br/> 

       <input type="checkbox" name="test[]" value="10" > test 10 <br/> 

    
    <button type="submit"  aria-placeholder="Add" name="add_sess">Nafsi_ses_pdf
    
    </form>
    </div>
<br>
<br>
<br>


            <form  action="Medical_pdf.php" method="get"> 
            
            <textarea id="" cols="" rows="" name="Medical"> Medical Description
          </textarea>

            <button type="submit" id="add" aria-placeholder="Add" name="add_sess">Medical
             </form>



      </main>
    
      <footer >
<!--
        <div class="line">
          <h1 style="text-align: center;"> Dr. Omar Al-Khursani Clinic </h1>
  -->

      </footer>

      

</body>





</html>

