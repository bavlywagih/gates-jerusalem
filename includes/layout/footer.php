
    <style>
        .nav-active-link {
            color: var(--main-color) !important;
        }

        .font-footer {
            color: #fff;
            font-family: 'Cairo', sans-serif;
        }
    </style>


    <span class="up"><i class="fa-solid fa-chevron-up"></i></span>

    <footer class="no-print">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3 links">
                    <ul>
                        <li><a href="index.php" class="font-footer <?php echo $activeHome ? 'nav-active-link' : '' ?>">الصفحة الرئيسية</a></li>
                        <?php if (!isset($_SESSION['username'])) { ?>
                            <li><a class="nav-link text-white <?php echo $activelogin ? 'nav-active-link' : '' ?> font-footer" href="login.php">تسجيل الدخول</a></li>
                            <li><a href="signup.php" class="<?php echo $activesignup ? 'nav-active-link' : '' ?> font-footer" href="signup.php">انشاء حساب</a></li>
                        <?php } else { ?>
                            <li><a href="gates-jerusalem.php" class="font-footer <?php echo $activeContent ? 'nav-active-link' : '' ?>">ابواب اورشليم</a></li>
                            <li><a href="search.php" class="font-footer <?php echo $activeSearchPage ? 'nav-active-link' : '' ?>">ابحث عن الاباء البطاركة</a></li>
                            <li><a href="search.php" class="font-footer <?php echo $activeaddPage ? 'nav-active-link' : '' ?>">انشاء صفحات</a></li>
                            <li><a href="logout.php" class="font-footer">تسجيل خروج</a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="col social-links">
                    <a href="https://www.facebook.com/profile.php?id=61561516863128"><i class="fab fa-facebook"></i></a>
                    <a href="https://api.whatsapp.com/send?phone=201063325054 "><i class="fab fa-whatsapp"></i></a>
                    <a href="mailto:bavlywagih696@gmail.com"><i class="fa fa-envelope"></i></a>
                </div>
            </div>
            <p class="copyright">All Rights reserved <a href="https://www.facebook.com/profile.php?id=61561516863128">Bavly</a> © 2024</p>
        </div>
    </footer>

    <?php
    $query = "
        SELECT id, page_title AS title, 'page' AS type 
        FROM pages 
        UNION 
        SELECT id, name AS title, 'gate' AS type 
        FROM gates
    ";

    $stmt = $con->query($query);
    $row_count = $stmt->rowCount();
    ?>

    <script type="text/javascript" src="includes/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript" src="includes/js/jquery.js"></script>
    <script type="text/javascript" src="includes/js/all.min.js"></script>
    <script src="includes/js/popper.min.js"></script>
    <script src="includes/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="includes/js/main.js"></script>

    <script>
        let el = document.querySelector(".scroller");
        let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;

        function updateScroller() {
            const scrollTop = document.documentElement.scrollTop;
            el.style.width = `${(scrollTop / height) * 100}%`;
        }

        window.addEventListener("scroll", updateScroller);
        window.addEventListener("resize", () => {
            height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            updateScroller();
        });

        updateScroller();

        document.addEventListener('copy', function(event) {
            let selectedText = window.getSelection().toString();
            selectedText += '\nاقرأ المزيد عن طريق ذلك الرابط: <?php echo $currentPageURL; ?> ';
            event.preventDefault();
            if (event.clipboardData) {
                event.clipboardData.setData('text/plain', selectedText);
            } else if (window.clipboardData) {
                window.clipboardData.setData('Text', selectedText);
            }
            console.log('Async: Copying to clipboard was successful!');
        });

        window.onload = () => {
            console.log('Loaded');
        };
    </script>

    <script>
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

            <?php if ($row_count != 0) : ?>
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
                                        while ($row = $stmt->fetch(PDO::FETCH_OBJ)) {
                                            $unique_id = $row->id;
                                            echo "{ text: '" . addslashes($row->title) . "', value: '" . ($row->type === "page" ? "page.php?id=" : "details.php?gates-jerusalem-Id=") . urlencode($unique_id) . "' },";
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
            <?php endif; ?>
        });
    </script>
    <?php
    if (isset($_SESSION['fullname'])) {
        $userId  = $_SESSION['id'];
        $query = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        $user = $stmt->fetch();
        $userId = $user['id']; 
        $fullname = $user['fullname'];
        $name = $fullname;
        $nameArray = explode(" ", $name);
        $nameuser = $nameArray[0];
    }
    ?>
    <script>
        <?php if (isset($fullname)){ ?>
            document.getElementById("navbarUsername").innerHTML = "<?php echo $nameuser; ?>";
        <?php } ?>
    </script>

