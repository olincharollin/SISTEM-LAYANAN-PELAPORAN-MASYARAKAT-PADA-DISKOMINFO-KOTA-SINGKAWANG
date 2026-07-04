<?php
session_start();
include "../config.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

// ✅ PROSES BLOKIR / BUKA BLOKIR (SUDAH DISESUAIKAN DENGAN SISTEM LOG KAMU)
if(isset($_GET['aksi']) && isset($_GET['id'])){
    $id_user = $_GET['id'];
    $aksi = $_GET['aksi'];
    
    // Tentukan status baru
    $status_baru = ($aksi == 'blokir') ? 'blokir' : 'aktif';
    
    // Update ke database
    $ubah = mysqli_query($conn, "UPDATE users SET status = '$status_baru' WHERE id = '$id_user'");
    
    if($ubah){
        // ✅ CARA MENCATAT LOG SESUAI SISTEM KAMU (TANPA FUNGSI, LANGSUNG QUERY)
        $ambil_nama = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama FROM users WHERE id = '$id_user'"));
        
        // Tentukan teks aktivitas
        if($aksi == 'blokir'){
            $keterangan = "Memblokir pengguna: " . $ambil_nama['nama'];
        } else {
            $keterangan = "Membuka blokir pengguna: " . $ambil_nama['nama'];
        }

        // ✅ SIMPAN KE TABEL AUDIT_LOG (STRUKTUR SAMA PERSIS DENGAN FILE AUDIT LOG KAMU)
        // Menggunakan $_SESSION['id'] sebagai user_id (admin yang sedang login)
        mysqli_query($conn, "INSERT INTO audit_log (user_id, aktivitas, created_at) 
                             VALUES ('$_SESSION[id]', '$keterangan', NOW())");
        
        // Redirect kembali ke halaman
        header("Location: users.php?pesan=sukses");
        exit;
    }
}

$data = mysqli_query($conn,"SELECT * FROM users ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User - Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #1a4d6b;
            --primary-dark: #0e3a52;
            --primary-light: #2c6e8f;
            --success: #2d6a4f;
            --warning: #b8680c;
            --danger: #9d2a2a;
            --gray-bg: #f8fafc;
            --white: #ffffff;
            --text-dark: #1e2a3a;
            --text-muted: #6c7e8f;
            --border: #e9edf2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', sans-serif;
            background-image: url('../assets/bck.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
            position: relative;
            display: flex;
            flex-direction: column;
            /* ✅ Sesuai dengan style audit log kamu: ruang atas untuk topbar fixed */
            padding-top: 88px; 
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(248, 250, 252, 0.94);
            z-index: -1;
        }

        /* ✅ TOPBAR SESUAI GAYA AUDIT LOG KAMU: Fixed, Blur, Transparan */
        .top-nav {
            width: 100%;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed; 
            top: 0;
            left: 0;
            z-index: 999; 
            background: rgba(255, 255, 255, 0.95); 
            backdrop-filter: blur(8px); 
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(13,46,94,0.05);
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-img {
            height: 48px;
            width: auto;
        }

        .logo-text h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 0;
            line-height: 1.2;
        }

        .logo-text p {
            font-size: 11px;
            color: var(--text-muted);
            margin: 0;
        }

        .back-btn {
            background: var(--white);
            border: 1.5px solid var(--border);
            color: var(--primary);
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: all 0.2s;
        }

        .back-btn:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        /* ✅ Container & Card Sesuai Lebar Penuh Seperti Audit Log */
        .container-custom {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            flex: 1;
        }

        .card {
            background: var(--white);
            border: none;
            border-radius: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: all 0.3s;
            overflow: hidden;
            width: 100% !important;
            margin: 0 0 32px 0 !important;
        }

        .card:hover {
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.08);
        }

        .card-header-custom {
            padding: 24px 32px;
            border-bottom: 1px solid var(--border);
            background: var(--white);
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        .card-header-custom h4 {
            font-weight: 700;
            color: var(--text-dark);
            margin: 0;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header-custom p {
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 6px;
            margin-bottom: 0;
        }

        .card-body-custom {
            padding: 0;
            width: 100%;
        }

        /* ✅ Table Sesuai Gaya Audit Log */
        .table-container {
            overflow-x: auto;
            width: 100% !important;
        }

        .table-custom {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-custom thead th {
            background: var(--gray-bg);
            padding: 16px 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
        }

        .table-custom thead th:first-child,
        .table-custom thead th:last-child {
            border-radius: 0;
        }

        .table-custom tbody td {
            padding: 16px 20px;
            font-size: 14px;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        .table-custom tbody tr:hover td {
            background: var(--gray-bg);
        }

        /* ✅ Style Badge Status & Role */
        .role-badge, .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 40px;
            font-size: 12px;
            font-weight: 500;
        }

        .role-admin {
            background: #e8f0fe;
            color: var(--primary-light);
        }

        .role-user {
            background: #e6f4ea;
            color: var(--success);
        }

        .status-aktif {
            background: #d1fae5;
            color: #065f46;
        }
        .status-blokir {
            background: #fee2e2;
            color: #991b1b;
        }

        /* ✅ Tombol Aksi */
        .btn-aksi {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-blokir {
            background: #fee2e2;
            color: #991b1b;
        }
        .btn-blokir:hover {
            background: #991b1b;
            color: white;
        }
        .btn-buka {
            background: #e0e7ff;
            color: #3730a3;
        }
        .btn-buka:hover {
            background: #3730a3;
            color: white;
        }

        /* ✅ Notifikasi */
        .alert-sukses {
            background: #d1fae5;
            color: #065f46;
            padding: 12px 20px;
            border-radius: 0;
            margin: 0 0 16px 0;
            display: flex;
            align-items: center;
            gap: 8px;
            border-left: 4px solid #065f46;
            position: relative;
            z-index: 10;
        }

        /* ✅ Empty State */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state i {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        /* ✅ Footer Sesuai Audit Log */
        .footer {
            width: 100% !important;
            margin: 0;
            padding: 20px 24px;
            background: var(--white);
            border-radius: 0;
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
            border: none;
            border-top: 1px solid var(--border);
        }

        /* ✅ Responsive Sesuai Audit Log */
        @media (max-width: 768px) {
            body {
                padding-top: 120px; 
            }
            .top-nav {
                padding: 16px;
                flex-direction: column;
                gap: 12px;
                align-items: center;
            }
            .card-header-custom {
                padding: 20px;
                flex-direction: column;
                align-items: flex-start !important;
            }
            .table-custom thead th {
                padding: 12px 16px;
                font-size: 10px;
            }
            .table-custom tbody td {
                padding: 12px 16px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<!-- ✅ TOPBAR: SAMA PERSIS DENGAN HALAMAN AUDIT LOG -->
<div class="top-nav">
    <div class="logo-area">
        <img src="../assets/logo.jpg" alt="Logo Diskominfo" class="logo-img">
        <div class="logo-text">
            <h4>Diskominfo Singkawang</h4>
            <p>Admin Panel - Kelola Pengguna</p>
        </div>
    </div>

    <a href="dashboard.php" class="back-btn">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>

<div class="container-custom">

    <!-- ✅ NOTIFIKASI BERHASIL -->
    <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'sukses'){ ?>
    <div class="alert-sukses">
        <i class="fas fa-check-circle"></i>
        Status pengguna berhasil diubah dan tercatat di log aktivitas!
    </div>
    <?php } ?>

    <div class="card">
        <div class="card-header-custom">
            <h4>
                <i class="fas fa-users" style="color: var(--primary);"></i>
                Daftar Pengguna Sistem
            </h4>
            <p>Kelola status dan informasi akun pengguna</p>
        </div>
        <div class="card-body-custom">
            <div class="table-container">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Lengkap</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                            <th>Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if(mysqli_num_rows($data) > 0):
                            while($row = mysqli_fetch_assoc($data)): 
                                $role_class = ($row['role'] == 'admin') ? 'role-admin' : 'role-user';
                                $role_icon = ($row['role'] == 'admin') ? 'fa-shield-alt' : 'fa-user';
                                
                                // ✅ STATUS
                                $status_class = ($row['status'] == 'aktif') ? 'status-aktif' : 'status-blokir';
                                $status_text = ($row['status'] == 'aktif') ? 'Aktif' : 'Diblokir';
                                
                                // ✅ TOMBOL AKSI
                                if($row['role'] != 'admin'){ // Admin tidak bisa diblokir
                                    if($row['status'] == 'aktif'){
                                        $tombol = '<a href="users.php?aksi=blokir&id='.$row['id'].'" class="btn-aksi btn-blokir"><i class="fas fa-lock"></i> Blokir</a>';
                                    } else {
                                        $tombol = '<a href="users.php?aksi=buka_blokir&id='.$row['id'].'" class="btn-aksi btn-buka"><i class="fas fa-unlock"></i> Buka</a>';
                                    }
                                } else {
                                    $tombol = '<span class="text-muted">-</span>'; // Admin tidak ada tombol
                                }
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 32px; height: 32px; background: var(--gray-bg); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas <?= $role_icon ?>" style="font-size: 14px; color: var(--text-muted);"></i>
                                    </div>
                                    <?= htmlspecialchars($row['nama']) ?>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($row['username']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td>
                                <span class="role-badge <?= $role_class ?>">
                                    <i class="fas <?= $role_icon ?>"></i>
                                    <?= ucfirst($row['role']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="status-badge <?= $status_class ?>">
                                    <i class="fas <?= ($row['status'] == 'aktif') ? 'fa-check' : 'fa-ban' ?>"></i>
                                    <?= $status_text ?>
                                </span>
                            </td>
                            <td><?= $tombol ?></td>
                            <td style="color: var(--text-muted); font-size: 13px;">
                                <?= date('d/m/Y H:i', strtotime($row['created_at'])) ?>
                            </td>
                        </tr>
                        <?php 
                            endwhile;
                        else: 
                        ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-users-slash"></i>
                                    <p>Belum ada pengguna yang terdaftar</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ✅ FOOTER SESUAI AUDIT LOG -->
    <div class="footer">
        <span>© <?= date('Y') ?> Dinas Komunikasi dan Informatika Kota Singkawang</span>
        <span style="margin: 0 8px;">•</span>
        <span>Sistem Pelayanan Pengaduan Masyarakat</span>
        <span style="margin: 0 8px;">•</span>
        <span><i class="fas fa-shield-alt"></i> Halaman Admin</span>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>