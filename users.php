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
require_once "connect.php"; // تأكد من استيراد اتصال قاعدة البيانات

// استعلام لجلب جميع المستخدمين
$sql = 'SELECT * FROM users';
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$current_user_id = $_SESSION['id'];

?>
<link rel="stylesheet" href="includes/css/pages/users.css">
<style>
    .user-card img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
    }
    </style>
<div class="dashboard">
    <div class="content">
        <header>
            <h1 id="page-title">مرحبا بك في لوحة التحكم</h1>
        </header>
        <main>
            <div class="users-list">
                <?php foreach ($users as $user) {
                    $user_id = $user['id'];

                    if ($user_id === $current_user_id) {
                        continue; // تخطي بطاقة المستخدم الحالية
                    }
                    // استعلام لجلب الصورة الأكثر حداثة للمستخدم
                    $query = "SELECT image_path FROM profile_image WHERE user_id = :user_id ORDER BY upload_date DESC LIMIT 1";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(':user_id', $user_id);
                    $stmt->execute();
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);


                    $image_path = $result ? $result['image_path'] : 'media/profile/user-profile.png';

                ?>
                    <div class="user-card">
                        <img src="<?= htmlspecialchars($image_path) ?>" alt="User Image">
                        <h3><a href="profile.php?id=<?= $user['id'] ?>"><?= htmlspecialchars($user['fullname']) ?></a></h3>
                        <p><?= htmlspecialchars($user['email']) ?></p>
                        <a href="#" class="view-details text-white">عرض التفاصيل</a>
                        <div class="user-details">
                            <p><strong>الهاتف:</strong> 0<?= htmlspecialchars($user['phone']) ?></p>
                            <p><strong>تاريخ الميلاد:</strong> <?= htmlspecialchars($user['birthdate']) ?></p>
                            <p><strong> الحاله:</strong> 
                                <?php 
                                if ($user['group-id'] == 0){
                                    echo "مستخدم";
                                }elseif ($user['group-id'] == 1) {
                                    echo "مشرف";
                                }elseif ($user['group-id'] == 2) {
                                    echo "سوبر مشرف";
                                }
                                ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>

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
            </div>
        </main>
    </div>
</div>

<?php
require_once "./includes/layout/footer.php";
?>