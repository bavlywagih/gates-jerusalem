<?php
session_start();

if (isset($_SESSION['username'])) {

    require_once "./includes/layout/header.php";
    require_once "./includes/layout/nav.php";
    require_once 'connect.php';
    require_once 'functions.php';


    $stmt = $con->prepare("SELECT * FROM pages WHERE id = ? ");
    $stmt->execute(array($_GET['id']));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($count > 0) {
        $page_title = $row['page_title'];
        $verse_reference = $row['verse_reference'];
        $verse = $row['verse'];
        $id_select = $row['id_select'];
    }

?>
    <div class="patriarch-details-container  p-3 shadow-lg  rounded border" style="width: 75%; margin: 60px auto; min-height: 415px;">
        <p class="text-center">عرض نص الشاهد التالي من الكتاب المقدس:</p>


        <h2 class="text-center text-light-emphasis"><?php echo $page_title ?></h2>
        <?php
        if ($id_select == 0) {
        ?>
            <button onclick="toggleTashkeel()" class="btn btn-success" >تبديل التشكيل</button>
            <a href="create-photo.php?id=<?php echo $_GET['id']?>" class="btn btn-success" >تبديل </a>
        <?php
        }
        ?>
        <div class="content">
            <div id="textContainer">
                <h3 id="textOutput" style="text-align: center;font-family: 'Cairo', sans-serif;">
                    <?php echo $verse . $verse_reference; ?>
                </h3>
                <div></div>
            </div>
        </div>
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
