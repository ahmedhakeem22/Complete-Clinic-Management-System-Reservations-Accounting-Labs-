<?php
// categories.php

// الاتصال بقاعدة البيانات
include '../includes/db.php';

// التعامل مع إضافة فئة جديدة
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name']);

    // التحقق من صحة البيانات
    if (empty($category_name)) {
        $error_message = "يرجى إدخال اسم الفئة.";
    } else {
        // التحقق مما إذا كانت الفئة موجودة بالفعل
        $check_sql = "SELECT COUNT(*) AS count FROM categories WHERE name = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $category_name);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $check_row = $check_result->fetch_assoc();
        if ($check_row['count'] > 0) {
            $error_message = "الفئة موجودة بالفعل.";
        } else {
            // إدخال الفئة الجديدة
            $insert_sql = "INSERT INTO categories (name) VALUES (?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("s", $category_name);
            if ($insert_stmt->execute()) {
                $success_message = "تم إضافة الفئة بنجاح.";
            } else {
                $error_message = "حدث خطأ أثناء إضافة الفئة: " . htmlspecialchars($insert_stmt->error);
            }
            $insert_stmt->close();
        }
        $check_stmt->close();
    }
}

// التعامل مع حذف فئة
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_category_id'])) {
    $delete_category_id = intval($_GET['delete_category_id']);

    // التحقق مما إذا كانت الفئة مرتبطة بأي مصروفات
    $check_sql = "SELECT COUNT(*) AS count FROM pay_bill WHERE category_id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $delete_category_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    $check_row = $check_result->fetch_assoc();
    if ($check_row['count'] > 0) {
        $error_message = "لا يمكن حذف هذه الفئة لأنها مرتبطة بمصروفات.";
    } else {
        // حذف الفئة
        $delete_sql = "DELETE FROM categories WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $delete_category_id);
        if ($delete_stmt->execute()) {
            $success_message = "تم حذف الفئة بنجاح.";
        } else {
            $error_message = "حدث خطأ أثناء حذف الفئة: " . htmlspecialchars($delete_stmt->error);
        }
        $delete_stmt->close();
    }
    $check_stmt->close();
}

// جلب جميع الفئات
$fetch_sql = "SELECT id, name FROM categories ORDER BY name ASC";
$fetch_stmt = $conn->prepare($fetch_sql);
$fetch_stmt->execute();
$fetch_result = $fetch_stmt->get_result();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الفئات</title>
    <!-- تضمين Bootstrap 5 CSS -->
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
    <h2 class="mb-4">إدارة الفئات</h2>
    
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
    
    <!-- نموذج إضافة فئة جديدة -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-2"></i> إضافة فئة جديدة
        </div>
        <div class="card-body">
            <form action="categories.php" method="post" class="row g-3 needs-validation" novalidate>
                <!-- اسم الفئة -->
                <div class="col-md-6">
                    <label for="category_name" class="form-label">اسم الفئة <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="category_name" name="category_name" required>
                    <div class="invalid-feedback">
                        يرجى إدخال اسم الفئة.
                    </div>
                </div>
                
                <!-- زر الإرسال -->
                <div class="col-12">
                    <button type="submit" name="add_category" class="btn btn-primary"><i class="fas fa-save me-2"></i>إضافة فئة</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- جدول عرض الفئات -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-list me-2"></i> قائمة الفئات
        </div>
        <div class="card-body">
            <table id="categoriesTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>رقم الفئة</th>
                        <th>اسم الفئة</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($category = $fetch_result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($category['id']); ?></td>
                            <td><?php echo htmlspecialchars($category['name']); ?></td>
                            <td>
                                <a href="edit_category.php?id=<?php echo $category['id']; ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit me-1"></i>تعديل</a>
                                <a href="categories.php?delete_category_id=<?php echo $category['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذه الفئة؟');"><i class="fas fa-trash-alt me-1"></i>حذف</a>
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
        $('#categoriesTable').DataTable({
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
$fetch_stmt->close();
$conn->close();
?>
