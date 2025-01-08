<!-- add_patient_modal.php -->
<div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="addPatientForm">
          <div class="modal-header">
            <h5 class="modal-title" id="addPatientModalLabel">
                <i class="fa-solid fa-user-plus me-2"></i> إضافة مريض جديد
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
          </div>
          <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="no_p" class="form-label">رقم المريض:</label>
                        <input type="text" id="no_p" name="pat_pid" class="form-control" readonly value="سيتم التوليد تلقائيًا">
                    </div>
                    <div class="col-md-9">
                        <label class="form-label">الاسم الرباعي:</label>
                        <div class="row g-2">
                            <div class="col-md-3">
                                <input type="text" id="first_name" name="first_name" class="form-control" placeholder="الاسم الأول" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="second_name" name="second_name" class="form-control" placeholder="الاسم الثاني" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="third_name" name="third_name" class="form-control" placeholder="الاسم الثالث" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="اسم العائلة" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="age" class="form-label">العمر:</label>
                        <input type="number" id="age" name="pat_age" class="form-control" min="0" placeholder="مثال: 30" required>
                    </div>
                    <div class="col-md-3">
                        <label for="mobile" class="form-label">رقم الهاتف:</label>
                        <input type="text" id="mobile" name="pat_phon" class="form-control" pattern="^(77|78|70|71|73)\d{7}$" title="يجب أن يبدأ بـ 77، 78، 70، 71، أو 73 ويكون بطول 9 أرقام" placeholder="مثال: 771234567" required>
                    </div>
                    <div class="col-md-3">
                        <label for="country" class="form-label">البلد:</label>
                        <input type="text" id="country" name="pat_contry" class="form-control" placeholder="مثال: اليمن" required>
                    </div>
                    <div class="col-md-3">
                        <label for="city" class="form-label">المدينة:</label>
                        <input type="text" id="city" name="pat_city" class="form-control" placeholder="مثال: صنعاء" required>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">الحالة الاجتماعية:</label>
                        <select id="status" name="Pat_sts" class="form-select" required>
                            <option value="" selected disabled>اختر...</option>
                            <option value="Married">متزوج</option>
                            <option value="Unmarried">غير متزوج</option>
                            <option value="absolute">مطلق</option>
                            <option value="Widower">أرمل</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="gender" class="form-label">الجنس:</label>
                        <select id="gender" name="pat_gander" class="form-select" required>
                            <option value="" selected disabled>اختر...</option>
                            <option value="M">ذكر</option>
                            <option value="F">أنثى</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="nochild" class="form-label">عدد الأطفال:</label>
                        <input type="number" id="nochild" name="pat_chel" class="form-control" min="0" placeholder="مثال: 2" required>
                    </div>
                    <div class="col-md-3">
                        <label for="jop" class="form-label">الوظيفة:</label>
                        <input type="text" id="jop" name="pat_jop" class="form-control" placeholder="مثال: مهندس" required>
                    </div>
                    <div class="col-md-3">
                        <label for="religion" class="form-label">الديانة:</label>
                        <select id="religion" name="pat_prig" class="form-select" required>
                            <option value="" selected disabled>اختر...</option>
                            <option value="Islam">الإسلام</option>
                            <option value="Christianity">المسيحية</option>
                            <option value="Judaism">اليهودية</option>
                            <option value="Hinduism">الهندوسية</option>
                            <option value="Buddhism">البوذية</option>
                            <option value="Other">أخرى</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="birthdaytime" class="form-label">تاريخ الميلاد:</label>
                        <input type="date" id="birthdaytime" name="birthdaytime" class="form-control" required>
                    </div>
                    <div class="col-12">
                        <label for="Notes" class="form-label">ملاحظات:</label>
                        <textarea id="Notes" name="pat_note" class="form-control" style="font-size:17px; resize:none; background-color: #f6f6f6;" rows="3" placeholder="أضف ملاحظات هنا..."></textarea> 
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="add_pp" class="btn btn-success">
                <i class="fa-solid fa-save me-1"></i> حفظ المريض
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="fa-solid fa-xmark me-1"></i> إلغاء
            </button>
          </div>
      </form>
    </div>
  </div>
</div>
