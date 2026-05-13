<?php
if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

$nav_active = 'iletisim';

require_once __DIR__ . '/../php/include/pricing-assets-path.php';
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Bize Ulaşın — Bilenyum</title>
  <meta name="description" content="Bilenyum iletişim: çağrı merkezi, WhatsApp, adres ve kurumsal bilgiler. Haftanın 7 günü 09:00–00:00 arası ulaşılabilir." />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../components/styles/main.css">
  <link rel="stylesheet" href="../components/styles/landing-reference.css">
</head>
<body class="page-iletisim">
<div class="site-header"><?php include __DIR__ . '/../php/templates/topbar.php'; ?><?php include __DIR__ . '/../php/templates/header.php'; ?></div>

<?php
$nav_page_intro_title = 'Size nasıl yardımcı olabiliriz?';
$nav_page_intro_lead = 'Bilenyum hakkında daha fazla bilgi sahibi olmak ister misiniz? Bize haftanın 7 günü 09:00 ile 00:00 aralığında ulaşabilirsiniz.';
include __DIR__ . '/../php/templates/bize-ulasin-hero.php';
?>

<?php include __DIR__ . '/../php/templates/space-divider-wave-purple.php'; ?>

<?php include __DIR__ . '/../php/templates/bize-ulasin-content.php'; ?>

<div class="space-divider-light">
  <div class="geo-circle-light"></div>
  <div class="geo-dot-light d1"></div>
  <div class="geo-dot-light d2"></div>
  <div class="geo-line-light"></div>
  <div class="geo-tri-light"></div>
  <svg class="space-wave-light" viewBox="0 0 1440 200" preserveAspectRatio="none" aria-hidden="true">
    <path d="M0,120 C320,160 640,90 960,140 C1180,175 1320,115 1440,150 L1440,200 L0,200 Z" fill="rgba(62,58,142,0.18)"/>
    <path d="M0,150 C260,195 540,115 820,165 C1080,210 1300,140 1440,175 L1440,200 L0,200 Z" fill="rgba(227,92,151,0.20)"/>
    <path d="M0,175 C200,215 460,145 720,178 C960,208 1180,148 1440,178 L1440,200 L0,200 Z" fill="#ffffff"/>
  </svg>
</div>

<?php include __DIR__ . '/../php/templates/footer.php'; ?>
<?php include __DIR__ . '/../php/templates/fab.php'; ?>
<?php include __DIR__ . '/../php/templates/video-modal.php'; ?>
<script>window.__pricingImgBase=<?php echo json_encode($pricingImgWebBase, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;</script>
<script src="../components/scripts/pricing-catalog.js" charset="utf-8"></script>
<script src="../components/scripts/landing-reference.js" charset="utf-8"></script>
<script src="../components/scripts/yumi-assistant.js" charset="utf-8"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../components/scripts/main.js"></script>
</body>
</html>
