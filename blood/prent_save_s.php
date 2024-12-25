<?php
require_once __DIR__ . '/../vendor/autoload.php';

class MyPDF extends TCPDF {
  // خاصية للتحكم في طباعة التذييل
  public $printFooterForResults = false;

  // إعادة تعريف Footer()
  public function Footer() {
      // إذا لم نرغب بطباعة التذييل في هذه الصفحة، نخرج مباشرةً
      if (!$this->printFooterForResults) {
          return;
      }
      // المسافة من أسفل الصفحة 15 ملم
      $this->SetY(-15);
      // اختيار الخط
      $this->SetFont('aealarabiya', '', 10);

      // طباعة "Lab : Doctor :" في سطر واحد
      $this->Cell(50, 5, 'Lab :', 0, 0, 'C');
      $this->Cell(90, 5, '', 0, 0, 'C');
      $this->Cell(50, 5, 'Doctor :', 0, 0, 'C');
  }
}

// تحميل مكتبة TCPDF

// تضمين ملف الاتصال بقاعدة البيانات
include '../includes/db.php';

// ضبط المنطقة الزمنية
date_default_timezone_set("Asia/Aden");

// دالة تنظيف المدخلات
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

/**
 * دالة لطباعة الهيدر (Header) على كل صفحة جديدة أو مع كل مقطع.
 * تحتوي على: الصورة، التاريخ، وبيانات المريض.
 */
function printHeaderPage($pdf, $pat_date, $fname, $age, $gander, $phone) {
    // صورة الشعار أو الخلفية
    $pdf->Image('includes/images/img.png',10,10,-300);
    // مسافة للأسفل
    $pdf->Ln(42);

    // طباعة التاريخ
    $pdf->Cell(140, 8, '', 0, 0, 'C', 0);
    $pdf->Cell(14, 8, 'Date :', 0, 0, 'C', 0);
    $pdf->Cell(28, 8, $pat_date, 0, 1, 'C', 0);
    $pdf->Ln();

    // طباعة بيانات المريض
    $pdf->SetFillColor(169, 204, 227);
    $pdf->Cell(20, 8, 'Name :', 1, 0, 'C', true);
    $pdf->Cell(45, 8, $fname, 1, 0, 'C', 0);

    $pdf->Cell(15, 8, 'Age :', 1, 0, 'C', true);
    $pdf->Cell(20, 8, $age, 1, 0, 'C', 0);

    $pdf->Cell(20, 8, 'Gander:', 1, 0, 'C', true);
    $pdf->Cell(10, 8, $gander, 1, 0, 'C', 0);

    $pdf->Cell(20, 8, 'Phone :', 1, 0, 'C', true);
    $pdf->Cell(35, 8, $phone, 1, 1, 'C', 0);
    $pdf->Ln();
}

/**
 * دالة لطباعة عنوان القسم (Section) مع رأس الجدول.
 */
function printSectionHeader($pdf, &$conntant, $title) {
    $pdf->SetFillColor(214, 234, 248);
    $pdf->Cell(186, 8, $title, 1, 1, 'C', true);
    $conntant++;
    // رأس الجدول
    $pdf->Cell(62, 8, 'Test', 1, 0, 'C', true);
    $pdf->Cell(62, 8, 'Result', 1, 0, 'C', true);
    $pdf->Cell(62, 8, 'Reference Values', 1, 1, 'C', true);
    $conntant++;
}

/**
 * دالة تتحقق من عدد الأسطر المطبوعة، وفي حال تجاوز الحد
 * تقوم بإضافة صفحة جديدة وطباعة الهيدر.
 */
function checkPageBreak($pdf, &$conntant, $limit, $pat_date, $row_fname, $row_age, $row_gander, $row_phone, $sectionTitle = null) {
    if ($conntant >= $limit) {
        $conntant = 0;      // إعادة العداد للصفر
        $pdf->AddPage();    // إضافة صفحة جديدة
        // طباعة الهيدر (البيانات الأساسية)
        printHeaderPage($pdf, $pat_date, $row_fname, $row_age, $row_gander, $row_phone);
        // إذا أردنا إعادة طباعة عنوان القسم
        if ($sectionTitle) {
            printSectionHeader($pdf, $conntant, $sectionTitle);
        }
    }
}

/**
 * دالة لطباعة سطر واحد من نتائج الفحص.
 * - $refValues يمكن أن يكون نصًا متعدد الأسطر فيُستخدم MultiCell عند الحاجة.
 */
function printTestRow($pdf, $testName, $testValue, $refValues, &$conntant,
                      $pat_date, $row_fname, $row_age, $row_gander, $row_phone, 
                      $limit = 16, $sectionTitle = null) 
{
    // لا نطبع شيئًا إذا كانت القيمة فارغة
    if (empty($testValue)) {
        return;
    }
    // التحقق من الصفحة
    checkPageBreak($pdf, $conntant, $limit, $pat_date, $row_fname, $row_age, $row_gander, $row_phone, $sectionTitle);

    // طباعة السطر
    $pdf->Ln(2);
    // الخلية الأولى: اسم الاختبار
    $pdf->Cell(62, 8, '          ' . $testName, 0, 0, 'L', 0);
    // الخلية الثانية: نتيجة الاختبار
    $pdf->Cell(62, 8, $testValue, 0, 0, 'C', 0);

    // الخلية الثالثة: القيم المرجعية
    // إذا كان النص متعدد الأسطر نستخدم MultiCell، وإلا Cell
    if (strpos($refValues, "\n") !== false) {
        $pdf->MultiCell(62, 8, $refValues, 0, '', 1);
    } else {
        $pdf->Cell(62, 8, $refValues, 0, 1, 'L', 0);
    }
    $conntant++;
}

// ---------------------------------------------------
//           معالجة المدخلات الرئيسية
// ---------------------------------------------------

$pat_date = date("Y-m-d");
$pat_idd  = 0;
$conntant = 0; // عداد للأسطر المطبوعة

// التحقق من زر الاستعلام (لاستخدامه في جلب بيانات المريض)
if (isset($_GET['Submit_pation'])) {
    $pat_idd = isset($_GET['pat_idd']) ? intval($_GET['pat_idd']) : 0;
    $r       = mysqli_query($conn, "SELECT fname,age,gander,phone FROM patinte WHERE pat_idd=$pat_idd");
}

// التحقق من زر الإضافة (Submit) لإدخال بيانات الفحص
if (isset($_GET['Submit'])) {
    // جمع البيانات من الفورم
    $pat_id          = $_GET['pat_id']         ?? '';
    $pat_hb          = $_GET['hb']             ?? '';
    $pat_wbc         = $_GET['wbc']            ?? '';
    $pat_neutrophil  = $_GET['neutrophil']     ?? '';
    $pat_lymphocyte  = $_GET['lymphocyte']     ?? '';
    $pat_monocyte    = $_GET['monocyte']       ?? '';
    $pat_esoinophil  = $_GET['esoinophil']     ?? '';
    $pat_platelats   = $_GET['platelats']      ?? '';
    $pat_esr         = $_GET['esr']            ?? '';
    $pat_malaria     = $_GET['malaria']        ?? '';
    $pat_ct          = $_GET['ct']             ?? '';
    $pat_pt          = $_GET['pt']             ?? '';
    $pat_ptc         = $_GET['ptc']            ?? '';
    $pat_inr         = $_GET['inr']            ?? '';
    $pat_bt          = $_GET['bt']             ?? '';
    $pat_reticulocyte= $_GET['reticulocyte']   ?? '';
    $pat_sickling    = $_GET['sickling']       ?? '';
    $pat_ptt         = $_GET['ptt']            ?? '';
    $pat_pttc        = $_GET['pttc']           ?? '';
    $pat_d_dimer     = $_GET['d_dimer']        ?? '';
    $pat_fbs         = $_GET['fbs']            ?? '';
    $pat_rbs         = $_GET['rbs']            ?? '';
    $pat_p_pbs       = $_GET['p_pbs']          ?? '';
    $pat_hba         = $_GET['hba']            ?? '';
    $pat_urea        = $_GET['urea']           ?? '';
    $pat_creatinine  = $_GET['creatinine']     ?? '';
    $pat_s_got       = $_GET['s_got']          ?? '';
    $pat_s_gpt       = $_GET['s_gpt']          ?? '';
    $pat_total_bilirubin  = $_GET['total_bilirubin']   ?? '';
    // لاحظ هنا أننا نستخدم isset لـ dirict_bilirubin لأننا سماهنا pat_C أحيانًا
    $pat_dirict_bilirubin = $_GET['dirict_bilirubin']  ?? '';
    $pat_alk_phospats     = $_GET['alk_phospats']      ?? '';
    $pat_albumin          = $_GET['albumin']           ?? '';
    $pat_ca               = $_GET['ca']                ?? '';
    $pat_k                = $_GET['k']                 ?? '';
    $pat_na               = $_GET['na']                ?? '';
    $pat_cl               = $_GET['cl']                ?? '';
    $pat_mg               = $_GET['mg']                ?? '';
    $pat_ck               = $_GET['ck']                ?? '';
    $pat_ck_mb            = $_GET['ck_mb']             ?? '';
    $pat_ldh              = $_GET['ldh']               ?? '';
    $pat_cholesterol      = $_GET['cholesterol']       ?? '';
    $pat_triglyceride     = $_GET['triglyceride']      ?? '';
    $pat_ldl              = $_GET['ldl']               ?? '';
    $pat_hdl              = $_GET['hdl']               ?? '';
    $pat_uricacid         = $_GET['uricacid']          ?? '';
    $pat_t_patinte        = $_GET['t_patinte']         ?? '';
    $pat_aso              = $_GET['aso']               ?? '';
    $pat_crp              = $_GET['crp']               ?? '';
    $pat_rf               = $_GET['rf']                ?? '';
    $pat_salmon_o         = $_GET['salmon_o']          ?? '';
    $pat_salmon_h         = $_GET['salmon_h']          ?? '';
    $pat_salmon_a         = $_GET['salmon_a']          ?? '';
    $pat_salmon_b         = $_GET['salmon_b']          ?? '';
    $pat_brucella_a       = $_GET['brucella_a']        ?? '';
    $pat_brucella_m       = $_GET['brucella_m']        ?? '';
    $pat_blood_group      = $_GET['blood_group']       ?? '';
    $pat_tb               = $_GET['tb']                ?? '';
    $pat_hiv              = $_GET['hiv']               ?? '';
    $pat_hcv              = $_GET['hcv']               ?? '';
    $pat_hbs_ag           = $_GET['hbs_ag']            ?? '';
    $pat_vdrl             = $_GET['vdrl']              ?? '';
    $pat_h_pylori_rb      = $_GET['h_pylori_rb']       ?? '';
    $pat_h_pylori_ag      = $_GET['h_pylori_ag']       ?? '';
    $pat_ethanol          = $_GET['ethanol']           ?? '';
    $pat_dlhjpam          = $_GET['dlhjpam']           ?? '';
    $pat_marijuana        = $_GET['marijuana']         ?? '';
    $pat_tramedol         = $_GET['tramedol']          ?? '';
    $pat_heroin           = $_GET['heroin']            ?? '';
    $pat_pethidine        = $_GET['pethidine']         ?? '';
    $pat_cocaine          = $_GET['cocaine']           ?? '';
    $pat_amphetamine      = $_GET['amphetamine']       ?? '';
    $pat_t3               = $_GET['t3']                ?? '';
    $pat_t4               = $_GET['t4']                ?? '';
    $pat_tsh              = $_GET['tsh']               ?? '';
    $pat_prolactin        = $_GET['prolactin']         ?? '';
    $pat_psa              = $_GET['psa']               ?? '';
    $pat_ps3              = $_GET['ps3']               ?? '';
    $pat_vitb             = $_GET['vitb']              ?? '';
    $pat_vitd             = $_GET['vitd']              ?? '';
    $pat_ca153            = $_GET['ca153']             ?? '';
    $pat_ca125            = $_GET['ca125']             ?? '';

    // إذا كان الـ pat_id فارغًا، لا نكمل.
    if (empty($pat_id)) {
        echo "Patinte ID is Required";
    } else {
        // إدخال البيانات في جدول blood_test
        $insert_blood_test = "
          INSERT INTO blood_test 
          (
            pat_id, hb, wbc, neutrophil, lymphocyte, monocyte, esoinophil,
            platelats, esr, malaria, ct, pt, ptc, inr, bt, reticulocyte,
            sickling, ptt, pttc, d_dimer, fbs, rbs, p_pbs, hba, urea,
            creatinine, s_got, s_gpt, total_bilirubin, dirict_bilirubin,
            alk_phospats, albumin, ca, k, na, cl, mg, ck, ck_mb, ldh,
            cholesterol, triglyceride, ldl, hdl, uricacid, t_patinte,
            aso, crp, rf, salmon_o, salmon_h, salmon_a, salmon_b,
            brucella_a, brucella_m, blood_group, tb, hiv, hcv, hbs_ag,
            vdrl, h_pylori_rb, h_pylori_ag, ethanol, dlhjpam, marijuana,
            tramedol, heroin, pethidine, cocaine, amphetamine,
            t3, t4, tsh, prolactin, psa, ps3, vitb, vitd, ca153, ca125,
            today_date
          ) VALUES (
            '$pat_id','$pat_hb','$pat_wbc','$pat_neutrophil','$pat_lymphocyte',
            '$pat_monocyte','$pat_esoinophil','$pat_platelats','$pat_esr',
            '$pat_malaria','$pat_ct','$pat_pt','$pat_ptc','$pat_inr','$pat_bt',
            '$pat_reticulocyte','$pat_sickling','$pat_ptt','$pat_pttc','$pat_d_dimer',
            '$pat_fbs','$pat_rbs','$pat_p_pbs','$pat_hba','$pat_urea','$pat_creatinine',
            '$pat_s_got','$pat_s_gpt','$pat_total_bilirubin','$pat_dirict_bilirubin',
            '$pat_alk_phospats','$pat_albumin','$pat_ca','$pat_k','$pat_na','$pat_cl',
            '$pat_mg','$pat_ck','$pat_ck_mb','$pat_ldh','$pat_cholesterol','$pat_triglyceride',
            '$pat_ldl','$pat_hdl','$pat_uricacid','$pat_t_patinte','$pat_aso','$pat_crp',
            '$pat_rf','$pat_salmon_o','$pat_salmon_h','$pat_salmon_a','$pat_salmon_b',
            '$pat_brucella_a','$pat_brucella_m','$pat_blood_group','$pat_tb','$pat_hiv',
            '$pat_hcv','$pat_hbs_ag','$pat_vdrl','$pat_h_pylori_rb','$pat_h_pylori_ag',
            '$pat_ethanol','$pat_dlhjpam','$pat_marijuana','$pat_tramedol','$pat_heroin',
            '$pat_pethidine','$pat_cocaine','$pat_amphetamine','$pat_t3','$pat_t4','$pat_tsh',
            '$pat_prolactin','$pat_psa','$pat_ps3','$pat_vitb','$pat_vitd','$pat_ca153',
            '$pat_ca125','$pat_date'
          )
        ";
        $run_blood_test = mysqli_query($conn, $insert_blood_test);

        // جلب معلومات المريض من جدول patinte
        $s = mysqli_query($conn, "SELECT fname,age,gander,phone FROM patinte WHERE pat_id=$pat_id");
        $row_fname   = '';
        $row_age     = '';
        $row_gander  = '';
        $row_phone   = '';

        if ($row = mysqli_fetch_assoc($s)) {
            $row_fname  = $row['fname'];
            $row_age    = $row['age'];
            $row_gander = $row['gander'];
            $row_phone  = $row['phone'];
        }

        // إنشاء كائن TCPDF
        $pdf = new MyPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetFont('aealarabiya', '', 14);
        $pdf->printFooterForResults = true;

        $pdf->AddPage();

        // طباعة الهيدر للصفحة الأولى
        printHeaderPage($pdf, $pat_date, $row_fname, $row_age, $row_gander, $row_phone);

        // ---------- القسم الأول: Haematology ----------
        // نتحقق هل هناك بيانات في أي من هذه الحقول
        $haematologyList = [
            ['HB',           $pat_hb,           "M : 14 - 18 g/dl\nF : 11.5 - 16.5 g/dl" ],
            ['WBC',          $pat_wbc,          "4 - 10 X10*9/L" ],
            ['Neutrophil',   $pat_neutrophil,   "40 - 70 %" ],
            ['Lymphocyte',   $pat_lymphocyte,   "20 - 40 %" ],
            ['Monocyte',     $pat_monocyte,     "2 - 10 %" ],
            ['Esoinophil',   $pat_esoinophil,   "1 - 6 %" ],
            ['Platelats',    $pat_platelats,    "150 - 450 X10*9 /L" ],
            ['ESR',          $pat_esr,          "M : up to 11 mm/hr\nF : up to 19 mm/hr" ],
            ['Malaria',      $pat_malaria,      "" ],
            ['CT',           $pat_ct,           "> 10 Min" ],
            ['PT Patinte',   $pat_pt,           "" ],
            ['PT Control',   $pat_ptc,          "" ],
            ['INR',          $pat_inr,          "0.9 - 1.2" ],
            ['BT',           $pat_bt,           "> 9 Min" ],
            ['Reticulocyte', $pat_reticulocyte, "" ],
            ['Sickling Test',$pat_sickling,     "" ],
            ['PTT Patinte',  $pat_ptt,          "" ],
            ['PTT Control',  $pat_pttc,         "" ],
            ['D_Dimer',      $pat_d_dimer,      "" ],
        ];

        // فلترة العناصر غير الفارغة
        $haematologyFilled = array_filter($haematologyList, fn($item) => !empty($item[1]));
        if (!empty($haematologyFilled)) {
            printSectionHeader($pdf, $conntant, 'HAEMATOLOGY');
            foreach ($haematologyFilled as $test) {
                printTestRow(
                    $pdf,
                    $test[0], // اسم الفحص
                    $test[1], // القيمة
                    $test[2], // القيم المرجعية
                    $conntant,
                    $pat_date, $row_fname, $row_age, $row_gander, $row_phone,
                    16, // الحد الأقصى للأسطر في الصفحة الواحدة (قابل للتغيير)
                    'HAEMATOLOGY'
                );
            }
        }

        // ---------- القسم الثاني: Biochemistry ----------
        $biochemistryList = [
            ['F.B.S',         $pat_fbs,         "70 - 120 mg/dl"],
            ['R.B.S',         $pat_rbs,         "80 - 120 mg/dl"],
            ['P.PBS',         $pat_p_pbs,       "80 - 120 mg/dl"],
            ['HBA 1C',        $pat_hba,         "Non diabetic 2 - 5%\nDiabetic adult <= 7%"],
            ['Urea',          $pat_urea,        "10 - 50 mg/dl"],
            ['Creatinine',    $pat_creatinine,  "M : 0.7 - 1.4 mg/dl\nF : 0.6 - 1.3 mg/dl"],
            ['S.Got',         $pat_s_got,       "up to 37 U/l"],
            ['S.Gpt',         $pat_s_gpt,       "up to 40 U/l"],
            ['Total Bilirubin',$pat_total_bilirubin, "up to 1.1 mg/dl"],
            ['Dirict Bilirubin',$pat_dirict_bilirubin,"up to 0.25 mg/dl"],
            ['ALK.Phospats',  $pat_alk_phospats,"M : 45 - 115 U/l\nF : 30 - 100 U/l"],
            ['Albumin',       $pat_albumin,     "35 - 50 g/l"],
            ['Ca++',          $pat_ca,          "8.2 - 10.5 mg/dl"],
            ['K+',            $pat_k,           "3.3 - 5.5 mmol/L"],
            ['Na+',           $pat_na,          "130 - 490 mmol/L"],
            ['Cl-',           $pat_cl,          "98 - 109 mmol/L"],
            ['Mg++',          $pat_mg,          "1.6 - 2.6 mg/dL"],
            ['C.K',           $pat_ck,          "up to 240 U/L"],
            ['CK-MB',         $pat_ck_mb,       "up to 25 U/L"],
            ['L.D.H',         $pat_ldh,         "230 - 460 U/L"],
            ['Cholesterol',   $pat_cholesterol, "< 200 mg/dL"],
            ['Triglyceride',  $pat_triglyceride,"< 200 mg/dL"],
            ['LDL',           $pat_ldl,         "< 135 mg/dL"],
            ['HDL',           $pat_hdl,         "< 55 mg/dL"],
            ['Uric Acid',     $pat_uricacid,    "M : 3.5 - 7.0 mg/dL\nF : 2.5 - 5.8 mg/dL"],
            ['T.Protine',     $pat_t_patinte,   "56 - 87 g/L"],
        ];

        $biochemistryFilled = array_filter($biochemistryList, fn($item) => !empty($item[1]));
        if (!empty($biochemistryFilled)) {
            printSectionHeader($pdf, $conntant, 'BIOCHEMEISTRY');
            foreach ($biochemistryFilled as $test) {
                printTestRow(
                    $pdf,
                    $test[0],
                    $test[1],
                    $test[2],
                    $conntant,
                    $pat_date, $row_fname, $row_age, $row_gander, $row_phone,
                    16,
                    'BIOCHEMEISTRY'
                );
            }
        }

        // ---------- القسم الثالث: Serology ----------
        $serologyList = [
            ['ASO',           $pat_aso,           '< 200'],
            ['C.R.P',         $pat_crp,           '< 1/6'],
            ['RF',            $pat_rf,            '< 1/4'],
            // Widal Test
            ['Widal Test (Salm. O)', $pat_salmon_o,'< 1/80'],
            ['Salm. H',       $pat_salmon_h,      '< 1/80'],
            ['S.Para Typh (A)',$pat_salmon_a,     '< 1/80'],
            ['S.Para Typh (B)',$pat_salmon_b,     '< 1/80'],
            // Brucella
            ['Brucella A (Abrotus)',$pat_brucella_a,'< 1/80'],
            ['Brucella M (Maletenses)',$pat_brucella_m,'< 1/80'],
            ['Blood Group',   $pat_blood_group,   ''],
            ['TB',            $pat_tb,            ''],
            ['HIV',           $pat_hiv,           ''],
            ['HCV',           $pat_hcv,           ''],
            ['HBS.AG',        $pat_hbs_ag,        ''],
            ['VDRL',          $pat_vdrl,          ''],
            ['H.PYLORI Ab',   $pat_h_pylori_rb,   ''],
            ['H.PYLORI AG',   $pat_h_pylori_ag,   ''],
        ];

        $serologyFilled = array_filter($serologyList, fn($item) => !empty($item[1]));
        if (!empty($serologyFilled)) {
            printSectionHeader($pdf, $conntant, 'SEROLOGY');
            foreach ($serologyFilled as $test) {
                printTestRow(
                    $pdf,
                    $test[0],
                    $test[1],
                    $test[2],
                    $conntant,
                    $pat_date, $row_fname, $row_age, $row_gander, $row_phone,
                    16,
                    'SEROLOGY'
                );
            }
        }

        // ---------- القسم الرابع: DRUGS ----------
        $drugsList = [
            ['Ethanol',    $pat_ethanol,    'Up to 50 mg/dl'],
            ['Diazepam',   $pat_dlhjpam,    ''],
            ['Marijuana',  $pat_marijuana,  ''],
            ['Tramedol',   $pat_tramedol,   ''],
            ['Heroin',     $pat_heroin,     ''],
            ['Pethidine',  $pat_pethidine,  ''],
            ['Cocaine',    $pat_cocaine,    ''],
            ['Amphetamine',$pat_amphetamine,''],
        ];

        $drugsFilled = array_filter($drugsList, fn($item) => !empty($item[1]));
        if (!empty($drugsFilled)) {
            printSectionHeader($pdf, $conntant, 'DRUGS');
            foreach ($drugsFilled as $test) {
                printTestRow(
                    $pdf,
                    $test[0],
                    $test[1],
                    $test[2],
                    $conntant,
                    $pat_date, $row_fname, $row_age, $row_gander, $row_phone,
                    16,
                    'DRUGS'
                );
            }
        }

        // ---------- القسم الخامس: HARMONES ----------
        // ملاحظة: سنفترض أننا سنطبعها بصفحة جديدة دومًا إذا لم تكن فارغة،
        // حسب منطق الكود القديم الذي قام بإضافة صفحة عند الوصول إلى الهرمونات.
        $harmonesList = [
            ['T3',         $pat_t3,        "< 3d (2.4 - 10.0 ) Pg/ml\n4 - 30d (2.7 - 8.2 ) Pg/ml\n2 - 12m (2.5 - 7.7 ) Pg/ml\n1 - 6y (2.7 - 8.8 ) Pg/ml\n7 - 12y (2.9 - 8.2 ) Pg/ml\n13 - 16y (3.3 - 6.9 ) Pg/ml\nAdult (2.02 - 4.43) Pg/ml"],
            ['T4',         $pat_t4,        "< 3d (1.1 - 1.30 )ng/dl\n4 - 30d (0.9 - 2.8 )ng/dl\n2 - 12m (0.7 - 2.3 )ng/dl\n1 - 6y (0.45 - 3.6 )ng/dl\n7 - 12y (0.8 - 1.7 )ng/dl\n13 - 16y (0.9 - 2.1 )ng/dl\nAdult (0.9 - 1.71) ng/dl"],
            ['TSH',        $pat_tsh,       "< 3d (0.68 - 29 )mIU/ml\n4 - 30d (0.51 - 11 )mIU/ml\n2 - 12m (0.55 - 6.7 )mIU/ml\n1 - 6y (0.45 - 3.6 )mIU/ml\n7 - 12y (0.61 - 5.2 )mIU/ml\n13 - 16y(0.36 - 4.7 )mIU/ml\nAdult(0.23 - 3.8 )mIU/ml"],
            ['Prolactin',  $pat_prolactin, "F : 3.4 - 24.1 ng/ml\nM : 4.1 - 18.4 ng/ml"],
            ['PSA Free',   $pat_psa,       ""],
            ['PSA Total',  $pat_ps3,       ""],
            ['Vit-B12',    $pat_vitb,      ""],
            ['Vit-D3',     $pat_vitd,      ""],
            ['CA 153',     $pat_ca153,     ""],
            ['CA 125',     $pat_ca125,     ""],
        ];

        // نتحقق من وجود أي بيانات
        $harmonesFilled = array_filter($harmonesList, fn($item) => !empty($item[1]));
        if (!empty($harmonesFilled)) {
            // قد نضيف صفحة جديدة دائماً كما في الكود القديم:
            $pdf->AddPage();
            $conntant = 0; // إعادة العداد
            printHeaderPage($pdf, $pat_date, $row_fname, $row_age, $row_gander, $row_phone);

            printSectionHeader($pdf, $conntant, 'HARMONES');
            foreach ($harmonesFilled as $test) {
                printTestRow(
                    $pdf,
                    $test[0],
                    $test[1],
                    $test[2],
                    $conntant,
                    $pat_date, $row_fname, $row_age, $row_gander, $row_phone,
                    12,
                    'HARMONES'
                );
            }
        }

        // في النهاية، تذييل بسيط
        // $pdf->Ln();
        // $pdf->Cell(50, 8, 'Lab :', 0, 0, 'C', 0);
        // $pdf->Cell(90, 8, '', 0, 0, 'C', 0);
        // $pdf->Cell(50, 8, 'Doctor :', 0, 1, 'C', 0);

        // طباعة الديباج/التجربة
        var_dump(["data" => "demo"]);

        // تنظيف البافر وإخراج الـ PDF
        ob_end_clean();
        $pdf->Output('lab3.pdf', 'I');
    }
}

// أخيرًا، إغلاق الاتصال بقاعدة البيانات
$conn->close();

?>
