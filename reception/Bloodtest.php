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
    input[type='checkbox'] {
        -webkit-appearance: none;
        width: 20px;
        height: 20px;
        background: white;
        border-radius: 5px;
        border: 1px solid green;
        cursor: pointer;
        transition: 0.3s;
    }
    input[type='checkbox']:checked {
        background: red;
        transform: scale(1.2);
    }
    .form-group label {
        font-weight: bold;
        color: #555;
        margin-bottom: 10px;
    }
    .test-section {
        margin-bottom: 30px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }
    .test-section label {
        color: #d9534f;
        font-size: 22px;
    }
    .test-items {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 10px;
    }
</style>

<div class="form-group" style="font-size:22px; font-family:Tahoma;">
    <?php
    function getTestsByIds($conn, array $ids) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $orderField = implode(',', $ids);

        $sql = "SELECT test_id, test_name, is_parent, parent_test_id, is_sub_test_level 
                FROM tests
                WHERE test_id IN ($placeholders)
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
            $isParent = $test['is_parent'] == 1;
            $hasParentTest = !is_null($test['parent_test_id']);
            $isSubTestLevel = $test['is_sub_test_level'] == 1;

            // تجاهل الفحوصات التي تكون is_sub_test_level = 1
            if ($isSubTestLevel) {
                continue;
            }

            // تحديد النمط بناءً على الشروط
            $rowStyle = '';
            if ($isParent) {
                $rowStyle = 'background-color: #ffc107; font-weight: bold;'; // لون مميز لـ is_parent
            } elseif ($hasParentTest) {
                $rowStyle = 'background-color: #ffc107;'; // نفس اللون إذا كانت parent_test_id غير خالية
            }

            // عرض الاختبار بناءً على الشروط
            echo "<label style='$rowStyle'>";
            if (!$isParent || $hasParentTest) { // إذا لم يكن "أبًا" أو لديه parent_test_id
                echo "<input type='checkbox' name='test[]' value='$tid'> ";
            }
            echo "$name</label>";
        }
        echo '</div>';
        echo '</div>';
    }
    ?>
</div>
