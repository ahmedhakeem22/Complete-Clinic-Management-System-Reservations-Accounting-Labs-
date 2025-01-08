<?php
session_start();
// إخفاء الأخطاء التحذيرية (اختياري)
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
ini_set('display_errors', '0');
include 'includes/templates/header.php';  
include 'includes/templates/navbar.php';

// تضمين ملف الاتصال بقاعدة البيانات
require_once '../includes/db.php';

// القيم الافتراضية للصفحة وعدد النتائج في كل صفحة
$limit = 10; // عدد النتائج في كل صفحة
$page  = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $limit;

// تجهيز عبارات WHERE ديناميكيًا
$whereClauses = [];
$params       = [];
$types        = ''; // سنبنيه تدريجيًا حسب أنواع البيانات

// الاستعلام الأساسي للعدّ الكلّي
$sqlCount = "SELECT COUNT(*) as total FROM invoice WHERE 1=1";

// الاستعلام الأساسي لجلب البيانات
$sqlData  = "SELECT * FROM invoice WHERE 1=1";

// إذا تم إرسال فلترة
if (isset($_GET['filter'])) {
    // نوع الخدمة
    if (!empty($_GET['service_type'])) {
        $sqlCount .= " AND name_ser = ?";
        $sqlData  .= " AND name_ser = ?";
        $params[]  = $_GET['service_type'];
        $types    .= 's';
    }

    // تاريخ البداية
    if (!empty($_GET['date_from'])) {
        $sqlCount .= " AND invoice_date >= ?";
        $sqlData  .= " AND invoice_date >= ?";
        $params[]  = $_GET['date_from'];
        $types    .= 's';
    }

    // تاريخ النهاية
    if (!empty($_GET['date_to'])) {
        $sqlCount .= " AND invoice_date <= ?";
        $sqlData  .= " AND invoice_date <= ?";
        $params[]  = $_GET['date_to'];
        $types    .= 's';
    }

    // رقم المريض
    if (!empty($_GET['pat_id'])) {
        $sqlCount .= " AND pat_id = ?";
        $sqlData  .= " AND pat_id = ?";
        $params[]  = $_GET['pat_id'];
        $types    .= 's';
    }
}

// نفّذ أولاً استعلام العدّ للحصول على العدد الكلي
$stmtCount = $conn->prepare($sqlCount);
if (!empty($params)) {
    $stmtCount->bind_param($types, ...$params);
}
$stmtCount->execute();
$resultCount = $stmtCount->get_result();
$rowCount    = $resultCount->fetch_assoc();
$totalRows   = $rowCount['total'] ?? 0;
$totalPages  = ceil($totalRows / $limit);

// تجهيز استعلام البيانات مع LIMIT و OFFSET
$sqlData .= " ORDER BY invoice_date DESC"; // ترتيب اختياري حسب تاريخ الفاتورة (يمكن تغييره)
$sqlData .= " LIMIT ? OFFSET ?";

// نظراً لأننا سنضيف باراميترين إضافيين (limit, offset) يجب توسيع $types
// هما من نوع integer (i, i)
$paramsData = $params; // انسخ المعاملات السابقة
$typesData  = $types . "ii"; // أضف نوعين رقميين

$paramsData[] = $limit;
$paramsData[] = $offset;

// تحضير وتنفيذ استعلام البيانات
$stmtData = $conn->prepare($sqlData);
$stmtData->bind_param($typesData, ...$paramsData);
$stmtData->execute();
$result = $stmtData->get_result();

// حساب المبالغ الإجمالية والمصروفات
// المبلغ الإجمالي في الصندوق
$sqlTotalInvoices = "SELECT SUM(cost_ser) AS total_invoices FROM invoice WHERE 1=1";

if (isset($_GET['filter'])) {
    if (!empty($_GET['service_type'])) {
        $sqlTotalInvoices .= " AND name_ser = ?";
    }
    if (!empty($_GET['date_from'])) {
        $sqlTotalInvoices .= " AND invoice_date >= ?";
    }
    if (!empty($_GET['date_to'])) {
        $sqlTotalInvoices .= " AND invoice_date <= ?";
    }
    if (!empty($_GET['pat_id'])) {
        $sqlTotalInvoices .= " AND pat_id = ?";
    }
}

$stmtTotalInvoices = $conn->prepare($sqlTotalInvoices);
if (!empty($params)) {
    $stmtTotalInvoices->bind_param($types, ...$params);
}
$stmtTotalInvoices->execute();
$resultTotalInvoices = $stmtTotalInvoices->get_result();
$rowTotalInvoices = $resultTotalInvoices->fetch_assoc();
$totalInvoices = $rowTotalInvoices['total_invoices'] ?? 0;

// مبلغ المصروفات
$sqlTotalExpenses = "SELECT SUM(amount) AS total_expenses FROM pay_bill WHERE 1=1";

$expenseParams = [];
$expenseTypes = '';

if (!empty($_GET['date_from'])) {
    $sqlTotalExpenses .= " AND bill_date >= ?";
    $expenseParams[] = $_GET['date_from'];
    $expenseTypes .= 's';
}

if (!empty($_GET['date_to'])) {
    $sqlTotalExpenses .= " AND bill_date <= ?";
    $expenseParams[] = $_GET['date_to'];
    $expenseTypes .= 's';
}

$stmtTotalExpenses = $conn->prepare($sqlTotalExpenses);
if (!empty($expenseParams)) {
    $stmtTotalExpenses->bind_param($expenseTypes, ...$expenseParams);
}
$stmtTotalExpenses->execute();
$resultTotalExpenses = $stmtTotalExpenses->get_result();
$rowTotalExpenses = $resultTotalExpenses->fetch_assoc();
$totalExpenses = $rowTotalExpenses['total_expenses'] ?? 0;

// المبلغ الصافي
$netAmount = $totalInvoices - $totalExpenses;
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الصندوق - إدارة الفواتير</title>
    <!-- تحديث Bootstrap إلى الإصدار 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- إضافة Font Awesome للأيقونات -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- استخدام خطوط Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            direction: rtl;
            background-color: #f0f4f8;
            font-family: 'Cairo', sans-serif;
        }
        .navbar {
            margin-bottom: 30px;
            background: #2C3E50;
        }
        .navbar-brand {
            font-weight: 600;
            color: #ecf0f1 !important;
        }
        .filter-box {
            margin: 20px 0;
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .filter-box h4 {
            margin-bottom: 25px;
            color: #2C3E50;
        }
        .table thead th {
            background-color: #34495E;
            color: #ecf0f1;
            vertical-align: middle;
            text-align: center;
        }
        .table tbody td {
            vertical-align: middle;
            text-align: center;
        }
        .btn-primary {
            background-color: #2980B9;
            border-color: #2980B9;
        }
        .btn-primary:hover {
            background-color: #1F618D;
            border-color: #1A5276;
        }
        .btn-secondary {
            background-color: #95A5A6;
            border-color: #95A5A6;
        }
        .btn-secondary:hover {
            background-color: #7F8C8D;
            border-color: #707B7C;
        }
        .btn-success {
            background-color: #27AE60;
            border-color: #27AE60;
        }
        .btn-success:hover {
            background-color: #1E8449;
            border-color: #196F3D;
        }
        .btn-info {
            background-color: #5DADE2;
            border-color: #5DADE2;
        }
        .btn-info:hover {
            background-color: #3498DB;
            border-color: #2980B9;
        }
        .btn-warning {
            background-color: #F39C12;
            border-color: #F39C12;
        }
        .btn-warning:hover {
            background-color: #D68910;
            border-color: #B9770E;
        }
        .modal-content {
            border-radius: 15px;
        }
        .pagination .page-link {
            color: #2C3E50;
        }
        .pagination .page-item.active .page-link {
            background-color: #2C3E50;
            border-color: #2C3E50;
            color: #ecf0f1;
        }
        .pagination .page-item.disabled .page-link {
            color: #95A5A6;
        }
        /* إضافة تأثيرات عند المرور بالفأرة */
        .table-hover tbody tr:hover {
            background-color: #D6DBDF;
            transition: background-color 0.3s ease;
        }
        /* تخصيص زر طباعة النتائج */
        .btn-print {
            background-color: #8E44AD;
            border-color: #8E44AD;
            color: #ffffff;
        }
        .btn-print:hover {
            background-color: #732D91;
            border-color: #5E3370;
            color: #ffffff;
        }
        /* تخصيص زر إضافة مصروفات */
        .btn-add-expense {
            background-color: #27AE60;
            border-color: #27AE60;
            color: #ffffff;
        }
        .btn-add-expense:hover {
            background-color: #1E8449;
            border-color: #196F3D;
            color: #ffffff;
        }
    </style>
</head>
<body>

<!-- نافبار علوية محسنة -->
<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <i class="fas fa-receipt me-2"></i> الصندوق - إدارة الفواتير
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="تبديل التنقل">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<div class="container">

    <!-- عنوان الصفحة -->
    <div class="text-center mb-5">
        <h1 class="display-4">إدارة الفواتير</h1>
        <p class="lead text-muted">تصفح الفواتير الخاصة بالمرضى مع خيارات البحث والفلترة والطباعة.</p>
    </div>

    <!-- فورم الفلترة -->
    <div class="filter-box">
        <h4><i class="fas fa-filter me-2"></i> فلترة نتائج الفواتير</h4>
        <form method="GET" action="" class="row g-3">
            <div class="col-md-3">
                <label for="service_type" class="form-label">نوع الخدمة</label>
                <select name="service_type" id="service_type" class="form-select">
                    <option value="">كل الأنواع</option>
                    <option value="فحص نفسي" <?php if(@$_GET['service_type'] == 'فحص نفسي') echo 'selected';?>>فحص نفسي</option>
                    <option value="Blood Tests" <?php if(@$_GET['service_type'] == 'فحص دم') echo 'selected';?>>فحص دم</option>
                    <option value="حجز جلسة" <?php if(@$_GET['service_type'] == 'حجز جلسة') echo 'selected';?>>حجز جلسة</option>
                </select>
            </div>

            <div class="col-md-3">
                <label for="date_from" class="form-label">من تاريخ</label>
                <input type="date" name="date_from" id="date_from" class="form-control"
                       value="<?php echo @$_GET['date_from']; ?>" placeholder="من تاريخ">
            </div>

            <div class="col-md-3">
                <label for="date_to" class="form-label">إلى تاريخ</label>
                <input type="date" name="date_to" id="date_to" class="form-control"
                       value="<?php echo @$_GET['date_to']; ?>" placeholder="إلى تاريخ">
            </div>

            <div class="col-md-3">
                <label for="pat_id" class="form-label">رقم المريض</label>
                <input type="number" name="pat_id" id="pat_id" class="form-control"
                       value="<?php echo @$_GET['pat_id']; ?>" placeholder="رقم المريض">
            </div>

            <div class="col-12 d-flex justify-content-start gap-2">
    <button type="submit" name="filter" class="btn btn-primary"><i class="fas fa-search me-2"></i>بحث</button>
    <a href="box.php" class="btn btn-secondary"><i class="fas fa-times me-2"></i>إزالة الفلاتر</a>
    <!-- زر إضافة مصروفات -->
    <a href="book_out.php" class="btn btn-add-expense"><i class="fas fa-plus me-2"></i>إضافة مصروفات</a>
</div>

        </form>
    </div>

    <!-- قسم عرض المبالغ المالية -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">المبلغ الإجمالي في الصندوق</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo number_format($totalInvoices, 2); ?> ر.ي</h5>
                    <!-- أو يمكن استخدام "ريال يمني" بدلاً من "ر.ي" -->
                    <!-- <h5 class="card-title"><?php echo number_format($totalInvoices, 2); ?> ريال يمني</h5> -->
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header">مبلغ المصروفات</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo number_format($totalExpenses, 2); ?> ر.ي</h5>
                    <!-- <h5 class="card-title"><?php echo number_format($totalExpenses, 2); ?> ريال يمني</h5> -->
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">المبلغ الصافي</div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo number_format($netAmount, 2); ?> ر.ي</h5>
                    <!-- <h5 class="card-title"><?php echo number_format($netAmount, 2); ?> ريال يمني</h5> -->
                </div>
            </div>
        </div>
    </div>

    <!-- زر طباعة النتائج الكاملة (مع الفلاتر الحالية) -->
    <div class="text-end mb-4">
        <a href="print_all_invoices.php?<?php echo http_build_query($_GET); ?>" target="_blank" class="btn btn-print me-3">
            <i class="fas fa-print me-2"></i>طباعة النتائج الحالية
        </a>
        <!-- زر إضافة مصروفات في حالة الرغبة بإضافة زر آخر بجانب زر الطباعة -->
        <!--
        <a href="book_out.php" class="btn btn-add-expense">
            <i class="fas fa-plus me-2"></i>إضافة مصروفات
        </a>
        -->
    </div>

    <!-- جدول عرض النتائج -->
    <div class="table-responsive shadow-sm">
    <table class="table table-bordered table-hover table-striped bg-white">
        <thead>
            <tr>
                <th>رقم الفاتورة</th>
                <th>رقم المريض</th>
                <th>اسم الخدمة</th>
                <th>تكلفة الخدمة</th>
                <th>تاريخ الفاتورة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['invoice_id']); ?></td>
                    <td><?php echo htmlspecialchars($row['pat_id']); ?></td>
                    <td>
                        <?php 
                        // التحقق من اسم الخدمة وتغيير القيمة عند الطباعة
                        echo htmlspecialchars($row['name_ser'] === 'Blood Tests' ? 'فحص دم' : $row['name_ser']); 
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars(number_format($row['cost_ser'], 2)); ?> ر.ي</td>
                    <td><?php echo htmlspecialchars($row['invoice_date']); ?></td>
                    <td>
                        <!-- زر فتح تفاصيل الفاتورة في نافذة منبثقة (معاينة) -->
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                data-bs-target="#invoiceModal"
                                data-invoice="<?php echo htmlspecialchars($row['invoice_id']); ?>">
                            <i class="fas fa-eye me-1"></i>معاينة
                        </button>

                        <!-- زر طباعة فاتورة محددة -->
                        <a href="print_single_invoice.php?invoice_id=<?php echo urlencode($row['invoice_id']); ?>"
                           target="_blank" class="btn btn-warning btn-sm">
                            <i class="fas fa-print me-1"></i>طباعة
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">لا توجد نتائج مطابقة.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>


    <!-- شريط الترقيم (Pagination) -->
    <?php if ($totalRows > 0): ?>
    <nav aria-label="pagination" class="mt-4">
      <ul class="pagination justify-content-center">
        <!-- زر الصفحة السابقة -->
        <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
          <a class="page-link" href="?<?php 
            // نحتفظ ببقية باراميترات GET عدا page
            $queryString = $_GET; 
            $queryString['page'] = $page - 1; 
            echo htmlspecialchars(http_build_query($queryString)); 
          ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span> السابقة
          </a>
        </li>

        <!-- أرقام الصفحات -->
        <?php 
            // لتجنب عرض عدد كبير من الصفحات، يمكن تحديد نطاق معين
            $maxLinks = 5;
            $start = max(1, $page - floor($maxLinks / 2));
            $end = min($totalPages, $start + $maxLinks - 1);
            if ($end - $start + 1 < $maxLinks) {
                $start = max(1, $end - $maxLinks + 1);
            }
            for($i = $start; $i <= $end; $i++): 
        ?>
        <li class="page-item <?php if($i == $page) echo 'active'; ?>">
          <a class="page-link" href="?<?php 
            $queryString['page'] = $i; 
            echo htmlspecialchars(http_build_query($queryString)); 
          ?>">
            <?php echo $i; ?>
          </a>
        </li>
        <?php endfor; ?>

        <!-- زر الصفحة التالية -->
        <li class="page-item <?php if($page >= $totalPages) echo 'disabled'; ?>">
          <a class="page-link" href="?<?php 
            $queryString['page'] = $page + 1; 
            echo htmlspecialchars(http_build_query($queryString)); 
          ?>" aria-label="Next">
            التالية <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
    <?php endif; ?>

</div>

<!-- نافذة منبثقة لعرض تفاصيل الفاتورة -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">تفاصيل الفاتورة</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
      </div>
      <div class="modal-body">
        <!-- سيتم ملء التفاصيل بواسطة AJAX / جافاسكربت ديناميكيًا -->
        <div id="invoiceDetails">... جاري التحميل ...</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
      </div>
    </div>
  </div>
</div>

<!-- ملفات جافاسكربت المطلوبة لعمل Bootstrap والنافذة المنبثقة -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- تحديث Bootstrap 5 لا يتطلب Popper بشكل منفصل -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function(){
    // عند فتح النافذة المنبثقة للفاتورة
    $('#invoiceModal').on('show.bs.modal', function (event) {
        var button    = $(event.relatedTarget);
        var invoiceId = button.data('invoice'); // رقم الفاتورة

        var modal = $(this);
        // تفريغ المحتوى السابق أو وضع رسالة انتظار
        modal.find('#invoiceDetails').html('<div class="text-center my-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">... جاري التحميل ...</span></div></div>');

        // طلب AJAX لجلب تفاصيل الفاتورة
        $.ajax({
            url: 'invoice_details_ajax.php', // صفحة تجلب بيانات الفاتورة (JSON أو HTML)
            type: 'GET',
            data: { invoice_id: invoiceId },
            success: function(data) {
                // عرض البيانات في النافذة
                modal.find('#invoiceDetails').html(data);
            },
            error: function() {
                modal.find('#invoiceDetails').html('<p class="text-danger">حدث خطأ في جلب بيانات الفاتورة.</p>');
            }
        });
    });
});
</script>

</body>
</html>
