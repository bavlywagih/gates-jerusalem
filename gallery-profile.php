<?php
session_start();
require 'connect.php';

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
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #1877f2;
            font-size: 24px;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .gallery-item {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: box-shadow 0.3s ease;
        }

        .gallery-item:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .gallery img {
            width: 100%;
            height: auto;
            display: block;
            transition: transform 0.3s ease;
        }

        .gallery img:hover {
            transform: scale(1.05);
        }

        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 0, 0, 0.7);
            border: none;
            color: white;
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            transition: background 0.3s ease;
        }

        .delete-btn:hover {
            background: rgba(255, 0, 0, 0.9);
        }

        .lightbox {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            flex-direction: column;
            text-align: center;
            z-index: 9999;
        }

        .lightbox img {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        }

        .lightbox.active {
            display: flex;
        }

        .upload-date {
            margin-top: 15px;
            color: #fff;
            font-size: 1rem;
            font-weight: 400;
        }

        .overlay {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 1.2rem;
            font-weight: bold;
            opacity: 0;
            transition: opacity 0.3s ease;
            cursor: pointer;
        }

        .gallery-item:hover .overlay {
            opacity: 1;
        }
    </style>
</head>

<body>
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