<?php
/*	$inipath = php_ini_loaded_file();

if ($inipath) {
    echo 'Loaded php.ini: ' . $inipath;
} else {
   echo 'A php.ini file is not loaded';
}*/
include 'config/config.php';
include 'mail/mail.class.php';

if(isset($_POST['submit'])){
    $tampil_email = tampil('p_user', 'email,nama', "email = '".$_POST['email']."'");
    list($email,$name) = $tampil_email[0];
   // echo $tampil_email[query]
    $pass = generatePassword();
    $mail = send_mail($email, '', 'suuport@metra.co.id', $pass, $name);
    if ($mail['STATUS'] == 'OK') {
            $update = update('p_user', "pass = '$pass'", "email = '" . $email . "'");
            if ($update[status] == true) {
                $success++;
            } else {
                $error++;
            }
        } else {
            $email_error .= $tampil_email[$i][0];
            $email_error .= ', ';
        }
}else{
    ?>
<form action="" method="post">
    <input type="text" name="email">
    <input type="submit" name="submit">
</form>
<?php
}
?>