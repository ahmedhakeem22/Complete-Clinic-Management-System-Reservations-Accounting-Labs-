<!-- edit_patient_modal.php -->
<div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="editPatientForm">
          <div class="modal-header">
            <h5 class="modal-title" id="editPatientModalLabel">
                <i class="fa-solid fa-pen-to-square me-2"></i> تعديل بيانات المريض
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
          </div>
          <div class="modal-body">
                <input type="hidden" name="pat_id" id="edit_pat_id">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="edit_first_name" class="form-label">الاسم الأول:</label>
                        <input type="text" id="edit_first_name" name="first_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_middle_name" class="form-label">الاسم الثاني:</label>
                        <input type="text" id="edit_middle_name" name="middle_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_third_name" class="form-label">الاسم الثالث:</label>
                        <input type="text" id="edit_third_name" name="third_name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="edit_last_name" class="form-label">اسم العائلة:</label>
                        <input type="text" id="edit_last_name" name="last_name" class="form-control" required>
                    </div>
                    <div class="col-md-4">
                        <label for="edit_age" class="form-label">العمر:</label>
                        <input type="number" id="edit_age" name="age" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-4">
                        <label for="edit_phone" class="form-label">رقم الهاتف:</label>
                        <input type="text" id="edit_phone" name="phone" class="form-control" pattern="^(77|78|70|71|73)\d{7}$" title="يجب أن يبدأ بـ 77، 78، 70، 71، أو 73 ويكون بطول 9 أرقام" required>
                    </div>
                    <div class="col-md-4">
                        <label for="edit_gander" class="form-label">الجنس:</label>
                        <select id="edit_gander" name="gander" class="form-select" required>
                            <option value="M">ذكر</option>
                            <option value="F">أنثى</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="edit_birthdaytime" class="form-label">تاريخ الميلاد:</label>
                        <input type="date" id="edit_birthdaytime" name="birthdaytime" class="form-control" required>
                    </div>
                </div>
          </div>
          <div class="modal-footer">
            <button type="submit" name="update_patient" class="btn btn-primary">
                <i class="fa-solid fa-rotate-right me-1"></i> تحديث المريض
            </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                <i class="fa-solid fa-xmark me-1"></i> إلغاء
            </button>
          </div>
      </form>
    </div>
  </div>
</div>
