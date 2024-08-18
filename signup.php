<?php
session_start();
if (isset($_SESSION['username'])) {
    header('location: index.php');
    exit();
}

require_once('includes/layout/header.php');
require_once('connect.php');
require_once('includes/layout/nav.php');

function generateRandomUsername($con)
{
    $words = array(
        'saint', 'icon', 'cross', 'liturgy', 'bishop', 'priest', 'deacon', 'monk',
        'nun', 'cathedral', 'psalm', 'gospel', 'apostle', 'martyr', 'holy', 'baptism',
        'chrismation', 'eucharist', 'orthodox', 'vespers', 'hymn', 'fasting', 'pascha',
        'nativity', 'trinity', 'resurrection', 'ascension', 'pentecost', 'transfiguration',
        'annunciation', 'theotokos', 'iconostasis', 'clergy', 'divine', 'sacrament'
    );

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
            $stmt->execute(array($username));
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
    if (!empty($username) && !empty($password) && !empty($fullname)) {
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count == 0) {
            $stmt = $con->prepare("INSERT INTO users (username, password, fullname) VALUES (?, ?, ?)");
            $stmt->execute([$username, $password, $fullname]);
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['group-id'] = 0;
            $_SESSION['id'] = $row['id'];
            header('location: index.php');
            exit();
        } else {
            echo "المستخدم موجود بالفعل";
        }
    } else {
        echo "جميع الحقول مطلوبه";
    }
}

?>

<div class="wrapper">
    <div class="logo">
        <!-- <i class="fa-solid fa-user"></i> -->
        <img src="media/img/icon-user.png" class="icon-user" alt="">
    </div>
    <div class="text-center  name">
        <br>
        <span>
            تسجيل دخول
        </span>
    </div>


    <form class="p-3 mt-3" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="form-field d-flex align-items-center">
            <div class="input-group  flex-column">
                <label for="username" class="form-label">اسم المستخدم :</label>
                <input type="text" id="disabledInput" style="cursor: not-allowed;" name="username" id="username" readonly placeholder="اسم المستخدم " class=" user-form-signup form-control w-100" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping" value="<?php echo generateRandomUsername($con); ?>">
                <span style="font-size:small; color:red;" data-translate="user-name-inform-input">* اسم المستخدم لا يمكن تعديله ويجب الاحتفاظ به لأنه مطلوب لتسجيل الدخول.</span>
            </div>
        </div>

        <div class="form-field d-flex align-items-center">
            <div class="input-group  flex-column">
                <label for="username" class="form-label">كلمة المرور :</label>
                <div class="d-flex flex-row align-items-center">
                    <div class="div-hide-password-login-form" id="togglePassword" style="padding-top: 4px; padding-bottom: 4px;">
                        <span class="fas fa-eye-slash input-group-text bg-transparent border-0 pe-auto" style="cursor: pointer !important;" id="eyeIcon"></span>
                    </div>
                    <input type="password" class="form-control rounded-0" name="password" id="password" placeholder="password">
                </div>
            </div>
        </div>

        <div class="input-group  flex-column">
            <label for="fullname" class="form-label">اسم المستخدم :</label>
            <input type="text" name="fullname" class="form-control w-100" id="fullname" placeholder="اسم المستخدم كامل" aria-label="fullname">
        </div>


        <button class="btn mt-3">تسجيل دخول</button>
    </form>


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
</script>

<?php
require_once('includes/layout/footer.php');

?>