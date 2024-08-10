<?php
$id = $encrypted_id;
$page_title = trim($_POST['page_title']);
$id_select = trim($_POST['id_select']);
$verse_reference = $id_select == 0 ? trim($_POST['verse_reference']) : " ";
$verse = $id_select == 0 ? trim($_POST['verse']) : trim($_POST['text']);

if (!empty($verse_reference) && !empty($verse)) {
    $stmt = $con->prepare("SELECT * FROM pages WHERE verse_reference = ?");
    $stmt->execute([$verse_reference]);

    if ($stmt->rowCount() == 0) {
        $stmt = $con->prepare("INSERT INTO pages (id, page_title, verse_reference, verse, id_select) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id, $page_title, $verse_reference, $verse, $id_select]);

        header('Location: page.php?id=' . $id);
        exit();
    } else {
        echo "هذه الآية موجودة بالفعل.";
    }
} else {
    echo "جميع الحقول مطلوبة.";
}
