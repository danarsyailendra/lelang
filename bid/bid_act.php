<?php
session_start();
include '../config/config.php';
if (isset($_POST['submit'])) {
    //echo $_POST['bid'].' '.$_POST['id_brg'].' '.$_POST['id_bid'];
    $harga_bid = str_replace(',', '', $_POST['bid']);
    $id_bid = $_POST['id_bid'];
    $id_brg = $_POST['id_brg'];
    $cek = tampil('t_barang', 'bid_flag', 'id_barang = "' . $id_brg . '"');
    list($flag_bid) = $cek[0];
    if ($flag_bid == 0) {
        echo "<script type='text/javascript'>";
        echo "alert('Batas waktu telah terlewati');";
        echo "location.href='../home.php';";
        echo "</script>";
    } else {
        $insert = insert('t_bid', '', "'$id_bid','$id_brg',$harga_bid,'" . $_SESSION['email'] . "',NOW()");
        $history = insert('t_history', 'id_barang,deskripsi,user_when,user_by', "'$id_brg','Tawaran update',NOW(),'" . $_SESSION['email'] . "'");
        /*if ($insert[status] == true) {
            echo "<script type='text/javascript'>";
            echo "alert('Tawaran Berhasil');";
            echo "location.href='../home.php';";
            echo "</script>";
        } else {
            echo "<script type='text/javascript'>";
            echo "alert('Header Error');";
            echo "location.href='../home.php';";
            echo "</script>";
        }*/
    }
} else {
    ?>

    <form method="post" action="bid/bid_act.php">
        <div class="modal-header metra-red header-modal-metra">
            <button type="button" class="close close-modal-metra" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <?php
            unset($id_barang);
            $id_barang = $_GET['id'];
            $barang = tampil('t_barang a', 'nama_barang,deskripsi,harga_awal,(select harga_bid from t_bid where id_bid = a.id_bid),gambar', 'id_barang = "' . $id_barang . '"');
            // echo $barang[query];
            list($nama_barang, $desc, $harga_awal, $tertinggi,$gambar) = $barang[0];
            $gambar = ($gambar=='') ? 'no_image.png' : $gambar;
            $generate_id = tampil("t_bid", "max(id_bid)", "date_format(t_bid.user_when,'%Y%m') = '" . date('Y') . date('m') . "'");
            list($max) = $generate_id[0];
            //echo $generate_id[rowsnum];
            if (empty($max)) {
                $id_bid = 'BID-' . date('Y') . '-' . date('m') . '-0001';
            } else {
                $max = explode('-', $max);
                $counter = $max[3] + 1;
                if (strlen($counter) == 1) {
                    $counter = '000' . $counter;
                } elseif (strlen($counter) == 2) {
                    $counter = '00' . $counter;
                } elseif (strlen($counter) == 3) {
                    $counter = '0' . $counter;
                } else {
                    $counter = $counter;
                }

                $id_bid = $max[0] . '-' . date('Y') . '-' . date('m') . '-' . $counter;
            }
            $tampil = tampil('t_bid', 'harga_bid,user_by,user_when', 'id_barang = "' . $id_barang . '" order by harga_bid desc,user_by desc limit 0,5');
            //  echo $tampil[query];
            ?>
            <h4 class="font-header-modal-metra">Input Tawaran | <?= $id_barang ?></h4>
        </div>
        <input type="hidden" name="id_bid" value="<?= $id_bid ?>">
        <input type="hidden" name="id_brg" value="<?= $id_barang ?>">
        <div class="modal-body" style="background-color: #ddd">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row cm-fix-height">
                        <div class="form-group col-md-4">
                            <b>Nama Barang</b> 
                        </div>
                        <div class="form-group col-md-1">
                            <b>:</b> 
                        </div>
                        <div class="form-group col-md-7">
                            <?= $nama_barang ?>
                        </div>
                    </div>
                    <div class="row cm-fix-height">

                        <div class="form-group col-md-4">
                            <b>Harga Awal</b> 
                        </div>
                        <div class="form-group col-md-1">
                            <b>:</b> 
                        </div>
                        <div class="form-group col-md-7">
                            Rp. <input type="text" id="start" value="<?= number_format($harga_awal) ?>" readonly style="border: none">
                        </div>
                    </div>
                    <div class="row cm-fix-height">

                        <div class="form-group col-md-4">
                            <b>Penawaran Tertinggi</b> 
                        </div>
                        <div class="form-group col-md-1">
                            <b>:</b> 
                        </div>
                        <div class="form-group col-md-7">
                            Rp. <input type="text" id="old" value="<?= number_format($tertinggi) ?>" readonly style="border: none">
                        </div>
                    </div>
                    <div class="row cm-fix-height">
                        <div class="form-group col-md-4">
                            <b>Dekripsi</b>
                            <br>
                            <img src="file/img/<?=$gambar?>"width="200px" height="100px">
                        </div>
                        <div class="form-group col-md-1">
                            <b>:</b> 
                        </div>
                        <div class="form-group col-md-7">
                            <pre style=""> <?= $desc = ($desc == '') ? '-' : $desc ?></pre>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row cm-fix-height">
                        <div class="form-group col-md-3">
                            <b>Tawaran</b> 
                        </div>
                        <div class="form-group col-md-1">
                            <b>:</b> 
                        </div>
                        <div class="form-group col-md-8">
                            <input type="text" <?= $readonly ?> value="<?= number_format($tertinggi) ?>" 
                                    id="new" name="bid" class="form-control" pattern="^[0-9,]*$" readonly required/>
                        </div>
                    </div>
                    <div class="row cm-fix-height">
                        <div class="form-group col-md-2">
                            
                        </div>
                        
                        <div class="form-group col-md-10">
                            <a class=" btn btn-success" onclick="plusFiveThousand(document.getElementById('new').value);validate()">Rp. 5,000</a>
                            <a class=" btn btn-success" onclick="plusTenThousand(document.getElementById('new').value);validate()">Rp. 10,000</a>
                            <a class=" btn btn-success" onclick="plusFiftyThousand(document.getElementById('new').value);validate()">Rp. 50,000</a>
                            <a class=" btn btn-success" onclick="plusHundredThousand(document.getElementById('new').value);validate()">Rp. 100,000</a>
                            <a class=" btn btn-warning" onclick="reset(document.getElementById('new').value);validate()">Reset</a>
                        </div>
                    </div>
                    <?php
                        if($_SESSION['tipe']=='developer'){
                    ?>
                   <hr>
                    <div class="row cm-fix-height">
                        <label for="penawaran terakhir">5 Penawaran Terakhir</label>
                        <table id="listTawar" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%" >No</th>
                                    <th width="20%" >Harga</th>
                                    <th width="30%" >User</th>
                                    <th width="35%" >Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < $tampil[rowsnum]; $i++) {
                                    $sql = tampil('p_user', 'nama', "email = '" . $tampil[$i][1] . "'");
                                    list($nama) = $sql[0];
                                    $date = explode(' ', $tampil[$i][2]);
                                    ?>
                                    <tr>
                                        <td><?= $i + 1 ?></td>
                                        <td>Rp. <?= number_format($tampil[$i][0]) ?></td>
                                        <td><?= $nama ?></td>
                                        <td><?= indo($date[0]) . ' - ' . $date[1] ?></td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                   <?php
                        }
                   ?>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="alert alert-danger shadowed pull-left" role="alert" id="sama"> 
                Tawaran Anda Sama dengan atau kurang dari tawaran terakhir
            </div>
            <input type="submit" name="submit" class="btn btn-danger metra-red" value="Submit" id="submit" style="display: none">
        </div>
    </form>
    <?php
}
?>
<script>
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
    function validate() {
        var harga_awal = document.getElementById('start').value;
        var tawar_lama = document.getElementById('old').value;
        var tawar_baru = document.getElementById('new').value;
        if (tawar_baru !== '') {
            harga_awal = parseInt(harga_awal.replace(/,/g, ''));
            tawar_lama = parseInt(tawar_lama.replace(/,/g, ''));
            tawar_baru = parseInt(tawar_baru.replace(/,/g, ''));
            if (tawar_baru <= tawar_lama) {
                document.getElementById('sama').style.display = '';
                document.getElementById('submit').style.display = 'none';

            } else if (tawar_baru <= harga_awal) {
                document.getElementById('sama').style.display = '';
                document.getElementById('submit').style.display = 'none';

            } else {
                document.getElementById('sama').style.display = 'none';
                document.getElementById('submit').style.display = '';

            }
        }
    }
    ;
    function removeComma(x) {
        var tawar_baru = x;
        if (tawar_baru === '') {

        } else {
            x = parseInt(tawar_baru.replace(/,/g, ''));
        }

        return x;
    }
    function plusFiveThousand(x){
       var bid = removeComma(x);
       bid = bid + 5000;
       bid = thousand_format(bid);
       document.getElementById('new').value = bid;
    }
    function plusTenThousand(x){
       var bid = removeComma(x);
       bid = bid + 10000;
       bid = thousand_format(bid);
       document.getElementById('new').value = bid;
    }
    function plusFiftyThousand(x){
       var bid = removeComma(x);
       bid = bid + 50000;
       bid = thousand_format(bid);
       document.getElementById('new').value = bid;
    }
    function plusHundredThousand(x){
       var bid = removeComma(x);
       bid = bid + 100000;
       bid = thousand_format(bid);
       document.getElementById('new').value = bid;
    }
    function reset(x){
       document.getElementById('new').value = document.getElementById('old').value ;
    }
</script>