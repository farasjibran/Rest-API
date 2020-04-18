<?php
// mengambil koneksi
include('../koneksi.php');

// menyiapkan koneksi
$connection = getConnection();
$request_method = $_SERVER['REQUEST_METHOD'];

// function untuk get data employe
function get_karyawan($id = 0)
{
    global $connection;
    $querysql = "SELECT * FROM tb_employe";

    // if untuk mengambil per data employe
    if ($id != 0) {
        $querysql .= " WHERE tb_employe.id = $id;";
    }
    $respons = array();
    $result = mysqli_query($connection, $querysql);

    // looping data
    while ($row = mysqli_fetch_assoc($result)) {
        $respons[] = $row;
    }
    echo json_encode($respons);
}

// function untuk tambah data


// disini saya menggunakan method GET
switch ($request_method) {
        // untuk method get
    case 'GET':
        // cek apabila id sesuai dengan yang ada di db
        if (!empty($_GET["id"])) {
            get_karyawan(intval($_GET["id"]));
        } else {
            get_karyawan();
        }
        break;

        // untuk method post    
    case 'POST':

        insert_employes();
        break;

    default:
        // invalid request method
        // header("HTTP/1.0 405 Method Not Allowed");
        break;
}
