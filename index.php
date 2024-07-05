<?php
session_start();

require_once "./includes/layout/header.php";
require_once "./includes/layout/nav.php";
require_once 'connect.php';
require_once 'functions.php';

?>

<section class="main">
    <div class="index-details-container">
        <h2>موقع ابواب اورشليم</h2>
        <a href="<?php if ( isset($_SESSION['username'])) { ?> gates-jerusalem.php <?php } else {?> login.php <?php }?>" class="main-btn">مشاهدة ابواب اورشليم</a>
        <div class="social-icons">
            <a href="https://www.facebook.com/profile.php?id=61561516863128"><i class="fab fa-facebook"></i></a>
            <a href="https://api.whatsapp.com/send?phone=201063325054 "><i class="fab fa-whatsapp"></i></a>
            <a href="mailto:bavlywagih696@gmail.com"><i class="fa fa-envelope"></i></a>
        </div>
    </div>
    <div class="index-image-container">
        <img src="media/img/index.png" class="img-fluid" alt="gates-jerusalem-image">
    </div>
</section>


<?php require_once './includes/layout/footer.php'; ?>