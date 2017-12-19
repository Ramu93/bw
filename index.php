<?php session_start();

if(!isset($_SESSION['login'])){
    header('Location: login.php');
    exit();
}

header('Location: bonded/sac/sac-request-create.php');
exit();
?>