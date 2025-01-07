<?php 
// Include essential files (header, navbar, database connection)
include 'includes/templates/header.php';  
include 'includes/templates/navbar.php';
include '../includes/db.php';

// Function to sanitize inputs
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Patient Data</title>
  
  <!-- Include Bootstrap for improved styling -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

  <!-- Include Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Include jQuery (if still needed for certain plugins or your custom code) -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Custom CSS for Modern, Elegant Design -->
  <style>
    /* 
    ========================
      GLOBAL STYLES
    ========================
    */
    body {
      font-family: "Montserrat", sans-serif; /* Example modern font */
      background: #fdfdfd; /* Soft, modern background */
      color: #333;
    }

    h2, h4 {
      font-weight: 600;
    }

    /* Cards & Elements */
    .card {
      border: none;
      border-radius: 10px;
      overflow: hidden;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .card-header {
      background: linear-gradient(135deg, #007bff, #6f42c1); 
      /* Example gradient color; adjust to match your brand */
      color: #fff;
      font-weight: 500;
      border-bottom: none;
    }

    .card-body {
      background-color: #fff;
      padding: 2rem;
    }

    .list-group-item {
      border: none;
      border-bottom: 1px solid #f1f1f1;
    }

    .table thead th {
      background-color: #e9ecef;
      font-weight: 600;
    }

    .table tbody tr:hover {
      background-color: #f7f9fa;
      cursor: pointer;
    }

    /* Buttons */
    .btn-primary {
      background-color: #6f42c1;
      border-color: #6f42c1;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .btn-primary:hover {
      background-color: #5b33a1;
      transform: translateY(-2px);
    }

    .btn-info {
      background-color: #198754;
      border-color: #198754;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }
    .btn-info:hover {
      background-color: #157347;
      transform: translateY(-2px);
    }

    /* Print Button Styles */
    .print-button {
      display: flex;
      align-items: center;
      gap: 5px;
      transition: background-color 0.3s ease;
    }

    .print-button:hover {
      background-color: #0d6efd;
    }

    /* 
    ========================
      FORM STYLES
    ========================
    */
    .search-form {
      background: #ffffff;
      border-radius: 10px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      padding: 2rem;
      margin-bottom: 2rem;
    }

    /* 
    ========================
      ANIMATIONS
    ========================
    */
    /* Simple fade-in for cards */
    .fade-in {
      opacity: 0;
      transform: translateY(20px);
      animation: fadeInUp 0.5s forwards ease-in-out;
    }

    @keyframes fadeInUp {
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Add a slight scale effect on hover for the entire card if desired */
    .card:hover {
      transform: scale(1.01);
      transition: transform 0.3s ease;
    }

    /* 
    ========================
      RESPONSIVE TWEAKS
    ========================
    */
    @media (max-width: 768px) {
      .search-form {
        padding: 1rem;
      }
      .card-body {
        padding: 1rem;
      }
      .table-responsive {
        margin-top: 1rem;
      }
    }
  </style>
</head>
<body>

<div class="container my-5">

    <h2 class="mb-4 text-center">Search for Patient Data</h2>
    
    <!-- Search Form -->
    <form action="" method="GET" class="search-form row g-3 mb-4 justify-content-center fade-in">
      <div class="col-md-4">
        <label for="pat_id" class="form-label">Patient ID:</label>
        <input 
          type="number" 
          name="pat_id" 
          id="pat_id" 
          class="form-control" 
          placeholder="Enter Patient ID" 
          required
        >
      </div>
      <div class="col-md-2 align-self-end">
        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-search"></i> View
        </button>
      </div>
    </form>

<?php
// Check if patient ID is set and is a number
if(isset($_GET['pat_id']) && is_numeric($_GET['pat_id'])){
    
    $pat_id = (int)test_input($_GET['pat_id']);

    // Fetch basic patient data using prepared statements
    $stmtPat = $conn->prepare("SELECT * FROM patinte WHERE pat_id = ?");
    $stmtPat->bind_param("i", $pat_id);
    $stmtPat->execute();
    $resultPat = $stmtPat->get_result();

    if($rowPat = $resultPat->fetch_assoc()){
        echo "<h4 class='mb-3 fade-in'>Patient Information:</h4>";
        echo "<div class='card mb-4 shadow-sm fade-in'>";
        echo "<div class='card-header'>Basic Details</div>";
        echo "<ul class='list-group list-group-flush'>";
        echo "<li class='list-group-item'><strong>Patient ID:</strong> " . $rowPat['pat_id'] . "</li>";
        echo "<li class='list-group-item'><strong>Name:</strong> " . $rowPat['fname'] . "</li>";
        echo "<li class='list-group-item'><strong>Age:</strong> " . $rowPat['age'] . "</li>";
        echo "<li class='list-group-item'><strong>Phone:</strong> " . $rowPat['phone'] . "</li>";
        echo "<li class='list-group-item'><strong>Gender:</strong> " . ucfirst($rowPat['gander']) . "</li>";
        echo "<li class='list-group-item'><strong>Country:</strong> " . ucfirst($rowPat['contry']) . "</li>";
        echo "<li class='list-group-item'><strong>City:</strong> " . ucfirst($rowPat['city']) . "</li>";
        echo "<li class='list-group-item'><strong>Marital Status:</strong> " . ucfirst($rowPat['soc_sts']) . "</li>";
        echo "<li class='list-group-item'><strong>Number of Children:</strong> " . $rowPat['chel_num'] . "</li>";
        echo "<li class='list-group-item'><strong>Occupation:</strong> " . ucfirst($rowPat['jop']) . "</li>";
        echo "<li class='list-group-item'><strong>Marriage Date:</strong> " . date("F j, Y", strtotime($rowPat['rig_pat'])) . "</li>";
        echo "<li class='list-group-item'><strong>Completion Date:</strong> " . date("F j, Y", strtotime($rowPat['date_com'])) . "</li>";
        echo "</ul>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-danger fade-in'>Sorry, no patient found with this ID.</div>";
        exit();
    }

    // Display Sessions in a single table
    $stmtSessions = $conn->prepare("
        SELECT * FROM session 
        WHERE pat_id = ?
          AND (
            TRIM(main_com)     <> '' OR
            TRIM(period_ill)   <> '' OR
            TRIM(sex_hist)     <> '' OR
            TRIM(person_hist)  <> '' OR
            TRIM(curr_hist)    <> ''
          )
        ORDER BY date_now DESC
    ");
    $stmtSessions->bind_param("i", $pat_id);
    $stmtSessions->execute();
    $resultSessions = $stmtSessions->get_result();

    if(mysqli_num_rows($resultSessions) > 0){
        echo "<h4 class='mb-3 fade-in'>Session Records:</h4>";
        
        echo "<div class='card mb-4 shadow-sm fade-in'>";
        echo "<div class='card-header'>Sessions</div>";
        echo "<div class='card-body'>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-hover'>";
        echo "<thead>";
        echo "<tr>
                <th>Session ID</th>
                <th>Session Date</th>
                <th>Next Session Date</th>
                <th>Actions</th>
              </tr>";
        echo "</thead>";
        echo "<tbody>";

        while($session = $resultSessions->fetch_assoc()){
            echo "<tr>";
            echo "<td>" . $session['id_session'] . "</td>";
            echo "<td>" . date("F j, Y", strtotime($session['date_now'])) . "</td>";
            echo "<td>" . date("F j, Y", strtotime($session['date_next'])) . "</td>";
            echo "<td>
                    <button 
                      class='btn btn-info btn-sm view-session-data' 
                      data-pat-id='".$pat_id."' 
                      data-session-id='".$session['id_session']."'>
                      <i class='bi bi-eye'></i> View Details
                    </button>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>"; // End of table-responsive
        echo "</div>"; // End of card-body
        echo "</div>"; // End of card
    } else {
        echo "<div class='alert alert-warning fade-in'>No non-empty sessions recorded for this patient.</div>";
    }

    // Display Tests
    $stmtTests = $conn->prepare("
        SELECT tr.result_date, COUNT(tr.result_id) as count_tests
        FROM test_results tr
        WHERE tr.pat_id = ?
          AND TRIM(tr.value) <> ''
        GROUP BY tr.result_date
        ORDER BY tr.result_date DESC
    ");
    $stmtTests->bind_param("i", $pat_id);
    $stmtTests->execute();
    $resultTests = $stmtTests->get_result();

    if(mysqli_num_rows($resultTests) > 0){
        echo "<h4 class='mb-3 fade-in'>Tests:</h4>";

        echo "<div class='card mb-4 shadow-sm fade-in'>";
        echo "<div class='card-header'>Tests</div>";
        echo "<div class='card-body'>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-hover'>";
        echo "<thead>";
        echo "<tr>
                <th>Test Date</th>
                <th>Number of Tests</th>
                <th>Actions</th>
              </tr>";
        echo "</thead>";
        echo "<tbody>";

        while($testGroup = $resultTests->fetch_assoc()){
            $date = date("F j, Y", strtotime($testGroup['result_date']));
            $count = $testGroup['count_tests'];
            echo "<tr>";
            echo "<td>" . $date . "</td>";
            echo "<td>" . $count . "</td>";
            echo "<td>
                    <button 
                      class='btn btn-info btn-sm view-tests-by-date' 
                      data-pat-id='".$pat_id."' 
                      data-date='".$testGroup['result_date']."'>
                      <i class='bi bi-eye'></i> View Tests
                    </button>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>"; 
        echo "</div>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-warning fade-in'>No non-empty tests found for this patient.</div>";
    }

    // Display Medical Prescriptions
    $stmtMedical = $conn->prepare("
        SELECT med.date_t, COUNT(med.id) as count_meds
        FROM medical med
        WHERE med.pat_id = ?
          AND TRIM(med.med_name) <> ''
        GROUP BY med.date_t
        ORDER BY med.date_t DESC
    ");
    $stmtMedical->bind_param("i", $pat_id);
    $stmtMedical->execute();
    $resultMedical = $stmtMedical->get_result();

    if(mysqli_num_rows($resultMedical) > 0){
        echo "<h4 class='mb-3 fade-in'>Medical Prescriptions:</h4>";

        echo "<div class='card mb-4 shadow-sm fade-in'>";
        echo "<div class='card-header'>Medical Prescriptions</div>";
        echo "<div class='card-body'>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-bordered table-hover'>";
        echo "<thead>";
        echo "<tr>
                <th>Prescription Date</th>
                <th>Number of Prescriptions</th>
                <th>Actions</th>
              </tr>";
        echo "</thead>";
        echo "<tbody>";

        while($medGroup = $resultMedical->fetch_assoc()){
            $date = date("F j, Y", strtotime($medGroup['date_t']));
            $count = $medGroup['count_meds'];
            echo "<tr>";
            echo "<td>" . $date . "</td>";
            echo "<td>" . $count . "</td>";
            echo "<td>
                    <button 
                      class='btn btn-info btn-sm view-medical-by-date' 
                      data-pat-id='".$pat_id."' 
                      data-date='".$medGroup['date_t']."'>
                      <i class='bi bi-eye'></i> View Prescriptions
                    </button>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
        echo "</div>"; 
        echo "</div>";
        echo "</div>";
    } else {
        echo "<div class='alert alert-warning fade-in'>No non-empty medical prescriptions found for this patient.</div>";
    }

    // Display Psychological Tests
    $stmtPsych = $conn->prepare("
        SELECT tp.result_date, COUNT(tp.id_Psychological) as count_psych
        FROM test_psychological tp
        WHERE tp.pat_id = ?
          AND TRIM(tp.result) <> ''
        GROUP BY tp.result_date
        ORDER BY tp.result_date DESC
    ");
    if (!$stmtPsych) {
       echo "<div class='alert alert-danger fade-in'>Failed to prepare psychological tests query: " . $conn->error . "</div>";
       exit();
    }
    $stmtPsych->bind_param("i", $pat_id);
    if (!$stmtPsych->execute()) {
       echo "<div class='alert alert-danger fade-in'>Failed to execute psychological tests query: " . $stmtPsych->error . "</div>";
       exit();
    }
    $resultPsych = $stmtPsych->get_result();

    if (mysqli_num_rows($resultPsych) > 0) {
       echo "<h4 class='mb-3 fade-in'>Psychological Tests:</h4>";

       echo "<div class='card mb-4 shadow-sm fade-in'>";
       echo "<div class='card-header'>Psychological Tests</div>";
       echo "<div class='card-body'>";
       echo "<div class='table-responsive'>";
       echo "<table class='table table-bordered table-hover'>";
       echo "<thead>";
       echo "<tr>
               <th>Test Date</th>
               <th>Number of Tests</th>
               <th>Actions</th>
             </tr>";
       echo "</thead>";
       echo "<tbody>";

       while ($psychGroup = $resultPsych->fetch_assoc()) {
           $date = date("F j, Y", strtotime($psychGroup['result_date']));
           $count = $psychGroup['count_psych'];
           echo "<tr>";
           echo "<td>" . $date . "</td>";
           echo "<td>" . $count . "</td>";
           echo "<td>
                   <button 
                     class='btn btn-info btn-sm view-psych-by-date' 
                     data-pat-id='" . $pat_id . "' 
                     data-date='" . $psychGroup['result_date'] . "'>
                     <i class='bi bi-eye'></i> View Tests
                   </button>
                 </td>";
           echo "</tr>";
       }

       echo "</tbody>";
       echo "</table>";
       echo "</div>"; 
       echo "</div>";
       echo "</div>";
    } else {
       echo "<div class='alert alert-warning fade-in'>No non-empty psychological tests found for this patient.</div>";
    }

} // End of if(isset($_GET['pat_id']))
?>

</div>

<!-- Footer file -->
<?php include 'includes/templates/footer.php'; ?>

<!-- 
  ================================
       MODALS FOR DETAILS
  ================================
-->

<!-- Session Details Modal -->
<div class="modal fade" id="sessionModal" tabindex="-1" aria-labelledby="sessionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="sessionModalLabel">
          <i class="bi bi-clipboard-data"></i> Session Details
        </h5>
        <button 
          type="button" 
          class="btn-close" 
          data-bs-dismiss="modal" 
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body" id="sessionModalBody">
        <!-- Details will be loaded here via AJAX -->
      </div>
      <div class="modal-footer">
        <button 
          type="button" 
          class="btn btn-secondary" 
          data-bs-dismiss="modal"
        >
          <i class="bi bi-x-circle"></i> Close
        </button>
        <button 
          type="button" 
          class="btn btn-primary print-button" 
          data-print-target="#sessionModalBody"
        >
          <i class="bi bi-printer"></i> Print
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Tests by Date Modal -->
<div class="modal fade" id="testsByDateModal" tabindex="-1" aria-labelledby="testsByDateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="testsByDateModalLabel">
          <i class="bi bi-clipboard-data"></i> Test Details
        </h5>
        <button 
          type="button" 
          class="btn-close" 
          data-bs-dismiss="modal" 
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body" id="testsByDateModalBody">
        <!-- Details will be loaded here via AJAX -->
      </div>
      <div class="modal-footer">
        <button 
          type="button" 
          class="btn btn-secondary" 
          data-bs-dismiss="modal"
        >
          <i class="bi bi-x-circle"></i> Close
        </button>
        <button 
          type="button" 
          class="btn btn-primary print-button" 
          data-print-target="#testsByDateModalBody"
        >
          <i class="bi bi-printer"></i> Print
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Medical Prescriptions by Date Modal -->
<div class="modal fade" id="medicalByDateModal" tabindex="-1" aria-labelledby="medicalByDateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="medicalByDateModalLabel">
          <i class="bi bi-clipboard-data"></i> Medical Prescriptions Details
        </h5>
        <button 
          type="button" 
          class="btn-close" 
          data-bs-dismiss="modal" 
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body" id="medicalByDateModalBody">
        <!-- Details will be loaded here via AJAX -->
      </div>
      <div class="modal-footer">
        <button 
          type="button" 
          class="btn btn-secondary" 
          data-bs-dismiss="modal"
        >
          <i class="bi bi-x-circle"></i> Close
        </button>
        <button 
          type="button" 
          class="btn btn-primary print-button" 
          data-print-target="#medicalByDateModalBody"
        >
          <i class="bi bi-printer"></i> Print
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Psychological Tests by Date Modal -->
<div class="modal fade" id="psychByDateModal" tabindex="-1" aria-labelledby="psychByDateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="psychByDateModalLabel">
          <i class="bi bi-clipboard-data"></i> Psychological Tests Details
        </h5>
        <button 
          type="button" 
          class="btn-close" 
          data-bs-dismiss="modal" 
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body" id="psychByDateModalBody">
        <!-- Details will be loaded here via AJAX -->
      </div>
      <div class="modal-footer">
        <button 
          type="button" 
          class="btn btn-secondary" 
          data-bs-dismiss="modal"
        >
          <i class="bi bi-x-circle"></i> Close
        </button>
        <button 
          type="button" 
          class="btn btn-primary print-button" 
          data-print-target="#psychByDateModalBody"
        >
          <i class="bi bi-printer"></i> Print
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Include Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JS -->
<script>
$(document).ready(function(){
    // Handle View Session Details button click
    $('.view-session-data').click(function(){
        var pat_id = $(this).data('pat-id');
        var session_id = $(this).data('session-id');

        // Load session details via AJAX
        $.ajax({
            url: 'get_session_details.php',
            type: 'GET',
            data: { pat_id: pat_id, session_id: session_id },
            beforeSend: function(){
                $('#sessionModalBody').html(
                  '<div class="text-center my-3">' + 
                    '<div class="spinner-border text-primary" role="status">' + 
                      '<span class="visually-hidden">Loading...</span>' +
                    '</div>' +
                  '</div>'
                );
                $('#sessionModal').modal('show');
            },
            success: function(response){
                $('#sessionModalBody').html(response);
            },
            error: function(){
                $('#sessionModalBody').html(
                  '<div class="alert alert-danger">An error occurred while loading details.</div>'
                );
            }
        });
    });

    // Handle View Tests by Date button click
    $('.view-tests-by-date').click(function(){
        var pat_id = $(this).data('pat-id');
        var date = $(this).data('date');

        // Load test details via AJAX
        $.ajax({
            url: 'get_tests_by_date.php',
            type: 'GET',
            data: { pat_id: pat_id, date: date },
            beforeSend: function(){
                $('#testsByDateModalBody').html(
                  '<div class="text-center my-3">' +
                    '<div class="spinner-border text-primary" role="status">' +
                      '<span class="visually-hidden">Loading...</span>' +
                    '</div>' +
                  '</div>'
                );
                $('#testsByDateModal').modal('show');
            },
            success: function(response){
                $('#testsByDateModalBody').html(response);
            },
            error: function(){
                $('#testsByDateModalBody').html(
                  '<div class="alert alert-danger">An error occurred while loading details.</div>'
                );
            }
        });
    });

    // Handle View Medical Prescriptions by Date button click
    $('.view-medical-by-date').click(function(){
        var pat_id = $(this).data('pat-id');
        var date = $(this).data('date');

        // Load medical prescription details via AJAX
        $.ajax({
            url: 'get_medical_by_date.php',
            type: 'GET',
            data: { pat_id: pat_id, date: date },
            beforeSend: function(){
                $('#medicalByDateModalBody').html(
                  '<div class="text-center my-3">' + 
                    '<div class="spinner-border text-primary" role="status">' + 
                      '<span class="visually-hidden">Loading...</span>' +
                    '</div>' +
                  '</div>'
                );
                $('#medicalByDateModal').modal('show');
            },
            success: function(response){
                $('#medicalByDateModalBody').html(response);
            },
            error: function(){
                $('#medicalByDateModalBody').html(
                  '<div class="alert alert-danger">An error occurred while loading details.</div>'
                );
            }
        });
    });

    // Handle View Psychological Tests by Date button click
    $('.view-psych-by-date').click(function(){
        var pat_id = $(this).data('pat-id');
        var date = $(this).data('date');

        // Load psychological test details via AJAX
        $.ajax({
            url: 'get_psychological_by_date.php',
            type: 'GET',
            data: { pat_id: pat_id, date: date },
            beforeSend: function(){
                $('#psychByDateModalBody').html(
                  '<div class="text-center my-3">' +
                    '<div class="spinner-border text-primary" role="status">' +
                      '<span class="visually-hidden">Loading...</span>' +
                    '</div>' +
                  '</div>'
                );
                $('#psychByDateModal').modal('show');
            },
            success: function(response){
                $('#psychByDateModalBody').html(response);
            },
            error: function(){
                $('#psychByDateModalBody').html(
                  '<div class="alert alert-danger">An error occurred while loading details.</div>'
                );
            }
        });
    });

    // Handle Print button click
    $('.print-button').click(function(){
        var printTarget = $(this).data('print-target');
        var printContent = $(printTarget).html();
        
        // Create a new window for printing
        var printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Print</title>');
        // Include Bootstrap for styling in print
        printWindow.document.write(
          '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">'
        );
        printWindow.document.write('</head><body>');
        printWindow.document.write(printContent);
        printWindow.document.write('</body></html>');

        printWindow.document.close();
        printWindow.focus();

        // Delay printing to ensure content is loaded
        setTimeout(function(){
            printWindow.print();
            printWindow.close();
        }, 500);
    });
});
</script>
</body>
</html>
