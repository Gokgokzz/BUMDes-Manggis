<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pendaftaran Pelanggan Baru - ICONNET</title>
  <link rel="icon" href="logo-iconnet.png" type="image/png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    /* ==================== VARIABEL WARNA & DASAR ==================== */
    :root {
      --navy: #253e72;
      --blue: #155fa8;
      --blue-light: #3d83c4;
      --tosca: #1ec8c8;
      --tosca-dark: #139b9b;
      --bg-light: #F8F9FA;
      --text-main: #22282f;
      --text-muted: #8a8a8a;
      --border-color: #EAEBED;
      --white: #FFFFFF;
      --hover-light: rgba(30, 200, 200, 0.08);
      --font-premium: 'Plus Jakarta Sans', sans-serif;
    }
    /* Custom Scrollbar Toska */
    ::-webkit-scrollbar {
      width: 10px;
    }

    ::-webkit-scrollbar-track {
      background: #0A2240;
    }

    ::-webkit-scrollbar-thumb {
      background: var(--tosca);
      border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: var(--tosca-dark);
    }

    html {
      scrollbar-width: thin;
      scrollbar-color: var(--tosca) #0A2240;
    }
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: var(--font-premium);
      color: var(--text-main);
      background-color: #0A2240;
      overflow-x: hidden;
      line-height: 1.6;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    ul {
      list-style: none;
    }

    .gold-text {
      color: var(--tosca) !important;
    }

    /* ==================== LAYOUT & TYPOGRAPHY ==================== */
    .section-inner {
      max-width: 1200px;
      margin: 40px auto;
      background-color: #ffffff;
      padding: 50px 40px;
      border-radius: 15px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
    }

    .reveal {
      opacity: 1;
      transform: translateY(30px);
      transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .reveal.show {
      opacity: 1;
      transform: translateY(0);
    }

    .luxury-eyebrow {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 3px;
      color: var(--tosca);
      text-transform: uppercase;
    }

    h2.title {
      font-size: clamp(26px, 3vw, 36px);
      font-weight: 700;
      color: var(--navy);
      letter-spacing: -0.5px;
      margin-bottom: 16px;
    }

    .subtitle {
      font-size: 16px;
      color: var(--text-muted);
      max-width: 580px;
      font-weight: 400;
      margin-bottom: 20px;
    }

    .region-title {
      font-size: 28px;
      color: var(--navy);
      margin-bottom: 30px;
      padding-bottom: 10px;
      border-bottom: 2px solid var(--border-color);
    }

    .promo-title {
      font-size: 28px;
      color: var(--tosca);
      margin-bottom: 30px;
      padding-bottom: 10px;
      border-bottom: 2px solid var(--border-color);
    }

    .block-label {
      font-size: 14px;
      font-weight: 700;
      letter-spacing: 0.5px;
      color: var(--navy);
      margin-bottom: 24px;
      text-transform: uppercase;
      border-left: 2px solid var(--tosca);
      padding-left: 10px;
    }

    .setup-notice {
      font-size: 13px;
      color: var(--text-muted);
      margin-top: 20px;
      text-align: left;
      line-height: 1.8;
    }

    /* ==================== IKON WIFI ANIMASI ==================== */
    .title-wifi-container {
      display: inline-flex;
      align-items: center;
      justify-content: flex-start;
      gap: 12px;
      width: 100%;
    }

    .title-wifi-container .title {
      margin: 0; 
    }

    .wifi-mini-wrap {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .wifi-mini-icon {
      position: relative;
      width: 42px;
      height: 28px;
      display: flex;
      align-items: flex-end;
      justify-content: center;
    }

    .wifi-mini-dot {
      width: 6px;
      height: 6px;
      background-color: var(--tosca, #1ec8c8);
      border-radius: 50%;
      animation: pulseDotM 2s infinite;
    }

    .wifi-mini-bar {
      position: absolute;
      border: 2.5px solid transparent;
      border-top-color: rgba(30, 200, 200, 0.15);
      border-radius: 50%;
      transform-origin: bottom center;
      bottom: 0;
      left: 50%;
      transform: translateX(-50%);
      animation: fillWifiM 2s infinite linear;
    }

    .bar-m1 { width: 16px; height: 16px; bottom: 2px; animation-delay: 0.4s; }
    .bar-m2 { width: 30px; height: 30px; bottom: 2px; animation-delay: 0.8s; }
    .bar-m3 { width: 44px; height: 44px; bottom: 2px; animation-delay: 1.2s; }

    @keyframes fillWifiM {
      0% { border-top-color: rgba(30, 200, 200, 0.15); }
      25%, 100% {
        border-top-color: var(--tosca, #1ec8c8);
        filter: drop-shadow(0 0 4px var(--tosca, #1ec8c8));
      }
    }

    @keyframes pulseDotM {
      0%, 100% { transform: scale(1); background-color: var(--tosca, #1ec8c8); }
      50% { transform: scale(1.2); background-color: var(--tosca-dark, #159c9c); }
    }

    /* ==================== KARTU FLASH PROMO ==================== */
    .promo-strip-grid {
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      gap: 16px;
    }

    .promo-mini-card {
      border: 1px solid var(--border-color);
      border-radius: 8px;
      padding: 20px 16px;
      text-align: center;
      transition: all 0.3s ease;
      position: relative;
      background: #FFFFFF;
    }

    .promo-mini-card .sp {
      display: block;
      font-size: 16px;
      font-weight: 700;
      color: var(--navy);
      margin-bottom: 5px;
    }

    .promo-mini-card .pr {
      font-size: 14px;
      color: var(--tosca);
      font-weight: 600;
      display: block;
      margin-bottom: 10px;
    }

    .promo-mini-card.active,
    .promo-mini-card:hover {
      border-color: var(--tosca);
      background: var(--hover-light);
    }

    .badge-overlay-promo {
      position: absolute;
      top: -15px;
      right: -10px;
      background: rgba(18, 24, 36, 0.9);
      border: 1px solid rgba(30, 200, 200, 0.4);
      padding: 6px 10px;
      backdrop-filter: blur(6px);
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 1px;
      color: var(--tosca);
      border-radius: 6px;
      z-index: 5;
      box-shadow: 0 8px 20px rgba(10, 14, 23, 0.12);
    }

    /* ==================== KARTU PAKET REGULER ==================== */
    .pkg-block {
      margin-top: 50px;
    }

    .pkg-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 30px;
    }

    .pkg-card {
      background: #FFFFFF;
      border: 1px solid var(--border-color);
      border-radius: 10px;
      padding: 40px 30px;
      position: relative;
      transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .pkg-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
      border-color: var(--tosca);
    }

    .card-badge {
      position: absolute;
      top: 20px;
      right: 25px;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 1px;
      color: var(--text-muted);
    }

    .card-badge.gold {
      color: var(--tosca);
    }

    .pkg-card .speed {
      font-size: 42px;
      font-weight: 300;
      color: var(--navy);
      margin-bottom: 16px;
    }

    .pkg-card .speed span {
      font-size: 16px;
      font-weight: 600;
      color: var(--text-muted);
    }

    .pkg-card .price {
      font-size: 20px;
      font-weight: 700;
      color: var(--tosca);
      margin-bottom: 15px;
    }

    .pkg-card .price .per {
      font-size: 13px;
      font-weight: 400;
      color: var(--text-muted);
    }

    .pkg-card.elite {
      background: var(--navy);
      border-color: var(--navy);
      color: #FFFFFF;
      animation: pulseRekomendasi 3s ease-in-out infinite;
    }

    .pkg-card.elite .speed,
    .pkg-card.elite .price {
      color: #FFFFFF;
    }

    .pkg-card.elite span {
      color: #FFFFFF !important;
    }

    @keyframes pulseRekomendasi {
      0%, 100% {
        transform: scale(1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      }
      50% {
        transform: scale(1.02);
        box-shadow: 0 15px 35px rgba(37, 62, 114, 0.3);
      }
    }

    /* ==================== KARTU PAKET HEBAT (LIST STYLE) ==================== */
    .pkg-grid.list-style {
      grid-template-columns: repeat(4, 1fr);
      gap: 20px;
    }

    .pkg-list-card {
      background: var(--bg-light);
      padding: 30px 24px;
      border-radius: 8px;
      border: 1px solid var(--border-color);
      position: relative;
      transition: all 0.3s ease;
    }

    .pkg-list-card:hover {
      border-color: var(--tosca);
      box-shadow: 0 10px 25px rgba(0,0,0,0.04);
    }

    .pkg-list-card h5 {
      font-size: 13px;
      font-weight: 700;
      letter-spacing: 0.5px;
      color: var(--navy);
    }

    .pkg-list-card .divider {
      height: 1px;
      background: #E2E3E5;
      margin: 16px 0;
    }

    .pkg-list-card ul li {
      font-size: 13.5px;
      color: var(--text-muted);
      display: flex;
      justify-content: space-between;
      margin-bottom: 12px;
    }

    .pkg-list-card ul li span {
      font-weight: 600;
      color: var(--navy);
    }

    .pkg-list-card.elite-box {
      background: var(--hover-light);
      border: 1px solid rgba(30, 200, 200, 0.4);
    }

    .bonus-tag {
      display: block;
      font-size: 11px;
      font-weight: 600;
      color: var(--tosca);
      margin-top: 15px;
    }

    .tax-note {
      font-size: 11px;
      color: var(--text-muted);
      margin-top: 15px;
    }

    /* ==================== BROSUR WRAPPER ==================== */
    .brosur-wrapper {
      margin-top: 50px;
      text-align: center;
    }

    .img-brosur {
      max-width: 100%;
      height: auto;
      border-radius: 12px;
    }

    .img-elevated {
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    /* ==================== TOMBOL WHATSAPP ==================== */
    .wa-container-center {
      width: 100% !important;
      display: block;
      margin: 25px 0 15px;
      clear: both;
      text-align: left !important;
    }

    .wa-container-center a {
      display: inline-block !important;
      text-align: left !important;
    }

    .btn-whatsapp {
      position: relative;
      overflow: hidden;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 12px 24px;
      background-color: var(--white);
      color: var(--tosca);
      border: 2px solid var(--tosca);
      border-left: 5px solid var(--tosca);
      border-radius: 8px;
      font-weight: 600;
      text-decoration: none;
      z-index: 1;
      transition: color 0.4s ease;
      cursor: pointer;
    }

    .btn-whatsapp::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 0;
      height: 100%;
      background-color: var(--tosca);
      transition: width 0.4s ease-in-out;
      z-index: -1;
    }

    .btn-whatsapp:hover::before {
      width: 100%;
    }

    .btn-whatsapp:hover {
      background: var(--white);
      color: #FFFFFF; 
    }

    /* ==================== BAGIAN INFORMASI KAKI / FOOTER ==================== */
    .footer-section {
      margin-top: 50px;
      padding-top: 30px;
      border-top: 2px solid var(--border-color);
      text-align: center;
    }

    .footer-text-main {
      font-size: 15px;
      color: var(--navy);
      font-weight: 500;
      margin-bottom: 20px;
      line-height: 1.6;
    }

    .footer-text-main strong {
      color: var(--navy);
      font-weight: 700;
    }

    .footer-text-sub {
      font-size: 14px;
      color: var(--text-muted);
      margin-bottom: 10px;
    }

    .footer-link {
      color: var(--tosca-dark);
      font-weight: 700;
      text-decoration: underline;
      transition: color 0.3s ease;
    }

    .footer-link:hover {
      color: var(--blue);
    }

    /* Google Maps Container Styling */
    .map-container {
      width: 100%;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      margin-top: 20px;
    }

    /* ==================== RESPONSIVE KHUSUS KARTU ==================== */
    @media (max-width: 960px) {
      .pkg-grid,
      .pkg-grid.list-style,
      .promo-strip-grid {
        grid-template-columns: 1fr !important;
      }
      .badge-overlay-promo { display: none !important; }
    }
  </style>
</head>

<body>

  <div class="section-inner" id="paket">
    <div class="section-header reveal">
      <div class="luxury-eyebrow">PAKET INTERNET</div>

      <div class="title-wifi-container">
        <h2 class="title">Paket Internet ICONNET</h2>

        <div class="wifi-mini-wrap">
          <div class="wifi-mini-icon">
            <div class="wifi-mini-dot"></div>
            <div class="wifi-mini-bar bar-m1"></div>
            <div class="wifi-mini-bar bar-m2"></div>
            <div class="wifi-mini-bar bar-m3"></div>
          </div>
        </div>
      </div>
      <p class="subtitle">Investasi konektivitas terbaik sesuai dengan area dan kebutuhan Anda.</p>
    </div>

    <!-- FLASH PROMO BUNDLING -->
    <div class="pkg-block reveal">
      <h3 class="promo-title">FLASH PROMO!!</h3>
      <h4 class="block-label" style="margin-top:40px;">PAKET BUNDLING 3 BULAN (AREA BALI)</h4>
      <div class="promo-strip-grid">
        <div class="promo-mini-card">
          <span class="sp">10 Mbps</span>
          <span class="pr">Rp <b>498.371</b></span> 
          <span style="font-size: 12px; color: var(--navy); display: block; margin-bottom: 5px;"><i class="fas fa-mobile"></i><b> 2 Hp</b></span>
          <span style="font-size: 12px; color: var(--navy); display: block; margin-bottom: 5px;"><i class="fas fa-laptop"></i><b> 1 Laptop</b></span>
        </div>
        <div class="promo-mini-card">
          <span class="sp">20 Mbps</span>
          <span class="pr">Rp <b>531.691</b></span>
          <span style="font-size: 12px; color: var(--navy); display: block; margin-bottom: 5px;"><i class="fas fa-mobile"></i><b> 3 Hp</b></span>
          <span style="font-size: 12px; color: var(--navy); display: block; margin-bottom: 5px;"><i class="fas fa-laptop"></i><b> 2 Laptop</b></span>
        </div>
        <div class="promo-mini-card active">
          <div class="badge-overlay-promo">
            <span>PROMO JOSS!!⚡</span>
          </div>
          <span class="sp">35 Mbps</span>
          <span class="pr">Rp <b>598.291</b></span>
          <span style="font-size: 12px; color: var(--navy); display: block; margin-bottom: 5px;"><i class="fas fa-mobile"></i><b> 5 Hp</b></span>
          <span style="font-size: 12px; color: var(--navy); display: block; margin-bottom: 5px;"><i class="fas fa-laptop"></i><b> 3 Laptop</b></span>
        </div>
        <div class="promo-mini-card">
          <span class="sp">50 Mbps</span>
          <span class="pr">Rp <b>687.088</b></span>
          <span style="font-size: 12px; color: var(--navy); display: block; margin-bottom: 5px;"><i class="fas fa-mobile"></i><b> 6 Hp</b></span>
          <span style="font-size: 12px; color: var(--navy); display: block; margin-bottom: 5px;"><i class="fas fa-laptop"></i><b> 4 Laptop</b></span>
        </div>
        <div class="promo-mini-card">
          <span class="sp">100 Mbps</span>
          <span class="pr">Rp <b>864.691</b></span>
          <span style="font-size: 12px; color: var(--navy); display: block; margin-bottom: 5px;"><i class="fas fa-mobile"></i><b> 10 Hp</b></span>
          <span style="font-size: 12px; color: var(--navy); display: block; margin-bottom: 5px;"><i class="fas fa-laptop"></i><b> 6 Laptop</b></span>
        </div>
      </div>
      <div class="wa-container-center">
        <a href="https://wa.me/6281916778887?text=Halo%20Admin%2C%20Saya%20mau%20pesan%20Paket%20Bundling%203%20Bulan%20Bali" target="_blank">
          <button class="btn-whatsapp"><i class="fab fa-whatsapp"></i> Pesan Sekarang</button>
        </a>
      </div>
      <div class="setup-notice">
        <span class="gold-text"><b>Gratis Biaya Instalasi</b></span> Untuk <span class="gold-text"><b>Paket Bundling 3 Bulan</b></span> · Harga sudah termasuk PPN 11%<br>
        *<span class="gold-text"><b>Harga Bulan</b></span> ke-<span class="gold-text"><b>4</b></span>: <span class="gold-text"><b>10 Mbps</b></span> Rp <span class="gold-text"><b>166.130</b></span> · <span class="gold-text"><b>20 Mbps</b></span> Rp <span class="gold-text"><b>177.230</b></span> · <span class="gold-text"><b>35 Mbps</b></span> Rp <span class="gold-text"><b>199.430</b></span> · <span class="gold-text"><b>50 Mbps</b></span> Rp <span class="gold-text"><b>229.029</b></span> · <span class="gold-text"><b>100 Mbps</b></span> Rp <span class="gold-text"><b>288.230</b></span>
      </div>
    </div>

    <!-- AREA BALI -->
    <div class="pkg-block reveal">
      <h3 class="region-title">Area Bali</h3>
      <h4 class="block-label" style="margin-top:40px;">ICONNET Reguler Bali</h4>
      <div class="pkg-grid">
        <div class="pkg-card elite">
          <div class="card-badge gold"><b>REKOMENDASI</b></div>
          <div class="speed">35 <span>Mbps</span></div>
          <div class="price">Rp 265.290<span class="per">/bulan</span></div> <br>
          <span style="font-size: 15px; color: var(--white); display: block; margin-bottom: 5px;"><i class="fas fa-mobile"></i><b> 5 Hp</b></span>
          <span style="font-size: 15px; color: var(--white); display: block; margin-bottom: 5px;"><i class="fas fa-laptop"></i><b> 3 Laptop</b></span>
        </div>
        <div class="pkg-card">
          <div class="speed">50 <span>Mbps</span></div>
          <div class="price">Rp 331.890<span class="per">/bulan</span></div> <br>
          <span style="font-size: 15px; color: var(--navy); display: block; margin-bottom: 5px;"><i class="fas fa-mobile"></i><b> 6 Hp</b></span>
          <span style="font-size: 15px; color: var(--navy); display: block; margin-bottom: 5px;"><i class="fas fa-laptop"></i><b> 4 Laptop</b></span>
        </div>
        <div class="pkg-card">
          <div class="speed">100 <span>Mbps</span></div>
          <div class="price">Rp 442.890<span class="per">/bulan</span></div> <br>
          <span style="font-size: 15px; color: var(--navy); display: block; margin-bottom: 5px;"><i class="fas fa-mobile"></i><b> 10 Hp</b></span>
          <span style="font-size: 15px; color: var(--navy); display: block; margin-bottom: 5px;"><i class="fas fa-laptop"></i><b> 6 Laptop</b></span>
        </div>
      </div>
      <div class="wa-container-center">
        <a href="https://wa.me/6281916778887?text=Halo%20Admin%2C%20Saya%20mau%20pesan%20Paket%20Reguler%20Bali" target="_blank">
          <button class="btn-whatsapp"><i class="fab fa-whatsapp"></i> Pesan Sekarang</button>
        </a>
      </div>
      <div class="setup-notice">
        <span class="gold-text"><b>Biaya Instalasi</b></span>: Rp <span class="gold-text"><b>50.000</b></span>, <br> *Harga sudah termasuk PPN 11% 
      </div>

      <h4 class="block-label" style="margin-top:40px;">ICONNET Hebat Bali (Bayar di Muka)</h4>
      <div class="pkg-grid list-style">
        <div class="pkg-list-card">
          <h5>HEBAT 3 BULAN</h5>
          <div class="divider"></div>
          <ul>
            <li>35 Mbps <span>Rp 795.870</span></li>
            <li>50 Mbps <span>Rp 995.670</span></li>
            <li>100 Mbps <span>Rp 1.328.670</span></li>
          </ul>
          <span class="bonus-tag"><b>Bayar 3 Bulan, <br> Biaya Instalasi Jadi 50.000</b></span>
        </div>
        <div class="pkg-list-card">
          <h5>HEBAT 6 BULAN</h5>
          <div class="divider"></div>
          <ul>
            <li>35 Mbps <span>Rp 1.326.450</span></li>
            <li>50 Mbps <span>Rp 1.659.450</span></li>
            <li>100 Mbps <span>Rp 2.214.450</span></li>
          </ul>
          <p class="tax-note"><b>Bayar 5 Bulan, Gratis 1 Bulan</b></p>
          <span class="bonus-tag"><b>Biaya Instalasi Jadi 50.000</b></span>
        </div>
        <div class="pkg-list-card elite-box">
          <h5>HEBAT 12 BULAN</h5>
          <div class="divider"></div>
          <ul>
            <div class="card-badge gold"><b>REKOMENDASI</b></div>
            <li>35 Mbps <span>Rp 2.387.610</span></li>
            <li>50 Mbps <span>Rp 2.987.010</span></li>
            <li>100 Mbps <span>Rp 3.986.010</span></li>
          </ul>
          <p class="tax-note"><b>Bayar 9 Bulan, <span>Gratis 3 Bulan</span></b></p>
          <span class="bonus-tag"><b>Gratis Biaya Instalasi</b></span>
        </div>
        <div class="pkg-list-card">
          <h5>HEBAT 24 BULAN</h5>
          <div class="divider"></div>
          <ul>
            <li>50 Mbps <span>Rp 5.642.130</span></li>
            <li>100 Mbps <span>Rp 7.529.130</span></li>
          </ul>
          <p class="tax-note"><b>Bayar 17 Bulan, <span>Gratis 7 Bulan</span></b></p>
          <span class="bonus-tag"><b>Gratis Biaya Instalasi</b></span>
        </div>
      </div>
      <div class="wa-container-center">
        <a href="https://wa.me/6281916778887?text=Halo%20Admin%2C%20Saya%20mau%20pesan%20Paket%20Hebat%20Bali" target="_blank">
          <button class="btn-whatsapp"><i class="fab fa-whatsapp"></i> Pesan Sekarang</button>
        </a>
      </div>
      <div class="setup-notice">
        *Harga sudah termasuk PPN 11%<br><span class="gold-text"><b>Biaya Instalasi Normal</b></span> Rp <span class="gold-text"><b>250.000</b></span> · <span class="gold-text"><b>Hebat 12</b></span> & <span class="gold-text"><b>24</b></span>: <span class="gold-text"><b>Gratis Instalasi</b></span> <br><br>
        <b><span style="font-size: 12px; color: var(--navy); display: block; margin-bottom: 5px;">35 Mbps Hebat 3-12 Bulan : <i class="fas fa-mobile"></i> 4 Hp  -  <i class="fas fa-laptop"></i> 2 Laptop</span></b>
        <b><span style="font-size: 12px; color: var(--navy); display: block; margin-bottom: 5px;">50 Mbps Hebat 3-24 Bulan : <i class="fas fa-mobile"></i> 5 Hp  -  <i class="fas fa-laptop"></i> 3 Laptop</span></b>
        <b><span style="font-size: 12px; color: var(--navy); display: block; margin-bottom: 5px;">100 Mbps Hebat 3-24 Bulan : <i class="fas fa-mobile"></i> 10 Hp  -  <i class="fas fa-laptop"></i> 6 Laptop</span></b>
      </div>
    </div>

    <!-- BAGIAN INFORMASI KONTAK TERBARU & GOOGLE MAPS -->
    <div class="footer-section reveal">
      <p class="footer-text-sub">
        <a href="https://iconnet.netlify.app/" target="_blank" rel="noopener noreferrer" class="footer-link">klik disini</a>, jika ingin tahu lebih lanjut tentang paketan' ICONNET.
      </p>
      <p class="footer-text-main">
        Hubungi <strong>+62 821-4774-0808</strong> atau langsung kunjungi <strong>BUMDes Manggis</strong> untuk berlangganan wifi ICONNET.
      </p>
      
      <!-- Peta Google Maps Kantor BUMDes Manggis -->
      <div class="map-container">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.0566037810436!2d115.51649707470683!3d-8.493877691547615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd20f812bda2193%3A0x8fbaca94cf8e61a8!2sKantor%20BUMDes%20Catur%20Mandala%20Manggis!5e0!3m2!1sid!2sid!4v1785382222868!5m2!1sid!2sid"
          width="100%" 
          height="250" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade"
          title="Peta Lokasi Kantor BUMDes Catur Mandala Manggis">
        </iframe>
      </div>
    </div>

  </div>

</body>
</html>