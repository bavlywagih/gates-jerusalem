<?php
session_start();
if (isset($_SESSION['username'])) {

    require_once 'connect.php';
    require_once 'functions.php';

    // وظيفة لفك تشفير ID
    function decrypt_id($encrypted_id_with_iv, $encryption_key)
    {
        $cipher_method = 'AES-128-CTR';
        $iv_length = openssl_cipher_iv_length($cipher_method);
        $options = 0;

        // فك ترميز النص المشفر
        $encrypted_data = base64_decode($encrypted_id_with_iv);

        // استخراج IV والنص المشفر
        $encryption_iv = substr($encrypted_data, 0, $iv_length);
        $encrypted_id = substr($encrypted_data, $iv_length);

        // فك تشفير ID
        $decrypted_id = openssl_decrypt($encrypted_id, $cipher_method, $encryption_key, $options, $encryption_iv);
        return $decrypted_id;
    }

    if (isset($_GET['id'])) {
        $encrypted_id_with_iv = $_GET['id'];
        $encryption_key = '172008bavly12345'; // مفتاح بطول 16 حرفًا
        $decrypted_id = decrypt_id($encrypted_id_with_iv, $encryption_key);
        echo "Decrypted ID: " . $decrypted_id;
    }
} else {
    header('location: login.php');
    exit();
}
