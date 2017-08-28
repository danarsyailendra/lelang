<?php

session_start();
include '../config/config.php';

$list_user = tampil('p_user', '*', 'email like "%@%" order by nama');
for($i=0;$i<$list_user[rowsnum];$i++){
    $email = $list_user[$i][0];
    $nama = $list_user[$i][1];
    $role = $list_user[$i][3];
    
    
    $data[] = array(
        $i+1,
        $nama,
        $email,
        $role
    );
}
$arr_data = array("data" => $data);
echo json_encode($arr_data);