
<?php include 'templats/header.php';
	include 'templats/navbar.php';
   

	?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
                           

<form  method="post" action="medi.php">
<div class="table-responsive">
<table class="table table-striped table-bordered table-hover table-active " cellspacing="15" cellpadding="0">
<tr>
<td>
                  <label style="background-color:#00b3b3;" class=" form-control "  > <strong style="color:white;" >  أدخــل عــدد العلاجــات الموصى بها  </strong></label>   
</td>
</tr>

<tr>
<td>
<input type="text" name="num" size="3"  class="form-control" placeholder=" Enter here how many drugs  " />
</td>
</tr>

<tr>
<td>
<input type="submit" name="submit" value="   إدخــــال معلـومـــات الأدويـــة "  class="btn btn-warning btn-block" />
</td>
</tr>
</table>
</div>
</form>
<div class="table-responsive">

<table class="table table-striped table-bordered table-hover table-active" >
<form  method="post" action="sale.php">
<tr>
<td>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
    <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" > رقـــم المريــض </strong> </label>
    <input name="pat_id"  type="number" placeholder="Patinte ID : " class="form-control" required />                                     
    </div>
</div>
</td>

</tr>

<?php
if(isset($_POST['submit'])){
$numbers=$_POST['num'];

for ($i=1 ; $i<=$numbers ;$i++)
{
    ?>
<tr>
<th colspan='7'  > <label style="background-color:#00b3b3;" class=" form-control " > <strong style="color:white;" > الـــدواء # <?php echo $i; ?> </strong> </label> </th>
</tr>
    <input type="hidden" value=" <?php echo $numbers; ?> " name="numbers" class="btn btn-info btn-block"/>

<tr>

<td>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
    <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" > اســــم الـــدواء </strong> </label>
                                                                                         <input name="med_name[]"  type="text" placeholder="  Name " class="form-control"/>

                                             


                                        </div>
                                        </div>
</td>

<td>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
                                       <label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" > الكميـــــة </strong> </label>       
                                            <input name="countity[]"  type="number" placeholder="  countity " class="form-control"/>
                                        </div>
                                        </div>
</td>




<td>   

<input type="hidden" id="HdnIDs" />
<table id="tester">
    <thead>
        <tr>
            <th>
                Excel?
            </th>
            <th>
                Operação

            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div>
                    <input type="checkbox" id="inputs" data-value="3243">
                </div>
            </td>
            <td>
                teste1
            </td>
        </tr>
        <tr>
            <td>
                <div>
                    <input type="checkbox" id="inputs" data-value="3247">
                </div>
            </td>
            <td>
                teste2
            </td>

        </tr>
        <tr>
            <td>
                    <input type="checkbox" id="inputs" data-value="3246">
            </td>
            <td>
                test3
            </td>
        </tr>
        <tr>
            <td>
                <div>
                    <input type="checkbox" id="inputs" data-value="3245">
                </div>
            </td>
            <td>
                TESTE1
            </td>
        </tr>
    </tbody>
</table>

<button id="btnexcellSelect" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i>&nbsp;&nbsp;Get Excel</button>

<br>
<div id="result"></div>

<script>
$(function () {
 var listInput = [];
  $("#btnexcellSelect").attr("disabled", "disabled");
  
  $('input[type=checkbox]').change(function() {
  listInput = [];
      $("#tester > tbody  tr").each(function () {      			
      		if ($('input[type=checkbox]').is(':checked')) {  
             $('#btnexcellSelect').removeAttr('disabled');            
          }else{         
          	 $("#btnexcellSelect").attr("disabled", "disabled");
             $('#result').html('');
             
          }
      });
  });

  $('#btnexcellSelect').click(function (e) {
    if ($('input[type=checkbox]').is(':checked')) {
     	$('input[type=checkbox]').each(function(){
      		if ($(this).is(':checked')) 
          {
            listInput.push($(this).attr('data-value'));
          }
      });
      $('#result').html(listInput.join(", "));
    }
    e.preventDefault();
  });
});
</script>



<!--
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
<label style="background-color:#737373;" class=" form-control " > <strong style="color:white;" >طــريقــــة الاستـخــــدام </strong> </label>
                                       
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<label class="chkskillsedit cursor1 backgroundcolor2-color highlightcheckboxedit col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="حبـة قبـل الفطـور -" disabled /><strong> حبـة قبـل الفطــور </strong> </label>
<label class="chkskillsedit cursor1 backgroundcolor2-color col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="نـص حبـة قبـل الفطـور -" disabled /> <strong> نـــص حبـة قبـل الفطــور </strong> </label><br/>
<label class="chkskillsedit cursor1 backgroundcolor2-color col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="حبـة بعـد الفطـور -" disabled /><strong>حبة بعد الفطور </strong> </label>
<label class="chkskillsedit cursor1 backgroundcolor2-color highlightcheckboxedit col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="نــص حبـة بعـد الفطـور -" disabled /> <strong> نــص حبة بعد الفطور </strong> </label><br/>
<label class="chkskillsedit cursor1 backgroundcolor2-color col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="حبـة قبـل الغـداء -" disabled /><strong> حبة قبل الغداء </strong> </label>
<label class="chkskillsedit cursor1 backgroundcolor2-color highlightcheckboxedit col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="حبـة بعـد الغـداء -" disabled /> <strong> حبة بعد الغداء </strong> </label><br/>
<label class="chkskillsedit cursor1 backgroundcolor2-color col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="نـص حبـة بعـد الغـداء -" disabled /><strong>نص حبة بعد الغداء</strong> </label>


<label class="chkskillsedit cursor1 backgroundcolor2-color col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="نـص حبـة قبـل الغـداء -" disabled /><strong> نص حبة قبل الغداء</strong>  </label><br/>

    
<label class="chkskillsedit cursor1 backgroundcolor2-color col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="حبـة قبـل العشـاء -" disabled /> <strong>حبة قبل العشاء </strong> </label>
<label class="chkskillsedit cursor1 backgroundcolor2-color col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="نـص حبـة قبـل العشـاء -" disabled /><strong> نص حبة قبل العشاء</strong>  </label><br/>

    <label class="chkskillsedit cursor1 backgroundcolor2-color col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="حبـة بعـد العشـاء -" disabled />  <strong>حبة بعد العشاء </strong> </label>
<label class="chkskillsedit cursor1 backgroundcolor2-color col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="نـص حبـة بعـد العشـاء -" disabled /><strong> نص حبة بعد العشاء </strong> </label><br/>

    <label class="chkskillsedit cursor1 backgroundcolor2-color col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="حبـة قبـل النـوم -" disabled /><strong>   حبة قبل النوم </strong>  </label>
    <label class="chkskillsedit cursor1 backgroundcolor2-color col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="نص حبـة قبل النـوم -" disabled /><strong> نص حبة قبل النوم  </strong>   </label><br/>
    <label class="chkskillsedit cursor1 backgroundcolor2-color col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="حبـة كـل اسبـوع -" disabled /><strong> حبة كل اسبوع  </strong>   </label>
    <label class="chkskillsedit cursor1 backgroundcolor2-color col-md-6">
    <input class="hid col-md-2" name="fr_skills[]" type="checkbox" value="مرتيـن في الاسبـوع -" disabled /><strong> مرتين في الاسبوع  </strong>   </label><br/>
       </div>
</div>
</td>
 
<script>
$(document).ready(function() {
    $('label.chkskillsedit>input[type=checkbox].hid').on('change', function(evt)  {
        if ($('label.chkskillsedit>input[type=checkbox]:checked').length <= 100) {
            $(this).parent('label').toggleClass('highlightcheckboxedit',this.checked);

            function fullskilledit() {
                var allValsedit = [];
                $('label.chkskillsedit :checked').each(function() {
                    allValsedit.push($(this).val()  + "\n" );
                });
                $('.txtValueshwskilledit').val(allValsedit);
            };
            $(function() {
                $('.chkskillsedit>input.hid').click(fullskilledit);
                fullskilledit();
            });
            
        } else {
            $(this).prop('checked', false);
            $(this).parent('label').removeClass('highlightcheckboxedit');
        }
    })
})
</script>
-->

   <td>

       <textarea name="usee[]"  cols="20" rows="12" class="txtValueshwskilledit form-control z-depth-1 " ></textarea>
       </td>
    
<?php }} ?>

<td>
<div class="col-xs-12 col-sm-12 col-md-12">
<div class="form-group">
                                         <label  style="background-color:#737373;" class=" form-control " > <strong style="color:white;">     تاريــخ الوصفـــة </strong> </label>
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



