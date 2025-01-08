<?php
// book_out_ach_pdf_insrt.php

// الاتصال بقاعدة البيانات
include '../includes/db.php';

// ضبط المنطقة الزمنية (إن لزم الأمر)
date_default_timezone_set("Asia/Aden");
$today = date("Y-m-d");

// جلب القيم من النموذج مع التحقق والتطهير
$recip_name      = isset($_POST['recip_name']) ? trim($_POST['recip_name']) : '';
$category_id     = isset($_POST['category_id']) ? intval($_POST['category_id']) : 0;
$amount          = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
$payment_method  = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : '';
$invoice_number  = isset($_POST['invoice_number']) ? trim($_POST['invoice_number']) : '';
$description     = isset($_POST['description']) ? trim($_POST['description']) : '';
$bill_date       = isset($_POST['bill_date']) ? $_POST['bill_date'] : $today;
$recipient_type  = isset($_POST['recipient_type']) ? $_POST['recipient_type'] : '';
$recipient_id    = isset($_POST['recipient_id']) ? intval($_POST['recipient_id']) : 0;
$vendor_id       = 0;
$employee_id     = 0;

// تحديد المستلم بناءً على نوعه
if ($recipient_type == 'vendor') {
    $vendor_id = $recipient_id;
} elseif ($recipient_type == 'employee') {
    $employee_id = $recipient_id;
}

// التحقق من البيانات الأساسية
$errors = [];

if (empty($recip_name)) {
    $errors[] = "يرجى إدخال اسم الصرف.";
}

if ($category_id <= 0) {
    $errors[] = "يرجى اختيار فئة المصروف.";
}

if ($amount <= 0) {
    $errors[] = "يرجى إدخال مبلغ صالح.";
}

$valid_payment_methods = ['نقدًا', 'تحويل بنكي', 'بطاقة ائتمان', 'آخر'];
if (empty($payment_method) || !in_array($payment_method, $valid_payment_methods)) {
    $errors[] = "يرجى اختيار طريقة دفع صحيحة.";
}

if ($recipient_type == 'vendor' && $vendor_id <= 0) {
    $errors[] = "يرجى اختيار المورد.";
}

if ($recipient_type == 'employee' && $employee_id <= 0) {
    $errors[] = "يرجى اختيار الموظف المسؤول.";
}

if (empty($bill_date)) {
    $errors[] = "يرجى اختيار تاريخ الصرف.";
}

// إذا وجدت أخطاء، عرضها والتوقف
if (!empty($errors)) {
    echo "<h3>حدثت بعض الأخطاء:</h3><ul>";
    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error) . "</li>";
    }
    echo "</ul><p><a href='book_out.php'>العودة إلى نموذج إضافة مصروف</a></p>";
    exit;
}

// التحقق من سيولة الصندوق قبل الإدخال (اختياري)
/*
$sql_invoices = "SELECT SUM(cost_ser) AS sum_invoices FROM invoice";
$result_invoices = $conn->query($sql_invoices);
$row_invoices = $result_invoices->fetch_assoc();
$sum_invoices = floatval($row_invoices['sum_invoices']);

$sql_pay = "SELECT SUM(amount) AS sum_pay FROM pay_bill";
$result_pay = $conn->query($sql_pay);
$row_pay = $result_pay->fetch_assoc();
$sum_pay = floatval($row_pay['sum_pay']);

$current_balance = $sum_invoices - $sum_pay;

if ($amount > $current_balance) {
    echo "<h3>عذراً، لا يوجد رصيد كافٍ لإجراء هذا الصرف.</h3>";
    echo "<p>السيولة المتاحة حالياً: " . number_format($current_balance, 2) . " ريال يمني</p>";
    echo "<p>المبلغ المطلوب صرفه: " . number_format($amount, 2) . " ريال يمني</p>";
    echo "<p><a href='book_out.php'>العودة إلى نموذج إضافة مصروف</a></p>";
    exit;
}
*/

// إدخال البيانات في قاعدة البيانات باستخدام Prepared Statements
$sql_insert = "INSERT INTO pay_bill (recip_name, category_id, amount, payment_method, invoice_number, description, vendor_id, bill_date, employee_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert);

if ($stmt) {
    // إعداد القيم لضمان عدم تمرير NULL مباشرة
    // إذا كان vendor_id أو employee_id غير محدد، نمرر 0
    $vendor_id = ($vendor_id > 0) ? $vendor_id : NULL;
    $employee_id = ($employee_id > 0) ? $employee_id : NULL;

    // تحديد نوع المعاملات
    // s - string, i - integer, d - double
    // recip_name: s
    // category_id: i
    // amount: d
    // payment_method: s
    // invoice_number: s
    // description: s
    // vendor_id: i (nullable)
    // bill_date: s
    // employee_id: i (nullable)

    // بدلاً من تمرير NULL مباشرة، نستخدم متغيرات منفصلة وتمريرها كـ integer
    // إذا كانت NULL، نستخدم قيمة 0 أو نتركها كما هي إذا كانت قاعدة البيانات تسمح بـ NULL
    // تأكد من أن الحقول vendor_id و employee_id في قاعدة البيانات تسمح بـ NULL

    // استخدام bind_param مع 'i' لنقل NULL كـ 0 إذا كانت غير محددة
    $stmt->bind_param(
        "sidsssisi",
        $recip_name,      // s
        $category_id,     // i
        $amount,          // d
        $payment_method,  // s
        $invoice_number,  // s
        $description,     // s
        $vendor_id,       // i
        $bill_date,       // s
        $employee_id      // i
    );

    if ($stmt->execute()) {
        // الحصول على المعرّف (bill_id) الذي تم إدخاله
        $new_bill_id = $stmt->insert_id;

        // إغلاق Statement
        $stmt->close();

        // إعادة التوجيه مباشرة إلى صفحة الطباعة مع تمرير bill_id
        header("Location: print_bill.php?id=" . $new_bill_id);
        exit; // مهم لإنهاء التنفيذ بعد إعادة التوجيه
    } else {
        // في حال وجود خطأ في تنفيذ الاستعلام
        echo "<h3>حدث خطأ أثناء إضافة المصروف:</h3><p>" . htmlspecialchars($stmt->error) . "</p>";
        echo "<p><a href='book_out.php'>العودة إلى نموذج إضافة مصروف</a></p>";
    }
} else {
    // في حال وجود خطأ في تحضير الاستعلام
    echo "<h3>حدث خطأ أثناء تحضير الاستعلام:</h3><p>" . htmlspecialchars($conn->error) . "</p>";
    echo "<p><a href='book_out.php'>العودة إلى نموذج إضافة مصروف</a></p>";
}

$conn->close();
?>
