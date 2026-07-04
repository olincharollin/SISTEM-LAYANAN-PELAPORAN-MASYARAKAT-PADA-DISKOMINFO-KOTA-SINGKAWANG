<?php
session_start();
include "../config.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

// Set header untuk unduh file Excel
header("Content-Type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data_pengaduan_".date('YmdHis').".xls");

// === HEADER KOLOM ===
echo "No\tID Pengaduan\tPelapor\tKategori\tJudul\tStatus\tTanggal Masuk\n";

// === QUERY: HANYA KOLOM YANG ADA DI DATABASE KAMU ===
$data = mysqli_query($conn,"SELECT 
                                pengaduan.id,
                                pengaduan.judul,
                                pengaduan.status,
                                pengaduan.created_at,
                                users.nama AS nama_user,
                                kategori_pengaduan.nama_kategori
                            FROM pengaduan
                            JOIN users ON pengaduan.user_id = users.id
                            JOIN kategori_pengaduan ON pengaduan.kategori_id = kategori_pengaduan.id
                            ORDER BY pengaduan.id DESC");

$no = 1;
while($row = mysqli_fetch_assoc($data)){

    // === UBAH KODE STATUS JADI TULISAN JELAS ===
    if($row['status'] == 'baru'){
        $status = "Baru";
    } elseif($row['status'] == 'diproses'){
        $status = "Sedang Diproses";
    } elseif($row['status'] == 'selesai'){
        $status = "Selesai";
    } elseif($row['status'] == 'ditolak'){
        $status = "Ditolak";
    } elseif($row['status'] == 'menunggu'){
        $status = "Menunggu";
    } else {
        $status = $row['status'];
    }

    // === PERBAIKAN TANGGAL: TAMBAH TANDA PETIK AGAR TIDAK JADI ######## ===
    $tanggal = " '".$row['created_at']."' ";

    // === TAMPILKAN DATA ===
    echo $no."\t";
    echo $row['id']."\t";
    echo $row['nama_user']."\t";
    echo $row['nama_kategori']."\t";
    echo $row['judul']."\t";
    echo $status."\t";
    echo $tanggal."\n";

    $no++;
}

// === PERBAIKAN LOG: HAPUS IP_ADDRESS KARENA TIDAK ADA DI DATABASE KAMU ===
// Cek dulu struktur tabel audit_log kamu, biasanya cuma butuh user_id dan aktivitas
$user_id = $_SESSION['id'];
mysqli_query($conn,"INSERT INTO audit_log (user_id, aktivitas)
                    VALUES ('$user_id','Export data pengaduan ke Excel')");
?>