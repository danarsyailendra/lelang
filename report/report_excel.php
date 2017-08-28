<?php
session_start();
include '../config/config.php';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=List-Pemenang-Lelang.xls");
$report = tampil('t_barang a', 'id_barang,nama_barang,(select harga_bid from t_bid where id_bid = a.id_bid and id_barang = a.id_barang) harga_bid, (select (select nama from p_user where email = b.user_by) from t_bid b where id_bid = a.id_bid and id_barang = a.id_barang) pemenang,id_bid', 'bid_flag=0 and active = 1');
?>
<table  border="1">
    <h2><b>List Pemenang Lelang</b></h2>
    <h1 style="color: white">&nbsp</h1>
    <thead>
        <tr>
            <th style="background: darkred;color: white">No</th>
            <th style="background: darkred;color: white">Nama Barang</th>
            <th style="background: darkred;color: white">Pemenang</th>
            <th style="background: darkred;color: white">Harga</th>
            <th style="background: darkred;color: white">ID Penawaran</th>
        </tr>
    </thead>
    <tbody>
        <?php
        for($i=0;$i<$report[rowsnum];$i++){
            ?>
        <tr>
            <td><?=$i+1?></td>
            <td><?=$report[$i][1]?></td>
            <td><?=$report[$i][3] = ($report[$i][3]=='') ? '-':$report[$i][3] ?></td>
            <td><?=$report[$i][2] = ($report[$i][2]=='') ? '-':number_format($report[$i][2]) ?></td>
            <td><?=$report[$i][4] = ($report[$i][4]=='') ? '-':$report[$i][4] ?></td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
