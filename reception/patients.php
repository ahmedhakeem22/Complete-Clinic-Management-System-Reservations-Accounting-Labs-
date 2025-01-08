<?php 
// index.php

// تضمين ملفات الرأس والنافبار وقاعدة البيانات
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';
include '../includes/db.php';

// تعيين المنطقة الزمنية
date_default_timezone_set("Asia/Aden");

// دوال لتنظيف البيانات
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// إعدادات التصفح
$limit = 10; // عدد السجلات في كل صفحة
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) { $page = 1; }

// التعامل مع مصطلح البحث
$search = isset($_GET['search']) ? sanitize_input($_GET['search']) : '';

// بناء الاستعلامات حسب وجود البحث أم لا
if (!empty($search)) {
    $search_param = "%" . $search . "%";
    $count_query = "SELECT COUNT(*) as total FROM patinte WHERE fname LIKE ?";
    $data_query = "SELECT pat_id, fname, age, phone, gander, date_com 
                   FROM patinte 
                   WHERE fname LIKE ? 
                   ORDER BY pat_id DESC 
                   LIMIT ? OFFSET ?";
} else {
    $count_query = "SELECT COUNT(*) as total FROM patinte";
    $data_query = "SELECT pat_id, fname, age, phone, gander, date_com 
                   FROM patinte 
                   ORDER BY pat_id DESC 
                   LIMIT ? OFFSET ?";
}

// حساب إجمالي الصفحات
if (!empty($search)) {
    $stmt_count = $conn->prepare($count_query);
    $stmt_count->bind_param("s", $search_param);
} else {
    $stmt_count = $conn->prepare($count_query);
}
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$total_row = $result_count->fetch_assoc();
$total = $total_row['total'];
$pages = ceil($total / $limit);

if ($page > $pages && $pages > 0) { $page = $pages; }
$offset = ($page - 1) * $limit;

// جلب بيانات المرضى
if (!empty($search)) {
    $stmt = $conn->prepare($data_query);
    $stmt->bind_param("sii", $search_param, $limit, $offset);
} else {
    $stmt = $conn->prepare($data_query);
    $stmt->bind_param("ii", $limit, $offset);
}
$stmt->execute();
$result = $stmt->get_result();

$patients = [];
while($row = $result->fetch_assoc()) {
    $patients[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>قائمة المرضى</title>

    <!-- روابط Bootstrap و Font Awesome (تأكد أنها متواجدة) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- استيراد خط Tajawal من Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;700;900&display=swap" rel="stylesheet">
    
    <style>
        /******************************/
        /*** تنسيق الصفحة الأساسية ***/
        /******************************/
        body {
            font-family: 'Tajawal', sans-serif;
            background: url('https://images.unsplash.com/photo-1659536412255-a232f5d69968?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8YmFja2dyb3VuZCUyMGNsYXNzeXxlbnwwfHwwfHx8MA%3D%3D&auto=format&fit=crop&w=1400&q=80') 
                        center center / cover no-repeat;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            color: #333;
            /* ملاحظة: سنضيف الـsidebar ثُم نعدّل الحواف */
        }

        /* الطبقة الشفافة للمحتوى الرئيسي */
        main.container {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.25);
            border-radius: 15px;
            padding: 20px;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        /******************************/
        /*** تنسيق الجداول والعناصر ***/
        /******************************/
        .table-container {
            border-radius: 12px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.45);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .table thead th {
            vertical-align: middle;
            text-align: center;
            background-color: #354259 !important;
            color: #fff !important;
            border: none !important;
        }
        .table tbody td {
            vertical-align: middle;
            text-align: center;
            color: #333;
            background-color: rgba(255, 255, 255, 0.45);
        }
        .table tbody tr:hover {
            background-color: rgba(53, 66, 89, 0.1);
        }

        /* الأزرار */
        .btn-success, .btn-primary, .btn-book-session {
            border: none;
            outline: none;
            transition: all 0.3s ease-in-out;
            font-weight: 600;
        }
        .btn-success {
            background-color: #00c897;
        }
        .btn-success:hover {
            background-color: #00b388;
            transform: scale(1.02);
        }
        .btn-primary {
            background-color: #219ebc;
        }
        .btn-primary:hover {
            background-color: #1b869c;
            transform: scale(1.02);
        }
        .btn-secondary:hover {
            transform: scale(1.02);
        }
        .btn-book-session {
            background-color: #f0ad4e;
            color: #fff;
        }
        .btn-book-session:hover {
            background-color: #ec971f;
            transform: scale(1.02);
        }

        /* الرسائل */
        .success-message, .error-message {
            margin: 15px 0;
            border-radius: 8px;
            padding: 15px;
        }

        /* البحث */
        .search-bar {
            position: relative;
        }
        .search-bar i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #6c757d;
        }
        .search-bar input {
            padding-left: 40px;
            border-radius: 20px;
            transition: box-shadow 0.3s ease-in-out;
            border: 1px solid #ced4da;
        }
        .search-bar input:focus {
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }

        /* الترقيم */
        .pagination {
            justify-content: center;
        }
        .page-item .page-link {
            border-radius: 50%;
            margin: 0 3px;
            transition: background-color 0.3s ease-in-out;
            color: #333;
        }
        .page-item.active .page-link {
            background-color: #354259 !important;
            border-color: #354259 !important;
            color: #fff !important;
        }
        .page-item .page-link:hover {
            background-color: #219ebc !important;
            border-color: #219ebc !important;
            color: #fff !important;
        }

        /* تكبير الأيقونات */
        .fa {
            transition: transform 0.3s;
        }
        .fa:hover {
            transform: scale(1.2);
        }

        /******************************/
        /*** تنسيق الـSidebar الجديد ***/
        /******************************/
        /* Sidebar container */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100vh;
            background-color: #2c3e50; /* لون خلفية الشريط الجانبي */
            color: #fff;
            transition: all 0.3s;
            z-index: 999;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        #sidebar.active {
            margin-left: -240px; /* إخفاء الشريط الجانبي عند التفعيل في الجوال */
        }
        .sidebar-header {
            padding: 1.5rem 1rem;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 1.25rem;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .nav-links {
            flex-grow: 1;
            padding-top: 1rem;
        }
        .nav-links a {
            display: block;
            padding: 0.75rem 1rem;
            color: #fff;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
            font-size: 0.95rem;
        }
        .nav-links a:hover {
            background-color: #34495e; 
            text-decoration: none;
            color: #fff;
        }

        /* Top Navbar (خاص بالشريط العلوي إن أحببت استخدامه) */
        .navbar-custom {
            margin-left: 240px; /* تباعد عن اليسار بمقدار عرض الـSidebar */
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            transition: margin-left 0.3s;
            z-index: 998;
        }

        /* محتوى الصفحة يتحرك لليمين/اليسار حسب الشريط الجانبي */
        #content {
            margin-left: 240px;
            padding: 2rem;
            transition: margin-left 0.3s;
            min-height: 100vh; /* لجعل المحتوى يأخذ كامل الارتفاع */
        }

        /* وسائط العرض الصغيرة */
        @media (max-width: 767.98px) {
            #sidebar {
                margin-left: -240px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            .navbar-custom {
                margin-left: 0;
            }
            #content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<?php include __DIR__ . '/includes/sidebar.php'; ?>
<!-- 
    ملاحظة: يجب أن يكون لديك ملف sidebar.php داخل المجلد (includes/sidebar.php) 
    أو عدّل المسار حسب موقع ملفك 
-->

<!-- إذا أردت استخدام الـNavbar العلوية الخاصة بالSidebar، يمكنك تفعيل الكود أدناه:
<nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
  <div class="container-fluid">
    <button class="btn btn-outline-secondary ms-2" id="toggleSidebar">
      <i class="fas fa-bars"></i>
    </button>
    <a class="navbar-brand ms-3" href="#">Brand New Panel</a>
  </div>
</nav>
-->

<!-- هناnavbar.php الخاصة بك (إن أردت الإبقاء عليها) -->
<!-- تم تضمينها مسبقًا في أعلى الصفحة عبر include 'includes/templates/navbar.php'; -->

<!-- Main Content Wrapper -->
<div id="content">
    <!-- المحتوى الأصلي للصفحة (الذي كان ضمن <main class="container">) -->
    <main class="container">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h2 class="text-center mb-3 mb-md-0">
                    <i class="fa-solid fa-notes-medical me-2"></i> قائمة المرضى
                </h2>
                <button class="btn btn-success add-btn" data-bs-toggle="modal" data-bs-target="#addPatientModal">
                    <i class="fa-solid fa-user-plus me-1"></i> إضافة مريض جديد
                </button>
            </div>

            <!-- رسائل نجاح/خطأ -->
            <?php 
                if(isset($_GET['success']) && $_GET['success'] == 1) {
                    echo "<div class='alert alert-success text-center success-message'><i class='fa-solid fa-circle-check me-2'></i> تم حفظ المريض بنجاح.</div>";
                }
                if(isset($_GET['update_success']) && $_GET['update_success'] == 1) {
                    echo "<div class='alert alert-success text-center success-message'><i class='fa-solid fa-circle-check me-2'></i> تم تحديث بيانات المريض بنجاح.</div>";
                }
                if(isset($_GET['booking_success']) && $_GET['booking_success'] == 1) {
                    echo "<div class='alert alert-success text-center success-message'><i class='fa-solid fa-circle-check me-2'></i> تم حجز الجلسة بنجاح سيتم تحويلك الى صفحة الطباعة</div>";
                }
                if(isset($_GET['booking_error']) && $_GET['booking_error'] == 1) {
                    echo "<div class='alert alert-danger text-center error-message'><i class='fa-solid fa-circle-exclamation me-2'></i> حدث خطأ أثناء حجز الجلسة.</div>";
                }
            ?>

            <!-- شريط البحث -->
            <form method="GET" action="patients.php" class="mb-3 search-bar d-flex">
                <i class="fa fa-search mt-2 me-2"></i>
                <input type="text" name="search" class="form-control me-2" placeholder="ابحث عن مريض.." 
                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="btn btn-primary me-2">بحث</button>
                <a href="patients.php" class="btn btn-secondary">مسح البحث</a>
            </form>

            <!-- الجدول -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0" id="myTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>الاسم الكامل</th>
                            <th>العمر</th>
                            <th>رقم الهاتف</th>
                            <th>الجنس</th>
                            <th>تاريخ التسجيل</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if(empty($patients)){
                            echo "<tr><td colspan='7' class='text-center'>لا توجد سجلات لعرضها.</td></tr>";
                        } else {
                            foreach($patients as $row){
                                echo "<tr id='row_" . htmlspecialchars($row['pat_id']) . "'>";
                                echo "<td>" . htmlspecialchars($row['pat_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['fname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                                echo "<td>" . ($row['gander'] === 'M' ? 'ذكر' : 'أنثى') . "</td>";
                                echo "<td>" . htmlspecialchars($row['date_com']) . "</td>";
                                echo "<td>";
                                echo "<button class='btn btn-primary btn-sm edit-btn me-1' data-patient-id='" . htmlspecialchars($row['pat_id']) . "' data-bs-toggle='modal' data-bs-target='#editPatientModal'>
                                        <i class='fa-solid fa-pen-to-square'></i> تعديل
                                      </button>";
                                echo "<button class='btn btn-book-session btn-sm book-session-btn' data-patient-id='" . htmlspecialchars($row['pat_id']) . "' data-patient-name='" . htmlspecialchars($row['fname']) . "'>
                                        <i class='fa-solid fa-calendar-plus'></i> حجز جلسة
                                      </button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- التصفح -->
            <?php if($pages > 1): ?>
            <nav aria-label="Page navigation" class="mt-3">
                <ul class="pagination">
                    <!-- زر الصفحة الأولى -->
                    <?php if($page > 3): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=1<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" aria-label="الأولى">
                                <span aria-hidden="true">&laquo;&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- زر السابق -->
                    <?php if($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page-1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" aria-label="السابق">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link" aria-label="السابق">
                                <span aria-hidden="true">&laquo;</span>
                            </span>
                        </li>
                    <?php endif; ?>

                    <!-- نطاق الصفحات حول الصفحة الحالية -->
                    <?php 
                    $range = 2;
                    for($i = max(1, $page - $range); $i <= min($pages, $page + $range); $i++): 
                    ?>
                        <li class="page-item <?php if($i == $page) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- زر التالي -->
                    <?php if($page < $pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page+1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" aria-label="التالي">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="page-item disabled">
                            <span class="page-link" aria-label="التالي">
                                <span aria-hidden="true">&raquo;</span>
                            </span>
                        </li>
                    <?php endif; ?>

                    <!-- زر الصفحة الأخيرة -->
                    <?php if($page < $pages - 2): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $pages; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>" aria-label="الأخيرة">
                                <span aria-hidden="true">&raquo;&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
            <?php endif; ?>
        </div>
    </main>
</div><!-- نهاية #content -->

<!-- مودالات الإضافة والتعديل والحجز -->
<?php include 'add_patient_modal.php'; ?>
<?php include 'edit_patient_modal.php'; ?>

<div class="modal fade" id="bookSessionModal" tabindex="-1" aria-labelledby="bookSessionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="bookSessionForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookSessionModalLabel">حجز جلسة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="book_pat_id" name="pat_id">
                    <div class="mb-3">
                        <label for="book_fname" class="form-label">الاسم الكامل</label>
                        <input type="text" class="form-control" id="book_fname" name="fname" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="book_session_price" class="form-label">سعر الجلسة (بالريال اليمني)</label>
                        <input type="number" class="form-control" id="book_session_price" name="session_price" value="3000" readonly>
                    </div>
                    <!-- حقول إضافية إذا رغبت -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">تأكيد الحجز</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap Bundle JS و FontAwesome JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>

<script>
    // Toggle Sidebar Script
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("toggleSidebar");
        const sidebar = document.getElementById("sidebar");
        const content = document.getElementById("content");

        if (toggleBtn) {
            toggleBtn.addEventListener("click", function () {
                sidebar.classList.toggle("active");
                if (sidebar.classList.contains("active")) {
                    // Sidebar hidden
                    content.style.marginLeft = "0";
                } else {
                    // Sidebar visible
                    content.style.marginLeft = "240px";
                }
            });
        }
    });

    // Flags to track manual date changes
    let addBirthdayManuallySet = false;
    let editBirthdayManuallySet = false;

    // Calculate birthdate
    function calculateBirthdate(age, birthdayInputId) {
        const currentYear = new Date().getFullYear();
        const birthYear = currentYear - age;
        const birthdayInput = document.getElementById(birthdayInputId);
        birthdayInput.value = `${birthYear}-01-01`;
    }

    document.getElementById('birthdaytime').addEventListener('change', function() {
        addBirthdayManuallySet = true;
    });
    document.getElementById('edit_birthdaytime').addEventListener('change', function() {
        editBirthdayManuallySet = true;
    });

    document.getElementById('age').addEventListener('input', function() {
        const age = parseInt(this.value);
        if (!isNaN(age) && age > 0 && !addBirthdayManuallySet) {
            calculateBirthdate(age, 'birthdaytime');
        }
    });
    document.getElementById('edit_age').addEventListener('input', function() {
        const age = parseInt(this.value);
        if (!isNaN(age) && age > 0 && !editBirthdayManuallySet) {
            calculateBirthdate(age, 'edit_birthdaytime');
        }
    });

    // Add Patient AJAX
    document.getElementById('addPatientForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('process_add_patient.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                alert('تم إضافة المريض بنجاح.');
                const addModal = new bootstrap.Modal(document.getElementById('addPatientModal'));
                addModal.hide();
                window.location.href = 'index.php?success=1';
            } else {
                alert('حدث خطأ: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء إرسال البيانات.');
        });
    });

    // Edit Patient AJAX
    document.getElementById('editPatientForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('process_edit_patient.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                alert('تم تعديل بيانات المريض بنجاح.');
                const editModal = new bootstrap.Modal(document.getElementById('editPatientModal'));
                editModal.hide();
                window.location.href = 'index.php?update_success=1';
            } else {
                alert('حدث خطأ: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء إرسال البيانات.');
        });
    });

    // Fetch patient data for edit
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', () => {
            const pat_id = button.getAttribute('data-patient-id');
            fetch(`get_patient.php?pat_id=${pat_id}`)
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    const patient = data.patient;
                    document.getElementById('edit_pat_id').value = patient.pat_id;
                    const nameParts = patient.fname.split(' ');
                    document.getElementById('edit_first_name').value = nameParts[0] || '';
                    document.getElementById('edit_middle_name').value = nameParts[1] || '';
                    document.getElementById('edit_third_name').value = nameParts[2] || '';
                    document.getElementById('edit_last_name').value = nameParts[3] || '';
                    document.getElementById('edit_age').value = patient.age;
                    document.getElementById('edit_phone').value = patient.phone;
                    document.getElementById('edit_gander').value = patient.gander;
                    document.getElementById('edit_birthdaytime').value = patient.birthdaytime;
                    editBirthdayManuallySet = false; 
                } else {
                    alert('حدث خطأ في جلب بيانات المريض.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ أثناء جلب بيانات المريض.');
            });
        });
    });

    // Book Session
    const bookSessionModal = new bootstrap.Modal(document.getElementById('bookSessionModal'));
    const bookSessionForm = document.getElementById('bookSessionForm');

    document.querySelectorAll('.book-session-btn').forEach(button => {
        button.addEventListener('click', () => {
            const pat_id = button.getAttribute('data-patient-id');
            const fname = button.getAttribute('data-patient-name');
            document.getElementById('book_pat_id').value = pat_id;
            document.getElementById('book_fname').value = fname;
            document.getElementById('book_session_price').value = 3000; 
            bookSessionModal.show();
        });
    });

    bookSessionForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch('process_book_session.php', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if(data.success){
                bookSessionModal.hide();
                alert('تم حجز الجلسة بنجاح سيتم تحويلك الى صفحة الطباعة');
                window.open(data.invoice_url, '_blank');
            } else {
                alert('حدث خطأ: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء إرسال البيانات: ' + error.message);
        });
    });
</script>

</body>
</html>
