<?php
session_start();
if (isset($_SESSION['username'])) {
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
        <div class="patriarch-details-container  p-3 shadow-lg  rounded border" style="width: 75%; margin: 120px auto; min-height: 415px;">
            <div class="content">
                <h3 class="text-black"><b><?php echo  $row['name']; ?></b></h3>
                <h2 class="card-title opacity-75"><?php echo $row['text']; ?></h2>
                <a class="mt-3 text-primary d-block text-start" style="cursor: pointer;" onclick="window.print()">طباعة هذه المعلومات...</a>
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
            document.addEventListener('copy', function(event) {
                let selectedText = window.getSelection().toString();
                selectedText += '\nاقرأ المزيد عن هذا البطرك من ذلك الرابط: <?php echo $currentPageURL; ?> ';

                // منع الحدث الافتراضي لتغيير النص المنسوخ
                event.preventDefault();

                // وضع النص المعدل في الحافظة
                if (event.clipboardData) {
                    event.clipboardData.setData('text/plain', selectedText);
                } else if (window.clipboardData) {
                    window.clipboardData.setData('Text', selectedText);
                }

                console.log('Async: Copying to clipboard was successful!');
            });

            window.onload = () => {
                console.log('Loaded');
            };
        </script>

        <script>
            function updateURL(increment) {
                const url = new URL(window.location.href);
                const searchParams = new URLSearchParams(url.search);
                const paramKey = 'gates-jerusalem-Id';
                let currentId = parseInt(searchParams.get(paramKey));

                if (!isNaN(currentId)) {
                    currentId += increment;

                    // تحقق من الحدود العليا والدنيا للقيمة
                    if (currentId >= 12) {
                        currentId = 12;
                        document.getElementById('increase').style.display = 'none'; // إخفاء زر الزيادة
                    } else {
                        document.getElementById('increase').style.display = 'inline'; // إظهار زر الزيادة إذا كان أقل من 12
                    }

                    if (currentId <= 1) {
                        currentId = 1;
                        document.getElementById('decrease').style.display = 'none'; // إخفاء زر النقصان
                    } else {
                        document.getElementById('decrease').style.display = 'inline'; // إظهار زر النقصان إذا كان أكبر من 1
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

            // فحص إذا كان يجب إخفاء الأزرار عند تحميل الصفحة
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