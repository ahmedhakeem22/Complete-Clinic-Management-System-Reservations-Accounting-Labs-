
<?php include 'templats/header.php';
	include 'templats/navbar.php';
include 'includes/db.php';

	?>
                                        

<form  method="post" action="pageentry.php">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover table-active " cellspacing="15" cellpadding="0">
<tr>
<td>
                  <label style="background-color:#00b3b3;" class=" form-control "  > <strong style="color:white;" >  كم عدد العلاجات التي تريد تخزينها ؟  </strong></label>   
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
<form  method="post" action="entery.php">
</tr>
<?php
if(isset($_POST['submit'])){
$numbers=$_POST['num'];
for ($i=1 ; $i<=$numbers ;$i++)
{
    //expired_date >' $date' and countity > 0
    ?>
<tr>
<th colspan='7'  > <label style="background-color:#00b3b3;" class=" form-control " > <strong style="color:white;"> الـــدواء # <?php echo $i; ?> </strong></label> </th>
</tr>
    <input type="hidden" value=" <?php echo $numbers; ?> " name="numbers" class="btn btn-info btn-block"/>

<tr>


                                                        
          
<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                       <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" > اسم الدواء </strong> </label>       
                                            <input name="name_med[]"  type="text" placeholder=" اسم الدواء " class="form-control"/>
                                        </div>
</td>

<td>
<div class="col-xs-12 col-sm-12 col-md-12"/>
<div class="form-group">
                                       <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" >  الاسم العلمي </strong> </label>       
                                            <input name="name_chemical[]"  type="text" placeholder=" الاسم العلمي " class="form-control"/>
                                        </div>
</td>



<td>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
                                       <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" > اسم الشركة </strong> </label>       
                                            <input name="company[]"  type="text" placeholder=" اسم الشركة "  class="form-control" required />
                                        </div>
</td>
<td>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
                                       <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" > اسم المندوب </strong> </label>       
                                            <input name="delegate[]"  type="text" placeholder=" اسم المندوب "  class="form-control" required />
                                        </div>
</td>
<?php }} ?>


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

