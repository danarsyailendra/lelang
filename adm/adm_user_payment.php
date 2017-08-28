<?php

session_start();
include '../config/config.php';
include '../mail/mail.class3.php';

$payment = tampil('t_barang a', 'DISTINCT(SELECT user_by from t_bid WHERE id_bid = a.id_bid)', "id_bid <> ''");
$payment = tampil("p_user", "email", "tipe_user='developer'");
        

for($i=0;$i<$payment[rowsnum];$i++){
    $email = $payment[$i][0];
    $sqln = tampil('p_user', 'nama', "email = '$email'");
    list($nama) = $sqln[0];
    $mail = send_mail($email, '', 'support@metra.co.id', $nama);
    //echo $nama.'<br>';
}