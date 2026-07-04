<?php
session_start();
include "../config.php";

if(!isset($_SESSION['id'])){
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['id'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
if(mysqli_num_rows($query) == 0){
    echo "<div style='padding:20px; color:red;'>Data tidak ditemukan!</div>";
    exit;
}
$user = mysqli_fetch_assoc($query);

$pesan = "";

// Proses Simpan
if(isset($_POST['simpan'])){
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $no_hp    = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $password_baru = trim($_POST['password_baru']);

    // ✅ Aturan validasi password: 8-10 karakter, ada huruf + angka
    $aturan_pass = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*_\-+=?]{8,10}$/';

    if(!empty($password_baru)){
        // Cek apakah password sesuai aturan
        if(!preg_match($aturan_pass, $password_baru)){
            $pesan = "<div class='alert alert-danger' style='border-radius: 12px; padding:12px 16px; margin-bottom:20px;'>❌ Password baru harus 8 - 10 karakter, mengandung huruf dan angka!</div>";
        } else {
            // Enkripsi pakai MD5 sesuai sistem
            $password_baru = md5($password_baru);
            $sql = "UPDATE users SET 
                    nama='$nama', 
                    username='$username', 
                    email='$email', 
                    no_hp='$no_hp', 
                    password='$password_baru' 
                    WHERE id='$user_id'";
        }
    } else {
        // Update tanpa ubah password
        $sql = "UPDATE users SET 
                nama='$nama', 
                username='$username', 
                email='$email', 
                no_hp='$no_hp' 
                WHERE id='$user_id'";
    }

    // Jalankan query jika tidak ada pesan error
    if(empty($pesan) && mysqli_query($conn, $sql)){
        $pesan = "<div class='alert alert-success' style='border-radius: 12px; padding:12px 16px; margin-bottom:20px;'>✅ Profil berhasil diperbarui!</div>";
        $_SESSION['nama'] = $nama;
        // Refresh data
        $query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
        $user = mysqli_fetch_assoc($query);
    } elseif(empty($pesan)) {
        $pesan = "<div class='alert alert-danger' style='border-radius: 12px; padding:12px 16px; margin-bottom:20px;'>❌ Gagal: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Edit Profil - SIPADU Diskominfo Singkawang</title>

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
            width: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            padding-top: 88px;
        }

        @media (max-width: 768px) {
            body {
                padding-top: 120px;
            }
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

        .top-nav {
            width: 100%;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(13,46,94,0.05);
        }

        @media (min-width: 768px) {
            .top-nav {
                padding: 16px 32px;
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
                height: 48px;
            }
        }

        .logo-text h4 {
            font-size: 14px;
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
            font-size: 10px;
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

        .container-custom {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 15px 20px 15px !important;
            flex: 1;
        }

        @media (min-width: 768px) {
            .container-custom {
                padding: 0 32px 32px 32px !important;
            }
        }

        .card {
            background: var(--white);
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: all 0.3s;
            overflow: hidden;
            width: 100% !important;
            margin: 0 0 20px 0 !important;
        }

        @media (min-width: 768px) {
            .card {
                border-radius: 20px;
                margin: 0 0 32px 0 !important;
            }
        }

        .card:hover {
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.08);
        }

        .card-header-custom {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--white);
            width: 100%;
        }

        @media (min-width: 768px) {
            .card-header-custom {
                padding: 24px 32px;
            }
        }

        .card-header-custom h4 {
            font-weight: 700;
            font-size: 15px;
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
            padding: 20px;
            width: 100%;
        }

        @media (min-width: 768px) {
            .card-body-custom {
                padding: 24px 32px;
            }
        }

        .form-label {
            font-weight: 600;
            font-size: 13px;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        @media (min-width: 768px) {
            .form-label {
                font-size: 14px;
            }
        }

        .form-control {
            border: 1.5px solid var(--border);
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 13px;
            transition: all 0.2s;
            background: #ffffff;
        }

        @media (min-width: 768px) {
            .form-control {
                padding: 12px 16px;
                font-size: 14px;
            }
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 77, 107, 0.1);
            outline: none;
        }

        .form-text {
            font-size: 11px;
            color: var(--text-muted);
        }

        @media (min-width: 768px) {
            .form-text {
                font-size: 12px;
            }
        }

        .pesan-error {
            font-size: 12px;
            color: #dc2626;
            margin-top: 5px;
            display: none;
        }

        .btn-primary {
            background: var(--primary);
            border: none;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 13px;
            transition: all 0.3s;
        }

        @media (min-width: 768px) {
            .btn-primary {
                padding: 12px 24px;
                font-size: 14px;
            }
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(26, 77, 107, 0.15);
        }

        .footer {
            width: 100%;
            background-color: #ffffff;
            border-top: 1px solid #e9edf2;
            text-align: center;
            padding: 18px 20px;
            font-size: 13px;
            color: #6c7e8f;
            margin-top: auto;
            margin-bottom: 0;
        }
    </style>
</head>
<body>

<div class="top-nav">
    <div class="logo-area">
        <img src="../assets/logo.jpg" alt="Logo Diskominfo" class="logo-img">
        <div class="logo-text">
            <h4>Diskominfo Singkawang</h4>
            <p>Sistem Pelayanan Pengaduan</p>
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
            <h4><i class="fas fa-user-edit" style="color: var(--primary);"></i> Edit Profil Saya</h4>
            <p>Perbarui informasi data diri dan kata sandi Anda</p>
        </div>
        <div class="card-body-custom">
            <?= $pesan ?>
            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($user['nama'] ?? '', ENT_QUOTES) ?>" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username'] ?? '', ENT_QUOTES) ?>" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '', ENT_QUOTES) ?>">
                    </div>
                    <div class="col-md-6 mb-4">
                        <label class="form-label">Nomor Telepon / WhatsApp</label>
                        <input type="tel" name="no_hp" class="form-control" value="<?= htmlspecialchars($user['no_hp'] ?? '', ENT_QUOTES) ?>">
                    </div>
                    <div class="col-md-12 mb-4">
                        <label class="form-label">Kata Sandi Baru <small class="text-muted">(Kosongkan jika tidak ingin mengubah)</small></label>
                        <input type="password" name="password_baru" id="password_baru" class="form-control" placeholder="Masukkan sandi baru..." minlength="8" maxlength="10">
                        <div class="form-text">Syarat: 8 - 10 karakter, wajib ada huruf dan angka</div>
                        <div id="pesanPass" class="pesan-error">Password tidak memenuhi syarat!</div>
                    </div>
                </div>
                <button type="submit" name="simpan" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</div>

<div class="footer">
    © <?= date('Y') ?> Dinas Komunikasi dan Informatika Kota Singkawang &nbsp;•&nbsp; Sistem Pelayanan Pengaduan Masyarakat
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Validasi otomatis di halaman -->
<script>
const polaPass = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*_\-+=?]{8,10}$/;
const inputPass = document.getElementById('password_baru');
const pesanError = document.getElementById('pesanPass');

inputPass.addEventListener('input', function() {
    if(this.value === "") {
        pesanError.style.display = 'none';
        this.setCustomValidity('');
    } else if (!polaPass.test(this.value)) {
        pesanError.style.display = 'block';
        this.setCustomValidity('Password tidak valid');
    } else {
        pesanError.style.display = 'none';
        this.setCustomValidity('');
    }
});
</script>

</body>
</html>