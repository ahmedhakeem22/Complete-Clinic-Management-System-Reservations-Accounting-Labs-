<?php
// Bloodtest.php

// 1) استدعاء ملف الاتصال بقاعدة البيانات
include '../includes/db.php';

// 2) استدعاء ملفات الواجهة (هيدر/نافبار)
// تأكد من أن ملفات الهيدر والنافبار لديك تحتوي على ربط Bootstrap 5 وأي ملفات CSS أو JS إضافية
include 'includes/templates/header.php';
include 'includes/templates/navbar.php';
?>

<main class="container my-4">

    <!-- قسم الصورة العلوية -->
    <div class="row">
        <div class="col-12">
            <img src="includes/images/Bloodtest.jpg" alt="image" class="img-fluid rounded shadow" />
        </div>
    </div>

    <!-- قسم إدخال بيانات المريض -->
    <div class="row my-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form id="bloodtest-form" action="choess_blood_box_preview.php" method="post" class="row g-3">
                        <div class="col-md-4">
                            <label for="Patient" class="form-label fw-bold">Patient ID</label>
                            <input type="number" id="Patient" name="pat_id" class="form-control" required />
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" name="preview" class="btn btn-success mt-2 mt-md-0">
                                عرض التكلفة
                            </button>
                        </div>

                        <!-- هنا سيُعرَض محتوى الفحوصات ضمن نفس النموذج -->
                        <div class="col-12 mt-4">
                            <?php
                            // 1) جلب جميع الفئات من قاعدة البيانات
                            $sql_categories = "SELECT category_id, category_name FROM test_categories ORDER BY category_id ASC";
                            $res_categories = $conn->query($sql_categories);

                            if ($res_categories->num_rows > 0):
                                while ($cat_row = $res_categories->fetch_assoc()):
                                    $category_id = $cat_row['category_id'];
                                    $category_name = $cat_row['category_name'];
                                    ?>

                                    <!-- عرض الفئة في بطاقة (Card) -->
                                    <div class="card mb-3">
                                        <div class="card-header bg-danger text-white fw-bold">
                                            <?= htmlspecialchars($category_name); ?>
                                        </div>
                                        <div class="card-body">
                                            <?php
                                            // 2) جلب الاختبارات الخاصة بهذه الفئة
                                            $sql_tests = "SELECT test_id, test_name, price, is_parent, parent_test_id
                                                          FROM tests 
                                                          WHERE category_id = $category_id AND is_sub_test_level = 0
                                                          ORDER BY test_id ASC";
                                            $res_tests = $conn->query($sql_tests);

                                            if ($res_tests->num_rows > 0):
                                                ?>
                                                <div class="row">
                                                    <?php
                                                    while ($test_row = $res_tests->fetch_assoc()):
                                                        $test_id       = $test_row['test_id'];
                                                        $test_name     = $test_row['test_name'];
                                                        $price         = $test_row['price'];
                                                        $isParent      = $test_row['is_parent'] == 1;
                                                        $hasParentTest = !is_null($test_row['parent_test_id']);

                                                        // تحديد النمط بناءً على الشروط
                                                        $labelClasses = 'form-check-label';
                                                        $labelStyle   = '';

                                                        if ($isParent) {
                                                            // لون مميز إذا كان الاختبار رئيسي
                                                            $labelStyle = 'background-color: #ffc107; font-weight: bold; padding: 4px 8px; border-radius: 4px;';
                                                        } elseif ($hasParentTest) {
                                                            // لون مميز إذا كان له اختبار أب
                                                            $labelStyle = 'background-color: #ffe08a; padding: 4px 8px; border-radius: 4px;';
                                                        }
                                                        ?>
                                                        <div class="col-sm-6 col-md-4 mb-3">
                                                            <div class="form-check">
                                                                <input
                                                                    class="form-check-input"
                                                                    type="checkbox"
                                                                    name="test[]"
                                                                    value="<?= $test_id; ?>"
                                                                    id="test_<?= $test_id; ?>"
                                                                />
                                                                <label
                                                                    for="test_<?= $test_id; ?>"
                                                                    class="<?= $labelClasses; ?>"
                                                                    style="<?= $labelStyle; ?>"
                                                                >
                                                                    <?= htmlspecialchars($test_name); ?>
                                                                    (<span class="text-primary"><?= $price; ?></span>)
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php endwhile; ?>
                                                </div>
                                                <?php
                                            else:
                                                echo "<p class='text-muted'>لا توجد اختبارات ضمن هذه الفئة.</p>";
                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                    <!-- نهاية بطاقة الفئة -->
                                <?php
                                endwhile;
                            else:
                                echo "<p>لا توجد فئات مُسجّلة بعد.</p>";
                            endif;
                            ?>
                        </div><!-- /.col-12 (لقسم عرض الفحوصات) -->
                    </form>
                </div> <!-- /.card-body -->
            </div> <!-- /.card -->
        </div> <!-- /.col-12 -->
    </div> <!-- /.row -->

</main>

<!-- Modal Structure -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="confirmationModalLabel">تأكيد الفحوصات المختارة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <!-- سيتم ملؤه عبر AJAX -->
                <div id="confirmationContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<footer class="bg-light py-3 mt-4">
    <div class="container text-center">
        <p class="text-muted mb-0">
            &copy; <?= date('Y'); ?> - جميع الحقوق محفوظة
        </p>
    </div>
</footer>

<!-- JavaScript to handle form submission and modal display -->
<script>
    // ملاحظة: تأكد من وجود ملفات JS الخاصة بـ Bootstrap 5، وملف JS الخاص بـ jQuery (إن استخدمته) في أسفل الصفحة.
    // إذا كنت تعتمد على Fetch API فقط مع JavaScript الأصلي، فلا داعي لـ jQuery.
    const bloodtestForm = document.getElementById('bloodtest-form');
    const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));

    bloodtestForm.addEventListener('submit', function (e) {
        e.preventDefault(); // منع الإرسال التقليدي للنموذج

        // إنشاء كائن FormData لجمع بيانات النموذج
        const formData = new FormData(bloodtestForm);

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
            confirmationModal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء معالجة الطلب.');
        });
    });
</script>

</body>
</html>
