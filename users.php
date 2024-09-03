<?php
ob_start();
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
if ($_SESSION['group-id'] != 2) {
    header('Location: index.php');
    exit();
}
require_once "./includes/layout/header.php";
require_once "connect.php"; // تأكد من استيراد اتصال قاعدة البيانات

// استعلام لجلب جميع المستخدمين
$sql = 'SELECT * FROM users';
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$current_user_id = $_SESSION['id'];



if (isset($_GET['do'])) {
    $id_to_delete = $_GET['do'];

    if (!empty($id_to_delete)) {
        // حذف الصور المرتبطة بالمستخدم
        $sql = "DELETE FROM profile_image WHERE user_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_to_delete, PDO::PARAM_INT);
        $stmt->execute();

        // حذف المستخدم
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id_to_delete, PDO::PARAM_INT);
        if ($stmt->execute()) {
            echo "تم حذف المستخدم بنجاح.";
        } else {
            echo "حدث خطأ أثناء حذف المستخدم.";
        }
    }

    header('Location: users.php');
    exit();
}


function generateRandomUsername($con)
{
    $words = [
        'saint',
        'icon',
        'cross',
        'liturgy',
        'bishop',
        'priest',
        'deacon',
        'monk',
        'nun',
        'cathedral',
        'psalm',
        'gospel',
        'apostle',
        'martyr',
        'holy',
        'baptism',
        'chrismation',
        'eucharist',
        'orthodox',
        'vespers',
        'hymn',
        'fasting',
        'pascha',
        'nativity',
        'trinity',
        'resurrection',
        'ascension',
        'pentecost',
        'transfiguration',
        'annunciation',
        'theotokos',
        'iconostasis',
        'clergy',
        'divine',
        'sacrament'
    ];
    $stmt = $con->prepare("SELECT username FROM users WHERE username LIKE 'user-%'");
    $stmt->execute();
    $usernames = $stmt->fetchAll(PDO::FETCH_COLUMN);

    $usedWords = array_map(function ($name) {
        return explode('-', $name)[1];
    }, $usernames);

    if (count($usedWords) == count($words)) {
        do {
            $randomNumber = rand(1000, 9999);
            $username = 'user-' . $randomNumber;
            $stmt = $con->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $count = $stmt->fetchColumn();
        } while ($count > 0);
    } else {
        do {
            $randomWord = $words[array_rand($words)];
        } while (in_array($randomWord, $usedWords));
        $username = 'user-' . $randomWord;
    }
    return $username;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $fullname = trim($_POST['fullname']);
    $phone    = trim($_POST['phone']);
    $email    = trim($_POST['email']);
    $birthdate    = trim($_POST['birthdate']);
    if (!empty($username) && !empty($password) && !empty($fullname) && !empty($phone) && !empty($birthdate) && !empty($email)) {
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count == 0) {
            $stmt = $con->prepare("INSERT INTO users (username, password, fullname, phone, birthdate, email) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$username, $password, $fullname, $phone, $birthdate, $email]);

            header('location: users.php');
            exit();
        } else {
            echo '<style>.spinner-wrapper { display: none; }</style>';
            echo "المستخدم موجود بالفعل";
        }
    } else {
        echo '<style>.spinner-wrapper { display: none; }</style>';
        echo "جميع الحقول مطلوبه";
    }
}


?>
<link rel="stylesheet" href="includes/css/pages/users.css">
<style>
    .user-card img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
    }
</style>
<div class="dashboard">
    <div class="content ">
        <header>
            <h1 id="page-title">مرحبا بك في لوحة التحكم</h1>
            <div class="d-flex justify-content-center">

                <button class="btn btn-primary mx-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">انشاء مستخدم</button>
                <?php
                $query = $con->prepare("SELECT maintenance FROM maintenance");
                $query->execute();
                $row = $query->fetch(PDO::FETCH_ASSOC);
                ?>
                <form action="maintenance-update.php" method="POST">
                    <?php if ($row['maintenance'] == 0) { ?>
                        <button class="btn btn-primary" name="Maintenance" value="1" id="enableMaintenance">تفعيل وضع الصيانه</button>
                    <?php } elseif ($row['maintenance'] == 1) { ?>
                        <button class="btn btn-primary" name="Maintenance" value="0" id="disableMaintenance">الغاء تفعيل وضع الصيانه </button>
                    <?php } ?>
                </form>
            </div>



            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasRightLabel">انشاء حساب</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <form action="" method="POST">
                        <div class="input-group  flex-column">
                            <label for="username" class="form-label cairo-semibold">اسم المستخدم :</label>
                            <div class="d-flex">
                                <input type="text" name="username" id="username" placeholder="اسم المستخدم " class=" user-form-signup form-control w-100" aria-label="Username" aria-describedby="addon-wrapping" value="<?= generateRandomUsername($con); ?>">
                                <button type="button" class="border border-0 mt-2 ps-2 bg-white" onclick="randomizeUsername()"><i class="fa-solid fa-rotate-right"></i></button>
                            </div>
                            <span class="user-name-inform-input el-messiri " data-translate="user-name-inform-input">* اسم المستخدم يجب الاحتفاظ به لأنه مطلوب لتسجيل الدخول.</span>
                        </div>
                        <div class="form-field d-flex align-items-center">
                            <div class="input-group  flex-column">
                                <label for="username" class="form-label cairo-semibold">كلمة المرور :</label>
                                <div class="d-flex flex-row align-items-center">
                                    <div class="div-hide-password-login-form" id="togglePassword">
                                        <span class="fas fa-eye-slash input-group-text bg-transparent border-0 pe-auto eyeIcon-cursor" id="eyeIcon"></span>
                                    </div>
                                    <input type="password" class="form-control rounded-0 input-background-signup" name="password" id="password" placeholder="password">
                                </div>
                            </div>
                        </div>
                        <div class="input-group  flex-column">
                            <label for="fullname" class="form-label cairo-semibold">اسم المستخدم :</label>
                            <input type="text" name="fullname" class="form-control w-100 input-background-signup " id="fullname" placeholder="اسم المستخدم كامل" aria-label="fullname">
                        </div>
                        <div class="input-group  flex-column">
                            <label for="email" class="form-label cairo-semibold"> البريد الالكتروني :</label>
                            <input type="email" name="email" class="form-control text-end w-100 input-background-signup " id="email" placeholder="البريد الالكتروني" aria-label="email">
                        </div>
                        <div class="input-group py-1 flex-column">
                            <label for="phone" class="form-label cairo-semibold"> رقم الهاتف :</label>
                            <input type="number" name="phone" class="form-control text-end w-100 input-background-signup " id="phone" placeholder="رقم الهاتف" aria-label="phone">
                        </div>
                        <div class="input-group py-1 flex-column">
                            <label for="birthdate" class="form-label cairo-semibold"> تاريخ الميلاد :</label>
                            <input type="date" name="birthdate" class="form-control text-end w-100 input-background-signup " id="birthdate" placeholder="تاريخ الميلاد9" aria-label="birthdate">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

        </header>
        <main>
            <div class="users-list gallery">
                <?php foreach ($users as $user) {
                    $user_id = $user['id'];

                    if ($user_id === $current_user_id) {
                        continue; // تخطي بطاقة المستخدم الحالية
                    }
                    // استعلام لجلب الصورة الأكثر حداثة للمستخدم
                    $query = "SELECT image_path FROM profile_image WHERE user_id = :user_id ORDER BY upload_date DESC LIMIT 1";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':user_id', $user_id);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);


                    $image_path = $result ? $result['image_path'] : 'media/profile/user-profile.png';

                ?>
                    <div class="user-card">
                        <img src="<?= htmlspecialchars($image_path) ?>" alt="User Image">
                        <h3><a href="profile.php?id=<?= $user['id'] ?>"><?= htmlspecialchars($user['fullname']) ?></a></h3>
                        <p><?= htmlspecialchars($user['email']) ?></p>
                        <a href="#" class="view-details text-white">عرض التفاصيل</a>
                        <div class="user-details">
                            <p><strong>الهاتف:</strong> 0<?= htmlspecialchars($user['phone']) ?></p>
                            <p><strong>تاريخ الميلاد:</strong> <?= htmlspecialchars($user['birthdate']) ?></p>
                            <p><strong>الحالة:</strong>
                                <?php
                                if ($user['group-id'] == 0) {
                                    echo "مستخدم";
                                } elseif ($user['group-id'] == 1) {
                                    echo "مشرف";
                                } elseif ($user['group-id'] == 2) {
                                    echo "سوبر مشرف";
                                }
                                ?>
                            </p>
                            <a class="btn btn-danger" href="?do=<?= $user_id ?>">حذف</a>
                            <a href="profile.php?id=<?= $user['id'] ?>" class="btn btn-success">تعديل</a>

                            <?php
                            // تحقق إذا كان هناك معرف المستخدم ومعرف المجموعة في العنوان
                            if (isset($_GET['id']) && isset($_GET['groupid'])) {
                                $id = $_GET['id'];
                                $groupid = $_GET['groupid'];

                                // تحديث المجموعة بناءً على معرف المستخدم ومعرف المجموعة المرسل
                                $sql = "UPDATE users SET `group-id` = :groupid WHERE id = :id";
                                $stmt = $pdo->prepare($sql);
                                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                                $stmt->bindParam(':groupid', $groupid, PDO::PARAM_INT);

                                if ($stmt->execute()) {
                                    // إعادة توجيه بعد التحديث
                                    header('Location: users.php');
                                    exit();
                                } else {
                                    echo "حدث خطأ أثناء تحديث المجموعة.";
                                }
                            }

                            if ($user['group-id'] == 0) { ?>
                                <a href="users.php?id=<?= $user['id'] ?>&groupid=1" class="btn btn-success">مشرف</a>
                                <a href="users.php?id=<?= $user['id'] ?>&groupid=2" class="btn btn-success">سوبر مشرف</a>
                            <?php } elseif ($user['group-id'] == 1) { ?>
                                <a href="users.php?id=<?= $user['id'] ?>&groupid=0" class="btn btn-success">مستخدم</a>
                                <a href="users.php?id=<?= $user['id'] ?>&groupid=2" class="btn btn-success">سوبر مشرف</a>
                            <?php } elseif ($user['group-id'] == 2) { ?>
                                <a href="users.php?id=<?= $user['id'] ?>&groupid=0" class="btn btn-success">مستخدم</a>
                                <a href="users.php?id=<?= $user['id'] ?>&groupid=1" class="btn btn-success">مشرف</a>
                            <?php }
                            ?>
                        </div>
                    </div>

                <?php } ?>

                <script>
                    const detailButtons = document.querySelectorAll('.view-details');

                    detailButtons.forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const details = this.nextElementSibling;
                            details.style.display = details.style.display === 'block' ? 'none' : 'block';
                        });
                    });
                </script>
            </div>
        </main>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        var passwordField = document.getElementById('password');
        var eyeIcon = document.getElementById('eyeIcon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        }
    }
    document.getElementById('togglePassword').addEventListener('click', togglePasswordVisibility);

    function randomizeUsername() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'generate_username.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                document.getElementById('username').value = xhr.responseText;
            }
        };
        xhr.send();
    }
</script>
<?php
require_once "./includes/layout/footer.php";
?>