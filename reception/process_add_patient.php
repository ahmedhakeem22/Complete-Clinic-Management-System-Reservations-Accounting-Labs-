<?php
// process_add_patient.php

header('Content-Type: application/json');

// تضمين قاعدة البيانات
include '../includes/db.php';

// دوال لتنظيف البيانات
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// معالجة الطلب إذا كان طريقة الطلب POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_pp'])) {
    $first_name    = sanitize_input($_POST['first_name']);
    $second_name   = sanitize_input($_POST['second_name']);
    $third_name    = sanitize_input($_POST['third_name']);
    $last_name     = sanitize_input($_POST['last_name']);
    $Pat_fname     = "$first_name $second_name $third_name $last_name";
    
    $pat_age       = intval($_POST['pat_age']);
    $pat_phon      = sanitize_input($_POST['pat_phon']);
    $pat_gander    = sanitize_input($_POST['pat_gander']);
    $pat_contry    = sanitize_input($_POST['pat_contry']);
    $pat_city      = sanitize_input($_POST['pat_city']);
    $Pat_sts       = sanitize_input($_POST['Pat_sts']);
    $pat_chel      = intval($_POST['pat_chel']);
    $pat_jop       = sanitize_input($_POST['pat_jop']);
    $pat_prig      = sanitize_input($_POST['pat_prig']);
    $pat_note      = sanitize_input($_POST['pat_note']);
    $birthdaytime  = sanitize_input($_POST['birthdaytime']);
    $pat_date      = date("Y-m-d H:i:s");

    // التحقق من صحة البيانات
    $errors_add = [];
    if (empty($Pat_fname)) {
        $errors_add[] = "الاسم الكامل مطلوب.";
    }
    if (!preg_match('/^(77|78|70|71|73)\d{7}$/', $pat_phon)) {
        $errors_add[] = "رقم الهاتف غير صالح. يجب أن يبدأ بـ 77، 78، 70، 71، أو 73 ويكون بطول 9 أرقام.";
    }
    if ($pat_age <= 0) {
        $errors_add[] = "العمر يجب أن يكون رقمًا موجبًا.";
    }
    if (!in_array($pat_gander, ['M', 'F'])) {
        $errors_add[] = "الجنس غير صالح.";
    }

    if (empty($errors_add)) {
        // تحضير الاستعلام لإضافة مريض جديد
        $stmt_add = $conn->prepare("INSERT INTO patinte (fname, age, phone, gander, contry, city, soc_sts, chel_num, jop, rig_pat, note_pat, date_com, birthdaytime)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if($stmt_add === false){
            echo json_encode(['success' => false, 'error' => "خطأ في تحضير الاستعلام: " . $conn->error]);
            exit();
        } else {
            // ربط المعاملات مع أنواع البيانات المناسبة
            $stmt_add->bind_param("sisssssssssss", $Pat_fname, $pat_age, $pat_phon, $pat_gander, $pat_contry, $pat_city, $Pat_sts, $pat_chel, $pat_jop, $pat_prig, $pat_note, $pat_date, $birthdaytime);
            
            // تنفيذ الاستعلام والتحقق من النجاح
            if($stmt_add->execute()){
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => "حدث خطأ: " . $stmt_add->error]);
            }

            // إغلاق الاستعلام
            $stmt_add->close();
        }
    } else {
        // تجميع رسائل الأخطاء
        echo json_encode(['success' => false, 'error' => implode(" ", $errors_add)]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'طلب غير صالح.']);
}
?>
