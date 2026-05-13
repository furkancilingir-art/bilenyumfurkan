<?php
if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

$nav_active = 'kadro';

require_once __DIR__ . '/../php/include/pricing-assets-path.php';
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Eğitmen kadromuz — Bilenyum</title>
  <meta name="description" content="Bilenyum ekibi: yazılım, eğitim, ürün, içerik ve destek birimleri. Birim butonlarıyla filtreleyin, profillere tek tıkla gidin." />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../components/styles/main.css">
  <link rel="stylesheet" href="../components/styles/landing-reference.css">
</head>
<body class="page-kadromuz">
<div class="site-header"><?php include __DIR__ . '/../php/templates/topbar.php'; ?><?php include __DIR__ . '/../php/templates/header.php'; ?></div>

<?php
$nav_page_intro_title = 'Ekibimizle tanışın';
$nav_page_intro_lead = 'Bilenyum’u bir eğitim teknolojileri şirketi olarak ayakta tutan yazılım, eğitim, ürün, içerik ve daha fazlasından oluşan ekip. Birimi seçerek ilgilendiğiniz alandaki arkadaşlarımızı görün; profillerde LinkedIn, akademik geçmiş ve uzmanlıklarına ulaşabilirsiniz.';
include __DIR__ . '/../php/templates/kadro-hero.php';
?>

<?php include __DIR__ . '/../php/templates/space-divider-wave-purple.php'; ?>

<?php include __DIR__ . '/../php/templates/kadro-team-section.php'; ?>

<?php include __DIR__ . '/../php/templates/footer.php'; ?>
<?php include __DIR__ . '/../php/templates/fab.php'; ?>
<?php include __DIR__ . '/../php/templates/video-modal.php'; ?>
<script>window.__pricingImgBase=<?php echo json_encode($pricingImgWebBase, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;</script>
<script src="../components/scripts/pricing-catalog.js" charset="utf-8"></script>
<script src="../components/scripts/landing-reference.js" charset="utf-8"></script>
<script src="../components/scripts/yumi-assistant.js" charset="utf-8"></script>
<script src="../components/scripts/kadromuz.js" charset="utf-8"></script>
<script src="../components/scripts/main.js"></script>
</body>
</html>
