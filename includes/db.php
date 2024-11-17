<?php
// includes/db.php

// إعداد معلومات الاتصال بقاعدة البيانات
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "najmdb";

// إنشاء اتصال باستخدام mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    // يمكنك تسجيل الخطأ في ملف سجل بدلاً من عرضه للمستخدم
    error_log("Connection failed: " . $conn->connect_error);
    die("خطأ في الاتصال بقاعدة البيانات.");
}
?>
