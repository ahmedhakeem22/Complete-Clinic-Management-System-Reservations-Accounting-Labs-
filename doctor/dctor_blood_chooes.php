<?php
include '../includes/db.php';
?>

<h3 class="mb-4 text-center" style="font-weight: bold; color: #333;">اختر الفحوصات الدموية</h3>

<!-- Patient ID -->
<div class="form-group row mb-4">
    <label for="PatientID" class="col-sm-2 col-form-label" style="font-weight: bold;">معرف المريض:</label>
    <div class="col-sm-10">
        <input 
            type="number" 
            class="form-control" 
            id="PatientID" 
            name="pat_id" 
            placeholder="أدخل معرف المريض" 
            required
        >
    </div>
</div>
<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #eef2f7;
        margin: 0;
        padding: 0;
        color: #333;
    }

    h3 {
        font-weight: bold;
        color: #2c3e50;
        text-align: center;
        margin: 20px 0;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        color: #34495e;
    }

    #PatientID {
        border: 1px solid #bdc3c7;
        padding: 10px;
        border-radius: 5px;
    }

    .form-group input[type="checkbox"] {
        -webkit-appearance: none;
        width: 18px;
        height: 18px;
        background-color: #ecf0f1;
        border: 2px solid #3498db;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease-in-out;
    }

    .form-group input[type="checkbox"]:checked {
        background-color: #2ecc71;
        border-color: #27ae60;
        transform: scale(1.1);
    }

    .test-section {
        background-color: #ffffff;
        border: 1px solid #dcdcdc;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    .test-section label {
        font-size: 20px;
        color: #2980b9;
        font-weight: bold;
        margin-bottom: 10px;
        display: block;
    }

    .test-items {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }

    .test-items label {
        font-size: 16px;
        color: #2c3e50;
        display: flex;
        align-items: center;
        gap: 10px;
        cursor: pointer;
        padding: 10px;
        border: 1px solid #dcdcdc;
        border-radius: 5px;
        background-color: #f9f9f9;
        transition: all 0.3s ease-in-out;
    }

    .test-items label:hover {
        background-color: #f1f1f1;
        border-color: #3498db;
    }

    .test-items label.highlight {
        background-color: #f39c12;
        color: white;
    }

    .form-group.row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
    }

    .form-group.row label {
        flex-basis: 20%;
        text-align: right;
    }

    .form-group.row input {
        flex-basis: 75%;
        padding: 10px;
        border: 1px solid #bdc3c7;
        border-radius: 5px;
    }

    .form-group.row input:focus {
        border-color: #3498db;
        outline: none;
        box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
    }

    footer {
        margin-top: 20px;
        text-align: center;
        padding: 10px;
        background-color: #34495e;
        color: #ecf0f1;
        font-size: 14px;
    }
</style>

<div class="form-group" style="font-size:22px; font-family:Tahoma;">
    <?php
    function getTestsByIds($conn, array $ids) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $orderField = implode(',', $ids);

        $sql = "SELECT test_id, test_name, is_parent, parent_test_id FROM tests
                WHERE test_id IN ($placeholders)
                AND is_sub_test_level != 1
                ORDER BY FIELD(test_id, $orderField)";

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die('خطأ في تحضير الاستعلام: ' . $conn->error);
        }
        $types = str_repeat('i', count($ids));
        $stmt->bind_param($types, ...$ids);

        $stmt->execute();
        $res = $stmt->get_result();

        $tests = [];
        while ($row = $res->fetch_assoc()) {
            $tests[] = $row;
        }
        $stmt->close();
        return $tests;
    }

    $categories = [
        'HAEMATOLOGY' => [1, 101, 102, 2, 3, 4, 7, 8, 9, 10, 11, 12, 13],
        'BIOCHEMISTRY' => [
            14, 15, 16, 17, 18, 104, 105, 19, 106, 107, 108, 109,
            20, 21, 22, 110, 111, 112, 113, 114, 23, 115, 116, 117,
            24, 118, 119, 120, 121, 25, 39
        ],
        'SEROLOGY' => [26, 27, 28, 29, 30, 31, 32, 33, 122, 123, 124, 36, 37, 38],
        'DRUGS' => [40, 41, 42, 43, 44, 45, 46, 47],
        'HORMONES' => [48, 49, 50, 51, 52, 53, 54, 55, 56, 57]
    ];

    foreach ($categories as $category => $ids) {
        echo '<div class="test-section">';
        echo "<label>$category</label><br/>";

        $tests = getTestsByIds($conn, $ids);

        echo '<div class="test-items">';
        foreach ($tests as $test) {
            $tid = $test['test_id'];
            $name = $test['test_name'];
            $isParent = $test['is_parent'];
            $parentTestId = $test['parent_test_id'];

            // Check if the test should have a special color
            $highlightClass = ($isParent == 1 || !empty($parentTestId)) ? 'highlight' : '';

            echo "<label class='$highlightClass'><input type='checkbox' name='test[]' value='$tid'> $name</label>";
        }
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>
