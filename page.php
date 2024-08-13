<?php
session_start();

if (isset($_SESSION['username'])) {
    require_once "./includes/layout/header.php";
    require_once "./includes/layout/nav.php";
    require_once 'connect.php';
    require_once 'functions.php';


    $stmt = $con->prepare("SELECT * FROM pages WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($count > 0) {
        $page_title = $row['page_title'];
        $verse_reference = $row['verse_reference'];
        $verse = $row['verse'];
        $id_select = $row['id_select'];
    } else {
        header('Location: add-pages.php');
        exit();
    }

    $stmt = $con->prepare("SELECT * FROM page_images WHERE page_id = ?");
    $stmt->execute([$_GET['id']]);
    $images = $stmt->fetchAll();
?>
    <?php if ($id_select == 0) { ?>
        <div class="patriarch-details-container p-3 shadow-lg rounded border" style="width: 75%; margin: 60px auto; min-height: 415px;">
            <p class="text-center">عرض نص الشاهد التالي من الكتاب المقدس:</p>
            <h2 class="text-center text-light-emphasis"><?php echo htmlspecialchars($page_title); ?></h2>
            <button onclick="toggleTashkeel()" class="btn btn-success">تبديل التشكيل</button>
            <a href="create-photo.php?id=<?php echo urlencode($_GET['id']); ?>" class="btn btn-success">إنشاء صورة</a>
            <a href="add-pages.php?add=verse&id=<?php echo urlencode($_GET['id']); ?>" class="btn btn-success">تعديل</a>
            <div class="content">
                <div id="textContainer">
                    <h3 id="textOutput" style="text-align: center; font-family: 'Cairo', sans-serif;">
                        <?php echo $verse . ' ' . $verse_reference; ?>
                    </h3>
                </div>
            </div>
        </div>
        <script>
            var h1 = document.getElementById('textOutput');
            var originalText = h1.textContent;

            var noTashkeelText = originalText.replace(/[\u0610-\u061A\u064B-\u065F\u0670-\u06E9\u06EE-\u06EF\u06FA-\u06FC\u06FF]/g, '');

            var hasTashkeel = true;

            function toggleTashkeel() {
                if (hasTashkeel) {
                    h1.textContent = noTashkeelText;
                } else {
                    h1.textContent = originalText;
                }
                hasTashkeel = !hasTashkeel;
            }
        </script>

    <?php } else { ?>
        <style>
            
            a {    
                color: blue;
                text-decoration: underline;
            }

            .container-page {
                display: flex;
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
                flex-direction: row-reverse;
            }

            .image-section {
                flex: 1;
                padding-right: 20px;
            }

            .image-section img {
                width: 100%;
                height: auto;
                border-radius: 10px;
            }

            .text-section {
                flex: 2;
                text-align: right;
                font-size: 1.2em;
                line-height: 1.6;
                color: #333;
            }

            .text-section p {
                margin: 0;
                padding: 0;
            }

            @media print {
                @page {
                    margin-top: 15px;
                    margin-bottom: 15px;
                }

                .no-print {
                    display: none !important;
                }

                body {
                    -webkit-print-color-adjust: exact !important;
                }

                img {
                    width: 20% !important;
                }

                .container-page {
                    display: flex !important;
                    max-width: 1200px !important;
                    margin: 0 auto !important;
                    padding: 20px !important;
                    flex-direction: row-reverse !important;
                }

                .image-section {
                    flex: 1 !important;
                    padding-right: 20px !important;
                }

                .image-section img {
                    width: 100% !important;
                    height: auto !important;
                    border-radius: 10px !important;
                }

                .text-section {
                    flex: 2 !important;
                    text-align: right !important;
                    font-size: 1.2em !important;
                    line-height: 1.6 !important;
                    color: #333 !important;
                }

                .text-section p {
                    margin: 0 !important;
                    padding: 0 !important;
                }
            }
        </style>

        <a class="text-end text-black no-print" style="cursor: pointer;" onclick="window.print()">طباعة هذه المعلومات... <i class="fa-solid fa-print font-awesom-icon-details-style"></i></a><br>
        <a href="add-pages.php?add=page&id=<?php echo urlencode($_GET['id']); ?>" class="text-end text-black no-print">تعديل</a>

        <p class="text-center">عرض عنوان الصفحه:</p>
        <h2 class="text-center text-light-emphasis"><?php echo htmlspecialchars($page_title); ?></h2>
        <div class="container-page">
            <div class="image-section">
                <?php
                if (!empty($images)) {
                    foreach ($images as $image) { ?>
                        <img src="<?php echo htmlspecialchars($image['image_path']); ?>" class="img-fluid py-2">
                <?php
                    }
                } ?>
            </div>
            <div class="text-section">
                <p> <?php echo $verse ?></p>
            </div>
        </div>
    <?php } ?>






<?php
    require_once './includes/layout/footer.php';
} else {
    header('Location: login.php');
    exit();
}
?>