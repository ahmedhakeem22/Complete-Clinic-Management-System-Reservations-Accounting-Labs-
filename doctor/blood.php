
<?php include 'templats/header.php';
	include 'templats/navbar.php';
 // include 'css/style.php';
	?>

  <title> Add Test Blood </title>

<body > 

<header>
    

</header>

      <main class="main" >

      <img src="../img/List of Blood.jpg" alt="image" width="100%" height="45%">

  <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">



      <!-- <img src="picnew.png" alt="image" width="100%" height="45%">-->
       <div class="boxlab" style="top:22.5%" >
           <h2 style="color:red;">A list of blood tests</h2>

         




               <div class="inputcheckbox">
<input type="checkbox" id="1"><label for="1">  CBC</label>&nbsp;&nbsp;
<select name="nafsy"><option value="1">HB </option>
<option value="2">wbc </option>
<option value="3">diff </option></select>
<input type="checkbox" id="2"><label for="2"> platelats </label>&nbsp;&nbsp;
<input type="checkbox" id="3"><label for="3">  ESR </label>&nbsp;&nbsp;
<input type="checkbox" id="4"><label for="4">  Malaria by disce </label>&nbsp;&nbsp;
<input type="checkbox" id="5"><label for="5">   Malaria by filme </label>&nbsp;&nbsp;
<input type="checkbox" id="6"><label for="6">  BMT </label>&nbsp;&nbsp;
<input type="checkbox" id="7"><label for="7">  CT </label>&nbsp;&nbsp;
<input type="checkbox" id="8"><label for="8">  PT </label>&nbsp;&nbsp;
<select name="nafsy">
<option value="4">INR </option>
</select>
</div>
<br>
<div class="inputcheckbox">
<input type="checkbox" id="9"><label for="9"> PTT </label>&nbsp;&nbsp;
<input type="checkbox" id="10"><label for="10"> RETICULOCYTE </label>&nbsp;&nbsp;
<input type="checkbox" id="11"><label for="11"> Sickling test </label>&nbsp;&nbsp;
<input type="checkbox" id="12"><label for="12"> G6pd </label>&nbsp;&nbsp;
<input type="checkbox" id="13"><label for="13"> D_Dimer  </label>&nbsp;&nbsp;
<input type="checkbox" id="14"><label for="14"> F.B.S </label>&nbsp;&nbsp;
<input type="checkbox" id="15"><label for="15"> R.B.S </label>&nbsp;&nbsp;
<input type="checkbox" id="16"><label for="16">P,PBS</label>&nbsp;&nbsp;
</div>
<br>
<div class="inputcheckbox">
<input type="checkbox" id="17"><label for="17"> HBA:C </label>&nbsp;&nbsp;
<input type="checkbox" id="18"><label for="18">KFT (H)</label>&nbsp;&nbsp;
<select name="nafsy">
<option value="5">Urea</option>
<option value="6">Creatinine </option>
</select>
<input type="checkbox" id="19"><label for="19">LFT</label>&nbsp;&nbsp;
<select name="nafsy"><option value="7">SGOT </option>
<option value="8">SGPT </option>
<option value="9">Bilirubin total </option>
<option value="10">Bilirubin Direct </option></select>
<input type="checkbox" id="20"><label for="20">ALK.Phospats</label>&nbsp;&nbsp;
<input type="checkbox" id="21"><label for="21"> Albumin </label>&nbsp;&nbsp;
<input type="checkbox" id="22"><label for="22"> Electrolytes </label>&nbsp;&nbsp;
<input type="checkbox" id="23"><label for="23"> Cardiac Enzyme </label>&nbsp;&nbsp;
<input type="checkbox" id="24"><label for="24"> Lipid </label>&nbsp;&nbsp;
</div>
<br>
<div class="inputcheckbox">
<input type="checkbox" id="25"><label for="25"> Uricacid </label>&nbsp;&nbsp;
<input type="checkbox" id="26"><label for="26">ASO</label>&nbsp;&nbsp;
<input type="checkbox" id="27"><label for="27">C.R.P</label>&nbsp;&nbsp;
<input type="checkbox" id="28"><label for="28">RF</label>&nbsp;&nbsp;
<input type="checkbox" id="29"><label for="29">Widol test</label>&nbsp;&nbsp;
<input type="checkbox" id="30"><label for="30">Brucella A+M</label>&nbsp;&nbsp;
<input type="checkbox" id="31"><label for="31">BLOOD Group</label>&nbsp;&nbsp;
<input type="checkbox" id="32"><label for="32">TB</label>&nbsp;&nbsp;
</div>
<br>
<div class="inputcheckbox">
<input type="checkbox" id="33"><label for="33">HIV</label>&nbsp;&nbsp;
<input type="checkbox" id="34"><label for="34">HCV</label>&nbsp;&nbsp;
<input type="checkbox" id="35"><label for="35">HBS-Ag</label>&nbsp;&nbsp;
<input type="checkbox" id="36"><label for="36">VDRL</label>&nbsp;&nbsp;
<input type="checkbox" id="37"><label for="37">H.PYLORI RB</label>&nbsp;&nbsp;
<input type="checkbox" id="38"><label for="38">H.PYLORI AG</label>&nbsp;&nbsp;
</div>

<br>
       <input class="submitnew" type="submit" value="submit" name="sub">
</div>
</form>

</div>
      </main>
         


<footer class="footer">

</footer>

</body>
</html>