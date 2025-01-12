<?php
// lab_view_requests.php
session_start();
include '../includes/db.php';
include 'includes/templates/header.php';

// التعامل مع النموذج باستخدام نمط PRG
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finish_tests'])) {
    $reqId = intval($_POST['request_id']);
    $stmt = $conn->prepare("UPDATE lab_requests SET status='completed' WHERE request_id=?");
    $stmt->bind_param("i", $reqId);
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "تم تأكيد الانتهاء للطلب رقم $reqId";
    } else {
        $_SESSION['error_message'] = "حدث خطأ أثناء تأكيد الانتهاء للطلب رقم $reqId";
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// جلب الطلبات المدفوعة
$sql = "SELECT lr.*, p.fname 
        FROM lab_requests lr
        JOIN patinte p ON lr.pat_id = p.pat_id
        WHERE lr.status='paid'
        ORDER BY lr.request_id DESC";
$res = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>قائمة الطلبات المدفوعة</title>
    <!-- ربط Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- إضافة أيقونات Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        /* تخصيص لوحة الألوان */
        :root {
            --primary-color: #4A90E2;
            --secondary-color: #50E3C2;
            --accent-color: #F5A623;
            --background-color: #F7F9FC;
            --text-color: #333333;
            --card-bg: #ffffff;
            --sidebar-bg: #343A40;
            --sidebar-text: #ffffff;
            --header-bg: #ffffff;
            --header-text: #333333;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* شريط جانبي */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            padding-top: 60px;
            transition: all 0.3s;
        }

        .sidebar a {
            color: var(--sidebar-text);
            text-decoration: none;
            display: block;
            padding: 15px 20px;
            transition: background 0.3s;
        }

        .sidebar a:hover {
            background-color: var(--primary-color);
        }

        /* رأس الصفحة */
        .header {
            margin-left: 250px;
            padding: 20px;
            background-color: var(--header-bg);
            color: var(--header-text);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            width: calc(100% - 250px);
            z-index: 1000;
        }

        /* المحتوى الرئيسي */
        .main-content {
            margin-left: 250px;
            padding: 100px 20px 20px 20px;
        }

        /* بطاقات المعلومات */
        .info-card {
            background-color: var(--card-bg);
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .info-card:hover {
            transform: translateY(-5px);
        }

        /* تخصيص الجداول */
        table thead {
            background-color: var(--primary-color);
            color: #ffffff;
        }

        table tbody tr:nth-child(even) {
            background-color: #e9f3fb;
        }

        /* تخصيص المودال */
        .modal-header {
            background-color: var(--secondary-color);
            color: #ffffff;
        }

        .modal-footer .btn-secondary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: #ffffff;
        }

        .modal-footer .btn-secondary:hover {
            background-color: #e5941f;
            border-color: #e5941f;
        }

        /* أيقونات الشارات */
        .badge-primary {
            background-color: var(--primary-color);
        }

        .badge-secondary {
            background-color: var(--secondary-color);
        }

        .badge-accent {
            background-color: var(--accent-color);
            color: #ffffff;
        }

        /* حالة عدم وجود طلبات */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 60vh;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: var(--secondary-color);
        }

        /* استجابة التصميم */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .header {
                margin-left: 0;
                width: 100%;
            }
            .main-content {
                margin-left: 0;
                padding: 100px 10px 10px 10px;
            }
        }
    </style>
</head>
<body>

    <!-- الشريط الجانبي -->
    <div class="sidebar">
        <a href="lab2.php"><i class="bi bi-house-door-fill me-2"></i> الصفحة الرئيسية</a>
        <a href="lab_view_requests.php"><i class="bi bi-list-check me-2"></i> إدارة الطلبات</a>
        <a href="manage_tests.php"><i class="bi bi-gear-fill me-2"></i> الإعدادات</a>
        <a href="login.php"><i class="bi bi-box-arrow-right me-2"></i> تسجيل الخروج</a>
    </div>

    <!-- رأس الصفحة -->
    <div class="header d-flex justify-content-between align-items-center">
        <h2>نظام إدارة الطلبات المختبرية</h2>
        <div>
            <span class="me-3"><i class="bi bi-bell-fill"></i></span>
            <span><i class="bi bi-person-circle"></i> المدير</span>
        </div>
    </div>

    <!-- المحتوى الرئيسي -->
    <div class="main-content">
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card info-card text-white">
                    <div class="card-body bg-primary">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="card-title">الطلبات المدفوعة</h5>
                                <h3><?= $res->num_rows ?></h3>
                            </div>
                            <div>
                                <i class="bi bi-wallet2" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- يمكنك إضافة المزيد من البطاقات هنا -->
        </div>

        <!-- عرض رسائل النجاح أو الخطأ -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_SESSION['error_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <!-- قائمة الطلبات -->
        <div class="card shadow-lg">
            <div class="card-header">
                <h5 class="mb-0">الطلبات المدفوعة (في انتظار الفحوصات)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php if ($res->num_rows > 0): ?>
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>معرف المريض</th>
                                    <th>اسم المريض</th>
                                    <th>تاريخ الطلب</th>
                                    <th>الحالة</th>
                                    <th>إجراءات</th>
                                    <th class="text-center">رقم الطلب</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $res->fetch_assoc()): ?>
                                    <tr>
                                        <td ><?= htmlspecialchars($row['pat_id']) ?></td>
                                        <td><?= htmlspecialchars($row['fname']) ?></td>
                                        <td><?= htmlspecialchars(date("d-m-Y H:i", strtotime($row['request_date']))) ?></td>
                                        <td>
                                            <span class="badge badge-secondary"><?= htmlspecialchars($row['status']) ?></span>
                                        </td>
                                        <td>
                                            <button 
                                                class="btn btn-info btn-sm"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailsModal" 
                                                data-request-id="<?= htmlspecialchars($row['request_id']) ?>"
                                            >
                                                <i class="bi bi-eye-fill"></i> عرض
                                            </button>
                                        </td>
                                        <td class="text-center"><?= htmlspecialchars($row['request_id']) ?></td>

                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="bi bi-emoji-smile-fill"></i>
                            <h4>لا توجد طلبات مدفوعة حالياً.</h4>
                            <p>يرجى المحاولة لاحقاً.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- مودال التفاصيل -->
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="detailsModalLabel">تفاصيل الطلب</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
          </div>
          <div class="modal-body" id="detailsContent">
            <div class="text-center my-5">
                <div class="spinner-border text-secondary" role="status">
                  <span class="visually-hidden">جارٍ التحميل...</span>
                </div>
                <p class="mt-3">جارٍ التحميل...</p>
            </div>
          </div>
          <div class="modal-footer">
            <form method="post" action="" class="me-auto">
                <input type="hidden" name="request_id" id="hiddenRequestId" value="">
                <button type="submit" name="finish_tests" class="btn btn-success">
                    <i class="bi bi-check-circle-fill"></i> تم الانتهاء
                </button>
            </form>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="bi bi-x-circle-fill"></i> إغلاق
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- ربط Bootstrap JS و Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var detailsModal = document.getElementById('detailsModal');
        detailsModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var requestId = button.getAttribute('data-request-id');

            document.getElementById('hiddenRequestId').value = requestId;

            document.getElementById('detailsContent').innerHTML = `
                <div class="text-center my-5">
                    <div class="spinner-border text-secondary" role="status">
                      <span class="visually-hidden">جارٍ التحميل...</span>
                    </div>
                    <p class="mt-3">جارٍ التحميل...</p>
                </div>
            `;

            // تعديل مسار الـ fetch إذا كان ملف AJAX في مجلد مختلف
            fetch('ajax_get_request_details.php?request_id=' + requestId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.text();
                })
                .then(data => {
                    document.getElementById('detailsContent').innerHTML = data;
                })
                .catch(err => {
                    console.error('Error fetching request details:', err);
                    document.getElementById('detailsContent').innerHTML = `
                        <div class="alert alert-danger text-center" role="alert">
                            حدث خطأ أثناء جلب التفاصيل. يرجى المحاولة مرة أخرى.
                        </div>
                    `;
                });
        });
    });
    </script>

    <?php
    // إغلاق الاتصال بقاعدة البيانات إذا لزم الأمر
    $conn->close();
    ?>
</body>
</html>
