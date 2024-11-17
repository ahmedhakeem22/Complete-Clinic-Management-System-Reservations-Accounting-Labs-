<html>
<head>
<title> New Patient </title>
<title></title>
            <meta http-equiv="Content-Type" content="text/html" charset="utf-8" >
            <meta name="viewport" content="width=device-width , initial-scale=1, shrink-to-fit=no">
            <link rel="icon" href="icon1.png" type="image/png" sizes="16x16">
            <link rel="stylesheet" type="text/css" href="style.css">
            
            </head>
<body id="content"> 

<?php


$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "najmdb";

// Create connection
$conn = new mysqli($servername, $username, $password ,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{
  
    date_default_timezone_set("Asia/Aden");
$pat_date=   date("Y-m-d h:i:sa");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }



    /////////////////insert_patient//////////////////
    
        if(isset($_POST['add_pp'])){


        //$pat_pid=$_POST['pat_pid'];
        $Pat_fname=$_POST['Pat_fname'];
        //$pat_lname=$_POST['pat_lname'];
        
        $pat_age=$_POST['pat_age'];
        $pat_phon=$_POST['pat_phon'];
        $pat_gander=$_POST['pat_gander'];
        $pat_contry=$_POST['pat_contry'];
        $pat_city=$_POST['pat_city'];
        $Pat_sts=$_POST['Pat_sts'];
        $pat_chel=$_POST['pat_chel'];
        $pat_jop=$_POST['pat_jop'];
        $pat_prig=$_POST['pat_prig'];
        $pat_note=$_POST['pat_note'];
       
            

    if (empty($_POST["Pat_fname"])) {
      $Pat_fname = "Name is required";
      echo $Pat_fname;
     }else {
    
        $stmt = $conn->prepare("INSERT INTO patinte ( fname,age,phone,gander,contry,city,soc_sts,chel_num,jop,rig_pat,note_pat,date_com)
        VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?)");
        
        $stmt->bind_param("ssssssssssss",$Pat_fname,$pat_age,$pat_phon,$pat_gander,$pat_contry,$pat_city,$Pat_sts,$pat_chel,$pat_jop,$pat_prig,$pat_note,$pat_date) ;
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
        
      
        
        
        
        
        
           //////////////////////////////////////
        
        
          
           

    
/*
   if(isset($_POST['add_p'])){
    $usr1 = $_POST['Fname'];
$pas1 = $_POST['country'];
$stmt = $conn->prepare("INSERT INTO users (user_id, password)
VALUES (?, ?)");

$stmt->bind_param("ss",$usr1,$pas1) ;
$stmt->execute();
/*
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
*/

/*
echo "New records created successfully";
$stmt->close();
}*/
    $conn->close();





}
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
            <a href="Doctor.php">Doctor</a>
            <a href="login.php">Resiption</a>
            <a href="#">المختبر النفسي</a>
            <a href="#">مختبر الدم</a>
          </div>
        </div> 
      </div>


</header>
<form  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
<main class="main" id="content" >




<img src="img/newfile.jpg" alt="image" width="100%" height="45%">

<div id="content" class="bordernew" >

        <button class="buttondelete" onclick="document.getElementById('myInput').value =''">Clear input field</button> 

   <table class="tablenew1" cellspacing="20" cellpadding="0"  >
        <tr>
            <td> <label for="no.p"> No.Patient: <pre></pre></label>
     <input type="number" id="nopateint" name="pat_pid">
    </td>
<td><label for="lname"> Full Name: <pre></pre></label>
    <input type="text" id="Full Name" name="Pat_fname" required>
</td>  
<td><label for="age"> Age:<pre></pre></label>
<input type="number" id="age" name="pat_age"></td>
<td><label for="mobile"> Mobile:<pre></pre></label>
    <input type="number" id="mobile" name="pat_phon"></td>
    
</tr>
        <tr>
            <td><label for="country"> Country:<pre></pre></label>
                <input type="text" id="country" name="pat_contry"></td>
            <td><label for="city"> City:<pre></pre></label>
        <input type="text" id="city" name="pat_city"></td>
        <td>
            <label for="status"> Social status:</label>
            <select id="status" name="Pat_sts" style="width: 110px;">
                <option value="Married">Married</option>
                <option value="Unmarried">Unmarried</option>
                <option value="absolute">absolute</option>
                <option value="Widower">Widower</option>
              </select>
        </td>
    <td>
        <label for="gender"> Gender:</label>
        <select id="gender" name="pat_gander" style="width: 155px;">
            <option value="M">Male</option>
            <option value="F">Female</option>
          </select>

        
    </td>
       
            
    </tr>
    <tr>
        <td><label for="no.p"> No.Children:<pre></pre></label>
            <input type="number" id="nochild" name="pat_chel"></td>
        <td>    <label for="jop"> Jop:<pre></pre></label>
            <input type="text" id="jop" name="pat_jop"></td>
        <td>    <label for="Religion"> Religion:<pre></pre></label>
        <input type="text" id="religion" name="pat_prig"></td>
        <td>   <label for="birthdaytime">Date:<pre></pre></label>
            <input type="date" id="date" name="birthdaytime"></td>
                
    </tr>  
    
    <tr>
        <td colspan="1">
            <label for="w3mission">Notes:<pre></pre></label>
            <textarea id="Notes" name="pat_note" style="font-size:17px; resize:none;text-align:start; width:100%; height:auto; background-color: rgb(246, 246, 246); scroll-behavior: auto; " id="detail" rows="5" cols="50">
            </textarea> 
        </td>
        


         <button class="submitnew" type="submit" value="submit" name="add_pp"> Save <button/>
         

<tr/>
        
            
   

        
        
        
    
</div>

</main>
     </form>

<footer class="footer" id="content" >
    
    <div class="line">

        <h1 style="text-align: center;"> Dr. Omar Al-Khursani Clinic </h1>

  </div>

  
</footer>

</body>





</html>

