<?php
// process_edit_patient.php

header('Content-Type: application/json');

// تضمين قاعدة البيانات
include '../includes/db.php';

// دوال لتنظيف البيانات
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// معالجة الطلب إذا كان طريقة الطلب POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_patient'])) {
    $pat_id = intval($_POST['pat_id']);
    $first_name = sanitize_input($_POST['first_name']);
    $middle_name = sanitize_input($_POST['middle_name']);
    $third_name = sanitize_input($_POST['third_name']);
    $last_name = sanitize_input($_POST['last_name']);
    $fname = "$first_name $middle_name $third_name $last_name";
    $age = intval($_POST['age']);
    $phone = sanitize_input($_POST['phone']);
    $gander = sanitize_input($_POST['gander']);
    $birthdaytime = sanitize_input($_POST['birthdaytime']);

    // التحقق من صحة البيانات الأساسية
    $errors = [];
    if (empty($first_name) || empty($middle_name) || empty($third_name) || empty($last_name)) {
        $errors[] = "الاسم الكامل مطلوب (الاسم الأول، الثاني، الثالث، واللقب).";
    }
    if ($age <= 0) {
        $errors[] = "العمر يجب أن يكون رقمًا موجبًا.";
    }
    if (!preg_match('/^(77|78|70|71|73)\d{7}$/', $phone)) {
        $errors[] = "رقم الهاتف يجب أن يكون مكونًا من 9 أرقام ويبدأ بـ 77، 78، 70، 71، أو 73.";
    }
    if (!in_array($gander, ['M', 'F'])) {
        $errors[] = "الجنس غير صالح.";
    }

    if (empty($errors)) {
        // استخدام الاستعلام المحضر لتحديث البيانات
        $stmt_update = $conn->prepare("UPDATE patinte SET fname = ?, age = ?, phone = ?, gander = ?, birthdaytime = ? WHERE pat_id = ?");
        if ($stmt_update) {
            $stmt_update->bind_param("siissi", $fname, $age, $phone, $gander, $birthdaytime, $pat_id);
            
            if ($stmt_update->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => "خطأ في تحديث السجل: " . $stmt_update->error]);
            }

            $stmt_update->close();
        } else {
            echo json_encode(['success' => false, 'error' => "خطأ في إعداد الاستعلام: " . $conn->error]);
        }
    } else {
        // تجميع رسائل الأخطاء
        echo json_encode(['success' => false, 'error' => implode(" ", $errors)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'طلب غير صالح.']);
}
?>
