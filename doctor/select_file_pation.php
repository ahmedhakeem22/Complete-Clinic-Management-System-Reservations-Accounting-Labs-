<?php 
// تضمين الملفات الأساسية (الرأس + القائمة + الاتصال بقاعدة البيانات)
include 'includes/templates/header.php';  
include 'includes/templates/navbar.php';
include '../includes/db.php';

// دالة لتعقيم المدخلات
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>عرض بيانات المريض</title>
  <!-- تضمين Bootstrap لتحسين التنسيق -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container my-5">

    <h2 class="mb-4">بحث عن جلسات وتقارير مريض</h2>
    <!-- نموذج لإدخال رقم المريض -->
    <form action="" method="GET" class="row g-3 mb-4">
      <div class="col-auto">
        <label for="pat_id" class="col-form-label">رقم المريض:</label>
      </div>
      <div class="col-auto">
        <input type="number" name="pat_id" id="pat_id" class="form-control" required>
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-primary">عرض</button>
      </div>
    </form>

<?php
// التحقق إن تم إدخال رقم المريض
if(isset($_GET['pat_id']) && is_numeric($_GET['pat_id'])){
    
    $pat_id = (int)test_input($_GET['pat_id']);

    // جلب بيانات المريض الأساسية باستخدام العبارات المحضرة
    $stmtPat = $conn->prepare("SELECT * FROM patinte WHERE pat_id = ?");
    $stmtPat->bind_param("i", $pat_id);
    $stmtPat->execute();
    $resultPat = $stmtPat->get_result();

    if($rowPat = $resultPat->fetch_assoc()){
        echo "<h4>بيانات المريض:</h4>";
        echo "<ul class='list-group mb-4'>";
        echo "<li class='list-group-item'><strong>رقم المريض:</strong> " . $rowPat['pat_id'] . "</li>";
        echo "<li class='list-group-item'><strong>الاسم:</strong> " . $rowPat['fname'] . "</li>";
        echo "<li class='list-group-item'><strong>العمر:</strong> " . $rowPat['age'] . "</li>";
        echo "<li class='list-group-item'><strong>الهاتف:</strong> " . $rowPat['phone'] . "</li>";
        echo "<li class='list-group-item'><strong>الجنس:</strong> " . $rowPat['gander'] . "</li>";
        echo "<li class='list-group-item'><strong>الدولة:</strong> " . $rowPat['contry'] . "</li>";
        echo "<li class='list-group-item'><strong>المدينة:</strong> " . $rowPat['city'] . "</li>";
        echo "<li class='list-group-item'><strong>الحالة الاجتماعية:</strong> " . $rowPat['soc_sts'] . "</li>";
        echo "<li class='list-group-item'><strong>عدد الأطفال:</strong> " . $rowPat['chel_num'] . "</li>";
        echo "<li class='list-group-item'><strong>الوظيفة:</strong> " . $rowPat['jop'] . "</li>";
        echo "<li class='list-group-item'><strong>الزواج:</strong> " . $rowPat['rig_pat'] . "</li>";
        echo "<li class='list-group-item'><strong>تاريخ الإكمال:</strong> " . $rowPat['date_com'] . "</li>";
        echo "</ul>";
    } else {
        echo "<div class='alert alert-danger'>عذراً، لا يوجد مريض بهذا الرقم.</div>";
        exit();
    }

    // جلب الجلسات غير الفارغة لهذا المريض باستخدام العبارات المحضرة
    $stmtSessions = $conn->prepare("
        SELECT * FROM session 
        WHERE pat_id = ?
          AND (
            TRIM(main_com)     <> '' OR
            TRIM(period_ill)   <> '' OR
            TRIM(sex_hist)     <> '' OR
            TRIM(person_hist)  <> '' OR
            TRIM(curr_hist)    <> ''
          )
        ORDER BY date_now DESC
    ");
    $stmtSessions->bind_param("i", $pat_id);
    $stmtSessions->execute();
    $resultSessions = $stmtSessions->get_result();

    if(mysqli_num_rows($resultSessions) > 0){
        echo "<h4>سجل الجلسات (غير الفارغة):</h4>";
        echo "<table class='table table-bordered text-center'>";
        echo "<thead class='table-dark'>";
        echo "<tr>
                <th>رقم الجلسة</th>
                <th>تاريخ الجلسة</th>
                <th>تاريخ الجلسة التالية</th>
                <th>عرض/طباعة</th>
              </tr>";
        echo "</thead>";
        echo "<tbody>";

        while($rowSession = $resultSessions->fetch_assoc()){
            echo "<tr>";
            echo "<td>" . $rowSession['id_session'] . "</td>";
            echo "<td>" . $rowSession['date_now'] . "</td>";
            echo "<td>" . $rowSession['date_next'] . "</td>";
            
            // رابط للعرض أو الطباعة 
            echo "<td>
                    <a href='report_file_pation_pdf.php?pat_id=".$pat_id."&session_id=".$rowSession['id_session']."'
                       class='btn btn-info btn-sm' target='_blank'>
                       عرض/طباعة
                    </a>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<div class='alert alert-warning'>لا توجد جلسات غير فارغة مسجّلة لهذا المريض.</div>";
    }

    // جلب نتائج التحاليل من جدول test_results وtests باستخدام العبارات المحضرة
    $stmtTests = $conn->prepare("
        SELECT tr.value, tr.result_date, t.test_name, t.normal_range
        FROM test_results tr
        JOIN tests t ON tr.test_id = t.test_id
        WHERE tr.pat_id = ?
          AND TRIM(tr.value) <> ''
        ORDER BY tr.result_date DESC, t.test_name ASC
    ");
    $stmtTests->bind_param("i", $pat_id);
    $stmtTests->execute();
    $resultTests = $stmtTests->get_result();

    if(mysqli_num_rows($resultTests) > 0){
        echo "<h4>تقارير التحاليل (غير الفارغة)، مجمّعة حسب التاريخ:</h4>";

        // تجميع النتائج حسب التاريخ
        $testsByDate = [];
        while($testRow = $resultTests->fetch_assoc()){
            $testsByDate[$testRow['result_date']][] = $testRow;
        }

        foreach($testsByDate as $date => $tests){
            echo "<div class='border rounded p-3 mb-3'>";
            echo "<h5 class='text-primary'>تاريخ التقرير: $date</h5>";

            echo "<table class='table table-striped table-bordered mt-3'>";
            echo "<thead class='table-secondary'>
                    <tr>
                        <th>اسم التحليل</th>
                        <th>القيمة</th>
                        <th>المدى الطبيعي</th>
                    </tr>
                  </thead>
                  <tbody>";

            foreach($tests as $test){
                echo "<tr>";
                echo "<td>".$test['test_name']."</td>";
                echo "<td>".$test['value']."</td>";
                echo "<td>".$test['normal_range']."</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
            echo "</div>"; // نهاية الإطار الخاص بالتاريخ
        }
    } else {
        echo "<div class='alert alert-warning'>لا توجد نتائج تحاليل غير فارغة لهذا المريض.</div>";
    }

    // جلب بيانات الأدوية من جدول medical باستخدام العبارات المحضرة
    $stmtMedical = $conn->prepare("
        SELECT med_name, usee, countity, date_t 
        FROM medical 
        WHERE pat_id = ?
          AND TRIM(med_name) <> ''
        ORDER BY date_t DESC
    ");
    $stmtMedical->bind_param("i", $pat_id);
    $stmtMedical->execute();
    $resultMedical = $stmtMedical->get_result();

    if(mysqli_num_rows($resultMedical) > 0){
        echo "<h4>الأدوية المصروفة للمريض:</h4>";
        echo "<table class='table table-bordered text-center'>";
        echo "<thead class='table-info'>";
        echo "<tr>
                <th>اسم الدواء</th>
                <th>طريقة الاستخدام</th>
                <th>عدد الجرعات</th>
                <th>التاريخ</th>
              </tr>";
        echo "</thead>";
        echo "<tbody>";
        while($rowMed = $resultMedical->fetch_assoc()){
            echo "<tr>";
            echo "<td>" . $rowMed['med_name'] . "</td>";
            echo "<td>" . $rowMed['usee'] . "</td>";
            echo "<td>" . $rowMed['countity'] . "</td>";
            echo "<td>" . $rowMed['date_t'] . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } 
    else {
        echo "<div class='alert alert-warning'>لا توجد بيانات أدوية غير فارغة لهذا المريض.</div>";
    }

} // نهاية الشرط if(isset($_GET['pat_id']))
?>

</div>

<!-- ملف الفوتر -->
<?php include 'includes/templates/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
