<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My New Dashboard</title>

  <!-- Bootstrap 5 CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <!-- Font Awesome -->
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />
  <!-- Google Fonts (Optional) -->
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap"
    rel="stylesheet"
  />
  
  <style>
    body {
      font-family: "Poppins", sans-serif; 
      margin: 0;
      padding: 0;
      background-color: #f8f9fa; /* Light gray background */
      min-height: 100vh;
      position: relative;
    }

    /* Sidebar */
    #sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 240px;
      height: 100vh;
      background-color: #2c3e50; /* Dark blue-gray */
      color: #fff;
      transition: all 0.3s;
      z-index: 999;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
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

    /* Sidebar Collapse for mobile */
    #sidebar.active {
      margin-left: -240px;
    }

    /* Top Navbar */
    .navbar-custom {
      margin-left: 240px;
      background-color: #fff;
      border-bottom: 1px solid #dee2e6;
      transition: margin-left 0.3s;
      z-index: 998;
    }

    .navbar-brand {
      font-weight: 600;
    }

    /* Main content area */
    #content {
      margin-left: 240px;
      padding: 2rem;
      transition: margin-left 0.3s;
      min-height: calc(100vh - 60px); /* Navbar height accounted for */
    }

    /* Cards */
    .card-custom {
      border: none;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .card-custom:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 16px rgba(0,0,0,0.2);
    }

    /* Make image behave like an icon */
    .icon-img {
      width: 60px;         /* عرض الصورة */
      height: 60px;        /* ارتفاع الصورة */
      object-fit: contain; /* الحفاظ على الأبعاد بدون تشوه */
      margin: 0 auto;      /* توسيط الصورة أفقياً داخل البطاقة */
      display: block;      /* لضمان عمل الـmargin: 0 auto */
    }

    /* Footer */
    footer.footer {
      position: fixed;
      bottom: 0;
      left: 240px;
      width: calc(100% - 240px);
      background-color: #2c3e50;
      color: #fff;
      text-align: center;
      padding: 0.8rem 0;
      font-size: 0.9rem;
      transition: left 0.3s, width 0.3s;
    }
    

    /* Mobile Media Query */
    @media (max-width: 767.98px) {
      #sidebar {
        margin-left: -240px;
      }
      #sidebar.active {
        margin-left: 0;
      }
      .navbar-custom {
        margin-left: 0;
      }
      #content {
        margin-left: 0;
      }
      footer.footer {
        left: 0;
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <?php include __DIR__ . '/includes/sidebar.php'; ?>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-custom shadow-sm">
    <div class="container-fluid">
      <button class="btn btn-outline-secondary ms-2" id="toggleSidebar">
        <i class="fas fa-bars"></i>
      </button>
      <a class="navbar-brand ms-3" href="#">Reception Panel</a>
    </div>
  </nav>

  <!-- Main Content -->
  <div id="content">
    <div class="container-fluid">
      <h1 class="mb-4">Welcome to Your New Reception Admin Panel</h1>
      <div class="row g-3">
        <!-- Card 1 -->
        <div class="col-md-6 col-lg-4">
          <div class="card card-custom">
            <img
              src="includes/images/oldpatinte.jpg"
              class="icon-img"
              alt="Random"
            />
            <div class="card-body">
              <h5 class="card-title">Patients</h5>
              <p class="card-text">
                Access and manage all patient records easily.
              </p>
              <a href="patients.php" class="btn btn-primary">
                <i class="fas fa-chart-line me-1"></i> View Details
              </a>
            </div>
          </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-6 col-lg-4">
          <div class="card card-custom">
            <img
              src="includes/images/searchday.jpg"
              class="icon-img"
              alt="Schedule"
            />
            <div class="card-body">
              <h5 class="card-title">Appointments</h5>
              <p class="card-text">
                View upcoming appointments, schedule, or reschedule them.
              </p>
              <a href="today_dates.php" class="btn btn-warning text-dark">
                <i class="fas fa-calendar-check me-1"></i> Check Appointments
              </a>
            </div>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-6 col-lg-4">
          <div class="card card-custom">
            <img
              src="includes/images/box.jpg"
              class="icon-img"
              alt="Billing"
            />
            <div class="card-body">
              <h5 class="card-title">Billing</h5>
              <p class="card-text">
                Handle invoices, payments, and track revenue seamlessly.
              </p>
              <a href="Treasury.php" class="btn btn-info text-white">
                <i class="fas fa-file-invoice-dollar me-1"></i> Go to Billing
              </a>
            </div>
          </div>
        </div>

        <!-- Card 5 -->
        <div class="col-md-6 col-lg-4">
          <div class="card card-custom">
            <img
              src="includes/images/searchicon.jpg"
              class="icon-img"
              alt="Search"
            />
            <div class="card-body">
              <h5 class="card-title">Search Records</h5>
              <p class="card-text">
                Quickly find any record or file using our new smart search.
              </p>
              <a href="Search_appointment.php" class="btn btn-secondary">
                <i class="fas fa-search me-1"></i> Search
              </a>
            </div>
          </div>
        </div>

      </div><!-- End row -->
    </div><!-- End container -->
  </div>
  <!-- End Main Content -->

  <!-- Footer -->
  <!-- (Add your footer code here if needed) -->

  <!-- Bootstrap Bundle JS & FontAwesome JS -->
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
          if(footer) {
            footer.style.left = "0";
            footer.style.width = "100%";
          }
        } else {
          // Sidebar is visible
          content.style.marginLeft = "240px";
          if(footer) {
            footer.style.left = "240px";
            footer.style.width = "calc(100% - 240px)";
          }
        }
      });
    });
  </script>
</body>
</html>
