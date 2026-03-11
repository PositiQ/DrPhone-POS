<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#1a237e">
  <meta name="description" content="Dr.Mobile POS System - Professional Point of Sale management system">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="PositiQ POS">
  <title>PositiQ POS · Dr.Phone</title>
  <!-- PWA Manifest -->
  <link rel="manifest" href="/manifest.json">
  <!-- PWA Icons -->
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a237e' width='192' height='192'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
  <link rel="apple-touch-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 192 192'><rect fill='%231a237e' width='192' height='192' rx='40'/><text x='50%' y='50%' font-size='80' font-weight='bold' fill='%23ffd700' text-anchor='middle' dominant-baseline='central'>POS</text></svg>">
  <!-- Font Awesome 6 (minimal icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="./styles/login.css">
</head>
<body>
  <!-- PWA Client Library -->
  <script src="/pwa-client.js"></script>
  <div class="login-card">
    <!-- logo area – Apple: clean, centered, calm -->
    <div class="logo-container">
      <div class="logo-symbol">
        <img src="https://res.cloudinary.com/dhqcnszvn/image/upload/v1771859587/WhatsApp_Image_2026-02-20_at_21.01.29_e73m2g.png" alt="logo" width="250px">
      </div>
      <div class="descriptor">Light up your Digital Dream 🫶🏽</div>
    </div>

    <!-- body -->
    <div class="card-body">

      <!-- username / operator -->
      <div class="field">
        <label>operator</label>
        <div class="input-wrapper">
          <i class="fas fa-user-circle"></i>
          <input type="text" placeholder="email or ID">
        </div>
      </div>

      <!-- password -->
      <div class="field">
        <label>password</label>
        <div class="input-wrapper">
          <i class="fas fa-lock-open"></i>
          <input type="password" placeholder="••••••••">
        </div>
      </div>


      <!-- action button -->
      <button class="login-btn">
        <span>Log in</span>
        <i class="fas fa-arrow-right"></i>
      </button>

    <!-- footer (clean, transparent) -->
    <div class="card-footer">
      <div><i class="fas fa-shield-alt" style="margin-right: 0.3rem;"></i> Powered By PositiQ Business Solutions</div>
    </div>
  </div>
</body>
</html>