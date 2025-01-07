<?php
// fetch_bill.php

// الاتصال بقاعدة البيانات
include '../includes/db.php';

// الحصول على bill_id من المعاملات GET
$bill_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($bill_id <= 0) {
    echo "معرف الفاتورة غير صالح.";
    exit();
}

// جلب تفاصيل الفاتورة باستخدام Prepared Statement
$sql = "SELECT bill_id, recip_name, amount, bill_date FROM pay_bill WHERE bill_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $bill_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bill = $result->fetch_assoc();
    
    if (!$bill) {
        echo "لم يتم العثور على الفاتورة المطلوبة.";
        exit();
    }
} else {
    error_log("خطأ في الاستعلام: " . $conn->error);
    echo "حدث خطأ أثناء معالجة الطلب. يرجى المحاولة لاحقًا.";
    exit();
}

// إغلاق الاتصال بقاعدة البيانات
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة رقم <?php echo htmlspecialchars($bill['bill_id']); ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .invoice {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .invoice-header, .invoice-footer {
            border-bottom: 2px solid #dee2e6;
            padding-bottoad 15px;
            margin-bottom: 20px;
        }

        .invoice-footer {
            border-top: 2px solid #dee2e6;
            border-bottom: none;
            padding-top: 15px;
            margin-top: 20px;
        }

        .logo {
            max-width: 150px;
        }

        .invoice-title {
            color: #0d6efd;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .table th {
            background-color: #0d6efd;
            color: #ffffff;
        }

        .btn-print {
            margin-top: 20px;
        }

        @media print {
            .btn-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="invoice">
            <div class="invoice-header d-flex justify-content-between align-items-center">
                <div>
                    <!-- تأكد من تحديث مسار الشعار -->
                    <img src="../img/one.png" alt="شعار الشركة" class="logo">
                </div>
                <div class="text-end">
                    <h1 class="invoice-title">أمر صرف</h1>
                    <p><strong>رقم الفاتورة:</strong> <?php echo htmlspecialchars($bill['bill_id']); ?></p>
                    <p><strong>تاريخ الفاتورة:</strong> <?php echo htmlspecialchars($bill['bill_date']); ?></p>
                </div>
            </div>
            <div class="invoice-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>تفاصيل المستفيد</h5>
                        <p><strong>اسم الخدمة:</strong> <?php echo htmlspecialchars($bill['recip_name']); ?></p>
                        <!-- يمكنك إضافة المزيد من التفاصيل هنا -->
                    </div>
                    <div class="col-md-6 text-end">
                        <h5>تفاصيل الدفع</h5>
                        <p><strong>المبلغ:</strong> <?php echo number_format($bill['amount'], 2); ?> ريال</p>
                        <!-- يمكنك إضافة المزيد من التفاصيل هنا -->
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>الوصف</th>
                            <th>الكمية</th>
                            <th>السعر الفردي</th>
                            <th>الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- مثال على تفاصيل الفاتورة -->
                        <tr>
                            <td>خدمة <?php echo htmlspecialchars($bill['recip_name']); ?></td>
                            <td>1</td>
                            <td><?php echo number_format($bill['amount'], 2); ?> ريال</td>
                            <td><?php echo number_format($bill['amount'], 2); ?> ريال</td>
                        </tr>
                        <!-- يمكنك إضافة المزيد من الصفوف حسب الحاجة -->
                        <tr>
                            <td colspan="3" class="text-end"><strong>الإجمالي</strong></td>
                            <td><strong><?php echo number_format($bill['amount'], 2); ?> ريال</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="invoice-footer text-center">
                <p>شكراً لاستخدامكم خدماتنا.</p>
                <p>_________________________</p>
                <p>التوقيع</p>
            </div>
            <div class="text-center">
                <button onclick="window.print()" class="btn btn-primary btn-print">طباعة الفاتورة</button>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS and dependencies (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
