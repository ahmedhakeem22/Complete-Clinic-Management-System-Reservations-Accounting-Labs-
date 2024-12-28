
<?php include 'templats/header.php';
	include 'templats/navbar.php';
include '../includes/db.php';

	?>
                                        

<form  method="post" action="dashboard.php">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover table-active " cellspacing="15" cellpadding="0">
<tr>
<td>
                  <label style="background-color:#00b3b3;" class=" form-control "  > <strong style="color:white;" >  كم عدد العلاجات التي تريد بيعها ؟  </strong></label>   
</td>
</tr>

<tr>
<td>
<input type="text" name="num" size="3"  class="form-control" placeholder=" Enter here how many drugs do you want to buy? " />
</td>
</tr>

<tr>
<td>
<input type="submit" name="submit" value="   إدخال معلومات الأدوية "  class="btn btn-warning btn-block" />
</td>
</tr>
</table>
</div>
</form>
<div class="table-responsive">

<table class="table table-striped table-bordered table-hover table-active" >
<form  method="post" action="sale.php">
</tr>
<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
    <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" > رقم المريــض </strong> </label>
    <input name="pat_id"  type="number" placeholder="Patinte ID : " class="form-control" required />                                     
    </div>
</div>
</td>

<td> 
<div class="col-xs-12 col-sm-12 col-md-12"/>

<div class="form-group">
    <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" >  اسـم المريــض </strong> </label>
     <input name="fname"   type="input" placeholder=" Patinte Name : " class="form-control"/>
  </div>
</td>
<?php
if(isset($_POST['submit'])){
$numbers=$_POST['num'];
for ($i=1 ; $i<=$numbers ;$i++)
{
    //expired_date >' $date' and countity > 0
    ?>
<tr>
<th colspan='7'  > <label style="background-color:#00b3b3;" class=" form-control " > <strong style="color:white;" > الـــدواء # <?php echo $i; ?> </label> </th>
</tr>
    <input type="hidden" value=" <?php echo $numbers; ?> " name="numbers" class="btn btn-info btn-block"/>

<tr>

<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
    <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" > رقم الـــدواء </strong> </label>
                                                        
          <select name="id_invoice[]" class="form-control" >

<?php
$query=mysqli_query($conn,"select * from buy_invpice where expired_date >' $date' and countity > 0 ");
while($array_ses_id=mysqli_fetch_array($query)){
echo"  <option value='".$array_ses_id['id_invoice']."'>    ".$array_ses_id['name_med']."     *      تاريخ الانتهاء     ".$array_ses_id['expired_date'].   " </option>  ";
}

?>
</select>
                                        </div>
</td>


<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
    <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" > اسـم الـــدواء </strong> </label>
                                             <select name="medicines_name[]" class="form-control" >


<?php
$query=mysqli_query($conn,"select * from buy_invpice where expired_date >' $date' and countity > 0 ");
while($array_ses_id=mysqli_fetch_array($query)){
echo"  <option value='".$array_ses_id['name_med']."'>   ".$array_ses_id['name_med'].  " الكميـــة  =   ".$array_ses_id['countity'].  " </option>  ";
}

?>
                                        </div>
</td>

<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                       <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" > الكمية </strong> </label>       
                                            <input name="unit_bact[]"  type="number" placeholder="  Unit No. " class="form-control"/>
                                        </div>
</td>

<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                       <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" > عـدد الوحــدات </strong> </label>       
                                            <input name="unit[]"  type="number" placeholder="  Unit No. " class="form-control"/>
                                        </div>
</td>



<td>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
                                       <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" >  سعــر البيــع </strong> </label>       
                                            <input name="sale_price[]"  type="number" placeholder=" Sale Price : "  class="form-control" required />
                                        </div>
</td>
<?php }} ?>

<td>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
                                         <label  style="background-color:#737373;" class=" form-control " > <strong style="color:white;">     تاريــخ البيع </strong> </label>
                                             <?php
date_default_timezone_set("Asia/Aden");
$date=   date("Y-m-d ");               
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  ?>
                                          <?php  echo  $date; ?>
                                        </div>                                        </div>
</td>
<tr>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">

<td colspan='6'>
                            <input name="submit" type="submit" value="Insert" class="btn btn-success form-control  btn-block" />
</td>


</div>
</tr>





</form>

</table>
</div>

<script src="js/jquery-3.4.1.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
    <script src="js/fontawesome.min.js"></script> 
        <script src="js/myjs.js."></script> 

