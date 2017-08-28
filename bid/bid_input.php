<?php
session_start();
include '../config/config.php';
if (isset($_POST['submit'])) {
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga_awal = str_replace(',', '', $_POST['harga_awal']);
    $batas_waktu_tgl = $_POST['batas_waktu_tgl'];
    $batas_waktu_jam = $_POST['batas_waktu_jam'];
    $desc = $_POST['desc'];
    $batas_waktu = date('Y-m-d H:i:s', strtotime("$batas_waktu_tgl $batas_waktu_jam"));

    
    $ftp_server = '10.15.16.51';
    $ftp_user = 'danar';
    $ftp_pass = 'metra123';

    $conn_id = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
    $login = ftp_login($conn_id, $ftp_user, $ftp_pass);
    $filename = $_FILES['gambar_barang']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    ftp_chdir($conn_id, 'lelang/file/img');
    $new_name = 'GBR-' . $id_barang . '.' . $ext;
    $source_file = $_FILES['gambar_barang']['tmp_name'];
    $destination_file = ftp_pwd($conn_id) . '/' . $new_name;
    echo $destination_file . '<br>';
    echo $source_file;
    //echo $batas_waktu;
    $insert = insert("t_barang", "id_barang,nama_barang,harga_awal,batas_waktu,deskripsi,user_by,user_when,gambar", "'$id_barang','$nama_barang',$harga_awal,STR_TO_DATE('$batas_waktu','%Y-%m-%d %H:%i:%s'),'$desc','" . $_SESSION['email'] . "',NOW(),'$new_name'");
    $history = insert('t_history', 'id_barang,deskripsi,user_when,user_by', "'$id_barang','Barang berhasil diinput',NOW(),'" . $_SESSION['email'] . "'");
    if ($insert[status] == true) {
        echo "<script type='text/javascript'>";
        echo "alert('Barang berhasil diinput');";
        echo "location.href='../home.php';";
        echo "</script>";
    }
    // echo $insert[msg];
    // echo $_SESSION['email'];
} else {
    ?>
    <!--<link rel="stylesheet" type="text/css" href="../assets/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" type="text/css" href="../assets/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.min.css">

        <link rel="stylesheet" type="text/css" href="assets/jquery-ui-1.11.4/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="assets/jquery-ui-1.11.4/jquery-ui.css">-->
    <form method="post" action="bid/bid_input.php">
        <div class="modal-header metra-red header-modal-metra">
            <button type="button" class="close close-modal-metra" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <?php
            $generate_id = tampil("t_barang", "max(id_barang)", "date_format(t_barang.user_when,'%Y%m') = '" . date('Y') . date('m') . "'");
            list($max) = $generate_id[0];
            //echo $generate_id[rowsnum];
            if (empty($max)) {
                $id_barang = 'BRG-' . date('Y') . '-' . date('m') . '-0001';
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

                $id_barang = $max[0] . '-' . date('Y') . '-' . date('m') . '-' . $counter;
            }
            ?>
            <h4 class="font-header-modal-metra">Input Barang | <?= $id_barang ?></h4>
        </div>
        <div class="modal-body">
            <div class="row cm-fix-height">
                <div class="form-group col-md-3">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="hidden" id="id_barang" name="id_barang" class="form-control" value="<?= $id_barang ?>"/>
                    <input type="text" id="nama_barang" name="nama_barang" class="form-control" required/>
                </div>
                <div class="form-group col-md-3">
                    <label for="nama_barang">Harga Awal</label>
                    <input type="text" <?= $readonly ?>
                           onblur="this.value = thousand_format(this.value)" 
                           onclick="removeComma(this.value);" 
                           onkeypress="removeComma(this.value)" 
                           onkeyup="this.value = thousand_format(this.value)" id="harga_awal" name="harga_awal" class="form-control" pattern="^[0-9,]*$" required/>
                </div>
                <div class="form-group col-md-3">
                    <label for="nama_barang">Batas Waktu</label>
                    <input type="date" name="batas_waktu_tgl" class="form-control"  required/>

                </div>
                <div class="form-group col-md-3">
                    <label for="nama_barang" style="color: white">aaaaa</label>
                    <input type="time" name="batas_waktu_jam" class="form-control"  required/>
                </div>
            </div>
            <div class="row cm-fix-height">
                <div class="form-group col-md-1">
                    <label for="nama_barang">Gambar</label>
                    
                    <input type="file" id="gambar_barang"  name="gambar_barang" class="btn btn-gray" value="aaaaa"/>
                  
                </div>
            </div>
            <hr>
            <div class="row cm-fix-height">
                <div class="form-group col-md-12">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea name="desc" style="height: 500px" class="form-control" id="desc"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="submit" name="submit" class="btn btn-danger metra-red" value="Submit">
        </div>
    </form>
    <!--<script src="../assets/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.js"></script>
    <script src="../assets/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/jquery-ui-1.11.4/jquery-ui.js"></script>
    <script src="assets/jquery-ui-1.11.4/jquery-ui.min.js"></script>-->


    <script>
        //$("#date").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
        //function tes (x){
        $('.modal').on('hidden.bs.modal', function () {
            $(this).find('form')[0].reset();
            $(this).find('h4').reset();
        });
        function removeComma(x) {
            var tawar_baru = x;
            if (tawar_baru === '') {

            } else {
                x = parseInt(tawar_baru.replace(/,/g, ''));
            }

            document.getElementById('harga_awal').value = x;
        }
        //}
        /*$(function () {
         $("#date").datepicker();
         });*/
       /* function cek_date() {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //January is 0!
            var yyyy = today.getFullYear();

            if (dd < 10) {
                dd = '0' + dd;
            }

            if (mm < 10) {
                mm = '0' + mm;
            }

            var tag = document.getElementById('date').value;
            var tgl = tag.split('-');
            var val = new Date(tgl[0], tgl[1], tgl[2]);
            today = yyyy + '-' + mm + '-' + dd;
            //var val = new Date(yyyy,mm,dd);
            if(val <= today){
                document.getElementById('nama_barang').value = val;
            }else{
                document.getElementById('nama_barang').value = val;
            }
            
        }*/
        // if(today<=document.getElementById('tgl').value){var val = 'true';}else{ var val = 'false';}document.getElementById('nama_barang').value = val 
    </script>

    <?php
}
?>
