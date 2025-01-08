<!-- مودال حجز الجلسة -->
<div class="modal fade" id="bookSessionModal" tabindex="-1" aria-labelledby="bookSessionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="bookSessionForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookSessionModalLabel">حجز جلسة</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="book_pat_id" name="pat_id">
                    <div class="mb-3">
                        <label for="book_fname" class="form-label">الاسم الكامل</label>
                        <input type="text" class="form-control" id="book_fname" name="fname" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="book_session_price" class="form-label">سعر الجلسة (بالريال اليمني)</label>
                        <input type="number" class="form-control" id="book_session_price" name="session_price" value="3000" readonly>
                    </div>
                    <!-- يمكنك إضافة حقول إضافية هنا إذا لزم الأمر -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">تأكيد الحجز</button>
                </div>
            </div>
        </form>
    </div>
</div>
