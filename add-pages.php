    <?php
    session_start();
    if (isset($_SESSION['username'])) {
        if ($_SESSION['group-id'] == 1) {

            require_once "./includes/layout/header.php";
            require_once "./includes/layout/nav.php";
            require_once 'connect.php';
            require_once 'functions.php';

            if (!isset($_GET["add"])) {
                header('location: add-pages.php?add=verse');
                exit();
            }
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $page_title = trim($_POST['page_title']);
                $id_select = trim($_POST['id_select']);
                $verse_reference = trim($_POST['verse_reference']);
                $verse = trim($_POST['verse']);
                $stmt = $con->prepare("SELECT * FROM pages WHERE page_title = ?");
                $stmt->execute([$page_title]);
                $row = $stmt->fetch();
                $count = $stmt->rowCount();
                if ($count == 0) {
                    $stmt = $con->prepare("INSERT INTO pages ( page_title, verse_reference, verse, id_select) VALUES ( ?, ?, ?, ?)");
                    $stmt->execute([$page_title, $verse_reference, $verse, $id_select]);
                    $id = $con->lastInsertId();
                    header('location: page.php?id=' . $id);
                    exit();
                }
            }

    ?>

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
                                <?php
                                if ($_GET["add"] == "verse") {
                                ?>
                                    <div class="d-flex flex-column" id="verse-reference-div">
                                        <label for="file-picker" class="form-label" id="label-verse-reference">
                                            شاهد الآيه :
                                        </label>
                                        <input type="text" class="form-control" name="verse_reference" placeholder="اكتب شاهد الآيه هنا" id="input-verse-reference">
                                    </div>
                                <?php
                                }
                                ?>
                                <?php
                                if ($_GET["add"] != "verse") {
                                ?>
                                    <div class="my-2">
                                        <label for="file-picker" class="form-label" id="label-verse"> محتوي الصفحه: </label>
                                        <textarea class="form-control" name="verse" id="post-editor" rows="5" style="height: 400px;"></textarea>
                                    </div>
                                <?php
                                } else {
                                ?>
                                    <div class="my-2">
                                        <label for="file-picker" class="form-label" id="label-verse"> الآيه : </label>
                                        <textarea class="form-control" name="verse" id="text-area" rows="5" style="height: 400px;" placeholder="اكتب الآيه هنا"></textarea>
                                    </div>
                                <?php
                                }
                                ?>
                                <div class="my-2">
                                    <label for="file-picker" class="form-label"> اختيار ال صفحة : </label>
                                    <select class="form-select" name="id_select" id="id-select" onchange="navigate()">
                                        <?php
                                        if ($_GET["add"] == "verse") {
                                        ?>
                                            <option value="0" selected>آيه</option>
                                            <option value="1">صفحه</option>
                                        <?php
                                        } else {
                                        ?>
                                            <option value="0">آيه</option>
                                            <option value="1" selected>صفحه</option>
                                        <?php
                                        }
                                        ?>



                                    </select>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-success" style="width: 100%;">ارسال</button>
                        </form>
                    </div>
                </div>
            </div>



            </body>

            </html>
            <script>
                function navigate() {
                    const selectElement = document.getElementById('id-select');
                    const selectedValue = selectElement.value;

                    // تحديد الرابط بناءً على القيمة المختارة
                    let addParam = '';
                    if (selectedValue === '0') {
                        addParam = 'verse';
                    } else if (selectedValue === '1') {
                        addParam = 'page';
                    }

                    // الانتقال إلى الرابط المحدد مباشرةً
                    window.location.href = `add-pages.php?add=${addParam}`;
                }
            </script>


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
