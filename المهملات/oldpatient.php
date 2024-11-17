<html>

<head>
    <title>Old Patient</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="icon1.png" type="image/png" sizes="16x16">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title> Home </title>
    <script src=""></script>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js">></script>
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

 
    /////////////////////////search jqury users//////////////////////////

    $r=mysqli_query($conn,"select pat_id,fname,age,phone,gander from patinte ");





   
   //////////////////////////////////////




   

$conn->close();
}
?>
 
  <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <main class="main">


          <img src="img/oldimg.jpg" alt="image" width="100%" height="45%">
          <div class="">
     
        <!-- <button class="buttondelete" onclick="document.getElementById('myInput').value =''">Clear input field</button>  -->  
     
      <!--    <table class="tablenew1" cellspacing="20" cellpadding="0"  >
          <tr>
     
            <td> <label for="no.p"> No.Patient: <pre></pre></label>
              <input type="number" id="No.Patient" name="No.">
             </td>
         <td><label for="lname"> Full Name: <pre></pre></label>
             <input type="text" id="Full Name" name="Fname">
        </td>  
        <td><label for="age"> Age:<pre></pre></label>
         <input type="number" id="Age" name="Age"></td>
         <td><label for="mobile"> Mobile:<pre></pre></label>
             <input type="number" id="Mobile" name="Mobile"></td>
             
     </tr>
         
                 <tr>
                     <td><label for="country"> Country:<pre></pre></label>
                         <input type="text" id="Country" name="country"></td>
                     <td><label for="city"> City:<pre></pre></label>
                 <input type="text" id="City" name="city"></td>
                 <td>
                     <label for="status"> Social status:</label>
                     <select id="Social status" name="status" style="width: 110px;">
                         <option value="Married">Married</option>
                         <option value="Unmarried">Unmarried</option>
                         <option value="absolute">absolute</option>
                         <option value="Widower">Widower</option>
                       </select>
                 </td>
             <td>
                 <label for="gender"> Gender:</label>
                 <select id="Gender" name="gender" style="width: 155px;">
                     <option value="Male">Male</option>
                     <option value="Female">Female</option>
                   </select>
     
                 
             </td>
                
                     
             </tr>
             <tr>
                 <td><label for="no.p"> No.Children:<pre></pre></label>
                     <input type="number" id="No.Children" name="No."></td>
                 <td>    <label for="jop"> Jop:<pre></pre></label>
                     <input type="text" id="Jop" name="jop"></td>
                 <td>    <label for="Religion"> Religion:<pre></pre></label>
                 <input type="text" id="Religion" name="religion"></td>
                 <td>   <label for="birthdaytime">Date and Time:<pre></pre></label>
                     <input type="datetime-local" id="Date and Time" name="birthdaytime"></td>
                         
             </tr>  
             <tr>
                 
                 <td colspan="4" title=" Registrar Notes ">    <label for="w3mission">Details:<pre></pre></label>
     
                     <textarea id="Details" style="text-align:justify; width: 950px; height:50px; background-color: rgb(246, 246, 246); scroll-behavior: auto; " id="detail" rows="50" cols="100">
     
                     </textarea> </td>
                     
             </tr>
         
             <form action="/action_page.php">
                <label class="search" for="gsearch">Search:</label>
                <input class="searchin" type="search" id="dsearch" name="gsearch">
                <input class="searchsub" type="submit">
              </form>
                 <input class="submitnew" type="submit" value="Submit">

                </div>
                --> 


                
                <h1 class="h1img2" > Old Patient </h1>
<input style="text-align: center; " type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Names.." title="Type in a name">

<table id="myTable">
  <tr class="header">
    <th style="width:3%;"> ID </th>
    <th style="width:13%;"> Full Name </th>
    <th style="width:2%">Age</th>
    <th style="width: 9%;">Mobile</th>
    <th style="width: 5%;" >Gender</th>
    <th style="width: 7%;" >country</th>
    <th style="width: 5% ;" >City</th>
    <th style="width: 10%;" >Social status</th>
    <th style="width: 7%;" >No.Children</th>
    <th style="width: 7% ;" >Jop</th>
    <th style="width: 8%;" >Religion</th>
    <th style="width: 10%;" >Date and Time</th>
    <th style="width: 8% ;" > Details </th>
  </tr>

  <?php 
  
while($row =mysqli_fetch_array($r)){
 
    echo "<tr>";
    echo "<td>" .$row['pat_id']."</td>";
    echo "<td>" .$row['fname']."</td>";
    echo "<td>".$row['age']."</td>";
    echo "<td>" .$row['phone']."</td>";
    echo "<td>" .$row['gander']."</td>";
   
      
    echo "</tr>";
    
    
    }

 
?>
 
  
</table>



<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
    $("#myTable tr:first").show();
  });
});
</script>
                



    </main>
      
   </form>
                



      
   
            
           <footer class="footer">


           </footer> 
        
   


</body>





</html>

