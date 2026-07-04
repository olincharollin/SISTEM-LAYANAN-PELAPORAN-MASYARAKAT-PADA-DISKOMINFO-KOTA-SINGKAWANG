<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SIPADU — Sistem Pelayanan Pengaduan Masyarakat Kota Singkawang</title>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<style>
:root {
    --navy:  #0d2e5e;
    --blue:  #2563eb;
    --blue2: #1d4ed8;
    --sky:   #bfdbfe;
    --soft:  #eff6ff;
    --soft2: #dbeafe;
    --white: #ffffff;
    --gray:  #64748b;
    --light: #f8faff;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body { font-family: 'Plus Jakarta Sans', sans-serif; background: var(--white); color: var(--navy); overflow-x: hidden; }

/* ── NAVBAR ── */
.navbar {
    position: fixed; top: 0; left: 0; right: 0; z-index: 999;
    height: 68px; padding: 0 5%;
    display: flex; align-items: center; justify-content: space-between;
    background: rgba(255,255,255,0.94);
    backdrop-filter: blur(14px);
    border-bottom: 1px solid rgba(37,99,235,0.1);
    transition: box-shadow .3s;
}
.navbar.scrolled { box-shadow: 0 4px 24px rgba(13,46,94,.1); }
.nav-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }

.nav-logo {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(37,99,235,.15);
    border: 1px solid rgba(37,99,235,.15);
}

.nav-logo img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 4px;
}

.b-title { font-weight: 800; font-size: .95rem; color: var(--navy); }
.b-sub   { font-size: .68rem; color: var(--gray); }

.nav-links { display: flex; align-items: center; gap: 4px; list-style: none; }
.nav-links a {
    color: var(--gray); text-decoration: none;
    font-size: .85rem; font-weight: 600;
    padding: 7px 14px; border-radius: 8px; transition: .2s;
}
.nav-links a:hover { color: var(--blue); background: var(--soft); }

.btn-masuk {
    background: linear-gradient(135deg, var(--blue), var(--blue2)) !important;
    color: #fff !important; font-weight: 700 !important;
    padding: 9px 22px !important; border-radius: 10px !important;
    box-shadow: 0 4px 14px rgba(37,99,235,.3) !important;
}
.btn-masuk:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 22px rgba(37,99,235,.4) !important;
}

.nav-toggle { display: none; background: none; border: none; cursor: pointer; padding: 6px; }
.nav-toggle span { display: block; width: 22px; height: 2px; background: var(--navy); border-radius: 2px; margin: 5px 0; transition: .3s; }

/* ── HERO ── */
.hero {
    min-height: 100vh; position: relative; overflow: hidden;
    display: flex; align-items: center; padding: 100px 5% 60px;
}
.hero-bg {
    position: absolute; inset: 0; z-index: 0;
    background: url('assets/index.webp') center center / cover no-repeat;
}

/* Overlay putih-biru soft */
.hero-overlay {
    position: absolute; inset: 0; z-index: 1;
    background: linear-gradient(
        135deg,
        rgba(255,255,255,0.93) 0%,
        rgba(239,246,255,0.90) 35%,
        rgba(219,234,254,0.80) 65%,
        rgba(191,219,254,0.68) 100%
    );
}

.hero-deco1 {
    position: absolute; top: -80px; right: 6%; z-index: 2;
    width: 380px; height: 380px; border-radius: 50%;
    background: radial-gradient(circle, rgba(37,99,235,.07) 0%, transparent 70%);
    pointer-events: none;
}
.hero-deco2 {
    position: absolute; bottom: -60px; left: 4%; z-index: 2;
    width: 260px; height: 260px; border-radius: 50%;
    background: radial-gradient(circle, rgba(37,99,235,.05) 0%, transparent 70%);
    pointer-events: none;
}

.hero-inner {
    position: relative; z-index: 3; max-width: 1200px; margin: 0 auto; width: 100%;
    display: grid; grid-template-columns: 1.1fr 0.9fr; gap: 60px; align-items: center;
}

.hero-badge {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(37,99,235,.08); border: 1px solid rgba(37,99,235,.18);
    color: var(--blue); font-size: .73rem; font-weight: 700;
    padding: 6px 14px; border-radius: 20px; margin-bottom: 22px;
    text-transform: uppercase; letter-spacing: .05em;
    animation: fadeUp .6s ease both;
}

.hero-title {
    font-family: 'Playfair Display', serif;
    font-size: clamp(2rem, 3.8vw, 3.1rem);
    font-weight: 800; line-height: 1.18; color: var(--navy);
    margin-bottom: 18px; animation: fadeUp .7s ease .1s both;
}
.hero-title .accent { color: var(--blue); }

.hero-desc {
    font-size: .97rem; color: var(--gray); line-height: 1.8;
    margin-bottom: 32px; max-width: 480px;
    animation: fadeUp .7s ease .2s both;
}

.hero-actions { display: flex; gap: 12px; flex-wrap: wrap; animation: fadeUp .7s ease .3s both; }

.btn-p {
    display: inline-flex; align-items: center; gap: 8px;
    background: linear-gradient(135deg, var(--blue), var(--blue2));
    color: #fff; padding: 13px 26px; border-radius: 12px;
    font-weight: 700; font-size: .92rem; text-decoration: none;
    box-shadow: 0 6px 20px rgba(37,99,235,.35); transition: all .25s;
}
.btn-p:hover { transform: translateY(-3px); color: #fff; box-shadow: 0 10px 28px rgba(37,99,235,.45); }

.btn-o {
    display: inline-flex; align-items: center; gap: 8px;
    background: #fff; color: var(--blue);
    padding: 13px 26px; border-radius: 12px;
    font-weight: 700; font-size: .92rem; text-decoration: none;
    border: 1.5px solid rgba(37,99,235,.22);
    box-shadow: 0 2px 8px rgba(0,0,0,.06); transition: all .25s;
}
.btn-o:hover { transform: translateY(-3px); border-color: var(--blue); box-shadow: 0 6px 16px rgba(37,99,235,.15); }

/* LOGO DI KANAN */
.hero-logo {
    display: flex;
    justify-content: center;
    align-items: center;
}

.logo-img{
    width: 320px;
    height: 320px;
    object-fit: contain;
    background: rgba(255,255,255,0.85);
    padding: 22px;
    border-radius: 50%;
    border: 2px solid rgba(37,99,235,0.15);
    box-shadow: 0 18px 50px rgba(13,46,94,.18);
    animation: floatAnim 3s ease-in-out infinite;
}

@keyframes floatAnim {
    0%,100%{transform:translateY(0)}
    50%{transform:translateY(-7px)}
}

/* ── STATS BAR ── */
.stats-bar { background: linear-gradient(135deg, var(--blue) 0%, var(--blue2) 100%); padding: 28px 5%; }
.stats-inner { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; }
.sb { text-align: center; }
.sb .sn { font-size: 1.9rem; font-weight: 800; color: #fff; }
.sb .sl { font-size: .78rem; color: rgba(255,255,255,.7); margin-top: 4px; }

/* ── SECTIONS ── */
section { padding: 80px 5%; }
.si { max-width: 1200px; margin: 0 auto; }
.sec-lbl { font-size: .72rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--blue); margin-bottom: 8px; }
.sec-ttl { font-family: 'Playfair Display', serif; font-size: clamp(1.7rem, 2.8vw, 2.3rem); font-weight: 800; color: var(--navy); margin-bottom: 12px; line-height: 1.2; }
.sec-dsc { font-size: .93rem; color: var(--gray); line-height: 1.78; max-width: 540px; }

/* ── TENTANG ── */
#tentang { background: var(--light); }
.about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 56px; align-items: center; }
.about-vis { background: linear-gradient(145deg, var(--soft), var(--soft2)); border-radius: 20px; padding: 26px; border: 1.5px solid var(--sky); }
.flow-step { display: flex; align-items: flex-start; gap: 13px; background: #fff; border: 1px solid var(--sky); border-radius: 12px; padding: 13px 15px; margin-bottom: 10px; transition: .2s; }
.flow-step:hover { border-color: var(--blue); box-shadow: 0 4px 14px rgba(37,99,235,.08); }
.flow-step:last-child { margin-bottom: 0; }
.fs-n { width: 33px; height: 33px; border-radius: 9px; background: linear-gradient(135deg, var(--blue), var(--blue2)); color: #fff; font-weight: 800; font-size: .8rem; display: grid; place-items: center; flex-shrink: 0; }
.fs-t { font-weight: 700; font-size: .86rem; color: var(--navy); }
.fs-d { font-size: .75rem; color: var(--gray); margin-top: 2px; line-height: 1.5; }
.feat-list { margin-top: 24px; display: flex; flex-direction: column; gap: 11px; }
.feat { display: flex; align-items: flex-start; gap: 12px; padding: 14px; border-radius: 12px; background: #fff; border: 1.5px solid var(--soft2); transition: .2s; }
.feat:hover { border-color: var(--blue); box-shadow: 0 4px 14px rgba(37,99,235,.08); }
.feat-ic { width: 38px; height: 38px; border-radius: 10px; background: var(--soft2); color: var(--blue); font-size: 1rem; display: grid; place-items: center; flex-shrink: 0; }
.ft-t { font-weight: 700; font-size: .86rem; color: var(--navy); }
.ft-d { font-size: .75rem; color: var(--gray); margin-top: 2px; }

/* ── CARA KERJA ── */
#cara-kerja { background: #fff; }
.steps-wrap { display: grid; grid-template-columns: repeat(4,1fr); gap: 18px; margin-top: 44px; }
.step-card { position: relative; text-align: center; padding: 26px 16px; border-radius: 16px; border: 1.5px solid var(--soft2); background: var(--light); transition: .25s; }
.step-card:hover { border-color: var(--blue); background: #fff; box-shadow: 0 8px 28px rgba(37,99,235,.1); transform: translateY(-4px); }
.step-card:not(:last-child)::after { content: '→'; position: absolute; right: -14px; top: 50%; transform: translateY(-50%); font-size: 1.1rem; color: var(--blue); font-weight: 800; z-index: 1; }
.st-n { position: absolute; top: 12px; right: 12px; background: var(--soft2); color: var(--blue); font-size: .67rem; font-weight: 800; padding: 2px 8px; border-radius: 8px; }
.st-ic { width: 58px; height: 58px; border-radius: 50%; background: linear-gradient(135deg, var(--soft2), var(--sky)); color: var(--blue); font-size: 1.25rem; display: grid; place-items: center; margin: 0 auto 13px; border: 2px solid var(--sky); }
.step-card h4 { font-size: .89rem; font-weight: 700; color: var(--navy); margin-bottom: 7px; }
.step-card p { font-size: .77rem; color: var(--gray); line-height: 1.6; }

/* ── LAYANAN ── */
#layanan { background: var(--light); }
.lay-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 17px; margin-top: 44px; }
.lay-card { background: #fff; border-radius: 16px; padding: 24px; border: 1.5px solid var(--soft2); transition: .25s; }
.lay-card:hover { border-color: var(--blue); transform: translateY(-4px); box-shadow: 0 8px 28px rgba(37,99,235,.1); }
.lay-ic { width: 48px; height: 48px; border-radius: 13px; background: var(--soft2); color: var(--blue); font-size: 1.25rem; display: grid; place-items: center; margin-bottom: 13px; }
.lay-card h4 { font-weight: 700; color: var(--navy); margin-bottom: 7px; font-size: .91rem; }
.lay-card p { font-size: .79rem; color: var(--gray); line-height: 1.65; }

/* ── KONTAK ── */
#kontak { background: #fff;}
.kontak-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: start; }
.kontak-list { display: flex; flex-direction: column; gap: 11px; margin-top: 22px; }
.k-item { display: flex; align-items: flex-start; gap: 12px; padding: 14px; border-radius: 12px; background: var(--light); border: 1.5px solid var(--soft2); transition: .2s; }
.k-item:hover { border-color: var(--blue); }
.k-ic { width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, var(--blue), var(--blue2)); color: #fff; font-size: .95rem; display: grid; place-items: center; flex-shrink: 0; }
.k-lbl { font-size: .69rem; font-weight: 700; color: var(--blue); text-transform: uppercase; letter-spacing: .04em; }
.k-val { font-size: .86rem; font-weight: 700; color: var(--navy); margin-top: 2px; }
.k-sub { font-size: .74rem; color: var(--gray); margin-top: 1px; }

.map-box { border-radius: 18px; overflow: hidden; border: 2px solid var(--soft2); box-shadow: 0 8px 28px rgba(13,46,94,.08); }
.map-box iframe { display: block; width: 100%; height: 300px; border: none; }
.map-note { background: var(--soft); padding: 12px 14px; margin-top: 11px; border-radius: 10px; border: 1px solid var(--sky); font-size: .77rem; color: var(--gray); display: flex; align-items: flex-start; gap: 8px; }
.map-note i { color: var(--blue); flex-shrink: 0; margin-top: 1px; }

/* ── CTA ── */
.cta-wrap { background: linear-gradient(135deg, var(--navy), #1e3a8a); padding: 80px 5%; text-align: center; position: relative; overflow: hidden; }
.cta-wrap::before { content: ''; position: absolute; top: -120px; left: 50%; transform: translateX(-50%); width: 600px; height: 400px; border-radius: 50%; background: radial-gradient(circle, rgba(96,165,250,.12) 0%, transparent 70%); pointer-events: none; }
.cta-wrap h2 { font-family: 'Playfair Display', serif; font-size: clamp(1.8rem, 3vw, 2.5rem); font-weight: 800; color: #fff; margin-bottom: 13px; position: relative; }
.cta-wrap p { color: rgba(255,255,255,.65); font-size: .97rem; margin-bottom: 30px; position: relative; }

/* ── FOOTER DIPERBAIKI ── */
footer { 
    background: #060f1e; 
    color: #fff; 
    padding: 48px 5% 20px; 
    border-top: 1px solid rgba(255,255,255,.05); 
    font-size: 0.85rem;
}

.footer-grid {
    max-width: 1200px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1.5fr;
    gap: 32px;
    margin-bottom: 32px;
}

.footer-col h4 {
    font-size: 1rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 16px;
    position: relative;
}

.footer-col h4::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -6px;
    width: 40px;
    height: 3px;
    background: linear-gradient(135deg, var(--blue), var(--blue2));
    border-radius: 3px;
}

.footer-col p {
    color: #b0b9c6;
    line-height: 1.7;
    margin-bottom: 12px;
}

.footer-links {
    list-style: none;
    padding: 0;
}

.footer-links li {
    margin-bottom: 10px;
}

.footer-links a {
    color: #b0b9c6;
    text-decoration: none;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.footer-links a:hover {
    color: var(--blue);
    padding-left: 4px;
}

.footer-contact-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    color: #b0b9c6;
    margin-bottom: 10px;
    line-height: 1.5;
}

.footer-contact-item i {
    color: var(--blue);
    font-size: 1rem;
    margin-top: 2px;
}

.footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.08);
    padding-top: 20px;
    text-align: center;
    color: #8892a0;
    font-size: 0.78rem;
}

/* ── ANIMATIONS ── */
@keyframes fadeUp { from{opacity:0;transform:translateY(22px)} to{opacity:1;transform:translateY(0)} }
.reveal { opacity:0; transform:translateY(24px); transition: opacity .6s ease, transform .6s ease; }
.reveal.visible { opacity:1; transform:translateY(0); }

/* ── RESPONSIVE ── */
@media (max-width: 900px) {
    .hero-inner { grid-template-columns: 1fr; }
    .hero-logo { margin-top: 30px; }
    .about-grid { grid-template-columns: 1fr; }
    .steps-wrap { grid-template-columns: repeat(2,1fr); }
    .step-card:not(:last-child)::after { display: none; }
    .lay-grid { grid-template-columns: repeat(2,1fr); }
    .kontak-grid { grid-template-columns: 1fr; }
    .stats-inner { grid-template-columns: repeat(2,1fr); }
    .footer-grid { grid-template-columns: 1fr 1fr; }
}

@media (max-width: 580px) {
    .nav-links { display:none; position:absolute; top:68px; left:0; right:0; background:#fff; flex-direction:column; padding:12px 16px; border-bottom:1px solid var(--soft2); }
    .nav-links.open { display:flex; }
    .nav-toggle { display:block; }
    .steps-wrap { grid-template-columns: 1fr; }
    .lay-grid { grid-template-columns: 1fr; }
    .hero-actions { flex-direction:column; }
    .btn-p, .btn-o { justify-content:center; }
    .logo-img{ width: 230px; height: 230px; }
    .footer-grid { grid-template-columns: 1fr; }
}

/* ── EMERGENCY 112 ── */
.emergency-bar{
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    position: relative;
    overflow: hidden;
}

.emergency-bar::before{
    content:'';
    position:absolute;
    top:-80px;
    right:-80px;
    width:220px;
    height:220px;
    border-radius:50%;
    background: rgba(255,255,255,0.08);
}

.emergency-inner{
    align-items:center;
}

.emergency-bar .sn{
    font-size:1.6rem;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:8px;
}

.emergency-bar .sl{
    font-size:.8rem;
    color:rgba(255,255,255,.82);
    margin-top:6px;
    line-height:1.5;
}

.emergency-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    background:#fff;
    color:#dc2626;
    padding:12px 22px;
    border-radius:12px;
    text-decoration:none;
    font-weight:800;
    font-size:.9rem;
    transition:.25s;
    box-shadow:0 6px 18px rgba(0,0,0,.15);
}

.emergency-btn:hover{
    transform:translateY(-3px);
    background:#fee2e2;
}
</style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar" id="navbar">
    <a href="#" class="nav-brand">
        <div class="nav-logo">
            <img src="assets/logo.jpg" alt="Logo Diskominfo">
        </div>
        <div>
            <div class="b-title">SISTEM PENGADUAN MASYARAKAT</div>
            <div class="b-sub">Diskominfo Singkawang</div>
        </div>
    </a>

    <ul class="nav-links" id="navLinks">
        <li><a href="#tentang">Tentang</a></li>
        <li><a href="#cara-kerja">Cara Kerja</a></li>
        <li><a href="#layanan">Layanan</a></li>
        <li><a href="#kontak">Kontak</a></li>
        <li><a href="nomor_darurat.php">Nomor Darurat</a></li>
        <li><a href="login.php" class="btn-masuk"><i class="bi bi-box-arrow-in-right"></i> Masuk</a></li>
    </ul>

    <button class="nav-toggle" id="navToggle">
        <span></span><span></span><span></span>
    </button>
</nav>


<!-- HERO -->
<section class="hero" id="beranda">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="hero-deco1"></div>
    <div class="hero-deco2"></div>

    <div class="hero-inner">

        <!-- KIRI -->
        <div>
            <div class="hero-badge">
                <i class="bi bi-patch-check-fill"></i> Resmi · Transparan · Terpercaya
            </div>

            <h1 class="hero-title">
                Selamat Datang di<br>
                <span class="accent">Sistem Pelayanan</span><br>
                Pengaduan Masyarakat
            </h1>

            <p class="hero-desc">
                Platform digital resmi Dinas Komunikasi dan Informatika Kota Singkawang untuk menyampaikan aspirasi,
                pengaduan, dan laporan dengan mudah, cepat, dan transparan.
            </p>

            <div class="hero-actions">
                <a href="login.php" class="btn-p"><i class="bi bi-send-fill"></i> Buat Pengaduan</a>
                <a href="#tentang" class="btn-o"><i class="bi bi-info-circle"></i> Pelajari Lebih</a>
            </div>
        </div>

        <!-- KANAN LOGO -->
        <div class="hero-logo">
            <img src="assets/logo.jpg" alt="Logo Diskominfo" class="logo-img">
        </div>

    </div>
</section>


<!-- EMERGENCY BAR 112 -->
<div class="stats-bar emergency-bar">
    <div class="stats-inner emergency-inner">

        <div class="sb reveal">
            <div class="sn">
                <i class="bi bi-telephone-fill"></i> 112
            </div>
            <div class="sl">
                Nomor Panggilan Darurat Nasional
            </div>
        </div>

        <div class="sb reveal">
            <div class="sn">
                <i class="bi bi-shield-fill-check"></i>
            </div>
            <div class="sl">
                Gratis & Aktif 24 Jam
            </div>
        </div>

        <div class="sb reveal">
            <div class="sn">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <div class="sl">
                Kebakaran, Kecelakaan, Bencana & Darurat
            </div>
        </div>

        <div class="sb reveal">
            <a href="nomor_darurat.php" class="emergency-btn">
                <i class="bi bi-telephone-outbound-fill"></i> Lihat Nomor Darurat
            </a>
        </div>

    </div>
</div>


<!-- TENTANG -->
<section id="tentang">
    <div class="si">
        <div class="about-grid">
            <div class="about-vis reveal">
                <div class="flow-step"><div class="fs-n">01</div><div><div class="fs-t">Pengaduan Digital</div><div class="fs-d">Laporan dikirim secara online kapan saja tanpa harus datang ke kantor</div></div></div>
                <div class="flow-step"><div class="fs-n">02</div><div><div class="fs-t">Verifikasi & Tindak Lanjut</div><div class="fs-d">Admin memverifikasi dan mendistribusikan ke dinas terkait</div></div></div>
                <div class="flow-step"><div class="fs-n">03</div><div><div class="fs-t">Update Status Real-time</div><div class="fs-d">Masyarakat memantau perkembangan penanganan laporan</div></div></div>
                <div class="flow-step"><div class="fs-n">04</div><div><div class="fs-t">Laporan Selesai & Terdokumentasi</div><div class="fs-d">Pengaduan terselesaikan dan tercatat secara akuntabel</div></div></div>
            </div>

            <div class="reveal">
                <div class="sec-lbl">Tentang SIPADU</div>
                <h2 class="sec-ttl">Layanan Pengaduan yang Transparan & Akuntabel</h2>
                <p class="sec-dsc">SIPADU adalah platform digital resmi Diskominfo Kota Singkawang untuk menyalurkan aspirasi dan laporan masyarakat kepada pemerintah daerah secara mudah dan terstruktur.</p>

                <div class="feat-list">
                    <div class="feat"><div class="feat-ic"><i class="bi bi-shield-lock-fill"></i></div><div><div class="ft-t">Aman & Terpercaya</div><div class="ft-d">Data laporan dijaga kerahasiaannya dan hanya diakses petugas berwenang</div></div></div>
                    <div class="feat"><div class="feat-ic"><i class="bi bi-eye-fill"></i></div><div><div class="ft-t">Transparan</div><div class="ft-d">Status pengaduan dapat dipantau secara real-time oleh pelapor</div></div></div>
                    <div class="feat"><div class="feat-ic"><i class="bi bi-lightning-fill"></i></div><div><div class="ft-t">Cepat & Responsif</div><div class="ft-d">Pengaduan ditangani maksimal 3 hari kerja oleh dinas terkait</div></div></div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- CARA KERJA -->
<section id="cara-kerja">
    <div class="si">
        <div class="reveal" style="text-align:center">
            <div class="sec-lbl">Cara Kerja</div>
            <h2 class="sec-ttl">Mudah dalam 4 Langkah</h2>
            <p class="sec-dsc" style="margin:0 auto">Proses pengaduan yang simpel dan dapat dipantau dari awal hingga selesai</p>
        </div>

        <div class="steps-wrap">
            <div class="step-card reveal"><div class="st-n">01</div><div class="st-ic"><i class="bi bi-person-plus-fill"></i></div><h4>Daftar Akun</h4><p>Buat akun menggunakan data diri yang valid untuk memulai layanan pengaduan</p></div>
            <div class="step-card reveal"><div class="st-n">02</div><div class="st-ic"><i class="bi bi-pencil-square"></i></div><h4>Isi Formulir</h4><p>Lengkapi detail pengaduan, pilih kategori, dan lampirkan foto sebagai bukti</p></div>
            <div class="step-card reveal"><div class="st-n">03</div><div class="st-ic"><i class="bi bi-send-fill"></i></div><h4>Kirim Laporan</h4><p>Kirim pengaduan dan terima nomor tiket sebagai referensi tindak lanjut</p></div>
            <div class="step-card reveal"><div class="st-n">04</div><div class="st-ic"><i class="bi bi-check-circle-fill"></i></div><h4>Pantau Status</h4><p>Monitor perkembangan penanganan pengaduan Anda secara real-time</p></div>
        </div>
    </div>
</section>


<!-- LAYANAN -->
<section id="layanan">
    <div class="si">
        <div class="reveal">
            <div class="sec-lbl">Kategori Layanan</div>
            <h2 class="sec-ttl">Apa yang Bisa Anda Laporkan?</h2>
            <p class="sec-dsc">Berbagai kategori tersedia agar laporan Anda ditangani oleh dinas yang tepat</p>
        </div>

        <div class="lay-grid">
            <div class="lay-card reveal"><div class="lay-ic"><i class="bi bi-building"></i></div><h4>Infrastruktur</h4><p>Jalan rusak, jembatan, drainase, lampu jalan, dan fasilitas publik yang butuh perbaikan.</p></div>
            <div class="lay-card reveal"><div class="lay-ic"><i class="bi bi-people-fill"></i></div><h4>Pelayanan Publik</h4><p>Keluhan terkait administrasi, kependudukan, perizinan, dan layanan pemerintahan.</p></div>
            <div class="lay-card reveal"><div class="lay-ic"><i class="bi bi-trash3-fill"></i></div><h4>Kebersihan & Lingkungan</h4><p>Masalah sampah, pencemaran, dan kebersihan lingkungan di Kota Singkawang.</p></div>
            <div class="lay-card reveal"><div class="lay-ic"><i class="bi bi-droplet-fill"></i></div><h4>Air & Sanitasi</h4><p>Gangguan air bersih, kebocoran pipa, dan permasalahan sanitasi lingkungan.</p></div>
            <div class="lay-card reveal"><div class="lay-ic"><i class="bi bi-heart-pulse-fill"></i></div><h4>Kesehatan</h4><p>Laporan terkait fasilitas kesehatan dan masalah kesehatan lingkungan masyarakat.</p></div>
            <div class="lay-card reveal"><div class="lay-ic"><i class="bi bi-chat-dots-fill"></i></div><h4>Lainnya</h4><p>Pengaduan dan aspirasi lain yang memerlukan perhatian pemerintah Kota Singkawang.</p></div>
        </div>
    </div>
</section>


<!-- KONTAK -->
<section id="kontak">
    <div class="si">
        <div class="kontak-grid">

            <!-- KIRI -->
            <div>
                <div class="sec-lbl reveal">Hubungi Kami</div>
                <h2 class="sec-ttl reveal">Informasi Kantor Diskominfo</h2>
                <p class="sec-dsc reveal">Butuh bantuan? Hubungi kami melalui kontak di bawah atau kunjungi kantor pada jam operasional.</p>

                <div class="kontak-list">
                    <div class="k-item reveal"><div class="k-ic"><i class="bi bi-geo-alt-fill"></i></div><div><div class="k-lbl">Alamat</div><div class="k-val">Dinas Komunikasi dan Informatika</div><div class="k-sub">Kota Singkawang, Kalimantan Barat</div></div></div>
                    <div class="k-item reveal"><div class="k-ic"><i class="bi bi-telephone-fill"></i></div><div><div class="k-lbl">Telepon</div><div class="k-val">(0562) 631234</div><div class="k-sub">Senin – Jumat, 08.00 – 16.00 WIB</div></div></div>
                    <div class="k-item reveal"><div class="k-ic"><i class="bi bi-envelope-fill"></i></div><div><div class="k-lbl">Email</div><div class="k-val">diskominfo@singkawangkota.go.id</div><div class="k-sub">Balasan dalam 1×24 jam kerja</div></div></div>
                    <div class="k-item reveal"><div class="k-ic"><i class="bi bi-clock-fill"></i></div><div><div class="k-lbl">Jam Operasional</div><div class="k-val">Senin – Jumat: 08.00 – 16.00 WIB</div><div class="k-sub">Sabtu, Minggu & Hari Libur: Tutup</div></div></div>
                </div>
            </div>

            <!-- KANAN MAP -->
            <div class="reveal">
                <div class="map-box">
                    <iframe 
                        src="https://www.google.com/maps?q=Diskominfo%20Singkawang&output=embed"
                        allowfullscreen=""
                        loading="lazy">
                    </iframe>
                </div>
                <div class="map-note">
                    <i class="bi bi-info-circle"></i>
                    Lokasi kantor dapat dilihat melalui Google Maps.
                </div>
            </div>

        </div>
    </div>
</section>


<!-- CTA -->
<div class="cta-wrap">
    <h2 class="reveal">Siap Menyampaikan Pengaduan?</h2>
    <p class="reveal">Daftar dan jadilah bagian dari masyarakat Singkawang yang aktif dan peduli</p>
    <a href="login.php" class="btn-p reveal" style="display:inline-flex">
        <i class="bi bi-box-arrow-in-right"></i> Masuk ke Sistem
    </a>
</div>


<!-- ✅ FOOTER YANG SUDAH DIPERBAIKI -->
<footer>
    <div class="footer-grid">
        <div class="footer-col">
            <h4>SIPADU</h4>
            <p>Sistem Pelayanan dan Pengaduan Masyarakat Kota Singkawang adalah platform resmi untuk menampung aspirasi, keluhan, dan laporan warga secara mudah, cepat, dan transparan.</p>
        </div>

        <div class="footer-col">
            <h4>Tautan</h4>
            <ul class="footer-links">
                <li><a href="#tentang"><i class="bi bi-chevron-right"></i> Tentang</a></li>
                <li><a href="#cara-kerja"><i class="bi bi-chevron-right"></i> Cara Kerja</a></li>
                <li><a href="#layanan"><i class="bi bi-chevron-right"></i> Layanan</a></li>
                <li><a href="#kontak"><i class="bi bi-chevron-right"></i> Kontak</a></li>
                <li><a href="nomor_darurat.php"><i class="bi bi-chevron-right"></i> Nomor Darurat</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Layanan</h4>
            <ul class="footer-links">
                <li><a href="#"><i class="bi bi-chevron-right"></i> Infrastruktur</a></li>
                <li><a href="#"><i class="bi bi-chevron-right"></i> Pelayanan Publik</a></li>
                <li><a href="#"><i class="bi bi-chevron-right"></i> Kebersihan & Lingkungan</a></li>
                <li><a href="#"><i class="bi bi-chevron-right"></i> Kesehatan</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Kontak Kami</h4>
            <div class="footer-contact-item">
                <i class="bi bi-geo-alt-fill"></i>
                <span>Jl. Merdeka No. 1, Kota Singkawang, Kalimantan Barat</span>
            </div>
            <div class="footer-contact-item">
                <i class="bi bi-telephone-fill"></i>
                <span>(0562) 631234</span>
            </div>
            <div class="footer-contact-item">
                <i class="bi bi-envelope-fill"></i>
                <span>diskominfo@singkawangkota.go.id</span>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        &copy; <?= date('Y') ?> Dinas Komunikasi dan Informatika Kota Singkawang • Hak Cipta Dilindungi Undang-Undang
    </div>
</footer>


<script>
window.addEventListener('scroll', () => {
    document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 40);
});

document.getElementById('navToggle').addEventListener('click', () => {
    document.getElementById('navLinks').classList.toggle('open');
});

document.querySelectorAll('#navLinks a').forEach(a => {
    a.addEventListener('click', () => document.getElementById('navLinks').classList.remove('open'));
});

const obs = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
        if(e.isIntersecting){
            setTimeout(() => e.target.classList.add('visible'), i * 90);
            obs.unobserve(e.target);
        }
    });
}, { threshold: 0.1 });

document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
</script>

</body>
</html>