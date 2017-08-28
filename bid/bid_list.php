<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-body">
            <?php
            $cd = tampil('t_barang', 'max(batas_waktu)', 'active = 1 and bid_flag =1');
            list($cnt) = $cd[0];
            //$format = explode(' ', $cnt);
            ?>
            <input type="hidden" id="cd" name="cd" value="<?= $cnt ?>">
            <input type="hidden" id="id" name="cd" value="<?= $cnt ?>">
            <h2 style="margin: 0;display: inline-block">List Barang | </h2><h3 style="display: inline-block"> Lelang berakhir : <span id="demo"></span></h3>


            <span class="pull-right" style="float: right">
                
                <?php
                if ($_SESSION['tipe'] != 'user') {
                    ?>
                    <a href="bid/bid_excel.php" data-target="#modal_excel" data-toggle="modal" class="btn btn-turquoise">Import CSV</a>
                    <a href="bid/bid_input.php" data-target="#modal_input" data-toggle="modal" class="btn btn-danger metra-red">+ Barang</a>

                    <?php
                }
                ?>
            </span>
            <br><br>
            <table id="listBarang" class="table table-bordered table-striped dataTable" style="max-width: 100%;display:block ;overflow-x: auto">
                <thead>
                    <tr>
                        <th width="5%" >No</th>
                        <th width="50%">Nama Barang</th>
                        <th width="15%">Harga Awal</th>
                        <th width="15%">Penawaran Tertinggi</th>
                        <th width="15%">Act</th>

                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------------------------------------------------>
<div id="modal_input" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<div id="loader"></div>-->
    <div class="modal-dialog modal-lg" id="input_barang">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div>
<div id="bid" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<div id="loader"></div>-->
    <div class="modal-dialog" id="bid">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div>
<div id="modal_excel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<div id="loader"></div>-->
    <div class="modal-dialog" id="modal_excel">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div>
<div id="modal_update" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<div id="loader"></div>-->
    <div class="modal-dialog modal-lg" id="modal_update">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div>
<div id="modal_delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<div id="loader"></div>-->
    <div class="modal-dialog modal-sm" id="modal_update">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div>

<script>
    var date_tgl = document.getElementById('cd').value;
    if (date_tgl !== '') {
        var pisah = date_tgl.split(" ");
        var tgl = pisah[0].split("-");
        var jam = pisah[1].split(":");
        countDownDate = new Date(tgl[0], tgl[1] - 1, tgl[2], jam[0], jam[1], jam[2]).getTime();
        var bw = new Date(tgl[0], tgl[1] - 1, tgl[2], jam[0], jam[1], jam[2]);
        //countDownDate = new Date('6 June 2017 12:00:00').getTime();
        //document.getElementById("demo").innerHTML
        var x = setInterval(function () {
            var now = new Date().getTime();
            var tgl = new Date();
            var distance = countDownDate - now;
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("demo").innerHTML = "<span style='color:red'>" + days + "</span>Hari <span style='color:red'>" + hours + "</span>Jam <span style='color:red'>" + minutes + "</span>Menit <span style='color:red'>" + seconds + "</span>Detik ";
            if (distance < 0) {
                clearInterval(x);
                //window.location.reload();
                document.getElementById("demo").innerHTML = "<span style='color:red'>0</span>Hari <span style='color:red'>0</span>Jam <span style='color:red'>0</span>Menit <span style='color:red'>0</span>Detik";
            }
            /* if (distance == 0) {
             clearInterval(x);
             window.location.reload();
             }*/
            if (distance < 0 && distance > -1000) {
                //clearInterval(x);
                window.location.reload();
            }
            //document.getElementById('cd').value = distance;
            //document.getElementById('id').value = tgl;
        }, 1000);
        /* if(countDownDate === new Date().getTime()){
         window.location.reload();
         }*/
        setInterval(function () {
            window.location.reload();
        }, 300000);

    }

    /*date_tgl = document.getElementById("batas_waktu'.$i.'").value;
     document.getElementById("coba'.$i.'").value = date_tgl;*/
</script>