<?php
require_once 'connect.php'; // الاتصال بقاعدة البيانات

$query = "SELECT COUNT(*) AS count FROM gates";
$stmt = $pdo->query($query);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($data);
?>
