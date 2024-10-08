<?php 
session_start();
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($con)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // التحقق من وجود المستخدم
    $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // التحقق من صحة كلمة المرور
        if ($password === $user['password']) {
            $_SESSION['username'] = $username;
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['group-id'] = $user['group-id'];
            $_SESSION['id'] = $user['id'];
            header('Location: index.php');
            exit();
        } else {
            // كلمة المرور خاطئة
            $error = "password";
            header('Location: login.php?error=' . urlencode($error));
            exit();
        }
    } else {
        // اسم المستخدم غير موجود
        $error = "username";
        header('Location: login.php?error=' . urlencode($error));
        exit();
    }
}
?>
