<?php
session_start();
include '../config/config.php';
//require '../config/excel_reader.php';

if (isset($_POST['submit'])) {
    $ftp_server = '10.15.16.51';
    $ftp_user = 'danar';
    $ftp_pass = 'metra123';

    $conn_id = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
    $login = ftp_login($conn_id, $ftp_user, $ftp_pass);

    ftp_chdir($conn_id, 'lelang/file');
    $destination_file = ftp_pwd($conn_id) . '/' . basename($_FILES['excel']['name']);

    // tambahkan baris berikut untuk mencegah error is not readable
    $handle = fopen($_FILES['excel']['tmp_name'], "r");
    $row = 0;
    $success = 0;
    $error = 0;
    $row_error = '';
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($row != 0) {
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
            $nama_barang = $data[0];
            $harga_awal = $data[1];
            $batas_waktu = date('Y-m-d H:i:s', strtotime("$data[2] $data[3]"));
            $desc = $data[4];
            $insert = insert("t_barang", "id_barang,nama_barang,harga_awal,batas_waktu,deskripsi,user_by,user_when", "'$id_barang','$nama_barang',$harga_awal,STR_TO_DATE('$batas_waktu','%Y-%m-%d %H:%i:%s'),'$desc','" . $_SESSION['email'] . "',NOW()");
            $history = insert('t_history', 'id_barang,deskripsi,user_when,user_by', "'$id_barang','Barang berhasil diinput',NOW(),'".$_SESSION['email']."'");
            //echo $data[0].' '.$data[1].' '.$data[2].' '.$data[3].'<br>';
            if($insert[status] == true){
                $success++;
            }else{
                $error++;
                $row_error .= $row .',';
            }
            //echo $insert[query].'<br>';
        }
        $row++;
    }
    //echo basename($_FILES['excel']['name']);
    echo "<script type='text/javascript'>";
    echo "alert('Import Success : $success - Import Error : $error - Row Error : $row_error');";
    echo "location.href='../home.php';";
    echo "</script>";
} else {
    ?>
    <form method="post" action="bid/bid_excel.php" enctype="multipart/form-data">
        <div class="modal-header metra-red header-modal-metra">
            <button type="button" class="close close-modal-metra" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="font-header-modal-metra">Import Excel</h4>
        </div>
        <div class="modal-body" style="background-color: #ddd">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row cm-fix-height">
                        <div class="form-group col-md-4">
                            <b>Template</b> 
                        </div>
                        <div class="form-group col-md-1">
                            <b>:</b> 
                        </div>
                        <div class="form-group col-md-7">
                            <a href="file/Template_Upload.xls"><img src="assets/img/sf/file-excel.svg"></a>
                        </div>
                    </div>
                    <div class="row cm-fix-height">
                        <div class="form-group col-md-4">
                            <b>Upload File</b> 
                        </div>
                        <div class="form-group col-md-1">
                            <b>:</b> 
                        </div>
                        <div class="form-group col-md-7">
                            <input type="file" name="excel" class="btn btn-gray" required>
                        </div>
                    </div>
                    <div class="row cm-fix-height">
                        <div class="form-group col-md-4">
                            <b>Note</b> 
                        </div>
                        <div class="form-group col-md-1">
                            <b>:</b> 
                        </div>
                        <div class="form-group col-md-7">
                            <p class="note">
                                Format Excel harus CSV
                            </p>
                            <p class="note">
                                Layout di excel harus sama dengan layout di template
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="submit" name="submit" class="btn btn-danger metra-red" value="Submit" id="submit">
        </div>
    </form>
    <?php
}
?>