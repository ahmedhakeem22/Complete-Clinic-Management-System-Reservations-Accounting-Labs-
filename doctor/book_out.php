<?php
// index.php

// يشمل رأس الصفحة وقائمة التنقل إذا كان لديك ملفات منفصلة (اختياري)
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';

// الاتصال بقاعدة البيانات (عدّل المسار حسب الحاجة)
include '../includes/db.php';

// تعريف المتغيرات الخاصة بالفلترة
$filter_date   = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
$filter_type   = isset($_GET['filter_type']) ? $_GET['filter_type'] : '';
$filter_person = isset($_GET['filter_person']) ? $_GET['filter_person'] : '';

// بناء شرط SQL بناءً على الفلاتر
$where  = [];
$params = [];
$types  = '';

if (!empty($filter_date)) {
    $where[]  = "bill_date = ?";
    $params[] = $filter_date;
    $types   .= 's';
}

if (!empty($filter_type)) {
    $where[]  = "recip_name LIKE ?";
    $params[] = '%' . $filter_type . '%';
    $types   .= 's';
}

if (!empty($filter_person)) {
    $where[]  = "recip_name LIKE ?";
    $params[] = '%' . $filter_person . '%';
    $types   .= 's';
}

$sql = "SELECT bill_id, recip_name, amount, bill_date FROM pay_bill";
if (count($where) > 0) {
    $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY bill_date DESC";

// إعداد الاستعلام باستخدام Prepared Statements
$stmt = $conn->prepare($sql);

if ($stmt) {
    if (count($params) > 0) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    die("خطأ في الاستعلام: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة المصروفات</title>
    <!-- تضمين Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- تضمين DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- تخصيص بعض الأنماط إذا لزم الأمر -->
    <style>
        body {
            padding: 20px;
        }
        .filter-form .filter-group {
            margin-bottom: 15px;
        }
        .btn-secondary {
            margin-left: 10px;
        }
        .invoice {
            font-family: 'Arial', sans-serif;
        }
        .invoice-header img {
            max-height: 100px;
        }
        .invoice-header h2 {
            margin-bottom: 0;
        }
        .invoice-details th {
            width: 30%;
        }
    </style>
</head>
<body>
<main class="container">
    <h2 class="mb-4">إدارة المصروفات</h2>
    
    <!-- نموذج إضافة أمر صرف -->
   <!-- نموذج إضافة أمر صرف -->
<div class="card mb-4">
    <div class="card-header">
        إضافة أمر صرف جديد
    </div>
    <div class="card-body">
        <!-- عند الإرسال يتم التحويل إلى الملف book_out_ach_pdf_insrt.php في نافذة جديدة -->
        <form action="book_out_ach_pdf_insrt.php" method="post" target="_blank" class="row g-3 needs-validation" novalidate>
            <div class="col-md-6">
                <label for="recip_name" class="form-label">اسم الخدمة</label>
                <input type="text" class="form-control" id="recip_name" name="recip_name" required>
                <div class="invalid-feedback">
                    يرجى إدخال اسم الخدمة.
                </div>
            </div>
            <div class="col-md-6">
                <label for="amount" class="form-label">المبلغ (ريال)</label>
                <input type="number" class="form-control" id="amount" name="amount" min="0" step="0.01" required>
                <div class="invalid-feedback">
                    يرجى إدخال مبلغ صالح.
                </div>
            </div>
            <div class="col-12">
                <button type="submit" name="add_sess" class="btn btn-primary">أمر صرف</button>
            </div>
        </form>
    </div>
</div>

    
    <!-- نموذج طباعة كل المصروفات -->
    <div class="mb-4">
        <form action="book_all_out_pdf.php" method="post" class="d-inline">
            <button type="submit" name="print_all" class="btn btn-success">طباعة كل المصروفات</button>
        </form>
    </div>
    
    <hr>
    
    <!-- نموذج الفلترة -->
    <div class="card mb-4">
        <div class="card-header">
            فلترة المصروفات
        </div>
        <div class="card-body">
            <form method="get" action="index.php" class="row g-3">
                <div class="col-md-4">
                    <label for="filter_date" class="form-label">التاريخ:</label>
                    <input type="date" class="form-control" id="filter_date" name="filter_date" value="<?php echo htmlspecialchars($filter_date); ?>">
                </div>
                <div class="col-md-4">
                    <label for="filter_type" class="form-label">نوع الخدمة:</label>
                    <input type="text" class="form-control" id="filter_type" name="filter_type" placeholder="ابحث بنوع الخدمة" value="<?php echo htmlspecialchars($filter_type); ?>">
                </div>
                <div class="col-md-4">
                    <label for="filter_person" class="form-label">الشخص:</label>
                    <input type="text" class="form-control" id="filter_person" name="filter_person" placeholder="ابحث بالشخص" value="<?php echo htmlspecialchars($filter_person); ?>">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">فلترة</button>
                    <a href="index.php" class="btn btn-secondary">إعادة تعيين</a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- جدول عرض المصروفات -->
    <div class="card">
        <div class="card-header">
            قائمة المصروفات
        </div>
        <div class="card-body">
            <table id="expensesTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>رقم الفاتورة</th>
                        <th>اسم الخدمة</th>
                        <th>المبلغ (ريال)</th>
                        <th>تاريخ الفاتورة</th>
                        <th>الإجراءات</th>
                        <th>طباعة</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['bill_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['recip_name']); ?></td>
                            <td><?php echo number_format($row['amount'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['bill_date']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $row['bill_id']; ?>" class="btn btn-sm btn-warning">تعديل</a>
                                <a href="delete.php?id=<?php echo $row['bill_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المصروف؟');">حذف</a>
                            </td>
                            <td>
                                <!-- زر الطباعة يفتح صفحة الطباعة -->
                                <a href="print_bill.php?id=<?php echo $row['bill_id']; ?>" class="btn btn-sm btn-info" target="_blank">
                                    طباعة
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- تضمين مكتبة jQuery و Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- تضمين DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // تفعيل DataTables مع دعم اللغة العربية
        $('#expensesTable').DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json"
            },
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true
        });

        // التحقق من صحة النماذج باستخدام Bootstrap
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')

            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    });
</script>

<footer class="text-center mt-5">
    <p>&copy; 2025 شركتك. جميع الحقوق محفوظة.</p>
</footer>

</body>
</html>

<?php
// إغلاق الاتصال بقاعدة البيانات
$stmt->close();
$conn->close();
?>
