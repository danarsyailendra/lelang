<div class="container-fluid">
    <div class="panel panel-default">
        <div class="panel-body">
            <h2 style="margin: 0;display: inline-block">User Administration</h2>
            <span class="pull-right" style="float: right">
                <a href="adm/adm_user_generate.php" class="btn btn-primary">Generate Password</a>
                <a href="adm/adm_user_reminder.php" class="btn btn-primary">Reminder User</a>
                <?php
                    if($_SESSION['tipe']=='developer'){
                ?>
                <a href="adm/adm_user_import.php" data-target="#user_import" data-toggle="modal" class="btn btn-turquoise">Import User</a>
                <?php
                    }
                ?>
            </span>
            <br><br>
            <table id="userList" class="table table-bordered table-striped dataTable" style="overflow: auto">
                <thead>
                    <tr>
                        <th width="5%" >No</th>
                        <th width="20%">Nama Lengkap</th>
                        <th width="20%">Email</th>
                        <th width="20%">Role</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------------------------------------------------------------>
<div id="user_import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<div id="loader"></div>-->
    <div class="modal-dialog" id="user_import">
        <div class="modal-content">
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->

</div>
<!--<div id="user_generate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--<div id="loader"></div>
    <div class="modal-dialog modal-sm" id="user_generate">
        <div class="modal-content">
        </div><!-- /.modal-content 
    </div><!-- /.modal-dialog 
</div>-->