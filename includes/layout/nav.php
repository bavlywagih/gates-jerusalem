<?php
$currentUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$urlParts = parse_url($currentUrl);
$path = $urlParts['path'];
$baseUrl = $urlParts['scheme'] . '://' . $urlParts['host'] . dirname($path);
$activeHome = $currentPageURL  === $baseUrl  . "index.php";
$activeContent = $currentPageURL === $baseUrl  . "gates-jerusalem.php";
$activeSearchPage = $currentPageURL === $baseUrl  . "search.php";
$activeprofile = $currentPageURL === $baseUrl  . "profile.php";
if (isset($_GET["add"])) {
    $url_addPage = "";
    if ($_GET["add"] == "verse") {
        $url_addPage = "verse";
    }
    if ($_GET["add"] == "page") {
        $url_addPage = "page";
    }
    if ($_GET["add"] == "manyverse") {
        $url_addPage = "manyverse";
    }
    $activeaddPage = $currentPageURL === $baseUrl  . "add-pages.php?add=" . $url_addPage;
}

$activelogin = $currentPageURL === $baseUrl  . "login.php";
$activesignup = $currentPageURL === $baseUrl  . "signup.php";

if (isset($_GET["search"])) {
    $activeSearch = $currentPageURL === $baseUrl  . "search.php?search=" . $_GET['search'];
} else {
    $activeSearch = ' ';
}
?>




<nav class="navbar navbar-expand-lg bg-dark no-print">
    <div class="container-fluid">
        <div class="d-flex">
            <a class="navbar-brand text-white d-flex align-items-center link-gates-jerusalem" href="index.php">
                <img src="media/img/logo.png" class="logo-gates-jerusalem" alt="logo-gates-jerusalem">
                بافلي
            </a>
            <button class="navbar-toggler" type="button" name="toggle-menu" data-bs-toggle="collapse" data-bs-target="#mobileNav">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="mobileNav">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white cairo-semibold <?= $activeHome ? 'nav-active-link' : '' ?>" href="index.php">الصفحة الرئيسية</a>
                </li>
                <?php if (isset($_SESSION['username'])) { ?>
                    <li class="nav-item">
                        <a class="nav-link text-white <?= $activeContent ? 'nav-active-link' : '' ?>" href="gates-jerusalem.php">ابواب اورشليم</a>
                    </li>
                <?php } ?>
                <?php
                if (isset($_SESSION['group-id'])) {
                    if ($_SESSION['group-id'] >= 1) {
                ?>
                        <li class="nav-item">
                            <a class="nav-link text-white <?= $activeaddPage ? 'nav-active-link' : '' ?>" href="add-pages.php">انشاء صفحات</a>
                        </li>
                <?php
                    }
                }
                ?>
            </ul>
            <?php
            if (isset($_SESSION['username'])) {
            ?>
                <form class="d-flex me-auto ms-0 search-form" method="GET" action="search.php">
                    <label for="search-input" class="visually-hidden"></label>
                    <input id="search-input" class="form-control me-2" value="<?= $_GET["search"] ?? '' ?>" type="search" placeholder="البحث..." name="search">
                    <button class="search-btn" type="submit">بحث</button>
                </form>
            <?php
            }
            if (isset($_SESSION['username'])) { ?>
                <div class="d-flex me-auto ms-0 button-nav-name" style="font-weight: 300; flex-basis: 13%;  flex-direction: row-reverse;">
                    <div class="dropdown">
                        <button class="  btn btn-secondary dropdown-toggle bg-transparent border border-0 border-bottom d-flex  align-items-center" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div id="navbarUsername" class="navbar-text text-white"> <?php echo htmlspecialchars($nameuser); ?></div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-mobile" style="right: -120px;">
                            <li><a class="dropdown-item" href="profile.php">الصفحة الشخصيه</a></li>
                            <?php
                            if ($_SESSION['group-id'] == 2) { ?>
                                <li><a class="dropdown-item" href="users.php">لوحه التحكم</a></li>
                            <?php } ?>
                            <li><a class="dropdown-item" href="logout.php">تسجيل خروج</a></li>
                        </ul>
                    </div>
                </div>
            <?php } else { ?>
                <div class="d-flex me-auto ms-0 button-nav-name" style="font-weight: 300; flex-basis: 13%;  flex-direction: row-reverse;">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-white cairo <?= $activelogin ? 'nav-active-link' : '' ?>" href="login.php" style="font-family: 'Cairo', sans-serif;">تسجيل دخول</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white cairo <?= $activesignup ? 'nav-active-link' : '' ?>" href="signup.php" style="font-family: 'Cairo', sans-serif;">أنشاء حساب</a>
                        </li>
                    </ul>
                </div>
            <?php } ?>

        </div>
    </div>
</nav>
<?php


if (isset($_SESSION['username'])) {
    $requestUri = $_SERVER['REQUEST_URI'];

    $filename = basename($requestUri);
    if ($filename == "profile.php") {
?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('profileForm');

                if (form) {
                    const sendFormData = () => {
                        const formData = new FormData(form);

                        fetch(form.action, {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log('Response Data:', data);
                                if (data.status === 'success') {
                                    const nameArray = data.fullname.split(" ");
                                    const nameuser = nameArray[0];
                                    document.getElementById('navbarUsername').textContent = nameuser;
                                    // alert('تم تحديث البيانات بنجاح');
                                } else {
                                    alert('حدث خطأ أثناء تحديث البيانات: ' + data.message);
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('حدث خطأ أثناء تحديث البيانات');
                            });
                    };

                    form.querySelectorAll('input').forEach(input => {
                        input.addEventListener('change', sendFormData);
                    });
                } else {
                    console.error('Form with ID profileForm not found');
                }
            });
        </script>
<?php }
} ?>

<div class="scroller no-print"></div>