<?php
// process_book_session.php

// إعداد استجابة JSON
header('Content-Type: application/json');

// تمكين عرض الأخطاء (للتصحيح فقط، قم بإزالتها في الإنتاج)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// الاتصال بقاعدة البيانات
include '../includes/db.php';

// تعيين الترميز إلى utf8mb4
mysqli_set_charset($conn, "utf8mb4");

// تعيين المنطقة الزمنية
date_default_timezone_set("Asia/Aden");

// دالة تنظيف المدخلات
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// التحقق من وجود البيانات المطلوبة
if(isset($_POST['pat_id']) && isset($_POST['fname']) && isset($_POST['session_price'])) {
    $pat_id = sanitize_input($_POST['pat_id']);
    $fname = sanitize_input($_POST['fname']);
    $session_price = floatval($_POST['session_price']);
    $invoice_date = date("Y-m-d");

    // معلومات الخدمة
    $name_ser = "حجز جلسة";
    $cost_ser = $session_price;

    // إدخال البيانات في جدول الفواتير
    // تأكد من أن جدول الفواتير يتوافق مع البيانات المدخلة
    $stmt = $conn->prepare("INSERT INTO invoice (pat_id, name_ser, cost_ser, invoice_date, fname) VALUES (?, ?, ?, ?, ?)");
    if(!$stmt){
        echo json_encode(['success' => false, 'error' => 'خطأ في تحضير الاستعلام: ' . $conn->error]);
        exit;
    }
    $stmt->bind_param("sssss", $pat_id, $name_ser, $cost_ser, $invoice_date, $fname);

    if(!$stmt->execute()){
        echo json_encode(['success' => false, 'error' => 'خطأ في تنفيذ الاستعلام: ' . $stmt->error]);
        exit;
    }

    // الحصول على معرف الفاتورة المضافة
    $invoice_id = $stmt->insert_id;
    $stmt->close();
    $conn->close();

    // إنشاء رابط صفحة الفاتورة
    $invoice_url = 'fetch_bill.php?id=' . $invoice_id;

    // إرسال استجابة ناجحة مع رابط الفاتورة
    echo json_encode(['success' => true, 'invoice_url' => $invoice_url]);
} else {
    echo json_encode(['success' => false, 'error' => 'بيانات المريض غير مكتملة.']);
}
?>
