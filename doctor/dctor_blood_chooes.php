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
    // جلب جميع الأقسام مرتبة حسب category_id
    $categoriesQuery = "SELECT * FROM test_categories ORDER BY category_id ASC";
    $categoriesResult = $conn->query($categoriesQuery);

    if ($categoriesResult->num_rows > 0) {
        while ($category = $categoriesResult->fetch_assoc()) {
            $categoryId = $category['category_id'];
            $categoryName = $category['category_name'];

            echo '<div class="test-section">';
            echo "<label>$categoryName</label><br/>";

            // جلب الفحوصات المرتبطة بهذا القسم مرتبة حسب test_id
            $testsQuery = "SELECT * FROM tests WHERE category_id = ? AND is_sub_test_level != 1 ORDER BY test_id ASC";
            $stmt = $conn->prepare($testsQuery);
            $stmt->bind_param('i', $categoryId);
            $stmt->execute();
            $testsResult = $stmt->get_result();

            echo '<div class="test-items">';
            while ($test = $testsResult->fetch_assoc()) {
                $tid = $test['test_id'];
                $name = $test['test_name'];
                $isParent = $test['is_parent'];
                $parentTestId = $test['parent_test_id'];

                // تحقق مما إذا كان الاختبار يجب أن يكون بلون مميز
                $highlightClass = ($isParent == 1 || !empty($parentTestId)) ? 'highlight' : '';

                echo "<label class='$highlightClass'><input type='checkbox' name='test[]' value='$tid'> $name</label>";
            }
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "<p>لا توجد أقسام متاحة.</p>";
    }
    ?>
</div>