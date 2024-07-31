<?php
session_start();
if (isset($_SESSION['username'])) {
    if (empty($_GET['gates-jerusalem-Id'])) {
        header('Location: gates-jerusalem.php');
        exit();
    }
    require_once "./includes/layout/header.php";
    require_once "./includes/layout/nav.php";
    require_once 'connect.php';
    require_once 'functions.php';

    $gates_jerusalem_Id = $_GET['gates-jerusalem-Id'];
    $query = "SELECT * FROM gates WHERE id = $gates_jerusalem_Id";
    $stmt = $pdo->query($query);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!isset($row['id'])) {
        header('location: gates-jerusalem.php');
        exit();
    } else {


?>

        <style>
            @media print {
                .no-print {
                    display: none;
                }

                body {
                    -webkit-print-color-adjust: exact;
                }


            }
        </style>
        <div class="patriarch-details-container  p-3 shadow-lg  rounded border" style="width: 75%; margin: 120px auto; min-height: 415px;">
            <div class="dropdown" style="display: flex; flex-direction: row-reverse;">
                <button class="btn btn-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-inset" style="z-index: 0;">
                    <?php
                    if ($_SESSION['group-id'] == 1) {
                    ?>
                        <li><a class="dropdown-item dropdown-item-details-styles" href="details-edit.php?gates-jerusalem-Id-edit=<?php echo $row['id']; ?>">تعديل <i class="fa-solid fa-pen-to-square font-awesom-icon-details-style"></i></a></li>
                        <li><a class="dropdown-item dropdown-item-details-styles" href="details-delete.php?gates-jerusalem-Id-delete=<?php echo $row['id']; ?>">حذف <i class="fa-regular fa-trash-can font-awesom-icon-details-style"></i></a></li>
                    <?php
                    }
                    ?>
                    <li><a class="dropdown-item dropdown-item-details-styles" style="cursor: pointer;" onclick="window.print()">طباعة هذه المعلومات... <i class="fa-solid fa-print font-awesom-icon-details-style"></i></a></li>
                </ul>
            </div>
            <div class="content">
                <h3 class="text-black"><b><?php echo  $row['name']; ?></b></h3>
                <h2 class="card-title"><?php echo $row['text']; ?></h2>
                <a class="mt-3 text-primary d-block text-start" href="gates-jerusalem.php">إلي صفحة السابقة...</a>
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
                    <button id="increase" class="arrow-button m-2"><i class="fa-solid fa-arrow-right"></i></button>
                    <button id="decrease" class="arrow-button m-2"><i class="fa-solid fa-arrow-left"></i></button>
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
                        document.getElementById('increase').style.display = 'none';
                    } else {
                        document.getElementById('increase').style.display = 'inline';
                    }
                    if (currentId <= 1) {
                        currentId = 1;
                        document.getElementById('decrease').style.display = 'none';
                    } else {
                        document.getElementById('decrease').style.display = 'inline';
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
            window.onload = function() {
                const url = new URL(window.location.href);
                const searchParams = new URLSearchParams(url.search);
                const paramKey = 'gates-jerusalem-Id';
                let currentId = parseInt(searchParams.get(paramKey));

                if (currentId >= 12) {
                    document.getElementById('increase').style.display = 'none';
                }

                if (currentId <= 1) {
                    document.getElementById('decrease').style.display = 'none';
                }
            }

            function printPage() {
                window.print();
            }
        </script>

<?php
    }
}




require_once './includes/layout/footer.php';



?>


<!-- <div class="image">
                    <img  style="" alt="patriarch_" />
                </div> -->
<!--