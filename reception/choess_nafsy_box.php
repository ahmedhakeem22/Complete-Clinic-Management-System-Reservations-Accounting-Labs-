<?php 
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>اختيار الاختبارات النفسية</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet" integrity="sha384-XLhr69cnx5j0GQ6vA6RbDfsxS2BAKX2V8T2MBrF6ilVJcS45NJoI1GtrgJo5sYTI" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .hero-image {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
        }
        .form-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: -100px;
            z-index: 1;
            position: relative;
        }
        .form-title {
            margin-bottom: 20px;
            font-family: 'Tahoma', sans-serif;
        }
        .checkbox-group {
            max-height: 500px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #f1f3f5;
        }
        .checkbox-group .form-check {
            margin-bottom: 10px;
        }
        .submit-btn {
            width: 100%;
        }
        .loading-spinner {
            display: none;
            margin-left: 10px;
        }
        @media (max-width: 576px) {
            .form-container {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body> 

    <!-- صورة البطل -->
    <img src="../img/Psychological.jpg" alt="صورة نفسية" class="hero-image">

    <!-- المحتوى الرئيسي -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="form-container">
                    <form action="choess_nafsy_box_pdf.php" method="get" id="testForm">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="patient_id" class="form-label">معرف المريض</label>
                                <input type="number" class="form-control" id="patient_id" name="pat_id" required>
                                <div id="patient_id_feedback" class="form-text text-danger"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="patient_name" class="form-label">اسم المريض</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="patient_name" name="fname" placeholder="سيتم جلب الاسم تلقائيًا" readonly>
                                    <span class="input-group-text loading-spinner" id="loadingSpinner">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    </span>
                                </div>
                                <div id="patient_name_feedback" class="form-text text-danger"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <button type="submit" name="add_sess" class="btn btn-success submit-btn">حفظ</button>
                        </div>
                        <h3 class="form-title">اختر الاختبارات اللازمة</h3>
                        <div class="checkbox-group">
                            <!-- إضافة جميع الاختبارات الـ37 هنا -->
                            <?php
                            // مصفوفة تحتوي على جميع الاختبارات
                            $tests = [
                                1 => "الاختبارات الستة الكل",
                                2 => "اختبار وايزمان للمعتقدات",
                                3 => "اختبار ايزليك للشخصية",
                                4 => "اختبار تاكيد الذات",
                                5 => "اختبار تقدير الذات",
                                6 => "اختبار وجهة الضبط",
                                7 => "اختبار ساكس لتكملة الجمل",
                                8 => "مقياس الدافعية والرغبة في الإدمان",
                                9 => "استبيان معتقدات الشخصية",
                                10 => "اختبار الشخصية المتعددة الأوجه MMPI",
                                11 => "مقياس بيك للاكتئاب",
                                12 => "مقياس كولومبيا للانتحار",
                                13 => "مقياس تابلور للقلق",
                                14 => "مقياس الوسواس القهري وشدته",
                                15 => "مقياس الاسيست للإدمان",
                                16 => "مقياس الذكاء المصور",
                                17 => "اختبار الجشطلت",
                                18 => "مقياس كرب بعد الصدمة",
                                19 => "مقياس الهوس",
                                20 => "اختبار وكسلر لذكاء المراهقين والبالغين",
                                21 => "اختبار وكسلر لذكاء الأطفال ما قبل سن المراهقة",
                                22 => "مقياس تقييم الأعراض الانسحابية للكحول",
                                23 => "مقياس تقييم الأعراض الانسحابية للبنزوديازيبين",
                                24 => "مقياس تقييم أعراض الإدمان على البنزوديازيبين",
                                25 => "مقياس تقييم الأعراض الانسحابية للأفيونات",
                                26 => "استبيان تقييم شدة الإدمان على الأفيونات",
                                27 => "استبيان تقييم الإدمان على الكحول",
                                28 => "اختبار التات (TAT)",
                                29 => "مقياس فرط النشاط وقلة الانتباه",
                                30 => "مقياس الدور الجنسي (ذكور-إناث)",
                                31 => "مقياس الرهاب الاجتماعي",
                                32 => "مقياس القلق الاجتماعي",
                                33 => "فحص الحالة العقلية",
                                34 => "مقياس الهلع",
                                35 => "استبيان التوافق الزوجي",
                                36 => "مقياس تشخيص اضطراب التوحد للأطفال",
                                37 => "مقياس إيلي براون"
                            ];

                            foreach ($tests as $id => $test_name) {
                                echo '
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="test[]" value="'.$id.'" id="test'.$id.'">
                                    <label class="form-check-label" for="test'.$id.'">
                                        '.$test_name.'
                                    </label>
                                </div>
                                ';
                            }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- التذييل -->
    <footer class="footer bg-light py-4">
        <div class="container text-center">
            &copy; <?php echo date("Y"); ?> جميع الحقوق محفوظة.
        </div>
    </footer>

    <!-- Bootstrap JS والمكتبات التابعة (Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+LzAhj8YF5qRZZZgk8b9hBvoMQQeN" crossorigin="anonymous"></script>
    <!-- JavaScript لجلب اسم المريض -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const patientIdInput = document.getElementById('patient_id');
            const patientNameInput = document.getElementById('patient_name');
            const patientIdFeedback = document.getElementById('patient_id_feedback');
            const patientNameFeedback = document.getElementById('patient_name_feedback');
            const loadingSpinner = document.getElementById('loadingSpinner');

            patientIdInput.addEventListener('blur', function() {
                const pat_id = patientIdInput.value.trim();
                if (pat_id === '') {
                    patientNameInput.value = '';
                    return;
                }

                // إظهار مؤشر التحميل
                loadingSpinner.style.display = 'inline-block';
                patientNameFeedback.textContent = '';

                // إرسال طلب AJAX باستخدام Fetch API
                fetch(`fetch_patient_name.php?pat_id=${encodeURIComponent(pat_id)}`)
                    .then(response => response.json())
                    .then(data => {
                        loadingSpinner.style.display = 'none';
                        if (data.success) {
                            patientNameInput.value = data.fname;
                            patientIdFeedback.textContent = '';
                        } else {
                            patientNameInput.value = '';
                            patientIdFeedback.textContent = data.error;
                        }
                    })
                    .catch(error => {
                        loadingSpinner.style.display = 'none';
                        patientNameInput.value = '';
                        patientIdFeedback.textContent = 'حدث خطأ أثناء جلب اسم المريض.';
                        console.error('Error fetching patient name:', error);
                    });
            });
        });
    </script>
</body>
</html>
