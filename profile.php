<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

require_once "./includes/layout/header.php";
require_once "./includes/layout/nav.php";
require_once 'connect.php';
require_once 'functions.php';

$userId  = $_SESSION['id'];
$query = "SELECT * FROM users WHERE id = :id LIMIT 1";
$stmt = $con->prepare($query);
$stmt->bindParam(':id', $userId);
$stmt->execute();
$user = $stmt->fetch();
$userId = $user['id']; 
$username = $user['username'];
$fullname = $user['fullname'];
$_SESSION['username'] = $user['username'];
$_SESSION['fullname'] = $user['fullname'];
$query = "SELECT image_path FROM profile_image WHERE user_id = :user_id ORDER BY upload_date DESC LIMIT 1";
$stmt = $con->prepare($query);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$result = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الملف الشخصي</title>
    <style>
        .img-account-profile {
            height: 10rem;
        }

        .rounded-circle {
            border-radius: 50% !important;
        }

        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgb(33 40 50 / 15%);
        }

        .card .card-header {
            font-weight: 500;
        }

        .form-control {
            display: block;
            width: 100%;
            padding: 0.875rem 1.125rem;
            font-size: 0.875rem;
            color: #69707a;
            background-color: #fff;
            border: 1px solid #c5ccd6;
            border-radius: 0.35rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .nav-borders .nav-link.active {
            color: #0061f2;
            border-bottom-color: #0061f2;
        }
    </style>
</head>

<body>

    <div class="container-xl px-4 mt-4">

        <nav class="nav nav-borders" style="flex-direction: row-reverse;">
            <a class="nav-link active ms-0" href="#">Profile</a>
        </nav>
        <hr class="mt-0 mb-4">
        <div class="row" style="flex-direction: row-reverse;">
            <div class="col-xl-4">
                <form id="uploadForm" class="card-body text-center">

                        <a href="gallery-profile.php">
                            <img id="profileImage" class="img-account-profile rounded mb-2 text-black" src="<?= htmlspecialchars($result['image_path']) ?>" alt="Profile Image">
                        </a>

                    <input type="file" id="profileImagesInput" name="profile_images[]" accept="image/*" required class="form-control mb-2" multiple>

                    <div class="small font-italic text-muted mb-4">JPG أو PNG بحجم لا يتجاوز 10 ميجابايت</div>

                </form>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">تفاصيل الحساب</div>
                    <div class="card-body">
                        <form id="profileForm" action="update_profile.php" method="post">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($userId); ?>">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">الاسم الكامل</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('profileImagesInput').addEventListener('change', function(event) {
            const formData = new FormData();
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                if (files[i].size > 10 * 1024 * 1024) {
                    alert("حجم الصورة كبير جداً. الرجاء اختيار صور أصغر.");
                    return;
                }
                formData.append('profile_images[]', files[i]);
            }

            fetch('upload_image_profile.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    data.forEach(item => {
                        if (item.status === 'success') {
                            document.getElementById('profileImage').src = item.image_path; 
                        } else {
                            alert(item.message); 
                        }
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('profileForm');

            const sendFormData = () => {
                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(data => {
                        location.assign("profile.php");
                        alert('تم تحديث البيانات بنجاح');
                        console.log('Success:', data);
                    })
                    .catch(error => {
                        alert('حدث خطأ أثناء تحديث البيانات');
                        console.error('Error:', error);
                    });
            };

            form.querySelectorAll('input').forEach(input => {
                input.addEventListener('change', sendFormData);
            });

        });
        
    </script>

    <?php
    require_once './includes/layout/footer.php';
    ?>

</body>

</html>