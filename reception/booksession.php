<?php include 'includes/templates/header.php';
include 'includes/templates/navbar.php';
?>

<main>
    <div class="image-container">
        <img src="includes/images/booksession.jpg" alt="image" class="session-image">
    </div>

    <div class="form-container">
        <form action="book_sess_print_ach_pdf.php" method="get">
            <table class="form-table" cellspacing="15" cellpadding="0">
                <tr>
                    <th>Patient No:</th>
                    <td>
                        <input type="number" id="pat_id" name="pat_id" title="Patient No." placeholder="Patient ID:" class="form-input" required>
                    </td>
                    <th>Patient Name:</th>
                    <td>
                        <input type="text" id="fname" name="fname" title="Patient Name:" placeholder="Patient Name:" class="form-input" readonly>
                    </td>
                    <td>
                        <button type="submit" id="add" name="add_sess" class="btn btn-primary">Book a Session</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</main>

<footer>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const patIdInput = document.getElementById('pat_id');
        const fnameInput = document.getElementById('fname');

        // عند إدخال رقم المريض، جلب الاسم تلقائيًا
        patIdInput.addEventListener('input', function () {
            const patId = patIdInput.value;

            if (patId) {
                fetch(`fetch_patient_name.php?pat_id=${patId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            fnameInput.value = data.fname; // عرض اسم المريض
                        } else {
                            fnameInput.value = ''; // إذا لم يتم العثور على اسم
                            alert('Patient not found.');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching patient name:', error);
                        fnameInput.value = ''; // تنظيف الحقل في حالة وجود خطأ
                        alert('An error occurred while fetching the patient name.');
                    });
            } else {
                fnameInput.value = ''; // تنظيف الحقل إذا كان الإدخال فارغًا
            }
        });
    });
</script>

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .image-container {
        text-align: center;
        margin-bottom: 20px;
    }

    .session-image {
        width: 100%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-container {
        max-width: 800px;
        margin: 0 auto;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .form-table {
        width: 100%;
        border-collapse: collapse;
    }

    .form-table th, .form-table td {
        padding: 10px;
        text-align: left;
    }

    .form-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
</style>
