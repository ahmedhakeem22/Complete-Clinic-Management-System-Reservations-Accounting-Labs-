<?php 
include 'templats/header.php';
include 'templats/navbar.php';
include '../includes/db.php'; // تضمين ملف الاتصال بقاعدة البيانات

///////////////date system ///////////////////////
date_default_timezone_set("Asia/Aden");
$pat_date = date("Y-m-d h:i:sa");               

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$r = null; // تعريف مسبق للمتغير $r

// /////////////select from session by patient ID //////////////
if (isset($_POST['Submit_pation'])) {
    $pat_id = $_POST['pat_id'];

    if (empty($pat_id)) {
        echo "<p style='color: red;'>Patient ID is required</p>";
    } else {
        // تنفيذ الاستعلام
        $query = "SELECT * FROM invoice WHERE pat_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $pat_id);
        $stmt->execute();
        $r = $stmt->get_result(); // الحصول على النتيجة
    }
}
?>

<main class="main">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <table id="mytable" cellspacing="15" cellpadding="0">
            <tr>
                <td>
                    <label for="no.p">Patient No:</label>
                    <input type="number" id="nosession" name="pat_id">
                </td>
                <td>
                    <label for="no.p">Patient name:</label>
                </td>
                <td>
                    <input type="submit" value="Submit" name="Submit_pation">
                </td>
            </tr>
        </table>

        <table class="borderjalsa2" cellspacing="15" cellpadding="0" style="top:20%;">
            <?php 
            // التحقق من وجود نتائج في $r
            if ($r && $r->num_rows > 0) {
                while ($row = $r->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>INVOICE ID: " . $row['invoice_id'] . "</td>";
                    echo "</tr>";
                    echo "<tr>";
                    echo "<td>Patient ID: " . $row['pat_id'] . "</td>";
                    echo "<td>" . $row['name_ser'] . "</td>";
                    echo "<td>" . $row['cost_ser'] . "</td>";
                    echo "<td>" . $row['invoice_date'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No results found.</td></tr>";
            }
            ?>
        </table>
    </form>
</main>

<footer class="footer"></footer>
</body>
</html>
