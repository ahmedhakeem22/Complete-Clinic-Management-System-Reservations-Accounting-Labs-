<?php

// استدعاء ملف الاتصال بقاعدة البيانات
include '../includes/db.php';  // تأكد من المسار الصحيح للملف

if(isset($_GET['pat_id'])) {

    $pat_idd = 0;
    if (isset($_GET['Submit_pation'])) {
        $pat_idd = $_GET['pat_idd'];
        $r = mysqli_query($conn, "SELECT fname, age, gander, phone FROM patinte WHERE pat_idd = $pat_idd");
    }

    if ($pat_idd > 0) {
        while ($row = mysqli_fetch_array($r)) {
            echo "<tr>";
            echo "<td> Name : " . $row['fname'] . "</td>";
            echo "<td> Age : " . $row['age'] . "</td>";
            echo "<td> Gander : " . $row['gander'] . "</td>";
            echo "<td> Phone : " . $row['phone'] . "</td>";
            echo "</tr>";
        }
    }
}

// غلق الاتصال بقاعدة البيانات
$conn->close();
?>
