<?php
include 'connect.php';

$id_to_delete = $_GET['gates-jerusalem-Id-delete'];
if (!isset($id_to_delete)) {
    header('location: gates-jerusalem.php');
    exit();
}
if (empty($id_to_delete)) {
    header('Location: gates-jerusalem.php');
    exit();
}
try {
    $sql = 'DELETE FROM gates WHERE id = :id';
    $stmt = $con->prepare($sql);
    $stmt->bindParam(':id', $id_to_delete, PDO::PARAM_INT);
    $stmt->execute();

    header('location: gates-jerusalem.php');
} catch (PDOException $e) {
    header('location: gates-jerusalem.php');
}
