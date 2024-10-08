<?php
session_start();
if (isset($_SESSION['username'])) {
    header('location: index.php');
    exit();
}
require_once('includes/layout/header.php');
$err = "";
if (isset($_GET['error'])) {
    if ($_GET['error'] == "username") {
        $err = "المستخدم غير موجود.";
    } elseif ($_GET['error'] == "password") {
        $err = "كلمة المرور خاطئة.";
    } elseif ($_GET['error'] == "userpass") {
        $err = "اسم المستخدم وكلمة المرور غير صحيحة.";
    }
}
?>

<div class="wrapper">
    <div class="text-center mt-4 name">
        <h3 class="cairo f-w-b">
            تسجيل دخول
        </h3>
    </div>

    <?php if ($err) { ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert" id="error-alert">
            <strong><?php echo $err; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>

    <form class="p-3 mt-3" action="loginpost.php" method="POST">
        <div class="form-field d-flex align-items-center">
            <div class="input-group flex-column">
                <label for="username" class="form-label cairo-semibold">اسم المستخدم :</label>
                <input type="text" name="username" id="username" placeholder="اسم المستخدم" class="form-control w-100" aria-label="Username">
            </div>
        </div>
        <div class="form-field d-flex align-items-center">
            <div class="input-group flex-column">
                <label for="password" class="form-label cairo-semibold">كلمة المرور :</label>
                <div class="d-flex flex-row align-items-center">
                    <div class="div-hide-password-login-form" id="togglePassword">
                        <span class="fas fa-eye-slash input-group-text input-group-text-icon bg-transparent border-0" id="eyeIcon"></span>
                    </div>
                    <input type="password" class="login-form-password form-control rounded-0" name="password" id="password" placeholder="password">
                </div>
            </div>
        </div>
        <button class="btn mt-3 cairo">تسجيل دخول</button>
        <div class="py-2">
            <a href="signup.php" class="text-black cairo text-blue-hover">إنشاء حساب</a>
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

    document.addEventListener('DOMContentLoaded', function() {
        var errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            setTimeout(function() {
                errorAlert.classList.remove('show');
                errorAlert.classList.add('fade');
                setTimeout(function() {
                    errorAlert.style.display = 'none';
                }, 500); // وقت تأخير لإخفاء التنبيه بعد التأثير
            }, 3000); // إخفاء الرسالة بعد 3 ثواني
        }
    });
</script>

<?php require_once('includes/layout/footer.php'); ?>
