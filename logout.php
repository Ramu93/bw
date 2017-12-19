<?php

session_start();
session_destroy();
$_SESSION = array();
setcookie(session_name(),"");
// session_regenerate_id(true);
header('Location:login.php');
?>