<?php
require_once '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>فاتورة رقم <?php echo isset($_GET['invoice_id']) ? htmlspecialchars($_GET['invoice_id']) : 'غير معروف'; ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo&display=swap" rel="stylesheet">
    <!-- Font Awesome للأيقونات -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
            max-width: 800px;
            margin: auto;
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

        .btn-print, .btn-back {
            margin-top: 20px;
        }

        @media print {
            body {
                background-color: #ffffff;
            }
            .btn-print, .btn-back {
                display: none;
            }
            .invoice {
                box-shadow: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="invoice">
        <div class="invoice-header d-flex justify-content-between align-items-center">
            <div>
                <!-- تأكد من تحديث مسار الشعار -->
                <img src="../img/one.png" alt="شعار الشركة" class="logo">
            </div>
            <div class="text-end">
                <h1 class="invoice-title">فاتورة</h1>
                <?php
                if (isset($_GET['invoice_id'])) {
                    $invoice_id = intval($_GET['invoice_id']);
                    // جلب بيانات الفاتورة
                    $query = "SELECT * FROM invoice WHERE invoice_id = ?";
                    $stmt = $conn->prepare($query);
                    if ($stmt) {
                        $stmt->bind_param("i", $invoice_id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if ($result && $result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            ?>
                            <p><strong>رقم الفاتورة:</strong> <?php echo htmlspecialchars($row['invoice_id']); ?></p>
                            <p><strong>تاريخ الفاتورة:</strong> <?php echo htmlspecialchars($row['invoice_date']); ?></p>
                            <?php
                        } else {
                            echo "<p class='text-danger'>لم يتم العثور على بيانات للفاتورة المطلوبة.</p>";
                        }
                        $stmt->close();
                    } else {
                        echo "<p class='text-danger'>حدث خطأ في التحضير للبيانات.</p>";
                    }
                } else {
                    echo "<p class='text-danger'>لم يتم تمرير رقم الفاتورة بشكل صحيح.</p>";
                }
                ?>
            </div>
        </div>
        <?php
        if (isset($row)) {
            ?>
            <div class="invoice-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>تفاصيل المريض</h5>
                        <p><strong>رقم المريض:</strong> <?php echo htmlspecialchars($row['pat_id']); ?></p>
                        <p><strong>اسم الخدمة:</strong> <?php echo htmlspecialchars($row['name_ser']); ?></p>
                    </div>
                    <div class="col-md-6 text-end">
                        <h5>تفاصيل الدفع</h5>
                        <p><strong>تكلفة الخدمة:</strong> <?php echo number_format($row['cost_ser'], 2); ?> ر.س</p>
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
                            <td><?php echo htmlspecialchars($row['name_ser']); ?></td>
                            <td>1</td>
                            <td><?php echo number_format($row['cost_ser'], 2); ?> ر.س</td>
                            <td><?php echo number_format($row['cost_ser'], 2); ?> ر.س</td>
                        </tr>
                        <!-- يمكنك إضافة المزيد من الصفوف حسب الحاجة -->
                        <tr>
                            <td colspan="3" class="text-end"><strong>الإجمالي</strong></td>
                            <td><strong><?php echo number_format($row['cost_ser'], 2); ?> ر.س</strong></td>
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
                <button onclick="window.print()" class="btn btn-primary btn-print"><i class="fas fa-print me-2"></i>طباعة الفاتورة</button>
                <a href="box.php" class="btn btn-secondary btn-back"><i class="fas fa-arrow-left me-2"></i>العودة</a>
            </div>
            <?php
        }
        ?>
    </div>

    <!-- Bootstrap 5 JS and dependencies (optional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 Bundle includes Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- تفعيل الطباعة عند تحميل الصفحة -->
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
