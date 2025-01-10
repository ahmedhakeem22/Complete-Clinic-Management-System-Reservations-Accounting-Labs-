<?php
// store_blood_request.php

header('Content-Type: application/json');
include '../includes/db.php';

// التحقق من وجود pat_id والفحوصات
if (!isset($_POST['pat_id']) || empty($_POST['pat_id'])) {
    echo json_encode(['status'=>'error','message'=>'رقم المريض مطلوب']);
    exit;
}

$pat_id = intval($_POST['pat_id']);

// مصفوفة الفحوصات
$testsChosen = $_POST['test'] ?? [];
if (count($testsChosen) === 0) {
    echo json_encode(['status'=>'error','message'=>'لم يتم اختيار أي فحص']);
    exit;
}

// 1) حساب التكلفة الإجمالية
$placeholders = rtrim(str_repeat('?,', count($testsChosen)), ',');
$sql = "SELECT test_id, price FROM tests WHERE test_id IN ($placeholders)";
$stmt = $conn->prepare($sql);
$types = str_repeat('i', count($testsChosen));
$stmt->bind_param($types, ...$testsChosen);
$stmt->execute();
$res = $stmt->get_result();

$totalCost = 0;
$testPrices = [];
while ($row = $res->fetch_assoc()) {
    $testPrices[] = $row;  
    $totalCost += $row['price'];
}

// 2) إنشاء سجل في lab_requests
$requestDate = date("Y-m-d H:i:s");
$status = 'new';
$stmtReq = $conn->prepare("
    INSERT INTO lab_requests (pat_id, request_date, status, total_cost)
    VALUES (?,?,?,?)
");
$stmtReq->bind_param("issd", $pat_id, $requestDate, $status, $totalCost);
$execReq = $stmtReq->execute();
$newRequestId = $stmtReq->insert_id;

if (!$execReq) {
    echo json_encode(['status'=>'error','message'=>'تعذّر إنشاء الطلب']);
    exit;
}

// 3) إدخال تفاصيل الفحوصات
$stmtDetail = $conn->prepare("
    INSERT INTO lab_request_tests (request_id, test_id, price)
    VALUES (?,?,?)
");
foreach ($testPrices as $test) {
    $testId = $test['test_id'];
    $price  = $test['price'];
    $stmtDetail->bind_param("iid", $newRequestId, $testId, $price);
    $stmtDetail->execute();
}

// أخيرًا نرجع JSON بالنجاح
echo json_encode(['status'=>'success','message'=>'تم حفظ الطلب بنجاح', 'request_id'=>$newRequestId]);
exit;
