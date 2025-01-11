<?php
// sale.php

// Enable CORS if necessary (optional, depending on your setup)
// header("Access-Control-Allow-Origin: *");
// header("Content-Type: application/json; charset=UTF-8");

// Include necessary files
require_once __DIR__ . '/../vendor/autoload.php';
require_once '../includes/db.php'; // Ensure the database path is correct

// Set the timezone
date_default_timezone_set("Asia/Aden");
$date = date("Y-m-d");

// Function to sanitize input data
function test_input($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to send JSON responses
function sendResponse($status, $message)
{
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are present
    if (isset($_POST['pat_id'], $_POST['med_name'], $_POST['quantity'], $_POST['usage'])) {
        // Sanitize and assign form data
        $pat_id = (int)test_input($_POST['pat_id']);
        $med_names = $_POST['med_name'];
        $quantities = $_POST['quantity'];
        $usages = $_POST['usage'];

        // Verify if the patient exists
        $stmt = mysqli_prepare($conn, "SELECT fname FROM patinte WHERE pat_id = ?");
        if (!$stmt) {
            sendResponse('error', "خطأ في تحضير الاستعلام: " . $conn->error);
        }
        mysqli_stmt_bind_param($stmt, 'i', $pat_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $row_fname);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if (!$row_fname) {
            sendResponse('error', "المريض غير موجود.");
        }

        // Begin transaction
        $conn->begin_transaction();

        // Insert into prescriptions table
        $stmt_presc = $conn->prepare("INSERT INTO prescriptions (pat_id, fname, date_t, status) VALUES (?, ?, ?, 'pending')");
        if (!$stmt_presc) {
            $conn->rollback();
            sendResponse('error', "خطأ في تحضير الاستعلام: " . $conn->error);
        }
        $stmt_presc->bind_param("iss", $pat_id, $row_fname, $date);
        if (!$stmt_presc->execute()) {
            $conn->rollback();
            sendResponse('error', "خطأ في الإدراج في جدول الوصفات الطبية: " . $stmt_presc->error);
        }
        $prescription_id = $stmt_presc->insert_id;
        $stmt_presc->close();

        // Prepare insert statement for medications
        $stmt_med = $conn->prepare("INSERT INTO medical (prescription_id, pat_id, fname, med_name, usee, countity, date_t) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt_med) {
            $conn->rollback();
            sendResponse('error', "خطأ في تحضير الاستعلام: " . $conn->error);
        }

        // Define usage options
        $usageOptions = [
            1  => 'حبة قبل الفطور',
            2  => 'نصف حبة قبل الفطور',
            3  => 'حبة بعد الفطور',
            4  => 'نصف حبة بعد الفطور',
            5  => 'حبة قبل الغداء',
            6  => 'نصف حبة قبل الغداء',
            7  => 'حبة بعد الغداء',
            8  => 'نصف حبة بعد الغداء',
            9  => 'حبة قبل العشاء',
            10 => 'نصف حبة قبل العشاء',
            11 => 'حبة بعد العشاء',
            12 => 'نصف حبة بعد العشاء',
            13 => 'حبة قبل النوم',
            14 => 'نصف حبة قبل النوم',
            15 => 'حبة كل أسبوع',
            16 => 'مرتين في الأسبوع',
            // Add more options as needed
        ];

        // Insert each medication
        for ($j = 0; $j < count($med_names); $j++) {
            $med_name = test_input($med_names[$j]);
            $quantity = (int)test_input($quantities[$j]);
            $selected_usages = isset($usages[$j]) ? $usages[$j] : [];

            // Generate usage string
            $medcal_skills = [];
            foreach ($selected_usages as $usage_id) {
                if (isset($usageOptions[$usage_id])) {
                    $medcal_skills[] = $usageOptions[$usage_id];
                }
            }
            $medcal_skills_str = implode(', ', $medcal_skills);

            // Bind parameters: prescription_id, pat_id, fname, med_name, usee, countity, date_t
            $stmt_med->bind_param("iisssis", $prescription_id, $pat_id, $row_fname, $med_name, $medcal_skills_str, $quantity, $date);

            if (!$stmt_med->execute()) {
                $conn->rollback();
                sendResponse('error', "خطأ في الإدراج في جدول الأدوية: " . $stmt_med->error);
            }
        }

        $stmt_med->close();
        $conn->commit();

        // Return success response
        sendResponse('success', "تم إرسال الوصفة الطبية بنجاح إلى الصيدلي.");
    } else {
        sendResponse('error', "بيانات النموذج غير كاملة.");
    }
} else {
    sendResponse('error', "طريقة الطلب غير صالحة.");
}
?>
