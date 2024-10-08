<?php
$maintenance_file = 'maintenance_mode.txt';
$maintenance_mode = trim(file_get_contents($maintenance_file));

if ($maintenance_mode == '1') {
    // محتوى صفحة الصيانة
    echo "<h1>الموقع في حالة صيانة</h1>";
    exit();
} else {
    // الموقع يعمل بشكل عادي
    // قم بتضمين الكود الرئيسي للموقع هنا
    echo "<h1>الموقع يعمل بشكل طبيعي</h1>";
}
?>
