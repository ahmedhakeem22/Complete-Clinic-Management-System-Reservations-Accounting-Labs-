<?php
// choess_blood_box_preview.php

// 1) استدعاء ملف الاتصال بقاعدة البيانات
include '../includes/db.php';

// 2) التحقق من صحة المدخلات
if (!isset($_POST['pat_id']) || empty($_POST['pat_id'])) {
    echo "<div class='alert alert-danger'>رقم المريض غير موجود. الرجاء العودة واختياره.</div>";
    exit;
}
$pat_id = intval($_POST['pat_id']);

// اختبارات مختارة
if (!isset($_POST['test']) || !is_array($_POST['test']) || count($_POST['test']) === 0) {
    echo "<div class='alert alert-warning'>لم تقم باختيار أي اختبار.</div>";
    exit;
}
$chose = $_POST['test'];

// 3) جلب اسم المريض (اختياري للعرض)
$stmt_name = $conn->prepare("SELECT fname FROM patinte WHERE pat_id = ?");
$stmt_name->bind_param("i", $pat_id);
$stmt_name->execute();
$res_name = $stmt_name->get_result();
$row_name = $res_name->fetch_assoc();

if (!$row_name) {
    echo "<div class='alert alert-danger'>المريض غير موجود في قاعدة البيانات.</div>";
    exit;
}
$patient_name = htmlspecialchars($row_name['fname']);

// 4) جلب بيانات الفحوصات المختارة
$placeholders = rtrim(str_repeat('?,', count($chose)), ',');
$sql_tests = "SELECT test_id, test_name, price FROM tests WHERE test_id IN ($placeholders)";
$stmt_tests = $conn->prepare($sql_tests);

// إنشاء الأنواع الديناميكي بناءً على عدد الاختبارات
$types = str_repeat('i', count($chose));
$stmt_tests->bind_param($types, ...$chose);
$stmt_tests->execute();
$result_tests = $stmt_tests->get_result();

// جمع البيانات لحساب المجموع
$testsData = [];
$total = 0;
while ($row = $result_tests->fetch_assoc()) {
    $testsData[] = $row;
    $total += $row['price'];
}

// 5) عرض النتائج للمستخدم
?>

<h2>تأكيد الفحوصات المختارة للمريض: <?= $patient_name ?> (ID: <?= $pat_id ?>)</h2>

<table class="table table-bordered">
    <thead class="thead-light">
        <tr>
            <th>Test ID</th>
            <th>Test Name</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($testsData as $test): ?>
        <tr>
            <td><?= $test['test_id'] ?></td>
            <td><?= htmlspecialchars($test['test_name']) ?></td>
            <td><?= number_format($test['price'], 2) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" style="text-align:right;">Total</th>
            <th><?= number_format($total, 2) ?></th>
        </tr>
    </tfoot>
</table>

<br>
<form action="choess_blood_box_pdf.php" method="post">
    <!-- نمرّر رقم المريض والفحوصات المختارة مرة أخرى (الأفضل POST) -->
    <input type="hidden" name="pat_id" value="<?= $pat_id ?>" />
    
    <?php foreach ($chose as $test_id): ?>
        <input type="hidden" name="test[]" value="<?= $test_id ?>" />
    <?php endforeach; ?>

    <!-- عند الضغط على هذا الزر، سيتم تنفيذ الحفظ + الطباعة -->
    <button type="submit" class="btn btn-primary">
        تأكيد الدفع وطباعة الفاتورة
    </button>
</form>
