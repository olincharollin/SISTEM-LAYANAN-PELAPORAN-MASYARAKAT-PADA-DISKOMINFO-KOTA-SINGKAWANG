<?php
session_start();
include "../config.php";

/** @var mysqli $conn */

if (!isset($_SESSION['role']) || $_SESSION['role'] != "user") {
    header("Location: ../login.php");
    exit;
}

$error   = "";
$success = "";

// Ambil kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori_pengaduan ORDER BY nama_kategori ASC");

if (isset($_POST['kirim'])) {

    $user_id   = $_SESSION['id'];
    $nama_user = $_SESSION['nama'];

    // Ambil data form
    $kategori_id = isset($_POST['kategori_id']) ? (int)$_POST['kategori_id'] : 0;
    $judul       = trim($_POST['judul'] ?? '');
    $pesan       = trim($_POST['pesan'] ?? '');

    $latitude    = trim($_POST['latitude'] ?? '');
    $longitude   = trim($_POST['longitude'] ?? '');
    $nama_lokasi = trim($_POST['nama_lokasi'] ?? '');

    $link_terkait = trim($_POST['link_terkait'] ?? '');
    $nomor_terkait = trim($_POST['nomor_terkait'] ?? '');

    // Validasi input wajib
    if ($kategori_id == 0) {
        $error = "Pilih kategori pengaduan.";
    } elseif ($judul == '') {
        $error = "Judul tidak boleh kosong.";
    } elseif ($pesan == '') {
        $error = "Isi pengaduan tidak boleh kosong.";
    }

    // Kategori yang wajib lokasi (ganti ID sesuai data kamu)
    $kategoriWajibLokasi = [4, 5, 6]; 

    if ($error == "" && in_array($kategori_id, $kategoriWajibLokasi)) {
        if ($latitude == "" || $longitude == "") {
            $error = "Lokasi wajib dipilih untuk kategori ini.";
        }
    }

    if ($nama_lokasi == '') {
        $nama_lokasi = "Tidak diketahui";
    }

    // Upload foto
    $foto_nama = NULL;

    if ($error == '' && isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {

        $allowed = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $error = "Format foto harus JPG, JPEG, atau PNG.";
        } elseif ($_FILES['foto']['size'] > 2000000) {
            $error = "Ukuran foto maksimal 2MB.";
        } else {

            if (!is_dir("../uploads")) {
                mkdir("../uploads", 0755, true);
            }

            $randomName = uniqid("foto_", true);
            $foto_nama = $randomName . "." . $ext;

            if (!move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/" . $foto_nama)) {
                $error = "Gagal upload foto.";
                $foto_nama = NULL;
            }
        }
    }

    // Simpan ke DB
    if ($error == '') {

        $status = "Menunggu";

        $lat = ($latitude != "") ? (float)$latitude : NULL;
        $lng = ($longitude != "") ? (float)$longitude : NULL;

        $stmt = mysqli_prepare($conn, "INSERT INTO pengaduan 
            (user_id, nama_user, kategori_id, judul, pesan, foto, latitude, longitude, nama_lokasi, link_terkait, nomor_terkait, status, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");

        if ($stmt) {

            mysqli_stmt_bind_param(
                $stmt,
                "isisssddssss",
                $user_id,
                $nama_user,
                $kategori_id,
                $judul,
                $pesan,
                $foto_nama,
                $lat,
                $lng,
                $nama_lokasi,
                $link_terkait,
                $nomor_terkait,
                $status
            );

            if (mysqli_stmt_execute($stmt)) {

                $success = "Pengaduan berhasil dikirim!";

                // ✅ DIPERBAIKI: Hapus ip_address karena kolom tidak ada
                $audit = mysqli_prepare($conn, "INSERT INTO audit_log (user_id, aktivitas) VALUES (?, 'Membuat pengaduan baru')");
                mysqli_stmt_bind_param($audit, "i", $user_id);
                mysqli_stmt_execute($audit);

                $_POST = [];

            } else {
                $error = "Gagal menyimpan data: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);

        } else {
            $error = "Query gagal disiapkan: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengaduan — Diskominfo Singkawang</title>

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

        * { box-sizing: border-box; margin: 0; padding: 0; }

        /* ── GLOBAL BACKGROUND ── */
        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            min-height: 100vh;
            background: url('../assets/bck.jpg') center center / cover no-repeat fixed;
            position: relative;
            width: 100%;
            overflow-x: hidden;
            /* ✅ Jarak atas agar tidak tertutup header */
            padding-top: 90px;
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

        /* ── HEADER ATAS ── */
        .top-header {
            width: 100%;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(37,99,235,0.1);
            box-shadow: 0 2px 14px rgba(13,46,94,0.08);
        }

        @media (max-width: 768px) {
            .top-header {
                padding: 12px 16px;
                flex-direction: column;
                gap: 10px;
                align-items: center;
            }
            body {
                padding-top: 110px;
            }
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-img {
            height: 45px;
            width: auto;
            object-fit: contain;
        }

        .logo-text h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--navy);
            margin: 0;
            line-height: 1.2;
        }
        .logo-text p {
            font-size: 11px;
            color: var(--gray);
            margin: 0;
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
            white-space: nowrap;
        }

        .back-btn:hover {
            background: linear-gradient(135deg, var(--blue), var(--blue2));
            color: #fff;
            border-color: var(--blue);
            transform: translateY(-1px);
        }

        /* ── CARD ── */
        .card {
            border: none;
            border-radius: 14px;
            margin-bottom: 20px;
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(8px);
            box-shadow: 0 2px 14px rgba(13,46,94,0.08);
            border: 1px solid rgba(37,99,235,0.1);
            position: relative;
            z-index: 2;
            width: 100%;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(37,99,235,0.15);
            border-radius: 14px 14px 0 0 !important;
            padding: 14px 20px;
            font-weight: 800;
            color: var(--navy);
            font-size: 0.85rem;
        }

        .card-body { padding: 20px; }

        .form-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--navy);
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control, .form-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.88rem;
            padding: 10px 14px;
            background: rgba(255,255,255,0.9);
            width: 100%;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
        }

        #map {
            height: 350px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            width: 100%;
        }

        .lokasi-info {
            display: none;
            background: #ecfdf5;
            border: 1px solid #6ee7b7;
            border-radius: 10px;
            padding: 8px 12px;
            font-size: 0.8rem;
            color: #065f46;
            margin-top: 8px;
            align-items: center;
            gap: 6px;
            width: 100%;
        }

        .btn-kirim {
            background: linear-gradient(135deg, var(--blue), var(--blue2));
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 800;
            font-size: 0.9rem;
            color: white;
            width: 100%;
            position: relative;
            z-index: 2;
            transition: all 0.2s;
        }

        .btn-kirim:hover {
            background: linear-gradient(135deg, var(--blue2), #1e3a8a);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(37,99,235,0.3);
        }

        .btn-outline-primary, .btn-outline-secondary {
            border-radius: 10px;
            font-size: 0.8rem;
        }

        /* Container utama */
        .container {
            position: relative;
            z-index: 2;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 15px 32px 15px !important;
            flex: 1;
        }

        @media (min-width: 768px) {
            .container {
                padding: 0 32px 32px 32px !important;
            }
        }

        .text-white-custom {
            color: var(--navy);
        }

        .footer {
            text-align: center;
            font-size: 0.72rem;
            color: var(--gray);
            padding: 16px 0 8px;
            position: relative;
            z-index: 2;
            width: 100%;
            margin-top: auto;
        }

        /* Preview foto */
        #previewFoto {
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            max-width: 100%;
        }

        h5, p {
            width: 100%;
            padding: 0 12px;
        }
    </style>
</head>
<body>

<!-- ✅ LOGO ALAMAT SESUAI STRUKTUR FOLDER KAMU -->
<div class="top-header">
    <div class="logo-area">
        <img src="../assets/logo.jpg" alt="Logo Diskominfo" class="logo-img">
        <div class="logo-text">
            <h4>Sistem Pengaduan Masyarakat</h4>
            <p>Dinas Komunikasi dan Informatika</p>
        </div>
    </div>
    <a href="dashboard.php" class="back-btn">
        <i class="bi bi-arrow-left"></i> <span class="d-none d-sm-inline">Kembali ke Dashboard</span>
        <span class="d-inline d-sm-none">Kembali</span>
    </a>
</div>

<div class="container py-4">

    <h5 class="fw-bold mb-1 pt-2" style="color: var(--navy);"><i class="bi bi-pencil-square me-2" style="color: var(--blue);"></i>Buat Pengaduan Baru</h5>
    <p class="mb-4" style="font-size:0.85rem; color: var(--gray);">
        Lengkapi formulir berikut. Laporan Anda akan ditindaklanjuti petugas kami.
    </p>

    <?php if ($error != ''): ?>
        <div class="alert alert-danger d-flex align-items-center gap-2 py-2 mb-3 mx-3" style="font-size:0.85rem;border-radius:12px">
            <i class="bi bi-exclamation-triangle-fill"></i> <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($success != ''): ?>
        <div class="alert alert-success d-flex align-items-center gap-2 py-2 mb-3 mx-3" style="font-size:0.85rem;border-radius:12px">
            <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($success) ?>
            <a href="riwayat.php" class="ms-auto fw-bold text-success text-decoration-none">Lihat Riwayat &rarr;</a>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" style="width: 100%;">

        <!-- Informasi Pengaduan -->
        <div class="card">
            <div class="card-header"><i class="bi bi-file-text me-2"></i> Informasi Pengaduan</div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Kategori <span class="text-danger">*</span></label>
                    <select name="kategori_id" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        <?php
                        mysqli_data_seek($kategori, 0);
                        while ($k = mysqli_fetch_assoc($kategori)):
                        ?>
                            <option value="<?= $k['id'] ?>" <?= (isset($_POST['kategori_id']) && $_POST['kategori_id'] == $k['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($k['nama_kategori']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Pengaduan <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control"
                        placeholder="Contoh: Situs pemerintah tidak bisa diakses"
                        value="<?= htmlspecialchars($_POST['judul'] ?? '') ?>" required>
                </div>

                <div>
                    <label class="form-label">Isi Pengaduan <span class="text-danger">*</span></label>
                    <textarea name="pesan" class="form-control" rows="4"
                        placeholder="Jelaskan masalah secara detail..." required><?= htmlspecialchars($_POST['pesan'] ?? '') ?></textarea>
                </div>

            </div>
        </div>

        <!-- Tambahan Info Digital -->
        <div class="card">
            <div class="card-header"><i class="bi bi-link-45deg me-2"></i> Informasi Tambahan</div>
            <div class="card-body">

                <div class="mb-3">
                    <label class="form-label">Link Website / Akun Sosial Media</label>
                    <input type="text" name="link_terkait" class="form-control"
                        placeholder="Contoh: https://contoh.com atau link Facebook/Instagram"
                        value="<?= htmlspecialchars($_POST['link_terkait'] ?? '') ?>">
                    <div class="text-muted mt-1" style="font-size:0.7rem">Opsional</div>
                </div>

                <div>
                    <label class="form-label">Nomor HP Terkait (Spam / Penipuan)</label>
                    <input type="text" name="nomor_terkait" class="form-control"
                        placeholder="Contoh: 08xxxxxxxxxx"
                        value="<?= htmlspecialchars($_POST['nomor_terkait'] ?? '') ?>">
                    <div class="text-muted mt-1" style="font-size:0.7rem">Opsional</div>
                </div>

            </div>
        </div>

        <!-- Foto Bukti -->
        <div class="card">
            <div class="card-header"><i class="bi bi-camera me-2"></i> Foto Bukti</div>
            <div class="card-body">
                <input type="file" name="foto" id="inputFoto" class="form-control" accept=".jpg,.jpeg,.png">
                <div class="text-muted mt-1" style="font-size:0.7rem">Format JPG/PNG, maksimal 2MB (Opsional)</div>
                <img id="previewFoto" src="" alt="Preview"
                    class="img-fluid rounded mt-2"
                    style="display:none; max-height:180px; object-fit:cover;">
            </div>
        </div>

        <!-- Lokasi -->
        <div class="card">
            <div class="card-header"><i class="bi bi-geo-alt me-2"></i> Lokasi Kejadian</div>
            <div class="card-body">
                <p class="text-muted mb-2" style="font-size:0.78rem">
                    <i class="bi bi-info-circle"></i> Jika laporan terkait fasilitas fisik (wifi/cctv), silakan pilih lokasi.
                </p>

                <div class="d-flex gap-2 mb-2">
                    <button type="button" id="btnGPS" class="btn btn-sm btn-outline-primary" style="font-size:0.8rem; border-radius: 10px;">
                        <i class="bi bi-crosshair2"></i> Lokasi Saya
                    </button>
                    <button type="button" id="btnReset" class="btn btn-sm btn-outline-secondary" style="font-size:0.8rem; border-radius: 10px;">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>
                </div>

                <div id="map"></div>

                <div class="lokasi-info" id="lokasiInfo">
                    <i class="bi bi-check-circle-fill"></i>
                    <span id="lokasiTeks">Lokasi dipilih</span>
                </div>

                <input type="hidden" name="latitude" id="latitude" value="<?= htmlspecialchars($_POST['latitude'] ?? '') ?>">
                <input type="hidden" name="longitude" id="longitude" value="<?= htmlspecialchars($_POST['longitude'] ?? '') ?>">
                <input type="hidden" name="nama_lokasi" id="nama_lokasi" value="<?= htmlspecialchars($_POST['nama_lokasi'] ?? '') ?>">
            </div>
        </div>

        <button type="submit" name="kirim" class="btn-kirim">
            <i class="bi bi-send-fill me-2"></i>Kirim Pengaduan
        </button>

        <div class="footer">
            &copy; <?= date('Y') ?> Dinas Komunikasi dan Informatika Kota Singkawang
        </div>

    </form>
</div>

<script>
var defaultLat = -0.021;
var defaultLng = 109.337;

var map = L.map('map').setView([defaultLat, defaultLng], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { 
    maxZoom: 19 
}).addTo(map);

var marker = null;

function setMarker(lat, lng) {
    if (marker) map.removeLayer(marker);
    marker = L.marker([lat, lng]).addTo(map);

    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;

    var label = 'Lat: ' + parseFloat(lat).toFixed(5) + ', Lng: ' + parseFloat(lng).toFixed(5);

    document.getElementById('nama_lokasi').value = label;
    document.getElementById('lokasiTeks').textContent = label;
    document.getElementById('lokasiInfo').style.display = 'flex';

    fetch('https://nominatim.openstreetmap.org/reverse?lat=' + lat + '&lon=' + lng + '&format=json')
        .then(function(r) { return r.json(); })
        .then(function(d) {
            if (d && d.display_name) {
                var nama = d.display_name.split(',').slice(0, 4).join(', ');
                document.getElementById('nama_lokasi').value = nama;
                document.getElementById('lokasiTeks').textContent = nama;
            }
        })
        .catch(function() {});
}

map.on('click', function(e) {
    setMarker(e.latlng.lat, e.latlng.lng);
});

document.getElementById('btnGPS').addEventListener('click', function() {
    if (!navigator.geolocation) {
        alert('Browser tidak mendukung GPS.');
        return;
    }

    var btn = this;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Mencari...';

    navigator.geolocation.getCurrentPosition(function(p) {
        map.setView([p.coords.latitude, p.coords.longitude], 16);
        setMarker(p.coords.latitude, p.coords.longitude);
        btn.innerHTML = '<i class="bi bi-crosshair2"></i> Lokasi Saya';
    }, function() {
        alert('Tidak dapat mengakses lokasi. Pastikan izin lokasi diaktifkan.');
        btn.innerHTML = '<i class="bi bi-crosshair2"></i> Lokasi Saya';
    });
});

document.getElementById('btnReset').addEventListener('click', function() {
    if (marker) {
        map.removeLayer(marker);
        marker = null;
    }

    document.getElementById('latitude').value = '';
    document.getElementById('longitude').value = '';
    document.getElementById('nama_lokasi').value = '';
    document.getElementById('lokasiInfo').style.display = 'none';

    map.setView([defaultLat, defaultLng], 13);
});

document.getElementById('inputFoto').addEventListener('change', function() {
    var preview = document.getElementById('previewFoto');

    if (this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(this.files[0]);
    } else {
        preview.style.display = 'none';
    }
});
</script>

</body>
</html>