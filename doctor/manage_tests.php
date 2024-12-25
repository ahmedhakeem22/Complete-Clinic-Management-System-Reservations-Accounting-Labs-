<?php
// manage_tests.php

// بدء الجلسة
session_start();

// 1) استدعاء ملف الاتصال بقاعدة البيانات
include '../includes/db.php';

// تعريف المتغيرات
$test_name = $price = $normal_range = $category_id = $parent_test_id = "";
$test_id = 0;
$update = false;
$errors = [];

// إعدادات الباجنيشن
$limit = 10; // عدد الفحوصات في كل صفحة
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// إعدادات البحث
$search_query = '';
$search_param = '';

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search_query = trim($_GET['search']);
    $search_param = "%" . $search_query . "%";
}

// معالجة إضافة أو تعديل الفحص
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // جلب البيانات من النموذج
    $test_name = trim($_POST['test_name']);
    $price = trim($_POST['price']);
    $normal_range = trim($_POST['normal_range']);
    $category_id = intval($_POST['category_id']);
    $parent_test_id = !empty($_POST['parent_test_id']) ? intval($_POST['parent_test_id']) : NULL;

    // التحقق من صحة البيانات
    if (empty($test_name)) {
        $errors[] = "اسم الفحص مطلوب.";
    }
    if (!is_numeric($price) || $price < 0) {
        $errors[] = "السعر يجب أن يكون رقمًا موجبًا.";
    }
    if (empty($category_id)) {
        $errors[] = "تصنيف الفحص مطلوب.";
    }

    // إذا لم يكن هناك أخطاء، نقوم بالإدخال أو التحديث
    if (empty($errors)) {
        if (isset($_POST['save'])) {
            // عملية إضافة
            $stmt = $conn->prepare("INSERT INTO tests (test_name, category_id, price, normal_range, parent_test_id) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sidsi", $test_name, $category_id, $price, $normal_range, $parent_test_id);
            if ($stmt->execute()) {
                $_SESSION['success'] = "تمت إضافة الفحص بنجاح.";
                // إعادة التوجيه مع الحفاظ على معايير البحث والصفحة الحالية
                $redirect_url = "manage_tests.php?page=" . $page;
                if (!empty($search_query)) {
                    $redirect_url .= "&search=" . urlencode($search_query);
                }
                header("Location: " . $redirect_url);
                exit();
            } else {
                $errors[] = "حدث خطأ أثناء إضافة الفحص: " . $stmt->error;
            }
            $stmt->close();
        } elseif (isset($_POST['update'])) {
            // عملية تحديث
            $test_id = intval($_POST['test_id']);
            $stmt = $conn->prepare("UPDATE tests SET test_name = ?, category_id = ?, price = ?, normal_range = ?, parent_test_id = ? WHERE test_id = ?");
            $stmt->bind_param("sidssi", $test_name, $category_id, $price, $normal_range, $parent_test_id, $test_id);
            if ($stmt->execute()) {
                $_SESSION['success'] = "تم تحديث الفحص بنجاح.";
                // إعادة التوجيه مع الحفاظ على معايير البحث والصفحة الحالية
                $redirect_url = "manage_tests.php?page=" . $page;
                if (!empty($search_query)) {
                    $redirect_url .= "&search=" . urlencode($search_query);
                }
                header("Location: " . $redirect_url);
                exit();
            } else {
                $errors[] = "حدث خطأ أثناء تحديث الفحص: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        // في حالة وجود أخطاء، سيتم عرضها في النوافذ المنبثقة
        $_SESSION['form_errors'] = $errors;
        $_SESSION['form_data'] = $_POST;
    }
}

// معالجة طلبات الحذف
if (isset($_GET['delete'])) {
    $test_id = intval($_GET['delete']);
    // التأكد من وجود الفحص قبل الحذف
    $stmt = $conn->prepare("SELECT * FROM tests WHERE test_id = ?");
    $stmt->bind_param("i", $test_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        // حذف الفحص
        $stmt_delete = $conn->prepare("DELETE FROM tests WHERE test_id = ?");
        $stmt_delete->bind_param("i", $test_id);
        if ($stmt_delete->execute()) {
            $_SESSION['success'] = "تم حذف الفحص بنجاح.";
        } else {
            $_SESSION['error'] = "حدث خطأ أثناء حذف الفحص: " . $stmt_delete->error;
        }
        $stmt_delete->close();
    } else {
        $_SESSION['error'] = "الفحص المطلوب غير موجود.";
    }
    $stmt->close();
    // إعادة التوجيه مع الحفاظ على معايير البحث والصفحة الحالية
    $redirect_url = "manage_tests.php?page=" . $page;
    if (!empty($search_query)) {
        $redirect_url .= "&search=" . urlencode($search_query);
    }
    header("Location: " . $redirect_url);
    exit();
}

// جلب العدد الإجمالي للفحوصات لحساب عدد الصفحات بناءً على معايير البحث
if (!empty($search_query)) {
    $count_stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tests WHERE test_name LIKE ?");
    $count_stmt->bind_param("s", $search_param);
} else {
    $count_stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tests");
}

$count_stmt->execute();
$total_tests_result = $count_stmt->get_result();
$total_tests_row = $total_tests_result->fetch_assoc();
$total_tests = $total_tests_row['total'];
$total_pages = ceil($total_tests / $limit);
$count_stmt->close();

// جلب جميع الفئات
$categories = [];
$cat_result = $conn->query("SELECT * FROM test_categories ORDER BY category_name ASC");
if ($cat_result) {
    while ($cat = $cat_result->fetch_assoc()) {
        $categories[] = $cat;
    }
} else {
    $_SESSION['error'] = "حدث خطأ أثناء جلب تصنيفات الفحوصات: " . $conn->error;
}

// جلب الفحوصات للصفحة الحالية بناءً على معايير البحث
$tests = [];
if (!empty($search_query)) {
    $test_stmt = $conn->prepare("SELECT t.*, c.category_name, p.test_name AS parent_test_name FROM tests t 
                                 LEFT JOIN test_categories c ON t.category_id = c.category_id 
                                 LEFT JOIN tests p ON t.parent_test_id = p.test_id 
                                 WHERE t.test_name LIKE ?
                                 ORDER BY t.test_id ASC LIMIT ? OFFSET ?");
    $test_stmt->bind_param("sii", $search_param, $limit, $offset);
} else {
    $test_stmt = $conn->prepare("SELECT t.*, c.category_name, p.test_name AS parent_test_name FROM tests t 
                                 LEFT JOIN test_categories c ON t.category_id = c.category_id 
                                 LEFT JOIN tests p ON t.parent_test_id = p.test_id 
                                 ORDER BY t.test_id ASC LIMIT ? OFFSET ?");
    $test_stmt->bind_param("ii", $limit, $offset);
}

$test_stmt->execute();
$test_result = $test_stmt->get_result();
if ($test_result) {
    while ($test = $test_result->fetch_assoc()) {
        $tests[] = $test;
    }
} else {
    $_SESSION['error'] = "حدث خطأ أثناء جلب الفحوصات: " . $conn->error;
}
$test_stmt->close();
?>
<!-- صفحة إدارة الفحوصات - التصميم الجديد -->

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إدارة الفحوصات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="icon1.png" type="image/png" sizes="16x16">

    <!-- Bootstrap 5 CSS via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome via CDN (إذا كنت تحتاجها) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- ملفات CSS إضافية -->
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <!-- هاذه هو النافبار المخصص لصفحة manage_tests.php -->
    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="Doctor.php">اسم الموقع</a>
          
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="Doctor.php">الرئيسية<span class="visually-hidden">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="News.php">الأخبار</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="contact.php">اتصل بنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="About.php">حول</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            المستخدم
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="Doctor.php" target="_blank">الطبيب</a></li>
                            <li><a class="dropdown-item" href="../reception/reception.php" target="_blank">الاستقبال</a></li>
                            <li><a class="dropdown-item" href="../nafsi/nafsi.php" target="_blank">المختبر النفسي</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../blood/index.php" target="_blank">مختبر الدم</a></li>
                            <li><a class="dropdown-item" href="../pharm" target="_blank">الصيدلية</a></li>
                        </ul>
                    </li> 
                </ul>
            </div>
        </div>
    </nav>

    <!-- محتوى الصفحة يبدأ هنا -->
    <div class="container mt-5">
        <!-- العنوان وزر الإضافة -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-primary">إدارة الفحوصات</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTestModal">
                <i class="bi bi-plus-circle"></i> إضافة فحص جديد
            </button>
        </div>

        <!-- نموذج البحث بشكل أكثر أناقة -->
        <div class="card mb-4">
            <div class="card-body">
                <form class="row g-3" method="GET" action="manage_tests.php">
                    <div class="col-md-10">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" name="search" placeholder="ابحث عن اسم الفحص..." value="<?php echo htmlspecialchars($search_query); ?>">
                        </div>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">بحث</button>
                    </div>
                </form>
                <?php if (!empty($search_query)): ?>
                    <div class="mt-3">
                        <a href="manage_tests.php" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> إلغاء البحث</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- عرض رسائل النجاح أو الخطأ من الجلسة -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                    echo htmlspecialchars($_SESSION['success'] ?? '');
                    unset($_SESSION['success']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php 
                    echo htmlspecialchars($_SESSION['error'] ?? '');
                    unset($_SESSION['error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
            </div>
        <?php endif; ?>

        <!-- جدول الفحوصات بدلاً من بطاقات لعرض أكثر تنظيماً -->
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">قائمة الفحوصات</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php if (!empty($tests)): ?>
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>اسم الفحص</th>
                                    <th>التصنيف</th>
                                    <th>السعر</th>
                                    <th>النطاق الطبيعي</th>
                                    <th>الفحص الأب</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tests as $index => $test): ?>
                                    <tr>
                                        <td><?php echo ($offset + $index + 1); ?></td>
                                        <td><?php echo htmlspecialchars($test['test_name'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($test['category_name'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars(number_format($test['price'] ?? 0, 2)) . " ريال"; ?></td>
                                        <td><?php echo htmlspecialchars($test['normal_range'] ?? ''); ?></td>
                                        <td><?php echo htmlspecialchars($test['parent_test_name'] ?? 'لا يوجد'); ?></td>
                                        <td>
                                            <button 
                                                class="btn btn-sm btn-warning me-2 edit-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editTestModal"
                                                data-test_id="<?php echo htmlspecialchars($test['test_id'] ?? ''); ?>"
                                                data-test_name="<?php echo htmlspecialchars($test['test_name'] ?? ''); ?>"
                                                data-category_id="<?php echo htmlspecialchars($test['category_id'] ?? ''); ?>"
                                                data-price="<?php echo htmlspecialchars($test['price'] ?? ''); ?>"
                                                data-normal_range="<?php echo htmlspecialchars($test['normal_range'] ?? ''); ?>"
                                                data-parent_test_id="<?php echo htmlspecialchars($test['parent_test_id'] ?? ''); ?>"
                                            >
                                                <i class="bi bi-pencil-square"></i> تعديل
                                            </button>
                                            <a href="manage_tests.php?delete=<?php echo htmlspecialchars($test['test_id'] ?? ''); ?>&page=<?php echo $page; ?>&search=<?php echo urlencode($search_query); ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('هل أنت متأكد من حذف هذا الفحص؟');">
                                                <i class="bi bi-trash"></i> حذف
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-info text-center" role="alert">
                            لا توجد فحوصات متاحة.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- عناصر الباجنيشن بشكل أنيق -->
        <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation example" class="mt-4">
                <ul class="pagination justify-content-center">
                    <!-- زر الصفحة السابقة -->
                    <li class="page-item <?php if($page <= 1){ echo 'disabled'; } ?>">
                        <a class="page-link" href="<?php 
                            if($page <= 1){
                                echo '#';
                            } else {
                                $prev_page = $page -1;
                                echo 'manage_tests.php?page=' . $prev_page . (!empty($search_query) ? '&search=' . urlencode($search_query) : '');
                            }
                        ?>" tabindex="-1">السابق</a>
                    </li>

                    <!-- أرقام الصفحات -->
                    <?php 
                        // تحديد نطاق الأرقام لعرض بعض الصفحات حول الصفحة الحالية
                        $range = 2; // عدد الصفحات قبل وبعد الصفحة الحالية
                        for($i = max(1, $page - $range); $i <= min($page + $range, $total_pages); $i++): 
                    ?>
                        <li class="page-item <?php if($page == $i){ echo 'active'; } ?>">
                            <a class="page-link <?php if($page == $i){ echo 'bg-primary text-white'; } ?>" href="manage_tests.php?page=<?php echo $i; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>

                    <!-- زر الصفحة التالية -->
                    <li class="page-item <?php if($page >= $total_pages){ echo 'disabled'; } ?>">
                        <a class="page-link" href="<?php 
                            if($page >= $total_pages){
                                echo '#';
                            } else {
                                $next_page = $page +1;
                                echo 'manage_tests.php?page=' . $next_page . (!empty($search_query) ? '&search=' . urlencode($search_query) : '');
                            }
                        ?>">التالي</a>
                    </li>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <!-- نموذج إضافة الفحص في نافذة منبثقة -->
    <div class="modal fade" id="addTestModal" tabindex="-1" aria-labelledby="addTestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="manage_tests.php?page=<?php echo $page; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?>" method="POST">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addTestModalLabel">إضافة فحص جديد</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        <!-- عرض الأخطاء إن وجدت -->
                        <?php if (isset($_SESSION['form_errors']) && isset($_POST['save'])): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php 
                                        foreach ($_SESSION['form_errors'] as $error): 
                                    ?>
                                        <li><?php echo htmlspecialchars($error ?? ''); ?></li>
                                    <?php 
                                        endforeach; 
                                        unset($_SESSION['form_errors']);
                                    ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <label for="add_test_name" class="form-label">اسم الفحص <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="add_test_name" name="test_name" 
                                value="<?php echo isset($_SESSION['form_data']['test_name']) ? htmlspecialchars($_SESSION['form_data']['test_name']) : ''; ?>" 
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="add_category_id" class="form-label">تصنيف الفحص <span class="text-danger">*</span></label>
                            <select class="form-select" id="add_category_id" name="category_id" required>
                                <option value="">اختر تصنيفًا</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo htmlspecialchars($category['category_id'] ?? ''); ?>"
                                        <?php 
                                            if(isset($_SESSION['form_data']['category_id']) && $_SESSION['form_data']['category_id'] == $category['category_id']) {
                                                echo 'selected';
                                            }
                                        ?>
                                    >
                                        <?php echo htmlspecialchars($category['category_name'] ?? ''); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="add_price" class="form-label">السعر <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="add_price" name="price" 
                                    value="<?php echo isset($_SESSION['form_data']['price']) ? htmlspecialchars($_SESSION['form_data']['price']) : ''; ?>" 
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="add_normal_range" class="form-label">النطاق الطبيعي</label>
                                <input type="text" class="form-control" id="add_normal_range" name="normal_range" 
                                    value="<?php echo isset($_SESSION['form_data']['normal_range']) ? htmlspecialchars($_SESSION['form_data']['normal_range']) : ''; ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="add_parent_test_id" class="form-label">الفحص الأب (اختياري)</label>
                            <select class="form-select" id="add_parent_test_id" name="parent_test_id">
                                <option value="">لا يوجد</option>
                                <?php foreach ($tests as $test_option): ?>
                                    <option value="<?php echo htmlspecialchars($test_option['test_id'] ?? ''); ?>"
                                        <?php 
                                            if(isset($_SESSION['form_data']['parent_test_id']) && $_SESSION['form_data']['parent_test_id'] == $test_option['test_id']) {
                                                echo 'selected';
                                            }
                                        ?>
                                    >
                                        <?php echo htmlspecialchars($test_option['test_name'] ?? ''); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php 
                            // مسح بيانات النموذج بعد الاستخدام
                            if(isset($_SESSION['form_data'])){
                                unset($_SESSION['form_data']);
                            }
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" name="save" class="btn btn-primary">إضافة الفحص</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- نموذج تعديل الفحص في نافذة منبثقة -->
    <div class="modal fade" id="editTestModal" tabindex="-1" aria-labelledby="editTestModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="manage_tests.php?page=<?php echo $page; ?><?php echo !empty($search_query) ? '&search=' . urlencode($search_query) : ''; ?>" method="POST">
                    <div class="modal-header bg-warning text-white">
                        <h5 class="modal-title" id="editTestModalLabel">تعديل الفحص</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        <!-- عرض الأخطاء إن وجدت -->
                        <?php if (isset($_SESSION['form_errors']) && isset($_POST['update'])): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php 
                                        foreach ($_SESSION['form_errors'] as $error): 
                                    ?>
                                        <li><?php echo htmlspecialchars($error ?? ''); ?></li>
                                    <?php 
                                        endforeach; 
                                        unset($_SESSION['form_errors']);
                                    ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <input type="hidden" name="test_id" id="edit_test_id">
                        <div class="mb-3">
                            <label for="edit_test_name" class="form-label">اسم الفحص <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_test_name" name="test_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_category_id" class="form-label">تصنيف الفحص <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_category_id" name="category_id" required>
                                <option value="">اختر تصنيفًا</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?php echo htmlspecialchars($category['category_id'] ?? ''); ?>">
                                        <?php echo htmlspecialchars($category['category_name'] ?? ''); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_price" class="form-label">السعر <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="edit_price" name="price" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_normal_range" class="form-label">النطاق الطبيعي</label>
                                <input type="text" class="form-control" id="edit_normal_range" name="normal_range">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_parent_test_id" class="form-label">الفحص الأب (اختياري)</label>
                            <select class="form-select" id="edit_parent_test_id" name="parent_test_id">
                                <option value="">لا يوجد</option>
                                <?php foreach ($tests as $test_option): ?>
                                    <option value="<?php echo htmlspecialchars($test_option['test_id'] ?? ''); ?>">
                                        <?php echo htmlspecialchars($test_option['test_name'] ?? ''); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" name="update" class="btn btn-warning">تحديث الفحص</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- سكريبتات JavaScript لتشغيل النوافذ المنبثقة وتعبئة بيانات التعديل -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const testId = this.getAttribute('data-test_id');
                    const testName = this.getAttribute('data-test_name');
                    const categoryId = this.getAttribute('data-category_id');
                    const price = this.getAttribute('data-price');
                    const normalRange = this.getAttribute('data-normal_range');
                    const parentTestId = this.getAttribute('data-parent_test_id');

                    // تعيين القيم في نموذج التعديل
                    document.getElementById('edit_test_id').value = testId;
                    document.getElementById('edit_test_name').value = testName;
                    document.getElementById('edit_category_id').value = categoryId;
                    document.getElementById('edit_price').value = price;
                    document.getElementById('edit_normal_range').value = normalRange;
                    document.getElementById('edit_parent_test_id').value = parentTestId;
                });
            });

            // إذا كان هناك أخطاء في النموذج، فتح النافذة المنبثقة المناسبة
            <?php if (isset($_SESSION['form_errors'])): ?>
                <?php
                    // تحديد نوع النافذة المنبثقة التي يجب فتحها بناءً على ما إذا كان هناك حفظ أم تحديث
                    if (isset($_POST['save'])) {
                        echo "var addModal = new bootstrap.Modal(document.getElementById('addTestModal')); addModal.show();";
                    } elseif (isset($_POST['update'])) {
                        echo "var editModal = new bootstrap.Modal(document.getElementById('editTestModal')); editModal.show();";
                    }
                ?>
            <?php endif; ?>
        });
    </script>

    <!-- Bootstrap 5 JS Bundle via CDN (يتضمن Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
