<?php
session_start();

if (isset($_SESSION['username'])) {

    require_once "./includes/layout/header.php";
    require_once "./includes/layout/nav.php";
    require_once 'connect.php';
    require_once 'functions.php';

    function decrypt_id($encrypted_id_with_iv, $encryption_key)
    {
        $cipher_method = 'AES-128-CTR';
        $iv_length = openssl_cipher_iv_length($cipher_method);
        $options = 0;

        $encrypted_data = base64_decode($encrypted_id_with_iv);

        $encryption_iv = substr($encrypted_data, 0, $iv_length);
        $encrypted_id = substr($encrypted_data, $iv_length);

        $decrypted_id = openssl_decrypt($encrypted_id, $cipher_method, $encryption_key, $options, $encryption_iv);
        return $decrypted_id;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $encrypted_id_with_iv = $_GET["id"];
        $encryption_key = '172008bavly12345'; 
        $decrypted_id = decrypt_id($encrypted_id_with_iv, $encryption_key);
        // echo "Decrypted ID: " . $decrypted_id;

        $stmt = $con->prepare("SELECT * FROM pages WHERE id = ? ");
        $stmt->execute(array($decrypted_id));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();

        if ($count > 0) {
            $verse_reference = $row['verse_reference'];
            $verse = $row['verse'];
        }
        // echo $verse_reference . $verse;
    }


?>
    <button onclick="toggleTashkeel()">تبديل التشكيل</button>

    <div id="textContainer">
        <h1 id="textOutput">
            <?php echo $verse . $verse_reference;?>
        </h1>
    </div>

    <script>

        var h1 = document.getElementById('textOutput');
        var originalText = h1.textContent;

        var noTashkeelText = originalText.replace(/[\u0610-\u061A\u064B-\u065F\u0670-\u06E9\u06EE-\u06EF\u06FA-\u06FC\u06FF]/g, '');

        var hasTashkeel = true;

        function toggleTashkeel() {

            if (hasTashkeel) {
                h1.textContent = noTashkeelText;
            } else {
                h1.textContent = originalText;
            }

            hasTashkeel = !hasTashkeel;
        }
    </script>

<?php
    require_once './includes/layout/footer.php';
} else {
    header('location: login.php');
    exit();
}
