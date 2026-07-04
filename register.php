<?php
session_start();
include "config.php";

$error = "";
$success = "";

if(isset($_POST['register'])){

    $nama     = mysqli_real_escape_string($conn,$_POST['nama']);
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $email    = mysqli_real_escape_string($conn,$_POST['email']);
    $no_hp    = mysqli_real_escape_string($conn,$_POST['no_hp']);
    $password = trim($_POST['password']);

    // ✅ Aturan validasi password: 8-10 karakter, ada huruf + angka
    $aturan_pass = '/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*_\-+=?]{8,10}$/';

    // Cek apakah password memenuhi syarat
    if(!preg_match($aturan_pass, $password)){
        $error = "Password harus 8 - 10 karakter, mengandung huruf dan angka, tanpa spasi!";
    } else {
        // Enkripsi pakai MD5 sesuai sistem kamu
        $password = md5($password);

        $cek = mysqli_query($conn,"SELECT * FROM users WHERE username='$username' OR email='$email'");

        if(mysqli_num_rows($cek) > 0){
            $error = "Username atau Email sudah digunakan!";
        } else {

            $insert = mysqli_query($conn,"INSERT INTO users 
                (nama,username,email,no_hp,password,role)
                VALUES 
                ('$nama','$username','$email','$no_hp','$password','user')");

            if($insert){
                $success = "Registrasi berhasil! Silakan login.";
            } else {
                $error = "Registrasi gagal!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Pengaduan Masyarakat</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        :root {
            --primary: #1a4d6b;
            --primary-dark: #0e3a52;
            --primary-light: #2c6e8f;
            --success: #2d6a4f;
            --danger: #9d2a2a;
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
            background-image: url('assets/bck.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.65);
            z-index: 0;
        }

        .register-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 460px;
            padding: 20px;
        }

        .register-box {
            background: rgba(255, 255, 255, 0.98);
            padding: 40px 35px;
            border-radius: 24px;
            width: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(2px);
            transition: transform 0.3s ease;
        }

        .register-box:hover {
            transform: translateY(-5px);
        }

        .logo-icon {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-icon img{
            width: 90px;
            height: 90px;
            object-fit: contain;
            border-radius: 18px;
            background: white;
            padding: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .register-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .register-header h2 {
            font-size: 26px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }

        .register-header p {
            color: var(--text-muted);
            font-size: 14px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        .input-group label i {
            margin-right: 6px;
            color: var(--primary);
        }

        .input-group input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1.5px solid var(--border);
            font-size: 14px;
            background: #f8fafc;
            transition: 0.2s;
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(26, 77, 107, 0.1);
        }

        .info-pass {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 5px;
            line-height: 1.5;
        }

        .pesan-error {
            font-size: 12px;
            color: #dc2626;
            margin-top: 5px;
            display: none;
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26, 77, 107, 0.3);
        }

        .error {
            background: #fee2e2;
            color: var(--danger);
            margin-bottom: 20px;
            padding: 12px;
            border-radius: 12px;
            font-size: 13px;
            border-left: 4px solid var(--danger);
        }

        .success {
            background: #e6f4ea;
            color: var(--success);
            margin-bottom: 20px;
            padding: 12px;
            border-radius: 12px;
            font-size: 13px;
            border-left: 4px solid var(--success);
        }

        .login-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .login-link a {
            text-decoration: none;
            color: var(--primary);
            font-weight: 600;
        }

        @media (max-width: 480px) {
            .register-box {
                padding: 30px 24px;
            }
        }
    </style>
</head>
<body>

<div class="register-container">
    <div class="register-box">

        <div class="logo-icon">
            <img src="assets/logo.jpg" alt="Logo Diskominfo">
        </div>

        <div class="register-header">
            <h2>Daftar Akun Baru</h2>
            <p>Silakan isi formulir di bawah ini untuk mendaftar</p>
        </div>

        <?php if($error != ""){ ?>
            <div class="error">
                <i class="fas fa-exclamation-circle"></i>
                <?= $error ?>
            </div>
        <?php } ?>

        <?php if($success != ""){ ?>
            <div class="success">
                <i class="fas fa-check-circle"></i>
                <?= $success ?>
            </div>
        <?php } ?>

        <form method="POST">

            <div class="input-group">
                <label><i class="fas fa-user"></i> Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="input-group">
                <label><i class="fas fa-at"></i> Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required>
            </div>

            <div class="input-group">
                <label><i class="fas fa-envelope"></i> Email</label>
                <input type="email" name="email" placeholder="Masukkan email" required>
            </div>

            <div class="input-group">
                <label><i class="fas fa-phone"></i> Nomor HP</label>
                <input type="text" name="no_hp" placeholder="Contoh: 08123456789" required>
            </div>

            <div class="input-group">
                <label><i class="fas fa-lock"></i> Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password" required minlength="8" maxlength="10">
                <div class="info-pass">Syarat: 8 - 10 karakter, wajib ada huruf dan angka</div>
                <div id="pesanPass" class="pesan-error">Password tidak memenuhi syarat!</div>
            </div>

            <button type="submit" name="register" class="btn-register">
                <i class="fas fa-user-plus"></i> Daftar Sekarang
            </button>

        </form>

        <div class="login-link">
            <span>Sudah punya akun?</span>
            <a href="login.php"> Masuk ke Dashboard</a>
        </div>

    </div>
</div>

<!-- Validasi otomatis di halaman -->
<script>
const polaPass = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*_\-+=?]{8,10}$/;
const inputPass = document.getElementById('password');
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