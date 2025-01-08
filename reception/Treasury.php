<?php
// Treasury.php (أو ابقِ الاسم الذي تريده)

// في حال أردت تحويل الصفحة إلى PHP بالكامل، ضع وسوم PHP في الأعلى إن لزم.
// إذا كنت تستخدم هذا الملف بامتداد .php فأنت تحتاج للوسوم أدناه.
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Treasury</title>

    <!-- الروابط الأصلية الخاصة بك -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="includes/css/style1.css">
    <link rel="stylesheet" type="text/css" href="includes/css/style.css">
    <link rel="stylesheet" href="includes/css/bootstrap.min.css">
    <link rel="stylesheet" href="includes/css/font-awesome.min.css">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <style>
        /* تنسيقات الشريط الجانبي */
        #sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 240px;
            height: 100vh;
            background-color: #2c3e50; /* لون خلفية الشريط الجانبي */
            color: #fff;
            transition: all 0.3s;
            z-index: 999;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        #sidebar.active {
            margin-left: -240px;
        }
        .sidebar-header {
            padding: 1.5rem 1rem;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 1.25rem;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .nav-links {
            flex-grow: 1;
            padding-top: 1rem;
        }
        .nav-links a {
            display: block;
            padding: 0.75rem 1rem;
            color: #fff;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
            font-size: 0.95rem;
        }
        .nav-links a:hover {
            background-color: #34495e;
            text-decoration: none;
            color: #fff;
        }

        /* عند تصغير الشاشة */
        @media (max-width: 767.98px) {
            #sidebar {
                margin-left: -240px;
            }
            #sidebar.active {
                margin-left: 0;
            }
        }

        /* تنسيق المنطقة الأساسية للمحتوى مع وجود الـSidebar */
        #content {
            margin-left: 240px; /* نفس عرض الشريط الجانبي */
            transition: margin-left 0.3s;
            min-height: 100vh;
            padding: 0; /* أو يمكنك ضبط الحواف حسب رغبتك */
        }
        @media (max-width: 767.98px) {
            #content {
                margin-left: 0;
            }
        }

        /* زر التبديل (إن أردت استعماله) */
        .toggle-btn {
            margin: 10px;
        }
    </style>
</head>
<body>

<!-- الشريط الجانبي -->
<?php include __DIR__ . '/includes/sidebar.php'; ?>

<!-- إذا لديك navbar خاصة بك من ملف آخر اتركها أو ضعه هنا -->
<?php 
// إن أردت تضمين Navbar من ملف آخر مثل:
// include 'includes/templates/navbar.php'; 
?>

<!-- زر إظهار/إخفاء الشريط الجانبي (اختياري) -->
<!-- يمكنك وضع هذا الزر داخل الـnavbar الخاصة بك -->
<button class="btn btn-outline-secondary toggle-btn" id="toggleSidebar">
    <i class="fa fa-bars"></i>
</button>

<!-- التفاف المحتوى داخل #content -->
<div id="content">
    
    <!-- المحتوى الأصلي للصفحة -->
    <img src="includes/images/Treasury.jpg" alt="image" width="100%" height="auto">
    <br><br>

    <div class="container">
        <div class="loginicon">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="form-group">
                        <div>
                            <img src="includes/images/img5.png" alt="">
                            <a href="Bloodtest.php">Blood test</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <div>
                            <img src="includes/images/img4.png" alt="">
                            <a href="choess_nafsy_box.php">Psychological examination</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <footer>
        <!-- Footer content -->
    </footer>

</div><!-- نهاية #content -->

<!-- سكربتات الـBootstrap والـFontAwesome -->
<script src="includes/js/bootstrap.min.js"></script>
<script src="includes/js/font-awesome.min.js"></script>

<!-- سكربت التبديل لإظهار/إخفاء الـSidebar -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("toggleSidebar");
        const sidebar = document.getElementById("sidebar");
        const content = document.getElementById("content");

        toggleBtn.addEventListener("click", function () {
            sidebar.classList.toggle("active");
            if (sidebar.classList.contains("active")) {
                // إذا تم إخفاء الشريط
                content.style.marginLeft = "0";
            } else {
                // إذا تم عرض الشريط
                content.style.marginLeft = "240px";
            }
        });
    });
</script>
</body>
</html>
