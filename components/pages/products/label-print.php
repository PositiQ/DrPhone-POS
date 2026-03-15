<?php
require_once __DIR__ . '/../../UI/auth.php';
pos_require_auth('products');
$name = $_GET['name'] ?? 'Product';
$imei = $_GET['imei'] ?? 'N/A';
$productId = $_GET['product_id'] ?? 'N/A';
$fmi = $_GET['fmi'] ?? 'N/A';
$iosVersion = $_GET['ios_version'] ?? 'N/A';
$color = $_GET['color'] ?? 'N/A';
$condition = $_GET['condition'] ?? 'N/A';
$battery = $_GET['battery'] ?? 'N/A';
$storage = $_GET['storage'] ?? 'N/A';
$date = $_GET['date'] ?? date('Y-m-d');
$sim = $_GET['sim'] ?? 'N/A';
$code = $_GET['code'] ?? 'N/A';

function e($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Phone Sticker - <?= e($name) ?></title>
<style>
  :root {
    --label-width: 58mm;
    --label-height: 40mm;
    --pad: 2mm;
    --gap: 1mm;
    --line: 0.4mm;
    --font-main: "Arial", "Helvetica", sans-serif;
  }

  * {
    box-sizing: border-box;
  }

  body {
    margin: 0;
    font-family: var(--font-main);
    background: #f5f5f5;
  }

  .sticker-page {
    min-height: 100svh;
    display: grid;
    place-items: center;
    padding: 8px;
  }

  .sticker {
    width: min(100%, calc(var(--label-width) * 3.7));
    background: #fff;
    padding: var(--pad);
    color: #000;
  }

  .sticker-58x40 {
    aspect-ratio: 58 / 40;
  }

  .top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: var(--gap);
    border-bottom: var(--line) solid #000;
    padding-bottom: 1mm;
  }

  .logo {
    font-weight: 700;
    font-size: clamp(11px, 2.8vw, 13px);
    white-space: nowrap;
  }

  .barcode-number {
    font-size: clamp(10px, 2.7vw, 13px);
    letter-spacing: 0.4px;
    text-align: right;
    overflow-wrap: anywhere;
  }

  .product {
    border: var(--line) solid #000;
    margin: 1.3mm 0;
    padding: 1.1mm;
    text-align: center;
    font-size: clamp(9px, 2.4vw, 11px);
    line-height: 1.15;
  }

  .bottom {
    display: grid;
    grid-template-columns: 2fr 1fr 2fr;
    gap: var(--gap);
  }

  .left,
  .middle,
  .right {
    border: var(--line) solid #000;
    padding: 1mm;
    font-size: clamp(8px, 2.2vw, 10px);
    line-height: 1.15;
    min-width: 0;
  }

  .left div,
  .right div {
    overflow-wrap: anywhere;
  }

  .middle {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: clamp(10px, 2.8vw, 12px);
    text-align: center;
  }

  .code {
    margin-top: 1mm;
    font-size: clamp(8px, 2vw, 9px);
  }

  @media (max-width: 520px) {
    .sticker-page {
      padding: 8px;
    }

    .sticker {
      width: 100%;
    }
  }

  @media print {
    @page {
      size: auto;
      margin: 0;
    }

    html,
    body {
      margin: 0;
      padding: 0;
      background: #fff;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }

    .sticker-page {
      min-height: auto;
      display: block;
      padding: 0;
    }

    .sticker {
      page-break-inside: avoid;
      break-inside: avoid;
      width: var(--label-width);
      height: var(--label-height);
    }
  }
</style>
</head>
<body>

<div class="sticker-page">
  <div class="sticker sticker-58x40" role="document" aria-label="Phone sticker label">

    <div class="top">
      <div class="logo">Dr Phone</div>
      <div class="barcode-number">IMEI: <?= e($imei) ?></div>
    </div>

    <div class="product">
      <b><?= e($name) ?></b>
    </div>

    <div class="bottom">

      <div class="left">
        <div><strong>ID #</strong> <?= e($productId) ?></div>
        <div><strong>FMI</strong> <?= e($fmi) ?></div>
        <div><strong>IOS Version</strong> <?= e($iosVersion) ?></div>
        <div><strong>Color</strong> <?= e($color) ?></div>
        <div><strong>Condition</strong> <?= e($condition) ?></div>
      </div>

      <div class="middle">
        <div>Battery: <br>
        <?= e($battery) ?> <br>
        Storage: <br>
        <?= e($storage) ?>
        </div>
      </div>

      <div class="right">
        <div>(<?= e($code) ?>)</div>
        <div>Date: <?= e($date) ?></div>
        <div>Sim: <?= e($sim) ?></div>
      </div>

    </div>
  </div>
</div>

<script>
window.addEventListener('load', function () {
  setTimeout(function () { window.print(); }, 200);
});
</script>

</body>
</html>