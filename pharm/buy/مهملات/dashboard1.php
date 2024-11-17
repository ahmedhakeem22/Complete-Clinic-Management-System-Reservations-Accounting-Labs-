
<?php 
include'templats/header.php';
include'templats/navbar.php';
include'includes/db.php';
?>


<?php

    date_default_timezone_set("Asia/Aden");
$date=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }


if(isset($_POST['submit'])){

$delegate = $_POST['delegate'];

$name_med = $_POST['name_med'];

$countity = $_POST['countity'];


$expired_date = $_POST['expired_date'];


$sale_price = $_POST['sale_price'];
$buy_price = $_POST['buy_price'];


$insert_med = "INSERT INTO buy_invpice(date_buy,delegate,name_med,countity,expired_date,sale_price,buy_price) values ('$date','$delegate','$name_med','$countity','$expired_date','$sale_price','$buy_price')";    


$run_video = mysqli_query($con,$insert_med);

if($run_video){

echo "<script>alert('medicines has been inserted successfully')</script>";

echo "<script>window.open('index.php','_self')</script>";

}

}

?>
 
 
<?php
 
    $r=mysqli_query($con,"select id_med,name_med,opcity,parcode from mediciness");


?>





<div class="row medinsert"><!-- 2 row Starts --> 

<div class="col-lg-6"><!-- col-lg-12 Starts -->

<div class="panel panel-default"><!-- panel panel-default Starts -->

<div class="panel-body"><!-- panel-body Starts -->

<form class="form-horizontal" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->


<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > اسم العلاج </label>
                
<input style="text-align: center; " name="name_med" type="input" id="myInput" onkeyup="myFunction()" placeholder="Search for Patinte.." title="Type in a name">

<table  id="myTable">
  <tr class="header">
    <th style="width:1%;"> رقم العلاج </th>
    <th style="width:1%;"> اسم العلاج  </th>
    <th style="width:1%;">الكمية بالوحدة</th>
    <th style="width:2%;">الرقم التسلسلي</th>
    
   
  </tr>

  <?php 
  
while($row =mysqli_fetch_array($r)){
 
    echo  "<tr>";
    echo "<td>" .$row['id_med']."</td>";
        echo "<td>" .$row['name_med']."</td>";
    echo "<td>" .$row['opcity']."</td>";
        echo "<td>" .$row['parcode']."</td>";
    echo "</tr>";
    
    
    }

 
?>
  
</table>



         <script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
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



</table>



<div class="col-md-6" >
</div>

</div><!-- form-group Ends -->


<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > الكمية </label>

<div class="col-md-6" >

<input type="number" name="countity" class="form-control" required >

<br>

</div>

</div><!-- form-group Ends -->

<!--

<div class="form-group" > form-group Starts

<label class="col-md-3 control-label" > سعر البيع</label>

<div class="col-md-6" >

<input type="number" name="sale_price" class="form-control" >

</div>

</div> form-group Ends -->





<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > سعر الشراء  </label>

<div class="col-md-6" >

<input type="number" name="buy_price" class="form-control" required >

</div>

</div><!-- form-group Ends -->



<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > سعر البيع </label>

<div class="col-md-6" >

<input type="number" name="sale_price" class="form-control" required >

</div>

</div><!-- form-group Ends -->


<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > تاريخ الانتهاء </label>

<div class="col-md-6" >

<input type="date" name="expired_date" class="form-control" required >

</div>

</div><!-- form-group Ends -->

<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > المندوب  </label>

<div class="col-md-6" >

<input type="input" name="delegate" class="form-control" required >

</div>

</div><!-- form-group Ends -->


<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" > تاريخ الشراء  </label>
<?php echo $date; ?> 

<div class="col-md-6" >


</div>

</div><!-- form-group Ends -->

<!--

<div class="form-group" >form-group Starts 

<label class="col-md-3 control-label" > سعر الشراء</label>

<div class="col-md-6" >

<input type="number" name="buy_price" class="form-control" required >



</div>

</div>form-group Ends



<div class="form-group" > form-group Starts

<label class="col-md-3 control-label" > الكمية</label>

<div class="col-md-6" >

<input type="number" name="opcity" class="form-control" required >



</div>

</div><S form-group Ends 


<div class="form-group" > form-group Starts

<label class="col-md-3 control-label" > وحدة\باكت </label>

<div class="col-md-6" >

<select name="packeg_and_unit" class="form-control" >

 <option value="وحدة"> unit </option>
  <option value="باكت">packeg</option>


</select>

</div>

</div><form-group Ends -->
<div class="form-group" ><!-- form-group Starts -->

<label class="col-md-3 control-label" >  </label>

<div class="col-md-6" >

<input type="submit" name="submit" value=" Buy " class="btn btn-primary form-control" >

</div>

</div><!-- form-group Ends -->

</form><!-- form-horizontal Ends -->

</div><!-- panel-body Ends -->

</div><!-- panel panel-default Ends -->

</div><!-- col-lg-12 Ends -->




</form>

</body>

</html>


<script src="js/jquery-3.4.1.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
    <script src="js/fontawesome.min.js"></script> 
        <script src="js/myjs.js."></script> 

