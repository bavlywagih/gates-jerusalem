<?php
if ($_SERVER['REQUEST_URI'] == "/404.php") {
    header("HTTP/1.0 404 Not Found");
    include("404.php");
    exit;
}

$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$currentPageURL = rtrim($protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], '/');
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
    <title>ابواب اورشليم - بافلي وجيه</title>
    <link rel="stylesheet" href="http://localhost/gates-jerusalem/includes/css/vendor/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.rtl.min.css" integrity="sha384-dc2NSrAXbAkjrdm9IYrX10fQq9SDG6Vjz7nQVKdKcJl3pC+k37e7qJR5MVSCS+wR" crossorigin="anonymous">
    <link rel="stylesheet" href="http://localhost/gates-jerusalem/includes/css/vendor/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost/gates-jerusalem/includes/css/index.css">
    <link rel="icon" type="image/x-icon" href="http://localhost/gates-jerusalem/media/img/logo.png" sizes="20x20">

</head>

<body style="overflow-x: hidden;">  
    <div class='spinner-wrapper'>
        <video width="320" height="240" autoplay muted loop>
            <source src="http://localhost/gates-jerusalem/media/videos/loading.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="spinner"></div>
    </div>