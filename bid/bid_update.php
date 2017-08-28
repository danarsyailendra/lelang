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

   /* $ftp_server = '10.15.16.51';
    $ftp_user = 'danar';
    $ftp_pass = 'metra123';

    $conn_id = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
    
    $login = ftp_login($conn_id, $ftp_user, $ftp_pass);
    //echo ftp_pwd($conn_id);*/
    $filename = $_FILES['gambar_barang']['name'];
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    //ftp_chdir($conn_id, 'lelang/file/img');
   // echo getcwd().DIRECTORY_SEPARATOR;
    chdir('../file/img');
    
    $new_name = 'GBR-' . $id_barang . '.' . $ext;
    $source_file = $_FILES['gambar_barang']['tmp_name'];
   // $destination_file = ftp_pwd($conn_id) . '/' . $new_name;
    $destination_file = getcwd().DIRECTORY_SEPARATOR.$new_name;
    echo $destination_file . '<br>';
    echo $source_file;

   // $upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY);
    (@move_uploaded_file($source_file, $destination_file));
        //echo $batas_waktu;
        $update = update('t_barang', "nama_barang = '$nama_barang',harga_awal=$harga_awal,batas_waktu = STR_TO_DATE('$batas_waktu','%Y-%m-%d %H:%i:%s'),deskripsi='$desc',gambar = '$new_name'", "id_barang = '$id_barang'");
        $history = insert('t_history', 'id_barang,deskripsi,user_when,user_by', "'$id_barang','Barang berhasil diupdate',NOW(),'" . $_SESSION['email'] . "'");
        if ($update[status] == true) {
            echo "<script type='text/javascript'>";
            echo "alert('Barang berhasil diupdate');";
            echo "location.href='../home.php';";
            echo "</script>";
        }
    //}else{
      //  echo "<script type='text/javascript'>";
      //  echo "alert('Header False');";
      //  echo "location.href='../home.php';";
      //  echo "</script>";
    //}
     //echo $update[query];
    // echo $_SESSION['email'];
} else {
    ?>

    <form method="post" action="bid/bid_update.php" enctype="multipart/form-data">
        <div class="modal-header metra-red header-modal-metra">
            <button type="button" class="close close-modal-metra" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <?php
            unset($id_barang);
            $id_barang = $_GET['id'];
            $barang = tampil('t_barang', 'nama_barang,harga_awal,batas_waktu,deskripsi', "id_barang = '$id_barang'");
            list($nama_barang, $harga_awal, $batas_waktu, $desc) = $barang[0];
            $waktu = explode(' ', $batas_waktu);

            $ccek = tampil('t_bid', 'id_bid', 'id_barang = "' . $id_barang . '"');
            $readonly = ($ccek[rowsnum] > 0) ? 'readonly' : '';
            ?>
            <h4 class="font-header-modal-metra">Update Barang | <?= $id_barang ?></h4>
        </div>
        <div class="modal-body">
            <div class="row cm-fix-height">
                <div class="form-group col-md-3">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="hidden" id="id_barang" name="id_barang" class="form-control" value="<?= $id_barang ?>"/>
                    <input type="text" id="nama_barang" name="nama_barang" class="form-control" value="<?= $nama_barang ?>" required/>
                </div>
                <div class="form-group col-md-3">
                    <label for="nama_barang">Harga Awal</label>
                    <input type="text" <?= $readonly ?> value="<?= number_format($harga_awal) ?>" 
                           onblur="this.value = thousand_format(this.value)" 
                           onclick="removeComma(this.value);" 
                           onkeypress="removeComma(this.value)" 
                           onkeyup="this.value = thousand_format(this.value)" id="harga_awal" name="harga_awal" class="form-control" pattern="^[0-9,]*$" required/>
                </div>
                <div class="form-group col-md-3">
                    <label for="nama_barang">Batas Waktu</label>
                    <input type="date" value="<?= $waktu[0] ?>" name="batas_waktu_tgl" class="form-control"  required/>

                </div>
                <div class="form-group col-md-3">
                    <label for="nama_barang" style="color: white">aaaaa</label>
                    <input type="time" value="<?= $waktu[1] ?>" name="batas_waktu_jam" class="form-control"  required/>
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
                    <textarea name="desc" style="height: 500px" class="form-control" id="desc"><?= $desc ?></textarea>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="submit" name="submit" class="btn btn-danger metra-red" value="Submit">
        </div>
    </form>
    <script>


        //function tes (x){
        $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });
        $('.modal').on('hidden.bs.modal', function () {
            $(this).find('input[type=text]').val('').end();

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
    </script>
    <?php
}
?>
