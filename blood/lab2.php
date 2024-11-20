<?php 
// تضمين ملفات الهيدر والنافبار
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';

// تضمين ملف الاتصال بقاعدة البيانات من المسار المحدد
include '../includes/db.php';

// تهيئة متغير معرّف المريض
$pat_idd = 0;

// التحقق من إرسال النموذج
if(isset($_GET['Submit_pation']) && isset($_GET['pat_id'])){
    // تنظيف مدخلات المستخدم
    $pat_idd = intval($_GET['pat_id']);
    
    // استخدام استعلام محضر لتحسين الأمان
    $stmt = $conn->prepare("SELECT fname, age, gander, phone FROM patinte WHERE pat_id = ?");
    $stmt->bind_param("i", $pat_idd);
    $stmt->execute();
    $r = $stmt->get_result();
    
    // إغلاق الاستعلام
    $stmt->close();
}

// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>

<title> Insert test </title>
<link href="css/bootstrap.min.css" rel="stylesheet"/>
<link href="css/style.css" rel="stylesheet"/>
<link href="css/style1.css" rel="stylesheet"/>
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet"/>

</head>

<body> 




    <main>



                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
          <div class="table-responsive ">
          <table id="mytable" cellspacing="0" cellpadding="0"  class="table table-dark table-striped table-bordered table-hover table-active "  >
          <tr>
            <td>
            <label for="no.p">  Patient No : </label>
            <input type="number" id="nosession" name="pat_id"/>
            </td>
        
            <!--  <td>
              <label for="no.p">Patient name: </label>
              </td>
-->
              <td>
             &nbsp; <input type="submit" value="استعـــلام" class="btn btn-warning" name="Submit_pation" style="width:180px;"/>
              </td>
              
			  
					  <td>
             <button type="button" onclick="location.href='select_blood_test.php';" class="btn btn-danger " class="glyphicon glyphicon-search" > استعلام عن فحص </button>
              </td>  
          </tr>
    
          <?php 
          
  if($pat_idd>0){
while($row =mysqli_fetch_array($r)){
 
    echo "<tr>";
    echo "<td> Name : " .$row['fname']."</td>";
      echo "<td> Age : " .$row['age']."</td>";
        echo "<td> Gander : " .$row['gander']."</td>";
          echo "<td> Phone : " .$row['phone']."</td>";
    echo "</tr>";
    
    
    }
  }
 
?>
          </table>
</div>
</form>
<!--  جدول إدخال نتائج الفحوصات -->
<form action="prent_save.php" method="GET">



<div class="table-responsive card card-cascade narrower" >
<div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
<table cellpadding='5' cellspacing="2" style="width:98%; margin:20px; "  class="table table-striped table-bordered table-hover table-active ">
<tr>
<td>
            <label for="no.p">  Patient No : </label>
            <input type="number" id="nosession" name="pat_id"/>
</td>
            
<td>
			  &nbsp; &nbsp; &nbsp;<input type="submit" value="ادخــال" class="btn btn-success " name="Submit" style="width:180px;"/>
</td>
</tr>
<tr>
<td colspan='7' >
   <h2 class="label label-danger" style="text-align: center;"> <span style="text-align: center; color:red;">جـــدول إدخـــال نتائـــج الفحوصـــات</span></h2>
</td>

</tr>

     <tr>
<td colspan='7'>
   <h2 class="label label-danger" style="text-align: center;"> <span class="label label-danger  badge " style="text-align: center; color:Brown;"> HAEMATOLOGY </span></h2>
</td>
     </tr>

<tr>

 <td>
    <label for="cbc"> <mark style="color:Brown;" > <abbr title=" (CBC) مجموعة فحوصات  "> <strong> CBC </strong> </abbr> </mark> </label> <br/>
  </td>

	<td>
    <label for="hb" style="color:Brown;" > HB :</label> <br/>
    <textarea value="2" id="test[]" cols="25" rows="1" name="hb"></textarea>
  </td>
  <td>
    <label for="wbc" style="color:Brown;" > WBC :</label> <br/>
    <textarea value="3" id="test[]" cols="25" rows="1" name="wbc"></textarea>
  </td>
    <td>
    <label for="cbc" >  <mark style="color:#990099;" > <abbr title=" (DIFF) مجموعة فحوصات  "> <strong> DIFF. </strong> </abbr> </mark></label> <br/>
  </td>
	<td>
    <label for="hb" style="color:#990099;" > Neutrophil :</label> <br/>
    <textarea value="54" id="test[]" cols="25" rows="1" name="neutrophil"></textarea>
  </td>
  <td>
    <label for="wbc" style="color:#990099;" > Lymphocyte :</label> <br/>
    <textarea value="55" id="test[]" cols="25" rows="1" name="lymphocyte"></textarea>
  </td>
  	<td>
    <label for="hb" style="color:#990099;" > Monocyte :</label> <br/>
    <textarea value="56" id="test[]" cols="25" rows="1" name="monocyte"></textarea>
  </td>

</tr>
<tr>
  <td>
    <label for="wbc" style="color:#990099;" > Esoinophil :</label> <br/>
    <textarea value="57" id="test[]" cols="25" rows="1" name="esoinophil"></textarea>
  </td>
<td>
    <label for="Platelats"> Platelats :</label> <br/>
    <textarea value="4" id="test[]" cols="25" rows="1" name="platelats"></textarea>
  </td>

      <td>
    <label for="ESR"> ESR :</label> <br/>
    <textarea value="5" id="test[]" cols="25" rows="1" name="esr"></textarea>
  </td> 

  <td>
    <label for="malaria"> Malaria : </label> <br/>
    <textarea value="6" id="test[]" cols="25" rows="1" name="malaria"></textarea>
  </td>  

<td>
    <label for="ct"> CT:</label> <br/>
    <textarea value="7" id="test[]" cols="25" rows="1" name="ct" ></textarea>
  </td>
<td>
            <label for="pt"> PT Patinte :</label> <br/>
            <textarea value="8" id="test[]" cols="25" rows="1" name="pt" ></textarea>
            </td>

 <td>
            <label for="pt"> PT Control :</label> <br/>
            <textarea value="8" id="test[]" cols="25" rows="1" name="ptc" ></textarea>
            </td>

 
 
 
 
</tr>

<tr>
<td>
           <label for="inr"> INR :</label> <br/>
           <textarea value="9" id="test[]" cols="25" rows="1" name="inr" ></textarea>
           </td>
<td>
              <label for="bt"> BT :</label> <br/>
              <textarea value="10" id="test[]" cols="25" rows="1" name="bt"></textarea>
              </td>

<td>
    <label for="reticulocyte"> Reticulocyte :</label> <br/>
    <textarea value="11" id="test[]" cols="25" rows="1" name="reticulocyte"></textarea>
  </td>

  <td>
    <label for="sickling"> Sickling Test :</label> <br/>
    <textarea value="12" id="test[]" cols="25" rows="1" name="sickling"></textarea>
  </td>

  <td>
    <label for="ptt"> PTT Patinte :</label><br/>
    <textarea value="13" id="test[]" cols="25" rows="1" name="ptt"></textarea>
  </td>
  <td>
    <label for="ptt"> PTT Control :</label><br/>
    <textarea value="13" id="test[]" cols="25" rows="1" name="pttc"></textarea>
  </td>



  <td>
    <label for="d_dimer"> D_Dimer :</label><br/>
    <textarea value="14" id="test[]" cols="25" rows="1" name="d_dimer" ></textarea>
  </td>
</tr>

     <tr>
<td colspan='7'>
   <h2 class="label label-danger" style="text-align: center;"> <span  class="label label-danger  badge" style="text-align: center; color:Brown;"> BIOCHEMEISTRY </span></h2>
</td>
     </tr>
 
<tr>
<td>
    <label for="fbs"> F.B.S :</label><br/>
    <textarea value="15" id="test[]" cols="25" rows="1" name="fbs"></textarea>
  </td>

  <td>
    <label for="rbs"> R.B.S :</label><br/>
    <textarea value="16" id="test[]" cols="25" rows="1" name="rbs"></textarea>
  </td>
  <td>
    <label for="p_pbs"> P.PBS  :</label><br/>
    <textarea value="17" id="test[]" cols="25" rows="1" name="p_pbs"></textarea>
  </td>

  <td>
    <label for="hba"> HBA 1C :</label><br/>
    <textarea value="18" id="test[]" cols="25" rows="1" name="hba"></textarea>
  </td>
  
  <td>
    <label for="KFT" style="color:Brown;" > <mark style="color:Brown;" > <abbr title=" (KFT) مجموعة فحوصات  "> <strong> KFT </strong> </abbr> </mark></label><br/>
  </td>

  <td>
    <label for="Urea" style="color:Brown;" > Urea :</label><br/>
    <textarea value="19" id="test[]" cols="25" rows="1" name="urea"></textarea>
  </td>
  <td>
    <label for="Creatinine" style="color:Brown;" > Creatinine :</label><br/>
    <textarea value="20" id="test[]" cols="25" rows="1" name="creatinine"></textarea>
  </td>

</tr>


<tr>


  <td>
    <label for="LFT"> <mark style="color:Brown;" > <abbr title=" (LFT) مجموعة فحوصات  ">  <strong>  LFT : </strong></abbr> </mark> </label><br/>
  </td>
 
 <td>
    <label for="S.Got" style="color:Brown;" > S.Got :</label><br/>
    <textarea value="21" id="test[]" cols="25" rows="1" name="s_got"></textarea>
  </td>
<td>
  <label for="S.Gpt" style="color:Brown;" > S.Gpt :</label><br/>
    <textarea value="22" id="test[]" cols="25" rows="1" name="s_gpt"></textarea>
  </td>

  <td>
    <label for="Total Bilirubin" style="color:Brown;" > Total Bilirubin :</label><br/>
    <textarea value="23" id="test[]" cols="25" rows="1" name="total_bilirubin"></textarea>
  </td>
  <td>
    <label for="dirict_bilirubin"  style="color:Brown;" > Dirict Bilirubin :</label><br/>
    <textarea value="24" id="test[]" cols="25" rows="1" name="dirict_bilirubin"></textarea>
  </td>

    
    <td>
    <label for="ALK.Phospats"> ALK.Phospats :</label><br/>
    <textarea value="25" id="test[]" cols="25" rows="1" name="alk_phospats"></textarea>
  </td>

    <td>
    <label for="Albumin"> Albumin :</label><br/>
    <textarea value="26" id="test[]" cols="25" rows="1" name="albumin"></textarea>
  </td>

</tr>




<tr>
    <td>
    <label for="electrolytes" style="color:Brown;" ><mark style="color:Brown;" > <abbr title=" (Electrolytes) مجموعة فحوصات  "> <strong> Electrolytes : </strong> </abbr> </mark>   </label><br/>
  </td>

  <td>
    <label for="ca++" style="color:Brown;" > Ca++ :</label><br/>
    <textarea value="27" id="test[]" cols="25" rows="1" name="ca"></textarea>
  </td>

  <td>
    <label for="K+" style="color:Brown;" > K+ :</label><br/>
    <textarea value="28" id="test[]" cols="25" rows="1" name="k"></textarea>
  </td>
  <td>
    <label for="na+" style="color:Brown;" > Na+ :</label><br/>
    <textarea value="29" id="test[]" cols="25" rows="1" name="na"></textarea>
  </td>
    <td>
    <label for="Cl-" style="color:Brown;" > Cl- :</label><br/>
    <textarea value="30" id="test[]" cols="25" rows="1" name="cl"></textarea>
  </td>

    <td>
    <label for="Mg++" style="color:Brown;" > Mg++ :</label><br/>
    <textarea value="31" id="test[]" cols="25" rows="1" name="mg"></textarea>
  </td>

<td>
    <label for="Cardiac Enzyme"> <mark style="color:Brown;" > <abbr title=" (Cardiac Enzyme) مجموعة فحوصات  "> <strong> Cardiac Enzyme  : </strong></abbr> </mark>  </label><br/>
  </td>
    
</tr>


<tr>




 <td>
    <label for="C.K" style="color:Brown;" > C.K :</label><br/>
    <textarea value="32" id="test[]" cols="25" rows="1" name="ck"></textarea>
  </td>

  <td>
    <label for="CK-MB" style="color:Brown;" > CK-MB :</label><br/>
    <textarea value="33" id="test[]" cols="25" rows="1" name="ck_mb"></textarea>
  </td>
  <td>
    <label for="L.D.H" style="color:Brown;" >L.D.H :</label><br/>
    <textarea value="34" id="test[]" cols="25" rows="1" name="ldh"></textarea>
  </td>

  
    <td>
    <label for="Lipid"> <mark style="color:#990099;" > <abbr title=" (DIFF) مجموعة فحوصات  "> <strong> Lipid : </strong> </abbr> </mark> </label><br/>
  </td>

    <td>
    <label for="Cholesterol" style="color:#990099;" > Cholesterol :</label><br/>
    <textarea value="35" id="test[]" cols="25" rows="1" name="cholesterol"></textarea>
  </td>

    <td>
    <label for="Triglyceride" style="color:#990099;" > Triglyceride :</label><br/>
    <textarea value="36" id="test[]" cols="25" rows="1" name="triglyceride"></textarea>
  </td>

    <td>
    <label for="LDL" style="color:#990099;" > LDL :</label><br/>
    <textarea value="37" id="test[]" cols="25" rows="1" name="ldl"></textarea>
  </td>

</tr>



<tr>

      <td>
    <label for="HCV" style="color:#990099;" > HDL :</label><br/>
    <textarea value="38" id="test[]" cols="25" rows="1" name="hdl"></textarea>
  </td>


    <td>
    <label for="Uricacid"> Uricacid :</label><br/>
    <textarea value="39" id="test[]" cols="25" rows="1" name="uricacid"></textarea>
  </td>

    <td>
    <label for="T.Patinte"> T.Patinte :</label><br/>
    <textarea value="40" id="test[]" cols="25" rows="1" name="t_patinte"></textarea>
  </td>

</tr>

     <tr>
<td colspan='7'>
   <h2 class="label label-danger" style="text-align: center;"> <span class="label label-danger  badge" style="text-align: center; color:Brown;"> SEROLOGY </span></h2>
</td>
     </tr>


     <tr>




 <td>
    <label for="ASO"> ASO :</label><br/>
    <textarea value="41" id="test[]" cols="25" rows="1" name="aso"></textarea>
  </td>

  <td>
    <label for="C.R.P"> C.R.P :</label><br/>
    <textarea value="42" id="test[]" cols="25" rows="1" name="crp"></textarea>
  </td>
  <td>
    <label for="RF">RF :</label><br/>
    <textarea value="43" id="test[]" cols="25" rows="1" name="rf"></textarea>
  </td>

  
    <td>
    <label for="Widal Test"> Widal Test :</label><br/>
  </td>

    <td>
    <label for="salmon_o"> Salmonella (O) :</label><br/>
    <textarea value="68" id="test[]" cols="25" rows="1" name="salmon_o"></textarea>
  </td>

     <td>
    <label for="salmon_h"> Salmonella (H) :</label><br/>
    <textarea value="69" id="test[]" cols="25" rows="1" name="salmon_h"></textarea>
  </td>

     <td>
    <label for="salmon_a"> Salmonella (A) :</label><br/>
    <textarea value="70" id="test[]" cols="25" rows="1" name="salmon_a"></textarea>
  </td>
</tr>

   <tr>


 <td>
    <label for="salmon_b"> Salmonella (B) :</label><br/>
    <textarea value="71" id="test[]" cols="25" rows="1" name="salmon_b"></textarea>
  </td>

     <td>
    <label for="HIV"> Brucella :</label><br/>
  </td>


    <td>
    <label for="BLOOD Group"> Abrotus :</label><br/>
    <textarea value="72" id="test[]" cols="25" rows="1" name="brucella_a"></textarea>
  </td>

  
    <td>
    <label for="BLOOD Group"> Maletenos :</label><br/>
    <textarea value="73" id="test[]" cols="25" rows="1" name="brucella_m"></textarea>
  </td>


    <td>
    <label for="BLOOD Group"> Blood Group :</label><br/>
    <textarea value="46" id="test[]" cols="25" rows="1" name="blood_group"></textarea>
  </td>

    <td>
    <label for="TB"> TB :</label><br/>
    <textarea value="47" id="test[]" cols="25" rows="1" name="tb"></textarea>
  </td>

 <td>
    <label for="Viral Marker"> <mark style="color:Brown;" > <abbr title=" (Viral Marker) مجموعة فحوصات  "> <strong> Viral Marker : </strong> </abbr> </mark> </label><br/>
  </td>

<tr>

  <td>
    <label for="HIV" style="color:Brown;" > HIV :</label><br/>
    <textarea value="48" id="test[]" cols="25" rows="1" name="hiv"></textarea>
  </td>
  <td>
    <label for="HCV" style="color:Brown;" >HCV :</label><br/>
    <textarea value="49" id="test[]" cols="25" rows="1" name="hcv"></textarea>
  </td>

    <td >
    <label for="HBS.AG" style="color:Brown;" > HBS.AG :</label><br/>
    <textarea value="50" id="test[]" cols="25" rows="1" name="hbs_ag"></textarea>
  </td>

    <td>
    <label for="VDRL"> VDRL :</label><br/>
    <textarea value="51" id="test[]" cols="25" rows="1" name="vdrl"></textarea>
  </td>

    <td>
    <label for="H.PYLORI RB">  H.PYLORI RB :</label><br/>
    <textarea value="52" id="test[]" cols="25" rows="1" name="h_pylori_rb"></textarea>
  </td>

    <td>
    <label for="H.PYLORI AG"> H.PYLORI AG :</label><br/>
    <textarea value="53" id="test[]" cols="25" rows="1" name="h_pylori_ag"></textarea>
  </td>


</tr>
  
</tr>
     <tr>
<td colspan='7'>
   <h2 class="label label-danger" style="text-align: center;"> <span class="label label-danger  badge" style="text-align: center; color:Brown;"> DRUGS </span></h2>
</td>
     </tr>

<tr>


  <td>
    <label for="Ethanol"> Ethanol :</label><br/>
    <textarea value="54" id="test[]" cols="25" rows="1" name="ethanol"></textarea>
  </td>
  <td>
    <label for="d">Diazepam :</label><br/>
    <textarea value="55" id="test[]" cols="25" rows="1" name="dlhjpam"></textarea>
  </td>

  
    <td>
    <label for="Marijuana"> Marijuana :</label><br/>
    <textarea value="56" id="test[]" cols="25" rows="1" name="marijuana"></textarea>
  </td>

    <td>
    <label for="Tramedol"> Tramedol :</label><br/>
    <textarea value="57" id="test[]" cols="25" rows="1" name="tramedol"></textarea>
  </td>

    <td>
    <label for="Heroin">  Heroin :</label><br/>
    <textarea value="58" id="test[]" cols="25" rows="1" name="heroin"></textarea>
  </td>

    <td>
    <label for="Pethidine"> Pethidine :</label><br/>
    <textarea value="59" id="test[]" cols="25" rows="1" name="pethidine"></textarea>
  </td>
    <td>
    <label for="Cocaine">  Cocaine :</label><br/>
    <textarea value="60" id="test[]" cols="25" rows="1" name="cocaine"></textarea>
  </td>

</tr>
<tr>

    <td>
    <label for="Amphetamine"> Amphetamine :</label><br/>
    <textarea value="61" id="test[]" cols="25" rows="1" name="amphetamine"></textarea>
  </td>

</tr>


     <tr>
<td colspan='7'>
   <h2 class="label label-danger" style="text-align: center;"> <span class="label label-danger  badge" style="text-align: center; color:Brown;"> HARMONES </span></h2>
</td>
     </tr>

<tr>

  <td>
    <label for="T3"> T3 :</label><br/>
    <textarea value="62" id="test[]" cols="25" rows="1" name="t3"></textarea>
  </td>
  <td>
    <label for="T4">T4 :</label><br/>
    <textarea value="63" id="test[]" cols="25" rows="1" name="t4"></textarea>
  </td>

  
    <td>
    <label for="TSH"> TSH :</label><br/>
    <textarea value="64" id="test[]" cols="25" rows="1" name="tsh"></textarea>
  </td>

    <td>
    <label for="Prolactin"> Prolactin :</label><br/>
    <textarea value="65" id="test[]" cols="25" rows="1" name="prolactin"></textarea>
  </td>

    <td>
    <label for="PSA">  PSA :</label><br/>
    <textarea value="66" id="test[]" cols="25" rows="1" name="psa"></textarea>
  </td>

    <td>
    <label for="PS3"> PS3 :</label><br/>
    <textarea value="67" id="test[]" cols="25" rows="1" name="ps3"></textarea>
  </td>

 <td>
    <label for="vitb"> Vit-B12 :</label><br/>
    <textarea value="67" id="test[]" cols="25" rows="1" name="vitb"></textarea>
  </td>


</tr>


<tr>

  <td>
    <label for="vitd"> Vit-D3 :</label><br/>
    <textarea value="62" id="test[]" cols="25" rows="1" name="vitd"></textarea>
  </td>
  <td>
    <label for="ca153">CA 153 :</label><br/>
    <textarea value="63" id="test[]" cols="25" rows="1" name="ca153"></textarea>
  </td>

  
    <td>
    <label for="ca125"> CA 125 :</label><br/>
    <textarea value="64" id="test[]" cols="25" rows="1" name="ca125"></textarea>
  </td>


</tr>
</table> 
<div>
</div>
   </form>


   </main>
            
           <footer>
            

           </footer> 
        
</body>

</html>

<script src="js/jquery-3.4.1.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
    <script src="js/fontawesome.min.js"></script> 
        <script src="js/myjs.js."></script> 
        

<!-- كود طباعة -->
<!--
<?php
$message ="<div>
    <table align='center'>
        <tr><td><h1>Reporte de Tipo de Documentos</h1></td></tr>
        <tr><td><h2>Farmaceutica MDC</h2></td></tr>
    </table>
</div>
<div>
    <table style='width:960px; margin:0 auto;'>
        <tr colspan='7'>
            <td><?php echo 'Fecha: '".$time = date('d/m/Y h:i:s A')."; ?></td>
        </tr>
        <tr bgcolor='#CCCCCC' height='30'>
            <td><b>Sr. No.</b></td>
            <td><b>Tipo Documento</b></td>
            <td><b>Cant. Pasos</b></td>
            <td><b>Costo</b></td>
            <td><b>Precio</b></td>
            <td><b>Balance</b></td>
            <td><b>Notifica Cliente</b></td>
        </tr>
    </table>";

echo "<html><head></head><body>" . $message . "<script type='application/javascript'>window.onload=function(){window.print()}</script></body></html>";
?>

