<?php
session_start();
if (isset($_SESSION['username'])) {

    require_once "./includes/layout/header.php";
    require_once 'connect.php';
    



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
        if ($_SESSION['group-id'] >= 1) {
    ?>

            <div class="container my-3 no-print">
                <div class="card rounded-3 card-w-90 w-m" style="width: 60%; margin: auto;">
                    <div class="card-body m-auto">
                        <h5 class="card-title text-center cairo f-w-b">انشاء باب من ابواب اورشليم</h5>
                        <form action="" method="POST">
                            <div class="form-group">
                                <div class="d-flex flex-column">
                                    <label for="file-picker" class="form-label cairo-semibold ">اسم الباب : </label>
                                    <input type="text" required class="form-control" name="name" placeholder="اكتب اسم الباب هنا">
                                </div>
                                <div class="my-2">
                                    <label for="file-picker" class="form-label cairo-semibold "> شرح : </label>
                                    <textarea class="form-control " name="text" id="post-editor" rows="5"></textarea>
                                </div>
                                <div class="my-2">
                                    <label for="file-picker" class="form-label cairo-semibold "> اختيار ال ID : </label>
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
                            <button type="submit" class="btn btn-success w-100">ارسال</button>
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

        <div class="map-container m-auto my-2">
            <?php
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <div class="gate "><a href="details.php?gates-jerusalem-Id=<?php echo $row['id']; ?>" class="cairo-semibold f-w-b"><?php echo $row['name']; ?></a></div>
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