<?php

session_start();
include '../config/config.php';

$list_barang = tampil('t_barang', 'id_barang,nama_barang,harga_awal,batas_waktu,user_by,user_when', 'active = 1 AND bid_flag = 1');
//echo $list_barang[msg];
if ($list_barang[rowsnum] > 0) {
    for ($i = 0; $i < $list_barang[rowsnum]; $i++) {
        /* $format = explode(' ', $list_barang[$i][3]);
          $tgl_indo = indo($format[0]) . ' - ' . $format[1]; */
        // $batas_waktu = '<input type"text" id="batas_waktu'.$i.'" value="'.$list_barang[$i][3].'" style="border:none" readonly>';
        if (strtotime(date('d-m-Y h:i:s a')) > strtotime($list_barang[$i][3])) {
            $cek = update('t_barang', 'bid_flag=0', 'id_barang = "' . $list_barang[$i][0] . '"');
            //$cek = 'aaaa';
        } else {
            $nama_tinggi = '';

            $tinggi = tampil('t_bid', 'harga_bid,user_by,id_bid', 'id_barang = "' . $list_barang[$i][0] . '" order by harga_bid desc limit 0,1');
            list($tertinggi, $user_email, $id_bid) = $tinggi[0];
            if ($_SESSION['tipe'] == 'developer') {
                $nama_tertinggi = tampil('p_user', 'nama', 'email = "' . $user_email . '"');
                list($user_name) = $nama_tertinggi[0];
                $nama_tinggi = '<br><code class="pull-right code-green"><i>' . $user_name . '</i></code>';
            }
            $tawar_tinggi = '';
            if (isset($tertinggi)) {
                $tawar_tinggi = 'Rp. ' . number_format($tertinggi);
            } else {
                $tawar_tinggi = '-';
            }
            //$cek ='';
            $cek_harga = update('t_barang', 'id_bid="' . $id_bid . '"', 'id_barang = "' . $list_barang[$i][0] . '" and active = 1 and bid_flag = 1');

            $button = '<div class="btn-group">
            <button type="button" class="btn btn-danger dropdown-toggle metra-red" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
            <ul class="dropdown-menu" role="menu">';
            if ($_SESSION['tipe'] != 'user') {
                $button .= '<li><a href="bid/bid_update.php?id=' . $list_barang[$i][0] . '" data-toggle="modal" data-target="#modal_update">Display / Update Barang</a></li>';
            }
            $button .= '<li><a href="bid/bid_act.php?id=' . $list_barang[$i][0] . '" data-toggle="modal" data-target="#bid">Penawaran</a></li>';
            if ($_SESSION['tipe'] != 'user') {
                $button .= '<li><a href="bid/bid_delete.php?id=' . $list_barang[$i][0] . '" data-toggle="modal" data-target="#modal_delete">Hapus Barang</a></li>';
            }
            $button .= '</ul></div>';

            $data[] = array(
                $i + 1,
                $list_barang[$i][1] . '<br><code class="pull-right code-green"><i>' . $list_barang[$i][0] . '</i></code>',
                'Rp. ' . number_format($list_barang[$i][2]),
                $tawar_tinggi . $nama_tinggi,
                $button
            );
        }

        //print_r($data);
    }
} else {
    $data[] = array(
        '',
        'Data Not Found',
        '',
        '',
        ''
    );
}
$arr_data = array("data" => $data);
echo json_encode($arr_data);
?>
