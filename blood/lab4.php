<?php
// تضمين ملفات الهيدر والنافبار
include 'templats/header.php';
include 'templats/navbar.php';

// تضمين ملف الاتصال بقاعدة البيانات من المسار المحدد
include '../includes/db.php';

// بدء الجلسة لتخزين معرف المريض بين الصفحات (اختياري ولكن مفيد)
session_start();

// تهيئة متغير معرّف المريض
$pat_idd = 0;

// جلب الفئات والاختبارات
$categories = [];
$category_stmt = $conn->prepare("SELECT category_id, category_name FROM test_categories");
$category_stmt->execute();
$category_result = $category_stmt->get_result();
while($row = $category_result->fetch_assoc()){
    $categories[$row['category_id']] = [
        'name' => $row['category_name'],
        'tests' => []
    ];
}
$category_stmt->close();

$test_stmt = $conn->prepare("SELECT test_id, test_name, category_id FROM tests ORDER BY category_id, test_name");
$test_stmt->execute();
$test_result = $test_stmt->get_result();
while($row = $test_result->fetch_assoc()){
    if(isset($categories[$row['category_id']])){
        $categories[$row['category_id']]['tests'][] = $row;
    }
}
$test_stmt->close();

// التحقق من إرسال نموذج البحث عن المريض
if(isset($_GET['Submit_pation']) && isset($_GET['pat_id'])){
    // تنظيف مدخلات المستخدم
    $pat_idd = intval($_GET['pat_id']);
    
    // تخزين معرف المريض في الجلسة
    $_SESSION['pat_id'] = $pat_idd;
    
    // استخدام استعلام محضر لتحسين الأمان
    $stmt = $conn->prepare("SELECT fname, age, gander, phone FROM patinte WHERE pat_id = ?");
    $stmt->bind_param("i", $pat_idd);
    $stmt->execute();
    $r = $stmt->get_result();
    $stmt->close();
}

// إغلاق الاتصال بقاعدة البيانات في النهاية
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
            margin-bottom: 20px; /* مسافة بين كل فئة */
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
    <script src="js/jquery-3.4.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".category-toggle").click(function () {
                $(this).toggleClass("open");
                $(this).next(".category-tests").slideToggle();
            });
        });
    </script>
</head>
<body> 
    <main>
        <!-- نموذج البحث عن المريض -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="GET">
            <div class="table-responsive">
                <table id="mytable" class="table table-dark table-striped table-bordered table-hover table-active">
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
                            <button type="button" onclick="location.href='select_blood_test.php';" class="btn btn-danger">استعلام عن فحص</button>
                        </td>  
                    </tr>
                    <?php 
                    if($pat_idd > 0){
                        while($row = mysqli_fetch_array($r)){
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
        <form action="prent_save_s.php" method="POST">
            <div class="table-responsive card card-cascade narrower">
                <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
                    <h2 class="text-center" style="margin: 0 auto; text-align: center;">جدول إدخال نتائج الفحوصات</h2>
                </div>
                <!-- إذا كان المريض معروفًا، استخدم حقل مخفي لتمرير pat_id -->
                <?php if($pat_idd > 0): ?>
                    <input type="hidden" name="pat_id" value="<?php echo $pat_idd; ?>"/>
                <?php else: ?>
                    <!-- إذا لم يكن المريض معروفًا، أعرض حقل إدخال pat_id -->
                    <div class="form-group">
                        <label for="pat_id_result">رقم المريض:</label>
                        <input type="number" id="pat_id_result" name="pat_id" class="form-control" required/>
                    </div>
                <?php endif; ?>

                <?php foreach ($categories as $category): ?>
                    <div class="category-section">
                        <div class="category-toggle">
                            <span>
                                <h2 class="label label-danger" style="text-align: center;">
                                    <span class="label label-danger badge" style="text-align: center; color:Brown;">
                                        <img src="includes/img/options2.png" alt="Category Icon" class="category-icon" style="width: 25px; height: 20px;"/>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </span>
                                </h2>
                            </span>
                        </div>
                        <div class="category-tests">
                            <table>
                                <?php foreach (array_chunk($category['tests'], 2) as $tests): ?>
                                    <tr>
                                        <?php foreach ($tests as $test): ?>
                                            <td style="width: 50%;">
                                                <label for="test_<?php echo $test['test_id']; ?>">
                                                    <?php echo htmlspecialchars($test['test_name']); ?>:
                                                </label>
                                                <input type="text" id="test_<?php echo $test['test_id']; ?>" name="test_<?php echo $test['test_id']; ?>" class="form-control" />
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>

                <!-- إضافة زر إرسال البيانات -->
                <div class="form-group text-center">
                    <button type="submit" name="submit_tests" class="btn btn-success btn-lg">إرسال النتائج</button>
                </div>
            </div>
        </form>
    </main>
    <footer></footer> 
    <script src="js/bootstrap.min.js"></script>
    <script src="js/fontawesome.min.js"></script> 
    <script src="js/myjs.js"></script> 
</body>
</html>
