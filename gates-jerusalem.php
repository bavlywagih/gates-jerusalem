<?php
session_start();
if (isset($_SESSION['username'])) {

    require_once "./includes/layout/header.php";
    require_once "./includes/layout/nav.php";
    require_once 'connect.php';
    require_once 'functions.php';



    $query = "SELECT * FROM gates ORDER BY id desc";

    $stmt = $pdo->query($query);
    $row_count = $stmt->rowCount();



    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST['name'] == "" & $_POST['text'] == "") {
            echo '<div class="toast-container position-fixed bottom-0 end-0 p-3">
                        <div id="liveToast" class="toast d-block" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <strong class="me-auto">Bootstrap</strong>
                                <small>الان</small>
                            </div>
                            <div class="toast-body">
                                يرجي املاء جميع الخانات .
                            </div>
                        </div>
                    </div>';
        } else {
            $text = $_POST['text'];
            $name = $_POST['name'];
            $id_select = $_POST['id_select'];

            $sql = "INSERT INTO gates (name, text , id) VALUES (:name, :text , :id)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id_select, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':text', $text, PDO::PARAM_STR);

            if ($stmt->execute()) {
                echo
                '<div class="toast-container position-fixed bottom-0 end-0 p-3">
                        <div id="liveToast" class="toast d-block" role="alert" aria-live="assertive" aria-atomic="true">
                            <div class="toast-header">
                                <strong class="me-auto">Bootstrap</strong>
                                <small>الان</small>
                            </div>
                            <div class="toast-body">
                            تمت انشاء الباب بنجاح.
                            </div>
                        </div>
                    </div>';
            }
        }
    }


?>

    <?php
    if ($row_count != 12) {
        if ($_SESSION['group-id'] == 1) {
    ?>

            <div class="container my-3">
                <div class="card rounded-3 card-w-90" style="width: 60%; margin: auto;">
                    <div class="card-body m-auto">
                        <h5 class="card-title text-center">انشاء باب من ابواب اورشليم</h5>
                        <form action="" method="POST">
                            <div class="form-group">
                                <div class="d-flex flex-column">
                                    <label for="file-picker" class="form-label">اسم الباب : </label>
                                    <input type="text" require class="form-control" name="name" placeholder="اكتب اسم الباب هنا">
                                </div>
                                <div class="my-2">
                                    <label for="file-picker" class="form-label"> شرح : </label>
                                    <textarea class="form-control " require name="text" id="post-editor" rows="5"></textarea>
                                </div>
                                <div class="my-2">
                                    <label for="file-picker" class="form-label"> اختيار ال ID : </label>
                                    <select class="form-select" name="id_select" aria-label="Default select example">
                                        <option selected>Open this select menu</option>

                                        <?php
                                        $id_sql = "SELECT id FROM gates";
                                        $stmt_id = $pdo->query($id_sql);
                                        $existing_ids = $stmt_id->fetchAll(PDO::FETCH_COLUMN);
                                        for ($i = 1; $i <= 12; $i++) {
                                            if (!in_array($i, $existing_ids)) {
                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                            }
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success" style="width: 100%;">ارسال</button>
                        </form>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>
    <?php
    if ($row_count != 0) {
    ?>
        <style>
            body {
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background-color: #f0f0f0;
            }

            .map-container {
                position: relative;
                width: 480px;
                height: 640px;
                background-image: url('media/img/map.png');
                background-size: cover;
                background-position: center;
            }

            .gate {
                position: absolute;
                color: #000;
                font-weight: bold;
                cursor: pointer;
                text-shadow: 1px 1px 2px #fff;
                /* Adding a shadow to make text stand out on the image */
            }

            .gate:hover {
                text-decoration: underline;
            }

            .map-container .gate:nth-child(1) {
                top: 6%;
                left: 38%;
            }

            .map-container .gate:nth-child(2) {
                top: 6.5%;
                left: 69%;
            }

            .map-container .gate:nth-child(3) {
                top: 14.5%;
                left: 75%;
            }

            .map-container .gate:nth-child(4) {
                top: 24%;
                left: 74%;
            }

            .map-container .gate:nth-child(5) {
                top: 29.5%;
                left: 74%;
            }

            .map-container .gate:nth-child(6) {
                top: 83.5%;
                left: 62%;
            }

            .map-container .gate:nth-child(7) {
                top: 60%;
                left: 68%;
            }

            .map-container .gate:nth-child(8) {
                top: 23.5%;
                left: 1%;
            }

            .map-container .gate:nth-child(9) {
                top: 56%;
                left: 30%;
            }

            .map-container .gate:nth-child(10) {
                top: 13%;
                left: 11%;
            }

            .map-container .gate:nth-child(11) {
                top: 29%;
                left: 3%;
            }

            .map-container .gate:nth-child(12) {
                top: 86.5%;
                left: 30%;
            }

            .gate-pdf {
                color: #000;
                font-weight: bold;
                cursor: pointer;
                text-shadow: 1px 1px 2px #fff;
                left: 3%;
                position: absolute;
                top: 1%;
            }

            .gate-word {
                color: #000;
                font-weight: bold;
                cursor: pointer;
                text-shadow: 1px 1px 2px #fff;
                left: 20%;
                position: absolute;
                top: 1%;
            }

            @media print {
                .no-print {
                    display: none;
                }

                body {
                    -webkit-print-color-adjust: exact;
                }


            }
        </style>
        <div class="map-container m-auto my-2">
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <div class="gate "><a href="details.php?gates-jerusalem-Id=<?php echo $row['id']; ?>" class=""><?php echo $row['name']; ?></a></div>
            <?php
            }
            ?>
            <div class="gate-pdf "><a class="no-print" onclick="printPage()">حفظ pdf</a></div>
        </div>
    <?php } ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastEl = document.getElementById('liveToast');
            var toast = new bootstrap.Toast(toastEl);
            toast.show();

            setTimeout(function() {
                window.location.href = "gates-jerusalem.php";
                toast.hide();
            }, 2000);
        });

        function printPage() {
            window.print();
        }
    </script>
<?php } else {
    header('location: login.php');
    exit();
} ?>
<?php require_once './includes/layout/footer.php'; ?>