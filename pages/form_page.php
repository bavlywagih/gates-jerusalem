<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء صفحة جديدة أو آية</title>
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container my-3 no-print">
        <div class="card rounded-3 card-w-90" style="width: 60%; margin: auto;">
            <div class="card-body m-auto" style="width: 95%;">
                <h5 class="card-title text-center" id="card-title">إنشاء آية</h5>
                <form action="" method="POST">
                    <div class="form-group">
                        <div class="d-flex flex-column">
                            <label for="file-picker" class="form-label" id="label-page-title"> عنوان الصفحة:</label>
                            <input type="text" required class="form-control" name="page_title" placeholder="اكتب عنوان الصفحة هنا">
                        </div>
                        <div class="d-flex flex-column" id="verse-reference-div">
                            <label for="file-picker" class="form-label" id="label-verse-reference"> شاهد الآية:</label>
                            <input type="text" class="form-control" name="verse_reference" placeholder="اكتب شاهد الآية هنا" id="input-verse-reference">
                        </div>
                        <div class="my-2">
                            <label for="file-picker" class="form-label" id="label-verse"> الآية:</label>
                            <textarea class="form-control" name="verse" id="text-area" rows="5" style="height: 400px;" placeholder="اكتب الآية هنا"></textarea>
                        </div>
                        <div class="my-2">
                            <label for="file-picker" class="form-label">اختيار الصفحة:</label>
                            <select class="form-select" name="id_select" id="id-select" aria-label="Default select example">
                                <option value="0" selected>آية</option>
                                <option value="1">صفحة</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" style="width: 100%;">إرسال</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('id-select').addEventListener('change', function() {
            const selectedValue = this.value;
            const cardTitle = document.getElementById('card-title');
            const labelPageTitle = document.getElementById('label-page-title');
            const labelVerseReference = document.getElementById('label-verse-reference');
            const labelVerse = document.getElementById('label-verse');
            const verseReferenceDiv = document.getElementById('verse-reference-div');
            const inputversereference = document.getElementById('input-verse-reference');
            const textAreaContainer = document.querySelector('.my-2');

            if (selectedValue === '0') {
                cardTitle.textContent = 'إنشاء آية';
                labelPageTitle.textContent = 'عنوان الصفحة:';
                labelVerseReference.textContent = 'شاهد الآية:';
                labelVerse.textContent = 'الآية:';
                verseReferenceDiv.style.visibility = 'visible';
                inputversereference.style.visibility = 'visible';
                document.getElementById('text-area').placeholder = 'اكتب الآية هنا';
            } else if (selectedValue === '1') {
                cardTitle.textContent = 'إنشاء صفحة جديدة';
                labelPageTitle.textContent = 'عنوان الصفحة:';
                labelVerseReference.textContent = '';
                labelVerse.textContent = 'الصفحة:';
                verseReferenceDiv.style.visibility = 'hidden';
                inputversereference.style.visibility = 'hidden';
                document.getElementById('text-area').placeholder = 'اكتب محتوى الصفحة هنا';
            }
        });
    </script>
</body>

</html>