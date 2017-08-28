<?php
session_start();
include '../config/config.php';
include '../mail/mail.class.php';

//if (isset($_POST['submit'])) {
    //$jabatan = $_POST['jabatan'];
    $tampil_email = tampil('p_user', 'email,nama', "");
    $success = 0;
    $error = 0;
    $email_error = '';
    for ($i = 0; $i < $tampil_email[rowsnum]; $i++) {
        $pass = generatePassword();
        $mail = send_mail($tampil_email[$i][0], '', 'support@metra.co.id', $pass, $tampil_email[$i][1]);
        if ($mail['STATUS'] == 'OK') {
            $update = update('p_user', "pass = '$pass'", "email = '" . $tampil_email[$i][0] . "'");
            if ($update[status] == true) {
                $success++;
            } else {
                $error++;
            }
        } else {
            $email_error .= $tampil_email[$i][0];
            $email_error .= ', ';
        }

        
    }
    echo "<script type='text/javascript'>";
        echo "alert('Generate Success');";
        echo "location.href='home.php?menu=3';";
        echo "</script>";
/*} else {
    ?>
    <form method="post" action="adm/adm_user_generate.php">
        <input type="hidden" name="id_brg" value="<?= $id_barang ?>">
        <div class="modal-body">
           
                Generate Password Untuk : 
            
           
                
                <div class="radio">
                    <label>
                        <input type="radio" name="jabatan" value="officer">Officer
                    </label>
                </div>
                <div class="radio">
                    <label>
                        <input type="radio" name="jabatan" value="non-officer">Non-Officer
                    </label>
                </div>
       
            <hr>
            <div class="row cm-fix-height">
                <div class="col-sm-1"></div>
                <button class="btn btn-default col-sm-4" data-dismiss="modal">Cancel</button>
                <div class="col-sm-2"></div>
                <input type="submit" name="submit" class="btn btn-danger metra-red col-sm-4" value="Submit">
                <div class="col-sm-1"></div>
            </div>
        </div>
    </form>

    <?php
}*/
?>