<?php include 'includes/templates/header.php';
	include 'includes/templates/navbar.php';
	?>
<?php

include '../includes/db.php';

  
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

?>
<body> 

<header>


</header>


<main>
 <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">



      
      <div>
            <img src="includes/images/today.jpg" alt="image" width="100%" height="45%">

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

<footer>



</footer>

</body>
