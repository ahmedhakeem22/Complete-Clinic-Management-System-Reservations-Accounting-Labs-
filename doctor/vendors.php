<?php
// vendors.php

// يشمل رأس الصفحة وقائمة التنقل إذا كان لديك ملفات منفصلة (اختياري)
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';

// الاتصال بقاعدة البيانات (عدّل المسار حسب الحاجة)
include '../includes/db.php';

// التعامل مع إضافة مورد جديد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_vendor'])) {
    $vendor_name = trim($_POST['vendor_name']);
    $contact_info = trim($_POST['contact_info']);
    
    if (!empty($vendor_name)) {
        $sql_insert_vendor = "INSERT INTO vendors (vendor_name, contact_info) VALUES (?, ?)";
        $stmt_insert_vendor = $conn->prepare($sql_insert_vendor);
        $stmt_insert_vendor->bind_param("ss", $vendor_name, $contact_info);
        if ($stmt_insert_vendor->execute()) {
            $success_message = "تم إضافة المورد بنجاح.";
        } else {
            $error_message = "حدث خطأ أثناء إضافة المورد: " . htmlspecialchars($stmt_insert_vendor->error);
        }
        $stmt_insert_vendor->close();
    } else {
        $error_message = "يرجى إدخال اسم المورد.";
    }
}

// التعامل مع حذف مورد
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_vendor_id'])) {
    $delete_vendor_id = intval($_GET['delete_vendor_id']);
    // يجب التحقق مما إذا كان المورد مرتبط بأي مصروف قبل الحذف
    $sql_check = "SELECT COUNT(*) AS count FROM pay_bill WHERE vendor_id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $delete_vendor_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();
    if ($row_check['count'] > 0) {
        $error_message = "لا يمكن حذف هذا المورد لأنه مرتبط بمصروفات.";
    } else {
        $sql_delete = "DELETE FROM vendors WHERE vendor_id = ?";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bind_param("i", $delete_vendor_id);
        if ($stmt_delete->execute()) {
            $success_message = "تم حذف المورد بنجاح.";
        } else {
            $error_message = "حدث خطأ أثناء حذف المورد: " . htmlspecialchars($stmt_delete->error);
        }
        $stmt_delete->close();
    }
    $stmt_check->close();
}

// جلب جميع الموردين
$sql_vendors = "SELECT vendor_id, vendor_name, contact_info FROM vendors ORDER BY vendor_name ASC";
$stmt_vendors = $conn->prepare($sql_vendors);
$stmt_vendors->execute();
$result_vendors = $stmt_vendors->get_result();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة الموردين</title>
    <!-- تضمين Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- تضمين Font Awesome للأيقونات -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- تضمين DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- تخصيص بعض الأنماط إذا لزم الأمر -->
    <style>
        body {
            padding: 20px;
            direction: rtl;
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
        }
        .card-header {
            background-color: #343a40;
            color: #fff;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .invalid-feedback {
            display: none;
        }
        .was-validated .form-control:invalid ~ .invalid-feedback,
        .was-validated .form-select:invalid ~ .invalid-feedback {
            display: block;
        }
    </style>
</head>
<body>
<main class="container">
    <h2 class="mb-4">إدارة الموردين</h2>
    
    <!-- عرض رسائل النجاح أو الخطأ -->
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($success_message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($error_message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
    <?php endif; ?>
    
    <!-- نموذج إضافة مورد جديد -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-2"></i> إضافة مورد جديد
        </div>
        <div class="card-body">
            <form action="vendors.php" method="post" class="row g-3 needs-validation" novalidate>
                <!-- اسم المورد -->
                <div class="col-md-6">
                    <label for="vendor_name" class="form-label">اسم المورد <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="vendor_name" name="vendor_name" required>
                    <div class="invalid-feedback">
                        يرجى إدخال اسم المورد.
                    </div>
                </div>
                
                <!-- معلومات الاتصال -->
                <div class="col-md-6">
                    <label for="contact_info" class="form-label">معلومات الاتصال</label>
                    <input type="text" class="form-control" id="contact_info" name="contact_info" placeholder="أدخل معلومات الاتصال">
                </div>
                
                <!-- زر الإرسال -->
                <div class="col-12">
                    <button type="submit" name="add_vendor" class="btn btn-primary"><i class="fas fa-save me-2"></i>إضافة مورد</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- جدول عرض الموردين -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-list me-2"></i> قائمة الموردين
        </div>
        <div class="card-body">
            <table id="vendorsTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>رقم المورد</th>
                        <th>اسم المورد</th>
                        <th>معلومات الاتصال</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($vendor = $result_vendors->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($vendor['vendor_id']); ?></td>
                            <td><?php echo htmlspecialchars($vendor['vendor_name']); ?></td>
                            <td><?php echo htmlspecialchars($vendor['contact_info']); ?></td>
                            <td>
                                <a href="edit_vendor.php?vendor_id=<?php echo $vendor['vendor_id']; ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit me-1"></i>تعديل</a>
                                <a href="vendors.php?delete_vendor_id=<?php echo $vendor['vendor_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المورد؟');"><i class="fas fa-trash-alt me-1"></i>حذف</a>
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
        $('#vendorsTable').DataTable({
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
$stmt_vendors->close();
$conn->close();
?>
