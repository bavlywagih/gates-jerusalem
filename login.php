<?php
session_start();
if (isset($_SESSION['username'])) {
    // echo $_SESSION['id'];

    header('location: index.php');
    exit();
}

require_once ('includes/layout/header.php');
require_once('connect.php');
require_once ('includes/layout/nav.php');



if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT * FROM users WHERE username = ?  AND password = ? " );
    $stmt->execute(array($username , $password));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

    if ($count > 0) {
        $_SESSION['username'] = $username;
        $_SESSION['fullname'] = $row['fullname'];
        $_SESSION['group-id'] = $row['group-id'];
        $_SESSION['id'] = $row['id'];
        header('location: index.php');
        exit();
    }else{
        echo "987";
    }
}

?>

<div class="wrapper">
    <div class="logo">
    <!-- <i class="fa-solid fa-user"></i> -->
        <img src="http://localhost/gates-jerusalem/media/img/icon-user.png" class="icon-user" alt="">
    </div>
    <div class="text-center mt-4 name">
        <br>
        <span>
            تسجيل دخول 
        </span>
    </div>


    <form class="p-3 mt-3" action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">

        <div class="form-field d-flex align-items-center">
            <span class="far fa-user"></span>
            <input type="text" name="username" id="username" placeholder="username">
        </div>
        <div class="form-field d-flex align-items-center">
            <span class="fas fa-key"></span>
            <input type="password" name="password" id="password" placeholder="password">
        </div>
        <button class="btn mt-3">تسجيل دخول</button>
    </form>
    <!-- <div class="text-center fs-6">
        <a href="#">تسجيل دخول مشرفين</a>
    </div> -->
</div>
<?php
require_once('includes/layout/footer.php');

?>