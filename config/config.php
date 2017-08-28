<?php

//$con = mysqli_connect("10.15.16.31", "lelang", "metra456", "lelang");
$con = mysqli_connect("118.97.63.84", "lelang", "metra456", "lelang");
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function tampil($nama_tabel, $field, $parameter) {
    global $con;
    $where = ($parameter == "") ? "" : " where " . $parameter;
    $query = "select " . $field . " from " . $nama_tabel . $where;
    if ($sql = mysqli_query($con, $query)) {
        // echo $sql;
        $hitung = mysqli_num_rows($sql);
        $post = array();
        while ($row = mysqli_fetch_row($sql)) {
            $post[] = $row;
        }
        $post[rowsnum] = $hitung;
        $post[query] = $query;
        return $post;
    }else{
        echo $post[msg] = 'Error: <i>' . $query . '</i> ' . mysqli_error($con);
    }
}

function insert($nama_tabel, $field, $value) {
    global $con;
    $query = "insert into " . $nama_tabel . " (" . $field . ") values (" . $value . ")";
    $post = array();
    if (mysqli_query($con, $query)) {
        $post[status] = true;
    } else {
        $post[status] = false;
        echo $post[msg] = 'Error: <i>' . $query . '</i> ' . mysqli_error($con);
    }
    $post[query] = $query;
    return $post;
}
function update($nama_tabel, $field, $parameter) {
    global $con;
    $query = "update $nama_tabel set $field where $parameter";
    $post = array();
    if (mysqli_query($con, $query)) {
        $post[status] = true;
    } else {
        $post[status] = false;
        echo $post[msg] = 'Error: <i>' . $query . '</i> ' . mysqli_error($con);
    }
    $post[query] = $query;
    return $post;
}
function indo($date){
	$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 
	/*$tahun = substr($date, 0, 4);
	$bulan = substr($date, 3, 2);
	$tgl   = substr($date, 5, 2);*/
 
        $date2 = explode('-', $date);
        $tahun = $date2[0];
        $bulan = $date2[1];
        $tgl = $date2[2];
	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;		
	return($result);
}
function generatePassword($length = 8) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}