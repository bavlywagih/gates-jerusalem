<?php
session_start();
if (isset($_SESSION['username']) && $_SESSION['group-id'] == 1) {
    require_once "../includes/layout/header.php";
    require_once "../includes/layout/nav.php";
    require_once '../connect.php';  // الاتصال بقاعدة البيانات
    require_once '../functions.php'; // استدعاء الوظائف العامة

    // توليد ID جديد وتشفيره
    $unique_id = generate_sequential_id($pdo);
    $encryption_key = '172008bavly12345';
    $encrypted_id = encrypt_id($unique_id, $encryption_key);

    // معالجة النموذج بعد إرساله
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once 'process_form.php';
    }

    // عرض النموذج
    require_once 'form_page.php';

    require_once '../includes/layout/footer.php';
} else {
    header('location: ../login.php');
    exit();
}
