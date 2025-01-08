<?php
// تضمين رأس الصفحة ونافذة التنقل
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';

// تضمين الاتصال بقاعدة البيانات
include '../includes/db.php';

// ضبط المنطقة الزمنية الافتراضية
date_default_timezone_set("Asia/Aden");
$pat_date = date("Y-m-d");

// دالة لتنقية المدخلات
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// تهيئة المتغيرات
$pat_id = 0;
$bookings = [];
$patient = [];

// التعامل مع طلب POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ok'])) {
    $pat_id = test_input($_POST['pat_id']);
    
    // جلب تفاصيل المريض
    $stmt = $conn->prepare("SELECT fname, phone FROM patinte WHERE pat_id = ?");
    $stmt->bind_param("i", $pat_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $patient = $result->fetch_assoc();
    $stmt->close();
}

// جلب الحجوزات لليوم الحالي
$query = "
    SELECT 
        invoice.invoice_id,
        invoice.fname,
        patinte.age,
        patinte.phone,
        patinte.gander,
        patinte.soc_sts,
        patinte.chel_num,
        invoice.invoice_date,
        invoice.name_ser,
        invoice.cost_ser
    FROM 
        invoice
    INNER JOIN 
        patinte ON invoice.pat_id = patinte.pat_id
    WHERE 
        DATE(invoice.invoice_date) = ?
    ORDER BY 
        invoice.invoice_id DESC
";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $pat_date);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>حجوزات اليوم</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- رابط Bootstrap CSS لتحسين التصميم -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        main {
            padding: 20px;
        }
        .search-container {
            margin-bottom: 20px;
        }
        #myInput {
            direction: rtl;
            text-align: right;
        }
        table {
            width: 100%;
        }
        thead {
            background-color: #0d6efd;
            color: white;
        }
        th, td {
            vertical-align: middle !important;
        }
        @media (max-width: 768px) {
            .table-responsive-stack tr {
                display: flex;
                flex-direction: column;
                margin-bottom: 15px;
                border: 1px solid #dee2e6;
                border-radius: 5px;
                padding: 10px;
                background-color: #fff;
            }
            .table-responsive-stack td {
                display: flex;
                justify-content: space-between;
                padding: 8px;
                border: none;
                border-bottom: 1px solid #dee2e6;
            }
            .table-responsive-stack td:last-child {
                border-bottom: none;
            }
            .table-responsive-stack td:before {
                content: attr(data-label);
                font-weight: bold;
                width: 50%;
                display: inline-block;
                text-align: right;
            }
        }
    </style>
</head>
<body> 
    <main class="container">
        <div class="mb-4">
            <img src="../img/today.jpg" alt="صورة اليوم" class="img-fluid rounded">
        </div>
        
        <!-- نموذج البحث -->
        <div class="search-container">
            <input type="text" id="myInput" class="form-control" onkeyup="filterTable()" placeholder="بحث عن الحجوزات...">
        </div>
        
        <!-- جدول الحجوزات -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="myTable">
                <thead class="table-primary">
                    <tr>
                        <th>المعرف</th>
                        <th>الاسم الكامل</th>
                        <th>العمر</th>
                        <th>الهاتف</th>
                        <th>الجنس</th>
                        <th>الحالة الاجتماعية</th>
                        <th>عدد الأطفال</th>
                        <th>اسم الخدمة</th>
                        <th>تكلفة الخدمة</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($bookings)): ?>
                        <?php foreach($bookings as $booking): ?>
                            <tr>
                                <td data-label="المعرف"><?php echo htmlspecialchars($booking['invoice_id']); ?></td>
                                <td data-label="الاسم الكامل"><?php echo htmlspecialchars($booking['fname']); ?></td>
                                <td data-label="العمر"><?php echo htmlspecialchars($booking['age']); ?></td>
                                <td data-label="الهاتف"><?php echo htmlspecialchars($booking['phone']); ?></td>
                                <td data-label="الجنس"><?php echo htmlspecialchars($booking['gander']); ?></td>
                                <td data-label="الحالة الاجتماعية"><?php echo htmlspecialchars($booking['soc_sts']); ?></td>
                                <td data-label="عدد الأطفال"><?php echo htmlspecialchars($booking['chel_num']); ?></td>
                                <td data-label="اسم الخدمة"><?php echo htmlspecialchars($booking['name_ser']); ?></td>
                                <td data-label="تكلفة الخدمة"><?php echo htmlspecialchars($booking['cost_ser']); ?> ريال</td>
                                <td data-label="التاريخ"><?php echo htmlspecialchars($booking['invoice_date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center">لا توجد حجوزات لليوم.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- سكريبت البحث -->
        <script>
            function filterTable() {
                const input = document.getElementById("myInput");
                const filter = input.value.toUpperCase();
                const table = document.getElementById("myTable");
                const tr = table.getElementsByTagName("tr");
                
                for (let i = 1; i < tr.length; i++) { // البدء من 1 لتخطي الرأس
                    let visible = false;
                    const td = tr[i].getElementsByTagName("td");
                    for (let j = 0; j < td.length; j++) {
                        if (td[j]) {
                            const txtValue = td[j].textContent || td[j].innerText;
                            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                                visible = true;
                                break;
                            }
                        }
                    }
                    tr[i].style.display = visible ? "" : "none";
                }
            }
        </script>
        
        <!-- تحسينات إضافية باستخدام Bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </main>
    
    <footer class="bg-light text-center text-lg-start mt-5">
        <div class="text-center p-3">
            © 2025 جميع الحقوق محفوظة.
        </div>
    </footer>
</body>
</html>
