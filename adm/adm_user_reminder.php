<?php

session_start();
include '../config/config.php';
include '../mail/mail.class2.php';

$user = tampil('p_user', 'email,nama,pass', '');

for($i=0;$i<$user[rowsnum];$i++){
    $email = $user[$i][0];
    $nama = $user[$i][1];
    $pass = $user[$i][2];
    
    //echo $email.'<br>';
    $mail = send_mail($email, '', 'support@metra.co.id', $pass, $nama);
}
echo "<script type='text/javascript'>";
        echo "alert('Reminder Success');";
        echo "location.href='../home.php?menu=3';";
        echo "</script>";