<?php
session_start();
if (isset($_SESSION['username'])) {
    header('location: index.php');
    exit();
}

require_once('includes/layout/header.php');
require_once('connect.php');
require_once('includes/layout/nav.php');



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM users WHERE username = ?  AND password = ? ");
    $stmt->execute(array($username, $password));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($count > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['group-id'] = $row['group-id'];
        $_SESSION['id'] = $row['id'];
        header('location: index.php');
        exit();
    } else {
        echo "الاسم أو كلمة المرور غير صحيحة";
    }
}

?>

<div class="wrapper">
    <div class="logo">
        <!-- <i class="fa-solid fa-user"></i> -->
        <img src="http://localhost/gates-jerusalem/media/img/icon-user.png" class="icon-user" alt="">
    </div>
    <div class="text-center mt-4 name">
        <br>
        <span>
            تسجيل دخول
        </span>
    </div>


    <form class="p-3 mt-3" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

        <div class="form-field d-flex align-items-center">
            <div class="input-group  flex-column">
                <label for="username" class="form-label">اسم المستخدم :</label>
                <input type="text" name="username" id="username" placeholder="اسم المستخدم " class="form-control w-100" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            <!-- <input type="text" name="username" id="username" placeholder="username"> -->
        </div>
        <div class="form-field d-flex align-items-center">
            <div class="input-group  flex-column">
                <label for="username" class="form-label">كلمة المرور :</label>
                <div class="d-flex flex-row align-items-center">
                    <div class="div-hide-password-login-form" id="togglePassword">
                        <span class="fas fa-eye-slash input-group-text bg-transparent border-0 pe-auto" style="cursor: pointer !important; height: 24px;" id="eyeIcon"></span>
                    </div>
                    <input type="password" class="login-form-password form-control rounded-0"  name="password" id="password" placeholder="password">
                </div>
            </div>
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