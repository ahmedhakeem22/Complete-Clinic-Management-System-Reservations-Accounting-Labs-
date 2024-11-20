<?php 
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';
include '../includes/db.php';
?>

<body> 
    <?php
    // التحقق من إرسال بيانات التعديل وتحديثها في قاعدة البيانات
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_patient'])) {
        // دوال لتنظيف البيانات المدخلة
        function sanitize_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // جمع وتنظيف البيانات من النموذج
        $pat_id = sanitize_input($_POST['pat_id']);
        $first_name = sanitize_input($_POST['first_name']);
        $middle_name = sanitize_input($_POST['middle_name']);
        $third_name = sanitize_input($_POST['third_name']);
        $last_name = sanitize_input($_POST['last_name']);
        $fname = $first_name . ' ' . $middle_name . ' ' . $third_name . ' ' . $last_name;
        $age = intval($_POST['age']);
        $phone = sanitize_input($_POST['phone']);
        $gander = sanitize_input($_POST['gander']); // 'M' أو 'F'

        // التحقق من صحة البيانات الأساسية
        $errors = [];
        if (empty($first_name) || empty($middle_name) || empty($third_name) || empty($last_name)) {
            $errors[] = "الاسم الكامل مطلوب (الاسم الأول، الثاني، الثالث، واللقب).";
        }
        if ($age <= 0) {
            $errors[] = "العمر يجب أن يكون رقمًا موجبًا.";
        }
        // تحديث نمط التحقق من رقم الهاتف
        if (!preg_match('/^(77|78|70|71|73)\d{7}$/', $phone)) {
            $errors[] = "رقم الهاتف يجب أن يكون مكونًا من 9 أرقام ويبدأ بـ 77، 78، 70، 71، أو 73.";
        }
        if (!in_array($gander, ['M', 'F'])) {
            $errors[] = "الجنس غير صالح.";
        }

        if (empty($errors)) {
            // استخدام الاستعلام المحضر لتحديث البيانات
            $stmt = $conn->prepare("UPDATE patinte SET fname = ?, age = ?, phone = ?, gander = ? WHERE pat_id = ?");
            if ($stmt) {
                $stmt->bind_param("sissi", $fname, $age, $phone, $gander, $pat_id);
                
                if ($stmt->execute()) {
                    echo "<div class='success-message'>تم تحديث بيانات المريض بنجاح.</div>";
                } else {
                    echo "<div class='error-message'>خطأ في تحديث السجل: " . htmlspecialchars($stmt->error) . "</div>";
                }

                $stmt->close();
            } else {
                echo "<div class='error-message'>خطأ في إعداد الاستعلام: " . htmlspecialchars($conn->error) . "</div>";
            }
        } else {
            // عرض رسائل الأخطاء
            echo "<div class='error-message'><ul>";
            foreach ($errors as $error) {
                echo "<li>" . htmlspecialchars($error) . "</li>";
            }
            echo "</ul></div>";
        }
    }
    ?>

    <main class="main">
        <img src="includes/images/oldimg.jpg" alt="image" width="100%" height="45%">
        <div class="">
            <input style="text-align: center;" type="input" id="myInput" onkeyup="myFunction()" placeholder="Search for Patient.." title="Type in a name"/>

            <table id="myTable">
                <tr class="header">
                    <th style="width:1%;"> ID </th>
                    <th style="width:1%;"> Full Name </th>
                    <th style="width:1%;">Age</th>
                    <th style="width:2%;">Mobile</th>
                    <th style="width:2%;">Gender</th>
                    <th style="width:2%;">Date and Time</th>
                    <th style="width:2%;">Actions</th>
                </tr>

                <?php 
                // استخدام الاتصال من ملف db.php لتنفيذ الاستعلام
                $r = mysqli_query($conn, "SELECT pat_id, fname, age, phone, gander, date_com FROM patinte");

                while($row = mysqli_fetch_array($r)) {
                    // إنشاء مصفوفة البيانات المطلوبة
                    $patientData = [
                        'pat_id' => $row['pat_id'],
                        'fname' => $row['fname'],
                        'age' => $row['age'],
                        'phone' => $row['phone'],
                        'gander' => $row['gander']
                    ];

                    // تحويل المصفوفة إلى JSON
                    $patientJson = htmlspecialchars(json_encode($patientData), ENT_QUOTES, 'UTF-8');

                    echo "<tr id='row_" . htmlspecialchars($row['pat_id']) . "'>";
                    echo "<td>" . htmlspecialchars($row['pat_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['fname']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>" . ($row['gander'] === 'M' ? 'Male' : 'Female') . "</td>";
                    echo "<td>" . htmlspecialchars($row['date_com']) . "</td>";
                    echo "<td>";
                    echo "<button class='edit-btn' data-patient='" . $patientJson . "'>✏️ Edit Patient</button>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </div>
    </main>

    <!-- نموذج التعديل كقسم يظهر كصفحة عائمة -->
    <div id="editFormContainer" class="floating-form" style="display: none;">
        <h2>Edit Patient Data</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="editForm">
            <input type="hidden" name="pat_id" id="pat_id">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" required><br>
            </div>

            <div class="form-group">
                <label for="middle_name">Middle Name:</label>
                <input type="text" name="middle_name" id="middle_name" required><br>
            </div>

            <div class="form-group">
                <label for="third_name">Third Name:</label>
                <input type="text" name="third_name" id="third_name" required><br>
            </div>

            <div class="form-group">
                <label for="last_name">Last Name (Family Name):</label>
                <input type="text" name="last_name" id="last_name" required><br>
            </div>

            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" name="age" id="age" required><br>
            </div>

            <div class="form-group">
                <label for="phone">Mobile:</label>
                <!-- إضافة نمط التحقق من صحة رقم الهاتف -->
                <input type="text" name="phone" id="phone" required pattern="^(77|78|70|71|73)\d{7}$" title="رقم الهاتف يجب أن يكون مكونًا من 9 أرقام ويبدأ بـ 77، 78، 70، 71، أو 73."><br>
            </div>

            <div class="form-group">
                <label for="gander">Gender:</label>
                <select name="gander" id="gander" required>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select><br>
            </div>

            <div class="form-actions">
                <input type="submit" name="update_patient" value="Update Patient" class="btn btn-primary">
                <button type="button" onclick="closeEditForm()" class="btn btn-secondary">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        function myFunction() {
            const filter = document.querySelector('#myInput').value.toUpperCase();
            const trs = document.querySelectorAll('#myTable tr:not(.header)');
            trs.forEach(tr => tr.style.display = [...tr.children].find(td => td.innerHTML.toUpperCase().includes(filter)) ? '' : 'none');
        }

        // إضافة مستمع للأحداث لأزرار التعديل بعد تحميل الصفحة
        document.addEventListener('DOMContentLoaded', () => {
            const editButtons = document.querySelectorAll('.edit-btn');
            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const patientData = JSON.parse(button.getAttribute('data-patient'));
                    openEditForm(patientData);
                });
            });
        });

        // فتح النموذج وتعبئة البيانات
        function openEditForm(patientData) {
            document.getElementById('pat_id').value = patientData.pat_id;
            const nameParts = patientData.fname.split(' ');
            document.getElementById('first_name').value = nameParts[0] || '';
            document.getElementById('middle_name').value = nameParts[1] || '';
            document.getElementById('third_name').value = nameParts[2] || '';
            document.getElementById('last_name').value = nameParts[3] || '';
            document.getElementById('age').value = patientData.age;
            document.getElementById('phone').value = patientData.phone;
            document.getElementById('gander').value = patientData.gander;
            // عرض النموذج
            document.getElementById('editFormContainer').style.display = 'block';
        }

        // إغلاق النموذج
        function closeEditForm() {
            document.getElementById('editFormContainer').style.display = 'none';
        }
    </script>

    <style>
        /* تصميم النموذج ليظهر كصفحة عائمة ولا يختفي بأي شيء في الصفحة الرئيسية */
        #editFormContainer {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #f9f9f9;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #ccc;
            z-index: 2000;
            box-shadow: 0px 0px 15px rgba(0,0,0,0.4);
            width: 500px;
            max-width: 90%;
            overflow: auto;
        }

        #editFormContainer .form-group {
            margin-bottom: 15px;
        }

        #editFormContainer label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        #editFormContainer input[type="text"],
        #editFormContainer input[type="number"],
        #editFormContainer select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #editFormContainer .form-actions {
            text-align: right;
        }

        #editFormContainer .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #editFormContainer .btn-primary {
            background-color: #007bff;
            color: white;
            margin-right: 10px;
        }

        #editFormContainer .btn-primary:hover {
            background-color: #0056b3;
        }

        #editFormContainer .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        #editFormContainer .btn-secondary:hover {
            background-color: #5a6268;
        }

        .success-message {
            color: green;
            margin: 10px 0;
            font-weight: bold;
        }

        .error-message {
            color: red;
            margin: 10px 0;
            font-weight: bold;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            font-weight: bold;
            font-size: 14px;
        }

        .edit-btn:hover {
            background-color: #45a049;
            transform: scale(1.05);
        }
    </style>

    <footer class="footer"></footer> 
</body>
</html>
