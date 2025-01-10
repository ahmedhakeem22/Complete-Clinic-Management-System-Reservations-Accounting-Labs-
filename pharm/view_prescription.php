<?php
require_once '../includes/db.php'; // تأكد من أن مسار ملف قاعدة البيانات صحيح

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $prescription_id = (int)$_GET['id'];

    // جلب تفاصيل الوصفة
    $stmt = $conn->prepare("SELECT pat_id, fname, date_t FROM prescriptions WHERE id = ?");
    $stmt->bind_param("i", $prescription_id);
    $stmt->execute();
    $stmt->bind_result($pat_id, $fname, $date_t);
    if (!$stmt->fetch()) {
        echo "<div class='modal-header'>
                <h5 class='modal-title' id='prescriptionModalLabel'>خطأ</h5>
                <button type='button' class='close' data-dismiss='modal' aria-label='إغلاق'>
                    <span aria-hidden='true'>&times;</span>
                </button>
              </div>
              <div class='modal-body'>
                لا توجد وصفة طبية بهذا الرقم.
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-dismiss='modal'>إغلاق</button>
              </div>";
        exit;
    }
    $stmt->close();

    // جلب الأدوية
    $stmt_med = $conn->prepare("SELECT med_name, usee, countity FROM medical WHERE prescription_id = ?");
    $stmt_med->bind_param("i", $prescription_id);
    $stmt_med->execute();
    $result_med = $stmt_med->get_result();

    // إعداد محتوى النافذة المنبثقة
    ?>
    <div class="modal-header">
        <h5 class="modal-title" id="prescriptionModalLabel">تفاصيل الوصفة</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <strong>رقم المريض:</strong> <?php echo htmlspecialchars($pat_id); ?>
        </div>
        <div class="mb-3">
            <strong>اسم المريض:</strong> <?php echo htmlspecialchars($fname); ?>
        </div>
        <div class="mb-3">
            <strong>التاريخ:</strong> <?php echo htmlspecialchars(date("d-m-Y", strtotime($date_t))); ?>
        </div>

        <h5 class="mt-4">الأدوية:</h5>
        <div class="table-responsive">
            <table class="table table-sm table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>اسم الدواء</th>
                        <th>الكمية</th>
                        <th>طريقة الاستخدام</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($result_med->num_rows > 0): ?>
                        <?php while ($med = $result_med->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($med['med_name']); ?></td>
                            <td><?php echo htmlspecialchars($med['countity']); ?></td>
                            <td><?php echo htmlspecialchars($med['usee']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">لا توجد أدوية مسجلة لهذه الوصفة.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
        <form method="post" action="confirm_prescription.php" onsubmit="return confirm('هل أنت متأكد من تأكيد وطباعة هذه الوصفة؟');">
            <input type="hidden" name="prescription_id" value="<?php echo $prescription_id; ?>">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
            <button type="submit" name="confirm" class="btn btn-success">
                <i class="fas fa-check"></i> تأكيد وطباعة
            </button>
        </form>
    </div>
    <?php
    $stmt_med->close();
} else {
    echo "<div class='modal-header'>
            <h5 class='modal-title' id='prescriptionModalLabel'>خطأ</h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='إغلاق'>
                <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
            رقم الوصفة غير صالح.
          </div>
          <div class='modal-footer'>
            <button type='button' class='btn btn-secondary' data-dismiss='modal'>إغلاق</button>
          </div>";
}
?>
