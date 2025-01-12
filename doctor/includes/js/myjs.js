document.addEventListener('DOMContentLoaded', function() {
    /**
     * دالة عرض Toast كإشعار عائم
     */
    window.showSuccessMessage = function(msg) {
        var toast = document.createElement('div');
        toast.className = 'toast';
        toast.setAttribute('role', 'alert');
        toast.setAttribute('aria-live', 'assertive');
        toast.setAttribute('aria-atomic', 'true');
        toast.setAttribute('data-delay', '5000'); // مدة العرض 5000 مللي ثانية
        toast.innerHTML = `
            <div class="toast-header">
                <strong class="mr-auto text-success">نجاح</strong>
                <small>الآن</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="إغلاق">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                ${msg}
            </div>
        `;
        document.getElementById('toast-container').appendChild(toast);
        $(toast).toast('show');
        $(toast).on('hidden.bs.toast', function () {
            $(this).remove();
        });
    };

    // إرسال نموذج الفحوصات الدموية باستخدام fetch
    document.getElementById('submitBloodTests').addEventListener('click', function() {
        const formElement = document.getElementById('bloodTestsForm');
        const formData = new FormData(formElement);

        fetch('store_blood_request.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showSuccessMessage('تم إرسال الطلب بنجاح!');
                $('#bloodModal').modal('hide');
            } else {
                alert('حدث خطأ: ' + data.message);
            }
        })
        .catch(err => {
            alert('تعذّر إرسال الطلب، تحقق من الاتصال. ' + err);
        });
    });

    // إرسال نموذج الوصفة الطبية باستخدام fetch
    document.getElementById('medicalForm').addEventListener('submit', function(e) {
        e.preventDefault(); // منع الإرسال الافتراضي للنموذج
        const formElement = document.getElementById('medicalForm');
        const formData = new FormData(formElement);

        fetch('sale.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showSuccessMessage('تم إضافة الوصفة الطبية بنجاح!');
                $('#medicalModal').modal('hide');
            } else {
                alert('حدث خطأ: ' + data.message);
            }
        })
        .catch(err => {
            alert('تعذّر إرسال الوصفة الطبية، تحقق من الاتصال. ' + err);
        });
    });

    // إغلاق النوافذ (Modal) بعد إرسال النماذج
    document.querySelectorAll('.modal-form').forEach(form => {
        form.addEventListener('submit', function () {
            const modal = form.closest('.modal');
            $(modal).modal('hide');
        });
    });

    // وظيفة إضافة أدوية جديدة في نافذة الوصفة الطبية
    let drugIndex = 1;
    const usageOptions = JSON.parse(document.getElementById('usageOptions').textContent || '{}');

    // التأكد من وجود زر الإضافة وحاوية الأدوية
    const addDrugBtn = document.getElementById('add-drug-med');
    const drugsContainer = document.getElementById('drugs-container');
    if(addDrugBtn && drugsContainer) {
        addDrugBtn.addEventListener('click', function() {
            const newIndex = drugIndex;
            drugIndex++;
            let usageHTML = '';
            for (const value in usageOptions) {
                usageHTML += `<label style="margin-right:10px;">
                                <input type="checkbox" name="usage[${newIndex}][]" value="${value}">
                                ${usageOptions[value]}
                              </label>`;
            }
            const drugItem = document.createElement('div');
            drugItem.classList.add('drug-item', 'border', 'p-3', 'mb-3');
            drugItem.innerHTML = `
                <h5 class="mb-3">Medication #${drugIndex}</h5>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Medication Name</label>
                        <input type="text" name="med_name[]" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Quantity</label>
                        <input type="number" name="quantity[]" class="form-control" placeholder="Quantity" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Usage Method</label>
                        <div class="usage-options">${usageHTML}</div>
                    </div>
                </div>
                <span class="remove-drug" style="cursor:pointer; color:red;">&times; Remove Medication</span>
            `;
            drugsContainer.appendChild(drugItem);
        });
    }

    // وظيفة إزالة دواء من قائمة الوصفة
    if(drugsContainer) {
        drugsContainer.addEventListener('click', function(e) {
            if(e.target.classList.contains('remove-drug')){
                const drugItem = e.target.closest('.drug-item');
                drugItem.remove();
                // تحديث أرقام الأدوية بعد الإزالة
                drugIndex = 0;
                document.querySelectorAll('.drug-item').forEach((item) => {
                    drugIndex++;
                    item.querySelector('h5').textContent = `Medication #${drugIndex}`;
                    item.querySelectorAll('.usage-options input').forEach(input => {
                        input.name = `usage[${drugIndex - 1}][]`;
                    });
                });
            }
        });
    }
});
