<!-- 
require_once '../connect.php'; // تأكد من المسار الصحيح

// استرجاع البيانات من قاعدة البيانات
$sql = "SELECT id, name, text FROM gates";
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// إرجاع البيانات بتنسيق JSON
header('Content-Type: application/json');
echo json_encode($results); -->

<?php
header('Content-Type: application/json');

// مثال على بيانات JSON
$data = [
    ['id' => 1, 'name' => 'بيان 1', 'text' => 'هذا نص تجريبي.'],
    ['id' => 2, 'name' => 'بيان 2', 'text' => 'نص آخر للتجربة.'],
    // أضف المزيد من البيانات حسب الحاجة
];

echo json_encode($data);
