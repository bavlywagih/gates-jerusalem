<?php
ob_start();
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
if ($_SESSION['group-id'] != 2) {
    header('Location: index.php');
    exit();
}
require_once "./includes/layout/header.php";
ob_end_flush();
?>
<link rel="stylesheet" href="includes/css/pages/users.css">


    <div class="dashboard">
        <div class="content">
            <header>
                <h1 id="page-title">مرحبا بك في لوحة التحكم</h1>
            </header>
            <main>
                <div class="users-list">
                    <div class="user-card">
                        <img src="media/profile/user-profile.png" alt="User Image">
                        <h3>محمد علي</h3>
                        <p>mohammed@example.com</p>
                        <a href="#" class="view-details text-white" >عرض التفاصيل</a>
                        <div class="user-details">
                            <p><strong>الهاتف:</strong> 1234567890</p>
                            <p><strong>العنوان:</strong> شارع الملك فهد، الرياض</p>
                        </div>
                    </div>


                <script>
                    // إضافة وظيفة لإظهار أو إخفاء التفاصيل
                    const detailButtons = document.querySelectorAll('.view-details');

                    detailButtons.forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const details = this.nextElementSibling;
                            details.style.display = details.style.display === 'block' ? 'none' : 'block';
                        });
                    });
                </script>
            </main>
        </div>
    </div>





<?php
require_once "./includes/layout/footer.php";
?>