<?php
require_once 'connect.php'; // الاتصال بقاعدة البيانات

$query = "SELECT * FROM gates ORDER BY id desc";
$stmt = $pdo->query($query);

if ($stmt->rowCount() > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="gate"><a href="details.php?gates-jerusalem-Id=' . $row['id'] . '" class="cairo-semibold f-w-b">' . $row['name'] . '</a></div>';
    }
}
?>
