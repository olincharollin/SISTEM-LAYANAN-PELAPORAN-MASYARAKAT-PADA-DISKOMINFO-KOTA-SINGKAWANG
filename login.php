<?php
session_start();
include "config.php";

$error = "";

function getIP(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
    return $_SERVER['REMOTE_ADDR'];
}

if(isset($_POST['login'])){

    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $password = md5($_POST['password']); // Tetap pakai md5 sesuai sistem kamu
    $ip = getIP();

    $query = mysqli_query($conn,"SELECT * FROM users WHERE username='$username' AND password='$password'");

    if(mysqli_num_rows($query) > 0){

        $data = mysqli_fetch_assoc($query);

        // ✅ CEK PENTING: APAKAH AKUN DIBLOKIR?
        if($data['status'] == 'blokir'){
            // Catat ke log sebagai gagal
            mysqli_query($conn,"INSERT INTO login_history (user_id, username, status_login, ip_address)
                                VALUES (NULL, '$username', 'Gagal - Akun Diblokir', '$ip')");
            $error = "❌ Akun Anda telah diblokir. Silakan hubungi Admin!";
        } else {
            // ✅ AKUN AKTIF: BUAT SESI
            $_SESSION['id'] = $data['id'];
            $_SESSION['nama'] = $data['nama'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['role'] = $data['role'];

            // ✅ PERBAIKAN LOG: Tadi salah tulis 'Gagal', sekarang jadi 'Berhasil' & lengkapi data
            mysqli_query($conn,"INSERT INTO login_history (user_id, username, status_login, ip_address)
                                VALUES ('$data[id]', '$username', 'Berhasil', '$ip')");
                                
            // ✅ SIMPAN KE AUDIT LOG (SESUAI STRUKTUR KAMU)
            mysqli_query($conn,"INSERT INTO audit_log (user_id, aktivitas, created_at)
                                VALUES ('$data[id]', 'Berhasil masuk ke sistem', NOW())");

            // ✅ ARAHKAN KE DASHBOARD
            if($data['role'] == "admin"){
                header("Location: admin/dashboard.php");
            } else {
                header("Location: user/dashboard.php");
            }
            exit;
        }

    } else {
        // ✅ LOGIN GAGAL (Salah Username/Password)
        mysqli_query($conn,"INSERT INTO login_history (user_id, username, status_login, ip_address)
                            VALUES (NULL, '$username', 'Gagal - Username/Password Salah', '$ip')");

        $error = "❌ Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pelayanan Pengaduan Masyarakat</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            background-image: url('assets/bck.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            position: relative;
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

        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.98);
            padding: 40px 35px;
            border-radius: 24px;
            width: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(2px);
            transition: transform 0.3s ease;
        }

        .login-box:hover {
            transform: translateY(-5px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-header h2 {
            font-size: 26px;
            font-weight: 700;
            background: linear-gradient(135deg, #1a3c5e 0%, #0f2b44 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #6c7e8f;
            font-size: 14px;
            font-weight: 400;
        }

        .back-btn {
            display: inline-block;
            margin-top: 16px;
            text-decoration: none;
            background: #f1f5f9;
            color: #1a5a7a;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s ease;
            border: 1px solid #dbeafe;
        }

        .back-btn:hover {
            background: #dbeafe;
            color: #0f3b54;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #2d3e50;
            margin-bottom: 6px;
        }

        .input-group input {
            width: 100%;
            padding: 14px 16px;
            border-radius: 12px;
            border: 1.5px solid #e2e8f0;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s ease;
            background: #f8fafc;
        }

        .input-group input:focus {
            outline: none;
            border-color: #1a5a7a;
            background: white;
            box-shadow: 0 0 0 3px rgba(26, 90, 122, 0.1);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: linear-gradient(135deg, #1a5a7a 0%, #0f3b54 100%);
            color: white;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #0f4a66 0%, #0a2e42 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(26, 90, 122, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .error {
            background: #fee2e2;
            color: #9e2a2a;
            text-align: center;
            margin-bottom: 20px;
            padding: 12px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 500;
            border-left: 4px solid #9e2a2a;
        }

        .register-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e8edf2;
        }

        .register-link a {
            text-decoration: none;
            color: #1a5a7a;
            font-weight: 600;
            font-size: 14px;
            transition: color 0.2s;
        }

        .register-link a:hover {
            color: #0f3b54;
            text-decoration: underline;
        }

        .register-link span {
            color: #6c7e8f;
            font-size: 13px;
        }

        /* ✅ TAMBAH STYLE UNTUK LUPA PASSWORD */
        .lupa-password-link {
            text-align: center;
            margin-top: 12px;
        }
        .lupa-password-link a {
            color: #9e2a2a;
            font-size: 13px;
            text-decoration: none;
            font-weight: 500;
        }
        .lupa-password-link a:hover {
            text-decoration: underline;
        }

        .logo-icon {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo-icon .icon-circle {
            width: 70px;
            height: 70px;
            background: white;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            overflow: hidden;
            border: 2px solid #dbeafe;
            box-shadow: 0 4px 12px rgba(26, 90, 122, 0.15);
        }

        .logo-icon .icon-circle img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 6px;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 16px;
            }

            .login-box {
                padding: 30px 24px;
            }

            .login-header h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-box">

        <!-- LOGO DISKOMINFO -->
        <div class="logo-icon">
            <div class="icon-circle">
                <img src="assets/logo.jpg" alt="Logo Diskominfo">
            </div>
        </div>

        <div class="login-header">
            <h3>Selamat Datang</h3>
            <p>Silakan masuk ke akun Anda</p>

            <a href="index.php" class="back-btn">
                ← Kembali ke Beranda
            </a>
        </div>

        <?php if($error != ""){ ?>
            <div class="error">
                <?= $error ?>
            </div>
        <?php } ?>

        <form method="POST">

            <div class="input-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required autocomplete="off">
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" name="login" class="btn-login">
                Masuk ke Dashboard
            </button>

        </form>

        <!-- ✅ TAMBAHAN: LINK LUPA PASSWORD -->
        <div class="lupa-password-link">
            <a href="lupa_password.php">Lupa Password?</a>
        </div>

        <div class="register-link">
            <span>Belum punya akun?</span>
            <a href="register.php"> Daftar Sekarang</a>
        </div>

    </div>
</div>

</body>
</html>