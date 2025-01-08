<?php
// pro_pdf.php

// الاتصال بقاعدة البيانات
include '../includes/db.php';

// التحقق من استلام البيانات
if (isset($_POST['add_sess'])) {
    // استخدام دوال السلامة للحصول على البيانات
    $name_pro = trim($_POST['name_pro']);
    $cost_ser = floatval($_POST['cost_ser']);
    $date_pro = $_POST['date_pro'];
    $note = trim($_POST['note']);

    // التحقق من صحة البيانات (إضافي)
    if (empty($name_pro) || $cost_ser < 0 || empty($date_pro)) {
        // يمكنك إعادة توجيه المستخدم مع رسالة خطأ أو عرض رسالة هنا
        echo "يرجى ملء جميع الحقول المطلوبة بشكل صحيح.";
        exit();
    }

    // إعداد الاستعلام للإدخال باستخدام Prepared Statements
    $stmt = $conn->prepare("INSERT INTO provider (name_pro, cost_ser, date_pro, note) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        error_log("خطأ في التحضير للاستعلام: " . $conn->error);
        echo "حدث خطأ في الخادم. يرجى المحاولة لاحقًا.";
        exit();
    }

    $stmt->bind_param("sdss", $name_pro, $cost_ser, $date_pro, $note);

    if ($stmt->execute()) {
        // الحصول على ID السجل الجديد
        $new_id = $stmt->insert_id;

        // إغلاق الاستعلام
        $stmt->close();

        // إعادة التوجيه إلى صفحة الطباعة مع ID السجل
        header("Location: print_receipt.php?id=" . $new_id);
        exit();
    } else {
        // تسجيل الخطأ وعرض رسالة للمستخدم
        error_log("خطأ في إضافة السند: " . $stmt->error);
        echo "حدث خطأ أثناء إضافة السند. يرجى المحاولة لاحقًا.";
    }

    // إغلاق الاتصال بقاعدة البيانات
    $conn->close();
} else {
    // إذا لم يتم إرسال النموذج بشكل صحيح
    echo "طلب غير صالح.";
    exit();
}
?>
