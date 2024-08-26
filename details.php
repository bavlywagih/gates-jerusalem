<?php
ob_start();
session_start();
if (isset($_SESSION['username'])) {
    if (empty($_GET['gates-jerusalem-Id'])) {
        header('Location: gates-jerusalem.php');
        exit();
    }
    require_once "./includes/layout/header.php";


    $gates_jerusalem_Id = $_GET['gates-jerusalem-Id'];
    $query = "SELECT * FROM gates WHERE id = $gates_jerusalem_Id";
    $stmt = $pdo->query($query);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!isset($row['id'])) {
        header('location: gates-jerusalem.php');
        exit();
    } else {

    ob_end_flush();

?>


        <div class="patriarch-details-container  p-3  rounded border">
            <div class="dropdown dropdown-div ">
                <button class="btn btn-secondary no-print" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-inset z-0">

                    <?php
                    if ($_SESSION['group-id'] >= 1) {
                    ?>
                        <li><a class="dropdown-item dropdown-item-details-styles" href="details-edit.php?gates-jerusalem-Id-edit=<?php echo $row['id']; ?>">تعديل <i class="fa-solid fa-pen-to-square font-awesom-icon-details-style"></i></a></li>
                        <li><a class="dropdown-item dropdown-item-details-styles" href="details-delete.php?gates-jerusalem-Id-delete=<?php echo $row['id']; ?>">حذف <i class="fa-regular fa-trash-can font-awesom-icon-details-style"></i></a></li>
                    <?php
                    }
                    ?>
                    <li><a class="dropdown-item dropdown-item-details-styles no-print eyeIcon-cursor" onclick="window.print()">طباعة هذه المعلومات... <i class="fa-solid fa-print font-awesom-icon-details-style"></i></a></li>
                </ul>
            </div>
            <div class="content">
                <h3 class="text-black text-center"><b><?= $row['name']; ?></b></h3>
                <div class="card-title el-messiri f-w-b"><?= $row['text']; ?></div>
                <a class="mt-3 text-primary d-block text-start no-print" href="gates-jerusalem.php">إلي صفحة السابقة...</a>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>

                <div class="button-container">
                    <?php
                    if ($_GET['gates-jerusalem-Id'] != 12) { ?>
                        <button id="increase" class="arrow-button m-2 no-print"><i class="fa-solid fa-arrow-right"></i></button>
                    <?php } ?>
                    <?php
                    if ($_GET['gates-jerusalem-Id'] != 1) { ?>
                        <button id="decrease" class="arrow-button m-2 no-print"><i class="fa-solid fa-arrow-left"></i></button>
                    <?php } ?>
                </div>
            </div>
        </div>



        <script>
            function updateURL(increment) {
                const url = new URL(window.location.href);
                const searchParams = new URLSearchParams(url.search);
                const paramKey = 'gates-jerusalem-Id';
                let currentId = parseInt(searchParams.get(paramKey));

                if (!isNaN(currentId)) {
                    currentId += increment;
                    if (currentId >= 12) {
                        currentId = 12;
                    }
                    if (currentId <= 1) {
                        currentId = 1;
                    }

                    searchParams.set(paramKey, currentId);
                    url.search = searchParams.toString();
                    window.location.href = url.toString();
                } else {
                    console.error('Parameter gates-jerusalem-Id is not a valid number.');
                }
            }

            document.getElementById('increase').addEventListener('click', function() {
                updateURL(1);
            });

            document.getElementById('decrease').addEventListener('click', function() {
                updateURL(-1);
            });


            function printPage() {
                window.print();
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.title = "<?= $row['name']; ?>";
            });
        </script>
<?php
    }
} else {
    header('location: login.php');
    exit();
}
require_once './includes/layout/footer.php';
?>