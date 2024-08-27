<?php
require_once 'connect.php';
header('Content-Type: application/json');
$response = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $birthdate = $_POST['birthdate'];
    try {
        $sql = "UPDATE users SET birthdate = :birthdate , phone = :phone , email = :email , fullname = :fullname WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':fullname', $fullname, PDO::PARAM_STR);
        $stmt->bindParam(':birthdate', $birthdate, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->execute();
        $response['status'] = 'success';
        $response['fullname'] = $fullname;
        $response['birthdate'] = $birthdate;
        $response['birthdate'] = $email;
        $response['phone'] = $phone;
    } catch (PDOException $e) {
        $response['status'] = 'error';
        $response['message'] = 'Error: ' . $e->getMessage();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
}
echo json_encode($response);
