<?php
session_start();
include "config.php";

// Cek apakah ada token di URL
if(!isset($_GET['token']) || empty($_GET['token'])){
    header("Location: login.php");
    exit;
}

$token = mysqli_real_escape_string($conn, $_GET['token']);
$sekarang = date("Y-m-d H:i:s");

// Cek token dulu
$cek_token = mysqli_query($conn, "SELECT * FROM password_resets WHERE token = '$token'");

if(mysqli_num_rows($cek_token) > 0){
    $data_reset = mysqli_fetch_assoc($cek_token);
    $user_id_reset = $data_reset['user_id'];
    $waktu_kadaluarsa = $data_reset['expired_at'];

    // Cek kadaluarsa
    if($sekarang > $waktu_kadaluarsa){
        $pesan = "❌ Tautan ini sudah kadaluarsa (lebih dari 1 jam). Silakan minta ulang.";
        $tipe = "gagal";
        $tampil_form = false;
    } else {
        $tampil_form = true;
        $pesan = "";
    }

} else {
    $pesan = "❌ Tautan tidak valid atau sudah pernah dipakai. Silakan minta ulang.";
    $tipe = "gagal";
    $tampil_form = false;
}

// Proses Ubah Password
if(isset($_POST['ubah']) && $tampil_form){
    $pass_baru = trim($_POST['password_baru']);
    $konfirmasi = trim($_POST['konfirmasi_password']);

    // ✅ Aturan validasi baru: 8-10 karakter, ada huruf + angka
    $aturan_pass = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*_\-+=?]{8,10}$/';

    if($pass_baru != $konfirmasi){
        $pesan = "❌ Password dan konfirmasi tidak sama!";
        $tipe = "gagal";
    } elseif(!preg_match($aturan_pass, $pass_baru)){
        $pesan = "❌ Password harus 8 - 10 karakter, mengandung huruf dan angka, tanpa spasi!";
        $tipe = "gagal";
    } else {
        // Enkripsi pakai MD5
        $pass_baru_md5 = md5($pass_baru);

        // Update ke database
        mysqli_query($conn, "UPDATE users SET password = '$pass_baru_md5' WHERE id = '$user_id_reset'");
        
        // Hapus token agar tidak bisa dipakai lagi
        mysqli_query($conn, "DELETE FROM password_resets WHERE user_id = '$user_id_reset'");

        // Catat ke audit log
        mysqli_query($conn,"INSERT INTO audit_log (user_id, aktivitas, created_at)
                            VALUES ('$user_id_reset', 'Berhasil mengubah password (Lupa Password)', NOW())");

        $pesan = "✅ Password berhasil diubah! Silakan login kembali dengan password baru.";
        $tipe = "berhasil";
        $tampil_form = false;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body {
            background-image: url('assets/bck.jpg');
            background-size: cover;
            background-position: center;
            display: flex; justify-content: center; align-items: center;
            min-height: 100vh; position: relative;
        }
        body::before {
            content: ''; position: fixed; top:0; left:0; right:0; bottom:0;
            background: rgba(0,0,0,0.65); z-index:0;
        }
        .box {
            position: relative; z-index:1; background: white; padding: 40px 30px;
            border-radius: 20px; width: 100%; max-width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .box h2 { text-align: center; color: #1a3c5e; margin-bottom: 20px; }
        .alert { padding:15px; border-radius:8px; margin-bottom:20px; font-size:14px; text-align:center; line-height:1.4; }
        .alert.berhasil { background: #d1fae5; color: #065f46; border-left:4px solid #065f46; }
        .alert.gagal { background: #fee2e2; color: #991b1b; border-left:4px solid #991b1b; }
        .input-group { margin-bottom: 20px; }
        .input-group label { display:block; font-size:13px; color:#2d3e50; margin-bottom:6px; }
        .input-group input {
            width:100%; padding:14px 16px; border-radius:12px; border:1.5px solid #e2e8f0;
            font-size:14px; background:#f8fafc;
        }
        .input-group input:focus {
            outline: none;
            border-color: #1a5a7a;
            box-shadow: 0 0 0 3px rgba(26, 90, 122, 0.1);
        }
        .info-pass {
            font-size: 11px;
            color: #6c7e8f;
            margin-top: 5px;
            line-height: 1.5;
        }
        .pesan-error {
            font-size: 12px;
            color: #dc2626;
            margin-top: 5px;
            display: none;
        }
        .btn-ubah {
            width:100%; padding:14px; border:none; border-radius:12px;
            background: linear-gradient(135deg, #1a5a7a 0%, #0f3b54 100%);
            color:white; font-weight:600; cursor:pointer; transition:0.3s;
            font-size:15px;
        }
        .btn-ubah:hover { transform: translateY(-2px); box-shadow:0 5px 15px rgba(26, 90, 122, 0.2); }
        .link-kembali { text-align:center; margin-top:20px; font-size:13px; }
        .link-kembali a { color:#1a5a7a; text-decoration:none; font-weight:500; }
        .link-kembali a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Buat Password Baru</h2>

        <?php if($pesan != ""){ ?>
            <div class="alert <?= $tipe ?>"><?= $pesan ?></div>
        <?php } ?>

        <?php if($tampil_form): ?>
        <form method="POST">
            <div class="input-group">
                <label>Password Baru</label>
                <input type="password" name="password_baru" id="password_baru" placeholder="Masukkan password baru" required minlength="8" maxlength="10">
                <div class="info-pass">Syarat: 8 - 10 karakter, wajib ada huruf dan angka</div>
                <div id="pesanPass" class="pesan-error">Password tidak memenuhi syarat!</div>
            </div>
            <div class="input-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="konfirmasi_password" id="konfirmasi_password" placeholder="Ulangi password baru" required>
            </div>
            <button type="submit" name="ubah" class="btn-ubah">Simpan Password Baru</button>
        </form>
        <?php endif; ?>

        <div class="link-kembali">
            <a href="login.php">← Kembali ke Halaman Login</a>
        </div>
    </div>

    <!-- Validasi otomatis di halaman -->
    <script>
    const polaPass = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*_\-+=?]{8,10}$/;
    const inputPass = document.getElementById('password_baru');
    const pesanError = document.getElementById('pesanPass');

    inputPass.addEventListener('input', function() {
        if (!polaPass.test(this.value)) {
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