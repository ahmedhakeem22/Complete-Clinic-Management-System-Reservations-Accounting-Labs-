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
    <!-- تضمين Bootstrap RTL CSS من شبكة CDN مع استخدام Bootswatch (مثلاً قالب "Lux") -->
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.0/dist/lux/bootstrap.rtl.min.css" rel="stylesheet">
    <!-- تضمين DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- تضمين خط "Cairo" من Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600&display=swap">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #edf2f7;
        }

        .card {
            margin-bottom: 30px;
            border: none;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .card-body {
            color: #4a5568;
            font-size: 1rem;
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
        }

        .btn-custom {
            padding: 10px 20px;
        }

        .table-container {
            overflow-x: auto;
        }

        .btn-custom:hover {
            background-color: #3182ce;
            color: #fff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e3e6f0;
        }
    </style>
</head>

<body>

    <main class="container my-5">
        <!-- نموذج إضافة سند قبض داخل بطاقة -->
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">إضافة سند قبض مقابل دعم مركز</h3>
            </div>
            <div class="card-body">
                <form action="pro_pdf.php" method="post" class="needs-validation" novalidate target="_blank">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name_pro" class="form-label">اسم الداعم:</label>
                            <input type="text" class="form-control" id="name_pro" name="name_pro" required>
                            <div class="invalid-feedback">
                                يرجى إدخال اسم الداعم.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="cost_ser" class="form-label">المبلغ (ريال):</label>
                            <input type="number" class="form-control" id="cost_ser" name="cost_ser" min="0" step="0.01"
                                required>
                            <div class="invalid-feedback">
                                يرجى إدخال مبلغ صالح.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="date_pro" class="form-label">تاريخ السند:</label>
                            <input type="date" class="form-control" id="date_pro" name="date_pro" required>
                            <div class="invalid-feedback">
                                يرجى إدخال تاريخ السند.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="note" class="form-label">ملاحظات:</label>
                            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                        </div>
                    </div>
                    <button type="submit" id="add" name="add_sess" class="btn btn-primary btn-custom w-100">حفظ</button>
                </form>
            </div>
        </div>

        <!-- نموذج الفلترة داخل بطاقة -->
        <div class="card">
            <div class="card-header">
                <h4 class="text-center">فلترة السندات</h4>
            </div>
            <div class="card-body">
                <form method="get" action="provider.php" class="row g-3">


                    <div class="col-md-4">
                        <label for="filter_date" class="form-label">تاريخ السند:</label>
                        <input type="date" class="form-control" id="filter_date" name="filter_date"
                            value="<?php echo isset($_GET['filter_date']) ? htmlspecialchars($_GET['filter_date']) : ''; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="filter_amount" class="form-label">المبلغ:</label>
                        <input type="number" class="form-control" id="filter_amount" name="filter_amount" min="0"
                            step="0.01" placeholder="ابحث بالمبلغ"
                            value="<?php echo isset($_GET['filter_amount']) ? htmlspecialchars($_GET['filter_amount']) : ''; ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="filter_provider" class="form-label">اسم الداعم:</label>
                        <input type="text" class="form-control" id="filter_provider" name="filter_provider"
                            placeholder="ابحث باسم الداعم"
                            value="<?php echo isset($_GET['filter_provider']) ? htmlspecialchars($_GET['filter_provider']) : ''; ?>">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-custom">فلترة</button>
                        <a href="provider.php" class="btn btn-secondary btn-custom">إعادة تعيين</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- جدول عرض السندات داخل بطاقة -->
        <div class="card">
            <div class="card-header">
                <h4 class="text-center">السندات السابقة</h4>
            </div>
            <div class="card-body table-container">
                <?php
                // تعريف المتغيرات الخاصة بالفلترة
                $filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
                $filter_provider = isset($_GET['filter_provider']) ? $_GET['filter_provider'] : '';
                $filter_amount = isset($_GET['filter_amount']) ? $_GET['filter_amount'] : '';

                // بناء شرط SQL بناءً على الفلاتر
                $where = [];
                $params = [];
                $types = '';

                if (!empty($filter_date)) {
                    $where[] = "date_pro = ?";
                    $params[] = $filter_date;
                    $types .= 's';
                }

                if (!empty($filter_provider)) {
                    $where[] = "name_pro LIKE ?";
                    $params[] = '%' . $filter_provider . '%';
                    $types .= 's';
                }

                if (!empty($filter_amount)) {
                    $where[] = "cost_ser = ?";
                    $params[] = $filter_amount;
                    $types .= 'd';
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

                <table id="receiptsTable" class="table table-striped table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>الإجراءات</th>
                            <th>ملاحظات</th>
                            <th>تاريخ السند</th>
                            <th>المبلغ (ريال)</th>
                            <th>اسم الداعم</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0):
                            while ($row = $result->fetch_assoc()):
                                ?>
                                <tr>
                                    <td>
                                        <a href="edit_receipt.php?id=<?php echo $row['id']; ?>"
                                            class="btn btn-warning btn-sm btn-custom">تعديل</a>
                                        <a href="delete_receipt.php?id=<?php echo $row['id']; ?>"
                                            class="btn btn-danger btn-sm btn-custom"
                                            onclick="return confirm('هل أنت متأكد من حذف هذا السند؟');">حذف</a>
                                        <a href="print_receipt.php?id=<?php echo $row['id']; ?>"
                                            class="btn btn-info btn-sm btn-custom" target="_blank">طباعة</a>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['note']); ?></td>
                                    <td><?php echo htmlspecialchars($row['date_pro']); ?></td>
                                    <td><?php echo number_format($row['cost_ser'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($row['name_pro']); ?></td>
                                    <td><?php echo htmlspecialchars($row['id']); ?></td>
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
        </div>
    </main>

    <footer class="text-center py-4">
        <!-- <p class="text-center">&copy; 2025 شركتك. جميع الحقوق محفوظة.</p> -->
    </footer>

    <!-- تضمين مكتبة jQuery، Bootstrap JS و DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
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