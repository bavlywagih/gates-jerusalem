<?php

// إعداد الاستعلام باستخدام prepare
$query = $con->prepare("SELECT maintenance FROM maintenance");

// تنفيذ الاستعلام باستخدام execute
$query->execute();

// جلب النتائج باستخدام fetch
$row = $query->fetch(PDO::FETCH_ASSOC);

// echo 'Maintenance status: ' . $row['maintenance'];

$current_page = basename($_SERVER['PHP_SELF']);

// طباعة اسم الصفحة
if (($current_page != "login.php" && $current_page != "users.php") && $row['maintenance'] == 1) {
    if (isset($_SESSION['group-id'])) {
        if ($_SESSION['group-id'] != 1 && $_SESSION['group-id'] != 2) {

            if (isset($_SESSION['username'])) {
                $_SESSION = [];

                if (ini_get("session.use_cookies")) {
                    $params = session_get_cookie_params();
                    setcookie(
                        session_name(),
                        '',
                        time() - 42000,
                        $params["path"],
                        $params["domain"],
                        $params["secure"],
                        $params["httponly"]
                    );
                }
                session_destroy();
            }
                header('Location: index.php');
            exit();
        }
    } else {
?>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                color: #333;
                text-align: center;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }

            .container {
                background-color: #ffffff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                max-width: 600px;
                width: 100%;
            }

            h1 {
                color: #d9534f;
                /* لون عناوين بألوان دافئة */
            }

            p {
                font-size: 16px;
                line-height: 1.5;
                margin-bottom: 20px;
            }

            a {
                text-decoration: none;
                color: #ffffff;
                background-color: #5bc0de;
                /* لون خلفية الزر */
                padding: 10px 20px;
                border-radius: 5px;
                font-weight: bold;
            }

            a:hover {
                background-color: #31b0d5;
                /* لون الزر عند التمرير عليه */
            }
        </style>
        <div class="container">
            <h1>الموقع تحت الصيانة</h1>
            <p>نظرًا لأن الموقع في وضع الصيانة، فإن الوصول إلى لوحة التحكم متاح فقط للمسؤولين.</p>
            <p><a href="login.php">تسجيل الدخول كمشرف او سوبر مشرف </a></p>
        </div>
<?php
        exit();
    }
}



?>