<?php
// fetch_patient_name.php

header('Content-Type: application/json');

// الاتصال بقاعدة البيانات
include '../includes/db.php';

// تعيين الترميز إلى utf8mb4
mysqli_set_charset($conn, "utf8mb4");

// دالة تنظيف المدخلات
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// التحقق من وجود pat_id
if(isset($_GET['pat_id'])) {
    $pat_id = sanitize_input($_GET['pat_id']);

    // استعلام لجلب اسم المريض
    $stmt = $conn->prepare("SELECT fname FROM patinte WHERE pat_id = ?");
    if(!$stmt){
        echo json_encode(['success' => false, 'error' => 'خطأ في تحضير الاستعلام.']);
        exit;
    }
    $stmt->bind_param("s", $pat_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        echo json_encode(['success' => true, 'fname' => $row['fname']]);
    } else {
        echo json_encode(['success' => false, 'error' => 'لم يتم العثور على المريض.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'error' => 'معرف المريض غير موجود.']);
}
?>
