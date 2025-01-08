<?php
// get_patient.php

header('Content-Type: application/json');

// تضمين قاعدة البيانات
include '../includes/db.php';

// دوال لتنظيف البيانات
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// التحقق من وجود pat_id في GET
if (isset($_GET['pat_id']) && !empty($_GET['pat_id'])) {
    $pat_id = intval($_GET['pat_id']);

    // جلب بيانات المريض
    $stmt_fetch = $conn->prepare("SELECT * FROM patinte WHERE pat_id = ?");
    $stmt_fetch->bind_param("i", $pat_id);
    $stmt_fetch->execute();
    $result_fetch = $stmt_fetch->get_result();

    if ($result_fetch->num_rows === 1) {
        $patient = $result_fetch->fetch_assoc();
        echo json_encode(['success' => true, 'patient' => $patient]);
    } else {
        echo json_encode(['success' => false, 'error' => 'المريض غير موجود.']);
    }

    $stmt_fetch->close();
} else {
    echo json_encode(['success' => false, 'error' => 'معرف المريض غير موجود.']);
}
?>
