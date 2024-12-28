<?php
require_once __DIR__ . '/../vendor/autoload.php';
include '../includes/db.php';
date_default_timezone_set("Asia/Aden");

// -----------------------------------------------------------------------------
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// -----------------------------------------------------------------------------
$pat_date_now = date("Y-m-d");

if (isset($_GET['pat_id'])) {
    // تنقية المدخلات
    $pat_id = intval(test_input($_GET['pat_id'])); 
    $fname  = isset($_GET['fname']) ? test_input($_GET['fname']) : '';

    if (isset($_GET['test']) && is_array($_GET['test'])) {
        // تحويل القيم إلى أعداد صحيحة (حماية إضافية)
        $chose = array_map('intval', $_GET['test']);

        // جلب اسم المريض من قاعدة البيانات
        $query  = "SELECT fname FROM patinte WHERE pat_id = ?";
        $stmt   = $conn->prepare($query);
        $stmt->bind_param('i', $pat_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row    = $result->fetch_assoc();

        $row_fname = $row ? $row['fname'] : 'غير معروف';

        // جلب أسماء الفحوصات والمجموعات من قاعدة البيانات
        if (count($chose) > 0) {
            // بناء قائمة الفحوصات المطلوبة بشكل ديناميكي
            $placeholders = implode(',', array_fill(0, count($chose), '?'));
            $types = str_repeat('i', count($chose)); // جميع المعرفات أعداد صحيحة

            // الاستعلام مع الانضمام لجدول الفئات
            $testsQuery = "
                SELECT t.test_id, t.test_name, c.category_id, c.category_name
                FROM tests t
                LEFT JOIN test_categories c ON t.category_id = c.category_id
                WHERE t.test_id IN ($placeholders)
                ORDER BY c.category_id ASC, t.test_id ASC
            ";

            $stmt = $conn->prepare($testsQuery);
            // ربط المعلمات ديناميكيًا
            $stmt->bind_param($types, ...$chose);
            $stmt->execute();
            $testsResult = $stmt->get_result();

            // تجميع الفحوصات حسب الفئة
            $groupedTests = [];
            while ($test = $testsResult->fetch_assoc()) {
                $category_id = $test['category_id'] ?? 0; // في حال لم تكن هناك فئة
                $category_name = $test['category_name'] ?? 'غير مصنف';
                if (!isset($groupedTests[$category_id])) {
                    $groupedTests[$category_id] = [
                        'category_name' => $category_name,
                        'tests' => []
                    ];
                }
                $groupedTests[$category_id]['tests'][] = $test['test_name'];
            }

            // تحديد حد أقصى للفحوصات في كل صفحة
            $maxTestsPerPage = 18; // يمكنك تعديل العدد حسب رغبتك
            $currentTestsCount = 0;

            // تمديد الكلاس TCPDF لإضافة الخلفية ورقم الصفحة في التذييل
            class MYPDF extends TCPDF {
                // إضافة الخلفية في الهيدر
                public function Header() {
                    $image_file = __DIR__ . '/includes/images/img_back_pdf.png'; // تأكد من المسار الصحيح

                    if (file_exists($image_file)) {
                        // الحصول على أبعاد الصفحة
                        $pageWidth = $this->getPageWidth();
                        $pageHeight = $this->getPageHeight();

                        // إضافة الصورة في الخلفية تغطي كامل الصفحة
                        $this->Image(
                            $image_file, 
                            0, 
                            0, 
                            $pageWidth, 
                            $pageHeight, 
                            '', 
                            '', 
                            '', 
                            false, 
                            300, 
                            '', 
                            false, 
                            false, 
                            0
                        );
                    }
                }

                // صفحة تذييل
                public function Footer() {
                    // تحديد الموقع من أسفل الصفحة
                    $this->SetY(-15);
                    // تعيين الخط
                    $this->SetFont('freeserif', 'I', 8);
                    // رقم الصفحة
                    $this->Cell(0, 10, 'صفحة ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'C', 0);
                }
            }

            // إنشاء كائن PDF
            $pdf = new MYPDF('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('عمرو أحمد الخرساني');
            $pdf->SetTitle('الفحوصات الدموية المختارة');
            $pdf->SetSubject('تقارير الفحوصات الدموية');
            $pdf->SetKeywords('TCPDF, PDF, blood tests, report');

            // إعدادات المستند
            $pdf->SetMargins(0, 0, 0); // إزالة الهوامش لضمان تغطية الخلفية
            $pdf->SetAutoPageBreak(TRUE, 0); // إزالة الهامش السفلي
            $pdf->SetPrintHeader(true); // تفعيل الهيدر لإظهار الخلفية
            $pdf->SetPrintFooter(true); // تفعيل الفوتر

            // ضبط حشو الخلايا
            $pdf->setCellPaddings(2, 2, 2, 2); // يمكن تعديل القيم حسب الحاجة

            // إضافة صفحة أولى
            $pdf->AddPage();
            addPatientInfo($pdf, $pat_id, $row_fname, $pat_date_now);

            // عنوان الفحوصات المختارة (تم نقله خارج دالة addPatientInfo لتجنب التكرار)
            $pdf->SetFont('freeserif', 'B', 14);
            $pdf->Cell(0, 8, 'اختبارات الدم المختارة', 0, 1, 'C', 0);
            $pdf->Ln(5);

            $pdf->SetFont('freeserif', '', 14);

            // تكرار عبر الفئات والفحوصات
            foreach ($groupedTests as $group) {
                $categoryName = $group['category_name'];
                $tests = $group['tests'];
                $numberOfTestsInGroup = count($tests);

                // التحقق مما إذا كانت الفئة والفحوصات ستتجاوز الحد الأقصى للفحوصات في الصفحة الحالية
                if ($currentTestsCount + $numberOfTestsInGroup > $maxTestsPerPage) {
                    // إضافة صفحة جديدة
                    $pdf->AddPage();
                    addPatientInfo($pdf, $pat_id, $row_fname, $pat_date_now);
                    // عنوان الفحوصات المختارة بعد إضافة صفحة جديدة
                    $pdf->SetFont('freeserif', 'B', 14);
                    $pdf->Cell(0, 8, 'اختبارات الدم المختارة', 0, 1, 'C', 0);
                    $pdf->Ln(5);
                    $pdf->SetFont('freeserif', '', 14);
                    $currentTestsCount = 0;
                }

                // تصميم خانة الفئة
                $pdf->SetFillColor(173, 216, 230); // لون أزرق فاتح
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetFont('freeserif', 'B', 14);
                // تحديد عرض الخانات: عرض صفحة A4 بالملم (210 ملم)
                $pageWidth = 210; 
                $pdf->Cell($pageWidth, 10, $categoryName, 1, 1, 'C', 1);
                $pdf->SetFont('freeserif', '', 14);
                $currentTestsCount +=1;

                // تكرار عبر الفحوصات في الفئة الحالية
                foreach ($tests as $testName) {
                    // التحقق مما إذا تم الوصول للحد الأقصى للفحوصات في الصفحة
                    if ($currentTestsCount >= $maxTestsPerPage) {
                        $pdf->AddPage();
                        addPatientInfo($pdf, $pat_id, $row_fname, $pat_date_now);
                        // عنوان الفحوصات المختارة بعد إضافة صفحة جديدة
                        $pdf->SetFont('freeserif', 'B', 14);
                        $pdf->Cell(0, 8, 'اختبارات الدم المختارة', 0, 1, 'C', 0);
                        $pdf->Ln(5);
                        $pdf->SetFont('freeserif', '', 14);
                        $currentTestsCount = 0;

                        // تصميم خانة الفئة بعد إضافة صفحة جديدة
                        $pdf->SetFillColor(173, 216, 230); // لون أزرق فاتح
                        $pdf->SetTextColor(0, 0, 0);
                        $pdf->SetFont('freeserif', 'B', 14);
                        $pdf->Cell($pageWidth, 10, $categoryName, 1, 1, 'C', 1);
                        $pdf->SetFont('freeserif', '', 14);
                        $currentTestsCount +=1;
                    }

                    // طباعة اسم الاختبار
                    $pdf->SetFillColor(255, 255, 255); // لون خلفية أبيض
                    $pdf->Cell(10, 8, '', 0, 0, 'C', 0); // زيادة العرض من 5 إلى 10 ملم
                    $pdf->Cell(140, 8, '', 1, 0, 'C', 0); // زيادة العرض من 125 إلى 140 ملم
                    $pdf->Cell(60, 8, $testName, 1, 1, 'C', 0); // زيادة العرض من 50 إلى 60 ملم
                    $currentTestsCount +=1;
                }
            }

            // تفريغ المخزن المؤقت
            ob_end_clean();
            // إخراج الملف PDF للمتصفح
            $pdf->Output('blood_choosen_dctor_pdf.pdf', 'I');
            exit;
        } else {
            echo "لم يتم اختيار أي فحوصات. الرجاء اختيار اختبارات الدم وإعادة المحاولة.";
        }
    } else {
        echo "الرجاء اختيار اختبارات الدم وإعادة المحاولة.";
    }
}

/**
 * دالة لإعادة كتابة معلومات المريض عند إضافة صفحة جديدة
 *
 * @param TCPDF $pdf كائن PDF
 * @param int $pat_id معرف المريض
 * @param string $row_fname اسم المريض
 * @param string $pat_date_now تاريخ اليوم
 */
function addPatientInfo($pdf, $pat_id, $row_fname, $pat_date_now) {
    // تعيين الموضع الرأسي للمحتوى عند 30 ملم من الأعلى
    $pdf->SetY(40);
    
    // تحسين شكل بيانات المريض باستخدام جدول
    $pdf->SetFont('freeserif', 'B', 14);
    $pdf->SetFillColor(224, 235, 255); // لون خلفية فاتح للخانات
    // صف معرف المريض
    $pdf->Cell(50, 8, 'معرف المريض:', 1, 0, 'C', 1);
    $pdf->SetFont('freeserif', '', 14);
    $pdf->SetFillColor(255, 255, 255); // خلفية بيضاء للقيم
    $pdf->Cell(60, 8, $pat_id, 1, 0, 'C', 1);
    // صف اسم المريض
    $pdf->SetFont('freeserif', 'B', 14);
    $pdf->SetFillColor(224, 235, 255);
    $pdf->Cell(50, 8, 'اسم المريض:', 1, 0, 'C', 1);
    $pdf->SetFont('freeserif', '', 14);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(50, 8, $row_fname, 1, 1, 'C', 1);
    // صف تاريخ اليوم
    $pdf->SetFont('freeserif', 'B', 14);
    $pdf->SetFillColor(224, 235, 255);
    $pdf->Cell(50, 8, 'تاريخ اليوم:', 1, 0, 'C', 1);
    $pdf->SetFont('freeserif', '', 14);
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Cell(160, 8, $pat_date_now, 1, 1, 'C', 1);
    // يمكنك إضافة المزيد من الحقول هنا إذا لزم الأمر
    $pdf->Ln(10);
}
?>
