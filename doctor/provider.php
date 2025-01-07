<?php 
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';
include '../includes/db.php';
?> 

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة وعرض سندات القبض</title>
    <!-- تضمين Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- تضمين DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- تخصيص بعض الأنماط إذا لزم الأمر -->
    <style>
        body {
            padding: 20px;
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }
        .submit-btn {
            width: 100%;
        }
        .filter-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }
        .table-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<main class="container my-5">
    <!-- نموذج إضافة سند قبض -->
    <div class="form-container">
        <h2 class="mb-4">إضافة سند قبض مقابل دعم مركز</h2>
        <form action="pro_pdf.php" method="post" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="name_pro" class="form-label">اسم الداعم:</label>
                <input type="text" class="form-control" id="name_pro" name="name_pro" required>
                <div class="invalid-feedback">
                    يرجى إدخال اسم الداعم.
                </div>
            </div>
            <div class="mb-3">
                <label for="cost_ser" class="form-label">المبلغ (ريال):</label>
                <input type="number" class="form-control" id="cost_ser" name="cost_ser" min="0" step="0.01" required>
                <div class="invalid-feedback">
                    يرجى إدخال مبلغ صالح.
                </div>
            </div>
            <div class="mb-3">
                <label for="date_pro" class="form-label">تاريخ السند:</label>
                <input type="date" class="form-control" id="date_pro" name="date_pro" required>
                <div class="invalid-feedback">
                    يرجى إدخال تاريخ السند.
                </div>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">ملاحظات:</label>
                <textarea class="form-control" id="note" name="note" rows="3"></textarea>
            </div>
            <button type="submit" id="add" name="add_sess" class="btn btn-primary submit-btn">حفظ</button>
        </form>
    </div>

    <!-- نموذج الفلترة -->
    <div class="filter-container">
        <h4 class="mb-3">فلترة السندات</h4>
        <form method="get" action="add_receipt.php" class="row g-3">
            <div class="col-md-4">
                <label for="filter_date" class="form-label">تاريخ السند:</label>
                <input type="date" class="form-control" id="filter_date" name="filter_date" value="<?php echo isset($_GET['filter_date']) ? htmlspecialchars($_GET['filter_date']) : ''; ?>">
            </div>
            <div class="col-md-4">
                <label for="filter_provider" class="form-label">اسم الداعم:</label>
                <input type="text" class="form-control" id="filter_provider" name="filter_provider" placeholder="ابحث باسم الداعم" value="<?php echo isset($_GET['filter_provider']) ? htmlspecialchars($_GET['filter_provider']) : ''; ?>">
            </div>
            <div class="col-md-4">
                <label for="filter_amount" class="form-label">المبلغ:</label>
                <input type="number" class="form-control" id="filter_amount" name="filter_amount" min="0" step="0.01" placeholder="ابحث بالمبلغ" value="<?php echo isset($_GET['filter_amount']) ? htmlspecialchars($_GET['filter_amount']) : ''; ?>">
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">فلترة</button>
                <a href="add_receipt.php" class="btn btn-secondary">إعادة تعيين</a>
            </div>
        </form>
    </div>

    <!-- جدول عرض السندات -->
    <div class="table-container">
        <h4 class="mb-3">السندات السابقة</h4>
        <?php
        // تعريف المتغيرات الخاصة بالفلترة
        $filter_date    = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
        $filter_provider = isset($_GET['filter_provider']) ? $_GET['filter_provider'] : '';
        $filter_amount  = isset($_GET['filter_amount']) ? $_GET['filter_amount'] : '';

        // بناء شرط SQL بناءً على الفلاتر
        $where  = [];
        $params = [];
        $types  = '';

        if (!empty($filter_date)) {
            $where[]  = "date_pro = ?";
            $params[] = $filter_date;
            $types   .= 's';
        }

        if (!empty($filter_provider)) {
            $where[]  = "name_pro LIKE ?";
            $params[] = '%' . $filter_provider . '%';
            $types   .= 's';
        }

        if (!empty($filter_amount)) {
            $where[]  = "cost_ser = ?";
            $params[] = $filter_amount;
            $types   .= 'd';
        }

        $sql = "SELECT id, name_pro, cost_ser, date_pro, note FROM provider";
        if (count($where) > 0) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        $sql .= " ORDER BY date_pro DESC";

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

        <table id="receiptsTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>اسم الداعم</th>
                    <th>المبلغ (ريال)</th>
                    <th>تاريخ السند</th>
                    <th>ملاحظات</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result->num_rows > 0):
                    while ($row = $result->fetch_assoc()): 
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name_pro']); ?></td>
                        <td><?php echo number_format($row['cost_ser'], 2); ?></td>
                        <td><?php echo htmlspecialchars($row['date_pro']); ?></td>
                        <td><?php echo htmlspecialchars($row['note']); ?></td>
                        <td>
                            <a href="edit_receipt.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">تعديل</a>
                            <a href="delete_receipt.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا السند؟');">حذف</a>
                            <a href="print_receipt.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info" target="_blank">طباعة</a>
                        </td>
                    </tr>
                <?php 
                    endwhile;
                else:
                ?>
                    <tr>
                        <td colspan="6" class="text-center">لا توجد سندات لعرضها.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<footer class="text-center mt-5">
    <p>&copy; 2025 شركتك. جميع الحقوق محفوظة.</p>
</footer>

<!-- تضمين مكتبة Bootstrap JS و Popper.js -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- تضمين DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // تفعيل DataTables مع دعم اللغة العربية
        $('#receiptsTable').DataTable({
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

</body>
</html>

<?php
// إغلاق الاتصال بقاعدة البيانات
$stmt->close();
$conn->close();
?>
