<?php 
require_once __DIR__ . '/../vendor/autoload.php';
include '../includes/db.php';

// إعداد المنطقة الزمنية
date_default_timezone_set("Asia/Aden");
$pat_date_now = date("Y-m-d");

// دالة لتعقيم البيانات
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// التحقق من أن النموذج قد تم إرساله باستخدام POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_sess'])) {
    
    // جلب البيانات وتعقيمها
    $name_pro = test_input($_POST['provider_name']);
    $service_cost = test_input($_POST['service_cost']);
    $note = test_input($_POST['note']);
    
    // التحقق من صحة البيانات
    if (empty($name_pro) || empty($service_cost) || $service_cost <= 0) {
        die("يرجى إدخال بيانات صحيحة.");
    }
    
    // إعداد الاستعلام باستخدام Prepared Statements للحماية من SQL Injection
    $stmt = $conn->prepare("INSERT INTO provider (name_pro, cost_ser, note, date_pro) VALUES (?, ?, ?, ?)");
    
    if ($stmt) {
        $stmt->bind_param("sdss", $name_pro, $service_cost, $note, $pat_date_now);
        if (!$stmt->execute()) {
            die("خطأ في إدخال البيانات: " . $stmt->error);
        }
        $stmt->close();
    } else {
        die("خطأ في الاستعلام: " . $conn->error);
    }
    
    // إنشاء PDF باستخدام TCPDF
    class PDF extends TCPDF {
        // رأس الصفحة
        public function Header() {
            $this->SetFont('helvetica', 'B', 15);
            // إضافة صورة الشعار
            $this->Image('includes/images/one.png', 10, 10, 30);
            // عنوان المستند
            $this->Cell(0, 15, 'سند قبض مقابل دعم مركز', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        }
        
        // تذييل الصفحة
        public function Footer() {
            // تحديد موقع التذييل
            $this->SetY(-15);
            // تحديد الخط
            $this->SetFont('helvetica', 'I', 8);
            // إضافة رقم الصفحة
            $this->Cell(0, 10, 'صفحة ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        }
    }
    
    // إنشاء كائن PDF جديد
    $pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false);
    
    // إعداد المستند
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('شركتك');
    $pdf->SetTitle('سند قبض');
    $pdf->SetSubject('سند قبض مقابل دعم مركز');
    $pdf->SetKeywords('TCPDF, PDF, سند قبض, دعم مركز');
    
    // إزالة الهيدر التلقائي لأننا نستخدم رأسنا الخاص
    $pdf->setPrintHeader(true);
    $pdf->setPrintFooter(true);
    
    // إعداد الخطوط
    $pdf->SetFont('aealarabiya', '', 12);
    
    // إضافة صفحة
    $pdf->AddPage();
    
    // إضافة محتوى السند
    $html = '
    <table cellpadding="5">
        <tr>
            <td><strong>تاريخ السند:</strong></td>
            <td>' . htmlspecialchars($pat_date_now) . '</td>
        </tr>
        <tr>
            <td><strong>اسم الداعم:</strong></td>
            <td>' . htmlspecialchars($name_pro) . '</td>
        </tr>
        <tr>
            <td><strong>المبلغ المدفوع (ريال):</strong></td>
            <td>' . number_format($service_cost, 2) . '</td>
        </tr>
        <tr>
            <td><strong>ملاحظات:</strong></td>
            <td>' . nl2br(htmlspecialchars($note)) . '</td>
        </tr>
    </table>
    ';

    $pdf->writeHTML($html, true, false, true, false, '');
    
    // إخراج PDF للمستخدم
    $pdf->Output('receipt_' . $name_pro . '_' . $pat_date_now . '.pdf', 'I');
    
    // إغلاق الاتصال بقاعدة البيانات
    $conn->close();
    
} else {
    // إذا لم يتم الوصول إلى الصفحة بشكل صحيح
    header("Location: add_receipt.php");
    exit();
}
?>
