<?php
session_start();
include "../config.php";

if(!isset($_SESSION['role']) || $_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit;
}

$error = "";
$success = "";

/* ======================
   TAMBAH DATA
====================== */
if(isset($_POST['tambah'])){
    $nama = mysqli_real_escape_string($conn,$_POST['nama_layanan']);
    $nomor = mysqli_real_escape_string($conn,$_POST['nomor_telepon']);
    $ket = mysqli_real_escape_string($conn,$_POST['keterangan']);

    if($nama == "" || $nomor == ""){
        $error = "Nama layanan dan nomor telepon wajib diisi!";
    } else {
        mysqli_query($conn,"INSERT INTO nomor_darurat (nama_layanan, nomor_telepon, keterangan)
                            VALUES ('$nama','$nomor','$ket')");
        $success = "Nomor darurat berhasil ditambahkan!";
    }
}

/* ======================
   UPDATE DATA
====================== */
if(isset($_POST['update'])){
    $id = (int)$_POST['id'];
    $nama = mysqli_real_escape_string($conn,$_POST['nama_layanan']);
    $nomor = mysqli_real_escape_string($conn,$_POST['nomor_telepon']);
    $ket = mysqli_real_escape_string($conn,$_POST['keterangan']);

    mysqli_query($conn,"UPDATE nomor_darurat 
                        SET nama_layanan='$nama',
                            nomor_telepon='$nomor',
                            keterangan='$ket'
                        WHERE id='$id'");
    $success = "Data berhasil diperbarui!";
}

/* ======================
   DELETE DATA
====================== */
if(isset($_GET['delete'])){
    $id = (int)$_GET['delete'];
    mysqli_query($conn,"DELETE FROM nomor_darurat WHERE id='$id'");
    header("Location: nomor_darurat.php");
    exit;
}

/* ======================
   AMBIL DATA EDIT
====================== */
$editData = null;
if(isset($_GET['edit'])){
    $id = (int)$_GET['edit'];
    $editQuery = mysqli_query($conn,"SELECT * FROM nomor_darurat WHERE id='$id'");
    $editData = mysqli_fetch_assoc($editQuery);
}

/* ======================
   DATA LIST
====================== */
$data = mysqli_query($conn,"SELECT * FROM nomor_darurat ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Kelola Nomor Darurat - Admin Panel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css22?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
            position: relative;
            width: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            padding-top: 90px; /* JARAK DI ATAS AGAR TIDAK TERTIMPA */
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
           TOPBAR - DIPERBAIKI
        ====================== */
        .top-nav {
            width: 100%;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            position: fixed; /* TETAP DI ATAS */
            top: 0;
            left: 0;
            right: 0;
            z-index: 999; /* PALING TINGGI */
            background: rgba(255, 255, 255, 0.95); /* AGAR JELAS */
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        @media (min-width: 768px) {
            .top-nav {
                padding: 16px 32px;
                flex-wrap: nowrap;
            }
            body {
                padding-top: 100px; /* Jarak lebih besar di layar besar */
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
            font-size: 15px;
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
            font-size: 11px;
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

        /* ======================
           CONTENT
        ====================== */
        .content {
            width: 100%;
            max-width: 100%;
            padding: 0 15px 20px 15px;
            flex: 1;
            position: relative;
            z-index: 1;
        }

        @media (min-width: 768px) {
            .content {
                padding: 0 32px 32px 32px;
            }
        }

        /* ======================
           CARD
        ====================== */
        .card {
            background: var(--white);
            border: none;
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: all 0.3s;
            margin-bottom: 20px;
            overflow: hidden;
            width: 100%;
        }

        @media (min-width: 768px) {
            .card {
                border-radius: 20px;
                margin-bottom: 28px;
            }
        }

        .card:hover {
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.08);
        }

        .card-header-custom {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border);
            background: var(--white);
        }

        @media (min-width: 768px) {
            .card-header-custom {
                padding: 20px 28px;
            }
        }

        .card-header-custom h5 {
            font-weight: 700;
            font-size: 15px;
            color: var(--text-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @media (min-width: 768px) {
            .card-header-custom h5 {
                font-size: 16px;
            }
        }

        .card-body-custom {
            padding: 18px 20px;
        }

        @media (min-width: 768px) {
            .card-body-custom {
                padding: 24px 28px;
            }
        }

        /* ======================
           FORM
        ====================== */
        .form-label {
            font-weight: 600;
            font-size: 13px;
            color: var(--text-dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-label i {
            color: var(--primary);
        }

        .form-control {
            border: 1.5px solid var(--border);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            width: 100%;
        }

        @media (min-width: 768px) {
            .form-control {
                border-radius: 12px;
                padding: 10px 16px;
            }
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(26, 77, 107, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        /* ======================
           BUTTONS
        ====================== */
        .btn-custom {
            padding: 9px 18px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 13px;
            border: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            margin: 4px 0;
        }

        @media (min-width: 768px) {
            .btn-custom {
                padding: 10px 24px;
                border-radius: 12px;
            }
        }

        .btn-primary-custom {
            background: var(--primary);
            color: white;
        }
        .btn-primary-custom:hover { background: var(--primary-dark); transform: translateY(-1px); }

        .btn-warning-custom {
            background: var(--warning);
            color: white;
        }
        .btn-warning-custom:hover { background: #9a5600; transform: translateY(-1px); }

        .btn-danger-custom {
            background: var(--danger);
            color: white;
        }
        .btn-danger-custom:hover { background: #7a1f1f; transform: translateY(-1px); }

        .btn-secondary-custom {
            background: var(--gray-bg);
            color: var(--text-dark);
        }
        .btn-secondary-custom:hover { background: #e4e9f0; transform: translateY(-1px); }

        /* ======================
           TABLE
        ====================== */
        .table-container {
            overflow-x: auto;
            width: 100%;
            -webkit-overflow-scrolling: touch;
        }

        .table-custom {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            min-width: 750px;
        }

        .table-custom thead th {
            background: var(--gray-bg);
            padding: 12px 10px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: var(--text-muted);
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }

        @media (min-width: 768px) {
            .table-custom thead th {
                padding: 14px 16px;
            }
        }

        .table-custom tbody td {
            padding: 12px 10px;
            font-size: 13px;
            color: var(--text-dark);
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }

        @media (min-width: 768px) {
            .table-custom tbody td {
                padding: 14px 16px;
            }
        }

        .table-custom tbody tr:hover td {
            background: var(--gray-bg);
        }

        .phone-number {
            font-family: monospace;
            font-weight: 600;
            color: var(--primary);
            font-size: 13px;
        }

        /* ======================
           ALERT
        ====================== */
        .alert-custom {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        @media (min-width: 768px) {
            .alert-custom {
                padding: 14px 18px;
                border-radius: 14px;
                margin-bottom: 24px;
            }
        }

        .alert-danger {
            background: #fee2e2;
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }
        .alert-success {
            background: #e6f4ea;
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        /* ======================
           FOOTER
        ====================== */
        .footer {
            width: 100%;
            padding: 15px 20px;
            background: var(--white);
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
            margin-top: auto;
            box-shadow: 0 -2px 8px rgba(13,46,94,0.04);
            position: relative;
            z-index: 10;
        }

        @media (min-width: 768px) {
            .footer {
                padding: 20px 32px;
                font-size: 12px;
            }
        }

        .footer span {
            display: inline-block;
            margin: 0 4px;
        }
    </style>
</head>
<body>

<!-- TOPBAR - DIPERBAIKI POSISINYA -->
<div class="top-nav">
    <div class="logo-area">
        <img src="../assets/logo.jpg" alt="Logo Diskominfo" class="logo-img">
        <div class="logo-text">
            <h4>Diskominfo Singkawang</h4>
            <p>Admin Panel - Kelola Nomor Darurat</p>
        </div>
    </div>

    <a href="dashboard.php" class="back-btn">
        <i class="fas fa-arrow-left"></i> <span class="d-none d-sm-inline">Kembali ke Dashboard</span>
        <span class="d-inline d-sm-none">Kembali</span>
    </a>
</div>

<!-- CONTENT -->
<div class="content">

    <div class="card">
        <div class="card-header-custom">
            <h5>
                <i class="fas fa-phone-alt" style="color: var(--primary);"></i>
                Kelola Nomor Darurat
            </h5>
        </div>
        <div class="card-body-custom">
            <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 20px;">
                Admin dapat menambahkan, mengedit, dan menghapus informasi nomor darurat.
            </p>

            <?php if($error != ""){ ?>
                <div class="alert-custom alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= $error ?>
                </div>
            <?php } ?>

            <?php if($success != ""){ ?>
                <div class="alert-custom alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?= $success ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- FORM TAMBAH / EDIT -->
    <div class="card">
        <div class="card-header-custom">
            <h5>
                <i class="fas <?= $editData ? 'fa-edit' : 'fa-plus-circle' ?>" style="color: var(--primary);"></i>
                <?= $editData ? "Edit Nomor Darurat" : "Tambah Nomor Darurat" ?>
            </h5>
        </div>
        <div class="card-body-custom">
            <form method="POST">
                <?php if($editData){ ?>
                    <input type="hidden" name="id" value="<?= $editData['id'] ?>">
                <?php } ?>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-building"></i> Nama Layanan
                    </label>
                    <input type="text" name="nama_layanan" class="form-control" required
                        value="<?= $editData ? htmlspecialchars($editData['nama_layanan']) : "" ?>"
                        placeholder="Contoh: Kepolisian, PLN, Dinas Kesehatan">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-phone"></i> Nomor Telepon
                    </label>
                    <input type="text" name="nomor_telepon" class="form-control" required
                        value="<?= $editData ? htmlspecialchars($editData['nomor_telepon']) : "" ?>"
                        placeholder="Contoh: 110, 119, 08123456789">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fas fa-info-circle"></i> Keterangan (Opsional)
                    </label>
                    <textarea name="keterangan" class="form-control" rows="3" 
                        placeholder="Informasi tambahan tentang layanan ini"><?= $editData ? htmlspecialchars($editData['keterangan']) : "" ?></textarea>
                </div>

                <?php if($editData){ ?>
                    <button type="submit" name="update" class="btn-custom btn-warning-custom">
                        <i class="fas fa-save"></i> Update Data
                    </button>
                    <a href="nomor_darurat.php" class="btn-custom btn-secondary-custom">
                        <i class="fas fa-times"></i> Batal
                    </a>
                <?php } else { ?>
                    <button type="submit" name="tambah" class="btn-custom btn-primary-custom">
                        <i class="fas fa-save"></i> Tambah Nomor
                    </button>
                <?php } ?>
            </form>
        </div>
    </div>

    <!-- LIST DATA -->
    <div class="card">
        <div class="card-header-custom">
            <h5>
                <i class="fas fa-list" style="color: var(--primary);"></i>
                Daftar Nomor Darurat
            </h5>
        </div>
        <div class="card-body-custom" style="padding: 0;">
            <div class="table-container">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>Nama Layanan</th>
                            <th>Nomor Telepon</th>
                            <th>Keterangan</th>
                            <th style="width: 130px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no = 1;
                    if(mysqli_num_rows($data) > 0){
                    while($row = mysqli_fetch_assoc($data)){
                    ?>
                        <tr>
                            <td style="text-align: center;"><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['nama_layanan']) ?></td>
                            <td><span class="phone-number"><?= htmlspecialchars($row['nomor_telepon']) ?></span></td>
                            <td><?= htmlspecialchars($row['keterangan']) ?: '<span style="color: var(--text-muted);">-</span>' ?></td>
                            <td>
                                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                    <a href="?edit=<?= $row['id'] ?>" class="btn-custom btn-warning-custom" style="padding: 5px 10px; font-size: 12px;">
                                        <i class="fas fa-edit"></i> <span class="d-none d-md-inline">Edit</span>
                                    </a>
                                    <a href="?delete=<?= $row['id'] ?>" class="btn-custom btn-danger-custom" style="padding: 5px 10px; font-size: 12px;"
                                       onclick="return confirm('Yakin ingin menghapus data ini?')">
                                        <i class="fas fa-trash"></i> <span class="d-none d-md-inline">Hapus</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php } } else { ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 40px 20px; color: var(--text-muted);">
                                <i class="fas fa-phone-slash" style="font-size: 40px; margin-bottom: 12px; display: block; opacity: 0.5;"></i>
                                <p style="font-size: 14px;">Belum ada nomor darurat yang ditambahkan</p>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- FOOTER -->
<div class="footer">
    <i class="fas fa-shield-alt"></i>
    <span>Sistem Informasi Pelayanan Masyarakat © <?= date("Y") ?></span>
    <span>|</span>
    <span>Dinas Komunikasi dan Informatika Kota Singkawang</span>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>