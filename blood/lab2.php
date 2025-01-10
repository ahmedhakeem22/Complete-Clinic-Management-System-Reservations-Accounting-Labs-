<?php
// lab2.php

// تضمين ملف الاتصال بقاعدة البيانات
include '../includes/db.php';
include 'includes/templates/header.php';

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
$test_sql = "SELECT test_id, test_name, category_id, normal_range, is_parent, is_sub_test_level FROM tests ORDER BY category_id ASC, test_id ASC";
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

// إغلاق الاتصال بقاعدة البيانات في نهاية السكريبت
// (يمكن غلق الاتصال هنا أو تركه)
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدخال نتائج الفحوصات</title>
    <!-- ربط Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- إضافة أيقونات Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* تخصيص لوحة الألوان */
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --accent-color: #198754;
            --background-color: #f8f9fa;
            --text-color: #212529;
            --card-bg: #ffffff;
            --navbar-bg: #343a40;
            --navbar-text: #ffffff;
            --header-height: 60px; /* ارتفاع الرأس */
            --sidebar-width: 250px; /* عرض الشريط الجانبي */
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* شريط التنقل الجانبي */
        .sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background-color: var(--navbar-bg);
            color: var(--navbar-text);
            padding-top: 20px;
            transition: all 0.3s;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar a {
            color: var(--navbar-text);
            text-decoration: none;
            display: block;
            padding: 15px 20px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: var(--primary-color);
        }

        /* رأس الصفحة */
        .navbar-custom {
            background-color: var(--navbar-bg);
            height: var(--header-height);
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            z-index: 1100;
            display: flex;
            align-items: center;
            padding: 0 20px;
        }

        .navbar-custom .navbar-brand {
            color: var(--navbar-text);
            font-size: 1.5rem;
            text-decoration: none;
        }

        .navbar-custom .navbar-text {
            margin-left: auto;
            color: var(--navbar-text);
            display: flex;
            align-items: center;
        }

        .navbar-custom .navbar-text i {
            margin-right: 5px;
        }

        /* المحتوى الرئيسي */
        .main-content {
            margin-top: var(--header-height);
            margin-left: var(--sidebar-width);
            padding: 20px;
        }

        /* بطاقات المعلومات */
        .info-card {
            background-color: var(--card-bg);
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .info-card:hover {
            transform: translateY(-5px);
        }

        /* تخصيص الجداول */
        table thead {
            background-color: var(--primary-color);
            color: #ffffff;
        }

        table tbody tr:nth-child(even) {
            background-color: #e9f3fb;
        }

        /* تخصيص المودال */
        .modal-header {
            background-color: var(--secondary-color);
            color: #ffffff;
        }

        .modal-footer .btn-secondary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: #ffffff;
        }

        .modal-footer .btn-secondary:hover {
            background-color: #157347;
            border-color: #157347;
        }

        /* أيقونات الشارات */
        .badge-primary {
            background-color: var(--primary-color);
        }

        .badge-secondary {
            background-color: var(--secondary-color);
        }

        .badge-accent {
            background-color: var(--accent-color);
            color: #ffffff;
        }

        /* حالة عدم وجود طلبات */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 60vh;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: var(--secondary-color);
        }

        /* تحسين تنسيق الفئات والاختبارات */
        .category-toggle {
            cursor: pointer;
            background-color: #d6d8db;
            padding: 15px;
            border-radius: 10px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            margin-bottom: 10px;
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

        /* استجابة التصميم */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .navbar-custom {
                left: 0;
                width: 100%;
                height: var(--header-height);
            }
            .main-content {
                margin-left: 0;
                padding: 80px 10px 10px 10px;
            }
        }

        /* تخصيص الأزرار */
        .btn-info-custom {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: #ffffff;
        }

        .btn-info-custom:hover {
            background-color: #3ab5a4;
            border-color: #3ab5a4;
        }

        /* تنسيق الشارات */
        .badge-custom {
            font-size: 0.9em;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var categoryToggles = document.querySelectorAll('.category-toggle');
            categoryToggles.forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    this.classList.toggle('open');
                    var tests = this.nextElementSibling;
                    if (tests.style.display === 'block') {
                        tests.style.display = 'none';
                    } else {
                        tests.style.display = 'block';
                    }
                });
            });
        });
    </script>
</head>
<body>

    <!-- شريط التنقل الجانبي -->
    <div class="sidebar">
        <a href="lab2.php"><i class="bi bi-house-door-fill me-2"></i> الصفحة الرئيسية</a>
        <a href="lab_view_requests.php"><i class="bi bi-list-check me-2"></i> إدارة الطلبات</a>
        <a href="manage_tests.php"><i class="bi bi-gear-fill me-2"></i> الإعدادات</a>
        <a href="login.php"><i class="bi bi-box-arrow-right me-2"></i> تسجيل الخروج</a>
    </div>

    <!-- رأس الصفحة -->
    <nav class="navbar navbar-custom">
        <a class="navbar-brand" href="#">نظام المختبر</a>
        <div class="navbar-text">
            <i class="bi bi-bell-fill me-2"></i>
            <i class="bi bi-person-circle me-2"></i> المدير
        </div>
    </nav>

    <!-- المحتوى الرئيسي -->
    <div class="main-content">
        <!-- نموذج البحث عن المريض -->
        <div class="card mb-4">
            <div class="card-body">
                <h2 class="mb-4 text-center text-primary">استعلام عن بيانات المريض</h2>
                <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <label for="pat_id" class="form-label">رقم المريض:</label>
                            <input type="number" id="pat_id" name="pat_id" class="form-control" required/>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <input type="submit" value="استعلام" class="btn btn-warning w-100" name="Submit_pation"/>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="button" onclick="location.href='select_blood_test.php';" class="btn btn-danger w-100">
                                <i class="bi bi-search"></i> استعلام عن فحص
                            </button>
                        </div>
                    </div>
                </form>

                <?php 
                // عرض بيانات المريض إن وجد
                if($pat_idd > 0 && $r){
                    echo '<div class="mt-4">';
                    echo '<h4 class="mb-3 text-center text-success">بيانات المريض</h4>';
                    echo '<table class="table table-bordered">';
                    echo '<tbody>';
                    while($row = $r->fetch_assoc()){
                        echo "<tr>";
                        echo "<th scope='row'>اسم:</th><td>" .htmlspecialchars($row['fname'])."</td>";
                        echo "<th scope='row'>العمر:</th><td>" .htmlspecialchars($row['age'])."</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th scope='row'>الجنس:</th><td>" .htmlspecialchars($row['gander'])."</td>";
                        echo "<th scope='row'>الهاتف:</th><td>" .htmlspecialchars($row['phone'])."</td>";
                        echo "</tr>";
                    }
                    echo '</tbody>';
                    echo '</table>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>

        <!-- نموذج إدخال نتائج الفحوصات -->
        <div class="card">
            <div class="card-body">
                <h2 class="mb-4 text-center text-primary">إدخال نتائج الفحوصات</h2>
                <form action="" method="POST">
                    <!-- إذا كان المريض معروفًا، حقل مخفي لتمرير pat_id -->
                    <?php if($pat_idd > 0): ?>
                        <input type="hidden" name="pat_id" value="<?= $pat_idd; ?>"/>
                    <?php else: ?>
                        <!-- إذا لم يكن المريض معروفًا، أعرض حقل إدخال pat_id -->
                        <div class="mb-3">
                            <label for="pat_id_result" class="form-label">رقم المريض:</label>
                            <input type="number" id="pat_id_result" name="pat_id" class="form-control" required/>
                        </div>
                    <?php endif; ?>

                    <!-- عرض الفئات والاختبارات -->
                    <?php foreach ($categories as $category): ?>
                        <div class="mb-4">
                            <div class="category-toggle d-flex justify-content-between align-items-center p-3 rounded">
                                <h5 class="mb-0 text-dark">
                                    <i class="bi bi-chevron-right me-2 category-icon"></i>
                                    <?= htmlspecialchars($category['name']); ?>
                                </h5>
                            </div>
                            <div class="category-tests">
                                <table class="table table-striped">
                                    <tbody>
                                        <?php 
                                        $testsOfCat = $category['tests'];
                                        foreach(array_chunk($testsOfCat,2) as $twoTests):
                                        ?>
                                            <?php foreach($twoTests as $testItem): ?>
                                                <?php 
                                                    $isParent = $testItem['is_parent'] == 1;
                                                    $isSubTest = $testItem['is_sub_test_level'] == 1;
                                                    $rowStyle = $isParent ? 'background-color: #ffc107; font-weight: bold;' : ''; // لون مميز لـ is_parent
                                                    if ($isSubTest && !$isParent) {
                                                        $rowStyle = 'background-color: #ffc107;'; // نفس اللون لـ is_sub_test_level
                                                    }
                                                ?>
                                                <tr style="<?= $rowStyle; ?>">
                                                    <th scope="row"><?= htmlspecialchars($testItem['test_name']); ?></th>
                                                    <td>
                                                        <?php if (!($isParent && $isSubTest) && !$isParent): ?>
                                                            <input type="text"
                                                                   id="test_<?= $testItem['test_id']; ?>"
                                                                   name="test_<?= $testItem['test_id']; ?>"
                                                                   class="form-control"
                                                                   placeholder="اكتب النتيجة..."/>
                                                        <?php else: ?>
                                                            <!-- إذا كان الاختبار هو Parent أو Sub Test، لا تعرض حقل إدخال -->
                                                            <span class="badge badge-secondary badge-custom">لا يتطلب إدخال</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- زر إرسال النتائج -->
                    <div class="d-grid gap-2">
                        <button type="submit" name="submit_tests" class="btn btn-success btn-lg">
                            <i class="bi bi-check-circle-fill"></i> إرسال النتائج
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ربط Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
