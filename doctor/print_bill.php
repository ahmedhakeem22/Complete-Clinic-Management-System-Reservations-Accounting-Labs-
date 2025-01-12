<?php
// print_bill.php

// الاتصال بقاعدة البيانات
include '../includes/db.php';

// الحصول على bill_id من المعاملات GET
$bill_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($bill_id <= 0) {
    echo "معرف الفاتورة غير صالح.";
    exit();
}

// جلب تفاصيل الفاتورة باستخدام Prepared Statement مع LEFT JOIN لجلب بيانات الفئة والمورد والموظف
$sql = "SELECT 
            pb.bill_id, 
            pb.recip_name, 
            pb.amount, 
            pb.bill_date, 
            c.name AS category_name, 
            v.vendor_name, 
            e.name AS employee_name, 
            pb.payment_method, 
            pb.invoice_number, 
            pb.description
        FROM 
            pay_bill pb
        JOIN 
            categories c ON pb.category_id = c.id
        LEFT JOIN 
            vendors v ON pb.vendor_id = v.vendor_id
        LEFT JOIN 
            employees e ON pb.employee_id = e.id
        WHERE 
            pb.bill_id = ?";
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
    <title>سند صرف رقم <?php echo htmlspecialchars($bill['bill_id']); ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <style>
       @page {
        size: A4 portrait; /* حجم الصفحة A4 بوضع عمودي */
        margin: 0; /* إلغاء الهوامش الافتراضية */
    }

    body {
        margin: 0;
        padding: 0;
        font-family: 'Cairo', sans-serif;
        width: 100%;
    }

    .invoice {
        height: 50%; /* تخصيص النصف العلوي فقط */
        width: 100%; /* تغطية العرض بالكامل */
        padding: 20px;
        margin: 0;
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        font-size: 14px;
        box-sizing: border-box; /* لضمان عرض الفاتورة بشكل صحيح */
    }


        .invoice-header {
            border-bottom: 1px solid #0d6efd;
            padding-bottom: 10px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .invoice-footer {
            border-top: 1px solid #0d6efd;
            padding-top: 10px;
            margin-top: 15px;
            font-size: 12px;
        }

        .logo {
            max-width: 120px;
        }

        .invoice-title {
            color: #0d6efd;
            font-size: 1.5rem;
            margin-bottom: 5px;
            font-weight: bold;
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

        .text-primary {
            color: #0d6efd !important;
            font-size: 16px;
        }

        @media print {
        .btn-print {
            display: none; /* إخفاء زر الطباعة */
        }

        .invoice {
            box-shadow: none;
            border: none;
            position: absolute;
            top: 0; /* تثبيت المحتوى في أعلى الصفحة */
            width: 100%; /* تغطية العرض بالكامل */
            filter: saturate(1.5); /* زيادة التشبع بمقدار 1.5 */
        }

        body {
            -webkit-print-color-adjust: exact; /* تمكين الطباعة بالألوان الدقيقة */
            print-color-adjust: exact;
        }
    }
       
            .invoice-title-main {
            color: #0d6efd;
            font-size: 1.8rem;
            margin-bottom: 15px;
            font-weight: bold;
            text-align: center;
            width: 100%;
            margin-bottom: 10px;

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
        }
    </style>
</head>

<body>
    <div class="container">
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
                        <h5 class="text-primary"><i class="bi bi-person-fill"></i> تفاصيل المستفيد</h5>
                        <p><strong>اسم الخدمة:</strong> <?php echo htmlspecialchars($bill['recip_name']); ?></p>
                        <p><strong>الفئة:</strong> <?php echo htmlspecialchars($bill['category_name']); ?></p>
                        <?php if (!empty($bill['vendor_name'])): ?>
                            <p><strong>المورد:</strong> <?php echo htmlspecialchars($bill['vendor_name']); ?></p>
                        <?php elseif (!empty($bill['employee_name'])): ?>
                            <p><strong>الموظف المسؤول:</strong> <?php echo htmlspecialchars($bill['employee_name']); ?></p>
                        <?php else: ?>
                            <p><strong>المستلم:</strong> غير محدد</p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 text-end">
                        <h5 class="text-primary"><i class="bi bi-cash-stack"></i> تفاصيل الدفع</h5>
                        <p><strong>المبلغ:</strong> <?php echo number_format($bill['amount'], 2); ?> ريال يمني</p>
                        <p><strong>طريقة الدفع:</strong> <?php echo htmlspecialchars($bill['payment_method']); ?></p>
                        <p><strong>رقم الفاتورة/المرجع:</strong> <?php echo htmlspecialchars($bill['invoice_number'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                </div>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>الوصف</th>
                            <th>الكمية</th>
                            <th>السعر الفردي</th>
                            <th>الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- تفاصيل الفاتورة -->
                        <tr>
                            <td>خدمة <?php echo htmlspecialchars($bill['recip_name']); ?></td>
                            <td>1</td>
                            <td><?php echo number_format($bill['amount'], 2); ?> ريال يمني</td>
                            <td><?php echo number_format($bill['amount'], 2); ?> ريال يمني</td>
                        </tr>
                        <!-- يمكنك إضافة المزيد من الصفوف حسب الحاجة -->
                        <tr>
                            <td colspan="3" class="text-end"><strong>الإجمالي</strong></td>
                            <td><strong><?php echo number_format($bill['amount'], 2); ?> ريال يمني</strong></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>الوصف:</strong></td>
                            <td><?php echo nl2br(htmlspecialchars($bill['description'] ?? '', ENT_QUOTES, 'UTF-8')); ?></td>
                            </tr>
                    </tbody>
                </table>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>شروط وأحكام:</strong></p>
                        <p>يرجى الاحتفاظ بهذه الفاتورة للرجوع إليها عند الحاجة. في حالة وجود أي استفسارات، لا تتردد في الاتصال بنا.</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <p><strong>التوقيع:</strong></p>
                        <p>_________________________</p>
                    </div>
                </div>
            </div>
            <div class="invoice-footer text-center">
                <p>شكراً لاستخدامكم خدماتنا.</p>
                <p>&copy; <?php echo date("Y"); ?> عيادة النفس المطمئنة. جميع الحقوق محفوظة.</p>
            </div>
            <button onclick="window.print()" class="btn btn-primary btn-print">
                <i class="bi bi-printer"></i> طباعة الفاتورة
            </button>
        </div>
    </div>

    <!-- Bootstrap 5 JS and dependencies (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
