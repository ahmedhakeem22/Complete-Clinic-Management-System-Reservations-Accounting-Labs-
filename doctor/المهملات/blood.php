
<?php include 'templates/header.php';
	include 'templates/navbar.php';
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
<input type="checkbox" id="1"><label for="1">  HB </label>&nbsp;&nbsp;
<input type="checkbox" id="2"><label for="2">  WBC </label>&nbsp;&nbsp;
<input type="checkbox" id="3"><label for="3">  Neutrophil </label>&nbsp;&nbsp;
<input type="checkbox" id="4"><label for="4">  Lymphocyte </label>&nbsp;&nbsp;
<input type="checkbox" id="5"><label for="5">  Monocyte </label>&nbsp;&nbsp;
<input type="checkbox" id="6"><label for="6">  Eosinophil </label>&nbsp;&nbsp;
<input type="checkbox" id="7"><label for="7">  RBS </label>&nbsp;&nbsp;
<input type="checkbox" id="8"><label for="8">  Urea </label>&nbsp;&nbsp;
</div>
<br>
<div class="inputcheckbox">
<input type="checkbox" id="9"><label for="9"> Creatinine </label>&nbsp;&nbsp;
<input type="checkbox" id="10"><label for="10"> S.GOT </label>&nbsp;&nbsp;
<input type="checkbox" id="11"><label for="11"> S.GPT </label>&nbsp;&nbsp;
<input type="checkbox" id="12"><label for="12"> Total Brilirubin </label>&nbsp;&nbsp;
<input type="checkbox" id="13"><label for="13"> Direct Brilirubin  </label>&nbsp;&nbsp;
<input type="checkbox" id="14"><label for="14"> A.S.O </label>&nbsp;&nbsp;
<input type="checkbox" id="15"><label for="15"> C.R.P </label>&nbsp;&nbsp;
<input type="checkbox" id="16"><label for="16">R.F</label>&nbsp;&nbsp;
</div>
<br>
<div class="inputcheckbox">
<input type="checkbox" id="17"><label for="17"> Widal Test Salmonella (O) </label>&nbsp;&nbsp;
<input type="checkbox" id="18"><label for="18">Widal Test Salmonella (H)</label>&nbsp;&nbsp;
<input type="checkbox" id="19"><label for="19">Widal Test Salmonella (A)</label>&nbsp;&nbsp;
<input type="checkbox" id="20"><label for="20">Widal Test Salmonella (B)</label>&nbsp;&nbsp;
<input type="checkbox" id="21"><label for="21"> Marijuana </label>&nbsp;&nbsp;
<input type="checkbox" id="22"><label for="22"> Amphetamin </label>&nbsp;&nbsp;
<input type="checkbox" id="23"><label for="23"> Cocaine </label>&nbsp;&nbsp;
<input type="checkbox" id="24"><label for="24"> Heroin </label>&nbsp;&nbsp;
</div>
<br>
<div class="inputcheckbox">
<input type="checkbox" id="25"><label for="25"> PT Patient </label>&nbsp;&nbsp;
<input type="checkbox" id="26"><label for="26">PTT Patient</label>&nbsp;&nbsp;
<input type="checkbox" id="27"><label for="27">INR</label>&nbsp;&nbsp;
<input type="checkbox" id="28"><label for="28">ESR</label>&nbsp;&nbsp;
<input type="checkbox" id="29"><label for="29">Malari</label>&nbsp;&nbsp;
<input type="checkbox" id="30"><label for="30">Cholestrol</label>&nbsp;&nbsp;
<input type="checkbox" id="31"><label for="31">Triglyceride</label>&nbsp;&nbsp;
<input type="checkbox" id="32"><label for="32">HDL</label>&nbsp;&nbsp;
</div>
<br>
<div class="inputcheckbox">
<input type="checkbox" id="33"><label for="33">LDL</label>&nbsp;&nbsp;
<input type="checkbox" id="34"><label for="34">Ca++</label>&nbsp;&nbsp;
<input type="checkbox" id="35"><label for="35">K+</label>&nbsp;&nbsp;
<input type="checkbox" id="36"><label for="36">Na+</label>&nbsp;&nbsp;
<input type="checkbox" id="37"><label for="37">H.pylorl</label>&nbsp;&nbsp;
<input type="checkbox" id="38"><label for="38">HIV</label>&nbsp;&nbsp;
<input type="checkbox" id="39"><label for="39">HBS-Ag</label>&nbsp;&nbsp;
<input type="checkbox" id="40"><label for="40">HCV</label>&nbsp;&nbsp;
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