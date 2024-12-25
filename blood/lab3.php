<?php 
// تضمين ملفات الهيدر والنافبار
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';

// تضمين ملف الاتصال بقاعدة البيانات
include '../includes/db.php';

/**
 * التحقق من إرسال النموذج لمعرفة رقم المريض (pat_id)
 */
$pat_idd = 0;
$r = null; // سنخزن نتيجة الاستعلام هنا

if (isset($_GET['Submit_pation']) && isset($_GET['pat_id'])) {
    // تحويل قيمة pat_id إلى عدد صحيح لتجنب مشاكل الحقن أو الأخطاء
    $pat_idd = intval($_GET['pat_id']);
    
    // استخدام استعلام محضر (Prepared Statement) لزيادة الأمان
    $stmt = $conn->prepare("SELECT fname, age, gander, phone FROM patinte WHERE pat_id = ?");
    $stmt->bind_param("i", $pat_idd);
    $stmt->execute();
    $r = $stmt->get_result();
    
    // إغلاق الاستعلام
    $stmt->close();
}

// إغلاق الاتصال بقاعدة البيانات (إن كنت بحاجة لإعادة استخدامه لا تقم بإغلاقه هنا)
$conn->close();
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>Insert Test</title>
    <!-- ربط ملفات الـ CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/style.css" rel="stylesheet"/>
    <link href="css/style1.css" rel="stylesheet"/>
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
</head>
<body> 

    <main>
        <!-- نموذج للاستعلام عن المريض (عرض اسمه ورقم هاتفه وأي معلومات أخرى) -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
            <div class="table-responsive">
                <table id="mytable" class="table table-dark table-striped table-bordered table-hover table-active">
                    <tr>
                        <td>
                            <label for="nosession">Patient No :</label>
                            <input type="number" id="nosession" name="pat_id" />
                        </td>
                        <td>
                            <input type="submit" value="استعـــلام" class="btn btn-warning" name="Submit_pation" style="width:180px;"/>
                        </td>
                        <td>
                            <!-- زر للانتقال إلى صفحة select_blood_test.php -->
                            <button type="button" onclick="location.href='select_blood_test.php';" class="btn btn-danger">
                                استعلام عن فحص
                            </button>
                        </td>  
                    </tr>

                    <?php 
                    // إذا كان هناك رقم مريض pat_idd > 0 ونجح الاستعلام، نقوم بعرض النتائج
                    if ($pat_idd > 0 && $r) {
                        while ($row = mysqli_fetch_array($r)) {
                            echo "<tr>";
                            echo "<td>Name : " . $row['fname'] . "</td>";
                            echo "<td>Age : " . $row['age'] . "</td>";
                            echo "<td>Gander : " . $row['gander'] . "</td>";
                            echo "<td>Phone : " . $row['phone'] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </form>

        <!-- نموذج لإدخال نتائج الفحوصات -->
        <form action="prent_save_s.php" method="GET">
            <div class="table-responsive card card-cascade narrower">
                <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
                    <table cellpadding='5' cellspacing="2" style="width:98%; margin:20px;" class="table table-striped table-bordered table-hover table-active">
                        
                        <!-- إدخال رقم المريض -->
                        <tr>
                            <td>
                                <label for="nosession2">Patient No :</label>
                                <input type="number" id="nosession2" name="pat_id" />
                            </td>
                            <td>
                                <input type="submit" value="ادخــال" class="btn btn-success" name="Submit" style="width:180px;"/>
                            </td>
                        </tr>

                        <!-- عنوان جدول إدخال النتائج -->
                        <tr>
                            <td colspan='7'>
                                <h2 class="label label-danger" style="text-align: center;">
                                    <span style="text-align: center; color:red;">جـــدول إدخـــال نتائـــج الفحوصـــات</span>
                                </h2>
                            </td>
                        </tr>

                        <!-- قسم HAEMATOLOGY -->
                        <tr>
                            <td colspan='7'>
                                <h2 class="label label-danger" style="text-align: center;">
                                    <span class="label label-danger badge" style="text-align: center; color:Brown;">
                                        HAEMATOLOGY
                                    </span>
                                </h2>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label><mark style="color:Brown;">
                                    <abbr title="(CBC) مجموعة فحوصات">
                                        <strong>CBC</strong>
                                    </abbr>
                                </mark></label>
                            </td>
                            <td>
                                <label for="hb" style="color:Brown;">HB :</label><br/>
                                <textarea id="hb" cols="25" rows="1" name="hb"></textarea>
                            </td>
                            <td>
                                <label for="wbc" style="color:Brown;">WBC :</label><br/>
                                <textarea id="wbc" cols="25" rows="1" name="wbc"></textarea>
                            </td>
                            <td>
                                <label>
                                    <mark style="color:#990099;">
                                        <abbr title="(DIFF) مجموعة فحوصات">
                                            <strong>DIFF.</strong>
                                        </abbr>
                                    </mark>
                                </label>
                            </td>
                            <td>
                                <label for="neutrophil" style="color:#990099;">Neutrophil :</label><br/>
                                <textarea id="neutrophil" cols="25" rows="1" name="neutrophil"></textarea>
                            </td>
                            <td>
                                <label for="lymphocyte" style="color:#990099;">Lymphocyte :</label><br/>
                                <textarea id="lymphocyte" cols="25" rows="1" name="lymphocyte"></textarea>
                            </td>
                            <td>
                                <label for="monocyte" style="color:#990099;">Monocyte :</label><br/>
                                <textarea id="monocyte" cols="25" rows="1" name="monocyte"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="esoinophil" style="color:#990099;">Eosinophil :</label><br/>
                                <textarea id="esoinophil" cols="25" rows="1" name="esoinophil"></textarea>
                            </td>
                            <td>
                                <label for="platelats">Platelats :</label><br/>
                                <textarea id="platelats" cols="25" rows="1" name="platelats"></textarea>
                            </td>
                            <td>
                                <label for="esr">ESR :</label><br/>
                                <textarea id="esr" cols="25" rows="1" name="esr"></textarea>
                            </td> 
                            <td>
                                <label for="malaria">Malaria :</label><br/>
                                <textarea id="malaria" cols="25" rows="1" name="malaria"></textarea>
                            </td>  
                            <td>
                                <label for="ct">CT :</label><br/>
                                <textarea id="ct" cols="25" rows="1" name="ct"></textarea>
                            </td>
                            <td>
                                <label for="pt">PT Patient :</label><br/>
                                <textarea id="pt" cols="25" rows="1" name="pt"></textarea>
                            </td>
                            <td>
                                <label for="ptc">PT Control :</label><br/>
                                <textarea id="ptc" cols="25" rows="1" name="ptc"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="inr">INR :</label><br/>
                                <textarea id="inr" cols="25" rows="1" name="inr"></textarea>
                            </td>
                            <td>
                                <label for="bt">BT :</label><br/>
                                <textarea id="bt" cols="25" rows="1" name="bt"></textarea>
                            </td>
                            <td>
                                <label for="reticulocyte">Reticulocyte :</label><br/>
                                <textarea id="reticulocyte" cols="25" rows="1" name="reticulocyte"></textarea>
                            </td>
                            <td>
                                <label for="sickling">Sickling Test :</label><br/>
                                <textarea id="sickling" cols="25" rows="1" name="sickling"></textarea>
                            </td>
                            <td>
                                <label for="ptt">PTT Patient :</label><br/>
                                <textarea id="ptt" cols="25" rows="1" name="ptt"></textarea>
                            </td>
                            <td>
                                <label for="pttc">PTT Control :</label><br/>
                                <textarea id="pttc" cols="25" rows="1" name="pttc"></textarea>
                            </td>
                            <td>
                                <label for="d_dimer">D_Dimer :</label><br/>
                                <textarea id="d_dimer" cols="25" rows="1" name="d_dimer"></textarea>
                            </td>
                        </tr>

                        <!-- قسم BIOCHEMISTRY -->
                        <tr>
                            <td colspan='7'>
                                <h2 class="label label-danger" style="text-align: center;">
                                    <span class="label label-danger badge" style="text-align: center; color:Brown;">
                                        BIOCHEMEISTRY
                                    </span>
                                </h2>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="fbs">F.B.S :</label><br/>
                                <textarea id="fbs" cols="25" rows="1" name="fbs"></textarea>
                            </td>
                            <td>
                                <label for="rbs">R.B.S :</label><br/>
                                <textarea id="rbs" cols="25" rows="1" name="rbs"></textarea>
                            </td>
                            <td>
                                <label for="p_pbs">P.PBS :</label><br/>
                                <textarea id="p_pbs" cols="25" rows="1" name="p_pbs"></textarea>
                            </td>
                            <td>
                                <label for="hba">HBA 1C :</label><br/>
                                <textarea id="hba" cols="25" rows="1" name="hba"></textarea>
                            </td>
                            <td>
                                <label style="color:Brown;">
                                    <mark style="color:Brown;">
                                        <abbr title="(KFT) مجموعة فحوصات">
                                            <strong>KFT</strong>
                                        </abbr>
                                    </mark>
                                </label><br/>
                            </td>
                            <td>
                                <label for="urea" style="color:Brown;">Urea :</label><br/>
                                <textarea id="urea" cols="25" rows="1" name="urea"></textarea>
                            </td>
                            <td>
                                <label for="creatinine" style="color:Brown;">Creatinine :</label><br/>
                                <textarea id="creatinine" cols="25" rows="1" name="creatinine"></textarea>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <label for="LFT">
                                    <mark style="color:Brown;">
                                        <abbr title="(LFT) مجموعة فحوصات">
                                            <strong>LFT :</strong>
                                        </abbr>
                                    </mark>
                                </label><br/>
                            </td>
                            <td>
                                <label for="s_got" style="color:Brown;">S.Got :</label><br/>
                                <textarea id="s_got" cols="25" rows="1" name="s_got"></textarea>
                            </td>
                            <td>
                                <label for="s_gpt" style="color:Brown;">S.Gpt :</label><br/>
                                <textarea id="s_gpt" cols="25" rows="1" name="s_gpt"></textarea>
                            </td>
                            <td>
                                <label for="total_bilirubin" style="color:Brown;">Total Bilirubin :</label><br/>
                                <textarea id="total_bilirubin" cols="25" rows="1" name="total_bilirubin"></textarea>
                            </td>
                            <td>
                                <label for="dirict_bilirubin" style="color:Brown;">Dirict Bilirubin :</label><br/>
                                <textarea id="dirict_bilirubin" cols="25" rows="1" name="dirict_bilirubin"></textarea>
                            </td>
                            <td>
                                <label for="alk_phospats">ALK.Phospats :</label><br/>
                                <textarea id="alk_phospats" cols="25" rows="1" name="alk_phospats"></textarea>
                            </td>
                            <td>
                                <label for="albumin">Albumin :</label><br/>
                                <textarea id="albumin" cols="25" rows="1" name="albumin"></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <label style="color:Brown;">
                                    <mark style="color:Brown;">
                                        <abbr title="(Electrolytes) مجموعة فحوصات">
                                            <strong>Electrolytes :</strong>
                                        </abbr>
                                    </mark>
                                </label><br/>
                            </td>
                            <td>
                                <label for="ca" style="color:Brown;">Ca++ :</label><br/>
                                <textarea id="ca" cols="25" rows="1" name="ca"></textarea>
                            </td>
                            <td>
                                <label for="k" style="color:Brown;">K+ :</label><br/>
                                <textarea id="k" cols="25" rows="1" name="k"></textarea>
                            </td>
                            <td>
                                <label for="na" style="color:Brown;">Na+ :</label><br/>
                                <textarea id="na" cols="25" rows="1" name="na"></textarea>
                            </td>
                            <td>
                                <label for="cl" style="color:Brown;">Cl- :</label><br/>
                                <textarea id="cl" cols="25" rows="1" name="cl"></textarea>
                            </td>
                            <td>
                                <label for="mg" style="color:Brown;">Mg++ :</label><br/>
                                <textarea id="mg" cols="25" rows="1" name="mg"></textarea>
                            </td>
                            <td>
                                <label>
                                    <mark style="color:Brown;">
                                        <abbr title="(Cardiac Enzyme) مجموعة فحوصات">
                                            <strong>Cardiac Enzyme :</strong>
                                        </abbr>
                                    </mark>
                                </label><br/>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                <label for="ck" style="color:Brown;">C.K :</label><br/>
                                <textarea id="ck" cols="25" rows="1" name="ck"></textarea>
                            </td>
                            <td>
                                <label for="ck_mb" style="color:Brown;">CK-MB :</label><br/>
                                <textarea id="ck_mb" cols="25" rows="1" name="ck_mb"></textarea>
                            </td>
                            <td>
                                <label for="ldh" style="color:Brown;">L.D.H :</label><br/>
                                <textarea id="ldh" cols="25" rows="1" name="ldh"></textarea>
                            </td>
                            <td>
                                <label>
                                    <mark style="color:#990099;">
                                        <abbr title="(DIFF) مجموعة فحوصات">
                                            <strong>Lipid :</strong>
                                        </abbr>
                                    </mark>
                                </label><br/>
                            </td>
                            <td>
                                <label for="cholesterol" style="color:#990099;">Cholesterol :</label><br/>
                                <textarea id="cholesterol" cols="25" rows="1" name="cholesterol"></textarea>
                            </td>
                            <td>
                                <label for="triglyceride" style="color:#990099;">Triglyceride :</label><br/>
                                <textarea id="triglyceride" cols="25" rows="1" name="triglyceride"></textarea>
                            </td>
                            <td>
                                <label for="ldl" style="color:#990099;">LDL :</label><br/>
                                <textarea id="ldl" cols="25" rows="1" name="ldl"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="hdl" style="color:#990099;">HDL :</label><br/>
                                <textarea id="hdl" cols="25" rows="1" name="hdl"></textarea>
                            </td>
                            <td>
                                <label for="uricacid">Uric Acid :</label><br/>
                                <textarea id="uricacid" cols="25" rows="1" name="uricacid"></textarea>
                            </td>
                            <td>
                                <label for="t_patinte">T.Patinte :</label><br/>
                                <textarea id="t_patinte" cols="25" rows="1" name="t_patinte"></textarea>
                            </td>
                        </tr>

                        <!-- قسم SEROLOGY -->
                        <tr>
                            <td colspan='7'>
                                <h2 class="label label-danger" style="text-align: center;">
                                    <span class="label label-danger badge" style="text-align: center; color:Brown;">
                                        SEROLOGY
                                    </span>
                                </h2>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="aso">ASO :</label><br/>
                                <textarea id="aso" cols="25" rows="1" name="aso"></textarea>
                            </td>
                            <td>
                                <label for="crp">C.R.P :</label><br/>
                                <textarea id="crp" cols="25" rows="1" name="crp"></textarea>
                            </td>
                            <td>
                                <label for="rf">RF :</label><br/>
                                <textarea id="rf" cols="25" rows="1" name="rf"></textarea>
                            </td>
                            <td>
                                <label>Widal Test :</label><br/>
                            </td>
                            <td>
                                <label for="salmon_o">Salmonella (O) :</label><br/>
                                <textarea id="salmon_o" cols="25" rows="1" name="salmon_o"></textarea>
                            </td>
                            <td>
                                <label for="salmon_h">Salmonella (H) :</label><br/>
                                <textarea id="salmon_h" cols="25" rows="1" name="salmon_h"></textarea>
                            </td>
                            <td>
                                <label for="salmon_a">Salmonella (A) :</label><br/>
                                <textarea id="salmon_a" cols="25" rows="1" name="salmon_a"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="salmon_b">Salmonella (B) :</label><br/>
                                <textarea id="salmon_b" cols="25" rows="1" name="salmon_b"></textarea>
                            </td>
                            <td>
                                <label>Brucella :</label><br/>
                            </td>
                            <td>
                                <label for="brucella_a">Abrotus :</label><br/>
                                <textarea id="brucella_a" cols="25" rows="1" name="brucella_a"></textarea>
                            </td>
                            <td>
                                <label for="brucella_m">Maletenos :</label><br/>
                                <textarea id="brucella_m" cols="25" rows="1" name="brucella_m"></textarea>
                            </td>
                            <td>
                                <label for="blood_group">Blood Group :</label><br/>
                                <textarea id="blood_group" cols="25" rows="1" name="blood_group"></textarea>
                            </td>
                            <td>
                                <label for="tb">TB :</label><br/>
                                <textarea id="tb" cols="25" rows="1" name="tb"></textarea>
                            </td>
                            <td>
                                <label>
                                    <mark style="color:Brown;">
                                        <abbr title="(Viral Marker) مجموعة فحوصات">
                                            <strong>Viral Marker :</strong>
                                        </abbr>
                                    </mark>
                                </label><br/>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="hiv" style="color:Brown;">HIV :</label><br/>
                                <textarea id="hiv" cols="25" rows="1" name="hiv"></textarea>
                            </td>
                            <td>
                                <label for="hcv" style="color:Brown;">HCV :</label><br/>
                                <textarea id="hcv" cols="25" rows="1" name="hcv"></textarea>
                            </td>
                            <td>
                                <label for="hbs_ag" style="color:Brown;">HBS.AG :</label><br/>
                                <textarea id="hbs_ag" cols="25" rows="1" name="hbs_ag"></textarea>
                            </td>
                            <td>
                                <label for="vdrl">VDRL :</label><br/>
                                <textarea id="vdrl" cols="25" rows="1" name="vdrl"></textarea>
                            </td>
                            <td>
                                <label for="h_pylori_rb">H.PYLORI RB :</label><br/>
                                <textarea id="h_pylori_rb" cols="25" rows="1" name="h_pylori_rb"></textarea>
                            </td>
                            <td>
                                <label for="h_pylori_ag">H.PYLORI AG :</label><br/>
                                <textarea id="h_pylori_ag" cols="25" rows="1" name="h_pylori_ag"></textarea>
                            </td>
                        </tr>

                        <!-- قسم DRUGS -->
                        <tr>
                            <td colspan='7'>
                                <h2 class="label label-danger" style="text-align: center;">
                                    <span class="label label-danger badge" style="text-align: center; color:Brown;">
                                        DRUGS
                                    </span>
                                </h2>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="ethanol">Ethanol :</label><br/>
                                <textarea id="ethanol" cols="25" rows="1" name="ethanol"></textarea>
                            </td>
                            <td>
                                <label for="dlhjpam">Diazepam :</label><br/>
                                <textarea id="dlhjpam" cols="25" rows="1" name="dlhjpam"></textarea>
                            </td>
                            <td>
                                <label for="marijuana">Marijuana :</label><br/>
                                <textarea id="marijuana" cols="25" rows="1" name="marijuana"></textarea>
                            </td>
                            <td>
                                <label for="tramedol">Tramedol :</label><br/>
                                <textarea id="tramedol" cols="25" rows="1" name="tramedol"></textarea>
                            </td>
                            <td>
                                <label for="heroin">Heroin :</label><br/>
                                <textarea id="heroin" cols="25" rows="1" name="heroin"></textarea>
                            </td>
                            <td>
                                <label for="pethidine">Pethidine :</label><br/>
                                <textarea id="pethidine" cols="25" rows="1" name="pethidine"></textarea>
                            </td>
                            <td>
                                <label for="cocaine">Cocaine :</label><br/>
                                <textarea id="cocaine" cols="25" rows="1" name="cocaine"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="amphetamine">Amphetamine :</label><br/>
                                <textarea id="amphetamine" cols="25" rows="1" name="amphetamine"></textarea>
                            </td>
                        </tr>

                        <!-- قسم HARMONES -->
                        <tr>
                            <td colspan='7'>
                                <h2 class="label label-danger" style="text-align: center;">
                                    <span class="label label-danger badge" style="text-align: center; color:Brown;">
                                        HARMONES
                                    </span>
                                </h2>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="t3">T3 :</label><br/>
                                <textarea id="t3" cols="25" rows="1" name="t3"></textarea>
                            </td>
                            <td>
                                <label for="t4">T4 :</label><br/>
                                <textarea id="t4" cols="25" rows="1" name="t4"></textarea>
                            </td>
                            <td>
                                <label for="tsh">TSH :</label><br/>
                                <textarea id="tsh" cols="25" rows="1" name="tsh"></textarea>
                            </td>
                            <td>
                                <label for="prolactin">Prolactin :</label><br/>
                                <textarea id="prolactin" cols="25" rows="1" name="prolactin"></textarea>
                            </td>
                            <td>
                                <label for="psa">PSA :</label><br/>
                                <textarea id="psa" cols="25" rows="1" name="psa"></textarea>
                            </td>
                            <td>
                                <label for="ps3">PS3 :</label><br/>
                                <textarea id="ps3" cols="25" rows="1" name="ps3"></textarea>
                            </td>
                            <td>
                                <label for="vitb">Vit-B12 :</label><br/>
                                <textarea id="vitb" cols="25" rows="1" name="vitb"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="vitd">Vit-D3 :</label><br/>
                                <textarea id="vitd" cols="25" rows="1" name="vitd"></textarea>
                            </td>
                            <td>
                                <label for="ca153">CA 153 :</label><br/>
                                <textarea id="ca153" cols="25" rows="1" name="ca153"></textarea>
                            </td>
                            <td>
                                <label for="ca125">CA 125 :</label><br/>
                                <textarea id="ca125" cols="25" rows="1" name="ca125"></textarea>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </form>
    </main>
    
    <footer>
        <!-- ضع محتوى الفوتر إن وجد -->
    </footer>

    <!-- ربط ملفات الـ JS -->
    <script src="includes/js/jquery-3.4.1.min.js"></script>
    <script src="includes/js/bootstrap.min.js"></script>
    <script src="includes/js/fontawesome.min.js"></script> 
    <script src="includes/js/myjs.js"></script> 
</body>
</html>
