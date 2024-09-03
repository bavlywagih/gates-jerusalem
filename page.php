<?php
session_start();
ob_start();

if (isset($_SESSION['username'])) {
    require_once "./includes/layout/header.php";
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
    ob_end_flush();
?>

    <?php if ($id_select == 0) { ?>
        <div class="patriarch-details-container gate-details-container p-3 shadow-lg rounded border">
            <p class="text-center">عرض نص الشاهد التالي من الكتاب المقدس:</p>
            <h2 class="text-center text-light-emphasis"><?= htmlspecialchars($page_title); ?></h2>
            <button onclick="toggleTashkeel()" class="btn btn-success">تبديل التشكيل</button>
            <a href="create-photo.php?id=<?= urlencode($_GET['id']); ?>" class="btn btn-success">إنشاء صورة</a>
            <?php
            if ($_SESSION['group-id'] >= 1) {
            ?>
                <a href="add-pages.php?add=verse&id=<?= urlencode($_GET['id']); ?>" class="btn btn-success">تعديل</a>
            <?php
            }
            ?>
            <div class="content">
                <div id="textContainer">
                    <h3 id="textOutput" style="text-align: center; font-family: 'Cairo', sans-serif;">
                        <?= $verse . ' ' . $verse_reference; ?>
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
        <div class="d-grid">
            <a class="text-end text-black no-print" style="cursor: pointer;" onclick="window.print()"><i class="fa-solid fa-print font-awesom-icon-details-style"></i>طباعة هذه المعلومات... </a>
            <?php if ($_SESSION['group-id'] >= 1) {?>
                <a href="add-pages.php?add=page&id=<?= urlencode($_GET['id']); ?>" class="text-end text-black no-print"> <i class="fa-solid fa-pen"></i> تعديل  </a>
            <?php }?>
        </div>
        <p class="text-center">عرض عنوان الصفحه:</p>
        <h2 class="text-center text-light-emphasis"><?= htmlspecialchars($page_title); ?></h2>
        <div class="container-page">
            <div class="image-section">
                <?php
                if (!empty($images)) {
                    foreach ($images as $image) { ?>
                        <img src="<?= htmlspecialchars($image['image_path']); ?>" class="img-fluid py-2">
                <?php
                    }
                } ?>
            </div>
            <div class="text-section">
                <p> <?= $verse ?></p>
            </div>
        </div>
    <?php } ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.title = "<?= htmlspecialchars($page_title);?>";
        });
    </script>

<?php
    require_once './includes/layout/footer.php';
} else {
    header('Location: login.php');
    exit();
}
?>