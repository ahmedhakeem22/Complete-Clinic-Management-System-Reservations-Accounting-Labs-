<?php
require_once '../includes/db.php';

// إعداد الرأس لتحديد نوع المحتوى كـ HTML
header('Content-Type: text/html; charset=UTF-8');

if (isset($_GET['invoice_id'])) {
    $invoice_id = intval($_GET['invoice_id']);
    // جلب بيانات الفاتورة
    $query = "SELECT * FROM invoice WHERE invoice_id = ?";
    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param("i", $invoice_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // عرض تفاصيل الفاتورة بتنسيق محسن
            ?>
            <div class="container">
                <h3 class="mb-4 text-center">تفاصيل الفاتورة</h3>
                <table class="table table-striped table-hover">
                    <tbody>
                        <tr>
                            <th scope="row">رقم الفاتورة</th>
                            <td><?php echo htmlspecialchars($row['invoice_id']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">رقم المريض</th>
                            <td><?php echo htmlspecialchars($row['pat_id']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">اسم الخدمة</th>
                            <td><?php echo htmlspecialchars($row['name_ser']); ?></td>
                        </tr>
                        <tr>
                            <th scope="row">تكلفة الخدمة</th>
                            <td><?php echo htmlspecialchars(number_format($row['cost_ser'], 2)); ?> ر.س</td>
                        </tr>
                        <tr>
                            <th scope="row">تاريخ الفاتورة</th>
                            <td><?php echo htmlspecialchars($row['invoice_date']); ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-end mt-4">
                    <!-- زر طباعة الفاتورة المحددة يفتح صفحة الطباعة في نافذة جديدة -->
                    <a href="print_single_invoice.php?invoice_id=<?php echo urlencode($row['invoice_id']); ?>" target="_blank" class="btn btn-primary me-2">
                        <i class="fas fa-print me-2"></i>طباعة الفاتورة
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>إغلاق
                    </button>
                </div>
            </div>
            <?php
        } else {
            echo "<p class='text-danger text-center'>لم يتم العثور على بيانات للفاتورة المطلوبة.</p>";
        }
        $stmt->close();
    } else {
        echo "<p class='text-danger text-center'>حدث خطأ في التحضير للبيانات.</p>";
    }
} else {
    echo "<p class='text-danger text-center'>لم يتم تمرير رقم الفاتورة بشكل صحيح.</p>";
}
?>
