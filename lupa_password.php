<?php
session_start();
include "config.php";

// ✅ LOAD PHPMailer - SUDAH BENAR
require 'lib/PHPMailer/Exception.php';
require 'lib/PHPMailer/PHPMailer.php';
require 'lib/PHPMailer/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$pesan = "";
$tipe = "";

if(isset($_POST['kirim'])){
    // ✅ AMBIL EMAIL YANG DIKETIK PENGGUNA DI KOLOM INPUT
    $email_input = mysqli_real_escape_string($conn, $_POST['email']);
    
    // ✅ CEK APAKAH EMAIL ITU ADA DI TABEL USERS (SEMUA USER, SIAPA SAJA)
    $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email_input'");
    
    if(mysqli_num_rows($cek_user) > 0){
        $data_user = mysqli_fetch_assoc($cek_user);
        $user_id   = $data_user['id'];
        $nama_user = $data_user['nama']; // Ambil nama sesuai pemilik email itu

        // ✅ BUAT TOKEN
        $token = md5(uniqid(rand(), true));
        $waktu_sekarang = date("Y-m-d H:i:s");
        $kadaluarsa = date("Y-m-d H:i:s", strtotime("+1 hours"));

        mysqli_query($conn, "DELETE FROM password_resets WHERE user_id = '$user_id'");
        mysqli_query($conn, "INSERT INTO password_resets (user_id, token, created_at, expired_at) 
                              VALUES ('$user_id', '$token', '$waktu_sekarang', '$kadaluarsa')");

        // 🔔 KIRIM EMAIL
        $mail = new PHPMailer(true);
        try {
            // ✅ PENGATURAN PENGIRIM (TETAP SATU INI SAJA, SUDAH BENAR)
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'yustamelvincha03@gmail.com';   // ✅ TETAP INI, JANGAN UBAH
            $mail->Password   = 'dgur vabe dmwc lmfz';         // ✅ TETAP INI, JANGAN UBAH
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;   // ✅ PENGATURAN BARU LEBIH AMAN
            $mail->Port       = 465;                           // ✅ PENGATURAN BARU LEBIH AMAN
            $mail->CharSet    = 'UTF-8';

            // ✅ PENGIRIM TETAP SAMA
            $mail->setFrom('yustamelvincha03@gmail.com', 'Sistem Pelayanan Diskominfo');
            
            // ✅ PENERIMA ADALAH EMAIL YANG DIKETIK PENGGUNA (INI YANG DIPERBAIKI)
            $mail->addAddress($email_input, $nama_user); 

            // ✅ LINK RESET (KHUSUS LARAGON)
            $link_reset = "http://192.168.142.209/pelayanan/reset_password.php?token=$token";

            $mail->isHTML(true);
            $mail->Subject = 'Permintaan Reset Password - Sistem Pelayanan';
            $mail->Body    = "
            <h3>Halo, {$nama_user}</h3>
            <p>Kamu meminta untuk mereset kata sandi akunmu.</p>
            <p>Klik tautan di bawah ini untuk membuat kata sandi baru:</p>
            <a href='$link_reset' style='background:#1a5a7a; color:white; padding:10px 15px; border-radius:8px; text-decoration:none; display:inline-block; margin:10px 0;'>Reset Password</a>
            <p>Link ini berlaku selama <b>1 jam</b>. Jika kamu tidak meminta ini, abaikan email ini.</p>
            <hr>
            <small>Sistem Pelayanan Pengaduan Masyarakat</small>
            ";

            $mail->send();
            $pesan = "✅ Tautan reset password telah dikirim ke <b>$email_input</b>. Silakan cek inbox atau folder Spam.";
            $tipe = "berhasil";

        } catch (Exception $e) {
            $pesan = "❌ Gagal: " . $mail->ErrorInfo;
            $tipe = "gagal";
        }

    } else {
        // ❌ JIKA EMAIL YANG DIKETIK TIDAK ADA DI DATABASE
        $pesan = "❌ Email <b>$email_input</b> tidak terdaftar di sistem kami!";
        $tipe = "gagal";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Sistem Pelayanan</title>
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
        .box h2 { text-align: center; color: #1a3c5e; margin-bottom: 10px; }
        .box p { text-align: center; color: #6c7e8f; margin-bottom: 25px; font-size: 14px; }
        .alert { padding:12px; border-radius:8px; margin-bottom:20px; font-size:13px; text-align:center; }
        .alert.berhasil { background: #d1fae5; color: #065f46; border-left:4px solid #065f46; }
        .alert.gagal { background: #fee2e2; color: #991b1b; border-left:4px solid #991b1b; }
        .input-group { margin-bottom: 20px; }
        .input-group label { display:block; font-size:13px; color:#2d3e50; margin-bottom:6px; }
        .input-group input {
            width:100%; padding:14px 16px; border-radius:12px; border:1.5px solid #e2e8f0;
            font-size:14px; background:#f8fafc;
        }
        .btn-kirim {
            width:100%; padding:14px; border:none; border-radius:12px;
            background: linear-gradient(135deg, #1a5a7a 0%, #0f3b54 100%);
            color:white; font-weight:600; cursor:pointer; transition:0.3s;
        }
        .btn-kirim:hover { transform: translateY(-2px); box-shadow:0 5px 15px rgba(26, 90, 122, 0.2); }
        .link-kembali { text-align:center; margin-top:20px; font-size:13px; }
        .link-kembali a { color:#1a5a7a; text-decoration:none; font-weight:500; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Lupa Password?</h2>
        <p>Masukkan email akunmu, kami akan kirim tautan untuk mereset password.</p>

        <?php if($pesan != ""){ ?>
            <div class="alert <?= $tipe ?>"><?= $pesan ?></div>
        <?php } ?>

        <form method="POST">
            <div class="input-group">
                <label>Alamat Email</label>
                <input type="email" name="email" placeholder="nama@domain.com" required>
            </div>
            <button type="submit" name="kirim" class="btn-kirim">Kirim Tautan Reset</button>
        </form>

        <div class="link-kembali">
            <a href="login.php">← Kembali ke Halaman Login</a>
        </div>
    </div>
</body>
</html>