<?php
// print_bill.php

// الاتصال بقاعدة البيانات
include '../includes/db.php';

// الحصول على invoice_id من المعاملات GET
$invoice_id = isset($_GET['invoice_id']) ? intval($_GET['invoice_id']) : 0;

if ($invoice_id <= 0) {
    echo "معرف الفاتورة غير صالح.";
    exit();
}

// جلب تفاصيل الفاتورة
$sql = "SELECT 
            i.invoice_id,
            i.request_id,
            i.pat_id,
            i.fname,
            i.name_ser,
            i.cost_ser,
            i.invoice_date,
            p.fname AS patient_name
        FROM invoice i
        JOIN patinte p ON i.pat_id = p.pat_id
        WHERE i.invoice_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $invoice_id);
$stmt->execute();
$result = $stmt->get_result();
$bill = $result->fetch_assoc();

if (!$bill) {
    echo "لم يتم العثور على الفاتورة المطلوبة.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>سند قبض رقم <?php echo htmlspecialchars($bill['invoice_id']); ?></title>
    <!-- Bootstrap 5 CSS (CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts (Cairo) -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <style>
        @page {
            margin: 0; 
        }
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .invoice {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            font-size: 14px;
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
        .invoice-title-main {
            color: #0d6efd;
            font-size: 1.8rem;
            margin-bottom: 15px;
            font-weight: bold;
            text-align: center;
            width: 100%;
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
                <img src="../img/one.png" alt="شعار الشركة" class="logo">
            </div>
            <div class="col-md-4 text-center mb-3 mb-md-0">
                <div class="invoice-title-main">سند قبض</div>
            </div>
            <div class="text-end">
                <h2 class="text-primary">عيادة النفس المطمئنة</h2>
                <p>العنوان: صنعاء، اليمن</p>
                <p>هاتف: 777164964</p>
            </div>
        </div>
        <div class="invoice-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5 class="text-primary"><i class="bi bi-person-fill"></i> بيانات المريض</h5>
                    <p><strong>اسم المريض:</strong> <?php echo htmlspecialchars($bill['patient_name']); ?></p>
                    <p><strong>رقم الطلب:</strong> <?php echo htmlspecialchars($bill['request_id']); ?></p>
                </div>
                <div class="col-md-6 text-end">
                    <h5 class="text-primary"><i class="bi bi-cash-stack"></i> تفاصيل الدفع</h5>
                    <p><strong>الخدمة:</strong> <?php echo htmlspecialchars($bill['name_ser']); ?></p>
                    <p><strong>المبلغ:</strong> <?php echo number_format($bill['cost_ser'], 2); ?> ريال يمني</p>
                    <p><strong>تاريخ الفاتورة:</strong> <?php echo htmlspecialchars($bill['invoice_date']); ?></p>
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
                    <!-- نفترض أن كل الفحص = سطر أو يمكنك جمعها بسطر واحد -->
                    <tr>
                        <td><?php echo htmlspecialchars($bill['name_ser']); ?></td>
                        <td>1</td>
                        <td><?php echo number_format($bill['cost_ser'], 2); ?> ريال</td>
                        <td><?php echo number_format($bill['cost_ser'], 2); ?> ريال</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-end"><strong>الإجمالي</strong></td>
                        <td><strong><?php echo number_format($bill['cost_ser'], 2); ?> ريال</strong></td>
                    </tr>
                </tbody>
            </table>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>شروط وأحكام:</strong></p>
                    <p>يرجى الاحتفاظ بهذه الفاتورة للرجوع إليها عند الحاجة.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p><strong>التوقيع:</strong></p>
                    <p>_________________________</p>
                </div>
            </div>
        </div>
        <div class="invoice-footer text-center">
            <p>شكراً لاستخدامكم خدماتنا</p>
            <p>&copy; <?php echo date("Y"); ?> عيادة النفس المطمئنة. جميع الحقوق محفوظة.</p>
        </div>
        <button onclick="window.print()" class="btn btn-primary btn-print">
            <i class="bi bi-printer"></i> طباعة الفاتورة
        </button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
