<style>
    .nav-active-link{
        color: var(--main-color) !important;
    }
    .font-footer{
        font-family: 'Cairo', sans-serif;
    }
</style>
<span class="up"><i class="fa-solid fa-chevron-up"></i></span>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3 links">
                    <ul>
                        <li><a href="index.php" class="font-footer <?php echo $activeHome ? 'nav-active-link' : '' ?>">الصفحة الرئيسية</a></li>
                        <li><a href="gates-jerusalem.php" class="font-footer <?php echo $activeContent ? 'nav-active-link' : '' ?>">ابواب اورشليم</a></li>
                        <li><a href="search.php" class="font-footer <?php echo $activeSearchPage ? 'nav-active-link' : '' ?>">ابحث عن الاباء البطاركة</a></li>
                        <?php if (!isset($_SESSION['username'])) {?>
                            <li><a class="nav-link text-white <?php echo $activelogin ? 'nav-active-link' : '' ?> font-footer" href="login.php">تسجيل الدخول</a></li>
                            <li><a href="#" class="font-footer">انشاء حساب</a></li>
                        <?php }else{?>
                            <li><a href="logout.php" class="font-footer">تسجيل خروج</a></li>
                        <?php }?>
                    
                    </ul>
                </div>
                <div class="col social-links">
                    <a href="https://www.facebook.com/profile.php?id=61561516863128"><i class="fab fa-facebook"></i></a>
                    <a href="https://api.whatsapp.com/send?phone=201063325054 "><i class="fab fa-whatsapp"></i></a>
                    <a href="mailto:bavlywagih696@gmail.com"><i class="fa fa-envelope"></i></a>
                </div>
            </div>
            <p class="copyright">All Rights reserved <a href="https://www.facebook.com/profile.php?id=61561516863128">Bavly</a> © 2024</p>
        </div>
    </footer>
<?php

?>



<script type="text/javascript" src="http://localhost/gates-jerusalem/includes/js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="http://localhost/gates-jerusalem/includes/js/jquery.js"></script>
<script type="text/javascript" src="http://localhost/gates-jerusalem/includes/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>
<script type="text/javascript" src="http://localhost/gates-jerusalem/includes/js/main.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea#post-editor',
            height: 500,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    </script>
</body>

</html>