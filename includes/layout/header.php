
<?php
require_once 'connect.php';
require_once "./maintenance.php";
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$currentPageURL = rtrim($protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], '/');
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
    
    <head>

<meta property="og:title" name="description" content="أبواب مدينة أورشليم القديمة، في عصر نحميا - شرح الكلمة - قاموس الكتاب المقدس | دائرة المعارف الكتابية المسيحية - معجم الكلمات العسرة في الإنجيل - موقع ابواب اورشليم - موقع بافلي - مصر">
<meta http-equiv="Content-Language" content="ar-eg">
<meta name="keywords" content="قاموس، الكتاب، المقدس، الإنجيل، الانجيل، انجيل، إنجيل، شرح، كلمات، الكلمات، الكلمة، الكلمه، كلمة، كلمه، تفسير، التفسير، معجم، المعجم، معاجم، المعاجم، القاموس، قواميس، القواميس، الشرح، شروحات، تفاسير">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1256">
<meta property="og:image" itemprop="image" name="twitter:image" id="metaOpenGraphImage" content="https://www.jerusalem-gates.42web.io/media/img/index.png" />
<meta content="summary_large_image" name="twitter:card">
<meta property="og:url" content="https://www.jerusalem-gates.42web.io/">
<meta property="og:type" content="website">
<meta property="og:site_name" content="jerusalem-gates.42web.io">





<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CYJ295F772"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-CYJ295F772');
</script>


        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="موقع أبواب القدس يتناول تاريخ أبواب القدس العريقة.">
        <meta name="keywords" content="أبواب القدس, تاريخ القدس, أبواب أورشليم, المدينة المقدسة">
        <meta name="google-site-verification" content="+nxGUDJ4QpAZ5l9Bsjdi102tLVC21AIh5d1Nl23908vVuFHs34=">

    <style>
        #consent-banner {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            z-index: 1000;
            display: none; /* إخفاء الشريط بشكل افتراضي */
        }
        #consent-banner button {
            background: #f1c40f;
            border: none;
            color: #000;
            padding: 10px 20px;
            cursor: pointer;
        }
    </style>
        <title>ابواب اورشليم - بافلي وجيه</title>
        <link rel="stylesheet" href="includes/css/index.css">
        <link rel="icon" type="image/x-icon" href="media/img/logo.png" sizes="20x20">
<script src="https://cdn.tiny.cloud/1/3bmxrokdxh6czakdtc0w6dtq55er625cw8wih2n3v02j4shb/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>

        
    </head>

    
    <body style="overflow: auto;">
 <div id="consent-banner">
        <p>نستخدم ملفات تعريف الارتباط لتحسين تجربتك. من فضلك، وافق على استخدام ملفات تعريف الارتباط.</p>
        <button id="grantButton">موافقة</button>
    </div>

    <!-- جافا سكريبت لإدارة تفضيلات ملفات تعريف الارتباط -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }

            function loadGtagScript() {
                var gtagScript = document.createElement('script');
                gtagScript.async = true;
                gtagScript.src = 'https://www.googletagmanager.com/gtag/js?id=G-CYJ295F772';
                document.head.appendChild(gtagScript);

                gtagScript.onload = function() {
                    gtag('js', new Date());
                    gtag('config', 'G-CYJ295F772');
                };
            }

            if (localStorage.getItem("consentGranted") !== "true") {
                gtag('consent', 'default', {
                    'ad_user_data': 'denied',
                    'ad_personalization': 'denied',
                    'ad_storage': 'denied',
                    'analytics_storage': 'denied',
                    'wait_for_update': 500
                });

                document.getElementById('consent-banner').style.display = 'block';

                document.getElementById('grantButton').addEventListener("click", function() {
                    localStorage.setItem("consentGranted", "true");
                    gtag('consent', 'update', {
                        'ad_user_data': 'granted',
                        'ad_personalization': 'granted',
                        'ad_storage': 'granted',
                        'analytics_storage': 'granted'
                    });
                    document.getElementById('consent-banner').style.display = 'none';
                    loadGtagScript();
                });
            } else {
                loadGtagScript();
            }
        });
    </script>
        <?php 
        require_once "./includes/layout/nav.php";

        ?>
        