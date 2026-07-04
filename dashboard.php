<?php
session_start();
include "../config.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

// Statistik Utama
$total     = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM pengaduan"));
$menunggu  = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM pengaduan WHERE status='Menunggu'"));
$proses    = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM pengaduan WHERE status='Diproses'"));
$selesai   = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM pengaduan WHERE status='Selesai'"));
$ditolak   = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM pengaduan WHERE status='Ditolak'"));
$totalUser = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM users WHERE role='user'"));

/* ======================
   GRAFIK 14 HARI TERAKHIR
====================== */
$grafikQuery = mysqli_query($conn,"
    SELECT DATE(created_at) AS tanggal, COUNT(*) AS jumlah
    FROM pengaduan
    GROUP BY DATE(created_at)
    ORDER BY tanggal DESC
    LIMIT 14
");

$tanggal = [];
$jumlah  = [];
$rows    = [];

if($grafikQuery && mysqli_num_rows($grafikQuery) > 0){
    while($row = mysqli_fetch_assoc($grafikQuery)){
        $rows[] = $row;
    }
    $rows = array_reverse($rows);
    foreach($rows as $row){
        $tanggal[] = date("d/m", strtotime($row['tanggal']));
        $jumlah[]  = (int)$row['jumlah'];
    }
}

/* ======================
   KATEGORI TERBANYAK
====================== */
$kategoriQuery = mysqli_query($conn,"
    SELECT k.nama_kategori, COUNT(p.id) AS jumlah
    FROM pengaduan p
    JOIN kategori_pengaduan k ON p.kategori_id = k.id
    GROUP BY p.kategori_id, k.nama_kategori
    ORDER BY jumlah DESC
    LIMIT 6
");

$katLabel = [];
$katData  = [];

if($kategoriQuery && mysqli_num_rows($kategoriQuery) > 0){
    while($row = mysqli_fetch_assoc($kategoriQuery)){
        $katLabel[] = $row['nama_kategori'];
        $katData[]  = (int)$row['jumlah'];
    }
}

/* ======================
   LOKASI TERBANYAK -> MENGGUNAKAN KOLOM `nama_lokasi` (SESUAI DATABASE)
====================== */
$lokasiQuery = mysqli_query($conn,"
    SELECT nama_lokasi, COUNT(*) AS jumlah
    FROM pengaduan
    WHERE nama_lokasi IS NOT NULL AND nama_lokasi != '' AND nama_lokasi != 'Tidak diketahui'
    GROUP BY nama_lokasi
    ORDER BY jumlah DESC
    LIMIT 8
");

$lokasiRows = [];
if($lokasiQuery && mysqli_num_rows($lokasiQuery) > 0){
    while($row = mysqli_fetch_assoc($lokasiQuery)){
        $lokasiRows[] = $row;
    }
}

/* ======================
   LAPORAN TERBARU
====================== */
$laporanTerbaru = mysqli_query($conn,"
    SELECT p.*, k.nama_kategori, u.nama AS nama_user
    FROM pengaduan p
    LEFT JOIN kategori_pengaduan k ON p.kategori_id = k.id
    LEFT JOIN users u ON p.user_id = u.id
    ORDER BY p.id DESC
    LIMIT 6
");

/* ======================
   AUDIT TERBARU -> TANPA IP
====================== */
$auditTerbaru = mysqli_query($conn,"
    SELECT a.id, a.aktivitas, a.created_at, u.nama
    FROM audit_log a
    JOIN users u ON a.user_id = u.id
    ORDER BY a.id DESC
    LIMIT 5
");

$bulanIni = mysqli_num_rows(mysqli_query($conn,"
    SELECT id FROM pengaduan 
    WHERE MONTH(created_at) = MONTH(NOW()) 
      AND YEAR(created_at) = YEAR(NOW())
"));
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Dashboard Admin — Diskominfo Singkawang</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
:root {
    --blue:    #2563eb;
    --blue2:   #1d4ed8;
    --navy:    #0d2e5e;
    --sky:     #bfdbfe;
    --soft:    #eff6ff;
    --soft2:   #dbeafe;
    --sidebar: rgba(13,46,94,0.96);
    --white:   #ffffff;
    --gray:    #64748b;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
    min-height: 100vh;
    background: url('../assets/bck.jpg') center center / cover no-repeat fixed;
    position: relative;
    overflow-x: hidden;
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

/* ==========================================
   SIDEBAR - RESPONSIF
========================================== */
.sidebar {
    width: 240px; height: 100vh;
    position: fixed; top: 0; left: 0; z-index: 1050;
    background: var(--sidebar);
    backdrop-filter: blur(16px);
    display: flex; flex-direction: column;
    border-right: 1px solid rgba(255,255,255,0.08);
    box-shadow: 4px 0 24px rgba(13,46,94,0.2);
    transition: all 0.3s ease;
}

/* Sidebar Tertutup di HP */
@media (max-width: 767.98px) {
    .sidebar {
        transform: translateX(-100%);
        width: 260px;
    }
    .sidebar.show {
        transform: translateX(0);
    }
    .content {
        margin-left: 0 !important;
        width: 100%;
    }
}

.sidebar-brand {
    padding: 20px 18px 16px;
    border-bottom: 1px solid rgba(255,255,255,.08);
}
.sidebar-brand .title { color: #fff; font-weight: 800; font-size: .95rem; }
.sidebar-brand .sub   { color: rgba(255,255,255,.4); font-size: .7rem; margin-top: 2px; }

.sidebar-menu { padding: 14px 10px; flex: 1; overflow-y: auto; }
.sidebar-menu a {
    display: flex; align-items: center; gap: 9px;
    padding: 10px 12px; border-radius: 9px;
    text-decoration: none; font-size: .84rem; font-weight: 500;
    color: rgba(255,255,255,.55); margin-bottom: 2px;
    transition: .2s;
}
.sidebar-menu a:hover  { background: rgba(255,255,255,.08); color: #fff; }
.sidebar-menu a.active {
    background: linear-gradient(135deg, var(--blue), var(--blue2));
    color: #fff; font-weight: 700;
    box-shadow: 0 4px 12px rgba(37,99,235,.35);
}
.sidebar-menu a i      { font-size: 1rem; width: 18px; text-align: center; }
.sidebar-menu .menu-group {
    font-size: .67rem; font-weight: 700; letter-spacing: .07em;
    color: rgba(255,255,255,.22); text-transform: uppercase;
    padding: 14px 12px 4px;
}
.sidebar-bottom { padding: 12px 10px; border-top: 1px solid rgba(255,255,255,.08); }
.sidebar-bottom a {
    display: flex; align-items: center; gap: 9px;
    padding: 10px 12px; border-radius: 9px;
    text-decoration: none; font-size: .84rem;
    color: #fca5a5; transition: .2s;
}
.sidebar-bottom a:hover { background: rgba(248,113,113,.12); color: #fff; }

/* Overlay saat sidebar terbuka di HP */
.sidebar-overlay {
    position: fixed; top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.5); z-index: 1040;
    display: none;
}
.sidebar-overlay.show { display: block; }

/* ==========================================
   KONTEN UTAMA
========================================== */
.content { 
    margin-left: 240px; 
    padding: 15px; 
    min-height: 100vh; 
    position: relative; 
    z-index: 1; 
    transition: margin-left 0.3s ease;
}
@media (min-width: 768px) and (max-width: 991.98px) {
    .content { padding: 20px; }
}
@media (min-width: 992px) {
    .content { padding: 24px; }
}

/* Tombol Buka Sidebar (Hanya di HP)
========================================== */
.toggle-sidebar {
    display: none;
    position: fixed;
    top: 15px;
    left: 15px;
    z-index: 1030;
    background: rgba(255,255,255,0.9);
    border: none;
    border-radius: 8px;
    width: 40px;
    height: 40px;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: var(--navy);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
@media (max-width: 767.98px) {
    .toggle-sidebar { display: flex; }
}

/* ==========================================
   TOPBAR
========================================== */
.topbar {
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(10px);
    border-radius: 14px;
    padding: 14px 20px;
    display: flex; 
    flex-wrap: wrap;
    justify-content: space-between; 
    align-items: center;
    box-shadow: 0 2px 16px rgba(13,46,94,.08);
    border: 1px solid rgba(37,99,235,.1);
    margin-bottom: 22px;
    margin-top: 50px; /* Beri jarak untuk tombol menu di HP */
}
@media (min-width: 768px) {
    .topbar { margin-top: 0; }
}
.topbar h5 { margin: 0; font-weight: 800; font-size: 1rem; color: var(--navy); }
.topbar .sub { font-size: .78rem; color: var(--gray); margin-top: 2px; }
.topbar .badge-time {
    background: var(--soft2); color: var(--blue);
    border-radius: 20px; padding: 5px 14px;
    font-size: .78rem; font-weight: 700;
    border: 1px solid var(--sky);
    margin-top: 8px;
}
@media (min-width: 576px) {
    .topbar .badge-time { margin-top: 0; }
}

/* ==========================================
   KARTU STATISTIK
========================================== */
.stat-card {
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(8px);
    border-radius: 14px; padding: 16px 18px;
    box-shadow: 0 2px 14px rgba(13,46,94,.08);
    border: 1px solid rgba(37,99,235,.1);
    border-left: 4px solid transparent;
    transition: transform .2s, box-shadow .2s;
    height: 100%;
}
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(13,46,94,.12); }
.stat-card .val  { font-size: 1.8rem; font-weight: 800; color: var(--navy); line-height: 1; }
.stat-card .lbl  { font-size: .75rem; color: var(--gray); margin-top: 4px; }
.stat-card .icon { font-size: 1.4rem; }
.stat-card.blue   { border-left-color: var(--blue); }
.stat-card.yellow { border-left-color: #f59e0b; }
.stat-card.sky    { border-left-color: #06b6d4; }
.stat-card.green  { border-left-color: #10b981; }
.stat-card.red    { border-left-color: #ef4444; }
.stat-card.purple { border-left-color: #8b5cf6; }

/* ==========================================
   KOTAK / BOX KOMPONEN
========================================== */
.box {
    background: rgba(255,255,255,0.88);
    backdrop-filter: blur(8px);
    border-radius: 14px; padding: 18px 20px;
    box-shadow: 0 2px 14px rgba(13,46,94,.08);
    border: 1px solid rgba(37,99,235,.1);
    margin-bottom: 20px;
    height: 100%;
}
.box-title {
    font-size: .88rem; font-weight: 800; color: var(--navy);
    margin-bottom: 14px; display: flex; align-items: center; gap: 7px;
}
.box-title i { color: var(--blue); }

/* ==========================================
   TABEL & KOMPONEN LAIN
========================================== */
.table-responsive {
    border-radius: 8px;
    overflow-x: auto; /* Bisa geser tabel ke samping di HP */
    -webkit-overflow-scrolling: touch;
}
.table thead th {
    background: var(--soft); font-size: .76rem;
    font-weight: 700; color: var(--navy);
    border-bottom: 2px solid var(--soft2); white-space: nowrap;
}
.table tbody td { font-size: .82rem; color: #374151; vertical-align: middle; }
.table-hover tbody tr:hover td { background: rgba(239,246,255,.6); }

/* Badge Status */
.badge-status { padding: 3px 10px; border-radius: 20px; font-size: .71rem; font-weight: 700; white-space: nowrap; }
.s-menunggu { background: #fef3c7; color: #92400e; }
.s-diproses { background: var(--soft2); color: #1e40af; }
.s-selesai  { background: #d1fae5; color: #065f46; }
.s-ditolak  { background: #fee2e2; color: #991b1b; }

/* Lokasi Row */
.lokasi-row { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid var(--soft); font-size: .82rem; flex-wrap: wrap; }
.lokasi-row:last-child { border-bottom: none; }
.lokasi-rank { width: 24px; height: 24px; border-radius: 50%; background: var(--blue); color: #fff; font-size: .68rem; font-weight: 800; display: grid; place-items: center; flex-shrink: 0; }
.lokasi-rank.gold   { background: #f59e0b; }
.lokasi-rank.silver { background: #94a3b8; }
.lokasi-rank.bronze { background: #b45309; }
.lokasi-name { flex: 1 1 150px; color: #374151; font-weight: 500; }
.lokasi-bar-wrap { width: 80px; background: var(--soft2); border-radius: 4px; height: 6px; flex-shrink: 0; }
.lokasi-bar { height: 6px; border-radius: 4px; background: linear-gradient(90deg, var(--blue), #60a5fa); }
.lokasi-count { font-weight: 700; color: var(--blue); min-width: 24px; text-align: right; flex-shrink: 0; }

/* Quick Button */
.quick-btn {
    display: flex; flex-direction: column; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.82); border: 1.5px solid var(--soft2);
    border-radius: 12px; padding: 14px 10px;
    text-decoration: none; color: var(--blue);
    font-size: .77rem; font-weight: 700;
    transition: .2s; flex: 1; min-width: 90px;
    backdrop-filter: blur(4px);
}
.quick-btn i { font-size: 1.35rem; }
.quick-btn:hover {
    background: linear-gradient(135deg, var(--blue), var(--blue2));
    color: #fff; border-color: var(--blue);
    box-shadow: 0 4px 14px rgba(37,99,235,.3);
    transform: translateY(-2px);
}

.footer { text-align: center; font-size: .74rem; color: var(--gray); padding: 20px 0 8px; }

/* Grafik Responsif */
canvas { max-width: 100% !important; }
</style>
</head>
<body>

<!-- Tombol Buka Menu (Hanya HP) -->
<button class="toggle-sidebar" id="toggleSidebar">
    <i class="bi bi-list"></i>
</button>

<!-- Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="title"><i class="bi bi-broadcast me-1"></i> Diskominfo</div>
        <div class="sub">Kota Singkawang</div>
    </div>
    <div class="sidebar-menu">
        <div class="menu-group">Menu Utama</div>
        <a href="dashboard.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="laporan.php"><i class="bi bi-file-earmark-text"></i> Kelola Laporan</a>
        <a href="users.php"><i class="bi bi-people"></i> Kelola User</a>
        <div class="menu-group">Lainnya</div>
        <a href="nomor_darurat.php"><i class="bi bi-telephone-fill"></i> Nomor Darurat</a>
        <a href="audit.php"><i class="bi bi-shield-check"></i> Audit Log</a>
        <a href="export_excel.php"><i class="bi bi-file-earmark-excel"></i> Export Excel</a>
    </div>
    <div class="sidebar-bottom">
        <a href="../logout.php"><i class="bi bi-box-arrow-left"></i> Logout</a>
    </div>
</div>

<!-- Konten Utama -->
<div class="content">

    <div class="topbar">
        <div>
            <h5><i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard Admin</h5>
            <div class="sub">
                Selamat datang,
                <b><?= htmlspecialchars($_SESSION['nama'] ?? $_SESSION['username'] ?? 'Admin') ?></b>
                — Monitoring pengaduan masyarakat
            </div>
        </div>
        <div class="badge-time">
            <i class="bi bi-calendar3 me-1"></i><?= date("d M Y") ?>
        </div>
    </div>

    <!-- Kartu Statistik -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-sm-4 col-md-4 col-lg-2 col-xxl-2">
            <div class="stat-card blue">
                <div class="d-flex justify-content-between align-items-start">
                    <div><div class="val"><?= $total ?></div><div class="lbl">Total Laporan</div></div>
                    <i class="bi bi-inbox-fill icon text-primary"></i>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-md-4 col-lg-2 col-xxl-2">
            <div class="stat-card yellow">
                <div class="d-flex justify-content-between align-items-start">
                    <div><div class="val"><?= $menunggu ?></div><div class="lbl">Menunggu</div></div>
                    <i class="bi bi-hourglass-split icon text-warning"></i>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-md-4 col-lg-2 col-xxl-2">
            <div class="stat-card sky">
                <div class="d-flex justify-content-between align-items-start">
                    <div><div class="val"><?= $proses ?></div><div class="lbl">Diproses</div></div>
                    <i class="bi bi-arrow-repeat icon text-info"></i>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-md-4 col-lg-2 col-xxl-2">
            <div class="stat-card green">
                <div class="d-flex justify-content-between align-items-start">
                    <div><div class="val"><?= $selesai ?></div><div class="lbl">Selesai</div></div>
                    <i class="bi bi-check-circle-fill icon text-success"></i>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-md-4 col-lg-2 col-xxl-2">
            <div class="stat-card red">
                <div class="d-flex justify-content-between align-items-start">
                    <div><div class="val"><?= $ditolak ?></div><div class="lbl">Ditolak</div></div>
                    <i class="bi bi-x-circle-fill icon text-danger"></i>
                </div>
            </div>
        </div>

        <div class="col-6 col-sm-4 col-md-4 col-lg-2 col-xxl-2">
            <div class="stat-card purple">
                <div class="d-flex justify-content-between align-items-start">
                    <div><div class="val"><?= $totalUser ?></div><div class="lbl">Jumlah User</div></div>
                    <i class="bi bi-people-fill icon" style="color:#8b5cf6;font-size:1.4rem"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Akses Cepat -->
    <div class="box mb-4">
        <div class="box-title"><i class="bi bi-lightning-fill"></i> Akses Cepat</div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="laporan.php" class="quick-btn"><i class="bi bi-file-earmark-text"></i>Kelola Laporan</a>
            <a href="laporan.php?status=Menunggu" class="quick-btn"><i class="bi bi-hourglass-split"></i>Belum Diproses</a>
            <a href="users.php" class="quick-btn"><i class="bi bi-people"></i>Kelola User</a>
            <a href="nomor_darurat.php" class="quick-btn"><i class="bi bi-telephone-fill"></i>No. Darurat</a>
            <a href="export_excel.php" class="quick-btn"><i class="bi bi-file-earmark-excel"></i>Export Excel</a>
            <a href="audit.php" class="quick-btn"><i class="bi bi-shield-check"></i>Audit Log</a>
        </div>
    </div>

    <!-- Grafik Baris 1 -->
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="box">
                <div class="box-title"><i class="bi bi-graph-up"></i> Tren Pengaduan (14 Hari Terakhir)</div>
                <canvas id="chartHarian" height="110"></canvas>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="box">
                <div class="box-title"><i class="bi bi-pie-chart-fill"></i> Distribusi Status</div>
                <canvas id="chartStatus"></canvas>
                <div class="mt-3" style="font-size:.75rem">
                    <?php
                    $statusList = [
                        ['Menunggu', $menunggu, '#f59e0b'],
                        ['Diproses', $proses,   '#06b6d4'],
                        ['Selesai',  $selesai,  '#10b981'],
                        ['Ditolak',  $ditolak,  '#ef4444'],
                    ];
                    foreach($statusList as $s): ?>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span>
                            <span style="display:inline-block;width:10px;height:10px;border-radius:3px;background:<?= $s[2] ?>;margin-right:6px"></span>
                            <?= $s[0] ?>
                        </span>
                        <b style="color:var(--navy)"><?= $s[1] ?></b>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Baris 2 -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="box">
                <div class="box-title"><i class="bi bi-bar-chart-fill"></i> Jenis Laporan Terbanyak</div>
                <?php if(!empty($katLabel)): ?>
                <canvas id="chartKategori" height="200"></canvas>
                <div class="mt-3">
                    <?php foreach($katLabel as $i => $k): ?>
                    <div class="d-flex justify-content-between align-items-center mb-1" style="font-size:.77rem">
                        <span style="color:#374151"><?= htmlspecialchars($k) ?></span>
                        <span class="fw-bold" style="color:var(--blue)"><?= $katData[$i] ?> laporan</span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p class="text-muted text-center py-3" style="font-size:.85rem">Belum ada data kategori.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box">
                <div class="box-title"><i class="bi bi-geo-alt-fill"></i> Lokasi Paling Banyak Laporan</div>

                <?php if(!empty($lokasiRows)):
                    $maxLok = $lokasiRows[0]['jumlah'];
                    foreach($lokasiRows as $i => $lok):
                        $rankClass = $i == 0 ? 'gold' : ($i == 1 ? 'silver' : ($i == 2 ? 'bronze' : ''));
                        $pct = $maxLok > 0 ? round(($lok['jumlah'] / $maxLok) * 100) : 0;
                        $namaLok = strlen($lok['nama_lokasi']) > 55 ? substr($lok['nama_lokasi'], 0, 55).'...' : $lok['nama_lokasi'];
                ?>
                <div class="lokasi-row">
                    <div class="lokasi-rank <?= $rankClass ?>"><?= $i+1 ?></div>
                    <div class="lokasi-name" title="<?= htmlspecialchars($lok['nama_lokasi']) ?>"><?= htmlspecialchars($namaLok) ?></div>
                    <div class="lokasi-bar-wrap"><div class="lokasi-bar" style="width:<?= $pct ?>%"></div></div>
                    <div class="lokasi-count"><?= $lok['jumlah'] ?></div>
                </div>
                <?php endforeach; else: ?>
                <p class="text-muted text-center py-3" style="font-size:.85rem">Belum ada data lokasi/alamat.</p>
                <?php endif; ?>

                <?php if(!empty($lokasiRows)): ?>
                <div class="mt-3 p-3 rounded" style="background:var(--soft);font-size:.77rem;border:1px solid var(--sky)">
                    <i class="bi bi-info-circle me-1" style="color:var(--blue)"></i>
                    <b>Lokasi teratas:</b> <?= htmlspecialchars(substr($lokasiRows[0]['nama_lokasi'], 0, 60)) ?>
                    dengan <b><?= $lokasiRows[0]['jumlah'] ?></b> laporan masuk.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Tabel Laporan Terbaru -->
    <div class="box mb-4">
        <div class="box-title"><i class="bi bi-clock-history"></i> Laporan Terbaru</div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Nama Pelapor</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php if($laporanTerbaru && mysqli_num_rows($laporanTerbaru) > 0):
                    while($row = mysqli_fetch_assoc($laporanTerbaru)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nama_user'] ?? '-') ?></td>
                    <td><?= htmlspecialchars(substr($row['judul'], 0, 45)) ?><?= strlen($row['judul']) > 45 ? '...' : '' ?></td>
                    <td><span style="font-size:.74rem;color:var(--gray)"><?= htmlspecialchars($row['nama_kategori'] ?? '-') ?></span></td>
                    <td>
                        <?php
                        $sc = [
                            'Menunggu'=>'s-menunggu',
                            'Diproses'=>'s-diproses',
                            'Selesai'=>'s-selesai',
                            'Ditolak'=>'s-ditolak'
                        ];
                        $cls = $sc[$row['status']] ?? 's-menunggu';
                        ?>
                        <span class="badge-status <?= $cls ?>"><?= htmlspecialchars($row['status']) ?></span>
                    </td>
                    <td style="font-size:.77rem;color:var(--gray)"><?= date("d/m/Y", strtotime($row['created_at'])) ?></td>
                    <td><a href="laporan.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary py-0" style="font-size:.74rem">Detail</a></td>
                </tr>
                    <?php endwhile; else: ?>
                <tr><td colspan="6" class="text-center text-muted py-3">Belum ada laporan.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="text-end mt-2">
            <a href="laporan.php" class="btn btn-sm btn-outline-primary" style="font-size:.79rem">Lihat Semua &rarr;</a>
        </div>
    </div>

    <!-- Tabel Audit Log -->
    <div class="box mb-2">
        <div class="box-title"><i class="bi bi-shield-check"></i> Aktivitas Terbaru</div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr><th>Nama Pengguna</th><th>Aktivitas</th><th>Waktu</th></tr>
                </thead>
                <tbody>
                <?php if($auditTerbaru && mysqli_num_rows($auditTerbaru) > 0):
                    while($a = mysqli_fetch_assoc($auditTerbaru)): ?>
                <tr>
                    <td><?= htmlspecialchars($a['nama'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($a['aktivitas'] ?? '-') ?></td>
                    <td style="font-size:.77rem;color:var(--gray)"><?= date("d/m/Y H:i", strtotime($a['created_at'])) ?></td>
                </tr>
                    <?php endwhile; else: ?>
                <tr><td colspan="3" class="text-center text-muted py-3">Belum ada aktivitas.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="text-end mt-2">
            <a href="audit.php" class="btn btn-sm btn-outline-secondary" style="font-size:.79rem">Lihat Audit Log &rarr;</a>
        </div>
    </div>

    <div class="footer">&copy; <?= date('Y') ?> Dinas Komunikasi dan Informatika Kota Singkawang</div>
</div>

<script>
// Fungsi Buka Tutup Sidebar di HP
const toggleBtn = document.getElementById('toggleSidebar');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');

toggleBtn.addEventListener('click', function() {
    sidebar.classList.toggle('show');
    overlay.classList.toggle('show');
});

overlay.addEventListener('click', function() {
    sidebar.classList.remove('show');
    overlay.classList.remove('show');
});

// GRAFIK
<?php if(!empty($tanggal) && !empty($jumlah)): ?>
new Chart(document.getElementById('chartHarian'), {
    type: 'line',
    data: {
        labels: <?= json_encode($tanggal) ?>,
        datasets: [{
            label: 'Pengaduan',
            data: <?= json_encode($jumlah) ?>,
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37,99,235,0.08)',
            borderWidth: 2.5,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#2563eb',
            pointRadius: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 } },
            x: { }
        }
    }
});
<?php endif; ?>

new Chart(document.getElementById('chartStatus'), {
    type: 'doughnut',
    data: {
        labels: ['Menunggu','Diproses','Selesai','Ditolak'],
        datasets: [{
            data: [<?= $menunggu ?>, <?= $proses ?>, <?= $selesai ?>, <?= $ditolak ?>],
            backgroundColor: ['#f59e0b','#06b6d4','#10b981','#ef4444'],
            borderWidth: 3,
            borderColor: 'rgba(255,255,255,0.9)'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '65%',
        plugins: { legend: { display: false } }
    }
});

<?php if(!empty($katLabel)): ?>
new Chart(document.getElementById('chartKategori'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($katLabel) ?>,
        datasets: [{
            label: 'Jumlah Laporan',
            data: <?= json_encode($katData) ?>,
            backgroundColor: [
                'rgba(37,99,235,0.75)','rgba(16,185,129,0.75)','rgba(245,158,11,0.75)',
                'rgba(239,68,68,0.75)','rgba(139,92,246,0.75)','rgba(6,182,212,0.75)'
            ],
            borderRadius: 6,
            borderWidth: 0
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: true,
        plugins: { legend: { display: false } },
        scales: { x: { beginAtZero: true, ticks: { precision: 0 } } }
    }
});
<?php endif; ?>
</script>

</body>
</html>