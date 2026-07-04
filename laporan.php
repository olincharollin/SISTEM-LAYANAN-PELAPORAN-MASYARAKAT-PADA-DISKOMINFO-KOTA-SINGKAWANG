<?php
session_start();
include "../config.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != "admin") {
    header("Location: ../login.php");
    exit;
}

/* ======================
   UPDATE STATUS
====================== */
if (isset($_POST['update_status'])) {
    $id = (int)$_POST['id'];
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    mysqli_query($conn, "UPDATE pengaduan SET status='$status' WHERE id='$id'");

    // ✅ SUDAH BENAR: Tanpa ip_address
    mysqli_query($conn, "
        INSERT INTO audit_log (user_id, aktivitas)
        VALUES ('$_SESSION[id]', 'Update status pengaduan ID $id menjadi $status')
    ");
}

/* ======================
   KIRIM / EDIT TANGGAPAN
====================== */
if (isset($_POST['kirim_tanggapan'])) {
    $pengaduan_id = (int)$_POST['pengaduan_id'];
    $tanggapan = mysqli_real_escape_string($conn, $_POST['tanggapan']);

    $cek = mysqli_query($conn, "SELECT * FROM tanggapan_admin WHERE pengaduan_id='$pengaduan_id'");

    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "UPDATE tanggapan_admin SET tanggapan='$tanggapan' WHERE pengaduan_id='$pengaduan_id'");
    } else {
        mysqli_query($conn, "
            INSERT INTO tanggapan_admin (pengaduan_id, admin_id, tanggapan)
            VALUES ('$pengaduan_id', '$_SESSION[id]', '$tanggapan')
        ");
    }

    // ✅ DIPERBAIKI: Tanda kurung lengkap & tanpa ip_address
    mysqli_query($conn, "
        INSERT INTO audit_log (user_id, aktivitas)
        VALUES ('$_SESSION[id]', 'Mengedit tanggapan pengaduan ID $pengaduan_id')
    ");
}

/* ======================
   FILTER
====================== */
$filter = isset($_GET['filter']) ? $_GET['filter'] : "semua";
$where = "";

if ($filter == "hari") {
    $where = "WHERE DATE(pengaduan.created_at) = CURDATE()";
} elseif ($filter == "minggu") {
    $where = "WHERE YEARWEEK(pengaduan.created_at, 1) = YEARWEEK(CURDATE(), 1)";
} elseif ($filter == "bulan") {
    $where = "WHERE MONTH(pengaduan.created_at) = MONTH(CURDATE()) AND YEAR(pengaduan.created_at) = YEAR(CURDATE())";
} elseif ($filter == "tahun") {
    $where = "WHERE YEAR(pengaduan.created_at) = YEAR(CURDATE())";
}

/* ======================
   DATA LAPORAN
====================== */
$data = mysqli_query($conn, "
    SELECT 
        pengaduan.*,
        users.nama AS nama_user,
        kategori_pengaduan.nama_kategori
    FROM pengaduan
    LEFT JOIN users ON pengaduan.user_id = users.id
    LEFT JOIN kategori_pengaduan ON pengaduan.kategori_id = kategori_pengaduan.id
    $where
    ORDER BY pengaduan.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #1a4d6b;
            --primary-dark: #12384d;
            --success: #198754;
            --bg: #f4f7fb;
            --white: #ffffff;
            --border: #e5e7eb;
            --text: #1e293b;
            --muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            display: flex;
            flex-direction: column;
            background-image: url('../assets/bck.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            position: relative;
            width: 100%;
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

        /* ======================
           TOPBAR
        ====================== */
        .topbar {
            width: 100%; /* Lebar penuh layar */
            height: 80px;
            background: white;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            position: sticky;
            top: 0;
            z-index: 99;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
            margin: 0; /* Pastikan tidak ada margin */
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .logo img {
            width: 46px;
            height: 46px;
            object-fit: contain;
            border-radius: 8px;
        }

        .logo-text h3 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
        }

        .logo-text span {
            font-size: 12px;
            color: var(--muted);
        }

        .back-btn {
            text-decoration: none;
            background: #eef4ff;
            color: var(--primary);
            padding: 10px 18px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 600;
            transition: 0.2s;
            border: 1px solid #dbeafe;
        }

        .back-btn:hover {
            background: var(--primary);
            color: var(--white);
            border-color: var(--primary);
        }

        /* ======================
           CONTAINER / KONTEN UTAMA - LEBAR PENUH
        ====================== */
        .container-custom {
            flex: 1;
            width: 100%; /* Lebar penuh layar */
            max-width: 100%; /* Hapus batasan lebar */
            margin: 0; /* Hilangkan margin kiri-kanan */
            padding: 32px; /* Beri jarak dalam saja */
        }

        /* ======================
           CARD
        ====================== */
        .card-custom {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,.04);
            margin-bottom: 26px;
            border: 1px solid var(--border);
            width: 100%; /* Lebar penuh */
        }

        .card-header-custom {
            padding: 22px 24px;
            border-bottom: 1px solid var(--border);
            font-size: 18px;
            font-weight: 700;
            color: var(--text);
            background: #fbfcfe;
            width: 100%;
        }

        .card-body-custom {
            padding: 24px;
            width: 100%;
        }

        /* ======================
           FILTER
        ====================== */
        .filter-group {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-select {
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 12px 14px;
            min-width: 190px;
            font-size: 14px;
            background: white;
            color: var(--text);
        }

        .btn-custom {
            border: none;
            border-radius: 14px;
            padding: 12px 18px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-primary-custom {
            background: var(--primary);
            color: white;
        }

        .btn-primary-custom:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        /* ======================
           TABLE
        ====================== */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 0 0 20px 20px;
            width: 100%;
        }

        .table-custom {
            width: 100%;
            border-collapse: collapse;
        }

        .table-custom th {
            background: #f8fafc;
            padding: 16px 14px;
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 700;
            text-align: left;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        .table-custom td {
            padding: 18px 14px;
            border-top: 1px solid #f1f5f9;
            vertical-align: top;
            font-size: 13px;
            color: var(--text);
        }

        .table-custom tr:hover {
            background: #fafafa;
        }

        /* ======================
           STATUS
        ====================== */
        .status-select {
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 8px 12px;
            font-size: 12px;
            background: white;
            font-weight: 500;
        }

        .status-select option[value="Menunggu"] { color: #b45309; }
        .status-select option[value="Diproses"] { color: #165baa; }
        .status-select option[value="Selesai"] { color: #15803d; }
        .status-select option[value="Ditolak"] { color: #991b1b; }

        /* ======================
           FOTO & LINK
        ====================== */
        .foto-link, .maps-link, .link-terkait-btn {
            text-decoration: none;
            font-weight: 600;
            padding: 8px 12px;
            border-radius: 10px;
            display: inline-block;
            font-size: 12px;
            transition: 0.2s;
            white-space: nowrap;
        }

        .foto-link {
            color: var(--primary);
            background: #eef4ff;
        }

        .foto-link:hover {
            background: #dbe8ff;
        }

        .maps-link {
            background: #eff6ff;
            color: #1d4ed8;
        }

        .maps-link:hover {
            background: #dbeafe;
        }

        .link-terkait-btn {
            background: #f0fdf4;
            color: #166534;
        }

        .link-terkait-btn:hover {
            background: #dcfce7;
        }

        /* ======================
           TANGGAPAN
        ====================== */
        .tanggapan-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px;
            min-width: 280px;
        }

        .tanggapan-text {
            font-size: 13px;
            line-height: 1.7;
            color: #334155;
            margin-bottom: 14px;
            min-height: 20px;
            white-space: pre-line;
        }

        .btn-edit {
            border: none;
            background: #facc15;
            color: #111827;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            width: 100%;
        }

        .btn-edit:hover {
            background: #eab308;
        }

        .form-edit {
            display: none;
            margin-top: 12px;
        }

        .form-edit textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 12px;
            resize: vertical;
            font-size: 13px;
            min-height: 100px;
            font-family: inherit;
            background: white;
        }

        .btn-save {
            margin-top: 10px;
            border: none;
            background: var(--success);
            color: white;
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s;
            width: 100%;
        }

        .btn-save:hover {
            background: #157347;
        }

        /* ======================
           FOOTER - LEBAR PENUH
        ====================== */
        .footer {
            width: 100%; /* Lebar penuh layar */
            margin: 0; /* Hilangkan semua margin */
            margin-top: auto;
            background: white;
            border-top: 1px solid var(--border);
            text-align: center;
            padding: 18px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 500;
        }

        /* ======================
           RESPONSIVE
        ====================== */
        @media (max-width: 768px) {
            .topbar {
                padding: 0 18px;
                height: auto;
                flex-direction: column;
                gap: 12px;
                padding-top: 14px;
                padding-bottom: 14px;
            }

            .container-custom {
                padding: 18px;
            }

            .logo-text h3 {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<!-- ======================
     TOPBAR
====================== -->
<div class="topbar">
    <div class="logo">
        <img src="../assets/logo.jpg" alt="Logo">
        <div class="logo-text">
            <h3>Sistem Pengaduan Masyarakat</h3>
            <span>Admin Panel Diskominfo</span>
        </div>
    </div>
    <a href="dashboard.php" class="back-btn">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<!-- ======================
     CONTENT - LEBAR PENUH
====================== -->
<div class="container-custom">

    <!-- FILTER -->
    <div class="card-custom">
        <div class="card-header-custom">Filter Data Laporan</div>
        <div class="card-body-custom">
            <form method="GET" class="filter-group">
                <select name="filter" class="filter-select">
                    <option value="semua" <?= ($filter == "semua") ? "selected" : "" ?>>Semua Data</option>
                    <option value="hari" <?= ($filter == "hari") ? "selected" : "" ?>>Hari Ini</option>
                    <option value="minggu" <?= ($filter == "minggu") ? "selected" : "" ?>>Minggu Ini</option>
                    <option value="bulan" <?= ($filter == "bulan") ? "selected" : "" ?>>Bulan Ini</option>
                    <option value="tahun" <?= ($filter == "tahun") ? "selected" : "" ?>>Tahun Ini</option>
                </select>
                <button type="submit" class="btn-custom btn-primary-custom">
                    <i class="fas fa-search"></i> Tampilkan Data
                </button>
            </form>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card-custom">
        <div class="card-header-custom">Daftar Seluruh Pengaduan</div>
        <div class="table-wrapper">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Judul Laporan</th>
                        <th>Status</th>
                        <th>Foto</th>
                        <th>Link Terkait</th>
                        <th>No. Terkait</th>
                        <th>Lokasi</th>
                        <th>Tanggal</th>
                        <th>Tanggapan Admin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($row = mysqli_fetch_assoc($data)):
                        $tanggapan_q = mysqli_query($conn, "SELECT * FROM tanggapan_admin WHERE pengaduan_id='$row[id]' LIMIT 1");
                        $tanggapan = mysqli_fetch_assoc($tanggapan_q);
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><b><?= htmlspecialchars($row['nama_user']) ?></b></td>
                        <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                        <td><?= htmlspecialchars($row['judul']) ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <select name="status" class="status-select" onchange="this.form.submit()">
                                    <option value="Menunggu" <?= $row['status'] == "Menunggu" ? "selected" : "" ?>>Menunggu</option>
                                    <option value="Diproses" <?= $row['status'] == "Diproses" ? "selected" : "" ?>>Diproses</option>
                                    <option value="Selesai" <?= $row['status'] == "Selesai" ? "selected" : "" ?>>Selesai</option>
                                    <option value="Ditolak" <?= $row['status'] == "Ditolak" ? "selected" : "" ?>>Ditolak</option>
                                </select>
                                <input type="hidden" name="update_status">
                            </form>
                        </td>
                        <td>
                            <?php if ($row['foto']): ?>
                                <a href="../uploads/<?= $row['foto'] ?>" target="_blank" class="foto-link">
                                    <i class="fas fa-image"></i> Lihat
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($row['link_terkait'])): ?>
                                <a href="<?= htmlspecialchars($row['link_terkait']) ?>" target="_blank" class="link-terkait-btn">
                                    <i class="fas fa-link"></i> Buka
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= !empty($row['nomor_terkait']) ? htmlspecialchars($row['nomor_terkait']) : '-' ?>
                        </td>
                        <td>
                            <?php if ($row['latitude'] && $row['longitude']): ?>
                                <a class="maps-link" target="_blank" href="https://www.google.com/maps?q=<?= $row['latitude'] ?>,<?= $row['longitude'] ?>">
                                    <i class="fas fa-map-marker-alt"></i> Buka Peta
                                </a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= date('d/m/Y <br>H:i', strtotime($row['created_at'])) ?>
                        </td>
                        <td>
                            <div class="tanggapan-box">
                                <div class="tanggapan-text">
                                    <?= $tanggapan ? nl2br(htmlspecialchars($tanggapan['tanggapan'])) : "<i>Belum ada tanggapan.</i>" ?>
                                </div>
                                <button class="btn-edit" onclick="toggleEdit<?= $row['id'] ?>()">
                                    <i class="fas fa-pen"></i> <?= $tanggapan ? 'Ubah Pesan' : 'Berikan Tanggapan' ?>
                                </button>
                                <div class="form-edit" id="editBox<?= $row['id'] ?>">
                                    <form method="POST">
                                        <input type="hidden" name="pengaduan_id" value="<?= $row['id'] ?>">
                                        <textarea name="tanggapan" placeholder="Tulis tanggapan atau jawaban untuk pelapor..." required><?= $tanggapan['tanggapan'] ?? '' ?></textarea>
                                        <button type="submit" name="kirim_tanggapan" class="btn-save">
                                            <i class="fas fa-save"></i> Simpan Tanggapan
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <script>
                                function toggleEdit<?= $row['id'] ?>() {
                                    const box = document.getElementById('editBox<?= $row['id'] ?>');
                                    box.style.display = box.style.display === 'block' ? 'none' : 'block';
                                }
                            </script>
                        </td>
                    </tr>
                    <?php endwhile; ?>

                    <?php if(mysqli_num_rows($data) == 0): ?>
                    <tr>
                        <td colspan="11" style="text-align: center; padding: 50px 20px; color: var(--muted)">
                            <i class="fas fa-inbox" style="font-size: 48px; opacity: 0.4; margin-bottom: 10px;"></i>
                            <p>Tidak ada data laporan yang ditemukan.</p>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ======================
     FOOTER - LEBAR PENUH
====================== -->
<div class="footer">
    <i class="fas fa-shield-alt"></i> Sistem Informasi Pelayanan Masyarakat © <?= date('Y') ?> | Dinas Komunikasi dan Informatika Kota Singkawang
</div>

</body>
</html>