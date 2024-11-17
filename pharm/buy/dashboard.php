
 
<?php include 'templats/header.php';
	include 'templats/navbar.php';
include 'includes/db.php';

	?>
    
<form  method="post" action="dashboard.php">
<table class="table table-striped table-bordered table-hover table-active " cellspacing="15" cellpadding="0" >
<tr>
<td>
            <label style="background-color:#00b3b3;" class=" form-control "  > <strong style="color:white;" >  كم عدد العلاجات التي تريد شراءها ؟  </strong></label> 
            </td>
            </tr>
            <tr>
            <td>
<input type="text" name="num" size="2" class="form-control" placeholder=" Enter here how many drugs do you want to buy? " />
</td>
</tr>
<tr>
<td>
<input type="submit" name="submit" value="   إدخال معلومات الأدوية "  class="btn btn-warning btn-block" />
</td>
</tr>

</table>
</form>
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover table-active " cellspacing="15" cellpadding="0" >
<form  method="post" action="buy.php">

<?php 
if(isset($_POST['submit'])){
$numbers=$_POST['num'];
for ($i=1 ; $i<=$numbers ;$i++)
{
    ?>

<tr>
<th colspan='7'  > <label style="background-color:#00b3b3;" class=" form-control " > <strong style="color:white;" > الـــدواء # <?php echo $i; ?> </label> </th>
</tr>
    <input type="hidden" value=" <?php echo $numbers; ?> " name="numbers" class="btn btn-info btn-block"/>

<tr>

<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
    <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" > اســم الـــدواء </strong> </label>
    <input name="name_med[]"  type="input" placeholder="Medicine Name : " class="form-control" required />                                     
    </div>
</div>
</td>
<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
    <label  style="background-color:#737373;" class=" form-control " > <strong style="color:white;">  الاســم العلمــي   </strong> </label>
    <input name="name_sinc[]"  type="input" placeholder="Scientific Name : " class="form-control" required />                                     
    </div>
</div>
</td>
<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
     <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;"> الكميـــة </strong> </label>
     <input name="countity[]"   type="number" placeholder=" Countity : " class="form-control"/>
  </div>
</td>

<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                          <label  style="background-color:#737373;" class=" form-control " > <strong style="color:white;"> تاريــخ الانتهاء </strong> </label>
                                            <input name="expired_date[]"   type="date" placeholder=" Expired Date  :  " class="form-control"/>
                                        </div>
</td>


<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                            <label  style="background-color:#737373;" class=" form-control " > <strong style="color:white;"> سعــر الشـــراء </strong> </label>
                                            <input name="buy_price[]"  type="number" placeholder="  Buy Price " class="form-control"/>
                                        </div>
</td>


<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                          <label  style="background-color:#737373;" class=" form-control " > <strong style="color:white;">    سعــر البيــع </strong> </label>
                                            <input name="sale_price[]"  type="number" placeholder=" Sale Price : "  class="form-control" required />
                                        </div>
</td>
  
  
<tr>

<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>

<div class="form-group">
     <label  style="background-color:#737373;" class=" form-control " > <strong style="color:white;">  اســم الشـركة  </strong> </label>
     <input name="copny_name[]"   type="input" placeholder=" Company : " class="form-control"/>
  </div>
</td>

<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                            <label  style="background-color:#737373;" class=" form-control " > <strong style="color:white;">   نوع العلاج </strong> </label>
                                            <input name="mad_chos[]"   type="input" placeholder="  Type  :  " class="form-control"/>
                                        </div>
</td>


<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                         <label  style="background-color:#737373;" class=" form-control " > <strong style="color:white;">   عدد الوحدات في البكت  </strong> </label>
                                            <input name="num_bact[]"  type="number" placeholder="  No. of unit in a packet : " class="form-control"/>
                                        </div>
</td>


<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                         <label  style="background-color:#737373;" class=" form-control " > <strong style="color:white;">     تاريخ الانتاج </strong> </label>
                                            <input name="date_do[]"  type="date" placeholder=" Production Date : "  class="form-control" required />
                                        </div>
</td>

<?php }} ?>


<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                            <label  style="background-color:#737373;" class=" form-control " > <strong style="color:white;">  المنـــدوب </strong> </label>
                                            <input name="delegate"  type="input" placeholder=" Delegate : "  class="form-control" required />
                                        </div>
</td>

<td>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
                                         <label  style="background-color:#737373;" class=" form-control " > <strong style="color:white;">     تاريــخ الشـــراء </strong> </label>
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

</tr>
<tr>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">

<td colspan='6'>
                            <input name="submit" type="submit" value="Insert" class="btn btn-success form-control  btn-block" >
</td>


</div>
</tr>





</form>
    
</table>

<script src="js/jquery-3.4.1.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
    <script src="js/fontawesome.min.js"></script> 
        <script src="js/myjs.js."></script> 

