<?php
session_start();
require_once 'connect.php';

if (isset($_SESSION['username']) && isset($con)) {
    header('location: index.php');
    exit();
}
require_once('includes/layout/header.php');
?>

<div class="wrapper">
    <div class="text-center mt-2 name">
        <h3 class="cairo f-w-b">انشاء حساب</h3>
    </div>
    <form id="signupForm" class="p-3 mt-3">
        <div class="form-field d-flex align-items-center">
            <div class="input-group flex-column">
                <label for="username" class="form-label cairo-semibold">اسم المستخدم :</label>
                <div class="d-flex">
                    <input type="text" name="username" id="username" placeholder="اسم المستخدم " class="user-form-signup form-control w-100">
                    <button type="button" class="border border-0 mt-2 ps-2" onclick="randomizeUsername()"><i class="fa-solid fa-rotate-right"></i></button>
                </div>
                <span class="user-name-inform-input el-messiri ">* اسم المستخدم يجب أن يكون أكثر من 3 حروف ويجب الاحتفاظ به لأنه مطلوب لتسجيل الدخول.</span>
                <span id="usernameError" class="error-message"></span>
            </div>
        </div>

        <div class="form-field d-flex align-items-center">
            <div class="input-group flex-column">
                <label for="password" class="form-label cairo-semibold">كلمة المرور :</label>
                <div class="d-flex flex-row align-items-center">
                    <div class="div-hide-password-login-form" id="togglePassword">
                        <span class="fas fa-eye-slash input-group-text bg-transparent border-0 pe-auto eyeIcon-cursor" id="eyeIcon"></span>
                    </div>
                    <input type="password" class="form-control rounded-0 input-background-signup" name="password" id="password" placeholder="password">
                </div>
                <span class="user-name-inform-input el-messiri ">* كلمة المرور يجب أن تكون أكثر من 8 أحرف.</span>
                <span id="passwordError" class="error-message"></span>
            </div>
        </div>

        <div class="input-group flex-column">
            <label for="fullname" class="form-label cairo-semibold">اسم المستخدم كامل :</label>
            <input type="text" name="fullname" id="fullname" class="form-control w-100">
            <span class="user-name-inform-input el-messiri ">* الاسم الكامل يجب أن يكون أكثر من 6 حروف.</span>
            <span id="fullnameError" class="error-message"></span>
        </div>

        <div class="input-group flex-column">
            <label for="email" class="form-label cairo-semibold">البريد الالكتروني :</label>
            <input type="email" name="email" id="email" class="form-control w-100">
            <span id="emailError" class="error-message"></span>
        </div>

        <div class="input-group py-1 flex-column">
            <label for="phone" class="form-label cairo-semibold">رقم الهاتف :</label>
            <input type="text" name="phone" id="phone" class="form-control w-100" placeholder="مثال: 01012345678">
            <span class="user-name-inform-input el-messiri ">* رقم الهاتف يجب أن يبدأ بـ "01" ويكون 11 رقمًا.</span>
            <span id="phoneError" class="error-message"></span>
        </div>

        <div class="input-group py-1 flex-column">
            <label for="birthdate" class="form-label cairo-semibold">تاريخ الميلاد :</label>
            <input type="date" name="birthdate" id="birthdate" class="form-control w-100">
            <span class="user-name-inform-input el-messiri ">* يجب أن يكون سنة الميلاد أكبر من أو يساوي 1943.</span>
            <span id="birthdateError" class="error-message"></span>
        </div>

        <button type="submit" class="btn mt-3 cairo">انشاء حساب</button>
        <div class="py-2">
            <a href="login.php" class="text-black cairo text-blue-hover">تسجيل دخول</a>
        </div>
    </form>
</div>

<script>
    document.getElementById('signupForm').addEventListener('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'signuppost.php', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.success) {
                    window.location.href = 'index.php';
                } else {
                    document.getElementById('usernameError').textContent = response.errors.username || '';
                    document.getElementById('passwordError').textContent = response.errors.password || '';
                    document.getElementById('fullnameError').textContent = response.errors.fullname || '';
                    document.getElementById('emailError').textContent = response.errors.email || '';
                    document.getElementById('phoneError').textContent = response.errors.phone || '';
                    document.getElementById('birthdateError').textContent = response.errors.birthdate || '';
                }
            }
        };
        xhr.send(formData);
    });

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
