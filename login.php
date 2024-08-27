<?php
session_start();
if (isset($_SESSION['username'])) {
    header('location: index.php');
    exit();
}
require_once('includes/layout/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($con)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $con->prepare("SELECT * FROM users WHERE username = ?  AND password = ? ");
    $stmt->execute([$username, $password]);
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
    <div class="text-center mt-4 name">
        <h3 class="cairo f-w-b">
            تسجيل دخول
        </h3>
    </div>
    <form class="p-3 mt-3" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
        <div class="form-field d-flex align-items-center">
            <div class="input-group  flex-column">
                <label for="username" class="form-label cairo-semibold">اسم المستخدم :</label>
                <input type="text" name="username" id="username" placeholder="اسم المستخدم " class="form-control w-100" placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping">
            </div>
        </div>
        <div class="form-field d-flex align-items-center">
            <div class="input-group  flex-column">
                <label for="username" class="form-label cairo-semibold ">كلمة المرور :</label>
                <div class="d-flex flex-row align-items-center">
                    <div class="div-hide-password-login-form " id="togglePassword">
                        <span class="fas fa-eye-slash input-group-text input-group-text-icon bg-transparent border-0 pe-auto " id="eyeIcon"></span>
                    </div>
                    <input type="password" class="login-form-password form-control rounded-0" name="password" id="password" placeholder="password">
                </div>
            </div>
        </div>
        <button class="btn mt-3 cairo">تسجيل دخول</button>
        <div class="py-2">
            <a href="signup.php" class="text-black cairo text-blue-hover">انشاء حساب</a>
        </div>
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

<?php require_once('includes/layout/footer.php');?>