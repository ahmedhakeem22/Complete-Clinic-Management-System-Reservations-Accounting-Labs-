<html>
<head>
<head>
      <title> Today's dates </title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="icon" href="icon1.png" type="image/png" sizes="16x16">
      <link rel="stylesheet" type="text/css" href="style.css">
      <title> Home </title>
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

$conn->close();
}
?>

<header class="header">


</header>

<div class="navbar">
      <a href="Home.html">Home</a>
      <a href="News.html">News</a>
      <a href="contact.html">Contact</a>
      <a href="About.html">About</a>
      <div class="dropdown">
        <button class="dropbtn">User 
          <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
          <a href="#">Doctor</a>
          <a href="login.html">Resiption</a>
          <a href="#">المختبر النفسي</a>
          <a href="#">مختبر الدم</a>
        </div>
      </div> 
    </div>

<main  class="main">
 <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">



      
      <div>
            <img src="img/today.jpg" alt="image" width="100%" height="45%">

      </div>


   
<table id="myTable">
      <tr class="header">
        <th style="width:3%;"> ID </th>
        <th style="width:13%;"> Full Name </th>
        <th style="width:2%">Age</th>
        <th style="width: 9%;">Mobile</th>
        <th style="width: 5%;" >Gender</th>
        <th style="width: 10%;" >Social status</th>
        <th style="width: 7%;" >No.Children</th>
        <th style="width: 10%;" >Date and Time</th>
      </tr>
    
      <tr>
            <td> 1 </td>
            <td>radfan sadek abdullah alkamel</td>
            <td>21</td>
            <td>738946710</td>
            <td>male</td>
            <td>Yemen</td>
      </tr>
      
    </table>
    
    <script>
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("myTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }
    }
    </script>


</main>

</form>

<footer class="footer">



</footer>

</body>
</html>