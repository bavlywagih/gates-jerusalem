<?php
session_start();
if (isset($_SESSION['username'])) {
    if (empty($_GET['gates-jerusalem-Id-edit'])) {
        header('Location: gates-jerusalem.php');
        exit();
    }
    require_once "./includes/layout/header.php";
    require_once "./includes/layout/nav.php";
    require_once 'connect.php';
    require_once 'functions.php';

    $gates_jerusalem_Id = $_GET['gates-jerusalem-Id-edit'];
    $query = "SELECT * FROM gates WHERE id = $gates_jerusalem_Id";
    $stmt = $pdo->query($query);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!isset($row['id'])) {
        header('location: gates-jerusalem.php');
        exit();
    } else {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $text = $_POST['text'];
            $sql = "UPDATE gates SET text = :text, name = :name WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':text', $text, PDO::PARAM_STR);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':id', $gates_jerusalem_Id, PDO::PARAM_INT);
            $stmt->execute();
            header('location: details.php?gates-jerusalem-Id=' . $_GET['gates-jerusalem-Id-edit']);
            exit();
        }

?>

        <div class="patriarch-details-container  p-3 shadow-lg  rounded border" style="width: 75%; margin: 120px auto; min-height: 415px;">
            <div class="content">
                <h3 class="text-black text-center">تعديل <b><?php echo  $row['name']; ?> </b></h3>

                <form action="" method="POST">
                    <div class="form-group">
                        <div class="d-flex flex-column">
                            <label for="file-picker" class="form-label">اسم الباب : </label>
                            <input type="text" require class="form-control" name="name" placeholder="اكتب اسم الباب هنا" value="<?php echo  $row['name']; ?>">
                        </div>
                        <div class="my-2">
                            <label for="file-picker" class="form-label"> شرح : </label>
                            <textarea class="form-control " require name="text" id="post-editor" rows="5"><?php echo $row['text']; ?></textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" style="width: 100%;">ارسال</button>
                </form>
            </div>
        </div>


        <script>
            function updateURL(increment) {
                const url = new URL(window.location.href);
                const searchParams = new URLSearchParams(url.search);
                const paramKey = 'gates-jerusalem-Id-edit';
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
                const paramKey = 'gates-jerusalem-Id-edit';
                let currentId = parseInt(searchParams.get(paramKey));

                if (currentId >= 12) {
                    document.getElementById('increase').style.display = 'none';
                }

                if (currentId <= 1) {
                    document.getElementById('decrease').style.display = 'none';
                }
            }
        </script>
<?php
    }
}


require_once './includes/layout/footer.php';
?>