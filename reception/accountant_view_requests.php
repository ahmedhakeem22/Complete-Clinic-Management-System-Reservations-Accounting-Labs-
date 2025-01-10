<?php
// accountant_view_requests.php
session_start(); // بدء الجلسة
include '../includes/db.php'; // تضمين ملف الاتصال بقاعدة البيانات

// معالجة طلب تأكيد الدفع
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_payment'])) {
    $reqId = intval($_POST['request_id']);
    
    // 1) قراءة معلومات الطلب
    $sqlReq = "SELECT lr.*, p.fname
               FROM lab_requests lr
               JOIN patinte p ON lr.pat_id = p.pat_id
               WHERE lr.request_id = ?";
    $stmtReq = $conn->prepare($sqlReq);
    $stmtReq->bind_param("i", $reqId);
    $stmtReq->execute();
    $resReq = $stmtReq->get_result();
    $reqData = $resReq->fetch_assoc();
    
    if ($reqData) {
        // تحديث الحالة إلى 'paid'
        $upd = $conn->prepare("UPDATE lab_requests SET status='paid' WHERE request_id=?");
        $upd->bind_param("i", $reqId);
        $upd->execute();

        // إدخال سجل الفاتورة في جدول invoice
        date_default_timezone_set("Asia/Aden");
        $invoice_date = date("Y-m-d");
        $pat_id   = $reqData['pat_id'];
        $fname    = $reqData['fname'];
        $name_ser = "Blood Tests";    // أو "Lab Request #$reqId"
        $cost_ser = $reqData['total_cost'];

        $stmt_invoice = $conn->prepare("
            INSERT INTO invoice (pat_id, name_ser, cost_ser, invoice_date, fname, request_id)
            VALUES (?,?,?,?,?,?)
        ");
        $stmt_invoice->bind_param("issssi", 
            $pat_id, 
            $name_ser, 
            $cost_ser, 
            $invoice_date, 
            $fname, 
            $reqId
        );
        $stmt_invoice->execute();
        $newInvoiceId = $stmt_invoice->insert_id;

        // تخزين الرسالة ومعرف الفاتورة في الجلسة
        $_SESSION['success_message'] = "تم تأكيد الدفع بنجاح للطلب رقم " . $reqId;
        $_SESSION['invoice_id'] = $newInvoiceId;

        // إعادة التوجيه إلى نفس الصفحة لتطبيق نمط PRG
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// جلب الطلبات الجديدة (status='new')
$sql = "SELECT lr.*, p.fname 
        FROM lab_requests lr
        JOIN patinte p ON lr.pat_id = p.pat_id
        WHERE lr.status='new'
        ORDER BY lr.request_id DESC";
$res = $conn->query($sql);

// جلب عدد الطلبات لليوم
$sql_today = "SELECT COUNT(*) as count_today FROM lab_requests WHERE DATE(request_date) = CURDATE()";
$result_today = $conn->query($sql_today);
$count_today = $result_today->fetch_assoc()['count_today'] ?? 0;

// جلب عدد الطلبات المكتملة
$sql_completed = "SELECT COUNT(*) as count_completed FROM lab_requests WHERE status='completed'";
$result_completed = $conn->query($sql_completed);
$count_completed = $result_completed->fetch_assoc()['count_completed'] ?? 0;

// جلب عدد الطلبات غير المدفوعة (status='new')
$sql_unpaid = "SELECT COUNT(*) as count_unpaid FROM lab_requests WHERE status='new'";
$result_unpaid = $conn->query($sql_unpaid);
$count_unpaid = $result_unpaid->fetch_assoc()['count_unpaid'] ?? 0;
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>قائمة الطلبات الجديدة</title>
    <!-- ربط Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- إضافة أيقونات Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts (اختياري) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* تخصيص لوحة الألوان */
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --accent-color: #198754;
            --background-color: #f8f9fa;
            --text-color: #212529;
            --card-bg: #ffffff;
            --navbar-bg:rgb(95, 178, 233); /* تغيير لون النافبار إلى الأزرق الفاتح */
            --navbar-text: #ffffff;
            --header-height: 70px; /* ارتفاع الرأس */
            --sidebar-width: 240px; /* عرض الشريط الجانبي */
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

       

        .nav-links {
            flex-grow: 1;
            padding-top: 1rem;
        }

        .nav-links a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            color: #fff;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
            font-size: 0.95rem;
        }

        .nav-links a i {
            margin-right: 10px;
        }

        .nav-links a:hover {
            background-color: #34495e; 
            color: #fff;
        }

        /* رأس الصفحة */
        .navbar-custom {
            background-color: var(--navbar-bg);
            height: var(--header-height);
            position: fixed;
            top: 0;
            left: var(--sidebar-width);
            right: 0;
            z-index: 1100;
            display: flex;
            align-items: center;
            padding: 0 20px;
            box-shadow: 0 2px 4px rgba(255, 255, 255, 0.1);
        }

        .navbar-custom .navbar-brand {
            color: var(--navbar-text);
            font-size: 1.5rem;
            text-decoration: none;
        }

        .navbar-custom .navbar-text {
            margin-left: auto;
            color: var(--navbar-text);
            display: flex;
            align-items: center;
        }

        .navbar-custom .navbar-text i {
            margin-right: 5px;
        }

        /* المحتوى الرئيسي */
        .main-content {
            margin-top: var(--header-height);
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: margin-left 0.3s;
        }

        /* بطاقات المعلومات */
        .info-card {
            background-color: var(--card-bg);
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            padding: 20px;
            text-align: center;
        }

        .info-card:hover {
            transform: translateY(-5px);
        }

        .info-card i {
            font-size: 2.5rem;
            margin-bottom: 10px;
            color: var(--primary-color);
        }

        /* تحسين جداول Bootstrap */
        table thead th {
            background-color: var(--primary-color);
            color: #ffffff;
            text-align: center;
        }

        table tbody td {
            vertical-align: middle;
        }

        /* تحسين أزرار المودال */
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
            background-color: #146c43;
            border-color: #146c43;
        }

        /* تحسين أزرار التأكيد */
        .btn-confirm {
            background-color: var(--primary-color);
            color: #ffffff;
        }

        .btn-confirm:hover {
            background-color: #0b5ed7;
            color: #ffffff;
        }

        /* تحسين شارات الحالة */
        .badge-status {
            font-size: 0.9em;
        }

        /* تحسين تصميم الإشعارات */
        .alert-custom {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        /* تحسين تصميم المودال */
        .modal-content {
            border-radius: 15px;
        }

          /* Sidebar */
      #sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 240px;
      height: 100vh;
      background-color: #2c3e50; /* Dark blue-gray */
      color: #fff;
      transition: all 0.3s;
      z-index: 999;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .sidebar-header {
      padding: 1.5rem 1rem;
      text-transform: uppercase;
      font-weight: 600;
      font-size: 1.25rem;
      letter-spacing: 1px;
      border-bottom: 1px solid rgb(180, 54, 54);
    }

    /* Sidebar Collapse for mobile */
    #sidebar.active {
      margin-left: -240px;
    }


    /* Mobile Media Query */
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
      footer.footer {
        left: 0;
        width: 100%;
      }
    }
    </style>
</head>
<body>

    <!-- شريط التنقل الجانبي -->
    <?php include __DIR__ . '/includes/sidebar.php'; ?>

    <!-- رأس الصفحة -->
  </nav>
    <nav class="navbar navbar-custom">
        <a class="navbar-brand" href="#"><i class="fas fa-clipboard-list me-2"></i> Blood tests</a>
        <div class="navbar-text">
            <i class="fas fa-bell me-2"></i>
            <i class="fas fa-user-circle me-2"></i> admin
        </div>
    </nav>

    <!-- المحتوى الرئيسي -->
    <div class="main-content">
        <!-- بطاقات عرض المعلومات -->
        <div class="row mb-4">
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="info-card">
                    <i class="fas fa-calendar-day"></i>
                    <h5>طلبات اليوم</h5>
                    <h3><?= htmlspecialchars($count_today) ?></h3>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="info-card">
                    <i class="fas fa-check-circle"></i>
                    <h5>الطلبات المكتملة</h5>
                    <h3><?= htmlspecialchars($count_completed) ?></h3>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-3">
                <div class="info-card">
                    <i class="fas fa-times-circle"></i>
                    <h5>الطلبات غير المدفوعة</h5>
                    <h3><?= htmlspecialchars($count_unpaid) ?></h3>
                </div>
            </div>
        </div>

        <!-- عنوان المحتوى -->
        <div class="text-center mb-5">
            <h1 class="display-4 text-primary"><i class="fas fa-clipboard-list me-2"></i> قائمة الطلبات الجديدة</h1>
            <p class="lead text-muted">هنا يمكنك تأكيد المدفوعات للطلبات التي لم تُدفع بعد.</p>
        </div>

        <?php
        // عرض رسالة النجاح إذا كانت موجودة
        if (isset($_SESSION['success_message'])):
        ?>
            <div class="alert alert-success alert-dismissible fade show alert-custom" role="alert">
                <?= htmlspecialchars($_SESSION['success_message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <script>
                // فتح صفحة الفاتورة في تبويب جديد بعد تحميل الصفحة
                window.addEventListener('load', function() {
                    window.open("choess_blood_box_pdf.php?invoice_id=<?= $_SESSION['invoice_id'] ?>", "_blank");
                });
            </script>
        <?php
            // إزالة الرسائل من الجلسة بعد العرض
            unset($_SESSION['success_message']);
            unset($_SESSION['invoice_id']);
        endif;
        ?>

        <?php if ($res->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>اسم المريض</th>
                            <th>تاريخ الطلب</th>
                            <th>التكلفة الإجمالية</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $res->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['request_id']) ?></td>
                            <td><?= htmlspecialchars($row['fname']) ?></td>
                            <td><?= htmlspecialchars(date("d-m-Y H:i", strtotime($row['request_date']))) ?></td>
                            <td><?= htmlspecialchars(number_format($row['total_cost'], 2)) ?> <span class="text-muted">ريال يمني</span></td>
                            <td>
                                <span class="badge bg-warning text-dark badge-status">جديد</span>
                            </td>
                            <td>
                                <!-- زر يفتح مودال التفاصيل -->
                                <button 
                                    class="btn btn-info btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#detailsModal" 
                                    data-requestid="<?= htmlspecialchars($row['request_id']) ?>"
                                >
                                    <i class="fas fa-eye"></i> تفاصيل
                                </button>
                                <!-- زر تأكيد الدفع -->
                                <form method="POST" action="" class="d-inline">
                                    <input type="hidden" name="request_id" value="<?= htmlspecialchars($row['request_id']) ?>">
                                    <button type="submit" name="confirm_payment" class="btn btn-success btn-sm" onclick="return confirm('هل أنت متأكد من تأكيد الدفع لهذا الطلب؟');">
                                        <i class="fas fa-check-circle"></i> تأكيد الدفع
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-clipboard-list fa-2x" style="color:var(--secondary-color);"></i>
                <h4 class="mt-3">لا توجد طلبات جديدة حالياً.</h4>
                <p>يرجى المحاولة لاحقاً.</p>
            </div>
        <?php endif; ?>
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
            <!-- سيتم التحميل بالـ AJAX -->
            <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                <div class="spinner-border text-primary" role="status">
                  <span class="visually-hidden">جارٍ التحميل...</span>
                </div>
                <span class="ms-3">جارٍ التحميل...</span>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
          </div>
        </div>
      </div>
    </div>

    <!-- ربط Bootstrap JS و Font Awesome JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // تفعيل تحميل تفاصيل الطلب عند فتح المودال
    var detailsModal = document.getElementById('detailsModal');
    detailsModal.addEventListener('show.bs.modal', function (event) {
      var button = event.relatedTarget;
      var requestId = button.getAttribute('data-requestid');
      var modalTitle = detailsModal.querySelector('.modal-title');
      var detailsContent = document.getElementById('detailsContent');

      // تعيين عنوان المودال
      modalTitle.textContent = "تفاصيل الطلب رقم " + requestId;

      // عرض مؤشر التحميل
      detailsContent.innerHTML = `
          <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
              <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">جارٍ التحميل...</span>
              </div>
              <span class="ms-3">جارٍ التحميل...</span>
          </div>
      `;

      // جلب تفاصيل الطلب باستخدام AJAX
      fetch('ajax_get_request_details.php?request_id=' + requestId)
        .then(response => response.text())
        .then(data => {
          detailsContent.innerHTML = data;
        })
        .catch(err => {
          detailsContent.innerHTML = `
              <div class="alert alert-danger text-center" role="alert">
                  حدث خطأ أثناء جلب التفاصيل. يرجى المحاولة مرة أخرى.
              </div>
          `;
        });
    });
    </script>
</body>
</html>

<?php
// إغلاق الاتصال بقاعدة البيانات إذا لزم الأمر
$conn->close();
?>
