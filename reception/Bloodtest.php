<?php
// Bloodtest.php

// 1) استدعاء ملف الاتصال بقاعدة البيانات
include '../includes/db.php';

// 2) استدعاء ملفات الواجهة (هيدر/نافبار)
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';
?>
<main>
    <img src="includes/images/Bloodtest.jpg" alt="image" width="100%" height="auto">

    <div class="boxlab" style="top:5px;">
        <!-- نستخدم الفورم الرئيسية لإرسال الفحوصات المختارة -->
        <!-- (الأفضل استعمال POST) -->
        <form id="bloodtest-form" action="choess_blood_box_preview.php" method="post">
            <table cellspacing="15" cellpadding="0">
                <tr>
                    <td>
                        Patient ID:
                        <input type="number" id="Patient" name="pat_id" required />
                    </td>
                    <td>
                        <!-- زر إرسال لننتقل إلى صفحة المعاينة (preview) -->
                        <button type="submit" name="preview" class="btn btn-success">عرض التكلفة</button>
                    </td>
                </tr>
            </table>

            <?php
            // 1) جلب جميع الفئات من قاعدة البيانات
            $sql_categories = "SELECT category_id, category_name FROM test_categories ORDER BY category_id ASC";
            $res_categories = $conn->query($sql_categories);

            if ($res_categories->num_rows > 0):
                while ($cat_row = $res_categories->fetch_assoc()):
                    $category_id   = $cat_row['category_id'];
                    $category_name = $cat_row['category_name'];
                    
                    // عنوان الفئة
                    echo "<h3 style='color:red; font-size:22px; margin-top:15px;'>{$category_name}</h3>";

                    // 2) جلب الاختبارات الخاصة بهذه الفئة
                    $sql_tests = "SELECT test_id, test_name, price 
                                  FROM tests 
                                  WHERE category_id = $category_id
                                  ORDER BY test_id ASC";
                    $res_tests = $conn->query($sql_tests);

                    if ($res_tests->num_rows > 0):
                        echo "<div style='margin-bottom:10px;'>";
                        while ($test_row = $res_tests->fetch_assoc()):
                            $test_id   = $test_row['test_id'];
                            $test_name = $test_row['test_name'];
                            $price     = $test_row['price'];

                            // checkbox لكل اختبار
                            echo "
                                <label style='margin-right:15px;'>
                                    <input type='checkbox' name='test[]' value='{$test_id}' />
                                    {$test_name} ({$price})
                                </label>
                            ";
                        endwhile;
                        echo "</div>";
                    else:
                        echo "<p>لا توجد اختبارات ضمن هذه الفئة.</p>";
                    endif;

                endwhile;
            else:
                echo "<p>لا توجد فئات مُسجّلة بعد.</p>";
            endif;
            ?>
        </form>
    </div>
</main>

<!-- Modal Structure -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-success" id="confirmationModalLabel">تأكيد الفحوصات المختارة</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- محتوى التأكيد سيتم تحميله هنا -->
        <div id="confirmationContent">
            <!-- سيتم ملؤه عبر AJAX -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
      </div>
    </div>
  </div>
</div>

<footer>
    <!-- Footer content -->
</footer>

<!-- JavaScript to handle form submission and modal display -->
<script>
document.getElementById('bloodtest-form').addEventListener('submit', function(e) {
    e.preventDefault(); // منع الإرسال التقليدي للنموذج

    // إنشاء كائن FormData لجمع بيانات النموذج
    var formData = new FormData(this);

    // إرسال البيانات عبر Fetch API باستخدام POST
    fetch('choess_blood_box_preview.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        // تحميل البيانات في محتوى النموذج المنبثق
        document.getElementById('confirmationContent').innerHTML = data;
        // عرض النموذج المنبثق
        $('#confirmationModal').modal('show');
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء معالجة الطلب.');
    });
});
</script>

</body>
</html>
