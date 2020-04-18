<?php
function getConnection()
{
    // koneksi database
    $dbhost = "127.0.0.1";
    $dbdatabase = "db_employe";
    $dbusername = "root";
    $dbpassword = "";
    $dbport = "3306";

    $conn = new mysqli($dbhost, $dbusername, $dbpassword, $dbdatabase, $dbport);
    // cek koneksi
    if ($conn->connect_error) {
        echo 'koneksi error ' . $conn->connect_error;
        header("location:v1/error.php");
    } else {
        return $conn;
    }
}
