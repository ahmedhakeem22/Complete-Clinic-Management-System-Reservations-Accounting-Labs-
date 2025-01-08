<?php
// print_receipt.php

// الاتصال بقاعدة البيانات
require_once '../includes/db.php';

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
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <style>
        @page {
            margin: 0;
            /* تعطيل الهوامش الافتراضية للصفحة */
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
            /* إضافة مسافة داخلية مخصصة للطباعة */
        }

        .invoice {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 14px;
            max-width: 800px;
            margin: auto;
        }

        .invoice-header {
            border-bottom: 1px solid #0d6efd;
            padding-bottom: 10px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .invoice-footer {
            border-top: 1px solid #0d6efd;
            padding-top: 10px;
            margin-top: 15px;
            font-size: 12px;
            text-align: center;
        }

        .logo {
            max-width: 120px;
        }

        .invoice-title-main {
            color: #0d6efd;
            font-size: 1.8rem;
            margin-bottom: 10px;
            font-weight: bold;
            text-align: center;
            width: 100%;
        }

        .text-primary {
            color: #0d6efd !important;
            font-size: 16px;
        }

        .table th {
            background-color: #0d6efd;
            color: #ffffff;
            font-size: 13px;
            padding: 8px;
        }

        .table td {
            font-size: 13px;
            padding: 8px;
        }

        .btn-print {
            margin-top: 15px;
            font-size: 14px;
        }

        @media print {
            .btn-print {
                display: none;
            }

            body {
                margin: 0;
            }

            .invoice {
                box-shadow: none;
                border: none;
            }
        }

        /* تحسين استجابة التصميم للشاشات الصغيرة */
        @media (max-width: 576px) {
            .invoice-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .text-end {
                text-align: left !important;
                margin-top: 10px;
            }

            .invoice-title-main {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="invoice-header">
            <div>
                <!-- تأكد من تحديث مسار الشعار -->
                <img src="../img/one.png" alt="شعار الشركة" class="logo">
            </div>
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <div class="invoice-title-main">
                    سند قبض
                </div>
            </div>
            <div class="text-end">
                <!-- اسم الشركة والعنوان -->
                <h2 class="text-primary">عيادة النفس المطمئنة</h2>
                <p>العنوان: صنعاء، اليمن</p>
                <p>هاتف: 777164964</p>
            </div>
        </div>
        <div class="invoice-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5 class="text-primary"><i class="bi bi-person-fill"></i> تفاصيل الداعم</h5>
                    <p><strong>اسم الداعم:</strong> <?php echo htmlspecialchars($receipt['name_pro']); ?></p>
                    <!-- يمكنك إضافة المزيد من التفاصيل هنا إذا لزم الأمر -->
                </div>
                <div class="col-md-6 text-end">
                    <h5 class="text-primary"><i class="bi bi-cash-stack"></i> تفاصيل السند</h5>
                    <p><strong>المبلغ:</strong> <?php echo number_format($receipt['cost_ser'], 2); ?> ريال</p>
                    <p><strong>تاريخ السند:</strong> <?php echo htmlspecialchars($receipt['date_pro']); ?></p>
                    <!-- يمكنك إضافة المزيد من التفاصيل هنا إذا لزم الأمر -->
                </div>
            </div>
            <table class="table table-striped table-bordered">
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
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>شروط وأحكام:</strong></p>
                    <p>يرجى الاحتفاظ بهذا السند للرجوع إليه عند الحاجة. في حالة وجود أي استفسارات، لا تتردد في الاتصال بنا.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p><strong>التوقيع:</strong></p>
                    <p>_________________________</p>
                </div>
            </div>
        </div>
        <div class="invoice-footer">
            <p>شكراً لدعمكم المستمر.</p>
            <p>&copy; <?php echo date("Y"); ?> عيادة النفس المطمئنة. جميع الحقوق محفوظة.</p>
        </div>
        <div class="text-center">
            <button onclick="window.print()" class="btn btn-primary btn-print">
                <i class="bi bi-printer"></i> طباعة السند
            </button>
        </div>
    </div>

    <!-- Bootstrap 5 JS and dependencies (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
