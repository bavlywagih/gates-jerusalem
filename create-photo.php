<?php
session_start();
ob_start();

if (isset($_SESSION['username'])) {
    require_once 'connect.php';
    require_once 'functions.php';
    $stmt = $con->prepare("SELECT * FROM pages WHERE id = ?");
    $stmt->execute(array($_GET['id']));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($count > 0) {
        $page_title = $row['page_title'];
        $verse_reference = $row['verse_reference'];
        $verse = $row['verse'];
        $id_select = $row['id_select'];
    }else{
        header('location: gates-jerusalem.php');
        exit();
    }
    ob_end_flush();

    if ($id_select == 0) {
?>

<div>
            <link rel="stylesheet" href="includes/css/pages/create-photo.css">


            <div class="div-create-photo" >
                <canvas id="canvas" width="1199" height="630" ></canvas>
                <button onclick="downloadImage()">تحميل الصوره</button>
                <a href="page.php?id=<?php echo $row['id'];?>">رجوع</a>
            </div>



            <script>
                function removeTashkeel(text) {
                    return text.replace(/[\u0600-\u06FF\u0750-\u077F]/g, function(char) {
                        return char.replace(/[\u064B-\u0652\u0670]/g, '');
                    });
                }

                function drawTextOnImage() {
                    const canvas = document.getElementById('canvas');
                    const context = canvas.getContext('2d');

                    const backgroundImage = new Image();
                    backgroundImage.src = "media/img/1rm120batch2-techi-14-framebg.jpg";
                    backgroundImage.onload = () => {

                        canvas.width = backgroundImage.width;
                        canvas.height = backgroundImage.height;

                        context.drawImage(backgroundImage, 0, 0);

                        const rawText = "<?php echo addslashes($verse) . " " . addslashes($verse_reference); ?>";
                        const text = removeTashkeel(rawText);

                        context.fillStyle = 'black';
                        context.textAlign = 'center';

                        fitTextOnCanvas(context, text, canvas.width - 100, canvas.height);
                    };
                }

                function fitTextOnCanvas(context, text, maxWidth, maxHeight) {
                    let fontSize = 50;
                    let lines = [];

                    do {
                        context.font = `${fontSize}px cairo-verse`;
                        lines = wrapText(context, text, maxWidth);
                        fontSize -= 2;
                    } while ((lines.length * (fontSize + 10) > maxHeight) && fontSize > 20);

                    const lineHeight = fontSize + 25;
                    const startY = (maxHeight - (lines.length * lineHeight)) / 2 + lineHeight;

                    lines.forEach((line, i) => {
                        context.fillText(line, maxWidth / 2 + 50, startY + i * lineHeight);
                    });
                }

                function wrapText(context, text, maxWidth) {
                    const words = text.split(' ');
                    let line = '';
                    const lines = [];

                    words.forEach(word => {
                        const testLine = line + word + ' ';
                        const metrics = context.measureText(testLine);
                        const testWidth = metrics.width;
                        if (testWidth > maxWidth && line.length > 0) {
                            lines.push(line);
                            line = word + ' ';
                        } else {
                            line = testLine;
                        }
                    });

                    lines.push(line);
                    return lines;
                }

                function downloadImage() {
                    const canvas = document.getElementById('canvas');
                    const link = document.createElement('a');
                    link.href = canvas.toDataURL('image/jpeg');
                    link.download = 'output.jpg';
                    link.click();
                }

                window.onload = drawTextOnImage;

                document.addEventListener('DOMContentLoaded', function() {
                    document.title = "<?php echo htmlspecialchars($page_title); ?>";
                });

                if (!sessionStorage.getItem('reloaded')) {
                    sessionStorage.setItem('reloaded', 'true');
                    location.reload();
                }
            </script>
        </div>

<?php
    } else {
        header('location: page.php?id=' . $_GET['id']);
        exit();
    }
} else {
    header('location: login.php');
    exit();
}
?>