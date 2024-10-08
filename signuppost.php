<?php
session_start();
require_once 'connect.php';

$response = [
    'success' => false,
    'errors' => []
];

$username  = trim($_POST['username']);
$password  = trim($_POST['password']);
$fullname  = trim($_POST['fullname']);
$email     = trim($_POST['email']);
$phone     = trim($_POST['phone']);
$birthdate = trim($_POST['birthdate']);
$birthYear = (int)date('Y', strtotime($birthdate));

// Validation
// Username validation
if (empty($username)) {
    $response['errors']['username'] = 'اسم المستخدم مطلوب.';
} elseif (strlen($username) <= 3) {
    $response['errors']['username'] = 'اسم المستخدم يجب أن يكون أكثر من 3 حروف.';
} else {
    $stmt = $con->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetchColumn() > 0) {
        $response['errors']['username'] = 'اسم المستخدم موجود بالفعل.';
    }
}

// Password validation
if (empty($password)) {
    $response['errors']['password'] = 'كلمة المرور مطلوبة.';
} elseif (strlen($password) < 8) {
    $response['errors']['password'] = 'كلمة المرور يجب أن تكون أكثر من 8 أحرف.';
}

// Fullname validation
if (empty($fullname)) {
    $response['errors']['fullname'] = 'الاسم الكامل مطلوب.';
} elseif (strlen($fullname) <= 6) {
    $response['errors']['fullname'] = 'الاسم الكامل يجب أن يكون أكثر من 6 حروف.';
}

// Email validation
if (empty($email)) {
    $response['errors']['email'] = 'البريد الإلكتروني مطلوب.';
}

// Phone number validation
if (empty($phone)) {
    $response['errors']['phone'] = 'رقم الهاتف مطلوب.';
} elseif (!preg_match('/^01[0-9]{9}$/', $phone)) {
    $response['errors']['phone'] = 'رقم الهاتف يجب أن يبدأ بـ "01" ويحتوي على 11 رقمًا.';
}

// Birthdate validation
if (empty($birthdate)) {
    $response['errors']['birthdate'] = 'تاريخ الميلاد مطلوب.';
} elseif ($birthYear < 1943) {
    $response['errors']['birthdate'] = 'سنة الميلاد يجب ألا تكون أقل من 1943.';
}

if (empty($response['errors'])) {
    $stmt = $con->prepare("INSERT INTO users (username, password, fullname, phone, birthdate, email) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$username, $password, $fullname, $phone, $birthdate, $email]);

    $_SESSION['username'] = $username;
    $_SESSION['fullname'] = $fullname;
    $_SESSION['phone'] = $phone;
    $_SESSION['birthdate'] = $birthdate;
    $_SESSION['email'] = $email;
    $_SESSION['id'] = $con->lastInsertId();

    $response['success'] = true;
}

echo json_encode($response);
?>
