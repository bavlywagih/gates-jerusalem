<?php

$activeHome = $currentPageURL === "http://localhost/gates-jerusalem" || $currentPageURL === "http://localhost/gates-jerusalem/index.php";
$activeContent = $currentPageURL === "http://localhost/gates-jerusalem/gates-jerusalem.php";
$activeSearchPage = $currentPageURL === "http://localhost/gates-jerusalem/search.php";
$activeaddPage = $currentPageURL === "http://localhost/gates-jerusalem/add-pages.php";
$activelogin = $currentPageURL === "http://localhost/gates-jerusalem/login.php";
$activesignup = $currentPageURL === "http://localhost/gates-jerusalem/signup.php";

if (isset($_GET["search"])) {
    $activeSearch = $currentPageURL === "http://localhost/gates-jerusalem/search.php?search=" . $_GET['search'];
} else {
    $activeSearch = ' ';
}

if (isset($_SESSION['username'])) {
    $name = $_SESSION['fullname'];
    $nameArray = explode(" ", $name);
    $nameuser = $nameArray[0];
}

?>




<nav class="navbar navbar-expand-lg bg-dark no-print">
    <div class="container-fluid">
        <a class="navbar-brand text-white d-flex align-items-center link-gates-jerusalem" href="index.php">
            <img src="http://localhost/gates-jerusalem/media/img/logo.png" class="logo-gates-jerusalem" alt="logo-gates-jerusalem">
            بافلي
        </a>
        <button class="navbar-toggler" type="button" name="toggle-menu" data-bs-toggle="collapse" data-bs-target="#mobileNav">
            <i class="fa-solid fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="mobileNav">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white <?php echo $activeHome ? 'nav-active-link' : '' ?>" href="index.php">الصفحة الرئيسية</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?php echo $activeContent ? 'nav-active-link' : '' ?>" href="gates-jerusalem.php">ابواب اورشليم</a>
                </li>
                <?php
                    if ($_SESSION['group-id'] == 1) {
                ?>
                <li class="nav-item">
                    <a class="nav-link text-white <?php echo $activeaddPage ? 'nav-active-link' : '' ?>" href="add-pages.php">انشاء صفحات</a>
                </li>
                <?php 
                    }
                ?>
            </ul>
            <form class="d-flex me-auto ms-0 search-form" method="GET" action="search.php">
                <label for="search-input" class="visually-hidden"></label>
                <input id="search-input" class="form-control me-2" value="<?php echo $_GET["search"] ?? '' ?>" type="search" placeholder="بحث عن آباء بطاركة..." name="search">
                <button class="search-btn" type="submit">بحث</button>
            </form>
            <?php
            if (isset($_SESSION['username'])) { ?>
                <div class="d-flex me-auto ms-0 button-nav-name" style="font-weight: 300; flex-basis: 13%;  flex-direction: row-reverse;">
                    <div class="dropdown">
                        <button class="  btn btn-secondary dropdown-toggle bg-transparent border border-0 border-bottom" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo $nameuser; ?>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-mobile" style="right: -120px;">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="logout.php">تسجيل خروج</a></li>
                        </ul>
                    </div>
                </div>
            <?php } else { ?>
                <div class="d-flex me-auto ms-0 button-nav-name" style="font-weight: 300; flex-basis: 13%;  flex-direction: row-reverse;">
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-white <?php echo $activelogin ? 'nav-active-link' : '' ?>" href="login.php" style="font-family: 'Cairo', sans-serif;">تسجيل دخول</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white <?php echo $activesignup ? 'nav-active-link' : '' ?>" href="signup.php" style="font-family: 'Cairo', sans-serif;">أنشاء حساب</a>
                        </li>
                    </ul>
                </div>
            <?php } ?>

        </div>
    </div>
</nav>