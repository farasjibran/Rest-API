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
    header("Content-Type:application/json");
    echo json_encode($respons);
}

// function untuk tambah data
function insert_employe()
{
    global $connection;
    $data = json_decode(file_get_contents("php://input"), true);
    $employe_name = $data['employe_name'];
    $employe_salary = $data['employe_salary'];
    $employe_age = $data["employe_age"];
    $employe_mobile_number = $data["employe_mobile_number"];
    $employe_birthday = $data["employe_birthday"];
    $employe_addres = $data["employe_addres"];
    echo $querysql = "INSERT INTO `tb_employe` (`id`, `employe_name`, `employe_salary`, `employe_age`, `employe_mobile_number`, `employe_birthday`, `employe_addres`) VALUES (NULL, '$employe_name', '$employe_salary', ' $employe_age', '$employe_mobile_number', '$employe_birthday', '$employe_addres');";
    if (mysqli_query($connection, $querysql)) {
        $respons = array('status' => 1, 'status_message' => 'Employe Added Succesfully.');
    } else {
        $respons = array(
            'status' => 0,
            'status_message' => 'Employe Addition Failed.'
        );
    }
    header("Content-Type:application/json");
    echo json_encode($respons);
}

// function untuk update data
function update_employe($id)
{
    global $connection;
    $post_vars = json_decode(file_get_contents("php://input"), true);
    $employe_name = $post_vars['employe_name'];
    $employe_salary = $post_vars['employe_salary'];
    $employe_age = $post_vars["employe_age"];
    $employe_mobile_number = $post_vars["employe_mobile_number"];
    $employe_birthday = $post_vars["employe_birthday"];
    $employe_addres = $post_vars["employe_addres"];
    echo $querysql = "UPDATE `tb_employe` SET `employe_name` = '$employe_name', `employe_salary` = '$employe_salary', `employe_age` = '$employe_age', `employe_mobile_number` = '$employe_mobile_number', `employe_birthday` = '$employe_birthday', `employe_addres` = '$employe_addres' WHERE `tb_employe`.`id` = $id;";
    if (mysqli_query($connection, $querysql)) {
        $respons = array('status' => 1, 'status_message' => 'Employe Updated Successfully');
    } else {
        $respons = array('status' => 0, 'status_message' => 'Employe Updation Failed ');
    }
    header("Content-Type:application/json");
    echo json_encode($respons);
}

// function untuk delete data
function delete_employe($id)
{
    global $connection;
    echo $querysql = "DELETE FROM `tb_employe` WHERE `tb_employe`.`id` = $id";
    if (mysqli_query($connection, $querysql)) {
        $respons = array('status' => 1, 'status_message' => 'Employe Deleted Successfully');
    } else {
        $respons = array('status' => 0, 'status_message' => 'Employe Deletion Failed ');
    }
    header("Content-Type:application/json");
    echo json_encode($respons);
}

// disini untuk menggunakan method 
switch ($request_method) {
        // untuk method get (show)
    case 'GET':
        // cek apabila id sesuai dengan yang ada di db
        if (!empty($_GET["id"])) {
            get_karyawan(intval($_GET["id"]));
        } else {
            get_karyawan();
        }
        break;

        // untuk method post (tambah)
    case 'POST':

        insert_employe();
        break;

        // untuk method put
    case 'PUT':

        $id = intval($_GET["id"]);
        update_employe($id);
        break;

        // untuk method delete
    case 'DELETE':

        $id = intval($_GET["id"]);
        delete_employe($id);
        break;

    default:
        // invalid request method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
