<?php include 'templats/header.php';
       include 'templats/navbar.php';
       
	?>


      <main>

      
           
                  <img src="Bloodtest.jpg" alt="image" width="100%" height="auto">




                  <table cellspacing="15" cellpadding="0" >
                    <main class="main">

      

       <form  action="choess_blood_box_pdf.php" method="get">
       <h5>   pation id  :  </h5>
       <input type="number" id="Patinte" name="pat_id" >
       <h5> chosse the test bloode   </h5>

       <form  action="bookses_pdf_acch.php" method="get">


<div class="form-group" style="font-size:22px; font-family:Tahoma; "  ><!-- form-group Starts -->
<div>
<pre></pre>

       <input type="checkbox" name="test[]" value="1" > HB  </input>
<pre></pre>

        <input type="checkbox" name="test[]" value="2" > WBC  </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="3" > Neutrophil   </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="4" >  Lymphocyte </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="5" > Monocyte  </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="6" > Eosinophil  </input>
       <pre></pre>

       <input type="checkbox" name="test[]" value="7" > Urea </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="8" > Creatinine </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="9" > S.GOT </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="40" > RBS </input>
			</div>
</div><!-- form-group Ends -->

       
       
      


    
<pre></pre>

<div class="form-group" style="font-size:22px; font-family:Tahoma;" ><!-- form-group Starts -->
<div>
       <input type="checkbox" name="test[]" value="10" > S.GPT </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="11" > Total Brilirubin  </input>
       <pre></pre>

       <input type="checkbox" name="test[]" value="12" > Direct Brilirubin  </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="13" > A.S.O   </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="14" >  C.R.P </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="15" > R.F  </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="16" > Widal Test Salmonella (O)  </input>
       <pre></pre>

       <input type="checkbox" name="test[]" value="17" > Widal Test Salmonella (H) </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="18" > Widal Test Salmonella (A) </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="19" > Widal Test Salmonella (B) </input>

</div>
</div><!-- form-group Ends -->
   
<pre></pre>

<div class="form-group" style="font-size:22px; font-family:Tahoma;" ><!-- form-group Starts -->
<div>
       <input type="checkbox" name="test[]" value="20" > Marijuana</input>
<pre></pre>

       <input type="checkbox" name="test[]" value="21" > Arnphetamin  </input>
       <pre></pre>

       <input type="checkbox" name="test[]" value="22" > Cocaine  </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="23" > Heroin  </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="24" >  PT Patient </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="25" > PTT Patient  </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="26" > INR  </input>
       <pre></pre>

       <input type="checkbox" name="test[]" value="27" > ESR </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="28" > Malari </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="29" > Cholestrol </input>

      </div>
</div><!-- form-group Ends -->    
<pre></pre>

<div class="form-group" style="font-size:22px; font-family:Tahoma; " ><!-- form-group Starts -->
<div>
       <input type="checkbox" name="test[]" value="30" > Triglyceride</input>
<pre></pre>

       <input type="checkbox" name="test[]" value="31" > HDL  </input>
       <pre></pre>

       <input type="checkbox" name="test[]" value="32" > LDL  </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="33" > Ca++  </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="34" >  K+  </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="35" >  Na+   </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="36" > H.pylorl AD </input>
       <pre></pre>

       <input type="checkbox" name="test[]" value="37" > HIV </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="38" > HBS-Ag </input>
<pre></pre>

       <input type="checkbox" name="test[]" value="39" > HCV </input>

      
</div>
</div><!-- form-group Ends -->
<pre></pre>

    <button type="submit"  aria-placeholder="Add" name="add_sess" class="btn btn-success" > SAVE </button>
    


</form>
                    </table>




      </main>


      <footer class="footer">

        <!--
<p id="demo"></p>

            <script>
            var d = new Date();
            document.getElementById("demo").innerHTML = d;
            </script>
        -->    
            

      </footer>

      

</body>





</html>

