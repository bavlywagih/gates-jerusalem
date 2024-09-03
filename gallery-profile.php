<?php
session_start();
require_once 'connect.php';
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['id'];
$query = "SELECT * FROM users WHERE id = :id LIMIT 1";
$stmt = $con->prepare($query);
$stmt->bindParam(':id', $userId);
$stmt->execute();
$user = $stmt->fetch();
$_SESSION['fullname'] = $user['fullname'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    if (isset($_POST['image_id'])) {
        $imageId = $_POST['image_id'];

        try {
            $con->beginTransaction();

            $query = "SELECT image_path FROM profile_image WHERE id = :id";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':id', $imageId);
            $stmt->execute();
            $image = $stmt->fetch();

            if (!$image) {
                throw new Exception('الصورة غير موجودة.');
            }

            $imagePath = $image['image_path'];

            $query = "DELETE FROM profile_image WHERE id = :id";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':id', $imageId);
            $stmt->execute();

            if (file_exists($imagePath)) {
                if (!unlink($imagePath)) {
                    throw new Exception('فشل في حذف الصورة من الخادم.');
                }
            } else {
                throw new Exception('الصورة غير موجودة على الخادم.');
            }

            $con->commit();
            echo 'success';
            exit();
        } catch (Exception $e) {
            $con->rollBack();
            echo 'error: ' . $e->getMessage();
            exit();
        }
    } else {
        echo 'error: معرّف الصورة غير موجود.';
        exit();
    }
}

$query = "SELECT id, image_path, upload_date FROM profile_image WHERE user_id = :user_id ORDER BY upload_date DESC";
$stmt = $con->prepare($query);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$images = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>معرض الصور الشخصية</title>
    <link rel="stylesheet" href="includes/css/pages/gallery-profile.css">
</head>

<body class="overflow-body">
    <div class="container">
        <h2>معرض الصور الشخصية</h2>
        <div class="gallery">
            <?php foreach ($images as $image) : ?>
                <div class="gallery-item">
                    <img src="<?= htmlspecialchars($image['image_path']); ?>"
                        alt="صورة شخصية"
                        loading="lazy"
                        class=" gallery-image"
                        data-upload-date="<?= htmlspecialchars($image['upload_date']); ?>"
                        data-image-id="<?= htmlspecialchars($image['id']); ?>">
                    <div class="overlay">عرض الصورة</div>
                    <button class="delete-btn" data-image-id="<?= htmlspecialchars($image['id']); ?>">×</button>
                </div>
            <?php endforeach; ?>
        </div>
        <div id="lightbox" class="lightbox">

            <img id="lightboxImage" src="" alt="صورة مكبرة">
            <p id="lightboxDate" class="upload-date"></p>
        </div>
    </div>

    <script>
        function timeAgo(date) {
            const now = new Date();
            const seconds = Math.floor((now - date) / 1000);
            const interval = Math.floor(seconds / 60);

            if (interval < 1) return 'منذ بضع ثواني';
            if (interval < 60) return `منذ ${interval} دقيقة${interval > 1 ? '' : ''}`;

            const hours = Math.floor(interval / 60);
            if (hours < 24) return `منذ ${hours} ساعة${hours > 1 ? '' : ''}`;

            const days = Math.floor(hours / 24);
            if (days < 7) return `منذ ${days} يوم${days > 1 ? '' : ''}`;

            const weeks = Math.floor(days / 7);
            if (weeks < 4) return `منذ ${weeks} أسبوع${weeks > 1 ? '' : ''}`;

            const months = Math.floor(weeks / 4);
            if (months < 12) return `منذ ${months} شهر${months > 1 ? '' : ''}`;

            const years = Math.floor(months / 12);
            return `منذ ${years} سنة${years > 1 ? '' : ''}`;
        }

        const galleryImages = document.querySelectorAll('.gallery-image');
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightboxImage');
        const lightboxDate = document.getElementById('lightboxDate');
        const overlays = document.querySelectorAll('.overlay');

        galleryImages.forEach(image => {
            image.addEventListener('click', () => {
                lightboxImage.src = image.src;

                const uploadDate = new Date(image.getAttribute('data-upload-date'));
                lightboxDate.textContent = timeAgo(uploadDate);

                lightbox.classList.add('active');
            });
        });

        overlays.forEach(overlay => {
            overlay.addEventListener('click', (event) => {
                const galleryItem = overlay.closest('.gallery-item');
                const image = galleryItem.querySelector('.gallery-image');

                lightboxImage.src = image.src;

                const uploadDate = new Date(image.getAttribute('data-upload-date'));
                lightboxDate.textContent = timeAgo(uploadDate);

                lightbox.classList.add('active');
            });
        });

        lightbox.addEventListener('click', (event) => {
            if (event.target === lightbox || event.target === lightboxImage) {
                lightbox.classList.remove('active');
            }
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.stopPropagation();
                const imageId = this.getAttribute('data-image-id');

                fetch('gallery-profile.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `action=delete&image_id=${imageId}`
                    })
                    .then(response => response.text())
                    .then(result => {
                        if (result === 'success') {
                            this.parentElement.remove();
                        } else {
                            alert(result);
                        }
                    })
                    .catch(error => {
                        console.error('حدث خطأ:', error);
                        alert('حدث خطأ أثناء محاولة حذف الصورة. يرجى المحاولة مرة أخرى.');
                    });
            });
        });
    </script>

</body>

</html>