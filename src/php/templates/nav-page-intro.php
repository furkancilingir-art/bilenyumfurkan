<?php
/**
 * İç sayfalar: mor dalgadan sonra paketler bloğundaki gibi ortak h2 + lead.
 * Include öncesi: $nav_page_intro_title (önerilir), $nav_page_intro_lead (opsiyonel),
 * $nav_page_intro_id (opsiyonel, varsayılan nav-page-intro).
 */
$nav_page_intro_title = isset($nav_page_intro_title) ? trim((string) $nav_page_intro_title) : '';
$nav_page_intro_lead = isset($nav_page_intro_lead) ? trim((string) $nav_page_intro_lead) : '';
if ($nav_page_intro_title === '') {
  return;
}
$nav_page_intro_id = isset($nav_page_intro_id) ? preg_replace('/[^a-z0-9_-]/i', '', (string) $nav_page_intro_id) : 'nav-page-intro';
if ($nav_page_intro_id === '') {
  $nav_page_intro_id = 'nav-page-intro';
}
$heading_id = $nav_page_intro_id . '-heading';
?>
<section class="sec sec-nav-page-intro light" aria-labelledby="<?php echo htmlspecialchars($heading_id, ENT_QUOTES, 'UTF-8'); ?>">
  <div class="sec-inner sec-inner--nav-page-intro">
    <h2 id="<?php echo htmlspecialchars($heading_id, ENT_QUOTES, 'UTF-8'); ?>" class="title title--nav-page-intro"><?php echo htmlspecialchars($nav_page_intro_title, ENT_QUOTES, 'UTF-8'); ?></h2>
    <?php if ($nav_page_intro_lead !== '') : ?>
    <p class="lead lead--nav-page-intro"><?php echo htmlspecialchars($nav_page_intro_lead, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>
  </div>
</section>
