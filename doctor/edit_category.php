<?php
// edit_category.php

// الاتصال بقاعدة البيانات
include '../includes/db.php';

// الحصول على id الفئة من GET
$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($category_id <= 0) {
    echo "معرف الفئة غير صالح.";
    exit();
}

// جلب تفاصيل الفئة الحالية
$fetch_sql = "SELECT name FROM categories WHERE id = ?";
$fetch_stmt = $conn->prepare($fetch_sql);
if ($fetch_stmt) {
    $fetch_stmt->bind_param("i", $category_id);
    $fetch_stmt->execute();
    $result = $fetch_stmt->get_result();
    $category = $result->fetch_assoc();
    if (!$category) {
        echo "لم يتم العثور على الفئة المطلوبة.";
        exit();
    }
} else {
    die("خطأ في استعلام الفئة: " . $conn->error);
}

// التعامل مع تعديل الفئة
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_category'])) {
    $new_category_name = trim($_POST['category_name']);

    // التحقق من صحة البيانات
    if (empty($new_category_name)) {
        $error_message = "يرجى إدخال اسم الفئة.";
    } else {
        // التحقق مما إذا كانت الفئة موجودة بالفعل (باستثناء الفئة الحالية)
        $check_sql = "SELECT COUNT(*) AS count FROM categories WHERE name = ? AND id != ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("si", $new_category_name, $category_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $check_row = $check_result->fetch_assoc();
        if ($check_row['count'] > 0) {
            $error_message = "الفئة موجودة بالفعل.";
        } else {
            // تحديث اسم الفئة
            $update_sql = "UPDATE categories SET name = ? WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("si", $new_category_name, $category_id);
            if ($update_stmt->execute()) {
                $success_message = "تم تعديل الفئة بنجاح.";
                // تحديث اسم الفئة في المتغير الحالي
                $category['name'] = $new_category_name;
            } else {
                $error_message = "حدث خطأ أثناء تعديل الفئة: " . htmlspecialchars($update_stmt->error);
            }
            $update_stmt->close();
        }
        $check_stmt->close();
    }
}

$fetch_stmt->close();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تعديل الفئة</title>
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
    <h2 class="mb-4">تعديل الفئة</h2>
    
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
    
    <!-- نموذج تعديل الفئة -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-edit me-2"></i> تعديل الفئة
        </div>
        <div class="card-body">
            <form action="edit_category.php?id=<?php echo $category_id; ?>" method="post" class="row g-3 needs-validation" novalidate>
                <!-- اسم الفئة -->
                <div class="col-md-6">
                    <label for="category_name" class="form-label">اسم الفئة <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                    <div class="invalid-feedback">
                        يرجى إدخال اسم الفئة.
                    </div>
                </div>
                
                <!-- زر الإرسال -->
                <div class="col-12">
                    <button type="submit" name="edit_category" class="btn btn-primary"><i class="fas fa-save me-2"></i>تعديل الفئة</button>
                    <a href="categories.php" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i>العودة إلى إدارة الفئات</a>
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
