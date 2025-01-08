<!-- C:\Users\Zainon\Herd\htdocs\doctor\includes\templates\navbar2.php -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <!-- زر التبديل للشريط الجانبي -->
        <button type="button" id="sidebarCollapse" class="btn btn-outline-light me-2">
            <i class="fas fa-bars"></i>
        </button>

        <!-- زر التوسيع في الشاشات الصغيرة -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="doctor.php">الرئيسية<span class="visually-hidden">(الحالية)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="news.php">الأخبار</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="contact.php">اتصل بنا</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="about.php">حول</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        المستخدم
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="doctor.php" target="_blank">الطبيب</a></li>
                        <li><a class="dropdown-item" href="../reception/reception.php" target="_blank">الاستقبال</a></li>
                        <li><a class="dropdown-item" href="../nafsi/nafsi.php" target="_blank">المختبر النفسي</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="../blood/index.php" target="_blank">مختبر الدم</a></li>
                        <li><a class="dropdown-item" href="../pharm" target="_blank">الصيدلية</a></li>
                    </ul>
                </li> 
            </ul>
        </div>
    </div>
</nav>
