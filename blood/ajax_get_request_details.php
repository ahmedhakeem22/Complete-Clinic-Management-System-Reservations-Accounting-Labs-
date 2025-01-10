<?php
// ajax_get_request_details.php
include '../includes/db.php';

// تفعيل عرض الأخطاء للتصحيح (تأكد من إزالتها في الإنتاج)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// التحقق من وجود request_id
if (!isset($_GET['request_id'])) {
    exit('<div class="alert alert-danger text-center">لا يوجد معرف للطلب.</div>');
}

$reqId = intval($_GET['request_id']);

// التحقق من صحة اسم الجدول والحقول
$sql = "SELECT lr.*, p.fname 
        FROM lab_requests lr
        JOIN patinte p ON lr.pat_id = p.pat_id
        WHERE lr.request_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    exit("<div class='alert alert-danger text-center'>خطأ في الاستعلام: " . htmlspecialchars($conn->error) . "</div>");
}
$stmt->bind_param("i", $reqId);
$stmt->execute();
$res = $stmt->get_result();
$reqData = $res->fetch_assoc();
if (!$reqData) {
    exit("<div class='alert alert-warning text-center'>الطلب غير موجود.</div>");
}

// جلب الفحوصات التفصيلية
$sqlTests = "
  SELECT lrt.*, t.test_name
  FROM lab_request_tests lrt
  JOIN tests t ON lrt.test_id = t.test_id
  WHERE lrt.request_id = ?
";
$stmt2 = $conn->prepare($sqlTests);
if (!$stmt2) {
    exit("<div class='alert alert-danger text-center'>خطأ في الاستعلام: " . htmlspecialchars($conn->error) . "</div>");
}
$stmt2->bind_param("i", $reqId);
$stmt2->execute();
$res2 = $stmt2->get_result();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-4">تفاصيل الطلب رقم: <span class="text-primary"><?= htmlspecialchars($reqData['request_id']) ?></span></h4>
            <div class="row mb-3">
                <div class="col-md-6">
                    <p><strong>اسم المريض:</strong> <?= htmlspecialchars($reqData['fname']) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>تاريخ الطلب:</strong> <?= htmlspecialchars(date("d-m-Y H:i", strtotime($reqData['request_date']))) ?></p>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>الحالة الحالية:</strong> 
                        <?php
                            // تحديد لون الحالة بناءً على القيمة
                            $status = htmlspecialchars($reqData['status']);
                            $statusClasses = [
                                'paid' => 'badge badge-primary',
                                'completed' => 'badge badge-success',
                                'pending' => 'badge badge-warning text-dark',
                                // أضف المزيد من الحالات إذا لزم الأمر
                            ];
                            $badgeClass = isset($statusClasses[$status]) ? $statusClasses[$status] : 'badge badge-secondary';
                            echo "<span class='{$badgeClass} text-uppercase'>{$status}</span>";
                        ?>
                    </p>
                </div>
            </div>

            <?php if ($res2->num_rows > 0): ?>
                <h5 class="mb-3">الفحوصات المطلوبة:</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th>رقم الفحص</th>
                                <th>اسم الفحص</th>
                                <th>تاريخ الفحص</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        while($testRow = $res2->fetch_assoc()):
                            // تحديد لون الحالة بناءً على القيمة
                            $testStatus = htmlspecialchars($testRow['status'] ?? 'غير محدد');
                            $testStatusClasses = [
                                'pending' => 'badge badge-warning text-dark',
                                'in_progress' => 'badge badge-primary',
                                'completed' => 'badge badge-success',
                                // أضف المزيد من الحالات إذا لزم الأمر
                            ];
                            $testBadgeClass = isset($testStatusClasses[$testStatus]) ? $testStatusClasses[$testStatus] : 'badge badge-secondary';
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($testRow['test_id']) ?></td>
                                <td><?= htmlspecialchars($testRow['test_name']) ?></td>
                                <td><?= htmlspecialchars(date("d-m-Y H:i", strtotime($testRow['test_date'] ?? $reqData['request_date']))) ?></td>
                                <td><span class="<?= $testBadgeClass ?> text-uppercase"><?= $testStatus ?></span></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info text-center">لا توجد فحوصات مرتبطة بهذا الطلب.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
// إغلاق الاتصال بقاعدة البيانات
$conn->close();
?>
