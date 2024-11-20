<?php include 'includes/templates/header.php';
	include 'includes/templates/navbar.php';
	?>
<html>
 


<body> 

                              <img src="../img/Psychological.jpg" alt="image" width="100%" height="45%">

      <main>


           
       <form  action="choess_nafsy_box_pdf.php" method="get">
       <table  cellspacing="15" cellpadding="0" >

       <tr>
  <td>  Patinte ID  :   <input type="number" id="Patinte" name="pat_id" required > </td>
               <td> Patinte Name :  <input  type="input" id="Patinte" name="fname" title="Patinte Name :" placeholder="Patinte Name : ">  </input>  </td>
               </td>
               <td>           <button type="submit"  aria-placeholder="Add" name="add_sess" class="btn btn-success" > SAVE </button>

  </td>
       </table>

       <h3> chosse the test bloode   </h3>

<div class="form-group" style="font-size:22px; font-family:Tahoma; "  ><!-- form-group Starts -->
<div>

       <input type="checkbox" name="test[]" value="1" > الاختبارات السته الكل </input>
       <pre></pre>

       <input type="checkbox" name="test[]" value="2" > اختبار وايزمان للمعتقدات</input>
<pre></pre>

       <input type="checkbox" name="test[]" value="3" > اختبار ايزليك للشخصية </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="4" >  اختبار تاكيد الذات </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="5" >  اختبار تقدير الذات</input>
<pre></pre>

       <input type="checkbox" name="test[]" value="6" >  اختبار وجهه الضبط </input>
       <pre></pre>

       <input type="checkbox" name="test[]" value="7" >  اختبار ساكس لتكمله الجمل </input> 
<pre></pre>
       <input type="checkbox" name="test[]" value="8" > مقياس الدافعية والرغفه في الادمان </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="9" >  استبيان معتقدات الشخصية  </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="10" >  اختبار الشخصيه المتعدده الاوجه MMPI  </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="11" >  مقياس بيك للاكتئاب  </input> 
       <pre></pre>

       <input type="checkbox" name="test[]" value="12" > مقياس كولومبيا للانتحار  </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="13" >  مقياس تابلور للقلق  </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="14" >  مقياس الوسواس القهري وشدته  </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="15" >   مقياس الاسيست للادمان  </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="16" >  مقياس الذكاء المصور  </input> 
       <pre></pre>

       <input type="checkbox" name="test[]" value="17" >  اختبار الجشطلت  </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="18" >  مقياس كرب مابعد الصدمه   </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="19" > مقياس الهوس   </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="20" >  اختبار وكسلر لذكاء المراهقين والبالغين  </input> 
       <pre></pre>

       <input type="checkbox" name="test[]" value="21" >  اختبار وكسلر لذكاء الاطفال ما قبل سن المراهقه  </input> 
       <pre></pre>

       <input type="checkbox" name="test[]" value="22" > مقياس تقييم الاعراض الانسحابيه للكحول  </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="23" > مقياس تقييم الاعراض الانسحابيه للبنزودياربين  </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="24" >   مقياس تقييم اعراض الادمان على البنزودياربين  </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="25" >  مقياس تقييم الاعراض الانسحابيه للافيونات </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="26" >  استبيان تقييم شده الادمان على الافيونات  </input> 
       <pre></pre>

       <input type="checkbox" name="test[]" value="27" >  استبيان تقييم الادمان غلى الكحول  </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="28" >  اختبار التات TAT  </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="29" >  مقياس فرط النشاط وقله الانتباه   </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="30" >   (مقياس الدور الجنسي (ذكور-اناث  </input> 
       <pre></pre>

       <input type="checkbox" name="test[]" value="31" >   مقياس الرهاب الاجتماعي   </input> 
       <pre></pre>

       <input type="checkbox" name="test[]" value="32" >  مقياس القلق الاجتماعي   </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="33" >  فحص الحاله العقليه   </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="34" >  مقياس الهلع  </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="35" >  استبيان التوافق الزوجي  </input> 
<pre></pre>

       <input type="checkbox" name="test[]" value="36" >  مقياس تشخيص اضطراب التوحد للاطفال  </input> 
       
    <pre></pre>
           <input type="checkbox" name="test[]" value="37" >  مقياس ايلي براون     </input> 
               <pre></pre>


    
	</div>
</div><!-- form-group Ends -->

</form>





      </main>


      <footer class="footer">

 

      </footer>

      

</body>





</html>

