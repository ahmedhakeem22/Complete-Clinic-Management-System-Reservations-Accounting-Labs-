<?php
include 'C:\Users\Zainon\Herd\htdocs\includes\db.php';

header('Content-Type: application/json; charset=utf-8'); // تحديد نوع المحتوى JSON

if (isset($_GET['pat_id'])) {
    $pat_id = intval($_GET['pat_id']); // تأكد من أن الإدخال رقم صحيح

    // استعلام لجلب اسم المريض
    $stmt = $conn->prepare("SELECT fname FROM patinte WHERE pat_id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $pat_id);
        $stmt->execute();
        $stmt->bind_result($fname);
        $stmt->fetch();
        $stmt->close();

        if (!empty($fname)) {
            echo json_encode(['success' => true, 'fname' => $fname]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Patient not found.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Database query failed.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid patient ID.']);
}

$conn->close();
?>
