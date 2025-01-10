<?php
// ajax_get_request_details.php
include '../includes/db.php';

if (!isset($_GET['request_id'])) {
    exit("لا يوجد request_id");
}
$reqId = intval($_GET['request_id']);

$sql = "SELECT lr.*, p.fname 
        FROM lab_requests lr
        JOIN patinte p ON lr.pat_id = p.pat_id
        WHERE lr.request_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $reqId);
$stmt->execute();
$res = $stmt->get_result();
$reqData = $res->fetch_assoc();
if (!$reqData) {
    exit("الطلب غير موجود");
}

// جلب الفحوصات التفصيلية
$sqlTests = "
  SELECT lrt.*, t.test_name
  FROM lab_request_tests lrt
  JOIN tests t ON lrt.test_id = t.test_id
  WHERE lrt.request_id = ?
";
$stmt2 = $conn->prepare($sqlTests);
$stmt2->bind_param("i", $reqId);
$stmt2->execute();
$res2 = $stmt2->get_result();
?>
<h4>طلب رقم: <?= $reqData['request_id'] ?></h4>
<p>اسم المريض: <?= htmlspecialchars($reqData['fname']) ?></p>
<p>تاريخ الطلب: <?= $reqData['request_date'] ?></p>
<p>الحالة الحالية: <?= $reqData['status'] ?></p>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>الفحص</th>
            <th>السعر</th>
        </tr>
    </thead>
    <tbody>
    <?php 
    while($testRow = $res2->fetch_assoc()):
    ?>
        <tr>
            <td><?= htmlspecialchars($testRow['test_name']) ?></td>
            <td><?= $testRow['price'] ?></td>
        </tr>
    <?php endwhile; ?>
    </tbody>
    <tfoot>
        <tr>
            <th>الإجمالي</th>
            <th><?= $reqData['total_cost'] ?></th>
        </tr>
    </tfoot>
</table>
