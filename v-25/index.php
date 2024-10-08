<?php
session_start();

require_once "./includes/layout/header.php";



?>

<section class="main">
    <div class="index-details-container">
        <h2 class="cairo-semibold">موقع ابواب اورشليم</h2>
        <a href="<?php if (isset($_SESSION['username'])) { ?> gates-jerusalem.php <?php } else { ?> login.php <?php } ?>" class="main-btn cairo" style="background-color: #333; color: #fff;"> <?php if (isset($_SESSION['username'])) { ?> مشاهدة ابواب اورشليم <?php } else { ?>تسجيل الدخول<?php } ?></a>
        <div class="social-icons">
            <a href="https://www.facebook.com/profile.php?id=61561516863128"><i class="fab fa-facebook"></i></a>
            <a href="https://api.whatsapp.com/send?phone=201063325054 "><i class="fab fa-whatsapp"></i></a>
            <a href="mailto:bavlywagih696@gmail.com"><i class="fa fa-envelope"></i></a>
        </div>
    </div>

</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.title = "الصفحه الرئيسيه";
    });
</script>
<?php require_once './includes/layout/footer.php'; ?>