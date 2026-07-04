<?php
session_start();
include "../config.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != "user"){
    header("Location: ../login.php");
    exit;
}

$data = mysqli_query($conn,"SELECT pengaduan.*, kategori_pengaduan.nama_kategori 
                            FROM pengaduan 
                            JOIN kategori_pengaduan ON pengaduan.kategori_id = kategori_pengaduan.id
                            WHERE user_id='$_SESSION[id]'
                            ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Riwayat Pengaduan — Diskominfo Singkawang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --blue:    #2563eb;
            --blue2:   #1d4ed8;
            --navy:    #0d2e5e;
            --sky:     #bfdbfe;
            --soft:    #eff6ff;
            --soft2:   #dbeafe;
            --gray:    #64748b;
        }

        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }

        /* ── GLOBAL BACKGROUND & LAYOUT ── */
        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            min-height: 100vh;
            background: url('../assets/bck.jpg') center center / cover no-repeat fixed;
            position: relative;
            width: 100%;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            /* ✅ JARAK DI ATAS AGAR TIDAK TERTIMPA TOPBAR */
            padding-top: 90px;
        }

        @media (min-width: 768px) {
            body {
                padding-top: 100px; /* Jarak lebih besar di layar besar */
            }
        }

        body::before {
            content: '';
            position: fixed; inset: 0; z-index: 0;
            background: linear-gradient(135deg,
                rgba(239,246,255,0.88) 0%,
                rgba(219,234,254,0.82) 50%,
                rgba(191,219,254,0.78) 100%
            );
            pointer-events: none;
        }

        /* ── TOPBAR DIPERBAIKI ── */
        .top-nav {
            width: 100%;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            position: fixed; /* ✅ Tetap diam di atas */
            top: 0;
            left: 0;
            right: 0;
            z-index: 999; /* ✅ Paling atas */
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(37,99,235,0.1);
            box-shadow: 0 2px 12px rgba(13,46,94,0.06);
        }

        @media (min-width: 768px) {
            .top-nav {
                padding: 20px 32px;
                flex-wrap: nowrap;
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
                height: 50px;
            }
        }

        .logo-text h4 {
            font-size: 14px;
            font-weight: 700;
            color: var(--navy);
            margin: 0;
            line-height: 1.2;
        }

        @media (min-width: 768px) {
            .logo-text h4 {
                font-size: 15px;
            }
        }

        .logo-text p {
            font-size: 10px;
            color: var(--gray);
            margin: 0;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(8px);
            border: 1.5px solid rgba(37,99,235,0.1);
            color: var(--blue);
            padding: 9px 16px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 14px rgba(13,46,94,0.08);
            transition: all 0.2s;
            white-space: nowrap;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, var(--blue), var(--blue2));
            color: #fff;
            border-color: var(--blue);
            transform: translateY(-1px);
        }

        /* ── CONTAINER UTAMA ── */
        .container-custom {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 15px 20px 15px !important;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        @media (min-width: 768px) {
            .container-custom {
                padding: 0 32px 32px 32px !important;
            }
        }

        /* ── CARD & TABLE ── */
        .card {
            border: none;
            border-radius: 14px;
            margin-bottom: 20px;
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(8px);
            box-shadow: 0 2px 14px rgba(13,46,94,0.08);
            border: 1px solid rgba(37,99,235,0.1);
            overflow: hidden;
            width: 100%;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(37,99,235,0.15);
            padding: 16px 20px;
            font-weight: 800;
            color: var(--navy);
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @media (min-width: 768px) {
            .card-header {
                padding: 20px 24px;
                font-size: 1rem;
            }
        }

        .card-body {
            padding: 0;
            width: 100%;
            overflow-x: auto; /* ✅ Bisa geser ke samping di HP */
            -webkit-overflow-scrolling: touch;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 750px; /* ✅ Lebar minimal agar rapi */
        }

        .table th {
            background: var(--soft);
            color: var(--navy);
            font-weight: 700;
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 10px;
            border: none;
            border-bottom: 2px solid var(--sky);
            white-space: nowrap;
        }

        @media (min-width: 768px) {
            .table th {
                padding: 16px;
                font-size: 0.78rem;
            }
        }

        .table th:first-child { border-radius: 14px 0 0 0; }
        .table th:last-child { border-radius: 0 14px 0 0; }

        .table td {
            padding: 12px 10px;
            font-size: 0.82rem;
            color: var(--navy);
            border: none;
            border-bottom: 1px solid var(--soft2);
            vertical-align: middle;
            background: rgba(255,255,255,0.3);
        }

        @media (min-width: 768px) {
            .table td {
                padding: 16px;
                font-size: 0.88rem;
            }
        }

        .table tr:hover td {
            background: rgba(37,99,235,0.05);
        }

        /* Status Badge */
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            white-space: nowrap;
        }

        @media (min-width: 768px) {
            .status-badge {
                padding: 6px 12px;
                font-size: 0.75rem;
            }
        }

        .status-menunggu { background: #fef3c7; color: #92400e; }
        .status-proses  { background: #dbeafe; color: #1e40af; }
        .status-selesai { background: #d1fae5; color: #065f46; }
        .status-tolak   { background: #fecaca; color: #991b1b; }

        /* Tombol Detail */
        .btn-detail {
            background: var(--soft);
            color: var(--navy) !important;
            border: 1px solid var(--sky);
            border-radius: 8px;
            font-size: 0.72rem;
            padding: 5px 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
        }

        @media (min-width: 768px) {
            .btn-detail {
                font-size: 0.78rem;
                padding: 6px 12px;
            }
        }

        .btn-detail:hover {
            background: var(--soft2);
            color: var(--navy);
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(13,46,94,0.1);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: var(--gray);
        }

        @media (min-width: 768px) {
            .empty-state {
                padding: 60px 20px;
            }
        }

        .empty-state i {
            font-size: 40px;
            margin-bottom: 12px;
            opacity: 0.4;
        }

        @media (min-width: 768px) {
            .empty-state i {
                font-size: 48px;
                margin-bottom: 16px;
            }
        }

        /* ── FOOTER ── */
        .footer {
            text-align: center;
            font-size: 0.7rem;
            color: var(--gray);
            padding: 15px 0;
            position: relative;
            z-index: 2;
            width: 100%;
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(4px);
            border-top: 1px solid rgba(37,99,235,0.08);
            margin-top: auto;
        }

        @media (min-width: 768px) {
            .footer {
                font-size: 0.72rem;
                padding: 20px 0;
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
            <p>Sistem Pengaduan Masyarakat</p>
        </div>
    </div>

    <a href="dashboard.php" class="back-btn">
        <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Kembali ke Dashboard</span>
        <span class="d-inline d-sm-none">Kembali</span>
    </a>
</div>

<div class="container-custom">

    <div class="card">
        <div class="card-header">
            <i class="bi bi-clock-history"></i>
            Riwayat Pengaduan Saya
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Kategori</th>
                        <th>Judul</th>
                        <th style="width: 120px;">Status</th>
                        <th style="width: 140px;">Tanggal</th>
                        <th style="width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; if(mysqli_num_rows($data) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($data)){ ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                        <td>
                            <div style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                <?= htmlspecialchars($row['judul']) ?>
                            </div>
                        </td>
                        <td class="text-center">
                            <?php 
                                $statusClass = 'status-menunggu';
                                if($row['status'] == 'Diproses') $statusClass = 'status-proses';
                                if($row['status'] == 'Selesai') $statusClass = 'status-selesai';
                                if($row['status'] == 'Ditolak') $statusClass = 'status-tolak';
                            ?>
                            <span class="status-badge <?= $statusClass ?>">
                                <?= $row['status'] ?>
                            </span>
                        </td>
                        <td class="text-center" style="font-size: 0.75rem;">
                            <?= date('d/m/Y<br>H:i', strtotime($row['created_at'])) ?>
                        </td>
                        <td class="text-center">
                            <a href="detail.php?id=<?= $row['id'] ?>" class="btn-detail">
                                <i class="bi bi-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                    <?php else: ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <p>Belum ada pengaduan yang dikirim</p>
                                <small>Silakan buat pengaduan baru</small>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- FOOTER -->
<div class="footer">
    &copy; <?= date('Y') ?> Dinas Komunikasi dan Informatika Kota Singkawang — Sistem Pelayanan Pengaduan Masyarakat
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>