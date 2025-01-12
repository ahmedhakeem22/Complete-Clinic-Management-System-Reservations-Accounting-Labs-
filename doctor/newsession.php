<?php 
// newsession.php

include 'includes/templates/header.php';
include 'includes/templates/navbar.php';
include '../includes/db.php';
include 'includes/functions.php'; // استدعاء دوال المساعدة

// تعيين المنطقة الزمنية وتاريخ الجلسة الحالية
date_default_timezone_set("Asia/Aden");
$pat_date = date("Y-m-d");

// تعريف خيارات الاستخدام للدواء
$usageOptions = [
    1  => 'One tablet before breakfast',
    2  => 'Half tablet before breakfast',
    3  => 'One tablet after breakfast',
    4  => 'Half tablet after breakfast',
    5  => 'One tablet before lunch',
    6  => 'Half tablet before lunch',
    7  => 'One tablet after lunch',
    8  => 'Half tablet after lunch',
    9  => 'One tablet before dinner',
    10 => 'Half tablet before dinner',
    11 => 'One tablet after dinner',
    12 => 'Half tablet after dinner',
    13 => 'One tablet before bedtime',
    14 => 'Half tablet before bedtime',
    15 => 'One tablet weekly',
    16 => 'Twice a week',
];

$pat_idd = 0;
$previous_date = "";

// عند الضغط على زر "Fetch" لجلب بيانات المريض
if (isset($_POST['show_det'])) {
    $pat_idd = (int)$_POST['pat_id'];
    $r = fetch_patient_details($conn, $pat_idd);
    $previous_date = fetch_previous_session_date($conn, $pat_idd);
}

// معالجة إضافة جلسة جديدة
if (isset($_POST['addsess'])) {
    $pat_id    = (int)$_POST['pat_id'];
    $date_pev  = !empty($_POST['date_pev']) ? $_POST['date_pev'] : $pat_date;
    $date_next = !empty($_POST['date_next']) ? $_POST['date_next'] : $pat_date;
    
    // تجميع بيانات الجلسة في مصفوفة
    $sessionParams = [
        'pat_id'      => $pat_id,
        'date_now'    => $pat_date,
        'date_pev'    => $date_pev,
        'date_next'   => $date_next,
        'main_com'    => $_POST['main_com'],
        'period_ill'  => $_POST['period_ill'],
        'sex_hist'    => $_POST['sex_hist'],
        'person_hist' => $_POST['person_hist'],
        'curr_hist'   => $_POST['curr_hist'],
        'last_hist'   => $_POST['last_hist'],
        'fam_hist'    => $_POST['fam_hist'],
        'work_hist'   => $_POST['work_hist'],
        'basic_dig'   => $_POST['basic_dig'],
        'diff_dig'    => $_POST['diff_dig'],
        'appear'      => $_POST['appear'],
        'behav'       => $_POST['behav'],
        'mood'        => $_POST['mood'],
        'killer'      => $_POST['killer'],
        'thin_shep'   => $_POST['thin_shep'],
        'thin_con'    => $_POST['thin_con'],
        'percep'      => $_POST['percep'],
        'memory'      => $_POST['memory'],
        'ability'     => $_POST['ability'],
        'insight'     => $_POST['insight'],
        'fores'       => $_POST['fores'],
        'degree'      => $_POST['degree'],
        'speech'      => $_POST['speech']
    ];
    
    if (empty($pat_id)) {
        echo "Patient ID is Required";
    } else {
        if(add_new_session($conn, $sessionParams)){
            echo "<script>showSuccessMessage('تم إضافة الجلسة بنجاح!');</script>";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Session</title>
    <!-- استدعاء Bootstrap & CSS خارجي -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
    <style>
        body {
            direction: ltr;
            text-align: left;
        }
    </style>
</head>
<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <main>
    <div>
      <table class="table table-striped table-bordered table-hover" cellspacing="15" cellpadding="0">
        <tr>
          <td> 
            <label for="no.p1" style="background-color:#009933;" class="form-control"> 
              <strong style="color:white;">Patient No.:</strong> 
            </label>
            <label> 
            <input type="number" name="pat_id" class="form-control" value="<?php echo htmlspecialchars($pat_idd); ?>" />
            </label>
            <label> 
              <input style="width:100px; background-color:orange;" class="btn btn-primary form-control"
                     type="submit" value="Fetch" title="Patient Information" name="show_det" />
            </label>
          </td>
          <td colspan='4'></td>
        </tr>
        <?php if($pat_idd > 0 && isset($r)): ?>
          <?php while($row = $r->fetch_assoc()): ?>
            <tr>
              <td> Name: <?php echo htmlspecialchars($row['fname']); ?> </td>
              <td> Age: <?php echo htmlspecialchars($row['age']); ?> </td>
              <td> Social Status: <?php echo htmlspecialchars($row['soc_sts']); ?> </td>
              <td> Phone: <?php echo htmlspecialchars($row['phone']); ?> </td>
              <td> Number of Children: <?php echo htmlspecialchars($row['chel_num']); ?> </td>
            </tr>
          <?php endwhile; ?>
        <?php endif; ?>
        <tr>
          <td>
            <label for="current" style="background-color:#4d4d4d;" class="form-control"> 
              <strong style="color:white;">Current Session Date:</strong> 
            </label>
            <label style="color:black;"> <?php echo htmlspecialchars($pat_date); ?> </label>
          </td>
          <td>
            <label for="previous" style="background-color:#4d4d4d;" class="form-control"> 
              <strong style="color:white;">Previous Session Date:</strong> 
            </label>
            <label style="color:black;"> <?php echo htmlspecialchars($previous_date); ?> </label>
          </td>
          <td colspan='3'>
            <label for="next" style="background-color:#4d4d4d;" class="form-control"> 
              <strong style="color:white;">Next Session Date:</strong> 
            </label>
            <input type="date" id="nextdate" name="date_next" class="form-control" />
          </td>
        </tr>
      </table>
    </div>

    <!-- القسم الخاص بتفاصيل الجلسة -->
    <table class="table table-striped table-bordered table-hover table-active" cellspacing="15" cellpadding="0">
      <tr>
        <td colspan='2'>
          <label style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Main Complaint:</strong>
          </label>
          <textarea id="complaint" cols="125" rows="3" name="main_com" class="form-control"></textarea>
        </td>
        <td colspan='2'>
          <label for="illness" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Illness Period:</strong>
          </label>
          <textarea id="illness" cols="123" rows="3" name="period_ill" class="form-control"></textarea>
        </td>
      </tr>
      <tr>
        <td colspan='2'>
          <label for="disease" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Current Illness History:</strong>
          </label>
          <textarea cols="125" rows="3" name="curr_hist" class="form-control"></textarea>
        </td>
        <td colspan='2'>
          <label for="last" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Previous History:</strong>
          </label>
          <textarea cols="123" rows="3" name="last_hist" class="form-control"></textarea>
        </td>
      </tr>
      <tr>
        <td>
          <label for="family" style="background-color:#007ce2;" class="form-control">
            <strong style="color:white;">Family History:</strong>
          </label>
          <textarea id="family" cols="55" rows="3" name="fam_hist" class="form-control"></textarea>
        </td>
        <td>
          <label for="work" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Occupational History:</strong>
          </label>
          <textarea id="work" cols="55" rows="3" name="work_hist" class="form-control"></textarea>
        </td>
        <td>
          <label for="Sexual" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Sexual History:</strong>
          </label>
          <textarea cols="55" rows="3" name="sex_hist" class="form-control"></textarea>
        </td>
        <td>
          <label for="Personal" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Personal History:</strong>
          </label>
          <textarea cols="55" rows="3" name="person_hist" class="form-control"></textarea>
        </td>
      </tr>
      <tr>
        <td colspan='4'>
          <label class="form-control" style="background-color:#196619;"> 
            <strong style="color:white;">Mental State Examination:</strong>
          </label>
        </td>
      </tr>
      <tr>
        <td>
          <label for="appearance" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Appearance:</strong>
          </label>
          <textarea cols="55" rows="3" name="appear" class="form-control"></textarea>
        </td>
        <td>
          <label for="behavior" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Behavior:</strong>
          </label>
          <textarea cols="55" rows="3" name="behav" class="form-control"></textarea>
        </td>
        <td>
          <label for="speech" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Speech:</strong>
          </label>
          <textarea cols="55" rows="3" name="speech" class="form-control"></textarea>
        </td>
        <td>
          <label for="Mood" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Mood/Affect:</strong>
          </label>
          <textarea cols="55" rows="3" name="mood" class="form-control"></textarea>
        </td>
      </tr>
      <tr>
        <td>
          <label for="killer" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Suicidal/Homicidal Thoughts/Plans:</strong>
          </label>
          <textarea cols="55" rows="3" name="killer" class="form-control"></textarea>
        </td>
        <td>
          <label for="thin_shep" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Thought Form:</strong>
          </label>
          <textarea cols="55" rows="3" name="thin_shep" class="form-control"></textarea>
        </td>
        <td>
          <label for="thin_con" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Thought Content:</strong>
          </label>
          <textarea cols="55" rows="3" name="thin_con" class="form-control"></textarea>
        </td>
        <td>
          <label for="percep" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Perception:</strong>
          </label>
          <textarea cols="55" rows="3" name="percep" class="form-control"></textarea>
        </td>
      </tr>
      <tr>
        <td>
          <label for="memory" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Memory:</strong>
          </label>
          <textarea cols="55" rows="3" name="memory" class="form-control"></textarea>
        </td>
        <td>
          <label for="ability" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Judgment:</strong>
          </label>
          <textarea cols="55" rows="3" name="ability" class="form-control"></textarea>
        </td>
        <td>
          <label for="insight" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Insight:</strong>
          </label>
          <textarea cols="55" rows="3" name="insight" class="form-control"></textarea>
        </td>
        <td>
          <label for="fores" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Cognitive Perception:</strong>
          </label>
          <textarea cols="55" rows="3" name="fores" class="form-control"></textarea>
        </td>
      </tr>
      <tr>
        <td style="width:200px;">
          <label for="degree" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Fullton Degree:</strong>
          </label>
          <input type="number" id="degree" name="degree" class="form-control" />
        </td>
        <td>
          <label for="basic_dig" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Preliminary Diagnosis:</strong>
          </label>
          <textarea cols="55" rows="3" name="basic_dig" class="form-control"></textarea>
        </td>
        <td colspan='2'>
          <label for="diff_dig" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Differential Diagnosis:</strong>
          </label>
          <textarea cols="125" rows="3" name="diff_dig" class="form-control"></textarea>
        </td>
      </tr>
    </table>

    <!-- جدول الأزرار لنماذج النوافذ المنبثقة -->
    <table class="table table-striped table-bordered table-hover table-active table-dark" cellspacing="15" cellpadding="0">
      <tr>
        <td>
          <input class="btn btn-success form-control" type="submit" value="Add Session" title="Add Session" name="addsess" />
        </td>
        <td>
          <button type="button" class="btn btn-danger form-control" data-toggle="modal" data-target="#bloodModal" title="Blood Laboratory Tests">
            Blood
          </button>
        </td>
        <td>
          <button type="button" class="btn btn-warning form-control" data-toggle="modal" data-target="#medicalModal" title="Medical Prescription">
            Medical Description
          </button>
        </td>
        <td>
          <button type="button" class="btn btn-info form-control" data-toggle="modal" data-target="#psychModal" title="Psychological Tests">
            Psychological
          </button>
        </td>
      </tr>
    </table>
  </main>
</form>

<!-- نوافذ (Modal) -->
<!-- Modal الخاص بالوصفة الطبية -->
<div class="modal fade" id="medicalModal" tabindex="-1" role="dialog" aria-labelledby="medicalModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="medicalForm" method="post" action="sale.php" class="modal-form">
        <div class="modal-header">
          <h5 class="modal-title" id="medicalModalLabel">Enter Prescribed Medications Information</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php include 'medi.php'; ?>
          <!-- تأكد بوجود عنصر لحاوية الأدوية داخل النموذج -->
          <div id="drugs-container"></div>
          <!-- زر لإضافة دواء جديد -->
          <button type="button" id="add-drug-med" class="btn btn-info mt-2">Add Medication</button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-primary">Save Information</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal الخاص بالاختبارات النفسية -->
<div class="modal fade" id="psychModal" tabindex="-1" role="dialog" aria-labelledby="psychModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form method="post" action="nafsi_ses_pdf.php" target="_blank" class="modal-form">
        <div class="modal-header">
          <h5 class="modal-title" id="psychModalLabel">اختر الاختبارات النفسية</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php include 'dctor_chosse_nafsy.php'; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
          <button type="submit" name="add_sess" class="btn btn-primary">حفظ الاختبارات/طباعة</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal الخاص بالفحوصات الدموية -->
<div class="modal fade" id="bloodModal" tabindex="-1" role="dialog" aria-labelledby="bloodModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form id="bloodTestsForm" method="get" action="blood_choosen_dctor_pdf.php" target="_blank" class="modal-form">
        <div class="modal-header">
          <h5 class="modal-title" id="bloodModalLabel">اختر الفحوصات الدموية</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <?php include 'dctor_blood_chooes.php'; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" id="submitBloodTests">إرسال الطلب</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- حاوية Toast لإظهار الإشعارات -->
<div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; min-height: 200px; z-index: 1060;">
  <div id="toast-container"></div>
</div>

<!-- تضمين متغيرات جافاسكريبت بالـ JSON -->
<script type="application/json" id="usageOptions">
    <?php echo json_encode($usageOptions); ?>
</script>

<!-- استدعاء ملفات الجافاسكريبت الخارجية -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>
<script src="includes/js/myjs.js"></script>
</body>
</html>
