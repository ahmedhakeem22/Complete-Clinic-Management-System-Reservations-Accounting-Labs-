<?php
/**
 * الملف: nafsi_ses_pdf.php
 * المسؤول عن توليد ملف PDF للاختبارات المختارة.
 *
 * @author ...
 * @date    2024-12-24
 *
 * المصادر:
 * [1] TCPDF Documentation: https://tcpdf.org/docs/examples/
 * [2] Official PHP Manual: https://www.php.net/manual/en/index.php
 */

 require_once __DIR__ . '/../vendor/autoload.php';
 include '../includes/db.php';

// ضبط التوقيت حسب المنطقة الزمنية
date_default_timezone_set("Asia/Aden");
$pat_date_now = date("Y-m-d");

// دالة لتصفية المدخلات
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// التحقق من استلام بيانات POST (أو GET حسب رغبتك)
// يفضّل في المشاريع الحقيقية استخدام POST لأمان أكبر
if (isset($_POST['add_sess']) && isset($_POST['test']) && isset($_POST['pat_id'])) {
    $chose = $_POST['test'];  // مصفوفة الاختبارات المختارة
    $c = count($chose);
    $pat_id = test_input($_POST['pat_id']);

    // جلب اسم المريض
    $stmt = mysqli_prepare($conn, "SELECT fname FROM patinte WHERE pat_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $pat_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row_fname = "";

    if ($row = mysqli_fetch_array($result)) {
        $row_fname = $row['fname'];
    }

    // إنشاء كائن TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('YourAppName');
    $pdf->SetAuthor('Dr. Amr');
    $pdf->SetTitle('اختبارات نفسية');
    $pdf->SetSubject('اختبارات تم اختيارها للمريض');
    $pdf->SetMargins(10, 10, 10);

    // إضافة صفحة
    $pdf->AddPage();

    // إدراج خلفية أو صور إن أحببت
    $pdf->Image('includes/images/img_back_pdf.png', 10, 10, -300); 
    // يمكنك التعديل على مكان الصورة وحجمها بما يناسبك

    // إعداد الخط
    $pdf->SetFont('freeserif', '', 12);

    // إضافة شعار أو صورة أخرى إذا لزم
    $pdf->Image('includes/images/2.png', 10, 70, 189);

    // مسافة سطر
    $pdf->Ln(27);

    // التاريخ
    $pdf->Cell(150, 8, '', 0, 0, 'C', 0);
    $pdf->Cell(14, 8, 'date :', 0, 0, 'C', 0);
    $pdf->Cell(20, 8, $pat_date_now, 0, 1, 'C', 0);

    $pdf->Ln();
    $pdf->Cell(318, 8, 'الدكتور : عمرو أحمـــد الخـــرساني ', 0, 0, 'C', 0);

    $pdf->Ln(10);

    // معلومات المريض
    $pdf->Cell(5, 8, '', 0, 0, 'C', 0);
    $pdf->Cell(22, 8, 'Patinte ID :', 1, 0, 'C', 0);
    $pdf->Cell(15, 8, $pat_id, 1, 0, 'C', 0);
    $pdf->Cell(30, 8, 'Patinte Name :', 1, 0, 'C', 0);
    $pdf->Cell(40, 8, $row_fname, 1, 0, 'C', 0);
    $pdf->Cell(70, 8, 'الاختبارات المختارة', 1, 1, 'C', 0);

    // تغيير الخط للغة العربية
    $pdf->SetFont('aealarabiya', '', 12);

    // طباعة الاختبارات المختارة
    // يفضل في المشاريع الحقيقية أن تأتي أسماء الاختبارات ديناميكياً من قاعدة البيانات أو مصفوفة
    $tests = [
        1  => 'الاختبارات الستة الكل',
        2  => 'اختبار وايزمان للمعتقدات',
        3  => 'اختبار إيزليك للشخصية',
        4  => 'اختبار تأكيد الذات',
        5  => 'اختبار تقدير الذات',
        6  => 'اختبار وجهة الضبط',
        7  => 'اختبار ساكس لتكملة الجمل',
        8  => 'مقياس الدافعية والرغبة في الإدمان',
        9  => 'استبيان معتقدات الشخصية',
        10 => 'اختبار الشخصية المتعددة الأوجه MMPI',
        11 => 'مقياس بيك للاكتئاب',
        12 => 'مقياس كولومبيا للانتحار',
        13 => 'مقياس تابلور للقلق',
        14 => 'مقياس الوسواس القهري وشدته',
        15 => 'مقياس الآسيست للإدمان',
        16 => 'مقياس الذكاء المصور',
        17 => 'اختبار الجشطلت',
        18 => 'مقياس كرب بعد الصدمة',
        19 => 'مقياس الهوس',
        20 => 'اختبار وكسلر لذكاء المراهقين والبالغين',
        21 => 'اختبار وكسلر لذكاء الأطفال ما قبل سن المراهقة',
        22 => 'مقياس تقييم الأعراض الانسحابية للكحول',
        23 => 'مقياس تقييم الأعراض الانسحابية للبنزودياربين',
        24 => 'مقياس تقييم أعراض الإدمان على البنزودياربين',
        25 => 'مقياس تقييم الأعراض الانسحابية للأفيونات',
        26 => 'استبيان تقييم شدة الإدمان على الأفيونيات',
        27 => 'استبيان تقييم الإدمان على الكحول',
        28 => 'اختبار التات TAT',
        29 => 'مقياس فرط النشاط وقلة الانتباه',
        30 => 'مقياس الدور الجنسي (ذكور-إناث)',
        31 => 'مقياس الرهاب الاجتماعي',
        32 => 'مقياس القلق الاجتماعي',
        33 => 'فحص الحالة العقلية',
        34 => 'مقياس الهلع',
        35 => 'استبيان التوافق الزوجي',
        36 => 'مقياس تشخيص اضطراب التوحد للأطفال',
        37 => 'مقياس إيلي براون'
    ];

    // طباعة أسماء الاختبارات المختارة
    foreach ($chose as $testId) {
        if (array_key_exists($testId, $tests)) {
            $pdf->Cell(5, 8, '', 0, 0, 'C', 0);
            $pdf->Cell(107, 8, '', 1, 0, 'C', 0);
            $pdf->Cell(70, 8, $tests[$testId], 1, 1, 'C', 0);
        }
    }

    // مثال لمعرفة النتيجة
    //var_dump(array("data" => "demo"));

    // تنظيف المؤقت وإخراج الملف
    ob_end_clean();
    $pdf->Output('nafsi_ses_pdf.pdf', 'I');
} else {
    // في حال لم يتم استلام بيانات بشكل صحيح
    echo "No tests were selected or missing data!";
}
?>
