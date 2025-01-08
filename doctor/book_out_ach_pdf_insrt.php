<?php
// book_out_ach_pdf_insrt.php

// الاتصال بقاعدة البيانات
include '../includes/db.php';

// ضبط المنطقة الزمنية (إن لزم الأمر)
date_default_timezone_set("Asia/Aden");
$today = date("Y-m-d");

// جلب القيم من النموذج
$recip_name = isset($_POST['recip_name']) ? trim($_POST['recip_name']) : '';
$amount     = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;

// يمكنك إضافة تحقق إضافي (Validation) على المدخلات هنا
// مثلاً: التأكد من عدم كونها فارغة، وأن المبلغ موجب، إلخ.

// في حال أردت التحقق من سيولة الصندوق قبل الإدخال:
// ----------------------------------------------
// 1) اجمع كل المبالغ من الجدول invoice
$sql_invoices = "SELECT SUM(cost_ser) AS sum_invoices FROM invoice";
$result_invoices = $conn->query($sql_invoices);
$row_invoices = $result_invoices->fetch_assoc();
$sum_invoices = floatval($row_invoices['sum_invoices']);

// 2) اجمع كل المبالغ من الجدول pay_bill
$sql_pay = "SELECT SUM(amount) AS sum_pay FROM pay_bill";
$result_pay = $conn->query($sql_pay);
$row_pay = $result_pay->fetch_assoc();
$sum_pay = floatval($row_pay['sum_pay']);

// 3) السيولة الحالية = إجمالي المبيعات - إجمالي المصروفات
$current_balance = $sum_invoices - $sum_pay;

// التحقق من كفاية السيولة
if ($amount > $current_balance) {
    // إذا المبلغ أكبر من السيولة المتاحة
    // يمكنك تحويله إلى صفحة أخرى مع رسالة خطأ أو عرض تنبيه
    // أو حتى طباعة رسالة بسيطة.
    echo "<h3>عذراً، لا يوجد رصيد كافٍ لإجراء هذا الصرف.</h3>";
    echo "<p>السيولة المتاحة حالياً: $current_balance ريال</p>";
    echo "<p>المبلغ المطلوب صرفه: $amount ريال</p>";
    exit; // إيقاف التنفيذ هنا
}

// إدخال البيانات في قاعدة البيانات
$sql_insert = "INSERT INTO pay_bill (recip_name, amount, bill_date) VALUES (?,?,?)";
$stmt = $conn->prepare($sql_insert);

if ($stmt) {
    $stmt->bind_param("sds", $recip_name, $amount, $today);
    $stmt->execute();
    
    // الحصول على المعرّف (bill_id) الذي تم إدخاله
    $new_bill_id = $stmt->insert_id;
    
    // إغلاق Statement
    $stmt->close();
    
    // إعادة التوجيه مباشرة إلى صفحة الطباعة مع تمرير bill_id
    header("Location: print_bill.php?id=" . $new_bill_id);
    exit; // مهم لإنهاء التنفيذ بعد إعادة التوجيه
} else {
    // في حال وجود خطأ في تحضير الاستعلام
    echo "حدث خطأ أثناء تحضير الاستعلام: " . $conn->error;
    exit;
}
?>
