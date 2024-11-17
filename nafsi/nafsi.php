<?php include 'templats/header.php';
	include 'templats/navbar.php';
	?>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css"/>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>

</head>
<body> 

    <main>

    <form  action="nafsy_insrt_pdf.php" method="get">
<div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
<table class="drnafsi table table-striped table-bordered table-hover table-active" cellspacing="15" cellpadding="0" >
<tr>
<td>
<lable style="background-color:#e60099;"  class=" form-control "> <strong style="color:white;" > Patinte ID : </strong> </lable><br/>
<input type="number" name="pat_id" style=" width:300px; background-color:white; " class="form-control " required > </input>
</td>

<td>
   <lable style="background-color:#e60099;"  class=" form-control "> <strong style="color:white;" >Test : </strong> </lable>
   <br/>
<select name="nafsy" class="form-control" style="height:50px; background-color:#ffe6f7; color:#e60099; "> 
<option value="1"> الاختبارات السته الكل</option>
<option value="2"> اختبار وايزمان للمعتقدات</option>
<option value="3"> اختبار ايزليك للشخصية</option>
<option value="4"> اختبار تاكيد الذات</option>
<option value="5"> اختبار تقدير الذات</option>
<option value="6"> اختبار وجهه الضبط</option>
<option value="7"> اختبار ساكس لتكمله الجمل</option>
<option value="8"> مقياس الدافعية والرغفه في الادمان</option>
<option value="9"> استبيان معتقدات الشخصية </option>
<option value="10"> اختبار الشخصيه المتعدده الاوجه MMPI</option>
<option value="11"> مقياس بيك للاكتئاب</option>
<option value="12"> مقياس كولومبيا للانتحار</option>
<option value="13"> مقياس تابلور للقلق</option>
<option value="14"> مقياس الوسواس القهري وشدته</option>
<option value="15"> مقياس الاسيست للادمان</option>
<option value="16"> مقياس الذكاء المصور</option>
<option value="17"> اختبار الجشطلت</option>
<option value="18"> مقياس كرب مابعد الصدمه</option>
<option value="19"> مقياس الهوس</option>
<option value="20"> اختبار وكسلر لذكاء المراهقين والبالغين</option>
<option value="21"> اختبار وكسلر لذكاء الاطفال ما قبل سن المراهقه</option>
<option value="22"> مقياس تقييم الاعراض الانسحابيه للكحول</option>
<option value="23"> مقياس تقييم الاعراض الانسحابيه للبنزودياربين</option>
<option value="24"> مقياس تقييم اعراض الادمان على البنزودياربين</option>
<option value="25"> مقياس تقييم الاعراض الانسحابيه للافيونات</option>
<option value="26"> استبيان تقييم شده الادمان على الافيونات</option>
<option value="27"> استبيان تقييم الادمان غلى الكحول</option>
<option value="28"> اختبار التات TAT</option>
<option value="29"> مقياس فرط النشاط وقله الانتباه</option>
<option value="30"> مقياس الدور الجنسي (ذكور-اناث</option>
<option value="31"> مقياس الرهاب الاجتماعي</option>
<option value="32"> مقياس القلق الاجتماعي</option>
<option value="33"> فحص الحاله العقليه</option>
<option value="34"> مقياس الهلع</option>
<option value="35"> استبيان التوافق الزوجي</option>
<option value="36"> مقياس تشخيص اضطراب التوحد للاطفال</option>
<option value="37"> مقياس ايلي براون</option>

</select>
	</td>
<td>
<lable style="background-color:#e60099;"  class=" form-control "> <strong style="color:white;" > The result : </strong> </lable>
<br/>
<textarea type="input" name="resul_pl" class="form-control "  required ></textarea>
</td>
		</tr>
        <tr>
<td>
<lable style="background-color:#e60099;"  class=" form-control "> <strong style="color:white;" > Note : </strong></lable>
<br/>
<textarea type="text" id="nosession" name="note_pl" class="form-control" > </textarea>
</td>

<td>

</td>
<td>
<br/>
<button class="btn btn-success form-control" type="submit" value="Submit" name="Submit_pation" style="height:50px;" > Save and Prent </button>
</td>
</tr>

</table>
</div>
   </form>
   </main>
            
           <footer>
            

           </footer> 
        
</body>

</html>

