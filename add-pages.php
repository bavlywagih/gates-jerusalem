<?php
session_start();
if (isset($_SESSION['username'])) {

    require_once "./includes/layout/header.php";
    require_once "./includes/layout/nav.php";
    require_once 'connect.php';
    require_once 'functions.php';

    // وظيفة للحصول على المعرف الرقمي الأخير من قاعدة البيانات
    function get_last_id($pdo)
    {
        $stmt = $pdo->prepare("SELECT MAX(id) FROM pages");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // وظيفة لتوليد معرف رقمي متتالي
    function generate_sequential_id($pdo)
    {
        $last_id = get_last_id($pdo);
        if ($last_id === false) {
            // إذا لم يكن هناك أي سجل في قاعدة البيانات
            return 1;
        } else {
            return $last_id + 1;
        }
    }

    // استخدام الوظيفة لتوليد معرف رقمي متتالي
    $unique_id = generate_sequential_id($pdo);
    // echo "Unique ID: " . $unique_id;

    // وظيفة لتشفير ID
    function encrypt_id($unique_id, $encryption_key)
    {
        $cipher_method = 'AES-128-CTR';
        $iv_length = openssl_cipher_iv_length($cipher_method);
        $options = 0;
        $encryption_iv = random_bytes($iv_length);

        // تشفير ID
        $encrypted_id = openssl_encrypt((string)$unique_id, $cipher_method, $encryption_key, $options, $encryption_iv);

        // ضم IV مع النص المشفر
        $encrypted_id_with_iv = base64_encode($encryption_iv . $encrypted_id);
        return $encrypted_id_with_iv;
    }

    // تشفير المعرف
    $encryption_key = '172008bavly12345'; // مفتاح بطول 16 حرفًا
    $encrypted_id = encrypt_id($unique_id, $encryption_key);
    // echo "<br>Encrypted ID: " . $encrypted_id;

    // echo '<br><a href="page.php?id=' . $encrypted_id . '">Decrypt ID</a>';

?>

    <div class="container my-3 no-print">
        <div class="card rounded-3 card-w-90" style="width: 60%; margin: auto;">
            <div class="card-body m-auto">
                <h5 class="card-title text-center">انشاء باب من ابواب اورشليم</h5>
                <form action="" method="POST">
                    <div class="form-group">
                        <div class="d-flex flex-column">
                            <label for="file-picker" class="form-label">عنوان الصفحة </label>
                            <input type="text" require class="form-control" name="name" placeholder="اكتب اسم الباب هنا">
                        </div>
                        <div class="my-2">
                            <label for="file-picker" class="form-label"> شرح : </label>
                            <textarea class="form-control " require name="text" id="post-editor" rows="5"></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" style="width: 100%;">ارسال</button>
                </form>
            </div>
        </div>
    </div>

<?php
    require_once './includes/layout/footer.php';
} else {
    header('location: login.php');
    exit();
}
