<!DOCTYPE html>
<html lang="ar" dir="ltr">  
<head>
    <meta charset="utf-8" />
    <title>Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- أيقونة الموقع -->
    <link rel="icon" href="../images/icon1.png" type="image/png" sizes="16x16">
    
    <!-- Bootstrap CSS من CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    
    <!-- ملفات CSS الخاصة بك -->
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/style1.css">
    <link rel="stylesheet" type="text/css" href="../css/sidebar.css"  />

</head>
<body>

    <!-- محتوى الصفحة -->

    <!-- تضمين jQuery و Popper.js و Bootstrap JS من CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
  ></script>
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"
  ></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const toggleBtn = document.getElementById("toggleSidebar");
      const sidebar = document.getElementById("sidebar");
      const content = document.getElementById("content");
      const footer = document.querySelector("footer.footer");

      toggleBtn.addEventListener("click", function () {
        sidebar.classList.toggle("active");

        if (sidebar.classList.contains("active")) {
          // Sidebar is hidden
          content.style.marginLeft = "0";
          footer.style.left = "0";
          footer.style.width = "100%";
        } else {
          // Sidebar is visible
          content.style.marginLeft = "240px";
          footer.style.left = "240px";
          footer.style.width = "calc(100% - 240px)";
        }
      });
    });
  </script>
    
    <!-- ملفات JavaScript الخاصة بك -->
    <script src="../js/main.js"></script>
</body>
</html>
