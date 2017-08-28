<?php
session_start();
include '../config/config.php';
if (isset($_POST['submit'])) {
    $id_barang = $_POST['id_brg'];
    $delete = update('t_barang', 'active=0', "id_barang = '$id_barang'");
    $history = insert('t_history', 'id_barang,deskripsi,user_when,user_by', "'$id_barang','Barang berhasil dihapus',NOW(),'" . $_SESSION['email'] . "'");
    if ($delete[status] == true) {
        echo "<script type='text/javascript'>";
        echo "alert('Barang berhasil dihapus');";
        echo "location.href='../home.php';";
        echo "</script>";
    }
} else {
    $id_barang = $_GET['id'];
    ?>
    <form method="post" action="bid/bid_delete.php">
        <input type="hidden" name="id_brg" value="<?= $id_barang ?>">
        <div class="modal-body">
            <div class="row cm-fix-height center-block">
                <img src="assets/img/sf/sign-delete.svg"> <h4 style="margin: 0;display: inline-block" >Yakin menghapus barang ini?</h4>
            </div>
            <hr>
            <div class="row cm-fix-height">
                <div class="col-sm-1"></div>
                <button class="btn btn-default col-sm-4" data-dismiss="modal">Tidak</button>
                <div class="col-sm-2"></div>
                <input type="submit" name="submit" class="btn btn-danger metra-red col-sm-4" value="Ya">
                <div class="col-sm-1"></div>
            </div>
        </div>

    </form>
    <?php
}
?>
<script>
    $('body').on('hidden.bs.modal', '.modal', function () {
            $(this).removeData('bs.modal');
        });
        $('.modal').on('hidden.bs.modal', function () {
            $(this).find('input[type=text]').val('').end();
            
        });
</script>