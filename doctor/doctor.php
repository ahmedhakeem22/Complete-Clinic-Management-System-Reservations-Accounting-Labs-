<?php
include 'includes/templates/header.php';
include 'includes/templates/navbar2.php';
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم</title>
    <!-- Bootstrap RTL CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.ltr.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="includes/css/styles.css" rel="stylesheet">
    <style>
        /* الخطوط والخلفية */
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* أنماط الشريط الجانبي */
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #2c3e50;
            color: #ecf0f1;
            transition: all 0.3s;
            height: 100vh;
            position: fixed;
            left: 0;
            /* لأن الاتجاه RTL */
            top: 0;
            overflow-y: auto;
            padding: auto;
            z-index: 1000;
            /* لضمان ظهور الشريط الجانبي فوق الشريط العلوي */
        }


        #sidebar.active {
            margin-left: -250px;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background: #1abc9c;
            text-align: center;
        }

        #sidebar ul.components {
            padding: 20px 0;
        }

        #sidebar ul li {
            padding: 10px 20px;
            font-size: 1.1em;
            display: block;
        }

        #sidebar ul li a {
            color: #bdc3c7;
            display: flex;
            align-items: center;
            transition: 0.3s;
        }

        #sidebar ul li a i {
            margin-left: 10px;
        }

        #sidebar ul li a:hover {
            color: #ecf0f1;
            background: #34495e;
            text-decoration: none;
            border-radius: 4px;
        }

        #sidebar ul li.active>a,
        a[aria-expanded="true"] {
            color: #ecf0f1;
            background: #1abc9c;
            border-radius: 4px;
        }

        /* محتوى الصفحة */
        #content {
            width: calc(100% - 250px);
            margin-left: 250px;
            transition: all 0.3s;
            padding: 20px;
        }

        #sidebar.active+#content {
            width: 100%;
            margin: 0;
        }

        /* شريط التنقل العلوي */
        .navbar {
            padding: 15px;
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            border-radius: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            left: 250px;
            /* ترك مساحة للشريط الجانبي */
            right: 0;
            z-index: 999;
            /* تحت الشريط الجانبي */
        }

        /* البطاقات */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: #fff;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.15);
        }

        /* تحديث مقاسات الصور داخل البطاقات */
        .card-img-top {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 180px;
            /* يمكنك تعديل هذا الارتفاع حسب الحاجة */
            width: 100%;
            object-fit: cover;
            /* يضمن تغطية الصورة للمساحة بدون تشويه */
        }


        /* بانر التاريخ */
        .date-banner {
            background: #1abc9c;
            color: #fff;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            font-size: 1.3rem;
            margin-top: 80px;
            /* إضافة مسافة من الأعلى */
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


        /* التذييل */
        footer {
            background: #2c3e50;
            color: #ecf0f1;
            text-align: center;
            padding: 20px 0;
            position: relative;
            bottom: 0;
            width: 100%;
            margin-top: 40px;
            border-top: 1px solid #34495e;
        }

        /* زر التبديل للشريط الجانبي */
        #sidebarCollapse {
            background: #1abc9c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background 0.3s;
            cursor: pointer;
        }

        #sidebarCollapse:hover {
            background: #16a085;
        }

        /* تحسين استجابة التصميم */
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }

            #sidebar.active {
                margin-left: 0;
            }

            #content {
                width: 100%;
                margin: 0;
            }

            #sidebarCollapse {
                display: block;
            }
        }

        /* تحسين الأزرار داخل البطاقات */
        .card .btn {
            width: 100%;
            margin-top: 10px;
            transition: background 0.3s, transform 0.3s;
        }

        .card .btn:hover {
            transform: scale(1.05);
        }

        /* تحسين النص داخل البطاقات */
        .card-title {
            font-weight: 600;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="d-flex">
        <!-- الشريط الجانبي -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h4>لوحة التحكم</h4>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <a href="newsession.php"><i class="fas fa-plus-circle"></i> جلسة جديدة</a>
                </li>

                <li>
                    <a href="select_file_pation.php"><i class="fas fa-chart-line"></i> تقارير المرضى</a>
                </li>

                <li>
                    <a href="book_out.php"><i class="fas fa-receipt"></i> سند صرف</a>
                </li>
                <li>
                    <a href="treasury.php"><i class="fas fa-box"></i> الصندوق</a>
                </li>
                <li>
                    <a href="provider.php"><i class="fas fa-hands-helping"></i> دعم المركز</a>
                </li>
                <li>
                    <a href="today_dates.php"><i class="fas fa-calendar-check"></i> حجوزات اليوم</a>
                </li>

                <li>
                    <a href="manage_tests.php"><i class="fas fa-vial"></i> إدارة الاختبارات</a>
                </li>
                <li>
                    <a href="vendors.php"><i class="fas fa-user-tie"></i> ادارة الموردين</a>
                </li>
                <li>
                    <a href="categories.php"><i class="fas fa-tags"></i> ادارة فئات المصاريف</a>
                </li>
                <li>
                    <a href="employees.php"><i class="fas fa-users"></i> ادارة الموظفين </a>
                </li>

            </ul>
        </nav>

        <!-- محتوى الصفحة -->
        <div id="content">


            <!-- بانر التاريخ -->
            <div class="date-banner" id="dateBanner">
                <!-- سيتم إضافة التاريخ بواسطة JavaScript -->
            </div>

            <!-- محتوى الصفحة الرئيسي -->
            <div class="row">
                <!-- بطاقة جلسة جديدة -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 text-center">
                        <img src="includes/images/jalsa1.PNG" class="card-img-top" alt="جلسة جديدة">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">جلسة جديدة</h5>
                            <a href="newsession.php" class="btn btn-primary mt-auto">
                                <i class="fas fa-plus-circle me-2"></i> ابدأ الآن
                            </a>
                        </div>
                    </div>
                </div>




                <!-- بطاقة فواتير الجلسات -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="card text-center">
                        <img src="../img/searchday.jpg" class="card-img-top" alt="فواتير الجلسات">
                        <div class="card-body">
                            <h5 class="card-title">حجوزات اليوم</h5>
                            <a href="today_dates.php" class="btn btn-info">
                                <i class="fas fa-file-invoice-dollar me-2"></i> عرض
                            </a>
                        </div>
                    </div>
                </div>

                <!-- بطاقة تقارير المرضى -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="card text-center">
                        <img src="includes/images/img9.png" class="card-img-top" alt="تقارير المرضى">
                        <div class="card-body">
                            <h5 class="card-title">تقارير المرضى</h5>
                            <a href="select_file_pation.php" class="btn btn-secondary">
                                <i class="fas fa-chart-line me-2"></i> عرض
                            </a>
                        </div>
                    </div>
                </div>



                <!-- بطاقة سند صرف -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="card text-center">
                        <img src="includes/images/img3.png" class="card-img-top" alt="سند صرف">
                        <div class="card-body">
                            <h5 class="card-title">سند صرف</h5>
                            <a href="book_out.php" class="btn btn-primary">
                                <i class="fas fa-receipt me-2"></i> عرض
                            </a>
                        </div>
                    </div>
                </div>

                <!-- بطاقة الصندوق -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="card text-center">
                        <img src="includes/images/IMG4.png" class="card-img-top" alt="الصندوق">
                        <div class="card-body">
                            <h5 class="card-title">الصندوق</h5>
                            <a href="treasury.php" class="btn btn-success">
                                <i class="fas fa-box me-2"></i> عرض
                            </a>
                        </div>
                    </div>
                </div>

                <!-- بطاقة دعم المركز -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="card text-center">
                        <img src="includes/images/img3.png" class="card-img-top" alt="دعم المركز">
                        <div class="card-body">
                            <h5 class="card-title">دعم المركز</h5>
                            <a href="provider.php" class="btn btn-warning">
                                <i class="fas fa-hands-helping me-2"></i> عرض
                            </a>
                        </div>
                    </div>
                </div>

                <!-- بطاقة إدارة الاختبارات -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="card text-center">
                        <img src="includes/images/manage_tests.png" class="card-img-top" alt="إدارة الاختبارات">
                        <div class="card-body">
                            <h5 class="card-title">إدارة الاختبارات</h5>
                            <a href="manage_tests.php" class="btn btn-primary">
                                <i class="fas fa-vial me-2"></i> إدارة
                            </a>
                        </div>
                    </div>
                </div>

                <!-- بطاقة إدارة الموردين -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="card text-center">
                        <img src="../img/vendor-icon-16.jpg" class="card-img-top" alt="إدارة الاختبارات">
                        <div class="card-body">
                            <h5 class="card-title">إدارة الموردين</h5>
                            <a href="vendors.php" class="btn btn-primary">
                                <i class="fas fa-user-tie me-2"></i> إدارة
                            </a>

                        </div>
                    </div>
                </div>

                <!-- بطاقة إدارة الموظفين -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="card text-center">
                        <img src="../img/manager_8743723.png" class="card-img-top" alt="إدارة الاختبارات">
                        <div class="card-body">
                            <h5 class="card-title">إدارة الموظفين</h5>
                            <a href="employees.php" class="btn btn-primary">
                                <i class="fas fa-users me-2"></i> إدارة
                            </a>

                        </div>
                    </div>
                </div>

                <!-- بطاقة إدارة فئات المصاريف -->
                <div class="col-lg-2 col-md-4 col-sm-6 mb-4">
                    <div class="card text-center">
                        <img src="../img/cost-management_16919198.png" class="card-img-top" alt="إدارة الاختبارات">
                        <div class="card-body">
                            <h5 class="card-title">إدارة المصاريف</h5>
                            <a href="categories.php" class="btn btn-primary">
                                <i class="fas fa-tags me-2"></i> إدارة
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- التذييل -->
    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <!-- Bootstrap JS Bundle (Includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
    <!-- Custom JS -->
    <script>
        // شريط التاريخ بالعربية
        function displayDate() {
            const days = ["الأحد", "الأثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت"];
            const months = ["يناير", "فبراير", "مارس", "أبريل", "مايو", "يونيو",
                "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"];
            const now = new Date();
            const dayName = days[now.getDay()];
            const day = now.getDate();
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            const dateString = `${dayName}, ${day} - ${month} - ${year}`;
            document.getElementById("dateBanner").innerText = dateString;
        }

        document.addEventListener("DOMContentLoaded", displayDate);

        // تفعيل شريط التنقل الجانبي
        document.getElementById("sidebarCollapse").addEventListener("click", function () {
            document.getElementById("sidebar").classList.toggle("active");
        });
    </script>

</body>

</html>