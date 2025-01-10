<?php
// تضمين الملفات اللازمة
require_once __DIR__ . '/../vendor/autoload.php';
require_once '../includes/db.php'; // تأكد من أن مسار ملف قاعدة البيانات صحيح

// تعيين المنطقة الزمنية
date_default_timezone_set("Asia/Aden");
$date = date("Y-m-d");

// دالة لتنقية المدخلات
function test_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// التأكد من أن النموذج تم إرساله عبر POST وأن الحقول المطلوبة موجودة
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['pat_id'], $_POST['med_name'], $_POST['quantity'], $_POST['usage'])) {
        $pat_id = (int)test_input($_POST['pat_id']);
        $med_names = $_POST['med_name'];
        $quantities = $_POST['quantity'];
        $usages = $_POST['usage'];

        // التحقق من وجود المريض
        $s = mysqli_prepare($conn, "SELECT fname FROM patinte WHERE pat_id = ?");
        if (!$s) {
            die("خطأ في تحضير الاستعلام: " . $conn->error);
        }
        mysqli_stmt_bind_param($s, 'i', $pat_id);
        mysqli_stmt_execute($s);
        mysqli_stmt_bind_result($s, $row_fname);
        mysqli_stmt_fetch($s);
        mysqli_stmt_close($s);

        if (!$row_fname) {
            die("المريض غير موجود.");
        }

        // بدء معاملة
        $conn->begin_transaction();

        // إدراج في جدول الوصفات الطبية
        $stmt_presc = $conn->prepare("INSERT INTO prescriptions (pat_id, fname, date_t, status) VALUES (?, ?, ?, 'pending')");
        if (!$stmt_presc) {
            die("خطأ في تحضير الاستعلام: " . $conn->error);
        }
        $stmt_presc->bind_param("iss", $pat_id, $row_fname, $date);
        if (!$stmt_presc->execute()) {
            $conn->rollback();
            die("خطأ في الإدراج في جدول الوصفات الطبية: " . $stmt_presc->error);
        }
        $prescription_id = $stmt_presc->insert_id;
        $stmt_presc->close();

        // إعداد استعلام الإدراج للأدوية
        $stmt_med = $conn->prepare("INSERT INTO medical (prescription_id, pat_id, fname, med_name, usee, countity, date_t) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt_med) {
            $conn->rollback();
            die("خطأ في تحضير الاستعلام: " . $conn->error);
        }

        // إعداد خيارات الاستخدام
        $usageOptions = [
            1  => 'حبة قبل الفطور',
            2  => 'نصف حبة قبل الفطور',
            3  => 'حبة بعد الفطور',
            4  => 'نصف حبة بعد الفطور',
            5  => 'حبة قبل الغداء',
            6  => 'نصف حبة قبل الغداء',
            7  => 'حبة بعد الغداء',
            8  => 'نصف حبة بعد الغداء',
            9  => 'حبة قبل العشاء',
            10 => 'نصف حبة قبل العشاء',
            11 => 'حبة بعد العشاء',
            12 => 'نصف حبة بعد العشاء',
            13 => 'حبة قبل النوم',
            14 => 'نصف حبة قبل النوم',
            15 => 'حبة كل أسبوع',
            16 => 'مرتين في الأسبوع',
            // أضف المزيد من الخيارات حسب الحاجة
        ];

        for ($j = 0; $j < count($med_names); $j++) {
            $med_name = test_input($med_names[$j]);
            $quantity = (int)test_input($quantities[$j]);
            $selected_usages = isset($usages[$j]) ? $usages[$j] : [];

            // توليد نص "طريقة الاستخدام"
            $medcal_skills = [];
            foreach ($selected_usages as $usage_id) {
                if (isset($usageOptions[$usage_id])) {
                    $medcal_skills[] = $usageOptions[$usage_id];
                }
            }
            $medcal_skills_str = implode(', ', $medcal_skills);

            // ربط المعاملات: prescription_id, pat_id, fname, med_name, usee, countity, date_t
            $stmt_med->bind_param("iisssis", $prescription_id, $pat_id, $row_fname, $med_name, $medcal_skills_str, $quantity, $date);

            if (!$stmt_med->execute()) {
                $conn->rollback();
                die("خطأ في الإدراج في جدول الأدوية: " . $stmt_med->error);
            }
        }

        $stmt_med->close();
        $conn->commit();

        // عرض رسالة نجاح أو إعادة توجيه
        echo "تم إرسال الوصفة الطبية بنجاح إلى الصيدلي.";
    } else {
        die("بيانات النموذج غير كاملة.");
    }
} else {
    die("طريقة الطلب غير صالحة.");
}
?>
