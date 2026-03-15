<?php
require_once __DIR__ . '/components/UI/auth.php';
pos_redirect_if_authenticated();

$errorMessage = '';
$emailValue = '';
$rememberChecked = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailValue = trim((string) ($_POST['email'] ?? ''));
    $passwordValue = (string) ($_POST['password'] ?? '');
    $rememberChecked = !empty($_POST['remember_me']);

    $response = pos_api_request('POST', '/auth/login', [
        'email' => $emailValue,
        'password' => $passwordValue,
        'rememberMe' => $rememberChecked,
    ]);

    if ($response['ok'] && !empty($response['data']['success']) && !empty($response['data']['data'])) {
        $authPayload = $response['data']['data'];
        pos_store_auth_session($authPayload);

        if (!empty($authPayload['rememberToken'])) {
            pos_set_remember_cookie($authPayload['rememberToken'], $authPayload['rememberTokenExpiresAt'] ?? null);
        } else {
            pos_clear_remember_cookie();
        }

        header('Location: /components/pages/index.php');
        exit;
    }

    $errorMessage = $response['message'] ?: 'Unable to log in with those credentials.';
}
?>
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
  <style>
    .login-form {
      display: contents;
    }
    .login-error {
      margin-bottom: 14px;
      padding: 10px 12px;
      border-radius: 12px;
      background: #fff0f0;
      color: #b42318;
      font-size: 13px;
      border: 1px solid #f8d7da;
    }
    .remember-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
      margin: 12px 0 18px;
      font-size: 13px;
      color: #44506b;
    }
    .remember-row label {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      cursor: pointer;
    }
    .hint-text {
      margin-top: 12px;
      font-size: 12px;
      color: #667085;
      text-align: center;
    }
  </style>
</head>
<body>
  <script src="/pwa-client.js"></script>
  <div class="login-card">
    <div class="logo-container">
      <div class="logo-symbol">
        <img src="https://res.cloudinary.com/dhqcnszvn/image/upload/v1771859587/WhatsApp_Image_2026-02-20_at_21.01.29_e73m2g.png" alt="logo" width="250">
      </div>
      <div class="descriptor">Light up your Digital Dream</div>
    </div>

    <div class="card-body">
      <form method="post" class="login-form">
        <?php if ($errorMessage): ?>
          <div class="login-error"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <div class="field">
          <label for="loginEmail">operator</label>
          <div class="input-wrapper">
            <i class="fas fa-user-circle"></i>
            <input id="loginEmail" name="email" type="email" placeholder="email address" value="<?php echo htmlspecialchars($emailValue, ENT_QUOTES, 'UTF-8'); ?>" required>
          </div>
        </div>

        <div class="field">
          <label for="loginPassword">password</label>
          <div class="input-wrapper">
            <i class="fas fa-lock-open"></i>
            <input id="loginPassword" name="password" type="password" placeholder="••••••••" required>
          </div>
        </div>

        <div class="remember-row">
          <label for="rememberMe">
            <input id="rememberMe" name="remember_me" type="checkbox" <?php echo $rememberChecked ? 'checked' : ''; ?>>
            <span>Remember me until logout</span>
          </label>
        </div>

        <button class="login-btn" type="submit">
          <span>Log in</span>
          <i class="fas fa-arrow-right"></i>
        </button>

        <div class="hint-text">Default superadmin is created automatically when the user table is initialized.</div>
      </form>

      <div class="card-footer">
        <div><i class="fas fa-shield-alt" style="margin-right: 0.3rem;"></i> Powered By PositiQ Business Solutions</div>
      </div>
    </div>
  </div>
</body>
</html>