<?php


$host = 'sql103.byetcluster.com'; // خادم قاعدة البيانات الخاص بـ InfinityFree
$user = 'if0_37211517'; // اسم المستخدم لقاعدة البيانات
$password = 'vmix852456'; // كلمة المرور الخاصة بقاعدة البيانات
$dbname = 'if0_37211517_jerusalem_gates'; // اسم قاعدة البيانات
$dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8mb4';
$pdo = new PDO($dsn, $user, $password);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);
try {
    $con = new PDO($dsn, $user, $password, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo ' connect db';
} catch (PDOException $e) {
    echo 'no connect db';
}