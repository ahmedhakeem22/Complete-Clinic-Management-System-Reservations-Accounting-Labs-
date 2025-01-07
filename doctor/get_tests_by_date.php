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

    // Fetch test results for the specified date
    $stmtTests = $conn->prepare("
        SELECT tr.*, t.test_name, t.normal_range 
        FROM test_results tr
        JOIN tests t ON tr.test_id = t.test_id
        WHERE tr.pat_id = ?
          AND tr.result_date = ?
          AND TRIM(tr.value) <> ''
        ORDER BY tr.result_date DESC, t.test_name ASC
    ");
    if(!$stmtTests){
        echo "<div class='alert alert-danger'>Failed to prepare test query: " . $conn->error . "</div>";
        exit();
    }
    $stmtTests->bind_param("is", $pat_id, $date);
    if(!$stmtTests->execute()){
        echo "<div class='alert alert-danger'>Failed to execute test query: " . $stmtTests->error . "</div>";
        exit();
    }
    $resultTests = $stmtTests->get_result();

    if(mysqli_num_rows($resultTests) > 0){
        echo "<h5>Test Details for Date: $date</h5>";
        echo "<table class='table table-striped table-bordered mt-3'>";
        echo "<thead class='table-secondary'>
                <tr>
                    <th>Test Name</th>
                    <th>Value</th>
                    <th>Normal Range</th>
                    <th>Result Date</th>
                </tr>
              </thead>
              <tbody>";

        while($test = $resultTests->fetch_assoc()){
            echo "<tr>";
            echo "<td>".$test['test_name']."</td>";
            echo "<td>".$test['value']."</td>";
            echo "<td>".$test['normal_range']."</td>";
            echo "<td>".$test['result_date']."</td>";
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-warning'>No test results found for this date.</div>";
    }

} else {
    echo "<div class='alert alert-danger'>Invalid inputs provided.</div>";
}
?>
