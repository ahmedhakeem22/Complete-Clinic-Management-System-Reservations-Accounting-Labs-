<?php include 'includes/templates/header.php';
       include 'includes/templates/navbar.php';
       
	?>
  
<br/>
      <div class="form-group" style="top:10%;"  />
      <div class="col-xs-12 col-sm-12 col-md-12"/>
           <table>
       <form  action="nafsi_ses_pdf.php" method="get"/>
       <td>
       <lable style="margin:10px;" >   Patinte ID :  </lable>
       <input style="width:200px; height:30px;  " type="number" id="Patinte" name="pat_id" required />
       </td>
</table>
</div>
</div>

       <h1 style="font-size:22px;margin:20px;" > Chosse the Test Psychological   <h1>
                     <div style="font-size:20px; margin:20px;">

       <input type="checkbox" name="test[]" value="1" > الاختبارات السته الكل<br/> 
       
       <input type="checkbox" name="test[]" value="2" > اختبار وايزمان للمعتقدات<br/> 

       <input type="checkbox" name="test[]" value="3" >  اختبار ايزليك للشخصية <br/> 

       <input type="checkbox" name="test[]" value="4" >   اختبار تاكيد الذات<br/> 

       <input type="checkbox" name="test[]" value="5" >  اختبار تقدير الذات <br/> 

       <input type="checkbox" name="test[]" value="6" >  اختبار وجهه الضبط <br/> 
       
       <input type="checkbox" name="test[]" value="7" >  اختبار ساكس لتكمله الجمل<br/> 

       <input type="checkbox" name="test[]" value="8" > مقياس الدافعية والرغفه في الادمان<br/> 

       <input type="checkbox" name="test[]" value="9" >  استبيان معتقدات الشخصية <br/> 

       <input type="checkbox" name="test[]" value="10" >  اختبار الشخصيه المتعدده الاوجه MMPI <br/> 

       <input type="checkbox" name="test[]" value="11" >  مقياس بيك للاكتئاب <br/> 
       
       <input type="checkbox" name="test[]" value="12" > مقياس كولومبيا للانتحار <br/> 

       <input type="checkbox" name="test[]" value="13" >  مقياس تابلور للقلق <br/> 

       <input type="checkbox" name="test[]" value="14" >  مقياس الوسواس القهري وشدته <br/> 

       <input type="checkbox" name="test[]" value="15" >   مقياس الاسيست للادمان <br/> 

       <input type="checkbox" name="test[]" value="16" >  مقياس الذكاء المصور <br/> 
       
       <input type="checkbox" name="test[]" value="17" >  اختبار الجشطلت <br/> 

       <input type="checkbox" name="test[]" value="18" >  مقياس كرب مابعد الصدمه  <br/> 

       <input type="checkbox" name="test[]" value="19" >  مقياس الهوس  <br/> 

       <input type="checkbox" name="test[]" value="20" >  اختبار وكسلر لذكاء المراهقين والبالغين <br/> 
       
       <input type="checkbox" name="test[]" value="21" >  اختبار وكسلر لذكاء الاطفال ما قبل سن المراهقه <br/> 
       
       <input type="checkbox" name="test[]" value="22" >  مقياس تقييم الاعراض الانسحابيه للكحول <br/> 

       <input type="checkbox" name="test[]" value="23" >  مقياس تقييم الاعراض الانسحابيه للبنزودياربين <br/> 

       <input type="checkbox" name="test[]" value="24" >   مقياس تقييم اعراض الادمان على البنزودياربين <br/> 

       <input type="checkbox" name="test[]" value="25" >  مقياس تقييم الاعراض الانسحابيه للافيونات<br/> 

       <input type="checkbox" name="test[]" value="26" >  استبيان تقييم شده الادمان على الافيونات <br/> 
       
       <input type="checkbox" name="test[]" value="27" >  استبيان تقييم الادمان غلى الكحول <br/> 

       <input type="checkbox" name="test[]" value="28" >  اختبار التات TAT <br/> 

       <input type="checkbox" name="test[]" value="29" >  مقياس فرط النشاط وقله الانتباه  <br/> 

       <input type="checkbox" name="test[]" value="30" >   (مقياس الدور الجنسي (ذكور-اناث <br/> 
       
       <input type="checkbox" name="test[]" value="31" >   مقياس الرهاب الاجتماعي  <br/> 
       
       <input type="checkbox" name="test[]" value="32" >  مقياس القلق الاجتماعي  <br/> 

       <input type="checkbox" name="test[]" value="33" >  فحص الحاله العقليه  <br/> 

       <input type="checkbox" name="test[]" value="34" >  مقياس الهلع <br/> 

       <input type="checkbox" name="test[]" value="35" >  استبيان التوافق الزوجي <br/> 

       <input type="checkbox" name="test[]" value="36" >  مقياس تشخيص اضطراب التوحد للاطفال <br/>   
       
           <input type="checkbox" name="test[]" value="36" > مقياس ايلي براون <br/>   

       </div>

    <button type="submit"  aria-placeholder="Add" name="add_sess" class="btn btn-success" style="margin:20px; width:200px;"> Prent </button>
    


</form>


      <footer class="footer">

 

      </footer>

<script src="includes/js/jquery-3.4.1.min.js"></script>
         <script src="includes/js/bootstrap.min.js"></script>
    <script src="includes/js/fontawesome.min.js"></script> 
        <script src="includes/js/myjs.js."></script> 
