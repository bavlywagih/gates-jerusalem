<?php
session_start();

if (!isset($_SESSION['username'])) {
    echo json_encode(['status' => 'error', 'message' => 'الرجاء تسجيل الدخول أولاً']);
    exit();
}

require_once 'connect.php';

$userId = $_SESSION['id'];

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_images'])) {
    $targetDir = "media/profile/";
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

    foreach ($_FILES['profile_images']['name'] as $key => $val) {
        $fileName = time() . "_" . basename($_FILES["profile_images"]["name"][$key]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["profile_images"]["tmp_name"][$key], $targetFilePath)) {
                $query = "INSERT INTO profile_image (user_id, image_path, upload_date) VALUES (:user_id, :image_path, NOW())";
                $stmt = $con->prepare($query);
                $stmt->bindParam(':user_id', $userId);
                $stmt->bindParam(':image_path', $targetFilePath);

                if ($stmt->execute()) {
                    $response[] = [
                        'status' => 'success',
                        'image_path' => $targetFilePath
                    ];
                } else {
                    $response[] = [
                        'status' => 'error',
                        'message' => 'حدث خطأ أثناء حفظ الصورة في قاعدة البيانات.'
                    ];
                }
            } else {
                $response[] = [
                    'status' => 'error',
                    'message' => 'حدث خطأ أثناء رفع الصورة.'
                ];
            }
        } else {
            $response[] = [
                'status' => 'error',
                'message' => 'نوع الملف غير مدعوم. الرجاء اختيار صورة بصيغة JPG أو JPEG أو PNG أو GIF.'
            ];
        }
    }

    echo json_encode($response);

}
