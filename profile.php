<?php
session_start();
ob_start();
require_once 'connect.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
require_once "./includes/layout/header.php";

// تحديد المعرف
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
} else {
    $userId = $_SESSION['id'];
}

$query = "SELECT * FROM users WHERE id = :id LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':id', $userId, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_OBJ);
if ($user == false) {
    header('Location: profile.php');
    exit();
}

// جلب بيانات المستخدم
$username = $user->username;
$fullname = $user->fullname;
$email = $user->email;
$birthdate = $user->birthdate;
$phone = $user->phone;
$_SESSION['username'] = $username;
$_SESSION['fullname'] = $fullname;
$_SESSION['birthdate'] = $birthdate;

$query = "SELECT image_path FROM profile_image WHERE user_id = :user_id ORDER BY upload_date DESC LIMIT 1";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_OBJ);

ob_end_flush();
?>

<style>
    .footer {
        margin-top: 126px;
    }
</style>

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
        <div class="row row-profile justify-content-center">
            <?php if (!isset($_GET['id'])) { ?>
                <div class="col-xl-4">
                    <form id="uploadForm" class="card-body text-center">
                        <a href="gallery-profile.php">
                            <img id="profileImage" class="img-account-profile rounded mb-2 text-black" src="<?php echo isset($result->image_path) ? htmlspecialchars($result->image_path) : 'media/profile/user-profile.png'; ?>" alt="Profile Image">
                        </a>
                        <input type="file" id="profileImagesInput" name="profile_images[]" accept="image/*" required class="form-control mb-2" multiple>
                        <div class="small font-italic text-muted mb-4">JPG أو PNG بحجم لا يتجاوز 10 ميجابايت</div>
                    </form>
                </div>
            <?php } ?>
            <div class="col-xl-8 ">
                <div class="card mb-4">
                    <div class="card-header">تفاصيل الحساب</div>
                    <div class="card-body">
                        <form id="profileForm" action="update_profile.php" method="post">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($userId); ?>">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">الاسم الكامل</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" value="<?= htmlspecialchars($fullname); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">رقم الهاتف</label>
                                <input type="number" class="form-control text-end" id="phone" name="phone" value="<?= htmlspecialchars($phone); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">تاريخ الميلاد</label>
                                <input type="date" class="form-control text-end" id="birthdate" name="birthdate" value="<?= htmlspecialchars($birthdate); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الالكتروني</label>
                                <input type="email" class="form-control text-end" id="email" name="email" value="<?= htmlspecialchars($email); ?>" required>
                            </div>
                            <?php if(isset($_GET["id"])){?>
                                <div id="qrcode" class="d-flex justify-content-center"></div>
                            <?php }?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="includes/js/qrcode.js"></script>
    <script>
        var text = "<?= $urlParts['scheme'] . '://' . $urlParts['host'] . $path . "?id=" . $_GET["id"] ?>";
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: text,
            width: 128,
            height: 128
        });
    </script>
    <script>
        <?php if (!isset($_GET['id'])) { ?>
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
        <?php } ?>

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