<?php include 'templats/header.php';
	include 'templats/navbar.php';
	?>
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
$date=   date("Y-m-d");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

 
if (isset($_GET['select'])) {
        $Date1= $_GET['Date1'];
                $Date2= $_GET['Date2'];



    $s=mysqli_query($conn,"SELECT * FROM buy_invpice WHERE date_buy between '$Date1' and '$Date2' ")
    or die("Error: " . mysqli_error($conn));
    }
    $conn->close();
}
?>

<main>


                  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">

          <table class="table table-striped table-bordered table-hover table-active  " cellspacing="0" cellpadding="0" style="margin:0px;">
<tr>
<td>
      <label class=" form-control  " style="background-color:gray;" > <strong style="color:white;" > بحث بين تاريخين </strong> </label>
</td>
      <td>
      <input type="date" name="Date1" class=" form-control"/>
      </td>
      <td>
      <input type="date" name="Date2" class=" form-control"/>
      </td>
      <td>
            <input type="submit" name="select" class="btn btn-info form-control  btn-block"/>
      </td>
      <td>
                   <input class="btn btn-danger form-control glyphicon glyphicon-circle-question " name="btn" type="button" onclick="window.location.href='ser.php'" title=" مساعــدة " value=" Help " />
      </td>
      </tr>
      </table>

<div class="table-responsive" >
<table id="myTable" class="table table-striped table-bordered table-hover table-active  " cellspacing="0" cellpadding="0">
  <tr class="header">
    <th style="width:10%; text-align:center; "> اســم العــلاج </th>
    <th style="width:10%; text-align:center; "  >الاســم العلمي  </th>
    <th style="width: 10%; text-align:center; ">الكمية</th>
        <th style="width: 10%; text-align:center; ">عدد الوحدات</th>
    <th style="width:10%; text-align:center; " >تاريخ الانتاج</th>
    <th style="width:10%; text-align:center; " >تاريخ الانتهاء</th>
            <th style="width:10%; text-align:center; " >تاريخ الشــراء</th>
        <th style="width:10%; text-align:center; " >سعر الشراء</th>
        <th style="width:10%; text-align:center; " > اسم الشركة</th>
                <th style="width:10%; text-align:center; " > اسم المندوب</th>
                              <!--  <th style="width:10%; text-align:center; " > <a href="edit_buy.php"> خصائص </a> </th> -->
</tr>
<tr>
                <?php
                
if (isset($_GET['select'])) {
       $Date1 = $_GET['Date1'];
                $Date2 = $_GET['Date2'];

        while ($row = mysqli_fetch_array($s)) {

            echo  "<tr>";
            echo "<td >" .$row['name_med']. "</td>";
            echo "<td >" . $row['name_sinc'] . "</td>";
            echo "<td >" . $row['countity'] . "</td>";
            echo "<td >" . $row['num_bact'] . "</td>";
            echo "<td >" . $row['date_do'] . "</td>";
            echo "<td >" . $row['expired_date'] . "</td>";
                        echo "<td>" .$row['date_buy']."</td>";
            echo "<td >" . $row['buy_price'] . "</td>";
            echo "<td >" . $row['copny_name'] . "</td>";
            echo "<td >" . $row['delegate'] . "</td>";
          /*  echo ("<td><a href=\"edit_buy.php?id=$row[id_invoice]name=\"edit\">Edit</a></td>"); */
            echo "</tr>";
}
}
?>
</tr>
</table>
      </form>
</main>
