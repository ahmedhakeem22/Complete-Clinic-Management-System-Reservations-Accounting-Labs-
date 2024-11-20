<?php include 'includes/templates/header.php';
       include 'includes/templates/navbar.php';
       
	?>


      <main>

      
           
    <img src="includes/images/Bloodtest.jpg" alt="image" width="100%" height="auto">
    <div class="boxlab" style="top:5px; " >
    <table cellspacing="15" cellpadding="0" >
    <form  action="choess_blood_box_pdf.php" method="get">
    <table  cellspacing="15" cellpadding="0" >

<td>
   Patinte ID:     <input type="number" id="Patinte" name="pat_id" /> </td>
  <td>       <button type="submit"  aria-placeholder="Add" name="add_sess" class="btn btn-success" > SAVE </button>
</td>

</table>

       <form  action="bookses_pdf_acch.php" method="get">

<style>
input[type='checkbox'] {
    -webkit-appearance:none;
    width:20px;
    height:20px;
    background:white;
    border-radius:5px;
    border:1px solid green;
        cursor: pointer;

}
input[type='checkbox']:checked {
    background: red;
}
</style>

<div class="form-group" style="font-size:22px; font-family:Tahoma; "  ><!-- form-group Starts -->


<lable style="color:red; font-size:22px; " > HAEMATOLOGY </lable>
<br/>

       <input type="checkbox" name="test[]" value="1" > CBC - </input>

<select name="test[]" multiple >
<option  value=""> CBC - فروع </option>
<option name="test[]" value="101">HB </option>
<option name="test[]" value="102">wbc </option>
</select>

        <input type="checkbox" name="test[]" value="2" > Platelats  </input>

       <input type="checkbox" name="test[]" value="3" > ESR   </input>

       <input type="checkbox" name="test[]" value="4" >  Malaria  </input>
       
       <input type="checkbox" name="test[]" value="7" > CT </input>

       <input type="checkbox" name="test[]" value="8" > PT </input>

    <!--   <select name="test[]">
<option  value=""> PT - فروع </option>
<option name="test[]" value="103">INR</option>
</select>
-->
       <input type="checkbox" name="test[]" value="9" > BT </input>

       <input type="checkbox" name="test[]" value="10" > Reticulocyte </input>

       <input type="checkbox" name="test[]" value="11" > Sickling test </input>
       
              <input type="checkbox" name="test[]" value="12" >  PTT </input>

       <input type="checkbox" name="test[]" value="13" > D_Dimer  </input>

<pre></pre>

<lable style="color:red; font-size:22px; "> BIOCHEMEISTRY </lable>

<pre></pre>

       <input type="checkbox" name="test[]" value="14" > F.B.S   </input>

       <input type="checkbox" name="test[]" value="15" >  R.B.S </input>

       <input type="checkbox" name="test[]" value="16" > P.PBS  </input>

       <input type="checkbox" name="test[]" value="17" > HBA 1C  </input>
       
       <input type="checkbox" name="test[]" value="18" > KFT </input>

 <select name="test[]" multiple >
<option  value=""> KFT - فروع </option>
<option name="test[]" value="104">Urea</option>
<option name="test[]" value="105">Creatinine</option>
</select>

       <input type="checkbox" name="test[]" value="19" > LFT </input>

        <select name="test[]" multiple >
<option  value=""> LFT - فروع </option>
<option name="test[]" value="106">S.Got</option>
<option name="test[]" value="107">S.Gpt</option>
<option name="test[]" value="108">Total Bilirubin</option>
<option name="test[]" value="109">Dirict Bilirubin </option>
</select>

       <input type="checkbox" name="test[]" value="20" >ALK.Phospats </input>

       <input type="checkbox" name="test[]" value="21" > Albumin</input>

       <input type="checkbox" name="test[]" value="22" > Electrolytes  </input>

               <select name="test[]" multiple >
<option  value=""> Electrolytes - فروع </option>
<option name="test[]" value="110"> Ca++ </option>
<option name="test[]" value="111">K+</option>
<option name="test[]" value="112">Na+</option>
<option name="test[]" value="113"> Cl+ </option>
<option name="test[]" value="114">Mg++</option>
</select>
       
<pre></pre>


       <input type="checkbox" name="test[]" value="23" > Cardiac Enzyme  </input>

                      <select name="test[]" multiple >
<option  value=""> Cardiac Enzyme - فروع </option>
<option name="test[]" value="115"> C.K </option>
<option name="test[]" value="116">CK-MB</option>
<option name="test[]" value="117">L.D.H</option>
</select>

       <input type="checkbox" name="test[]" value="24" > Lipid  </input>

                             <select name="test[]" multiple >
<option  value=""> Lipid - فروع </option>
<option name="test[]" value="118"> Cholesterol </option>
<option name="test[]" value="119">Triglyceride</option>
<option name="test[]" value="120">LDL</option>
<option name="test[]" value="121">HDL</option>

</select>

       <input type="checkbox" name="test[]" value="25" >  Uricacid </input>

       <input type="checkbox" name="test[]" value="39" >  T.Patinte </input>


<pre></pre>

<lable style="color:red; font-size:22px; "> SEROLOGY </lable>

<pre></pre>

       <input type="checkbox" name="test[]" value="26" > ASO  </input>

       <input type="checkbox" name="test[]" value="27" > C.R.P  </input>
       
       <input type="checkbox" name="test[]" value="28" > RF </input>

       <input type="checkbox" name="test[]" value="29" > Widal Test </input>

       <input type="checkbox" name="test[]" value="30" > Brucella </input>

       <input type="checkbox" name="test[]" value="31" > BLOOD Group </input>

       <input type="checkbox" name="test[]" value="32" > TB  </input>
       
       
       <input type="checkbox" name="test[]" value="33" > Viral Marker  </input>

                             <select name="test[]" multiple >
<option  value=""> Viral Marker - فروع </option>
<option name="test[]" value="122"> HIV </option>
<option name="test[]" value="123">HCV</option>
<option name="test[]" value="124">HBS.AG</option>
</select>
       <input type="checkbox" name="test[]" value="36" >  VDRL   </input>

       <input type="checkbox" name="test[]" value="37" > H.PYLORI RB </input>
       
       <input type="checkbox" name="test[]" value="38" > H.PYLORI AG </input>

  
<pre></pre>
<lable style="color:red; font-size:22px; " > Drugs </lable>
<pre></pre>

     <input type="checkbox" name="test[]" value="40" > Ethanol  </input>

       <input type="checkbox" name="test[]" value="41" > Diazepam  </input>
       
       <input type="checkbox" name="test[]" value="42" > Marijuana </input>

       <input type="checkbox" name="test[]" value="43" > Tramedol </input>

       <input type="checkbox" name="test[]" value="44" > Heroin </input>

       <input type="checkbox" name="test[]" value="45" > Pethidine </input>

       <input type="checkbox" name="test[]" value="46" > Cocaine  </input>

              <input type="checkbox" name="test[]" value="47" > Amphetamine  </input>

       <pre></pre>
<lable style="color:red; font-size:22px; " > Harmones </lable>
<pre></pre>

<input type="checkbox" name="test[]" value="48" > T3  </input>

       <input type="checkbox" name="test[]" value="49" > T4  </input>
       
       <input type="checkbox" name="test[]" value="50" > TSH </input>

       <input type="checkbox" name="test[]" value="51" > Prolactin </input>

       <input type="checkbox" name="test[]" value="52" > PSA Free </input>

       <input type="checkbox" name="test[]" value="53" > PSA Total </input>

       <input type="checkbox" name="test[]" value="54" > Vit-B12 </input>

       <input type="checkbox" name="test[]" value="55" > Vit-D3 </input>

       <input type="checkbox" name="test[]" value="56" > CA 153 </input>

       <input type="checkbox" name="test[]" value="57" > CA 125 </input>

    


</form>
                    </table>

</div>


      </main>


      <footer>

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

