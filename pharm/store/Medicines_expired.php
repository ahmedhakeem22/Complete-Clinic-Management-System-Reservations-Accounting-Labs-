<?php include 'templats/header.php';
	include 'templats/navbar.php';
	?>
 
<?php


$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "najmdb";

 

$conn = new mysqli($servername, $username, $password ,$dbname);

date_default_timezone_set("Asia/Aden");
$date=   date("y-m-d");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
  mysqli_select_db($conn,"najmdb");
 
    $r=mysqli_query($conn,"SELECT name_med,name_sinc,countity,num_bact,date_do,expired_date,date_buy,buy_price,copny_name,delegate FROM buy_invpice WHERE expired_date < '$date' ");
      //  $r=mysqli_query($conn,"SELECT name_med,name_sinc,countity,num_bact,date_do,expired_date,date_buy,buy_price,copny_name,delegate,DATE_ADD(expired_date,INTERVAL 1 DAY ) AS SubtractDate FROM buy_invpice  ");

   

$conn->close();
}
?>

<main>

      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
      <div class="table-responsive" >
      <table class="table table-striped table-bordered table-hover table-active  " cellspacing="0" cellpadding="0" style="margin:0px;">
      <tr>
      <td>
      <label style="background-color:#FF0000; text-align:center; font-size:25px; " class=" form-control  " > <strong style="color:white;" > الأدويـــة المنتهيـــة </strong> </label>
      </td>
      
      </tr>
      <tr>
      <td>
      <input style="text-align:center;"  type="input" id="myInput" onkeyup="myFunction()" placeholder="Search .." title="البحــث عــن عـــلاج" class="form-control" />
      </td>
      </tr>
</table>
</div>
<div class="table-responsive" >
<table id="myTable" class="table table-striped table-bordered table-hover table-active  " cellspacing="0" cellpadding="0">
  <tr class="header">
    <th style="width:10%; text-align:center; "> اســم العــلاج </th>
    <th style="width:10%; text-align:center; "  >الاســم العلمي  </th>
    <th style="width: 10%; text-align:center; ">الكمية</th>
        <th style="width: 10%; text-align:center; ">عدد الوحدات</th>
    <th style="width:10%; text-align:center; " >تاريخ الانتاج</th>
    <th style="width:10%; text-align:center; " >تاريخ الانتهاء</th>
        <th style="width:10%; text-align:center; " >تاريخ الشراء</th>
        <th style="width:10%; text-align:center; " >سعر الشراء</th>
        <th style="width:10%; text-align:center; " > اسم الشركة</th>
                <th style="width:10%; text-align:center; " > اسم المندوب</th>
  </tr>
<tr>


  <?php 
  
while($row =mysqli_fetch_array($r)){
 
    echo "<tr>";
    echo "<td>" .$row['name_med']."</td>";
    echo "<td>" .$row['name_sinc']."</td>";
    echo "<td>".$row['countity']."</td>";
    echo "<td>" .$row['num_bact']."</td>";
    echo "<td>" .$row['date_do']."</td>";
    echo "<td>" .$row['expired_date']."</td>";
        echo "<td>" .$row['date_buy']."</td>";
    echo "<td>" .$row['buy_price']."</td>";
    echo "<td>" .$row['copny_name']."</td>";
    echo "<td>" .$row['delegate']."</td>";

      
    echo "</tr>";
    
    
    }

 
?>

</tr>
</table>
</div>
          </form>

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
function myFunction() {
  const filter = document.querySelector('#myInput').value.toUpperCase();
  const trs = document.querySelectorAll('#myTable tr:not(.header)');
  trs.forEach(tr => tr.style.display = [...tr.children].find(td => td.innerHTML.toUpperCase().includes(filter)) ? '' : 'none');
}
</script>       



</main>

     

<footer>


</footer>

<script src="js/jquery-3.4.1.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
    <script src="js/fontawesome.min.js"></script> 
        <script src="js/myjs.js."></script> 