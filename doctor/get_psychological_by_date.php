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

// Debugging code to view received values
if(isset($_GET['pat_id']) && isset($_GET['date'])) {
    $pat_id_received = $_GET['pat_id'];
    $date_received = $_GET['date'];
    // Print received values for debugging
    echo "<div class='alert alert-info'>Received pat_id: $pat_id_received and date: $date_received</div>";
} else {
    echo "<div class='alert alert-danger'>Required data not received.</div>";
    exit();
}

// Validate inputs
if(is_numeric($_GET['pat_id']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['date'])) {
    
    $pat_id = (int)test_input($_GET['pat_id']);
    $date = test_input($_GET['date']);

    // Fetch psychological tests for the specified date
    $stmtPsych = $conn->prepare("
        SELECT * FROM test_psychological 
        WHERE pat_id = ?
          AND DATE(result_date) = ?
          AND TRIM(result) <> ''
        ORDER BY result_date DESC, name_test ASC
    ");
    if(!$stmtPsych) {
        echo "<div class='alert alert-danger'>Failed to prepare psychological test query: " . $conn->error . "</div>";
        exit();
    }
    $stmtPsych->bind_param("is", $pat_id, $date);
    if(!$stmtPsych->execute()) {
        echo "<div class='alert alert-danger'>Failed to execute psychological test query: " . $stmtPsych->error . "</div>";
        exit();
    }
    $resultPsych = $stmtPsych->get_result();

    if(mysqli_num_rows($resultPsych) > 0) {
        echo "<h5>Psychological Test Details for Date: $date</h5>";
        echo "<table class='table table-striped table-bordered mt-3'>";
        echo "<thead class='table-warning'>
                <tr>
                    <th>Test Name</th>
                    <th>Result</th>
                    <th>Notes</th>
                    <th>Result Date</th>
                </tr>
              </thead>
              <tbody>";

        while($psych = $resultPsych->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$psych['name_test']."</td>";
            echo "<td>".$psych['result']."</td>";
            echo "<td>".$psych['notes']."</td>";
            echo "<td>".date("Y-m-d", strtotime($psych['result_date']))."</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-warning'>No psychological tests found for this date.</div>";
    }

} else {
    echo "<div class='alert alert-danger'>Invalid inputs provided.</div>";
}
?>
