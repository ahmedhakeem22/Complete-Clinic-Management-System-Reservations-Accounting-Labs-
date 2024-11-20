<?php 
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';
?>

<?php
// استدعاء ملف الاتصال بقاعدة البيانات
include '../includes/db.php';

// التحقق من الاتصال بقاعدة البيانات
if ($conn->connect_error) {
    die("<div class='alert alert-danger text-center m-3'>فشل الاتصال بقاعدة البيانات: " . $conn->connect_error . "</div>");
} else {
  
    // تعيين المنطقة الزمنية
    date_default_timezone_set("Asia/Aden");
    $pat_date = date("Y-m-d H:i:s");               

    // دالة لتنظيف المدخلات
    function test_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // معالجة النموذج عند الإرسال
    if(isset($_POST['add_pp'])){

        // الحصول على وتطهير المدخلات
        $first_name    = test_input($_POST['first_name']);
        $second_name   = test_input($_POST['second_name']);
        $third_name    = test_input($_POST['third_name']);
        $last_name     = test_input($_POST['last_name']);
        $Pat_fname     = "$first_name $second_name $third_name $last_name";
        
        $pat_age       = test_input($_POST['pat_age']);
        $pat_phon      = test_input($_POST['pat_phon']);
        $pat_gander    = test_input($_POST['pat_gander']);
        $pat_contry    = test_input($_POST['pat_contry']);
        $pat_city      = test_input($_POST['pat_city']);
        $Pat_sts       = test_input($_POST['Pat_sts']);
        $pat_chel      = test_input($_POST['pat_chel']);
        $pat_jop       = test_input($_POST['pat_jop']);
        $pat_prig      = test_input($_POST['pat_prig']);
        $pat_note      = test_input($_POST['pat_note']);
        $birthdaytime  = test_input($_POST['birthdaytime']);

        // التحقق من صحة الاسم الكامل
        if (empty($Pat_fname)) {
            $message = "<div class='alert alert-danger text-center'>الاسم الكامل مطلوب.</div>";
        }
        // التحقق من صحة رقم الهاتف
        elseif (!preg_match('/^(77|78|70|71|73)\d{7}$/', $pat_phon)) {
            $message = "<div class='alert alert-danger text-center'>رقم الهاتف غير صالح. يجب أن يبدأ بـ 77، 78، 70، 71، أو 73 ويكون بطول 9 أرقام.</div>";
        }
        else {
            // تحضير الاستعلام
            $stmt = $conn->prepare("INSERT INTO patinte (fname, age, phone, gander, contry, city, soc_sts, chel_num, jop, rig_pat, note_pat, date_com, birthdaytime)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            if($stmt === false){
                $message = "<div class='alert alert-danger text-center'>خطأ في تحضير الاستعلام: " . $conn->error . "</div>";
            } else {
                // ربط المعاملات مع أنواع البيانات المناسبة
                $stmt->bind_param("sisssssssssss", $Pat_fname, $pat_age, $pat_phon, $pat_gander, $pat_contry, $pat_city, $Pat_sts, $pat_chel, $pat_jop, $pat_prig, $pat_note, $pat_date, $birthdaytime);
                
                // تنفيذ الاستعلام والتحقق من النجاح
                if($stmt->execute()){
                    $message = "<div class='alert alert-success text-center'>تم حفظ البيانات بنجاح.</div>";
                } else {
                    $message = "<div class='alert alert-danger text-center'>حدث خطأ: " . $stmt->error . "</div>";
                }

                // إغلاق الاستعلام
                $stmt->close();
            }
        }

        // إغلاق الاتصال بقاعدة البيانات
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إضافة مريض جديد</title>
    <!-- إضافة الروابط اللازمة للـ CSS مثل Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/includes/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .bordernew {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .newpattable label {
            font-weight: bold;
        }
        .newpationimg img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .btn-custom-success {
            background-color: #28a745;
            color: #fff;
        }
        .btn-custom-warning {
            background-color: #ffc107;
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="container my-5">
        <?php 
            if(isset($message)) {
                echo $message;
            }
        ?>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <main>
                <div class="newpationimg text-center mb-4">
                    <img src="includes/images/newfile.jpg" alt="Image" class="img-fluid">
                </div>
                <div id="content" class="bordernew">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="no_p" class="form-label">رقم المريض:</label>
                            <input type="text" id="no_p" name="pat_pid" class="form-control" readonly value="سيتم التوليد تلقائيًا">
                        </div>
                        <div class="col-md-9">
                            <label class="form-label">الاسم الرباعي:</label>
                            <div class="row g-2">
                                <div class="col-md-3">
                                    <input type="text" id="first_name" name="first_name" class="form-control" placeholder="الاسم الأول" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="second_name" name="second_name" class="form-control" placeholder="الاسم الثاني" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="third_name" name="third_name" class="form-control" placeholder="الاسم الثالث" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" id="last_name" name="last_name" class="form-control" placeholder="اسم العائلة" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="age" class="form-label">العمر:</label>
                            <input type="number" id="age" name="pat_age" class="form-control" min="0" placeholder="مثال: 30">
                        </div>
                        <div class="col-md-3">
                            <label for="mobile" class="form-label">رقم الهاتف:</label>
                            <input type="text" id="mobile" name="pat_phon" class="form-control" pattern="^(77|78|70|71|73)\d{7}$" title="يجب أن يبدأ بـ 77، 78، 70، 71، أو 73 ويكون بطول 9 أرقام" placeholder="مثال: 771234567" required>
                        </div>
                        <div class="col-md-3">
                            <label for="country" class="form-label">البلد:</label>
                            <input type="text" id="country" name="pat_contry" class="form-control" placeholder="مثال: اليمن">
                        </div>
                        <div class="col-md-3">
                            <label for="city" class="form-label">المدينة:</label>
                            <input type="text" id="city" name="pat_city" class="form-control" placeholder="مثال: صنعاء">
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">الحالة الاجتماعية:</label>
                            <select id="status" name="Pat_sts" class="form-select">
                                <option selected>اختر...</option>
                                <option value="Married">متزوج</option>
                                <option value="Unmarried">غير متزوج</option>
                                <option value="absolute">مطلق</option>
                                <option value="Widower">أرمل</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="gender" class="form-label">الجنس:</label>
                            <select id="gender" name="pat_gander" class="form-select">
                                <option selected>اختر...</option>
                                <option value="M">ذكر</option>
                                <option value="F">أنثى</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="nochild" class="form-label">عدد الأطفال:</label>
                            <input type="number" id="nochild" name="pat_chel" class="form-control" min="0" placeholder="مثال: 2">
                        </div>
                        <div class="col-md-3">
                            <label for="jop" class="form-label">الوظيفة:</label>
                            <input type="text" id="jop" name="pat_jop" class="form-control" placeholder="مثال: مهندس">
                        </div>
                        <div class="col-md-3">
                            <label for="religion" class="form-label">الديانة:</label>
<select id="religion" name="pat_prig" class="form-select">
    <!-- <option selected>اختر...</option> -->
    <option value="Islam">الإسلام</option>
    <option value="Christianity">المسيحية</option>
    <option value="Judaism">اليهودية</option>
    <option value="Hinduism">الهندوسية</option>
    <option value="Buddhism">البوذية</option>
    <option value="Other">أخرى</option>
</select>
                        </div>
                        <div class="col-md-3">
                            <label for="birthdaytime" class="form-label">تاريخ الميلاد:</label>
                            <input type="date" id="birthdaytime" name="birthdaytime" class="form-control">
                        </div>
                        <div class="col-12">
                            <label for="Notes" class="form-label">ملاحظات:</label>
                            <textarea id="Notes" name="pat_note" class="form-control" style="font-size:17px; resize:none; background-color: #f6f6f6;" rows="5" placeholder="أضف ملاحظات هنا..."></textarea> 
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button class="btn btn-custom-success me-2" type="submit" name="add_pp">حفظ الملف</button>
                            <button type="reset" class="btn btn-custom-warning">مسح الحقول</button>
                        </div>
                    </div>
                </div>
            </main>
        </form>
    </div>
    
    <footer class="footer mt-5">
        <!-- يمكنك إضافة محتوى الفوتر هنا -->
    </footer>
    
    <!-- إضافة الروابط اللازمة للـ JS مثل Bootstrap و jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/includes/js/bootstrap.bundle.min.js"></script>
    <script>
        // مثال لتحسين تجربة المستخدم: إظهار رسالة نجاح بعد فترة زمنية
        document.addEventListener("DOMContentLoaded", function(){
            const alert = document.querySelector('.alert');
            if(alert){
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 5000); // يخفي الرسالة بعد 5 ثوانٍ
            }
        });
    </script>
</body>
</html>
