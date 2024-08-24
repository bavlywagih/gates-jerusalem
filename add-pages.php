<?php
session_start();
ob_start();
if (!isset($_GET["add"])) {
    header('Location: add-pages.php?add=verse');
    exit();
}

$add = $_GET["add"];
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!in_array($add, ["verse", "page", "manyverse"])) {
    header('Location: add-pages.php?add=verse');
    exit();
}

if (isset($_SESSION['username'])) {
    if ($_SESSION['group-id'] == 1) {
        require_once "./connect.php";
        require_once "./includes/layout/header.php";
        require_once 'functions.php';

        $pageData = [
            'page_title' => '',
            'verse_reference' => '',
            'verse' => '',
            'id_select' => $add == 'verse' ? '0' : ($add == 'page' ? '1' : '2')
        ];

        $pageImages = [];

        if ($id) {
            try {
                $stmt = $con->prepare("SELECT * FROM pages WHERE id = ?");
                $stmt->execute([$id]);
                $pageData = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$pageData) {
                    echo "الصفحة أو الآية غير موجودة.";
                    exit();
                }
                $stmt = $con->prepare("SELECT * FROM page_images WHERE page_id = ?");
                $stmt->execute([$id]);
                $pageImages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo "خطأ في قاعدة البيانات: " . $e->getMessage();
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $page_title = trim($_POST['page_title']);
            $id_select = trim($_POST['id_select']);
            $verse_reference = isset($_POST['verse_reference']) ? trim($_POST['verse_reference']) : null;
            $verse = trim($_POST['verse']);

            try {
                if ($id) {
                    $stmt = $con->prepare("UPDATE pages SET page_title = ?, verse_reference = ?, verse = ?, id_select = ? WHERE id = ?");
                    $stmt->execute([$page_title, $verse_reference, $verse, $id_select, $id]);
                    if (isset($_POST['removed_image_ids']) && $_POST['removed_image_ids'] !== '') {
                        $removedImageIds = explode(',', $_POST['removed_image_ids']);
                        foreach ($removedImageIds as $imageId) {
                            $stmt = $con->prepare("SELECT image_path FROM page_images WHERE id = ?");
                            $stmt->execute([$imageId]);
                            $image = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($image) {
                                if (file_exists($image['image_path'])) {
                                    unlink($image['image_path']);
                                }
                                $stmt = $con->prepare("DELETE FROM page_images WHERE id = ?");
                                $stmt->execute([$imageId]);
                            }
                        }
                    }

                    if ($id_select == '1' && isset($_FILES['page_images'])) {
                        $images = $_FILES['page_images'];
                        $uploadDir = 'media/uploads/';
                        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                        foreach ($images['tmp_name'] as $key => $tmp_name) {
                            $image_name = $images['name'][$key];
                            $image_tmp = $images['tmp_name'][$key];
                            $image_size = $images['size'][$key];
                            $image_error = $images['error'][$key];
                            $image_type = $images['type'][$key];

                            if ($image_error === UPLOAD_ERR_OK) {
                                if (in_array($image_type, $allowedTypes)) {
                                    $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
                                    $image_new_name = uniqid() . '.' . $image_ext;
                                    $image_destination = $uploadDir . $image_new_name;

                                    if (move_uploaded_file($image_tmp, $image_destination)) {
                                        $stmt = $con->prepare("INSERT INTO page_images (page_id, image_path) VALUES (?, ?)");
                                        $stmt->execute([$id, $image_destination]);
                                    }
                                } else {
                                    echo "نوع الملف غير مسموح به: $image_type";
                                }
                            } else {
                                echo "حدث خطأ أثناء تحميل الملف: " . $image_error;
                            }
                        }
                    }

                    header('Location: page.php?id=' . $id);
                    exit();
                } else {
                    $stmt = $con->prepare("INSERT INTO pages (page_title, verse_reference, verse, id_select) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$page_title, $verse_reference, $verse, $id_select]);
                    $id = $con->lastInsertId();

                    if ($id_select == '1' && isset($_FILES['page_images'])) {
                        $images = $_FILES['page_images'];
                        $uploadDir = 'media/uploads/';
                        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

                        foreach ($images['tmp_name'] as $key => $tmp_name) {
                            $image_name = $images['name'][$key];
                            $image_tmp = $images['tmp_name'][$key];
                            $image_size = $images['size'][$key];
                            $image_error = $images['error'][$key];
                            $image_type = $images['type'][$key];

                            if ($image_error === UPLOAD_ERR_OK) {
                                if (in_array($image_type, $allowedTypes)) {
                                    $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
                                    $image_new_name = uniqid() . '.' . $image_ext;
                                    $image_destination = $uploadDir . $image_new_name;

                                    if (move_uploaded_file($image_tmp, $image_destination)) {
                                        $stmt = $con->prepare("INSERT INTO page_images (page_id, image_path) VALUES (?, ?)");
                                        $stmt->execute([$id, $image_destination]);
                                    }
                                } else {
                                    echo "نوع الملف غير مسموح به: $image_type";
                                }
                            } else {
                                echo "حدث خطأ أثناء تحميل الملف: " . $image_error;
                            }
                        }
                    }

                    header('Location: page.php?id=' . $id);
                    exit();
                }
            } catch (PDOException $e) {
                echo "خطأ في قاعدة البيانات: " . $e->getMessage();
            }
        }
        ob_end_flush();

?>
        <div class="container my-3 no-print">
            <div class="card rounded-3 card-w-90 card-div-add-pages">
                <div class="card-body m-auto card-body-div">
                    <h5 class="card-title text-center f-w-b cairo" id="card-title"><?= $id ? 'تعديل الصفحة أو الآية' : 'إنشاء آية أو صفحة' ?></h5>
                    <form action="" method="POST" enctype="multipart/form-data" id="page-form">
                        <input type="hidden" name="removed_image_ids" id="removed_image_ids" value="">
                        <div class="form-group">
                            <div class="d-flex flex-column">
                                <label for="file-picker" class="form-label cairo-semibold " id="label-page-title"> عنوان الصفحة :</label>
                                <input type="text" required class="form-control" name="page_title" placeholder="اكتب عنوان الصفحة هنا" value="<?= htmlspecialchars($pageData['page_title']) ?>">
                            </div>
                            <?php if ($pageData['id_select'] == '0') { ?>
                                <div class="d-flex flex-column" id="verse-reference-div">
                                    <label for="file-picker" class="form-label cairo-semibold " id="label-verse-reference"> شاهد الآية :</label>
                                    <input type="text" class="form-control" name="verse_reference" placeholder="اكتب شاهد الآية هنا" id="input-verse-reference" value="<?= htmlspecialchars($pageData['verse_reference']) ?>">
                                </div>
                            <?php } ?>

                            <?php if ($pageData['id_select'] == '1') { ?>
                                <div class="my-2">
                                    <label for="file-picker" class="form-label cairo-semibold " id="label-verse"> محتوى الصفحة: </label>
                                    <textarea class="form-control form-control-textarea" name="verse" id="post-editor" rows="5"><?= htmlspecialchars($pageData['verse']) ?></textarea>
                                </div>

                                <?php if (!empty($pageImages)) { ?>
                                    <div class="my-2">
                                        <label class="form-label cairo-semibold ">الصور الحالية:</label>
                                        <div class="d-flex flex-wrap gap-2 ">
                                            <?php foreach ($pageImages as $image) { ?>
                                                <div class="position-relative px-2">
                                                    <img src="<?= $image['image_path'] ?>" class="page-img" alt="Page Image">
                                                    <button type="button" class="btn-close position-absolute top-0 start-100 translate-middle bg-danger remove-image-btn remove-image-data-image-id " data-image-id="<?= $image['id'] ?>" aria-label="Close"></button>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="my-2">
                                    <label for="image-upload" class="form-label cairo-semibold " id="label-image-upload"> تحميل صور للصفحة: </label>
                                    <input type="file" class="form-control" name="page_images[]" id="image-upload" multiple>
                                </div>
                            <?php } elseif ($pageData['id_select'] == '0') { ?>
                                <div class="my-2">
                                    <label for="file-picker" class="form-label cairo-semibold " id="label-verse"> الآية: </label>
                                    <textarea class="form-control form-control-verse" name="verse" id="text-area" rows="5" placeholder="اكتب الآية هنا"><?= htmlspecialchars($pageData['verse']) ?></textarea>
                                </div>
                            <?php } elseif ($pageData['id_select'] == '2') { ?>
                                <div class="my-2">
                                    <label for="file-picker" class="form-label cairo-semibold " id="label-verse"> آيات متعددة: </label>
                                    <textarea class="form-control post-editor-verse" name="verse" id="post-editor" rows="10" placeholder="اكتب الآيات هنا"><?= htmlspecialchars($pageData['verse']) ?></textarea>
                                </div>
                            <?php } ?>

                            <div class="my-2">
                                <label for="file-picker" class="form-label cairo-semibold "> اختيار الصفحة: </label>
                                <select class="form-select" name="id_select" id="id-select" onchange="navigate()">
                                    <option value="0" <?= $pageData['id_select'] == '0' ? 'selected' : '' ?> class="cairo-semibold ">آية</option>
                                    <option value="1" <?= $pageData['id_select'] == '1' ? 'selected' : '' ?> class="cairo-semibold ">صفحة</option>
                                    <option value="2" <?= $pageData['id_select'] == '2' ? 'selected' : '' ?> class="cairo-semibold ">آيات متعددة</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success cairo w-100" ><?= $id ? 'تحديث' : 'إرسال' ?></button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function navigate() {
                const selectElement = document.getElementById('id-select');
                const selectedValue = selectElement.value;
                let addParam = '';
                if (selectedValue === '0') {
                    addParam = 'verse';
                } else if (selectedValue === '1') {
                    addParam = 'page';
                } else if (selectedValue === '2') {
                    addParam = 'manyverse';
                }
                window.location.href = `add-pages.php?add=${addParam}`;
            }

            document.querySelectorAll('.remove-image-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const imageId = this.getAttribute('data-image-id');
                    const removedImagesInput = document.getElementById('removed_image_ids');
                    let removedImageIds = removedImagesInput.value ? removedImagesInput.value.split(',') : [];

                    if (!removedImageIds.includes(imageId)) {
                        removedImageIds.push(imageId);
                    }
                    removedImagesInput.value = removedImageIds.join(',');

                    this.parentElement.remove();
                });
            });
        </script>

<?php
        require_once './includes/layout/footer.php';
    } else {
        header('Location: index.php');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
?>