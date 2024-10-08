<?php
header('Content-Type: application/json'); // تأكيد أن الرد سيكون JSON
require_once 'connect.php'; // الاتصال بقاعدة البيانات

$errors = [];
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $text = trim($_POST['text']);
    $id_select = $_POST['id_select'];

    // التحقق من صحة البيانات المدخلة
    if (empty($name)) {
        $errors[] = 'يرجى إدخال اسم الباب.';
    }

    if (empty($text)) {
        $errors[] = 'يرجى إدخال الشرح.';
    }

    if (empty($id_select) || $id_select === 'اختر ID') {
        $errors[] = 'يرجى اختيار ID.';
    }

    // إذا لم تكن هناك أخطاء، يتم إدراج البيانات في قاعدة البيانات
    if (empty($errors)) {
        $sql = "INSERT INTO gates (name, text, id) VALUES (:name, :text, :id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':id', $id_select);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'تمت إضافة الباب بنجاح.';
        } else {
            $response['success'] = false;
            $errors[] = 'حدث خطأ أثناء إدخال البيانات.';
        }
    }

    // إرسال الرد بصيغة JSON
    $response['success'] = empty($errors);
    $response['errors'] = $errors;
    echo json_encode($response);
}
?>
