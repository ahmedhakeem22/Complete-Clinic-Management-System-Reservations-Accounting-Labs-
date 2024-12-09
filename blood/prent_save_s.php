<?php
// تضمين ملفات الاتصال بقاعدة البيانات وجلب بيانات المريض والاختبارات
include '../includes/db.php';
session_start();

// التحقق من معرف المريض في الجلسة
$pat_idd = isset($_SESSION['pat_id']) ? $_SESSION['pat_id'] : 0;

// جلب بيانات المريض من قاعدة البيانات
$patient_data = [];
if ($pat_idd > 0) {
    $stmt = $conn->prepare("SELECT fname, age, gander, phone FROM patinte WHERE pat_id = ?");
    $stmt->bind_param("i", $pat_idd);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $patient_data = $row;
    }
    $stmt->close();
}

// جلب الفئات والاختبارات
$categories = [];
$category_stmt = $conn->prepare("SELECT category_id, category_name FROM test_categories");
$category_stmt->execute();
$category_result = $category_stmt->get_result();
while ($row = $category_result->fetch_assoc()) {
    $categories[$row['category_id']] = [
        'name' => $row['category_name'],
        'tests' => []
    ];
}
$category_stmt->close();

$test_stmt = $conn->prepare("SELECT test_id, test_name, category_id FROM tests ORDER BY category_id, test_name");
$test_stmt->execute();
$test_result = $test_stmt->get_result();
while ($row = $test_result->fetch_assoc()) {
    if (isset($categories[$row['category_id']])) {
        $categories[$row['category_id']]['tests'][] = $row;
    }
}
$test_stmt->close();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تقرير الفحوصات</title>
    <link href="css/bootstrap.min.css" rel="stylesheet"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            direction: rtl;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: right;
        }
        table th {
            background-color: #f2f2f2;
        }
        .patient-info, .test-results {
            margin-bottom: 20px;
        }
        .patient-info h3, .test-results h3 {
            text-align: center;
        }
        .btn-print {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-print:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function printReport() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 class="text-center">تقرير نتائج الفحوصات</h1>

        <!-- بيانات المريض -->
        <div class="patient-info">
            <h3>معلومات المريض</h3>
            <table>
                <tr>
                    <th>اسم المريض</th>
                    <td><?php echo htmlspecialchars($patient_data['fname']); ?></td>
                </tr>
                <tr>
                    <th>العمر</th>
                    <td><?php echo htmlspecialchars($patient_data['age']); ?></td>
                </tr>
                <tr>
                    <th>الجنس</th>
                    <td><?php echo htmlspecialchars($patient_data['gander']); ?></td>
                </tr>
                <tr>
                    <th>رقم الهاتف</th>
                    <td><?php echo htmlspecialchars($patient_data['phone']); ?></td>
                </tr>
            </table>
        </div>

        <!-- نتائج الفحوصات -->
        <div class="test-results">
            <h3>نتائج الفحوصات</h3>
            <?php
            // نقوم بالتكرار عبر الفئات
            foreach ($categories as $category):
                $hasResults = false; // متغير لمعرفة إذا كانت هذه الفئة تحتوي على نتائج

                // التحقق من الفحوصات داخل الفئة
                foreach ($category['tests'] as $test):
                    $test_value = isset($_POST['test_' . $test['test_id']]) ? $_POST['test_' . $test['test_id']] : '';
                    if (!empty($test_value)) {
                        $hasResults = true; // إذا كان هناك نتيجة، فإن الفئة تحتوي على نتائج
                        break;
                    }
                endforeach;

                // إذا كانت الفئة تحتوي على نتائج فقط نقوم بطباعتها
                if ($hasResults):
            ?>
                    <h4><?php echo htmlspecialchars($category['name']); ?></h4>
                    <table>
                        <thead>
                            <tr>
                                <th>اسم الفحص</th>
                                <th>النتيجة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($category['tests'] as $test): 
                                $test_value = isset($_POST['test_' . $test['test_id']]) ? $_POST['test_' . $test['test_id']] : '';
                                if (!empty($test_value)): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($test['test_name']); ?></td>
                                        <td><?php echo htmlspecialchars($test_value); ?></td>
                                    </tr>
                                <?php endif;
                            endforeach; ?>
                        </tbody>
                    </table>
                <?php endif;
            endforeach;
            ?>
        </div>

        <!-- زر الطباعة -->
        <div class="text-center">
            <button class="btn-print" onclick="printReport()">طباعة التقرير</button>
        </div>
    </div>
</body>
</html>
