<?php 
require_once __DIR__ . '/../vendor/autoload.php';
include '../includes/db.php';
use TCPDF;

// تعيين المنطقة الزمنية
date_default_timezone_set("Asia/Aden");
$pat_date_now = date("Y-m-d");

// دالة لتعقيم المدخلات
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// تعريف كلاس PDF مع تعديل الرأس والتذييل
class PDF extends TCPDF {
    // رأس الصفحة
    public function Header(){
        $this->SetFont('times','B',15);
        $this->Cell(0, 10, 'تقرير المريض', 0, 1, 'C');
        $this->Ln(5);
    }

    // تذييل الصفحة
    public function Footer(){
        $this->SetY(-15);
        $this->SetFont('times','I',10);
        $this->Cell(0,10,'الصفحة '.$this->getAliasNumPage().' من '.$this->getAliasNbPages(),0,0,'C');
    }
}

// التأكد من وجود 'pat_id' في GET
if(isset($_GET['pat_id']) && is_numeric($_GET['pat_id'])){
    $pat_id = (int)$_GET['pat_id'];
    $session_id = isset($_GET['session_id']) ? (int)$_GET['session_id'] : null;

    // جلب بيانات المريض الأساسية باستخدام العبارات المحضرة
    $stmt = $conn->prepare("SELECT * FROM patinte WHERE pat_id = ?");
    $stmt->bind_param("i", $pat_id);
    $stmt->execute();
    $resultPat = $stmt->get_result();

    if($pat_array = $resultPat->fetch_assoc()){
        // إنشاء كائن PDF
        $pdf = new PDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('اسم العيادة');
        $pdf->SetTitle('تقرير المريض');
        $pdf->SetHeaderData('', 0, 'تقرير المريض', '');
        $pdf->setHeaderFont(Array('times','B',12));
        $pdf->setFooterFont(Array('times','I',8));
        $pdf->AddPage();

        // إضافة صورة الخلفية إذا كانت موجودة
        if(file_exists('img_back_pdf.png')){
            $pdf->Image('img_back_pdf.png',0,0,210,297, '', '', '', false, 300, '', false, false, 0);
        }

        // إعداد الخط
        $pdf->SetFont('aealarabiya','',14);
        $pdf->Ln(20);

        // عرض بيانات المريض
        $pdf->Cell(40,8,'التاريخ:',0,0,'R');
        $pdf->Cell(50,8,$pat_date_now,0,1,'L');

        $pdf->Cell(40,8,'رقم المريض:',0,0,'R');
        $pdf->Cell(50,8,$pat_array['pat_id'],0,1,'L');

        $pdf->Cell(40,8,'الاسم:',0,0,'R');
        $pdf->Cell(50,8,$pat_array['fname'],0,1,'L');

        $pdf->Cell(40,8,'العمر:',0,0,'R');
        $pdf->Cell(50,8,$pat_array['age'],0,1,'L');

        $pdf->Cell(40,8,'الهاتف:',0,0,'R');
        $pdf->Cell(50,8,$pat_array['phone'],0,1,'L');

        $pdf->Cell(40,8,'الجنس:',0,0,'R');
        $pdf->Cell(50,8,$pat_array['gander'],0,1,'L');

        $pdf->Cell(40,8,'الدولة:',0,0,'R');
        $pdf->Cell(50,8,$pat_array['contry'],0,1,'L');

        $pdf->Cell(40,8,'المدينة:',0,0,'R');
        $pdf->Cell(50,8,$pat_array['city'],0,1,'L');

        $pdf->Cell(40,8,'الحالة الاجتماعية:',0,0,'R');
        $pdf->Cell(50,8,$pat_array['soc_sts'],0,1,'L');

        $pdf->Cell(40,8,'عدد الأطفال:',0,0,'R');
        $pdf->Cell(50,8,$pat_array['chel_num'],0,1,'L');

        $pdf->Cell(40,8,'الوظيفة:',0,0,'R');
        $pdf->Cell(50,8,$pat_array['jop'],0,1,'L');

        $pdf->Cell(40,8,'الزواج:',0,0,'R');
        $pdf->Cell(50,8,$pat_array['rig_pat'],0,1,'L');

        $pdf->Cell(40,8,'تاريخ الإكمال:',0,0,'R');
        $pdf->Cell(50,8,$pat_array['date_com'],0,1,'L');

        $pdf->Ln(10);

        // إذا تم تمرير session_id، عرض بيانات الجلسة المحددة فقط
        if($session_id){
            $stmtSession = $conn->prepare("SELECT * FROM session WHERE pat_id = ? AND id_session = ?");
            $stmtSession->bind_param("ii", $pat_id, $session_id);
        } else {
            // إذا لم يتم تمرير session_id، عرض جميع الجلسات
            $stmtSession = $conn->prepare("SELECT * FROM session WHERE pat_id = ?");
            $stmtSession->bind_param("i", $pat_id);
        }
        $stmtSession->execute();
        $resultSession = $stmtSession->get_result();

        while($pat_array_ses = $resultSession->fetch_assoc()){
            // إضافة صفحة جديدة لكل جلسة
            $pdf->AddPage();

            // إضافة صورة الخلفية
            if(file_exists('img_back_pdf.png')){
                $pdf->Image('img_back_pdf.png',0,0,210,297, '', '', '', false, 300, '', false, false, 0);
            }

            $pdf->SetFont('aealarabiya','',14);
            $pdf->Ln(20);

            // عرض بيانات الجلسة
            $pdf->Cell(40,8,'رقم الجلسة:',0,0,'R');
            $pdf->Cell(50,8,$pat_array_ses['id_session'],0,1,'L');

            $pdf->Cell(40,8,'تاريخ الجلسة:',0,0,'R');
            $pdf->Cell(50,8,$pat_array_ses['date_now'],0,1,'L');

            $pdf->Cell(40,8,'تاريخ الجلسة التالية:',0,0,'R');
            $pdf->Cell(50,8,$pat_array_ses['date_next'],0,1,'L');

            $pdf->Ln(5);

            // عرض محتويات الجلسة
            $fields = [
                'main_com' => 'الشكوى الرئيسية',
                'period_ill' => 'مدة المرض',
                'sex_hist' => 'التاريخ الجنسي',
                'person_hist' => 'التاريخ الشخصي',
                'curr_hist' => 'تاريخ المرض الحالي',
                'last_hist' => 'تاريخ المرض الأخير',
                'fam_hist' => 'تاريخ العائلة',
                'work_hist' => 'تاريخ العمل',
                'basic_dig' => 'التشخيص الأساسي',
                'diff_dig' => 'التشخيص التفريقي',
                'appear' => 'المظهر',
                'behav' => 'السلوك',
                'speech' => 'الكلام',
                'mood' => 'المزاج',
                'killer' => 'أفكار انتحار أو قتل',
                'thin_shep' => 'شكل التفكير',
                'thin_con' => 'محتوى التفكير',
                'percep' => 'الإدراك',
                'memory' => 'الذاكرة',
                'ability' => 'القدرة على الحكم',
                'insight' => 'البصيرة',
                'fores' => 'التوقعات',
                'degree' => 'درجة فولستين',
                'speech' => 'الكلام'
            ];

            foreach($fields as $field => $label){
                if(!empty(trim($pat_array_ses[$field]))){
                    $pdf->SetFont('aealarabiya','B',12);
                    $pdf->Cell(60,8, $label . ':',0,1,'R');
                    $pdf->SetFont('aealarabiya','',12);
                    $pdf->MultiCell(0, 8, $pat_array_ses[$field], 0, 'R', false);
                    $pdf->Ln(2);
                }
            }

            // عرض نتائج التحاليل النفسية
            $stmtPsych = $conn->prepare("SELECT * FROM test_psychological WHERE pat_id = ?");
            $stmtPsych->bind_param("i", $pat_id);
            $stmtPsych->execute();
            $resultPsych = $stmtPsych->get_result();

            if($psychRow = $resultPsych->fetch_assoc()){
                $pdf->SetFont('aealarabiya','B',14);
                $pdf->Cell(0,8,'الاختبارات النفسية',0,1,'C');
                $pdf->SetFont('aealarabiya','',12);

                $pdf->Cell(50,8,'اسم الاختبار:',0,0,'R');
                $pdf->Cell(100,8,$psychRow['name_test'],0,1,'L');

                $pdf->Cell(50,8,'نتيجة الاختبار:',0,0,'R');
                $pdf->Cell(100,8,$psychRow['result'],0,1,'L');

                $pdf->Cell(50,8,'ملاحظات:',0,1,'R');
                $pdf->MultiCell(0, 8, $psychRow['notes'], 0, 'R', false);
                $pdf->Ln(5);
            }

            // عرض نتائج التحاليل الطبية من جدول test_results وtests
            $stmtTests = $conn->prepare("
                SELECT tr.value, t.test_name, t.normal_range
                FROM test_results tr
                JOIN tests t ON tr.test_id = t.test_id
                WHERE tr.pat_id = ?
                ORDER BY tr.result_date DESC, t.test_name ASC
            ");
            $stmtTests->bind_param("i", $pat_id);
            $stmtTests->execute();
            $resultTests = $stmtTests->get_result();

            if(mysqli_num_rows($resultTests) > 0){
                $pdf->SetFont('aealarabiya','B',14);
                $pdf->Cell(0,8,'نتائج التحاليل الطبية',0,1,'C');
                $pdf->SetFont('aealarabiya','B',12);
                $pdf->Cell(80,8,'اسم التحليل',1,0,'C');
                $pdf->Cell(60,8,'المدى الطبيعي',1,0,'C');
                $pdf->Cell(50,8,'النتيجة',1,1,'C');

                $pdf->SetFont('aealarabiya','',12);
                while($testRow = $resultTests->fetch_assoc()){
                    $pdf->Cell(80,8,$testRow['test_name'],1,0,'C');
                    $pdf->Cell(60,8,$testRow['normal_range'],1,0,'C');
                    $pdf->Cell(50,8,$testRow['value'],1,1,'C');
                }
            }
        }

        // عرض نتائج التحاليل من جدول test_results (اختبارات عامة)
        $stmtGeneralTests = $conn->prepare("
            SELECT tr.value, t.test_name, t.normal_range
            FROM test_results tr
            JOIN tests t ON tr.test_id = t.test_id
            WHERE tr.pat_id = ?
            ORDER BY tr.result_date DESC, t.test_name ASC
        ");
        $stmtGeneralTests->bind_param("i", $pat_id);
        $stmtGeneralTests->execute();
        $resultGeneralTests = $stmtGeneralTests->get_result();

        if(mysqli_num_rows($resultGeneralTests) > 0){
            $pdf->AddPage();
            if(file_exists('img_back_pdf.png')){
                $pdf->Image('img_back_pdf.png',0,0,210,297, '', '', '', false, 300, '', false, false, 0);
            }
            $pdf->SetFont('aealarabiya','B',14);
            $pdf->Cell(0,8,'نتائج التحاليل الطبية العامة',0,1,'C');
            $pdf->SetFont('aealarabiya','B',12);
            $pdf->Cell(80,8,'اسم التحليل',1,0,'C');
            $pdf->Cell(60,8,'المدى الطبيعي',1,0,'C');
            $pdf->Cell(50,8,'النتيجة',1,1,'C');

            $pdf->SetFont('aealarabiya','',12);
            while($testRow = $resultGeneralTests->fetch_assoc()){
                $pdf->Cell(80,8,$testRow['test_name'],1,0,'C');
                $pdf->Cell(60,8,$testRow['normal_range'],1,0,'C');
                $pdf->Cell(50,8,$testRow['value'],1,1,'C');
            }
        }

        // إظهار PDF
        $pdf->Output('report_pation_'.$pat_id.'.pdf', 'I');

    } else {
        echo "لا يوجد مريض بهذا الرقم.";
    }
} else {
    echo "رقم المريض غير صالح.";
}
?>
