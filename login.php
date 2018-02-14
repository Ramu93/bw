<?php session_start();
if(isset($_SESSION['login'])){
    header('Location: index.php');
    exit();
}
require('bonded/dbconfig.php');
$errmsg = '';
if(isset($_POST['login_button'])){
    $loginid = mysqli_real_escape_string($dbc,trim($_POST['username']));
    $password = md5(mysqli_real_escape_string($dbc,trim($_POST['password'])));
    $query = "SELECT * FROM employee_master WHERE loginid = '$loginid'";
    $result = mysqli_query($dbc, $query);
    if(mysqli_num_rows($result)>0){
        $row = mysqli_fetch_assoc($result);
        if($password == $row['password']){
            $_SESSION['login'] = 'yes';
            $_SESSION['userid'] = $row['em_id'];
            $_SESSION['loginid'] = $loginid;
            $_SESSION['loginname'] = $row['employee_name'];
            $_SESSION['role_master_id'] = $row['role_master_id'];
            $q2 = "SELECT * FROM role_master WHERE role_master_id = '{$row['role_master_id']}'";
            $r2 = mysqli_query($dbc,$q2);
            if(mysqli_num_rows($r2)>0){
                $r2 = mysqli_fetch_assoc($r2);
                $_SESSION['role_permissions'] = $r2['role_permissions']; 
            //file_put_contents("testlog.log", print_r($_SESSION['login'], true), FILE_APPEND | LOCK_EX);
               // echo "<script>window.location.href='bonded/sac/sac-request-create.php';</script>";
                header('Location: index.php');
                exit();
            }else{
                $errmsg = "Failed to load user permissions";
                unset($_SESSION);
            }
        }else{
            $errmsg = "Login ID / Password mismatch";
        }
    }else{
        $errmsg = "Login ID not available";
    }
}

?><!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bonded Warehouse</title>
    <!-- Core CSS - Include with every page -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/main-style.css" rel="stylesheet" />

</head>

<body class="body-Login-back" style="background-color: #dd4b39;">

    <div class="container">
       
        <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center logo-margin ">
                <img src="assets/img/tmtlogo.png" alt=""/>
            </div>
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="login.php" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control " placeholder="Login ID" name="username" type="text" autofocus required value="<?php echo isset($loginid)?$loginid:''; ?>">
                                </div>
                                <div class="form-group">
                                    <input class="form-control " placeholder="Password" name="password" type="password" required>
                                </div>
                                <!--div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me">Remember Me
                                    </label>
                                </div-->
                                <div class="form-group" style="color:red;padding-left:10px;"><?php echo ($errmsg!='')?$errmsg:''; ?></div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-success btn-block" name="login_button">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!-- Core Scripts - Include with every page -->
    <script src="assets/plugins/jquery-1.10.2.js"></script>
    <script src="assets/plugins/bootstrap/bootstrap.min.js"></script>
    <!--script src="assets/plugins/metisMenu/jquery.metisMenu.js"></script-->

</body>
</html>