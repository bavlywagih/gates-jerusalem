<?php
session_start();
if (isset($_SESSION['username'])) {

    require_once "./includes/layout/header.php";


    if (isset($_GET["search"]) && trim($_GET["search"]) != null) {
        $searchTerm = trim($_GET['search']);
        $searchTermLike = '%' . $searchTerm . '%';

        $stmt = $pdo->prepare("
            SELECT 
                'gates' AS source_table,
                id, 
                name AS title, 
                text AS full_text
            FROM 
                gates 
            WHERE 
                name LIKE :searchTermLike 
                OR id LIKE :searchTermLike 
                OR text LIKE :searchTermLike
            UNION
            SELECT 
                'pages' AS source_table,
                id, 
                page_title AS title, 
                verse AS full_text
            FROM 
                pages 
            WHERE 
                page_title LIKE :searchTermLike 
                OR id LIKE :searchTermLike 
                OR verse LIKE :searchTermLike
        ");

        $stmt->execute(['searchTermLike' => $searchTermLike]);
        $count = $stmt->rowCount();



?>
        <!DOCTYPE html>
        <html lang="ar">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>نتائج البحث</title>
            <style>

            </style>
        </head>

        <body>
            <?php
                if ($count) { 
                    $counter = 1; 
                    ?>
                    <p class="result-count">وٌجِد <?php echo $count ?> نتيجة بحث</p>
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
                        $titleHighlighted = preg_replace("/(" . preg_quote($searchTerm, '/') . ")/i", "<span class='highlight'>$1</span>", $title);
                    ?>

                        <div class="patriarch-details-container search">
                            <div class="content">
                                <a href="<?php echo $row['source_table'] == 'gates' ? 'details.php?gates-jerusalem-Id=' . $row['id'] : 'page.php?id=' . $row['id'] ?>">
                                    <h3 class="text-black">
                                        <b class="idchange"> 
                                            <?php echo $counter . '</b>-' . $titleHighlighted; ?>
                                        </h3>
                                </a>
                                <h2 class="card-title opacity-75">
                                    <span class="filtered-text" data-full-text="<?php echo htmlspecialchars($row['full_text'], ENT_QUOTES, 'UTF-8'); ?>"></span>
                                </h2>
                                <span class="read-more hidden">عرض المزيد</span>
                            </div>
                            <small>المصدر: <?php echo $row['source_table'] == 'gates' ? 'البوابات' : 'الصفحات'; ?></small>
                        </div>
                        <hr>
            <?php 
                    $counter++;
                    }
                    }
                    else { ?>
                            <div class="data-not-found">
                                <p>عفواً لا يوجد بيانات</p>
                                <img src="media/img/404.jpg" alt="no_data_found">
                            </div>
                        <?php } ?>
                        

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const elements = document.querySelectorAll('.filtered-text');
                                const readMoreButtons = document.querySelectorAll('.read-more');

                                elements.forEach((element, index) => {
                                    let fullText = element.getAttribute('data-full-text');
                                    let tempDiv = document.createElement('div');
                                    tempDiv.innerHTML = fullText;
                                    tempDiv.querySelectorAll('a, script').forEach(node => node.remove());
                                    let cleanText = tempDiv.textContent || tempDiv.innerText || '';

                                    let previewText = cleanText.substring(0, 150);
                                    let remainingText = cleanText.substring(150);

                                    if (cleanText.length > 150) {
                                        element.innerHTML = previewText + `<span class="more-text hidden">${remainingText}</span>`;
                                        readMoreButtons[index].classList.remove('hidden');
                                    } else {
                                        element.innerHTML = cleanText;
                                        readMoreButtons[index].remove();
                                    }

                                    const searchTerm = <?php echo json_encode($searchTerm); ?>;
                                    const regex = new RegExp(searchTerm, 'gi');
                                    element.innerHTML = element.innerHTML.replace(regex, match => `<span class="highlight">${match}</span>`);

                                    readMoreButtons[index]?.addEventListener('click', function() {
                                        const hiddenText = element.querySelector('.more-text');
                                        if (hiddenText) {
                                            hiddenText.classList.toggle('hidden');
                                            this.textContent = hiddenText.classList.contains('hidden') ? 'عرض المزيد' : 'عرض أقل';
                                        }
                                    });
                                });
                            });


                        </script>
        </body>

        </html>
    <?php

    } else if (isset($_GET["search"])) { ?>
        <div class="data-not-found">
            <img src="media/img/no-data.jpg" alt="no_data_found">
        </div>
    <?php } else { ?>
        <img src="media/img/search.jpg" alt="search_image" class="d-block w-50 ms-auto me-auto" />
<?php }

    require_once './includes/layout/footer.php';
} else {
    header('location: login.php');
    exit();
}
?>