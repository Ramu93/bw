<?php
session_start();
require('dbconfig.php'); 
if(!$_POST) {
    $action = $_GET['action'];
}
else {
    $action = $_POST['action'];
}
switch($action){
    case 'login':
        $finaloutput = login();
    break;
}

echo json_encode($finaloutput);

function login(){
    global $dbc; 
    $output = array();
    $_SESSION['login']=false; 

    $username = mysqli_real_escape_string($dbc, trim($_POST['username']));
    $password = mysqli_real_escape_string($dbc, trim($_POST['password']));

    $query = "SELECT * FROM users WHERE username='".$username."'";
    $result = mysqli_query($dbc,$query);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        if(md5($password) == $row['password']){
            $_SESSION['login']=true; 
            $_SESSION['username'] = $row['username'];
            $_SESSION['fullname'] = $row['firstname'] . " " . $row['lastname'];
            $output = array("infocode" => "LOGINSUCCESS", "message" => "dashboard/dashboard.php");
        } else {
            //$output = "bootbox.alert('Wrong password!');";
            $output = array("infocode" => "INCORRECTPASSWORD", "message" => "Wrong password!");
        }
    } else {
        //$output = "bootbox.alert('Unknown user!');";
        $output = array("infocode" => "UNKNOWNUSER", "message" => "Unknown user!");
    }
    return $output;
}


?>
