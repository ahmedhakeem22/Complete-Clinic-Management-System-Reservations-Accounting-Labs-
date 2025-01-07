<?php
// بدء التخزين المؤقت للإخراج لمنع إرسال أي بيانات قبل توليد الصفحة
ob_start();

// تضمين ملف الاتصال بقاعدة البيانات
include '../includes/db.php';

// تحديد المنطقة الزمنية
date_default_timezone_set("Asia/Aden");

// دالة لتنظيف المدخلات
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// تهيئة المتغيرات
$start_date = '';
$end_date = '';
$results = [];

// التحقق من وجود بيانات الفلترة
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
        // تنظيف المدخلات
        $start_date = test_input($_GET['start_date']);
        $end_date = test_input($_GET['end_date']);

        // التحقق من صحة التواريخ
        if (!empty($start_date) && !empty($end_date)) {
            // إعداد الاستعلام باستخدام Prepared Statements لمنع حقن SQL
            $stmt = $conn->prepare("SELECT * FROM Pay_bill WHERE date BETWEEN ? AND ?");
            $stmt->bind_param("ss", $start_date, $end_date);
            $stmt->execute();
            $result = $stmt->get_result();

            // جلب النتائج
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $results[] = $row;
                }
            } else {
                $message = "لا توجد بيانات مطابقة للتواريخ المحددة.";
            }

            $stmt->close();
        } else {
            $message = "يرجى تحديد تاريخ البداية وتاريخ النهاية.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تصفية بيانات Pay Bill حسب التاريخ</title>
    <!-- تضمين Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- تضمين أيقونات Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- تضمين jQuery (اختياري إذا كنت ستستخدم AJAX) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- تضمين Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            margin-bottom: 50px;
        }
        .table thead th {
            background-color: #6f42c1;
            color: white;
        }
        .btn-custom {
            background-color: #6f42c1;
            color: white;
        }
        .btn-custom:hover {
            background-color: #5a32a1;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="mb-4 text-center">تصفية بيانات Pay Bill حسب التاريخ</h2>

    <!-- نموذج الفلترة -->
    <form method="GET" action="filter_pay_bill.php" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="start_date" class="form-label">تاريخ البداية:</label>
            <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $start_date; ?>" required>
        </div>
        <div class="col-md-4">
            <label for="end_date" class="form-label">تاريخ النهاية:</label>
            <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $end_date; ?>" required>
        </div>
        <div class="col-md-4 align-self-end">
            <button type="submit" class="btn btn-custom w-100">
                <i class="bi bi-search"></i> تصفية
            </button>
        </div>
    </form>

    <!-- عرض الرسائل -->
    <?php if(isset($message)) { ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?php echo $message; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
    <?php } ?>

    <!-- عرض النتائج في جدول -->
    <?php if(!empty($results)) { ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Pay_bill ID</th>
                        <th>Name Service</th>
                        <th>Cost Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($results as $row) { ?>
                        <tr>
                            <td><?php echo $row['bill_id']; ?></td>
                            <td><?php echo $row['recip_name']; ?></td>
                            <td><?php echo number_format($row['amount'], 2); ?></td>
                            <td><?php echo date("Y-m-d", strtotime($row['date'])); ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2" class="text-end"><strong>المجموع الكلي:</strong></td>
                        <td colspan="2"><strong>
                            <?php 
                                $total = array_sum(array_column($results, 'amount'));
                                echo number_format($total, 2); 
                            ?>
                        </strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php } ?>

    <!-- زر توليد تقرير PDF (اختياري) -->
    <?php if(!empty($results)) { ?>
        <div class="text-end mt-3">
            <a href="generate_filtered_pdf.php?start_date=<?php echo $start_date; ?>&end_date=<?php echo $end_date; ?>" class="btn btn-primary">
                <i class="bi bi-printer"></i> توليد تقرير PDF
            </a>
        </div>
    <?php } ?>
</div>

</body>
</html>
