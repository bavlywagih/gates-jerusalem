<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تصدير البيانات إلى PDF</title>
    <!-- تحميل jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- تحميل jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.6.0/jspdf.umd.min.js"></script>
    <!-- تحميل jsPDF autoTable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.15/jspdf.plugin.autotable.min.js"></script>
    <!-- تحميل خط عربي من Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap">
</head>

<body>
    <h1>تصدير البيانات</h1>
    <button id="download-pdf">تنزيل PDF</button>

    <script>
        $(document).ready(function() {
            $('#download-pdf').on('click', function() {
                downloadPDF();
            });
        });

        async function downloadPDF() {
            // تأكد من تحميل مكتبة jsPDF بشكل صحيح
            const {
                jsPDF
            } = window.jspdf;

            if (!jsPDF) {
                console.error('jsPDF library not loaded');
                return;
            }

            const doc = new jsPDF();

            // تحميل الخطوط العربية من Google Fonts
            // استخدم خط Amiri كخط عربي
            doc.addFileToVFS('Amiri-Regular.ttf', 'BASE64_ENCODED_FONT'); // استبدل ببيانات الخط الفعلي
            doc.addFont('Amiri-Regular.ttf', 'Amiri', 'normal');

            try {
                // تحميل البيانات من الخادم باستخدام jQuery
                const data = await $.ajax({
                    url: 'data.php',
                    method: 'GET',
                    dataType: 'json'
                });

                // إعداد الخط والخصائص
                doc.setFont('Amiri');
                doc.setFontSize(18);
                doc.text('تصدير البيانات', 10, 10);

                // إعداد الجدول
                doc.autoTable({
                    startY: 20,
                    head: [
                        ['معرف', 'الاسم', 'النص']
                    ],
                    body: data.map(row => [row.id, row.name, row.text]),
                    theme: 'grid',
                    styles: {
                        font: 'Amiri',
                        halign: 'right' // محاذاة النص لليمين لدعم العربية
                    },
                    margin: {
                        top: 10
                    }
                });

                // حفظ ملف PDF
                doc.save('data_export.pdf');
            } catch (error) {
                console.error('Error fetching data:', error);
            }
        }
    </script>
</body>

</html>