<?php
session_start();
include '../config/config.php';
//require '../config/excel_reader.php';

if (isset($_POST['submit'])) {
   /* $ftp_server = '118.97.63.84';
    $ftp_user = 'danar';
    $ftp_pass = 'metra123';

    $conn_id = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
    $login = ftp_login($conn_id, $ftp_user, $ftp_pass);

    ftp_chdir($conn_id, 'lelang/file');
    $destination_file = ftp_pwd($conn_id) . '/' . basename($_FILES['excel']['name']);
*/
    // tambahkan baris berikut untuk mencegah error is not readable
    $handle = fopen($_FILES['excel']['tmp_name'], "r");
    $row = 0;
    $success = 0;
    $error = 0;
    $row_error = '';
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if ($row != 0) {
            $email = $data[0];
            $nama = $data[1];
            $role = $data[2];
            $insert = insert("p_user", "email,nama,tipe_user", "'$email','$nama','$role'");
            
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
    echo "location.href='../home.php?menu=3';";
    echo "</script>";
} else {
    ?>
    <form method="post" action="adm/adm_user_import.php" enctype="multipart/form-data">
        <div class="modal-header metra-red header-modal-metra">
            <button type="button" class="close close-modal-metra" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            <h4 class="font-header-modal-metra">Import User</h4>
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
                            <a href="file/template_user.xls"><img src="assets/img/sf/file-excel.svg"></a>
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