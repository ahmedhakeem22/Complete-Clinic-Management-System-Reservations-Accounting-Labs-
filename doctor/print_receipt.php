<?php
// print_receipt.php

// الاتصال بقاعدة البيانات
include '../includes/db.php';

// الحصول على id السند من المعاملات GET
$receipt_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($receipt_id <= 0) {
    echo "معرف السند غير صالح.";
    exit();
}

// جلب تفاصيل السند باستخدام Prepared Statement
$sql = "SELECT id, name_pro, cost_ser, date_pro, note FROM provider WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $receipt_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $receipt = $result->fetch_assoc();
    
    if (!$receipt) {
        echo "لم يتم العثور على السند المطلوب.";
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
    <title>سند قبض رقم <?php echo htmlspecialchars($receipt['id']); ?></title>
    <!-- تضمين Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- خطوط جوجل (اختياري) -->
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
            padding-bottom: 15px;
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
                    <h1 class="invoice-title">سند قبض</h1>
                    <p><strong>رقم السند:</strong> <?php echo htmlspecialchars($receipt['id']); ?></p>
                    <p><strong>تاريخ السند:</strong> <?php echo htmlspecialchars($receipt['date_pro']); ?></p>
                </div>
            </div>
            <div class="invoice-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>تفاصيل الداعم</h5>
                        <p><strong>اسم الداعم:</strong> <?php echo htmlspecialchars($receipt['name_pro']); ?></p>
                        <!-- يمكنك إضافة المزيد من التفاصيل هنا -->
                    </div>
                    <div class="col-md-6 text-end">
                        <h5>تفاصيل السند</h5>
                        <p><strong>المبلغ:</strong> <?php echo number_format($receipt['cost_ser'], 2); ?> ريال</p>
                        <!-- يمكنك إضافة المزيد من التفاصيل هنا -->
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>الوصف</th>
                            <th>المبلغ (ريال)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- تفاصيل السند -->
                        <tr>
                            <td>سند قبض لاسم الداعم: <?php echo htmlspecialchars($receipt['name_pro']); ?></td>
                            <td><?php echo number_format($receipt['cost_ser'], 2); ?> ريال</td>
                        </tr>
                        <?php if (!empty($receipt['note'])): ?>
                        <tr>
                            <td colspan="2"><strong>ملاحظات:</strong> <?php echo htmlspecialchars($receipt['note']); ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="text-end"><strong>الإجمالي</strong></td>
                            <td><strong><?php echo number_format($receipt['cost_ser'], 2); ?> ريال</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="invoice-footer text-center">
            <p>شكراً لدعمكم المستمر.</p>
            <p>_________________________</p>
                <p>التوقيع</p>
            </div>
            <div class="text-center">
                <button onclick="window.print()" class="btn btn-primary btn-print">طباعة السند</button>
            </div>
        </div>
    </div>

    <!-- تضمين Bootstrap 5 JS و Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
