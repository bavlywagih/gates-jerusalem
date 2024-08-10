<?php




function get_last_id($pdo) {
    $stmt = $pdo->prepare("SELECT MAX(id) FROM pages");
    $stmt->execute();
    return $stmt->fetchColumn();
}

function generate_sequential_id($pdo) {
    $last_id = get_last_id($pdo);
    return $last_id ? $last_id + 1 : 1;
}

function encrypt_id($unique_id, $encryption_key) {
    $cipher_method = 'AES-128-CTR';
    $iv_length = openssl_cipher_iv_length($cipher_method);
    $options = 0;
    $encryption_iv = random_bytes($iv_length);
    $encrypted_id = openssl_encrypt((string)$unique_id, $cipher_method, $encryption_key, $options, $encryption_iv);
    return base64_encode($encryption_iv . $encrypted_id);
}
?>
