<?php

include '../includes/db.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    date_default_timezone_set("Asia/Aden");
    $pat_date = date("Y-m-d");
    
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $pat_id = 0;
    if (isset($_POST['select']) && isset($_POST['pat_id'])) {
        $pat_id = test_input($_POST['pat_id']);
        $pat_id = mysqli_real_escape_string($conn, $pat_id);
        
        $s = mysqli_query($conn, "SELECT * FROM blood_test WHERE pat_id='$pat_id'");
        
        if (mysqli_num_rows($s) > 0) {
            while ($row = mysqli_fetch_array($s)) {
                echo "<tr>";
                echo "<td> djgdhgdjhg " . $row['pat_id'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "No results found.";
        }
    }
}

$conn->close();
?>