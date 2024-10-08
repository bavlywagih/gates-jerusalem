<?php
require_once 'connect.php';

if (isset($_POST['Maintenance'])){
    $query = "UPDATE maintenance SET maintenance =". $_POST['Maintenance'];
    $con->exec($query);
    header('Location: users.php');

}


?>