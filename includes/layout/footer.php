<span class="up"><i class="fa-solid fa-chevron-up"></i></span>

<footer class="footer no-print">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 text-center">
                <div class="footer-site-logo mb-4">
                    <h5 class="cairo">ابواب اورشليم</h5>
                </div>
                <ul class="list-unstyled nav-links footer-ul-style">
                    <?php if (!isset($_SESSION['username'])) { ?>

                        <li class="cairo-semibold d-inline-block footer-li "> <a href="login.php" class="text-white           text-white-footer <?= $activelogin    ?   'nav-active-link' : '' ?>">تسجيل الدخول </a></li>
                        <li class="cairo-semibold d-inline-block footer-li "> <a href="signup.php" class="text-white          text-white-footer <?= $activesignup   ?   'nav-active-link' : '' ?>">إنشاء حساب </a></li>

                    <?php } else { ?>
                        <li class="cairo-semibold d-inline-block footer-li "> <a href="index.php" class="text-white           text-white-footer <?= $activeHome     ?   'nav-active-link' : '' ?>">الصفحه الرئيسية </a></li>
                        <li class="cairo-semibold d-inline-block footer-li "> <a href="gates-jerusalem.php" class="text-white text-white-footer <?= $activeContent  ?   'nav-active-link' : '' ?>">ابواب اورشليم </a></li>
                        <?php
                        if (isset($_SESSION['group-id'])) {
                            if ($_SESSION['group-id'] >= 1) { ?>
                                <li class="cairo-semibold d-inline-block footer-li "> <a href="add-pages.php" class="text-white       text-white-footer <?= $activeaddPage  ?   'nav-active-link' : '' ?>">انشاء صفحات </a></li>
                        <?php }
                        } ?>

                        <li class="cairo-semibold d-inline-block footer-li "> <a href="profile.php" class="text-white         text-white-footer <?= $activeprofile  ?   'nav-active-link' : '' ?>">الصفحه الشخصيه </a></li>

                        <li class="cairo-semibold d-inline-block footer-li "> <a href="logout.php" class="text-white text-white-footer">تسجيل خروج</a></li>
                    <?php } ?>
                </ul>

                <div class="social mb-4">
                    <ul class="list-unstyled">
                        <ul class="social-icon">
                            <li><a href="https://www.facebook.com/profile.php?id=61561516863128" class="fb"><i class="fa-brands fa-facebook "></i></a></li>
                            <li><a href="https://api.whatsapp.com/send?phone=201063325054" class="wa"><i class="fa-brands fa-whatsapp "></i></a></li>
                            <li><a href="mailto:bavlywagih696@gmail.com" class="em"><i class="fa-solid fa-envelope"></i></a></li>
                        </ul>
                    </ul>
                </div>

                <div class="copyright">
                    <p class="copyright">All rights reserved <a href="https://www.facebook.com/profile.php?id=61561516863128" class="text-white text-white-footer" target="_blank" rel="noopener noreferrer">Bavly</a> © 2024</p>
                </div>


            </div>
        </div>
    </div>
</footer>
<script type="text/javascript" src="includes/js/tinymce/tinymce.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-webcomponent@2/dist/tinymce-webcomponent.min.js"></script>
<script type="text/javascript" src="includes/js/jquery.js"></script>
<script type="text/javascript" src="includes/js/all.min.js"></script>
<script src="includes/js/popper.min.js"></script>
<script src="includes/js/bootstrap.min.js"></script>
<script type="text/javascript" src="includes/js/main.js"></script>

<?php
if (isset($_SESSION['username'])) {

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
        <?php if (isset($fullname)) { ?>
            document.getElementById("navbarUsername").innerHTML = "<?php echo $nameuser; ?>";
        <?php }
    } ?>
    </script>
    <script>
        function adjustFooterPosition() {
            const footer = document.querySelector('footer');
            const body = document.body;
            const html = document.documentElement;
            const bodyHeight = body.offsetHeight;
            const windowHeight = window.innerHeight;
            console.log(bodyHeight);
            if (bodyHeight < windowHeight) {
                footer.style.position = 'fixed';
                footer.style.bottom = '-125';
                footer.style.left = '0';
                footer.style.width = '100%';
            } else {
                footer.style.position = 'static';
            }
        }

        window.addEventListener('load', adjustFooterPosition);

        window.addEventListener('resize', adjustFooterPosition);
    </script>