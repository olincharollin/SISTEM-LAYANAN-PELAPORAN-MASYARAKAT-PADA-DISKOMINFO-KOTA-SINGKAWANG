<?php
$host = "127.0.0.1";
$user = "root";
$pass = "";
$db   = "pelayanan";
$port = 3307;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if(!$conn){
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>