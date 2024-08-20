<?php
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    echo $fullname . $_POST['id'];

    try {
        $sql = "UPDATE users SET  fullname = :fullname WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $stmt->execute();
        echo 'Profile updated successfully';
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    echo 'Invalid request method';
}
