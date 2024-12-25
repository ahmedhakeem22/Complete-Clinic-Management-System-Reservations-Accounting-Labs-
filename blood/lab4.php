<?php
// lab2.php

// تضمين ملفات الهيدر والنافبار (اختياري)
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';

// تضمين ملف الاتصال بقاعدة البيانات
include '../includes/db.php';

session_start();

// متغير لجلب المريض (إذا بحثنا عنه)
$pat_idd = 0;
$r = null;

// ----- 1) جلب الفئات والاختبارات من جدول test_categories و tests -----
$categories = [];
$cat_sql = "SELECT category_id, category_name FROM test_categories ORDER BY category_id ASC";
$stmt_cat = $conn->prepare($cat_sql);
$stmt_cat->execute();
$res_cat = $stmt_cat->get_result();
while($row = $res_cat->fetch_assoc()){
    $categories[$row['category_id']] = [
        'name' => $row['category_name'],
        'tests' => []
    ];
}
$stmt_cat->close();

// جلب الاختبارات
$test_sql = "SELECT test_id, test_name, category_id, normal_range FROM tests ORDER BY category_id, test_name";
$stmt_test = $conn->prepare($test_sql);
$stmt_test->execute();
$res_test = $stmt_test->get_result();
while($row = $res_test->fetch_assoc()){
    $cat_id = $row['category_id'];
    if(isset($categories[$cat_id])){
        $categories[$cat_id]['tests'][] = $row;
    }
}
$stmt_test->close();

// ----- 2) بحث عن المريض (عند الضغط على زر "استعلام") -----
if(isset($_GET['Submit_pation']) && isset($_GET['pat_id'])){
    $pat_idd = intval($_GET['pat_id']);
    $_SESSION['pat_id'] = $pat_idd;

    // جلب بيانات المريض
    $stmt = $conn->prepare("SELECT fname, age, gander, phone FROM patinte WHERE pat_id = ?");
    $stmt->bind_param("i", $pat_idd);
    $stmt->execute();
    $r = $stmt->get_result();
    $stmt->close();
}

// ----- 3) حفظ النتائج في test_results (عند الضغط على زر "إرسال النتائج") -----
if(isset($_POST['submit_tests'])){
    // جلب رقم المريض
    $pat_id = intval($_POST['pat_id'] ?? 0);

    if($pat_id <= 0){
        exit("رقم المريض غير صالح.");
    }

    // مصفوفة للاختبارات المدخلة
    $choseTests = $_POST; // سنبحث عن مفاتيح test_{test_id}

    // إعداد استعلام الإدخال
    $sql_insert = "INSERT INTO test_results (pat_id, test_id, value, result_date) VALUES (?,?,?,?)";
    $stmt_insert = $conn->prepare($sql_insert);

    $inserted_ids = [];  // للاحتفاظ بمعرّفات النتائج (result_id)
    $result_date = date("Y-m-d");

    foreach($choseTests as $key => $value){
        if(strpos($key, 'test_') === 0){
            // test_123 => 123
            $test_id_str = substr($key, 5);
            $test_id = intval($test_id_str);
            $val = trim($value);

            // إذا القيمة غير فارغة
            if($test_id > 0 && $val !== ''){
                $stmt_insert->bind_param("iiss", $pat_id, $test_id, $val, $result_date);
                $stmt_insert->execute();
                
                $new_id = $stmt_insert->insert_id; 
                if($new_id > 0){
                    $inserted_ids[] = $new_id;
                }
            }
        }
    }
    $stmt_insert->close();

    if(empty($inserted_ids)){
        exit("لم يتم إدخال أي نتائج فحوصات.");
    }

    // تحويل المصفوفة إلى سلسلة
    $result_ids_str = implode(',', $inserted_ids);

    // إعادة التوجيه للصفحة الثانية للطباعة
    header("Location: prent_save.php?pat_id={$pat_id}&result_ids={$result_ids_str}");
    exit;
}

// (يمكن غلق الاتصال هنا أو تركه)
?>
<!DOCTYPE html>
<html>
<head>
    <title>Insert Test</title>
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <link href="css/style.css" rel="stylesheet"/>
    <link href="css/style1.css" rel="stylesheet"/>
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet"/>
    <style>
        /* تنسيقات الصفحة */
        body {
            background-color: #f5f5f5;
        }
        main {
            padding: 20px;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        h2, h3 {
            color: #dc3545;
            text-align: center;
        }
        h2 {
            font-size: 1.8rem;
        }
        .category-toggle span {
            font-size: 1.3rem;
        }
        label {
            font-weight: bold;
        }
        .btn-warning, .btn-danger, .btn-success {
            margin-top: 10px;
        }
        table.table {
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
        }
        th {
            background-color: #343a40;
            color: #ffffff;
            text-align: center;
        }
        .category-toggle {
            cursor: pointer;
            background-color: #d6d8db;
            padding: 15px;
            border-radius: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .category-toggle:hover {
            background-color: #c2c4c7;
        }
        .category-tests {
            display: none; /* الإخفاء الافتراضي */
            margin-top: 10px;
            padding: 20px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .category-icon {
            transition: transform 0.3s ease;
        }
        .category-toggle.open .category-icon {
            transform: rotate(90deg);
        }
        .category-toggle.open {
            background-color: #e9ecef;
        }
        .test-row {
            display: flex;
            justify-content: space-between;
        }
        .test-row div {
            width: 48%;
        }
        .category-tests tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        .category-tests tr:nth-child(even) {
            background-color: #ffffff;
        }
        .category-tests table {
            width: 100%;
            border-spacing: 0;
            border-collapse: separate;
        }
        .category-tests td {
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        .category-tests input.form-control {
            border-radius: 5px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script src="includes/js/jquery-3.4.1.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".category-toggle").click(function(){
                $(this).toggleClass("open");
                $(this).next(".category-tests").slideToggle();
            });
        });
    </script>
</head>
<body>
    <main>
        <!-- نموذج البحث عن المريض -->
        <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
            <div class="table-responsive">
                <table id="mytable" class="table table-dark table-striped table-bordered table-active" style="color:#000;">
                    <thead>
                        <tr>
                            <th colspan="3">استعلام عن بيانات المريض</th>
                        </tr>
                    </thead>
                    <tr>
                        <td>
                            <label for="pat_id">رقم المريض:</label>
                            <input type="number" id="pat_id" name="pat_id" class="form-control" required/>
                        </td>
                        <td>
                            <input type="submit" value="استعلام" class="btn btn-warning" name="Submit_pation" style="width:180px;"/>
                        </td>
                        <td>
                            <button type="button" onclick="location.href='select_blood_test.php';" class="btn btn-danger">
                                استعلام عن فحص
                            </button>
                        </td>
                    </tr>
                    <?php 
                    // عرض بيانات المريض إن وجد
                    if($pat_idd > 0 && $r){
                        while($row = $r->fetch_assoc()){
                            echo "<tr>";
                            echo "<td>اسم: " .htmlspecialchars($row['fname'])."</td>";
                            echo "<td>العمر: " .htmlspecialchars($row['age'])."</td>";
                            echo "<td>الجنس: " .htmlspecialchars($row['gander'])."</td>";
                            echo "<td>الهاتف: " .htmlspecialchars($row['phone'])."</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </form>

        <!-- نموذج إدخال نتائج الفحوصات -->
        <form action="" method="POST">
            <div class="table-responsive card card-cascade narrower">
                <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
                    <h2 class="text-center" style="margin:0 auto;text-align:center;">جدول إدخال نتائج الفحوصات</h2>
                </div>

                <!-- إذا كان المريض معروفًا، حقل مخفي لتمرير pat_id -->
                <?php if($pat_idd > 0): ?>
                    <input type="hidden" name="pat_id" value="<?= $pat_idd; ?>"/>
                <?php else: ?>
                    <!-- إذا لم يكن المريض معروفًا، أعرض حقل إدخال pat_id -->
                    <div class="form-group">
                        <label for="pat_id_result">رقم المريض:</label>
                        <input type="number" id="pat_id_result" name="pat_id" class="form-control" required/>
                    </div>
                <?php endif; ?>

                <!-- عرض الفئات والاختبارات -->
                <?php foreach ($categories as $category): ?>
                    <div class="category-section">
                        <div class="category-toggle">
                            <span>
                                <h2 class="label label-danger" style="text-align:center;">
                                    <span class="label label-danger badge" style="text-align:center;color:Brown;">
                                        <img src="includes/images/options2.png" alt="Category Icon" class="category-icon" style="width:25px;height:20px;"/>
                                        <?= htmlspecialchars($category['name']); ?>
                                    </span>
                                </h2>
                            </span>
                        </div>
                        <div class="category-tests">
                            <table>
                                <?php 
                                $testsOfCat = $category['tests'];
                                foreach(array_chunk($testsOfCat,2) as $twoTests):
                                ?>
                                    <tr>
                                        <?php foreach($twoTests as $testItem): ?>
                                        <td style="width:50%;">
                                            <label for="test_<?= $testItem['test_id']; ?>">
                                                <?= htmlspecialchars($testItem['test_name']); ?>:
                                            </label>
                                            <input type="text"
                                                   id="test_<?= $testItem['test_id']; ?>"
                                                   name="test_<?= $testItem['test_id']; ?>"
                                                   class="form-control"
                                                   placeholder="اكتب النتيجة..."/>
                                        </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- زر إرسال النتائج -->
                <div class="form-group text-center">
                    <button type="submit" name="submit_tests" class="btn btn-success btn-lg">
                        إرسال النتائج
                    </button>
                </div>
            </div>
        </form>
    </main>
</body>
</html>
