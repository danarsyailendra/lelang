<?php

session_start();
include '../config/config.php';

$list_barang = tampil('t_bid', '*', "t_bid.user_by = '" . $_SESSION['email'] . "' order by id_barang, harga_bid desc");
$j = 1;
for ($i = 0; $i < $list_barang[rowsnum]; $i++) {
    if ($list_barang[$i][1] != $list_barang[$i - 1][1]) {
        
        $id_brg = $list_barang[$i][1];
        $sqld = tampil('t_barang', 'deskripsi', "id_barang = '$id_brg'");
        list($desc) = $sqld[0];
        $harga = $list_barang[$i][2];
        $id_bid = $list_barang[$i][0];
        $brg = tampil('t_barang', 'nama_barang,id_bid', "id_barang = '$id_brg'");
        list($nama_barang,$id_bid_brg) = $brg[0];
        if($id_bid == $id_bid_brg){
            $status  = '<center><h3 class="alert alert-success shadowed" style="background-color:#2da34e;color:white">Win</h3></center>';
        }else{
            $status = '<center><h3 class="alert alert-danger shadowed" style="background-color:#e0553c;color:white">Lose</h3></center>';
        }
        $data[] = array(
            $j++,
            $id_brg.'<br><pre>'.$desc.'</pre>',
            $nama_barang,
            "Rp. ".number_format($harga),
            $status
        );
    }
}
$arr_data = array("data" => $data);
echo json_encode($arr_data);
