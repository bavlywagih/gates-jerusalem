<?php
session_start();
if (isset($_SESSION['username'])) {

    require_once "./includes/layout/header.php";
    require_once "./includes/layout/nav.php";
    require_once 'connect.php';
    require_once 'functions.php';

    function get_last_id($pdo)
    {
        $stmt = $pdo->prepare("SELECT MAX(id) FROM pages");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    function generate_sequential_id($pdo)
    {
        $last_id = get_last_id($pdo);
        if ($last_id === false) {
            return 1;
        } else {
            return $last_id + 1;
        }
    }

    $unique_id = generate_sequential_id($pdo);
    // echo "Unique ID: " . $unique_id;

    function encrypt_id($unique_id, $encryption_key)
    {
        $cipher_method = 'AES-128-CTR';
        $iv_length = openssl_cipher_iv_length($cipher_method);
        $options = 0;
        $encryption_iv = random_bytes($iv_length);

        $encrypted_id = openssl_encrypt((string)$unique_id, $cipher_method, $encryption_key, $options, $encryption_iv);

        $encrypted_id_with_iv = base64_encode($encryption_iv . $encrypted_id);
        return $encrypted_id_with_iv;
    }

    $encryption_key = '172008bavly12345';
    $encrypted_id = encrypt_id($unique_id, $encryption_key);
    // echo "<br>Encrypted ID: " . $encrypted_id;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $encrypted_id;
        $verse_reference = trim($_POST['verse_reference']);
        $verse = trim($_POST['verse']);
        if (!empty($verse_reference) && !empty($verse)) {
            $stmt = $con->prepare("SELECT * FROM pages WHERE verse_reference = ?");
            $stmt->execute([$verse_reference]);
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            if ($count == 0) {
                $stmt = $con->prepare("INSERT INTO pages (id, verse_reference, verse) VALUES (?, ?, ?)");
                $stmt->execute([$id, $verse_reference, $verse]);
                header('location: page.php?id='. $id);
                exit();
            } else {
                echo "الآيه موجود بالفعل";
            }
        } else {
            echo "جميع الحقول مطلوبه";
        }
    }
?>

    <div class="container my-3 no-print">
        <div class="card rounded-3 card-w-90" style="width: 60%; margin: auto;">
            <div class="card-body m-auto" style="width: 95%;">
                <h5 class="card-title text-center">انشاء باب من ابواب اورشليم</h5>
                <form action="" method="POST">
                    <div class="form-group">
                        <div class="d-flex flex-column">
                            <label for="file-picker" class="form-label"> شاهد الآيه :</label>
                            <input type="text" require class="form-control" name="verse_reference" placeholder="اكتب شاهد الآيه هنا">
                        </div>
                        <div class="my-2">
                            <label for="file-picker" class="form-label"> الآيه : </label>
                            <textarea class="form-control " require name="verse" rows="5" style="height: 400px;" placeholder="اكتب الآيه هنا"></textarea>
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
