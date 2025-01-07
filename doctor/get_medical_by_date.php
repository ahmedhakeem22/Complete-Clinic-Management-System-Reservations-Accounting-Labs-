<?php
// Enable error reporting (for debugging purposes - make sure to disable it in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Include database connection
include '../includes/db.php';

// Function to sanitize inputs
function test_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if(isset($_GET['pat_id']) && isset($_GET['date']) && is_numeric($_GET['pat_id']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['date'])){
    
    $pat_id = (int)test_input($_GET['pat_id']);
    $date = test_input($_GET['date']);

    // Fetch medical prescriptions on the specified date
    $stmtMedical = $conn->prepare("
        SELECT * FROM medical 
        WHERE pat_id = ?
          AND date_t = ?
          AND TRIM(med_name) <> ''
        ORDER BY date_t DESC, med_name ASC
    ");
    if(!$stmtMedical){
        echo "<div class='alert alert-danger'>Failed to prepare medical prescriptions query: " . $conn->error . "</div>";
        exit();
    }
    $stmtMedical->bind_param("is", $pat_id, $date);
    if(!$stmtMedical->execute()){
        echo "<div class='alert alert-danger'>Failed to execute medical prescriptions query: " . $stmtMedical->error . "</div>";
        exit();
    }
    $resultMedical = $stmtMedical->get_result();

    if(mysqli_num_rows($resultMedical) > 0){
        echo "<h5>Medical prescription details on date: $date</h5>";
        echo "<table class='table table-striped table-bordered mt-3'>";
        echo "<thead class='table-info'>
                <tr>
                    <th>Medicine Name</th>
                    <th>Usage Instructions</th>
                    <th>Dosage Count</th>
                    <th>Date</th>
                </tr>
              </thead>
              <tbody>";

        while($med = $resultMedical->fetch_assoc()){
            echo "<tr>";
            echo "<td>".$med['med_name']."</td>";
            echo "<td>".$med['usee']."</td>";
            echo "<td>".$med['countity']."</td>";
            echo "<td>".$med['date_t']."</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-warning'>No medical prescriptions on this date.</div>";
    }

} else {
    echo "<div class='alert alert-danger'>Invalid inputs provided.</div>";
}
?>
