<?php 
// newsession.php

include 'includes/templates/header.php';
include 'includes/templates/navbar.php';
include '../includes/db.php';

// Set the timezone
date_default_timezone_set("Asia/Aden");
$pat_date = date("Y-m-d");

// Define the usage options array
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
    // Add more options as needed
];

// Handle displaying patient information
$pat_idd = 0;
if (isset($_POST['show_det'])) {
  $pat_idd = $_POST['pat_id'];

  // Search for patient information
  $r = mysqli_query($conn, "SELECT fname, age, phone, soc_sts, chel_num FROM patinte WHERE pat_id = $pat_idd ");
}

// Function to sanitize data
function test_input($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

// Handle adding a new session
if (isset($_POST['addsess'])) {

  $pat_id = $_POST['pat_id'];
  $date_pev = $_POST['date_pev'];
  $date_next = $_POST['date_next'];
  $main_com = $_POST['main_com'];
  $period_ill = $_POST['period_ill'];
  $curr_hist = $_POST['curr_hist'];
  $last_hist = $_POST['last_hist'];
  $fam_hist = $_POST['fam_hist'];
  $work_hist = $_POST['work_hist'];
  $sex_hist = $_POST['sex_hist'];
  $person_hist = $_POST['person_hist'];
  $appear = $_POST['appear'];
  $behav = $_POST['behav'];
  $speech = $_POST['speech'];
  $mood = $_POST['mood'];
  $killer = $_POST['killer'];
  $thin_shep = $_POST['thin_shep'];
  $thin_con = $_POST['thin_con'];
  $percep = $_POST['percep'];
  $memory = $_POST['memory'];
  $ability = $_POST['ability'];
  $insight = $_POST['insight'];
  $fores = $_POST['fores'];
  $degree = $_POST['degree'];
  $basic_dig = $_POST['basic_dig'];
  $diff_dig = $_POST['diff_dig'];

  if (empty($_POST["pat_id"])) {
    $Pat_fname = "Patient ID is Required";
    echo $Pat_fname;
  } else {

    $stmt = $conn->prepare("INSERT INTO session (pat_id, date_now, date_pev, date_next, main_com, period_ill, sex_hist, person_hist, curr_hist, last_hist, fam_hist, work_hist, basic_dig, diff_dig, appear, behav, mood, killer, thin_shep, thin_con, percep, memory, ability, insight, fores, degree, speech)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssssssssssssssssssssss", 
        $pat_id, 
        $pat_date, 
        $date_pev, 
        $date_next, 
        $main_com, 
        $period_ill, 
        $sex_hist, 
        $person_hist, 
        $curr_hist, 
        $last_hist, 
        $fam_hist, 
        $work_hist, 
        $basic_dig, 
        $diff_dig, 
        $appear, 
        $behav, 
        $mood, 
        $killer, 
        $thin_shep, 
        $thin_con, 
        $percep, 
        $memory, 
        $ability, 
        $insight, 
        $fores, 
        $degree, 
        $speech
    );
    $stmt->execute();
    
    // عرض إشعار النجاح
    echo "<script>showSuccessMessage('تم إضافة الجلسة بنجاح!');</script>";
    
    // Close the statement
    $stmt->close();
  }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Session</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Bootstrap Multiselect CSS -->
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
              <input type="number" name="pat_id" class="form-control" />
            </label>

            <label> 
              <input style="width:100px; background-color:orange;" class="btn btn-primary form-control"
                  type="submit" value="Fetch" title="Patient Information" name="show_det" />
            </label>
          </td>

          <td colspan='4'>
          </td>
        </tr>
        <tr>
          <?php
          if ($pat_idd > 0) {
            while ($row = mysqli_fetch_array($r)) {

              echo "<tr>";
              echo "<td> Name: " . htmlspecialchars($row['fname']) . "</td>";
              echo "<td> Age: " . htmlspecialchars($row['age']) . "</td>";
              echo "<td> Social Status: " . htmlspecialchars($row['soc_sts']) . "</td>";
              echo "<td> Phone: " . htmlspecialchars($row['phone']) . "</td>";
              echo "<td> Number of Children: " . htmlspecialchars($row['chel_num']) . "</td>";
              echo "</tr>";

            }
          }

          ?>
        </tr>

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
            <input type="date" id="previousdate" name="date_pev" class="form-control" />
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
      </tr>
      <tr>
        <td>
        <label for="family" style="background-color:#007ce2;" class=" form-control "> 
          <strong style="color:white;">Family History:</strong>
        </label>
        <textarea id="family" cols="55" rows="3" name="fam_hist"></textarea>
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
          <label for="Mood and affect" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Mood/Affect:</strong>
          </label>
          <textarea cols="55" rows="3" name="mood" class="form-control"></textarea>
        </td>
      </tr>

      <tr>
      </tr>

      <tr>
        <td>
          <label for="killing" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Suicidal/Homicidal Thoughts/Plans:</strong>
          </label>
          <textarea cols="55" rows="3" name="killer" class="form-control"></textarea>
        </td>

        <td>
          <label for="Thinking" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Thought Form:</strong>
          </label>
          <textarea cols="55" rows="3" name="thin_shep" class="form-control"></textarea>
        </td>

        <td>
          <label for="content" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Thought Content:</strong>
          </label>
          <textarea cols="55" rows="3" name="thin_con" class="form-control"></textarea>
        </td>

        <td>
          <label for="perception" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Perception:</strong>
          </label>
          <textarea cols="55" rows="3" name="percep" class="form-control"></textarea>
        </td>
      </tr>

      <tr>
        <td>
          <label for="Memory" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Memory:</strong>
          </label>
          <textarea cols="55" rows="3" name="memory" class="form-control"></textarea>
        </td>

        <td>
          <label for="judge" style="background-color:#007ce2;" class="form-control"> 
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
          <label for="Foresight" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Cognitive Perception:</strong>
          </label>
          <textarea cols="55" rows="3" name="fores" class="form-control"></textarea>
        </td>
      </tr>

      <tr>
        <td style="width:200px;">
          <label for="degree" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Fullton Degree:</strong>
            <pre></pre>
          </label>
          <input type="number" id="degree" name="degree" class="form-control" />
        </td>

        <td>
          <label for="Basic" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Preliminary Diagnosis:</strong>
          </label>
          <textarea cols="55" rows="3" name="basic_dig" class="form-control"></textarea>
        </td>

        <td colspan='2'>
          <label for="Differential" style="background-color:#007ce2;" class="form-control"> 
            <strong style="color:white;">Differential Diagnosis:</strong>
          </label>
          <textarea cols="125" rows="3" name="diff_dig" class="form-control"></textarea>
        </td>
      </tr>
    </table>

    <table class="table table-striped table-bordered table-hover table-active table-dark" cellspacing="15" cellpadding="0">
      <tr>
        <td>
          <input class="btn btn-success form-control" type="submit" value="Add Session" title="Add Session" name="addsess" />
        </td>

        <!-- زر (Blood Tests) لفتح النافذة المنبثقة الخاصة باختبارات الدم -->
        <td>
          <button type="button" class="btn btn-danger form-control" data-toggle="modal" data-target="#bloodModal" title="Blood Laboratory Tests">
            Blood
          </button>
        </td>

        <!-- زر (Medical Description) لفتح النافذة المنبثقة الخاصة بوصفة الدواء -->
        <td>
          <button type="button" class="btn btn-warning form-control" data-toggle="modal" data-target="#medicalModal" title="Medical Prescription">
            Medical Description
          </button>
        </td>

        <!-- زر (Psychological) لفتح النافذة المنبثقة الخاصة بالاختبارات النفسية -->
        <td>
          <button type="button" class="btn btn-info form-control" data-toggle="modal" data-target="#psychModal" title="Psychological Tests">
            Psychological
          </button>
        </td>
      </tr>
    </table>

  </main>
</form>
<!-- Modal Window for Medical Prescription -->
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="submit" class="btn btn-primary">Save Information</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Window for Psychological Tests -->
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

<!-- Modal Window for Blood Tests -->
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

<!-- حاوية Toasts -->
<div aria-live="polite" aria-atomic="true" style="position: fixed; top: 20px; right: 20px; min-height: 200px; z-index: 1060;">
  <div id="toast-container">
    <!-- سيتم إضافة Toasts هنا ديناميكيًا -->
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // معالجة إرسال نموذج الفحوصات الدموية
    document.getElementById('submitBloodTests').addEventListener('click', function() {
        const formElement = document.getElementById('bloodTestsForm');
        const formData = new FormData(formElement);

        fetch('store_blood_request.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showSuccessMessage('تم إرسال الطلب بنجاح!');
                $('#bloodModal').modal('hide');
            } else {
                alert('حدث خطأ: ' + data.message);
            }
        })
        .catch(err => {
            alert('تعذّر إرسال الطلب، تحقق من الاتصال. ' + err);
        });
    });

    // معالجة إرسال نموذج الوصفة الطبية
    document.getElementById('medicalForm').addEventListener('submit', function(e) {
        e.preventDefault(); // منع الإرسال الافتراضي للنموذج

        const formElement = document.getElementById('medicalForm');
        const formData = new FormData(formElement);

        fetch('sale.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showSuccessMessage('تم إضافة الوصفة الطبية بنجاح!');
                $('#medicalModal').modal('hide');
            } else {
                alert('حدث خطأ: ' + data.message);
            }
        })
        .catch(err => {
            alert('تعذّر إرسال الوصفة الطبية، تحقق من الاتصال. ' + err);
        });
    });
});
</script>


<script>
  // Close the modal after form submission
  document.querySelectorAll('.modal-form').forEach(form => {
    form.addEventListener('submit', function (e) {
      const modal = form.closest('.modal');
      $(modal).modal('hide'); // Close the modal
    });
  });
</script>

<!-- دالة عرض Toast كإشعار عائم -->
<script>
    // دالة في الصفحة الرئيسية يمكن استدعاؤها من النافذة المنبثقة
    function showSuccessMessage(msg) {
        // إنشاء عنصر Toast
        var toast = document.createElement('div');
        toast.className = 'toast';
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.setAttribute('data-delay', '5000'); // مدة عرض الـ Toast بالمللي ثانية

        // محتويات الـ Toast
        toast.innerHTML = `
            <div class="toast-header">
                <strong class="mr-auto text-success">نجاح</strong>
                <small>الآن</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="إغلاق">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                ${msg}
            </div>
        `;

        // إضافة الـ Toast إلى الحاوية
        document.getElementById('toast-container').appendChild(toast);

        // تفعيل Toast باستخدام jQuery
        $(toast).toast('show');

        // إزالة الـ Toast من الـ DOM بعد انتهاء عرضه
        $(toast).on('hidden.bs.toast', function () {
            $(this).remove();
        });
    }
</script>

<!-- Bootstrap and jQuery JS -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Multiselect JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.min.js"></script>

<!-- JavaScript for the Modal Window (for Medical Prescription multi-check usage) -->
<script>
    $(document).ready(function() {
        let drugIndex = 1;

        // Define the usage options array in JavaScript
        const usageOptions = <?php echo json_encode($usageOptions); ?>;

        // Function to add a new medication in the medication form inside the modal window
        $('#add-drug-med').click(function() {
            const newIndex = drugIndex;
            drugIndex++;

            let usageHTML = '';
            $.each(usageOptions, function(value, label) {
                usageHTML += `<label style="margin-right:10px;">
                                <input type="checkbox" name="usage[${newIndex}][]" value="${value}">
                                ${label}
                              </label>`;
            });

            const drugItem = `
                <div class="drug-item border p-3 mb-3">
                    <h5 class="mb-3">Medication #${drugIndex}</h5>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Medication Name</label>
                            <input type="text" name="med_name[]" class="form-control" placeholder="Name" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Quantity</label>
                            <input type="number" name="quantity[]" class="form-control" placeholder="Quantity" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Usage Method</label>
                            <div class="usage-options">
                                ${usageHTML}
                            </div>
                        </div>
                    </div>
                    <span class="remove-drug" style="cursor:pointer; color:red;">&times; Remove Medication</span>
                </div>
            `;
            $('#drugs-container').append(drugItem);
        });

        // Function to remove a medication in the medication form inside the modal window
        $('#drugs-container').on('click', '.remove-drug', function() {
            $(this).closest('.drug-item').remove();
            // Update medication numbers after removal
            drugIndex = 0;
            $('.drug-item').each(function() {
                drugIndex++;
                $(this).find('h5').text(`Medication #${drugIndex}`);
                // Update the names of the usage method fields
                $(this).find('.usage-options input').each(function() {
                    const nameParts = $(this).attr('name').split('[');
                    nameParts[1] = drugIndex - 1;
                    $(this).attr('name', `usage[${drugIndex - 1}][]`);
                });
            });
        });
    });
</script>  
<script>
    // دالة عرض Toast كإشعار عائم
    function showSuccessMessage(msg) {
        // إنشاء عنصر Toast
        var toast = document.createElement('div');
        toast.className = 'toast';
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.setAttribute('data-delay', '5000'); // مدة عرض الـ Toast بالمللي ثانية

        // محتويات الـ Toast
        toast.innerHTML = `
            <div class="toast-header">
                <strong class="mr-auto text-success">نجاح</strong>
                <small>الآن</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="إغلاق">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                ${msg}
            </div>
        `;

        // إضافة الـ Toast إلى الحاوية
        document.getElementById('toast-container').appendChild(toast);

        // تفعيل Toast باستخدام jQuery
        $(toast).toast('show');

        // إزالة الـ Toast من الـ DOM بعد انتهاء عرضه
        $(toast).on('hidden.bs.toast', function () {
            $(this).remove();
        });
    }
</script>

</body>
</html>
