<?php
session_start();
//date_default_timezone_set('America/Los_Angeles');
include 'config/config.php';
if (empty($_SESSION['email'])) {
    header("Location:http://" . $_SERVER['SERVER_NAME'] . "/lelang/");
} else {
    if ($_GET['menu'] == '') {
        $current_menu = '1';
    } else {
        $current_menu = $_GET['menu'];
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
            <link rel="stylesheet" type="text/css" href="assets/css/bootstrap-clearmin.min.css">
            <link rel="stylesheet" type="text/css" href="assets/css/roboto.css">
            <link rel="stylesheet" type="text/css" href="assets/css/material-design.css">
            <link rel="stylesheet" type="text/css" href="assets/css/small-n-flat.css">
            <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">

            <script src='assets/js/tinymce/tinymce.min.js'></script>
            <title>TelkomMetra | Lelang</title>
            <style>
                /* Center the loader */
                #loader {
                    position: absolute;
                    left: 50%;
                    top: 50%;
                    z-index: 1;
                    width: 150px;
                    height: 150px;
                    margin: -75px 0 0 -75px;
                    border: 16px solid #f3f3f3;
                    border-radius: 50%;
                    border-top: 16px solid #3498db;
                    width: 120px;
                    height: 120px;
                    -webkit-animation: spin 2s linear infinite;
                    animation: spin 2s linear infinite;
                }

                @-webkit-keyframes spin {
                    0% { -webkit-transform: rotate(0deg); }
                    100% { -webkit-transform: rotate(360deg); }
                }

                @keyframes spin {
                    0% { transform: rotate(0deg); }
                    100% { transform: rotate(360deg); }
                }

                /* Add animation to "page content" */


                @-webkit-keyframes animatebottom {
                    from { bottom:-100px; opacity:0 } 
                    to { bottom:0px; opacity:1 }
                }

                @keyframes animatebottom { 
                    from{ bottom:-100px; opacity:0 } 
                    to{ bottom:0; opacity:1 }
                }
                /*for pagination*/
                .pagination>.active>a,
                .pagination>.active>span,
                .pagination>.active>a:hover,
                .pagination>.active>span:hover,
                .pagination>.active>a:focus,
                .pagination>.active>span:focus{
                    z-index: 2;
                    color: #f9f9f9;
                    background-color: #ff6868;
                    border-color: #ff6868;
                    cursor: default;
                }
                .pagination>li>a:hover,
                .pagination>li>span:hover,
                .pagination>li>a:focus,
                .pagination>li>span:focus{
                    color: #c40000;
                    background-color: #eee;
                    border-color: #ddd;
                }
                .pagination>li>a, 
                .pagination>li>span{
                    position: relative;
                    float: left;
                    padding: 6px 12px;
                    line-height: 1.428571429;
                    text-decoration: none;
                    color: #ff6868;
                    background-color: #f9f9f9;
                    border: 1px solid #ddd;
                    margin-left: -1px;
                }
                .fileUpload {
                    position: relative;
                    overflow: hidden;
                    margin: 10px;
                }
            </style>
        </head>
        <style>
            .metra-red {background: #ff6868;border-color: #ff6868}
            .metra-white {background: #f9f9f9;border-color: #f9f9f9}
            .cm-menu-items li.metra-active a {box-shadow: inset 3px 0 0 #ff6868}
            .header-modal-metra{background: #ff6868;border-color: #ff6868;color: white;opacity: 1}
            .close-modal-metra{color: whitesmoke;opacity: 1}
            .font-header-modal-metra{color: whitesmoke}
            .metra-logo{display: block;height: 50px;background: url(assets/img/logo4.png) no-repeat 15px center transparent;}
            .note {color: #e53030}
            .code-green{color: #008e31;background-color: #f2fff6}
        </style>
        <body class="cm-no-transition cm-1-navbar">
            <div id="cm-menu">
                <nav class="cm-navbar cm-navbar-primary metra-red">
                    <div class="cm-flex metra-red"><a href="#" class="metra-logo"></a></div>
                    <div class="btn btn-danger metra-red md-menu-white" data-toggle="cm-menu"></div>
                </nav>
                <div id="cm-menu-content">
                    <div id="cm-menu-items-wrapper">
                        <div id="cm-menu-scroller">
                            <ul class="cm-menu-items">
                                <?php
                                $menu = tampil("p_user_type", "id_menu", "tipe_user = '" . $_SESSION['tipe'] . "'");
                                list($id_menu) = $menu[0];
                                //echo $id_menu;
                                $arr_id_menu = explode(',', $id_menu);
                                for ($i = 0; $i < count($arr_id_menu); $i++) {
                                    $list_menu = tampil("p_menu", "*", "id_menu = $arr_id_menu[$i]");
                                    list($menu_id, $nama_menu, $link, $icon) = $list_menu[0];
                                    //echo $file_name = basename(__FILE__);
                                    $cek = ($menu_id == $current_menu) ? 'active metra-active' : '';
                                    ?>
                                    <li class="<?= $cek ?>"><a href="home.php?menu=<?= $menu_id ?>" class="<?= $icon ?>"><?= $nama_menu ?></a></li>
                                    <?php
                                }
                                $select_menu = tampil("p_menu", "link,nama", "id_menu = $current_menu");
                                list($link, $nama_menu) = $select_menu[0];
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <header id="cm-header">
                <nav class="cm-navbar cm-navbar-primary metra-red">
                    <div class="btn btn-danger metra-red md-menu-white hidden-md hidden-lg" data-toggle="cm-menu"></div>
                    <div class="cm-flex metra-red">
                        <h1><?= $nama_menu ?> | <?= $_SESSION['name'] ?></h1> 
                    </div>

                    <div class=" dropdown pull-right metra-red">
                        <a href="logout.php" class="btn btn-danger metra-red  fa fa fa-fw fa-sign-out" title="Sign Out"></a>
                    </div>

                </nav>
            </header>
            <div id="global">

                <?php
                include $link;
                ?>

                <footer class="cm-footer"><span class="pull-left">Telkom Metra | Lelang Metra | Best Viewed In Google Chrome</span><span class="pull-right">&copy; Telkom Metra 2017</span></footer>
            </div>
            <script src="assets/js/lib/jquery-2.1.3.min.js"></script>
            <script src="assets/js/jquery.mousewheel.min.js"></script>
            <script src="assets/js/jquery.cookie.min.js"></script>
            <script src="assets/js/fastclick.min.js"></script>
            <script src="assets/js/bootstrap.min.js"></script>
            <script src="assets/js/clearmin.min.js"></script>
            <script src="assets/js/demo/home.js"></script>
            <script src="assets/js/jquery.dataTables.min.js"></script>
            <script src="assets/js/dataTables.bootstrap.js"></script>
            <script src="assets/js/demo/popovers-tooltips.js"></script>

            <script>
                
                $(document).ready(function () {
                    $('#listBarang').DataTable({
                        "cache": false,
                        "info": false,
                        "lengthChange": false,
                        "Processing": true,
                       "ServerSide": true,
                        "ajax": "bid/bid_list_act.php",
                        "pageLength": 10,
                        "dom": '<"top"if>rt<"bottom"p><"clear">'
                        
                    });


                });

                $(document).ready(function () {
                    $('#barangUser').DataTable({
                        "cache": false,
                        "info": false,
                        "lengthChange": false,
                        "Processing": true,
                        "ServerSide": true,
                        "ajax": "basket/basket_list_act.php",
                        "pageLength": 10,
                        "dom": '<"top"if>rt<"bottom"p><"clear">'
                    });


                });
                $(document).ready(function () {
                    $('#userList').DataTable({
                        "cache": false,
                        "info": false,
                        "lengthChange": false,
                        "Processing": true,
                        "ServerSide": true,
                        "ajax": "adm/adm_user_list_act.php",
                        "pageLength": 10,
                        "dom": '<"top"if>rt<"bottom"p><"clear">'
                    });


                });
                $(document).ready(function () {
                    $('#reportBarang').DataTable({
                        "cache": false,
                        "info": false,
                        "lengthChange": false,
                        "Processing": true,
                        "ServerSide": true,
                        "ajax": "report/report_list_act.php",
                        "pageLength": 10,
                        "dom": '<"top"if>rt<"bottom"p><"clear">'
                    });


                });

                function thousand_format(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }

            </script>
        </body>
    </html>
    <?php
}
?>