<?php
include 'templats/header.php';
include 'templats/navbar.php';
require_once '../includes/db.php'; // تأكد من أن مسار ملف قاعدة البيانات صحيح

// جلب الوصفات الطبية قيد الانتظار
$query = "SELECT id, pat_id, fname, date_t FROM prescriptions WHERE status = 'pending' ORDER BY date_t DESC";
$result = $conn->query($query);

if (!$result) {
    die("خطأ في جلب الوصفات الطبية: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>واجهة الصيدلي</title>
    <!-- تضمين Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- تضمين Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- أيقونات إضافية -->
    <style>
        body {
            background-color: #eef2f3;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .table-container {
            margin-top: 40px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            padding: 30px;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 30px;
        }
        .table thead {
            background-color: #2c3e50;
            color: #ffffff;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }
        .btn-primary {
            background-color: #2980b9;
            border-color: #2980b9;
        }
        .btn-primary:hover {
            background-color: #1c5980;
            border-color: #145374;
        }
        /* تحسين تصميم النافذة المنبثقة */
        .modal-header {
            background-color: #2980b9;
            color: #ffffff;
            border-bottom: none;
        }
        .modal-footer {
            border-top: none;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="table-container">
            <h1 class="text-center">الوصفات الطبية الجديدة</h1>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>رقم الوصفة</th>
                            <th>رقم المريض</th>
                            <th>اسم المريض</th>
                            <th>التاريخ</th>
                            <th>الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['pat_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['fname']); ?></td>
                                <td><?php echo htmlspecialchars(date("d-m-Y", strtotime($row['date_t']))); ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm view-details-btn" data-id="<?php echo $row['id']; ?>">
                                        <i class="fas fa-eye"></i> تفاصيل
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">لا توجد وصفات طبية قيد الانتظار.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- نافذة منبثقة لعرض تفاصيل الوصفة -->
    <div class="modal fade" id="prescriptionModal" tabindex="-1" role="dialog" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- سيتم تحميل المحتوى عبر AJAX -->
                <div class="text-center my-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">جار التحميل...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- تضمين jQuery و Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
    $(document).ready(function(){
        $('.view-details-btn').on('click', function(){
            var prescriptionId = $(this).data('id');
            $('#prescriptionModal').modal('show');
            // عرض مؤشر التحميل
            $('#prescriptionModal .modal-content').html(`
                <div class="text-center my-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">جار التحميل...</span>
                    </div>
                </div>
            `);
            $.ajax({
                url: 'view_prescription.php',
                method: 'GET',
                data: {id: prescriptionId},
                success: function(data){
                    $('#prescriptionModal .modal-content').html(data);
                },
                error: function(){
                    $('#prescriptionModal .modal-content').html(`
                        <div class="modal-header">
                            <h5 class="modal-title" id="prescriptionModalLabel">خطأ</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            حدث خطأ أثناء تحميل التفاصيل. الرجاء المحاولة مرة أخرى.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        </div>
                    `);
                }
            });
        });
    });
    </script>
</body>
</html>
