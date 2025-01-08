<?php
// book_out.php

// تضمين رأس الصفحة وقائمة التنقل
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';

// الاتصال بقاعدة البيانات
include '../includes/db.php';

// دوال مساعدة لتحسين الأمان والترشيح
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// جلب الفئات، الموردين، والموظفين من قاعدة البيانات
function fetch_data($conn, $table, $id_field, $name_field) {
    $sql = "SELECT $id_field, $name_field FROM $table ORDER BY $name_field ASC";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->execute();
        return $stmt->get_result();
    } else {
        die("خطأ في استعلام $table: " . $conn->error);
    }
}

$category_result = fetch_data($conn, 'categories', 'id', 'name');
$vendor_result = fetch_data($conn, 'vendors', 'vendor_id', 'vendor_name');
$employee_result = fetch_data($conn, 'employees', 'id', 'name');

// بناء مصفوفات الفئات، الموردين، والموظفين
$categories = [];
while ($category = $category_result->fetch_assoc()) {
    $categories[$category['id']] = $category['name'];
}
$category_result->close();

$vendors = [];
while ($vendor = $vendor_result->fetch_assoc()) {
    $vendors[$vendor['vendor_id']] = $vendor['vendor_name'];
}
$vendor_result->close();

$employees = [];
while ($employee = $employee_result->fetch_assoc()) {
    $employees[$employee['id']] = $employee['name'];
}
$employee_result->close();

// بناء استعلام SQL بناءً على الفلاتر
$sql = "SELECT * FROM pay_bill";
$conditions = [];
$params = [];
$types = '';

// التعامل مع الفلاتر من GET
if (isset($_GET['filter_date']) && !empty($_GET['filter_date'])) {
    $conditions[] = "bill_date = ?";
    $params[] = sanitize_input($_GET['filter_date']);
    $types .= 's';
}

if (isset($_GET['filter_category']) && !empty($_GET['filter_category'])) {
    $conditions[] = "category_id = ?";
    $params[] = intval($_GET['filter_category']);
    $types .= 'i';
}

if (isset($_GET['filter_payment_method']) && !empty($_GET['filter_payment_method'])) {
    $conditions[] = "payment_method = ?";
    $params[] = sanitize_input($_GET['filter_payment_method']);
    $types .= 's';
}

if (isset($_GET['filter_invoice_number']) && !empty($_GET['filter_invoice_number'])) {
    $conditions[] = "invoice_number LIKE ?";
    $params[] = '%' . sanitize_input($_GET['filter_invoice_number']) . '%';
    $types .= 's';
}

if (isset($_GET['filter_recipient_type']) && !empty($_GET['filter_recipient_type']) && isset($_GET['filter_recipient_id'])) {
    $recipient_type = sanitize_input($_GET['filter_recipient_type']);
    $recipient_id = intval($_GET['filter_recipient_id']);
    if ($recipient_type == 'vendor') {
        $conditions[] = "vendor_id = ?";
    } elseif ($recipient_type == 'employee') {
        $conditions[] = "employee_id = ?";
    }
    $params[] = $recipient_id;
    $types .= 'i';
}

if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

$stmt = $conn->prepare($sql);
if ($stmt) {
    if (!empty($params)) {
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- تضمين Font Awesome للأيقونات -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- تضمين DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <!-- تخصيص بعض الأنماط -->
    <style>
        body {
            padding: 20px;
            direction: rtl;
            font-family: 'Cairo', sans-serif;
            background-color: #f0f2f5;
        }
        .card-header {
            background-color: #4e73df;
            color: #fff;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
        .btn-success {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }
        .btn-success:hover {
            background-color: #17a673;
            border-color: #138f61;
        }
        .btn-secondary {
            background-color: #858796;
            border-color: #858796;
        }
        .btn-secondary:hover {
            background-color: #6e707e;
            border-color: #5a5c69;
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
    <h2 class="mb-4">إدارة المصروفات</h2>
    
    <!-- نموذج إضافة أمر صرف جديد -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-plus me-2"></i> إضافة أمر صرف جديد
        </div>
        <div class="card-body">
            <form action="book_out_ach_pdf_insrt.php" method="post" target="_blank" class="row g-3 needs-validation" novalidate>
                <!-- اسم الصرف -->
                <div class="col-md-6">
                    <label for="recip_name" class="form-label">اسم الصرف <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="recip_name" name="recip_name" required>
                    <div class="invalid-feedback">
                        يرجى إدخال اسم الصرف.
                    </div>
                </div>
                
                <!-- نوع المستلم -->
                <div class="col-md-6">
                    <label for="recipient_type" class="form-label">نوع المستلم <span class="text-danger">*</span></label>
                    <select name="recipient_type" id="recipient_type" class="form-select" required>
                        <option value="">اختر نوع المستلم</option>
                        <option value="vendor">مورد</option>
                        <option value="employee">موظف</option>
                    </select>
                    <div class="invalid-feedback">
                        يرجى اختيار نوع المستلم.
                    </div>
                </div>
                
                <!-- المستلم -->
                <div class="col-md-6" id="recipient_container" style="display: none;">
                    <label for="recipient_id" class="form-label">المستلم <span class="text-danger">*</span></label>
                    <select name="recipient_id" id="recipient_id" class="form-select" required>
                        <option value="">اختر المستلم</option>
                        <!-- الخيارات ستضاف ديناميكيًا عبر JavaScript -->
                    </select>
                    <div class="invalid-feedback">
                        يرجى اختيار المستلم.
                    </div>
                </div>
                
                <!-- الفئة -->
                <div class="col-md-6">
                    <label for="category_id" class="form-label">فئة المصروف <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">اختر الفئة</option>
                        <?php foreach ($categories as $id => $name): ?>
                            <option value="<?php echo htmlspecialchars($id); ?>"><?php echo htmlspecialchars($name); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">
                        يرجى اختيار فئة المصروف.
                    </div>
                </div>
                
                <!-- المبلغ -->
                <div class="col-md-6">
                    <label for="amount" class="form-label">المبلغ (ريال يمني) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="amount" name="amount" min="0" step="0.01" required>
                    <div class="invalid-feedback">
                        يرجى إدخال مبلغ صالح.
                    </div>
                </div>
                
                <!-- طريقة الدفع -->
                <div class="col-md-6">
                    <label for="payment_method" class="form-label">طريقة الدفع <span class="text-danger">*</span></label>
                    <select name="payment_method" id="payment_method" class="form-select" required>
                        <option value="">اختر طريقة الدفع</option>
                        <option value="نقدًا">نقدًا</option>
                        <option value="تحويل بنكي">تحويل بنكي</option>
                        <option value="بطاقة ائتمان">بطاقة ائتمان</option>
                        <option value="آخر">آخر</option>
                    </select>
                    <div class="invalid-feedback">
                        يرجى اختيار طريقة الدفع.
                    </div>
                </div>
                
                <!-- رقم الفاتورة/المرجع -->
                <div class="col-md-6">
                    <label for="invoice_number" class="form-label">رقم الفاتورة/المرجع</label>
                    <input type="text" class="form-control" id="invoice_number" name="invoice_number" placeholder="أدخل رقم الفاتورة أو المرجع">
                    <div class="invalid-feedback">
                        يرجى إدخال رقم الفاتورة إذا كان متاحًا.
                    </div>
                </div>
                
                <!-- الوصف -->
                <div class="col-md-6">
                    <label for="description" class="form-label">الوصف</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="أدخل وصفًا للمصروف"></textarea>
                    <div class="invalid-feedback">
                        يرجى إدخال وصف للمصروف إذا كان مطلوبًا.
                    </div>
                </div>
                
                <!-- تاريخ الصرف -->
                <div class="col-md-6">
                    <label for="bill_date" class="form-label">تاريخ الصرف <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="bill_date" name="bill_date" value="<?php echo date('Y-m-d'); ?>" required>
                    <div class="invalid-feedback">
                        يرجى اختيار تاريخ الصرف.
                    </div>
                </div>
                
                <!-- زر الإرسال -->
                <div class="col-12">
                    <button type="submit" name="add_sess" class="btn btn-primary"><i class="fas fa-save me-2"></i>أمر صرف</button>
                </div>
            </form>
        </div>
        
        <!-- نموذج طباعة كل المصروفات -->
        <div class="mb-4">
            <form action="book_all_out_pdf.php" method="post" class="d-inline">
                <button type="submit" name="print_all" class="btn btn-success"><i class="fas fa-print me-2"></i>طباعة كل المصروفات</button>
            </form>
        </div>
        
        <hr>
        
        <!-- نموذج الفلترة -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-filter me-2"></i> فلترة المصروفات
            </div>
            <div class="card-body">
                <form method="get" action="book_out.php" class="row g-3 needs-validation" novalidate>
                    <div class="col-md-3">
                        <label for="filter_date" class="form-label">التاريخ:</label>
                        <input type="date" class="form-control" id="filter_date" name="filter_date" value="<?php echo isset($_GET['filter_date']) ? htmlspecialchars($_GET['filter_date']) : ''; ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="filter_category" class="form-label">الفئة:</label>
                        <select name="filter_category" id="filter_category" class="form-select">
                            <option value="">كل الفئات</option>
                            <?php foreach ($categories as $id => $name): ?>
                                <option value="<?php echo htmlspecialchars($id); ?>" <?php echo (isset($_GET['filter_category']) && $_GET['filter_category'] == $id) ? 'selected' : ''; ?>><?php echo htmlspecialchars($name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filter_payment_method" class="form-label">طريقة الدفع:</label>
                        <select name="filter_payment_method" id="filter_payment_method" class="form-select">
                            <option value="">كل الطرق</option>
                            <option value="نقدًا" <?php if(isset($_GET['filter_payment_method']) && $_GET['filter_payment_method'] == 'نقدًا') echo 'selected'; ?>>نقدًا</option>
                            <option value="تحويل بنكي" <?php if(isset($_GET['filter_payment_method']) && $_GET['filter_payment_method'] == 'تحويل بنكي') echo 'selected'; ?>>تحويل بنكي</option>
                            <option value="بطاقة ائتمان" <?php if(isset($_GET['filter_payment_method']) && $_GET['filter_payment_method'] == 'بطاقة ائتمان') echo 'selected'; ?>>بطاقة ائتمان</option>
                            <option value="آخر" <?php if(isset($_GET['filter_payment_method']) && $_GET['filter_payment_method'] == 'آخر') echo 'selected'; ?>>آخر</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filter_invoice_number" class="form-label">رقم الفاتورة:</label>
                        <input type="text" class="form-control" id="filter_invoice_number" name="filter_invoice_number" placeholder="ابحث برقم الفاتورة" value="<?php echo isset($_GET['filter_invoice_number']) ? htmlspecialchars($_GET['filter_invoice_number']) : ''; ?>">
                    </div>
                    
                    <!-- فلترة نوع المستلم -->
                    <div class="col-md-3">
                        <label for="filter_recipient_type" class="form-label">نوع المستلم:</label>
                        <select name="filter_recipient_type" id="filter_recipient_type" class="form-select">
                            <option value="">كل الأنواع</option>
                            <option value="vendor" <?php if(isset($_GET['filter_recipient_type']) && $_GET['filter_recipient_type'] == 'vendor') echo 'selected'; ?>>مورد</option>
                            <option value="employee" <?php if(isset($_GET['filter_recipient_type']) && $_GET['filter_recipient_type'] == 'employee') echo 'selected'; ?>>موظف</option>
                        </select>
                    </div>
                    
                    <!-- فلترة المستلم بناءً على نوعه -->
                    <div class="col-md-3" id="filter_recipient_container" style="display: none;">
                        <label for="filter_recipient_id" class="form-label">المستلم:</label>
                        <select name="filter_recipient_id" id="filter_recipient_id" class="form-select" required>
                            <option value="">كل المستلمين</option>
                            <!-- الخيارات ستضاف ديناميكيًا عبر JavaScript -->
                        </select>
                        <div class="invalid-feedback">
                            يرجى اختيار المستلم.
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search me-2"></i>فلترة</button>
                        <a href="book_out.php" class="btn btn-secondary"><i class="fas fa-times me-2"></i>إعادة تعيين</a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- جدول عرض المصروفات -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-list me-2"></i> قائمة المصروفات
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="expensesTable" class="table table-striped table-bordered" style="width:100%">
                        <thead class="table-dark">
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>اسم الصرف</th>
                                <th>الفئة</th>
                                <th>المبلغ (ريال يمني)</th>
                                <th>طريقة الدفع</th>
                                <th>رقم الفاتورة/المرجع</th>
                                <th>الوصف</th>
                                <th>المستلم</th>
                                <th>نوع المستلم</th>
                                <th>تاريخ الصرف</th>
                                <th>الإجراءات</th>
                                <th>طباعة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): 
                                // جلب اسم الفئة
                                $category_name = $categories[$row['category_id']] ?? 'غير محدد';
                                
                                // تحديد نوع المستلم واسم المستلم
                                if (!empty($row['vendor_id'])) {
                                    $recipient_type_display = 'مورد';
                                    $recipient_name = $vendors[$row['vendor_id']] ?? 'غير محدد';
                                } elseif (!empty($row['employee_id'])) {
                                    $recipient_type_display = 'موظف';
                                    $recipient_name = $employees[$row['employee_id']] ?? 'غير محدد';
                                } else {
                                    $recipient_type_display = 'غير محدد';
                                    $recipient_name = 'غير محدد';
                                }
                            ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['bill_id'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($row['recip_name'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($category_name); ?></td>
                                    <td><?php echo number_format($row['amount'], 2); ?> ر.ي</td>
                                    <td><?php echo htmlspecialchars($row['payment_method'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($row['invoice_number'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($row['description'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($recipient_name); ?></td>
                                    <td><?php echo htmlspecialchars($recipient_type_display); ?></td>
                                    <td><?php echo htmlspecialchars($row['bill_date'] ?? ''); ?></td>
                                    <td>
                                        <a href="edit.php?id=<?php echo $row['bill_id']; ?>" class="btn btn-sm btn-warning" title="تعديل"><i class="fas fa-edit"></i></a>
                                        <a href="delete.php?id=<?php echo $row['bill_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المصروف؟');" title="حذف"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                    <td>
                                        <a href="print_bill.php?id=<?php echo $row['bill_id']; ?>" class="btn btn-sm btn-info" target="_blank" title="طباعة"><i class="fas fa-print"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                        <!-- تم إزالة <tfoot> لمنع تكرار الرؤوس -->
                    </table>
                </div>
            </div>
        </div>
    </main>
    
    <!-- تضمين مكتبة jQuery و Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
                "info": true,
                "responsive": true,
                "autoWidth": false
            });

            // تحميل بيانات الموردين والموظفين في JavaScript
            const vendors = <?php echo json_encode($vendors); ?>;
            const employees = <?php echo json_encode($employees); ?>;

            // دالة لإظهار وإخفاء وتحديث قائمة المستلمين بناءً على نوع المستلم
            function updateRecipientOptions(type, recipientSelectId, recipientContainerId) {
                const recipientSelect = $('#' + recipientSelectId);
                if (type === 'vendor') {
                    recipientSelect.empty().append('<option value="">اختر المستلم</option>');
                    $.each(vendors, function(id, name) {
                        recipientSelect.append('<option value="' + id + '">' + name + '</option>');
                    });
                    $('#' + recipientContainerId).slideDown();
                    recipientSelect.attr('required', true);
                } else if (type === 'employee') {
                    recipientSelect.empty().append('<option value="">اختر المستلم</option>');
                    $.each(employees, function(id, name) {
                        recipientSelect.append('<option value="' + id + '">' + name + '</option>');
                    });
                    $('#' + recipientContainerId).slideDown();
                    recipientSelect.attr('required', true);
                } else {
                    recipientSelect.empty().append('<option value="">كل المستلمين</option>');
                    $('#' + recipientContainerId).slideUp();
                    recipientSelect.removeAttr('required');
                }
            }

            // التعامل مع النموذج الرئيسي (إضافة مصروف)
            $('#recipient_type').change(function() {
                const type = $(this).val();
                updateRecipientOptions(type, 'recipient_id', 'recipient_container');
            });

            // التعامل مع نموذج الفلترة
            $('#filter_recipient_type').change(function() {
                const type = $(this).val();
                updateRecipientOptions(type, 'filter_recipient_id', 'filter_recipient_container');
            });

            // إذا كانت هناك قيمة مسبقة في نموذج الفلترة (مثلاً بعد الفلترة)
            <?php if(isset($_GET['filter_recipient_type']) && isset($_GET['filter_recipient_id'])): ?>
                updateRecipientOptions('<?php echo htmlspecialchars($_GET['filter_recipient_type']); ?>', 'filter_recipient_id', 'filter_recipient_container');
                $('#filter_recipient_id').val('<?php echo htmlspecialchars($_GET['filter_recipient_id']); ?>');
            <?php endif; ?>

            // إذا كانت هناك قيمة مسبقة في النموذج الرئيسي (إضافة مصروف)
            <?php if(isset($_GET['recipient_type']) && isset($_GET['recipient_id'])): ?>
                updateRecipientOptions('<?php echo htmlspecialchars($_GET['recipient_type']); ?>', 'recipient_id', 'recipient_container');
                $('#recipient_id').val('<?php echo htmlspecialchars($_GET['recipient_id']); ?>');
            <?php endif; ?>

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
