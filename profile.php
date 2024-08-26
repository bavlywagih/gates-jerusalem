<?php
session_start();
require_once 'connect.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
require_once "./includes/layout/header.php";


$userId  = $_SESSION['id'];
$query = "SELECT * FROM users WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $userId);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_OBJ);

$userId = $user->id;
$username = $user->username;
$fullname = $user->fullname;
$_SESSION['username'] = $user->username;
$_SESSION['fullname'] = $user->fullname;

$query = "SELECT image_path FROM profile_image WHERE user_id = :user_id ORDER BY upload_date DESC LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الملف الشخصي</title>
</head>

<body>
    <div class="container-xl container-xl-profile px-4 mt-4">
        <nav class="nav nav-borders row-profile">
            <a class="nav-link active ms-0" href="#">Profile</a>
        </nav>
        <hr class="mt-0 mb-4">
        <div class="row row-profile">
            <div class="col-xl-4">
                <form id="uploadForm" class="card-body text-center">
                    <a href="gallery-profile.php">
                        <img id="profileImage" class="img-account-profile rounded mb-2 text-black" src="<?php if (isset($result->image_path)) {echo htmlspecialchars($result->image_path);}else{echo "media/profile/user-profile.png" ;} ?>" alt="Profile Image">
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
                            <input type="hidden" name="id" value="<?= htmlspecialchars($userId); ?>">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">الاسم الكامل</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" value="<?= htmlspecialchars($user->fullname); ?>" required>
                            </div>
                            <div id="qrcode" class="d-flex justify-content-center"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="includes/js/qrcode.js"></script>

    <script>
        // النص الذي تريد تحويله إلى رمز QR
        var text = "<?= $urlParts['scheme'] . '://' . $urlParts['host'] . $path ?>";

        // توليد رمز QR
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: text,
            width: 128, // عرض الرمز
            height: 128 // ارتفاع الرمز
        });
    </script>

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

        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('profileForm');
            const sendFormData = () => {
                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.text())
                    .then(text => {
                        try {
                            const data = JSON.parse(text);
                            if (data.status === 'success') {
                                // alert('تم تحديث البيانات بنجاح');
                            } else {
                                alert('حدث خطأ أثناء تحديث البيانات: ' + data.message);
                            }
                        } catch (error) {
                            console.error('Error parsing JSON:', error);
                            alert('حدث خطأ في معالجة الرد من الخادم.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('حدث خطأ أثناء تحديث البيانات');
                    });
            };

            form.querySelectorAll('input').forEach(input => {
                input.addEventListener('change', sendFormData);
            });
        });
    </script>

    <?php require_once './includes/layout/footer.php'; ?>
</body>

</html>