document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        
        const name = document.querySelector('input[name="name"]').value.trim();
        const text = document.querySelector('textarea[name="text"]').value.trim();
        const id_select = document.querySelector('select[name="id_select"]').value;
        
        let errors = [];

        // تحقق من الحقول
        if (name.length === 0) {
            errors.push('يرجى إدخال اسم الباب.');
        }

        if (text.length === 0) {
            errors.push('يرجى إدخال الشرح.');
        }

        if (id_select === "Open this select menu") {
            errors.push('يرجى اختيار ID.');
        }

        if (errors.length > 0) {
            displayErrors(errors);
        } else {
            // إرسال البيانات عبر AJAX
            const formData = new FormData(form);
            fetch('process_form.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showSuccessToast('تمت إضافة البيانات بنجاح.');
                    setTimeout(() => window.location.href = 'gates-jerusalem.php', 2000);
                } else {
                    displayErrors(data.errors);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });

    function displayErrors(errors) {
        const toastContainer = document.createElement('div');
        toastContainer.classList.add('toast-container', 'position-fixed', 'bottom-0', 'end-0', 'p-3');

        const toastHTML = `
            <div id="liveToast" class="toast d-block" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">خطأ</strong>
                    <small>الآن</small>
                </div>
                <div class="toast-body">
                    ${errors.join('<br>')}
                </div>
            </div>
        `;

        toastContainer.innerHTML = toastHTML;
        document.body.appendChild(toastContainer);
    }

    function showSuccessToast(message) {
        const toastContainer = document.createElement('div');
        toastContainer.classList.add('toast-container', 'position-fixed', 'bottom-0', 'end-0', 'p-3');

        const toastHTML = `
            <div id="liveToast" class="toast d-block" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">نجاح</strong>
                    <small>الآن</small>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        `;

        toastContainer.innerHTML = toastHTML;
        document.body.appendChild(toastContainer);
    }
});

