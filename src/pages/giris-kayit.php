<?php
if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

require_once __DIR__ . '/../php/include/pricing-assets-path.php';
$girisImgBase = $pricingImgWebBase;
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Giriş Yap veya Kayıt Ol — Bilenyum</title>
  <meta name="description" content="Bilenyum hesabınıza giriş yapın veya saniyeler içinde yeni hesap oluşturun." />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../components/styles/main.css">
  <link rel="stylesheet" href="../components/styles/landing-reference.css">
</head>
<body class="page-giris-kayit">
<header class="checkout-top">
  <div class="checkout-top-inner">
    <a class="checkout-logo" href="landing-reference.php" aria-label="Bilenyum ana sayfa">
      <img src="../../assets/logo.png" alt="Bilenyum" width="160" height="40" decoding="async" />
    </a>
    <div class="checkout-top-help">
      <p>Giriş yapma işlemleriniz ile ilgili problem yaşıyorsanız bize ulaşabilirsiniz.</p>
      <div class="checkout-top-contacts">
        <a href="https://wa.me/905551234567" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.6 6.32A7.85 7.85 0 0 0 12.05 4a7.94 7.94 0 0 0-6.88 11.9L4 20l4.2-1.1A7.93 7.93 0 0 0 12.05 20h.01a7.95 7.95 0 0 0 5.55-13.68zM12.06 18.5h-.01a6.59 6.59 0 0 1-3.36-.92l-.24-.14-2.5.65.67-2.43-.16-.25a6.6 6.6 0 1 1 12.24-3.46 6.6 6.6 0 0 1-6.64 6.55z"/></svg>
          +90 555 123 45 67
        </a>
        <a href="tel:+908501234567">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 15.5c-1.25 0-2.45-.2-3.57-.57a1.02 1.02 0 0 0-1.02.24l-2.2 2.2a15.07 15.07 0 0 1-6.59-6.59l2.2-2.21a.96.96 0 0 0 .25-1A11.36 11.36 0 0 1 8.5 4c0-.55-.45-1-1-1H4a1 1 0 0 0-1 1 17 17 0 0 0 17 17c.55 0 1-.45 1-1v-3.5c0-.55-.45-1-1-1z"/></svg>
          0850 123 45 67
        </a>
        <a href="mailto:info@bilenyum.com">
          <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 6.75A2.75 2.75 0 0 1 5.75 4h12.5A2.75 2.75 0 0 1 21 6.75v10.5A2.75 2.75 0 0 1 18.25 20H5.75A2.75 2.75 0 0 1 3 17.25V6.75zm2.1-.25L12 11.33 18.9 6.5H5.1zM19 8.42l-6.43 4.5a1 1 0 0 1-1.14 0L5 8.42v8.83c0 .41.34.75.75.75h12.5c.41 0 .75-.34.75-.75V8.42z"/></svg>
          info@bilenyum.com
        </a>
      </div>
    </div>
  </div>
</header>

<?php include __DIR__ . '/../php/templates/giris-kayit-content.php'; ?>

<script>window.__pricingImgBase=<?php echo json_encode($pricingImgWebBase, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;</script>
<script src="../components/scripts/pricing-catalog.js" charset="utf-8"></script>
<script src="../components/scripts/landing-reference.js" charset="utf-8"></script>
<script src="../components/scripts/giris-kayit.js" charset="utf-8"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../components/scripts/main.js"></script>
</body>
</html>
