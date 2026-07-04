<?php
session_start();
include "../config.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

$data = mysqli_query($conn,"SELECT audit_log.*, users.nama
                            FROM audit_log
                            LEFT JOIN users ON audit_log.user_id = users.id
                            ORDER BY audit_log.id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Audit Log - Sistem Pengaduan Masyarakat</title>

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
            width: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            /* ✅ JARAK DI ATAS AGAR TIDAK TERTIMPA TOPBAR */
            padding-top: 90px;
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

        /* ✅ TOPBAR - DIPERBAIKI POSISINYA */
        .top-nav {
            width: 100%;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            position: fixed; /* Tetap di atas */
            top: 0;
            left: 0;
            right: 0;
            z-index: 999; /* Paling atas */
            background: rgba(255, 255, 255, 0.95); /* Latar belakang jelas */
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(13,46,94,0.05);
        }

        @media (min-width: 768px) {
            .top-nav {
                padding: 16px 32px;
                flex-wrap: nowrap;
            }
            body {
                padding-top: 100px; /* Jarak lebih besar di layar besar */
            }
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
            min-width: 200px;
        }

        .logo-img {
            height: 42px;
            width: auto;
        }

        @media (min-width: 768px) {
            .logo-img {
                height: 48px;
            }
        }

        .logo-text h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--primary-dark);
            margin: 0;
            line-height: 1.2;
        }

        @media (min-width: 768px) {
            .logo-text h4 {
                font-size: 16px;
            }
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
            padding: 9px 16px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            transition: all 0.2s;
            white-space: nowrap;
        }

        .back-btn:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
            transform: translateY(-1px);
        }

        /* ✅ KONTEN UTAMA */
        .container-custom {
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 0 15px 20px 15px;
        }

        @media (min-width: 768px) {
            .container-custom {
                padding: 0 32px 32px 32px;
            }
        }

        /* ✅ CARD */
        .card {
            background: var(--white);
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: all 0.3s;
            overflow: hidden;
            width: 100%;
            margin-bottom: 20px;
        }

        @media (min-width: 768px) {
            .card {
                border-radius: 20px;
                margin-bottom: 28px;
            }
        }

        .card:hover {
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.08);
        }

        .card-header-custom {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--white);
        }

        @media (min-width: 768px) {
            .card-header-custom {
                padding: 24px 32px;
            }
        }

        .card-header-custom h4 {
            font-weight: 700;
            font-size: 16px;
            color: var(--text-dark);
            margin: 0;
            letter-spacing: -0.3px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @media (min-width: 768px) {
            .card-header-custom h4 {
                font-size: 18px;
            }
        }

        .card-header-custom p {
            color: var(--text-muted);
            font-size: 13px;
            margin-top: 6px;
            margin-bottom: 0;
        }

        @media (min-width: 768px) {
            .card-header-custom p {
                font-size: 14px;
            }
        }

        .card-body-custom {
            padding: 0;
            width: 100%;
        }

        /* ✅ TABEL - AMAN DI HP */
        .table-container {
            overflow-x: auto;
            width: 100%;
            -webkit-overflow-scrolling: touch;
        }

        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 700px; /* Lebar minimal agar rapi */
        }

        .table-custom thead th {
            background: var(--gray-bg);
            padding: 12px 10px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        @media (min-width: 768px) {
            .table-custom thead th {
                padding: 16px 20px;
                font-size: 12px;
            }
        }

        .table-custom tbody td {
            padding: 12px 10px;
            font-size: 13px;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;

-        }

        @media (min-width: 768px) {
            .table-custom tbody td {
                padding: 16px 20px;
                font-size: 14px;
            }
        }

        .table-custom tbody tr:hover td {
            background: var(--gray-bg);
        }

        /* ✅ BADGE / LABEL AKTIVITAS */
        .badge-activity {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 10px;
            border-radius: 40px;
            font-size: 11px;
            font-weight: 500;
            white-space: nowrap;
        }

        @media (min-width: 768px) {
            .badge-activity {
                padding: 5px 12px;
                font-size: 12px;
            }
        }

        .badge-login { background: #e6f4ea; color: var(--success); }
        .badge-pengaduan { background: #e8f0fe; color: var(--primary-light); }
        .badge-warning { background: #fef3e8; color: var(--warning); }
        .badge-default { background: var(--gray-bg); color: var(--text-muted); }

        /* ✅ KOSONG / TIDAK ADA DATA */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--text-muted);
        }

        @media (min-width: 768px) {
            .empty-state {
                padding: 60px 20px;
            }
        }

        .empty-state i {
            font-size: 40px;
            margin-bottom: 12px;
            opacity: 0.5;
        }

        @media (min-width: 768px) {
            .empty-state i {
                font-size: 48px;
                margin-bottom: 16px;
            }
        }

        /* ✅ FOOTER */
        .footer {
            width: 100%;
            margin: 0;
            padding: 15px 20px;
            background: var(--white);
            border-radius: 0;
            text-align: center;
            font-size: 11px;
            color: var(--text-muted);
            border-top: 1px solid var(--border);
            margin-top: 20px;
        }

        @media (min-width: 768px) {
            .footer {
                padding: 20px 24px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<!-- ✅ TOPBAR: TETAP DI ATAS, TIDAK MENUTUPI KONTEN -->
<div class="top-nav">
    <div class="logo-area">
        <img src="../assets/logo.jpg" alt="Logo Diskominfo" class="logo-img">
        <div class="logo-text">
            <h4>Diskominfo Singkawang</h4>
            <p>Admin Panel - Audit Log</p>
        </div>
    </div>

    <a href="dashboard.php" class="back-btn">
        <i class="fas fa-arrow-left"></i> <span class="d-none d-sm-inline">Kembali ke Dashboard</span>
        <span class="d-inline d-sm-none">Kembali</span>
    </a>
</div>

<div class="container-custom">

    <div class="card">
        <div class="card-header-custom">
            <h4>
                <i class="fas fa-history" style="color: var(--primary);"></i>
                Audit Log Sistem
            </h4>
            <p>Catatan aktivitas semua pengguna dalam sistem pelayanan pengaduan masyarakat</p>
        </div>
        <div class="card-body-custom">
            <div class="table-container">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Pengguna</th>
                            <th>Aktivitas</th>
                            <th style="width: 140px;">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        if(mysqli_num_rows($data) > 0){ 
                            while($row = mysqli_fetch_assoc($data)){ 
                                // Menentukan warna badge berdasarkan kata kunci
                                $badge_class = 'badge-default';
                                $icon = 'fa-info-circle';
                                $activity = strtolower($row['aktivitas']);
                                
                                if(strpos($activity, 'login') !== false || strpos($activity, 'masuk') !== false) {
                                    $badge_class = 'badge-login';
                                    $icon = 'fa-sign-in-alt';
                                } elseif(strpos($activity, 'pengaduan') !== false || strpos($activity, 'tanggapan') !== false || strpos($activity, 'laporan') !== false) {
                                    $badge_class = 'badge-pengaduan';
                                    $icon = 'fa-clipboard-list';
                                } elseif(strpos($activity, 'hapus') !== false || strpos($activity, 'delete') !== false || strpos($activity, 'gagal') !== false) {
                                    $badge_class = 'badge-warning';
                                    $icon = 'fa-exclamation-triangle';
                                }
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <div style="width: 28px; height: 28px; background: var(--gray-bg); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-user" style="font-size: 12px; color: var(--text-muted);"></i>
                                    </div>
                                    <span style="font-weight: 500; font-size: 13px;"><?= htmlspecialchars($row['nama'] ?? 'System / Tidak Diketahui') ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="badge-activity <?= $badge_class ?>">
                                    <i class="fas <?= $icon ?>"></i>
                                    <?= htmlspecialchars($row['aktivitas']) ?>
                                </span>
                            </td>
                            <td style="color: var(--text-muted); font-size: 12px;">
                                <i class="far fa-calendar-alt" style="margin-right: 4px;"></i>
                                <?= date('d/m/Y <br>H:i', strtotime($row['created_at'])) ?>
                            </td>
                        </tr>
                        <?php } 
                        } else { ?>
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="fas fa-clipboard-list"></i>
                                    <p>Belum ada aktivitas yang tercatat</p>
                                    <small>Catatan aktivitas pengguna akan muncul di sini</small>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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