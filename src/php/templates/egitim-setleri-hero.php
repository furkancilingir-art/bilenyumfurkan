<?php
$nav_page_intro_title = isset($nav_page_intro_title) ? trim((string) $nav_page_intro_title) : '';
$nav_page_intro_lead = isset($nav_page_intro_lead) ? trim((string) $nav_page_intro_lead) : '';
?>
<section class="sec nav-page-hero" aria-labelledby="setleri-hero-title">
  <?php include __DIR__ . '/hero-stars.php'; ?>
  <div class="sec-inner sec-inner--nav-hero">
    <p class="nav-page-hero-eyebrow">Eğitim setleri</p>
    <h1 id="setleri-hero-title" class="title title--setleri-page">Eğitim setleri</h1>
    <?php if ($nav_page_intro_title !== '') : ?>
    <p class="nav-page-hero-kicker"><?php echo htmlspecialchars($nav_page_intro_title, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <?php if ($nav_page_intro_lead !== '') : ?>
    <p class="lead lead--nav-hero"><?php echo htmlspecialchars($nav_page_intro_lead, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
  </div>
</section>
