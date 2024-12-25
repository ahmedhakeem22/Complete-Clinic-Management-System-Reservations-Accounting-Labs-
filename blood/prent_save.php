<?php

require_once __DIR__ . '/../vendor/autoload.php';
include '../includes/db.php';

// 1) استقبال المعاملات
$pat_id = isset($_GET['pat_id']) ? intval($_GET['pat_id']) : 0;
$result_ids_str = isset($_GET['result_ids']) ? $_GET['result_ids'] : '';
if ($pat_id <= 0 || empty($result_ids_str)) {
    exit("معطيات غير صحيحة: لا يوجد pat_id أو result_ids.");
}

// 2) تحويل result_ids إلى مصفوفة
$result_ids = array_filter(array_map('intval', explode(',', $result_ids_str)));
if (empty($result_ids)) {
    exit("لا توجد نتائج فحوصات.");
}

// 3) جلب بيانات المريض
$stmtP = $conn->prepare("SELECT fname, age, gander, phone FROM patinte WHERE pat_id=?");
$stmtP->bind_param("i", $pat_id);
$stmtP->execute();
$resP = $stmtP->get_result();
if ($resP->num_rows == 0) {
    exit("لا يوجد مريض بهذا الرقم.");
}
$patientData = $resP->fetch_assoc();

// 4) جلب بيانات test_results مع JOIN على tests و test_categories
$placeholders = implode(',', array_fill(0, count($result_ids), '?'));
$sql = "
    SELECT tr.result_id, tr.value, tr.result_date,
           t.test_id, t.test_name, t.normal_range,
           c.category_id, c.category_name
    FROM test_results tr
    JOIN tests t ON tr.test_id = t.test_id
    JOIN test_categories c ON t.category_id = c.category_id
    WHERE tr.pat_id=? AND tr.result_id IN ($placeholders)
    ORDER BY c.category_name, t.test_name
";
$stmt = $conn->prepare($sql);

$types = str_repeat('i', count($result_ids) + 1);
$params = array_merge([$pat_id], $result_ids);

function refValues($arr) {
    if (strnatcmp(phpversion(),'5.3') >= 0) {
        $refs = [];
        foreach($arr as $key => $value) {
            $refs[$key] = &$arr[$key];
        }
        return $refs;
    }
    return $arr;
}

$stmt->bind_param($types, ...refValues($params));
$stmt->execute();
$results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if (empty($results)) {
    exit("لا توجد نتائج فحوصات بهذا المعرف.");
}

// 5) تعريف فئة MyPDF مع جعل الصورة خلفيةً
class MyPDF extends TCPDF {
    public function Header() {
        // إضافة الصورة الخلفية
        $this->SetAutoPageBreak(false, 0);
        $this->Image(
            'includes/images/img.png', 
            0, 
            0, 
            $this->getPageWidth(), 
            $this->getPageHeight(), 
            '', '', '', 
            false, 300, '', 
            false, false, 0
        );
        $this->SetAutoPageBreak(true, 15);
        
        // عنوان التقرير
        $this->SetFont('aealarabiya','B',16);
        $this->Ln(16); // تحريك العنوان للأسفل
        $this->Cell(0, 15, 'تقرير نتائج الفحوصات', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln(10);
    }

    public function Footer() {
        // تذييل الصفحة
        $this->SetY(-10);
        $this->SetFont('aealarabiya','I',10);
        $this->Cell(0,10,"الصفحة ".$this->getAliasNumPage()."/".$this->getAliasNbPages(),0,0,'C');
    }
}

// 6) إنشاء كائن PDF
$pdf = new MyPDF('P','mm','A4',true,'UTF-8',false);
$pdf->SetFont('aealarabiya','',14);

// 7) صفحة جديدة
$pdf->AddPage();

// 8) معلومات المريض من اليمين إلى اليسار
$pdf->SetFont('aealarabiya','B',14);
$pdf->Ln(30);
$pdf->Cell(0,10,"معلومات المريض",0,1,'C');

$pdf->SetFont('aealarabiya','',14);
$pdf->Cell(50,10,"الهاتف:",1,0,'R');
$pdf->Cell(30,10,"الجنس:",1,0,'R');
$pdf->Cell(30,10,"العمر:",1,0,'R');
$pdf->Cell(80,10,"اسم المريض:",1,1,'R');

$pdf->Cell(50,10,$patientData['phone'],1,0,'C');
$pdf->Cell(30,10,$patientData['gander'],1,0,'C');
$pdf->Cell(30,10,$patientData['age'],1,0,'C');
$pdf->Cell(80,10,$patientData['fname'],1,1,'C');
$pdf->Ln(10);

// 9) ترتيب النتائج حسب الـ category_name
$organized = [];
foreach($results as $row) {
    $catName = $row['category_name'];
    if(!isset($organized[$catName])) {
        $organized[$catName] = [];
    }
    $organized[$catName][] = $row;
}

// 10) طباعة الفحوصات منظمة حسب الفئة مع تحديد 14 تقريرًا لكل صفحة
$counter = 0; // تعريف العداد
$maxPerPage = 16; // الحد الأقصى للتقارير في الصفحة

foreach($organized as $catName => $rows){
    foreach($rows as $r){
        // التحقق مما إذا كان العداد قد وصل إلى الحد الأقصى
        if ($counter >= $maxPerPage) {
            $pdf->AddPage();
            $counter = 0; // إعادة تعيين العداد بعد إضافة صفحة جديدة
            
            // طباعة معلومات المريض مرة أخرى في الصفحة الجديدة
            $pdf->SetFont('aealarabiya','B',14);
            $pdf->Ln(30);
            $pdf->Cell(0,10,"معلومات المريض",0,1,'C');
            
            $pdf->SetFont('aealarabiya','',14);
            $pdf->Cell(50,10,"الهاتف:",1,0,'R');
            $pdf->Cell(30,10,"الجنس:",1,0,'R');
            $pdf->Cell(30,10,"العمر:",1,0,'R');
            $pdf->Cell(80,10,"اسم المريض:",1,1,'R');
            
            $pdf->Cell(50,10,$patientData['phone'],1,0,'C');
            $pdf->Cell(30,10,$patientData['gander'],1,0,'C');
            $pdf->Cell(30,10,$patientData['age'],1,0,'C');
            $pdf->Cell(80,10,$patientData['fname'],1,1,'C');
            $pdf->Ln(10);
        }

        // إذا كانت بداية فئة جديدة، طباعة عنوان الفئة وجدول الأعمدة
        if ($counter == 0 || $prevCatName !== $catName) {
            $pdf->SetFillColor(200,220,255);
            $pdf->Cell(0,8,$catName,1,1,'C',true);
            $pdf->Cell(60,8,"اسم الاختبار",1,0,'C');
            $pdf->Cell(40,8,"النتيجة",1,0,'C');
            $pdf->Cell(90,8,"النطاق الطبيعي",1,1,'C');
        }

        // طباعة بيانات الاختبار
        $test_name    = $r['test_name'];
        $value        = $r['value'];
        $normal_range = $r['normal_range'];
        $pdf->Cell(60,8,$test_name,1,0,'C');
        $pdf->Cell(40,8,$value,1,0,'C');
        $pdf->Cell(90,8,$normal_range,1,1,'C');
        $counter++;
        $prevCatName = $catName;
    }
    $pdf->Ln(5);
}

// 11) إخراج PDF
ob_end_clean();
$pdf->Output('results.pdf','I');
