<!DOCTYPE html>
<html>
<head>


<title> Select Test </title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/style1.css" rel="stylesheet">
<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" >

</head>
<?php

include 'templats/header.php';
include 'templats/navbar.php';
include '../includes/db.php'; // استيراد ملف الاتصال بقاعدة البيانات

date_default_timezone_set("Asia/Aden");
$pat_date = date("Y-m-d");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$pat_id = 0;
if (isset($_POST['select']) && isset($_POST['pat_id'])) {
    $pat_id = test_input($_POST['pat_id']);
    $pat_id = mysqli_real_escape_string($conn, $pat_id);
    
    $s = mysqli_query($conn, "SELECT * FROM blood_test WHERE pat_id='$pat_id'");
    
    if (mysqli_num_rows($s) > 0) {
        while ($row = mysqli_fetch_array($s)) {
            echo "<tr>";
            echo "<td> djgdhgdjhg " . $row['pat_id'] . "</td>";
            echo "</tr>";
        }
    } else {
        echo "No results found.";
    }
}

$conn->close(); // إغلاق الاتصال
?>

<body> 	
<main>


                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
          <div class="table-responsive">
          <table id="mytable" cellspacing="0" cellpadding="0"  class="table table-dark table-striped table-bordered table-hover table-active "  >
          <tr>
          
</tr>
<tr>
<td colspan='5'>
          <h5> Patient No : <input type="number" id="nosession" name="pat_id"/>  </h5>
            </td>
<td colspan='3' >
              <input type="submit" value="استعلام" class="btn btn-warning " name="select" style="width:180px; "/>
              </td>
					  <td>
             <button type="button" onclick="location.href='select_blood_test.php';" class="btn btn-primary  waves-effect " class="glyphicon glyphicon-search" > تحديث الصفحــة </button>
              </td>  
          </tr>
          </table>
</div>
</form>


<!-- جدول الاستعلام عن نتائج الفحوصات -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
<div class="table-responsive card card-cascade narrower">
<div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-left">
<table  class="table table-striped table-bordered table-hover table-bordered">
<tr>
<td colspan='8'>
   <h2 class="label label-danger" style="text-align: center;"> <span style="text-align: center; color:green;"> جـــدول الاستعــلام عن النتائـــج </span></h2>
</td>
</tr>
<tr>
<th style="width:15%;" > ID </th>
<th style="width:15%;" > HB </th>
<th style="width:15%;" > WBC </th>
<th style="width:15%;" > Neutrophil </th>
<th style="width:15%;" > Lymphocyte </th>
<th style="width:15%;" > Monocyte </th>
<th style="width:15%;" > Esoinophil </th>
<th style="width:15%;" > Platelats </th>
<th style="width:15%;" > ESR </th>
<th style="width:15%;" > Malaria </th>
<th style="width:15%;" > CT </th>
<th style="width:15%;" > PT Patient </th>
<th style="width:15%;" > PT Control </th>
<th style="width:15%;" > INR </th>
<th style="width:15%;" > BT </th>
<th style="width:15%;" > Reticulocyte </th>
<th style="width:15%;" > Sickling Test </th>
<th style="width:15%;" > PTT </th>
<th style="width:15%;" > PTT Control </th>
<th style="width:15%;" > D_Dimer </th>
<th style="width:15%;" > F.B.S </th>
<th style="width:15%;" > R.B.S </th>
<th style="width:15%;" > P.PBS </th>
<th style="width:15%;" > HBA 1C </th>
<th style="width:15%;" > Urea </th>
<th style="width:15%;" > Creatinine </th>
<th style="width:15%;" > S.Got </th>
<th style="width:15%;" > S.Gpt </th>
<th style="width:15%;" > Total Bilirubin </th>
<th style="width:15%;" > Dirict Bilirubin </th>
<th style="width:15%;" > ALK.Phospats </th>
<th style="width:15%;" > Albumin </th>
<th style="width:15%;" > Ca++ </th>
<th style="width:15%;" > K+ </th>
<th style="width:15%;" > Na+ </th>
<th style="width:15%;" > Cl- </th>
<th style="width:15%;" > Mg++ </th>
<th style="width:15%;" > C.K </th>
<th style="width:15%;" > CK-MB </th>
<th style="width:15%;" > L.D.H </th>
<th style="width:15%;" > Cholesterol </th>
<th style="width:15%;" > Triglyceride </th>
<th style="width:15%;" > LDL </th>
<th style="width:15%;" > HDL </th>
<th style="width:15%;" > Uricacid </th>
<th style="width:15%;" > T.Patinte </th>
<th style="width:15%;" > ASO </th>
<th style="width:15%;" > RF </th>
<th style="width:15%;" > Salmonella (O) </th>
<th style="width:15%;" > Salmonella (H) </th>
<th style="width:15%;" > Salmonella (A) </th>
<th style="width:15%;" > Salmonella (B) </th>
<th style="width:15%;" > Abrotus </th>
<th style="width:15%;" > Maletenos </th>
<th style="width:15%;" > Blood Group </th>
<th style="width:15%;" > TB </th>
<th style="width:15%;" > HIV </th>
<th style="width:15%;" > HCV </th>
<th style="width:15%;" > HBS.AG </th>
<th style="width:15%;" > VDRL </th>
<th style="width:15%;" > H.PYLORI RB </th>
<th style="width:15%;" > H.PYLORI AG </th>
<th style="width:15%;" > Ethanol </th>
<th style="width:15%;" > Dlhjpam </th>
<th style="width:15%;" > Marijuana </th>
<th style="width:15%;" > Tramedol </th>
<th style="width:15%;" > Heroin </th>
<th style="width:15%;" > Pethidine </th>
<th style="width:15%;" > Cocaine </th>
<th style="width:15%;" > Amphetamine </th>
<th style="width:15%;" > T3 </th>
<th style="width:15%;" > T4 </th>
<th style="width:15%;" > TSH </th>
<th style="width:15%;" > Prolactin </th>
<th style="width:15%;" > PSA </th>
<th style="width:15%;" > PS3 </th>
<th style="width:15%;" > Vit-B12 </th>
<th style="width:15%;" > Vit-D3 </th>
<th style="width:15%;" > CA 153 </th>
<th style="width:15%;" > CA 125 </th>
<th style="width:15%;" > Date </th>
</tr>

 <?php 
  if($pat_id>0){
while($row =mysqli_fetch_array($s)){
    echo "<tr>";
        echo "<td title='ID' >" .$row['pat_id']."</td>";
        echo "<td title='HB' >" .$row['hb']."</td>";
        echo "<td title='WBC' >" .$row['wbc']."</td>";

        echo "<td title='Neutrophil' >" .$row['neutrophil']."</td>";
        echo "<td title='Lymphocyte' >" .$row['lymphocyte']."</td>";
        echo "<td title='Monocyte' >" .$row['monocyte']."</td>";
        echo "<td title='Esoinophil' >" .$row['esoinophil']."</td>";


        echo "<td title='Platelats' >" .$row['platelats']."</td>";
        echo "<td title='ESR' >" .$row['esr']."</td>";
        echo "<td title='Malaria' >" .$row['malaria']."</td>";
        echo "<td title='CT' >" .$row['ct']."</td>";
        echo "<td title='PT' >" .$row['pt']."</td>";
        echo "<td title='PT Control' >" .$row['ptc']."</td>";
        echo "<td title='INR' >" .$row['inr']."</td>";
        echo "<td title='BT' >" .$row['bt']."</td>";
        echo "<td title='Reticulocyte' >" .$row['reticulocyte']."</td>";
        echo "<td title='Sickling' >" .$row['sickling']."</td>";
        echo "<td title='PTT' >" .$row['ptt']."</td>";
        echo "<td title='PTT Control' >" .$row['pttc']."</td>";
        echo "<td title='D.D_Dimer' >" .$row['d_dimer']."</td>";
        echo "<td title='FBS' >" .$row['fbs']."</td>";
        echo "<td title='RBS' >" .$row['rbs']."</td>";
        echo "<td title='P.PBS' >" .$row['p_pbs']."</td>";
        echo "<td title='HBA' >" .$row['hba']."</td>";
        echo "<td title='Urea' >" .$row['urea']."</td>";
        echo "<td title='Creatinine' >" .$row['creatinine']."</td>";
        echo "<td title='S.GOT' >" .$row['s_got']."</td>";
        echo "<td title='S.GPT' >" .$row['s_gpt']."</td>";
        echo "<td title='T.ilirubin' >" .$row['total_bilirubin']."</td>";
        echo "<td title='D.Bilirubin' >" .$row['dirict_bilirubin']."</td>";
        echo "<td title='alk_phospats' >" .$row['alk_phospats']."</td>";
        echo "<td title='Albumin' >" .$row['albumin']."</td>";
        echo "<td title='Ca++' >" .$row['ca']."</td>";
        echo "<td title='K+' >" .$row['k']."</td>";
        echo "<td title='Na+' >" .$row['na']."</td>";
        echo "<td title='CL+' >" .$row['cl']."</td>";
        echo "<td title='MG++' >" .$row['mg']."</td>";
        echo "<td title='CK' >" .$row['ck']."</td>";
        echo "<td title='Ck_mb' >" .$row['ck_mb']."</td>";
        echo "<td title='LDH' >" .$row['ldh']."</td>";
        echo "<td title='Cholesterol' >" .$row['cholesterol']."</td>";
        echo "<td title='Triglyceride' >" .$row['triglyceride']."</td>";
        echo "<td title='LDL' >" .$row['ldl']."</td>";
        echo "<td title='HDL' >" .$row['hdl']."</td>";
        echo "<td title='Uricacid' >" .$row['uricacid']."</td>";
        echo "<td title='T.Patient' >" .$row['t_patinte']."</td>";
        echo "<td title='ASO' >" .$row['aso']."</td>";
        echo "<td title='RF' >" .$row['rf']."</td>";
        echo "<td title='Salmonella (O)' >" .$row['salmon_o']."</td>";
        echo "<td title='Salmonella (H)' >" .$row['salmon_h']."</td>";
        echo "<td title='Salmonella (A)' >" .$row['salmon_a']."</td>";
        echo "<td title='Salmonella (B)' >" .$row['salmon_b']."</td>";
        echo "<td title='Abrotus' >" .$row['brucella_a']."</td>";
        echo "<td title='Maletenos' >" .$row['brucella_m']."</td>";
        echo "<td title='blood_group' >" .$row['blood_group']."</td>";
        echo "<td title='TB' >" .$row['tb']."</td>";
        echo "<td title='HIV' >" .$row['hiv']."</td>";
        echo "<td title='HCV' >" .$row['hcv']."</td>";
        echo "<td title='HBS.AG' >" .$row['hbs_ag']."</td>";
        echo "<td title='VDRL' >" .$row['vdrl']."</td>";
        echo "<td title='H.PYLORI RB' >" .$row['h_pylori_rb']."</td>";
        echo "<td title=' H.PYLORI AG' >" .$row['h_pylori_ag']."</td>";

        echo "<td title='Ethanol' >" .$row['ethanol']."</td>";
        echo "<td title='Dlhjpam' >" .$row['dlhjpam']."</td>";
        echo "<td title='Marijuana' >" .$row['marijuana']."</td>";
        echo "<td title='Tramedol' >" .$row['tramedol']."</td>";
        echo "<td title='Heroin' >" .$row['heroin']."</td>";
        echo "<td title='Pethidine' >" .$row['pethidine']."</td>";
        echo "<td title='Cocaine' >" .$row['cocaine']."</td>";
        echo "<td title='Amphetamine' >" .$row['amphetamine']."</td>";
        echo "<td title='T3' >" .$row['t3']."</td>";
        echo "<td title='T4' >" .$row['t4']."</td>";
        echo "<td title='TSH' >" .$row['tsh']."</td>";
        echo "<td title='Prolactin' >" .$row['prolactin']."</td>";
        echo "<td title='PSA' >" .$row['psa']."</td>";
        echo "<td title='PS3' >" .$row['ps3']."</td>";
        echo "<td title='Vit-B12' >" .$row['vitb']."</td>";
        echo "<td title='Vit-D3' >" .$row['vitd']."</td>";
        echo "<td title='CA 153' >" .$row['ca153']."</td>";
        echo "<td title='CA 125' >" .$row['ca125']."</td>";



        echo "<td title='Date' >" .$row['today_date']."</td>";
        
    echo "</tr>";    
    }
  }
 
?>
</table>
</div>
</div>
</form>
</main>
</body> 	
</html>