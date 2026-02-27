<?php
$name  = $_GET['name']  ?? 'Product';
$sku   = $_GET['sku']   ?? 'SKU';
$price = $_GET['price'] ?? '0';

function e($v) { return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Label - <?= e($name) ?></title>
  <style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:Arial,sans-serif;background:#fafafa}
    .wrap{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:18px}
    .label{width:300px;background:#fff;border-radius:10px;border:2px solid #1a237e;padding:18px;box-shadow:0 6px 16px rgba(0,0,0,.12);text-align:center}
    .name{font-size:14px;font-weight:800;color:#1a237e;line-height:1.3;margin-bottom:8px;word-break:break-word}
    .sku{font-size:11px;color:#555;margin:8px 0;font-family:Courier New,monospace;background:#f5f5f5;padding:6px;border-radius:6px;border:1px solid #ddd}
    .price{margin-top:8px;font-size:14px;font-weight:800}
    .price span{font-size:12px;font-weight:500}
    @media print{
      body{background:#fff}
      .wrap{min-height:auto;padding:0}
      .label{box-shadow:none;border:1px solid #333;border-radius:0;width:100%;max-width:3.5in}
    }
  </style>
</head>
<body>
  <div class="wrap">
    <div class="label">
      <div class="name"><?= e($name) ?></div>
      <div class="sku"><?= e($sku) ?></div>
      <div style="margin:10px 0;">
        <svg id="barcode"></svg>
      </div>
      <div class="price"><span>LKR</span> <?= e($price) ?></div>
      <div id="err" style="margin-top:10px;color:red;font-size:12px;"></div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
  <script>
    window.addEventListener('load', function () {
      try {
        if (!window.JsBarcode) throw new Error("JsBarcode not loaded");
        JsBarcode('#barcode', <?= json_encode($sku) ?>, {
          format: 'CODE128',
          displayValue: true,
          fontSize: 12,
          height: 48,
          margin: 0
        });
      } catch (e) {
        console.error(e);
        document.getElementById('err').textContent = "Barcode failed. Check console.";
      }
      setTimeout(function(){ window.print(); }, 300);
    });
  </script>
</body>
</html>