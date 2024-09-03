<?php
session_start();
if (isset($_SESSION['username']) && isset($con)) {
    header('location: index.php');
    exit();
}
require_once('includes/layout/header.php');

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
    $username     = trim($_POST['username']);
    $password     = trim($_POST['password']);
    $fullname     = trim($_POST['fullname']);
    $phone        = trim($_POST['phone']);
    $email        = trim($_POST['email']);
    $birthdate    = trim($_POST['birthdate']);
    if (!empty($username) && !empty($password) && !empty($fullname) && !empty($phone) && !empty($birthdate) && !empty($email)) {
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count == 0) {
            $stmt = $con->prepare("INSERT INTO users (username, password, fullname, phone, birthdate, email) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$username, $password, $fullname, $phone, $birthdate, $email]);
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['phone'] = $phone;
            $_SESSION['birthdate'] = $birthdate;
            $_SESSION['email'] = $email;
            $_SESSION['group-id'] = 0;
            $_SESSION['id'] = $con->lastInsertId();
            header('location: index.php');
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

<div class="wrapper">
    <div class="text-center mt-2 name">
        <h3 class="cairo f-w-b">
            انشاء حساب
        </h3>
    </div>
    <form class="p-3 mt-3" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="form-field d-flex align-items-center">
            <div class="input-group  flex-column">
                <label for="username" class="form-label cairo-semibold">اسم المستخدم :</label>
                <div class="d-flex">
                    <input type="text" name="username" id="username" placeholder="اسم المستخدم " class=" user-form-signup form-control w-100" aria-label="Username" aria-describedby="addon-wrapping" value="<?= generateRandomUsername($con); ?>">
                    <button type="button" class="border border-0 mt-2 ps-2" onclick="randomizeUsername()"><i class="fa-solid fa-rotate-right"></i></button>
                </div>
                <span class="user-name-inform-input el-messiri " data-translate="user-name-inform-input">* اسم المستخدم يجب الاحتفاظ به لأنه مطلوب لتسجيل الدخول.</span>
            </div>
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

        <script>
            window.onload = function() {
                const today = new Date();
                today.setDate(today.getDate() + 1);
                const yesterday = today.toISOString().split('T')[0];
                document.getElementById('birthdate').setAttribute('max', yesterday);
            };
        </script>

        <button class="btn mt-3 cairo">انشاء حساب</button>
        <div class="py-2">
            <a href="login.php" class="text-black cairo text-blue-hover">تسجيل دخول</a>
        </div>
    </form>
</div>

<script>
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
</script>

<?php require_once('includes/layout/footer.php'); ?>