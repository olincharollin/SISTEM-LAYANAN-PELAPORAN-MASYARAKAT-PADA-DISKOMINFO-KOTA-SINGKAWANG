<?php
include "../config.php";

header("Content-Type: application/json");

$data = mysqli_query($conn,"SELECT pengaduan.id, users.nama, kategori_pengaduan.nama_kategori,
                            pengaduan.judul, pengaduan.status, pengaduan.latitude, pengaduan.longitude, pengaduan.created_at
                            FROM pengaduan
                            JOIN users ON pengaduan.user_id = users.id
                            JOIN kategori_pengaduan ON pengaduan.kategori_id = kategori_pengaduan.id
                            ORDER BY pengaduan.id DESC");

$result = [];

while($row = mysqli_fetch_assoc($data)){
    $result[] = $row;
}

echo json_encode($result);
?>