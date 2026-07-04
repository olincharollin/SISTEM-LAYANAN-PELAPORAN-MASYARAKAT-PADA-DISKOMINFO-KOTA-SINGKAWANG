<?php
session_start();
include "../config.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != "user") {
    header("Location: ../login.php");
    exit;
}

$id = (int)$_GET['id'];

$data = mysqli_query($conn,"SELECT pengaduan.*, kategori_pengaduan.nama_kategori 
                            FROM pengaduan 
                            JOIN kategori_pengaduan ON pengaduan.kategori_id = kategori_pengaduan.id
                            WHERE pengaduan.id='$id' AND pengaduan.user_id='$_SESSION[id]'");

$row = mysqli_fetch_assoc($data);

if(!$row){
    echo "<script>alert('Data tidak ditemukan!'); window.location='riwayat.php';</script>";
    exit;
}

$tanggapan = mysqli_query($conn,"SELECT tanggapan_admin.*, users.nama 
                                FROM tanggapan_admin 
                                JOIN users ON tanggapan_admin.admin_id = users.id
                                WHERE pengaduan_id='$id'
                                ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengaduan — Diskominfo Singkawang</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

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

        /* ── GLOBAL BACKGROUND ── */
        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            min-height: 100vh;
            background: url('../assets/bck.jpg') center center / cover no-repeat fixed;
            position: relative;
            width: 100%;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
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

        /* ── TOMBOL KEMBALI ── */
        .top-nav {
            width: 100%;
            padding: 20px 32px;
            display: flex;
            justify-content: flex-end;
            position: sticky;
            top: 0;
            z-index: 99;
            background: transparent;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(8px);
            border: 1.5px solid rgba(37,99,235,0.1);
            color: var(--blue);
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 2px 14px rgba(13,46,94,0.08);
            transition: all 0.2s;
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
            padding: 0 32px 32px 32px !important;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        /* ── CARD STYLE ── */
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
            padding: 20px 24px;
            font-weight: 800;
            color: var(--navy);
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-body {
            padding: 24px;
        }

        /* ── INFO ITEM ── */
        .info-row {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 20px;
        }
        .info-group {
            flex: 1;
            min-width: 200px;
        }
        .info-label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--gray);
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }
        .info-value {
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--navy);
            background: rgba(239,246,255,0.6);
            padding: 8px 12px;
            border-radius: 8px;
            border-left: 3px solid var(--blue);
            word-break: break-word;
        }
        .info-value.text-block {
            padding: 12px;
            line-height: 1.6;
            white-space: pre-line;
        }

        /* Status Badge */
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
        }
        .status-menunggu { background: #fef3c7; color: #92400e; }
        .status-proses  { background: #dbeafe; color: #1e40af; }
        .status-selesai { background: #d1fae5; color: #065f46; }
        .status-tolak   { background: #fecaca; color: #991b1b; }

        /* Gambar */
        .foto-bukti {
            max-width: 100%;
            max-height: 400px;
            border-radius: 12px;
            border: 2px solid var(--soft2);
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            object-fit: contain;
        }

        /* Peta */
        #map {
            height: 300px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            width: 100%;
            margin-top: 8px;
        }

        /* Tanggapan */
        .tanggapan-box {
            background: rgba(240, 253, 244, 0.7);
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 16px;
            border-left: 4px solid #10b981;
            margin-bottom: 12px;
        }
        .tanggapan-header {
            font-weight: 700;
            color: #065f46;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
        }
        .tanggapan-waktu {
            font-size: 0.75rem;
            font-weight: 500;
            color: #047857;
        }
        .tanggapan-teks {
            line-height: 1.7;
            color: #065f46;
            white-space: pre-line;
        }

        .empty-tanggapan {
            text-align: center;
            padding: 30px 20px;
            color: var(--gray);
            background: rgba(241, 245, 249, 0.6);
            border-radius: 10px;
        }
        .empty-tanggapan i {
            font-size: 32px;
            margin-bottom: 8px;
            opacity: 0.4;
        }

        /* Footer selalu di bawah */
        .footer {
            margin-top: auto;
            text-align: center;
            font-size: 0.72rem;
            color: var(--gray);
            padding: 20px 0;
            position: relative;
            z-index: 2;
            width: 100%;
            background: rgba(255,255,255,0.4);
            backdrop-filter: blur(4px);
            border-top: 1px solid rgba(37,99,235,0.08);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .top-nav { padding: 16px; justify-content: center; }
            .container-custom { padding: 0 16px 16px 16px !important; }
            .info-row { flex-direction: column; gap: 10px; }
            .card-body { padding: 16px; }
        }
    </style>
</head>
<body>

<!-- TOMBOL KEMBALI -->
<div class="top-nav">
    <a href="riwayat.php" class="back-btn">
        <i class="bi bi-arrow-left"></i> Kembali ke Riwayat
    </a>
</div>

<div class="container-custom">

    <!-- CARD UTAMA -->
    <div class="card">
        <div class="card-header">
            <div style="display: flex; align-items: center; gap: 10px;">
                <i class="bi bi-file-text" style="color: var(--blue); font-size: 1.1rem;"></i>
                <h4 style="margin:0; font-size:1.1rem;">Detail Pengaduan</h4>
            </div>
            <span class="status-badge 
                <?= $row['status'] == 'Menunggu' ? 'status-menunggu' : '' ?>
                <?= $row['status'] == 'Diproses' ? 'status-proses' : '' ?>
                <?= $row['status'] == 'Selesai' ? 'status-selesai' : '' ?>
                <?= $row['status'] == 'Ditolak' ? 'status-tolak' : '' ?>">
                <?= $row['status'] ?>
            </span>
        </div>

        <div class="card-body">
            <!-- BARIS 1: Kategori & Tanggal -->
            <div class="info-row">
                <div class="info-group">
                    <div class="info-label">Kategori Pengaduan</div>
                    <div class="info-value"><?= htmlspecialchars($row['nama_kategori']) ?></div>
                </div>
                <div class="info-group">
                    <div class="info-label">Tanggal Dikirim</div>
                    <div class="info-value">
                        <i class="bi bi-calendar-event me-1"></i>
                        <?= date('d F Y, H:i', strtotime($row['created_at'])) ?>
                    </div>
                </div>
            </div>

            <!-- BARIS 2: Judul -->
            <div class="info-row">
                <div class="info-group" style="width: 100%;">
                    <div class="info-label">Judul Pengaduan</div>
                    <div class="info-value"><?= htmlspecialchars($row['judul']) ?></div>
                </div>
            </div>

            <!-- BARIS 3: Isi Pengaduan -->
            <div class="info-row">
                <div class="info-group" style="width: 100%;">
                    <div class="info-label">Isi Laporan</div>
                    <div class="info-value text-block"><?= nl2br(htmlspecialchars($row['pesan'])) ?></div>
                </div>
            </div>

            <!-- BARIS 4: Foto Bukti -->
            <?php if (!empty($row['foto'])): ?>
            <div class="info-row">
                <div class="info-group" style="width: 100%;">
                    <div class="info-label">Foto Bukti</div>
                    <div>
                        <img src="../uploads/<?= htmlspecialchars($row['foto']) ?>" alt="Foto Bukti" class="foto-bukti">
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- BARIS 5: Lokasi & Peta -->
            <?php if (!empty($row['latitude']) && !empty($row['longitude'])): ?>
            <div class="info-row">
                <div class="info-group" style="width: 100%;">
                    <div class="info-label">Lokasi Kejadian</div>
                    <div class="info-value mb-2">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                        <?= htmlspecialchars($row['nama_lokasi']) ?>
                    </div>
                    <div id="map"></div>
                </div>
            </div>
            <?php endif; ?>

            <!-- GARIS PEMISAH -->
            <hr style="border-color: rgba(37,99,235,0.1); margin: 24px 0;">

            <!-- BAGIAN TANGGAPAN ADMIN -->
            <div class="info-row">
                <div class="info-group" style="width: 100%;">
                    <div class="info-label mb-3">
                        <i class="bi bi-shield-check me-1"></i> Tanggapan / Balasan Petugas
                    </div>
                    
                    <?php if(mysqli_num_rows($tanggapan) > 0): ?>
                        <?php while($t = mysqli_fetch_assoc($tanggapan)): ?>
                        <div class="tanggapan-box">
                            <div class="tanggapan-header">
                                <span><b><?= htmlspecialchars($t['nama']) ?></b></span>
                                <span class="tanggapan-waktu"><?= date('d/m/Y H:i', strtotime($t['created_at'])) ?></span>
                            </div>
                            <div class="tanggapan-teks"><?= nl2br(htmlspecialchars($t['tanggapan'])) ?></div>
                        </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="empty-tanggapan">
                            <i class="bi bi-hourglass-split"></i>
                            <p class="mb-0">Belum ada tanggapan. Laporan sedang dalam pengecekan.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- FOOTER DI BAWAH -->
<div class="footer">
    &copy; <?= date('Y') ?> Dinas Komunikasi dan Informatika Kota Singkawang — Sistem Pelayanan Pengaduan Masyarakat
</div>

<?php if (!empty($row['latitude']) && !empty($row['longitude'])): ?>
<script>
var lat = <?= $row['latitude'] ?>;
var lng = <?= $row['longitude'] ?>;

var map = L.map('map').setView([lat, lng], 16);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

L.marker([lat, lng]).addTo(map)
    .bindPopup("<b>Lokasi Pengaduan</b><br><?= addslashes($row['nama_lokasi']) ?>")
    .openPopup();
</script>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>