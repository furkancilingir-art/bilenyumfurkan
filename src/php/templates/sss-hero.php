<?php
/* Yedek şablon — canlı sayfa faq-sss-page-hero.php kullanır. */
$nav_page_intro_title = isset($nav_page_intro_title) ? trim((string) $nav_page_intro_title) : '';
$nav_page_intro_lead = isset($nav_page_intro_lead) ? trim((string) $nav_page_intro_lead) : '';
?>
<section class="sec nav-page-hero" aria-labelledby="sss-hero-title">
  <?php include __DIR__ . '/hero-stars.php'; ?>
  <div class="sec-inner sec-inner--nav-hero">
    <p class="nav-page-hero-eyebrow">SSS</p>
    <h1 id="sss-hero-title" class="title title--faq-sss-page">Sıkça Sorulan Sorular</h1>
    <?php if ($nav_page_intro_title !== '') : ?>
    <p class="nav-page-hero-kicker"><?php echo htmlspecialchars($nav_page_intro_title, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
    <?php if ($nav_page_intro_lead !== '') : ?>
    <p class="lead lead--nav-hero"><?php echo htmlspecialchars($nav_page_intro_lead, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
  </div>
</section>
