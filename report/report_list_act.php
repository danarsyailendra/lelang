<?php

session_start();
include '../config/config.php';

$report = tampil('t_barang a', 'id_barang,nama_barang,(select harga_bid from t_bid where id_bid = a.id_bid and id_barang = a.id_barang) harga_bid, (select (select nama from p_user where email = b.user_by) from t_bid b where id_bid = a.id_bid and id_barang = a.id_barang) pemenang,id_bid', 'active = 1 and bid_flag=0 order by id_bid desc');
//$report[query];
for ($i = 0; $i < $report[rowsnum]; $i++) {
    $id_barang = $report[$i][0];
    $nama_barang = $report[$i][1];
    $harga_bid = $report[$i][2];
    $pemenang = $report[$i][3];
    $id_bid = $report[$i][4];

    $harga_bid = ($harga_bid == '') ? '-' : 'Rp. '.number_format($harga_bid);
    $pemenang = ($pemenang == '') ? '-' : $pemenang;
    $id_bid = ($id_bid == '') ? '-' : $id_bid;
    $data[] = array(
        $i + 1,
        $nama_barang,
        $pemenang,
        $harga_bid,
        $id_bid
    );
}
$arr_data = array("data" => $data);
echo json_encode($arr_data);
?>