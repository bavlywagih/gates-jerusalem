    <?php
    session_start();
    if (isset($_SESSION['username'])) {
        if ($_SESSION['group-id'] == 1) {

            require_once "./includes/layout/header.php";
            require_once "./includes/layout/nav.php";
            require_once 'connect.php';
            require_once 'functions.php';

            function get_last_id($pdo)
            {
                $stmt = $pdo->prepare("SELECT MAX(id) FROM pages");
                $stmt->execute();
                return $stmt->fetchColumn();
            }

            function generate_sequential_id($pdo)
            {
                $last_id = get_last_id($pdo);
                if ($last_id === false) {
                    return 1;
                } else {
                    return $last_id + 1;
                }
            }

            $unique_id = generate_sequential_id($pdo);
            // echo "Unique ID: " . $unique_id;

            function encrypt_id($unique_id, $encryption_key)
            {
                $cipher_method = 'AES-128-CTR';
                $iv_length = openssl_cipher_iv_length($cipher_method);
                $options = 0;
                $encryption_iv = random_bytes($iv_length);

                $encrypted_id = openssl_encrypt((string)$unique_id, $cipher_method, $encryption_key, $options, $encryption_iv);

                $encrypted_id_with_iv = base64_encode($encryption_iv . $encrypted_id);
                return $encrypted_id_with_iv;
            }

            $encryption_key = '172008bavly12345';
            $encrypted_id = encrypt_id($unique_id, $encryption_key);
            // echo "<br>Encrypted ID: " . $encrypted_id;

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $id = $encrypted_id;
                $page_title = trim($_POST['page_title']);
                $id_select = trim($_POST['id_select']);
                if ($id_select == 0) {
                    $verse_reference = trim($_POST['verse_reference']);
                    $verse = trim($_POST['verse']);
                } else {
                    $verse_reference = " ";
                    $verse = trim($_POST['text']);
                }
                if (!empty($verse_reference) && !empty($verse)) {
                    $stmt = $con->prepare("SELECT * FROM pages WHERE verse_reference = ?");
                    $stmt->execute([$verse_reference]);
                    $row = $stmt->fetch();
                    $count = $stmt->rowCount();
                    if ($count == 0) {
                        $stmt = $con->prepare("INSERT INTO pages (id, page_title, verse_reference, verse, id_select) VALUES (?, ?, ?, ?, ?)");
                        $stmt->execute([$id, $page_title, $verse_reference, $verse, $id_select]);
                        header('location: page.php?id=' . $id);
                        exit();
                    } 
                

                } else {
                    echo "جميع الحقول مطلوبه";
                }
            }
    ?>

            <!DOCTYPE html>
            <html lang="ar">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Form Example</title>
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
                            <h5 class="card-title text-center" id="card-title">انشاء آيه</h5>
                            <form action="" method="POST">
                                <div class="form-group">
                                    <div class="d-flex flex-column">
                                        <label for="file-picker" class="form-label" id="label-page-title"> عنوان الصفحه :</label>
                                        <input type="text" required class="form-control" name="page_title" placeholder="اكتب عنوان الصفحه هنا">
                                    </div>
                                    <div class="d-flex flex-column" id="verse-reference-div">
                                        <label for="file-picker" class="form-label" id="label-verse-reference"> شاهد الآيه :</label>
                                        <input type="text"  class="form-control" name="verse_reference" placeholder="اكتب شاهد الآيه هنا" id="input-verse-reference">
                                    </div>
                                    <div class="my-2">
                                        <label for="file-picker" class="form-label" id="label-verse"> الآيه : </label>
                                        <textarea class="form-control"  name="verse" id="text-area" rows="5" style="height: 400px;" placeholder="اكتب الآيه هنا"></textarea>
                                    </div>
                                    <div class="my-2">
                                        <label for="file-picker" class="form-label"> اختيار ال صفحة : </label>
                                        <select class="form-select" name="id_select" id="id-select" aria-label="Default select example">
                                            <option value="0" selected>آيه</option>
                                            <option value="1">صفحه</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success" style="width: 100%;">ارسال</button>
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
                            cardTitle.textContent = 'انشاء آيه';
                            labelPageTitle.textContent = 'عنوان الصفحه :';
                            labelVerseReference.textContent = 'شاهد الآيه :';
                            labelVerse.textContent = 'الآيه :';
                            verseReferenceDiv.style.visibility = 'visible'; // إظهار شاهد الآيه
                            inputversereference.style.visibility = 'visible'; // إظهار شاهد الآيه

                            if (!document.querySelector('textarea[name="verse"]')) {
                                const newTextArea = document.createElement('textarea');
                                newTextArea.className = 'form-control';
                                newTextArea.name = 'verse';
                                newTextArea.rows = 5;
                                newTextArea.style.height = '400px';
                                newTextArea.placeholder = 'اكتب الآيه هنا';
                                newTextArea.id = 'text-area';
                                textAreaContainer.replaceChild(newTextArea, textAreaContainer.querySelector('#post-editor'));
                            }
                            tinymce.remove(); // إزالة محرر TinyMCE إذا كان موجوداً
                        } else if (selectedValue === '1') {
                            cardTitle.textContent = 'انشاء صفحة جديدة';
                            labelPageTitle.textContent = 'عنوان الصفحة :';
                            labelVerseReference.textContent = '';
                            labelVerse.textContent = 'الصفحة :';
                            verseReferenceDiv.style.visibility = 'hidden'; // إخفاء شاهد الآيه
                            inputversereference.style.visibility = 'hidden'; // إخفاء شاهد الآيه

                            if (!document.querySelector('textarea[name="text"]')) {
                                const newTextArea = document.createElement('textarea');
                                newTextArea.className = 'form-control';
                                newTextArea.name = 'text';
                                newTextArea.id = 'post-editor';
                                newTextArea.rows = 5;
                                textAreaContainer.replaceChild(newTextArea, textAreaContainer.querySelector('#text-area'));
                            }
                            tinymce.init({
                                selector: 'textarea#post-editor',
                                height: 500,
                                license_key: 'gpl',

                                plugins: [
                                    'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                                    'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                                    'insertdatetime', 'media', 'table', 'help', 'wordcount', 'directionality'
                                ],
                                toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help searchreplace | ltr rtl | addButton',
                                content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
                                <?php
                                $query = "SELECT * FROM pages ";

                                $stmt = $pdo->query($query);
                                $row_count = $stmt->rowCount();
                                ?>
                                <?php
                                if ($row_count != 0) {
                                ?>
                                    setup: function(editor) {
                                        editor.on('ExecCommand', function(e) {
                                            if (e.command === 'mceLink') {
                                                setTimeout(function() {
                                                    var urlInput = document.querySelector('.tox-textfield[id^="form-field_"]');
                                                    if (urlInput) {
                                                        var select = document.createElement('select');
                                                        select.style.marginTop = '10px';
                                                        select.style.width = '100%';

                                                        var options = [{
                                                                text: 'اختر رابط...',
                                                                value: ''
                                                            },
                                                            <?php

                                                            function encrypt_id_page($unique_id_page, $encryption_key_page)
                                                            {
                                                                $cipher_method_page = 'AES-128-CTR';
                                                                $iv_length_page = openssl_cipher_iv_length($cipher_method_page);
                                                                $options_page = 0;
                                                                $encryption_iv_page = random_bytes($iv_length_page);

                                                                $encrypted_id_page = openssl_encrypt((string)$unique_id_page, $cipher_method_page, $encryption_key_page, $options_page, $encryption_iv_page);
                                                                $encrypted_id_with_iv_page = base64_encode($encryption_iv_page . $encrypted_id_page);
                                                                return $encrypted_id_with_iv_page;
                                                            }

                                                            $encryption_key_page = '172008bavly12345';
                                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                                $unique_id_page = $row["id"];
                                                                $encrypted_id_page = encrypt_id($unique_id_page, $encryption_key_page);

                                                                echo "{ text: '" . addslashes($row["verse_reference"]) . "', value: 'page.php?id=" . urlencode($encrypted_id_page) . "' },";
                                                            }
                                                            ?>
                                                        ];

                                                        options.forEach(function(option) {
                                                            var opt = document.createElement('option');
                                                            opt.value = option.value;
                                                            opt.text = option.text;
                                                            select.appendChild(opt);
                                                        });

                                                        select.onchange = function() {
                                                            urlInput.value = select.value;
                                                        };

                                                        urlInput.style.display = 'none';

                                                        urlInput.parentNode.appendChild(select);
                                                    }
                                                }, 1);
                                            }
                                        });
                                    }
                                <?php } ?>
                            });

                        }
                    });
                </script>

            </body>

            </html>



    <?php
            require_once './includes/layout/footer.php';
        } else {
            header('location: index.php');
            exit();
        }
    } else {
        header('location: login.php');
        exit();
    }
