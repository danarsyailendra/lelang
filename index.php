<?php
session_start();
include "config/config.php";
//echo $_SESSION['email'];
if (isset($_SESSION['email'])) {
    header("Location:http://" . $_SERVER['SERVER_NAME'] . "/lelang/home.php");
} else {
    if (isset($_POST['submit'])) {
        $user = $_POST['username'];
        $pass = $_POST['password'];
        $cek = tampil("p_user", "email,nama,tipe_user", "email = '$user' and pass = '$pass' ");
        list($email, $username, $tipe) = $cek[0];
        if ($cek[rowsnum] > 0) {
            $_SESSION['email'] = $email;
            $_SESSION['name'] = $username;
            $_SESSION['tipe'] = $tipe;
            header("Location:http://" . $_SERVER['SERVER_NAME'] . "/lelang/home.php");
            unset($_SESSION['login']);
        } else {
            $_SESSION['login'] = true;

            header("Location:http://" . $_SERVER['SERVER_NAME'] . "/lelang/");
        }
    } else {
        //echo $_GET['login'];
        ?>
        <!DOCTYPE html>
        <html lang="fr">
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
                <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-clearmin.min.css">
                <link rel="stylesheet" type="text/css" href="assets/css/roboto.css">
                <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
                <title>Lelang Metra | Login</title>
                <style></style>
            </head>
            <body class="cm-login">

                <div class="text-center" style="padding:90px 0 30px 0;background:#fff;border-bottom:1px solid #ddd">
                    <img src="assets/img/New_Telkom_Metra.jpg" style="max-width: 100%">
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3" style="margin:40px auto; float:none;">
                    <form method="post" action="">
                        <?php
                        //echo $_SESSION['login'];    
                        if ($_SESSION['login'] == true) {
                            ?>
                            <div class="col-xs-12">
                                <div class="panel panel-default">
                                    <div class="panel-body" style="background-color: pink">
                                        <img src="assets/img/sf/shield-error.svg"><span style="color: red;font-size: 15px"><b>Username atau Password Salah</b></span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="col-xs-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-fw fa-user"></i></div>
                                    <input type="text" name="username" class="form-control" placeholder="Username">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-fw fa-lock"></i></div>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <button type="submit" class="btn btn-block btn-danger" name="submit">Sign in</button>
                        </div>
                    </form>
                </div>
            </body>
        </html>
        <?php
    }
}
?>