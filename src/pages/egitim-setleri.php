<?php
if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

$nav_active = 'egitim';

require_once __DIR__ . '/../php/include/pricing-assets-path.php';

$pricing_section_title = 'Sınıfınıza uygun paketi seçin';
$pricing_section_lead = 'Tüm setlerde canlı dersler, kayıt arşivi ve veli paneli ile şeffaf takip sunuyoruz.';
$pricing_cta_variant = 'none';
?>
<!doctype html>
<html lang="tr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Eğitim setleri — Bilenyum</title>
  <meta name="description" content="5–8. sınıf Bilenyum eğitim paketleri; canlı ders, kayıt ve veli paneli ile tek çatı altında." />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../components/styles/main.css">
  <link rel="stylesheet" href="../components/styles/landing-reference.css">
</head>
<body class="page-egitim-setleri">
<div class="site-header"><?php include __DIR__ . '/../php/templates/topbar.php'; ?><?php include __DIR__ . '/../php/templates/header.php'; ?></div>

<?php
$nav_page_intro_title = 'Setlerinizi keşfedin';
$nav_page_intro_lead = 'Her sınıf seviyesi için özenle hazırlanmış paketler: canlı dersler, tekrar için kayıtlar ve tek panelden takip. Aşağıdan sınıfınızı seçerek paketleri karşılaştırabilirsiniz.';
include __DIR__ . '/../php/templates/egitim-setleri-hero.php';
?>

<?php include __DIR__ . '/../php/templates/space-divider-wave-purple.php'; ?>

<?php include __DIR__ . '/../php/templates/egitim-setleri-features.php'; ?>

<?php include __DIR__ . '/../php/templates/pricing-section.php'; ?>

<div class="section-fade section-fade--light-to-cosmic" aria-hidden="true"></div>

<div class="cosmic-band" data-cosmos-parallax>
<?php include __DIR__ . '/../php/templates/hero-stars.php'; ?>
<?php include __DIR__ . '/../php/templates/journey-section.php'; ?>
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
