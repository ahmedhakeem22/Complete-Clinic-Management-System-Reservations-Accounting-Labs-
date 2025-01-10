<?php
// employees.php

// الاتصال بقاعدة البيانات
include '../includes/db.php';

// التعامل مع إضافة موظف جديد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_employee'])) {
    // جلب وتطهير البيانات المدخلة
    $name = trim($_POST['name'] ?? '');
    $position = trim($_POST['position'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $date_hired = trim($_POST['date_hired'] ?? '');

    // التحقق من صحة البيانات
    $errors = [];

    if (empty($name)) {
        $errors[] = "يرجى إدخال اسم الموظف.";
    }

    if (empty($position)) {
        $errors[] = "يرجى إدخال منصب الموظف.";
    }

    if (empty($email)) {
        $errors[] = "يرجى إدخال البريد الإلكتروني للموظف.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "يرجى إدخال بريد إلكتروني صالح.";
    }

    if (empty($date_hired)) {
        $errors[] = "يرجى اختيار تاريخ التعيين.";
    }

    // التحقق مما إذا كان البريد الإلكتروني موجودًا بالفعل
    if (empty($errors)) {
        $check_sql = "SELECT COUNT(*) AS count FROM employees WHERE email = ?";
        $check_stmt = $conn->prepare($check_sql);
        if ($check_stmt) {
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();
            $check_result = $check_stmt->get_result();
            $check_row = $check_result->fetch_assoc();
            if ($check_row['count'] > 0) {
                $errors[] = "البريد الإلكتروني موجود بالفعل.";
            }
            $check_stmt->close();
        } else {
            $errors[] = "خطأ في استعلام التحقق: " . htmlspecialchars($conn->error);
        }
    }

    // إذا لم توجد أخطاء، إدخال الموظف الجديد
    if (empty($errors)) {
        $insert_sql = "INSERT INTO employees (name, position, email, phone, date_hired) VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        if ($insert_stmt) {
            $insert_stmt->bind_param("sssss", $name, $position, $email, $phone, $date_hired);
            if ($insert_stmt->execute()) {
                $success_message = "تم إضافة الموظف بنجاح.";
            } else {
                $errors[] = "حدث خطأ أثناء إضافة الموظف: " . htmlspecialchars($insert_stmt->error);
            }
            $insert_stmt->close();
        } else {
            $errors[] = "خطأ في تحضير استعلام الإضافة: " . htmlspecialchars($conn->error);
        }
    }
}

// التعامل مع حذف موظف
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_employee_id'])) {
    $delete_employee_id = intval($_GET['delete_employee_id']);

    // التحقق مما إذا كان الموظف موجودًا
    $check_sql = "SELECT COUNT(*) AS count FROM employees WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    if ($check_stmt) {
        $check_stmt->bind_param("i", $delete_employee_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $check_row = $check_result->fetch_assoc();
        if ($check_row['count'] > 0) {
            // حذف الموظف
            $delete_sql = "DELETE FROM employees WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            if ($delete_stmt) {
                $delete_stmt->bind_param("i", $delete_employee_id);
                if ($delete_stmt->execute()) {
                    $success_message = "تم حذف الموظف بنجاح.";
                } else {
                    $errors[] = "حدث خطأ أثناء حذف الموظف: " . htmlspecialchars($delete_stmt->error);
                }
                $delete_stmt->close();
            } else {
                $errors[] = "خطأ في تحضير استعلام الحذف: " . htmlspecialchars($conn->error);
            }
        } else {
            $errors[] = "لم يتم العثور على الموظف المطلوب.";
        }
        $check_stmt->close();
    } else {
        $errors[] = "خطأ في استعلام التحقق: " . htmlspecialchars($conn->error);
    }
}

// جلب جميع الموظفين
$fetch_sql = "SELECT id, name, position, email, phone, date_hired FROM employees ORDER BY date_hired DESC";
$fetch_stmt = $conn->prepare($fetch_sql);
if ($fetch_stmt) {
    $fetch_stmt->execute();
    $fetch_result = $fetch_stmt->get_result();
} else {
    die("خطأ في استعلام جلب الموظفين: " . htmlspecialchars($conn->error));
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إدارة الموظفين</title>
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
    <h2 class="mb-4">إدارة الموظفين</h2>
    
    <!-- عرض رسائل النجاح أو الخطأ -->
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($success_message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
        </div>
    <?php endif; ?>
    
    <!-- نموذج إضافة موظف جديد -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-user-plus me-2"></i> إضافة موظف جديد
        </div>
        <div class="card-body">
            <form action="employees.php" method="post" class="row g-3 needs-validation" novalidate>
                <!-- اسم الموظف -->
                <div class="col-md-6">
                    <label for="name" class="form-label">اسم الموظف <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <div class="invalid-feedback">
                        يرجى إدخال اسم الموظف.
                    </div>
                </div>
                
                <!-- منصب الموظف -->
                <div class="col-md-6">
                    <label for="position" class="form-label">منصب الموظف <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="position" name="position" required>
                    <div class="invalid-feedback">
                        يرجى إدخال منصب الموظف.
                    </div>
                </div>
                
                <!-- البريد الإلكتروني -->
                <div class="col-md-6">
                    <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="invalid-feedback">
                        يرجى إدخال بريد إلكتروني صالح.
                    </div>
                </div>
                
                <!-- رقم الهاتف -->
                <div class="col-md-6">
                    <label for="phone" class="form-label">رقم الهاتف</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="أدخل رقم الهاتف">
                    <div class="invalid-feedback">
                        يرجى إدخال رقم هاتف صالح إذا كان متاحًا.
                    </div>
                </div>
                
                <!-- تاريخ التعيين -->
                <div class="col-md-6">
                    <label for="date_hired" class="form-label">تاريخ التعيين <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="date_hired" name="date_hired" value="<?php echo date('Y-m-d'); ?>" required>
                    <div class="invalid-feedback">
                        يرجى اختيار تاريخ التعيين.
                    </div>
                </div>
                
                <!-- زر الإرسال -->
                <div class="col-12">
                    <button type="submit" name="add_employee" class="btn btn-primary"><i class="fas fa-save me-2"></i>إضافة موظف</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- جدول عرض الموظفين -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-users me-2"></i> قائمة الموظفين
        </div>
        <div class="card-body">
            <table id="employeesTable" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>رقم الموظف</th>
                        <th>الاسم</th>
                        <th>المنصب</th>
                        <th>البريد الإلكتروني</th>
                        <th>رقم الهاتف</th>
                        <th>تاريخ التعيين</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($employee = $fetch_result->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo htmlspecialchars($employee['id'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($employee['name'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($employee['position'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($employee['email'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($employee['phone'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($employee['date_hired'] ?? ''); ?></td>
                            <td>
                                <a href="edit_employee.php?id=<?php echo $employee['id']; ?>" class="btn btn-sm btn-warning"><i class="fas fa-edit me-1"></i>تعديل</a>
                                <a href="employees.php?delete_employee_id=<?php echo $employee['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا الموظف؟');"><i class="fas fa-trash-alt me-1"></i>حذف</a>
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
        $('#employeesTable').DataTable({
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
