<?php
// edit_employee.php

// الاتصال بقاعدة البيانات
include '../includes/db.php';

// الحصول على id الموظف من GET
$employee_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($employee_id <= 0) {
    echo "معرف الموظف غير صالح.";
    exit();
}

// جلب تفاصيل الموظف الحالية
$fetch_sql = "SELECT name, position, email, phone, date_hired FROM employees WHERE id = ?";
$fetch_stmt = $conn->prepare($fetch_sql);
if ($fetch_stmt) {
    $fetch_stmt->bind_param("i", $employee_id);
    $fetch_stmt->execute();
    $result = $fetch_stmt->get_result();
    $employee = $result->fetch_assoc();
    if (!$employee) {
        echo "لم يتم العثور على الموظف المطلوب.";
        exit();
    }
} else {
    die("خطأ في استعلام الموظف: " . htmlspecialchars($conn->error));
}

// التعامل مع تعديل الموظف
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_employee'])) {
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

    // التحقق مما إذا كان البريد الإلكتروني موجودًا بالفعل (باستثناء الموظف الحالي)
    if (empty($errors)) {
        $check_sql = "SELECT COUNT(*) AS count FROM employees WHERE email = ? AND id != ?";
        $check_stmt = $conn->prepare($check_sql);
        if ($check_stmt) {
            $check_stmt->bind_param("si", $email, $employee_id);
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

    // إذا لم توجد أخطاء، تحديث بيانات الموظف
    if (empty($errors)) {
        $update_sql = "UPDATE employees SET name = ?, position = ?, email = ?, phone = ?, date_hired = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        if ($update_stmt) {
            $update_stmt->bind_param("sssssi", $name, $position, $email, $phone, $date_hired, $employee_id);
            if ($update_stmt->execute()) {
                $success_message = "تم تعديل بيانات الموظف بنجاح.";
                // تحديث بيانات الموظف في المتغير الحالي
                $employee['name'] = $name;
                $employee['position'] = $position;
                $employee['email'] = $email;
                $employee['phone'] = $phone;
                $employee['date_hired'] = $date_hired;
            } else {
                $errors[] = "حدث خطأ أثناء تعديل الموظف: " . htmlspecialchars($update_stmt->error);
            }
            $update_stmt->close();
        } else {
            $errors[] = "خطأ في تحضير استعلام التعديل: " . htmlspecialchars($conn->error);
        }
    }
}

$fetch_stmt->close();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل الموظف</title>
    <!-- تضمين Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- تضمين Font Awesome للأيقونات -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
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
    <h2 class="mb-4">تعديل الموظف</h2>
    
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
    
    <!-- نموذج تعديل الموظف -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-2"></i> تعديل بيانات الموظف
        </div>
        <div class="card-body">
            <form action="edit_employee.php?id=<?php echo $employee_id; ?>" method="post" class="row g-3 needs-validation" novalidate>
                <!-- اسم الموظف -->
                <div class="col-md-6">
                    <label for="name" class="form-label">اسم الموظف <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($employee['name'] ?? ''); ?>" required>
                    <div class="invalid-feedback">
                        يرجى إدخال اسم الموظف.
                    </div>
                </div>
                
                <!-- منصب الموظف -->
                <div class="col-md-6">
                    <label for="position" class="form-label">منصب الموظف <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="position" name="position" value="<?php echo htmlspecialchars($employee['position'] ?? ''); ?>" required>
                    <div class="invalid-feedback">
                        يرجى إدخال منصب الموظف.
                    </div>
                </div>
                
                <!-- البريد الإلكتروني -->
                <div class="col-md-6">
                    <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($employee['email'] ?? ''); ?>" required>
                    <div class="invalid-feedback">
                        يرجى إدخال بريد إلكتروني صالح.
                    </div>
                </div>
                
                <!-- رقم الهاتف -->
                <div class="col-md-6">
                    <label for="phone" class="form-label">رقم الهاتف</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="أدخل رقم الهاتف" value="<?php echo htmlspecialchars($employee['phone'] ?? ''); ?>">
                    <div class="invalid-feedback">
                        يرجى إدخال رقم هاتف صالح إذا كان متاحًا.
                    </div>
                </div>
                
                <!-- تاريخ التعيين -->
                <div class="col-md-6">
                    <label for="date_hired" class="form-label">تاريخ التعيين <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="date_hired" name="date_hired" value="<?php echo htmlspecialchars($employee['date_hired'] ?? date('Y-m-d')); ?>" required>
                    <div class="invalid-feedback">
                        يرجى اختيار تاريخ التعيين.
                    </div>
                </div>
                
                <!-- زر الإرسال -->
                <div class="col-12">
                    <button type="submit" name="edit_employee" class="btn btn-primary"><i class="fas fa-save me-2"></i>تعديل الموظف</button>
                    <a href="employees.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>العودة إلى إدارة الموظفين</a>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- تضمين مكتبة jQuery و Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
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
$conn->close();
?>
