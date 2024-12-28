
 
<?php include 'templats/header.php';
	include 'templats/navbar.php';
include '../includes/db.php';

	?>


<div class="form-group" style="margin:20px;">




  

<table style=" margin:20px; cellspacing="20" cellpadding="0">
<form  method="post" action="dashboard.php">

<div class="container"/>
        <div class="row centered-form"/>
            <div class="col-xs-12 col-sm-8 col-md-8 col-sm-offset-2 col-md-offset-2"/>
                <div class="panel panel-info"/>
 
                    <div class="panel-heading text-center"/>
                   
                    </div>
 
                    <div class="panel-body"/>
                            
                            <div class="list_wrapper"/>  
                                <div class="row"/>


<tr>
<td>
<input type="text" name="num" size="2" class="form-control" />
</td>
<td>
       كم عدد العلاجات التي تريد شراءها ؟ 
</td>

</tr>


<tr>
<td colspan='2'  >
<br/>
<input type="submit" name="submit" value="إدخــال"  class="btn btn-info btn-block" />
</td>
</tr>
</form>
</table>

<table style="margin:20px;  " cellspacing="20" cellpadding="0">
<form  method="post" action="buy.php">

<?php 
if(isset($_POST['submit'])){
$numbers=$_POST['num'];
for ($i=1 ; $i<=$numbers ;$i++)
{
    ?>
<tr>
<th colspan='2'  > الـــدواء # <?php echo $i; ?> </th>
</tr>
    <input type="hidden" value=" <?php echo $numbers; ?> " name="numbers" class="btn btn-info btn-block"/>

<tr>

<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
     اســم الـــدواء 
    <input name="name_med[]"  type="input" placeholder="Medicines Name : " class="form-control" required />                                     
    </div>
</div>
</td>

<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>

<div class="form-group">
      الكميـــة
     <input name="countity[]"   type="number" placeholder=" Countity : " class="form-control"/>
  </div>
</td>

<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                             تاريــخ الانتهاء 
                                            <input name="expired_date[]"   type="date" placeholder=" Expired Date  :  " class="form-control"/>
                                        </div>
</td>


<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                            سعــر الشـــراء 
                                            <input name="buy_price[]"  type="number" placeholder="  Buy Price " class="form-control"/>
                                        </div>
</td>


<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                             سعــر البيــع
                                            <input name="sale_price[]"  type="number" placeholder=" Sale Price : "  class="form-control" required />
                                        </div>
</td>

<?php }} ?>

<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                              تاريــخ الشـــراء
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

<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                              المنـــدوب
                                            <input name="delegate"  type="input" placeholder=" Sale Price : "  class="form-control" required />
                                        </div>
</td>
</tr>
<tr>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">

<td colspan='2'>
                            <input name="submit" type="submit" value="Insert" class="btn btn-info btn-block" />
</td>


</div>
</tr>





</form>

                 </div>
                </div>
            </div>
        </div>
    </div>                 </div>
                </div>
            </div>
        </div>
    
</table>

<script src="js/jquery-3.4.1.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
    <script src="js/fontawesome.min.js"></script> 
        <script src="js/myjs.js."></script> 

