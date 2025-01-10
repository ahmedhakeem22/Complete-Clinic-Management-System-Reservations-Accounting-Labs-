<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once '../includes/db.php'; // تأكد من أن مسار ملف قاعدة البيانات صحيح

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prescription_id'])) {
    $prescription_id = (int)$_POST['prescription_id'];

    // تحديث حالة الوصفة إلى "مؤكد"
    $stmt_update = $conn->prepare("UPDATE prescriptions SET status = 'confirmed' WHERE id = ?");
    $stmt_update->bind_param("i", $prescription_id);
    if (!$stmt_update->execute()) {
        die("خطأ في تحديث حالة الوصفة: " . $stmt_update->error);
    }
    $stmt_update->close();

    // جلب تفاصيل الوصفة والأدوية للطباعة
    // جلب تفاصيل الوصفة
    $stmt = $conn->prepare("SELECT pat_id, fname, date_t FROM prescriptions WHERE id = ?");
    $stmt->bind_param("i", $prescription_id);
    $stmt->execute();
    $stmt->bind_result($pat_id, $fname, $date_t);
    $stmt->fetch();
    $stmt->close();

    // جلب الأدوية
    $stmt_med = $conn->prepare("SELECT med_name, usee, countity FROM medical WHERE prescription_id = ?");
    $stmt_med->bind_param("i", $prescription_id);
    $stmt_med->execute();
    $result_med = $stmt_med->get_result();

    // توليد PDF للطباعة
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->AddPage();
    $pdf->Image('../img/img_back_pdf.png', 10, 10, 190, 0, 'PNG', '', '', false, 300, '', false, false, 0);

    $pdf->Ln(42);
    $pdf->SetFillColor(165, 225, 166);

    // توليد محتوى الـ PDF
    $pdf->SetFont('dejavusans', '', 22);
    $pdf->Cell(55, 8, '', 0, 0, 'C', 0);
    $pdf->Cell(80, 12, 'وصفـــة طبيـــة', 1, 1, 'C', 1);
    $pdf->SetFont('dejavusans', '', 12);
    $pdf->Cell(20, 8, '', 0, 1, 'C', 0);
    $pdf->SetFillColor(165, 225, 166);
    $pdf->Cell(5, 8, '', 0, 0, 'C', 0);

    $pdf->Cell(25, 8, 'رقم المريض', 1, 0, 'C', 1);
    $pdf->Cell(15, 8, $pat_id, 1, 0, 'C', 1);

    $pdf->Cell(25, 8, 'اسم المريض', 1, 0, 'C', 1);
    $pdf->Cell(60, 8, $fname, 1, 0, 'C', 1);

    $pdf->Cell(15, 8, 'تاريخ', 1, 0, 'C', 1);
    $pdf->Cell(35, 8, $date_t, 1, 1, 'C', 1);
    $pdf->Ln(10);

    $pdf->SetFillColor(171, 209, 254);
    $pdf->Cell(28, 8, '', 0, 0, 'C', 0);
    $pdf->Cell(80, 8, 'اســـم الـــدواء', 1, 0, 'C', 1);
    $pdf->Cell(50, 8, 'الكميـــة', 1, 1, 'C', 1);

    while ($med = $result_med->fetch_assoc()) {
        $med_name = $med['med_name'];
        $quantity = $med['countity'];
        $usage = $med['usee'];

        $pdf->Cell(28, 8, '', 0, 0, 'C', 0);
        $pdf->SetFillColor(177, 232, 178);
        $pdf->Cell(80, 8, $med_name, 1, 0, 'C', 1);
        $pdf->Cell(50, 8, $quantity, 1, 1, 'C', 1);

        $pdf->SetFillColor(211, 247, 212);
        $pdf->Cell(28, 8, '', 0, 0, 'C', 0);
        $pdf->Cell(130, 8, $usage, 1, 1, 'C', 1);
    }

    $stmt_med->close();

    $pdf->SetFont('freeserif', '', 14);

    if (ob_get_length()) {
        ob_end_clean();
    }

    // إخراج الـ PDF للمتصفح للطباعة
    $pdf->Output('prescription.pdf', 'I');

} else {
    die("طلب غير صالح.");
}
?>
