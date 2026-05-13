<?php
/**
 * SSS — ana sayfa (compact: ilk 5 + tam sayfa bağlantısı) veya tam liste (full).
 *
 * Dışarıdan (tam sayfa için):
 *   $faq_sss_mode = 'full';
 *   $faq_sss_initial_konu = (string) GET veya seçilen kategori id;
 */
$faq_sss_mode = isset($faq_sss_mode) && $faq_sss_mode === 'full' ? 'full' : 'compact';

$sss_data = require __DIR__ . '/../data/faq-sss-data.php';
$sss_categories = $sss_data['categories'] ?? [];
$sss_items = $sss_data['items'] ?? [];

$items_by_cat = [];
foreach ($sss_items as $row) {
  $c = $row['cat'] ?? '';
  if ($c === '') {
    continue;
  }
  if (!isset($items_by_cat[$c])) {
    $items_by_cat[$c] = [];
  }
  $items_by_cat[$c][] = $row;
}

$faq_sss_initial_konu = isset($faq_sss_initial_konu) ? (string) $faq_sss_initial_konu : '';
$cat_ids = array_column($sss_categories, 'id');
$initial_ci = 0;
if ($faq_sss_initial_konu !== '') {
  $idx = array_search($faq_sss_initial_konu, $cat_ids, true);
  if ($idx !== false) {
    $initial_ci = (int) $idx;
  }
}
$initial_cid = $sss_categories[$initial_ci]['id'] ?? ($cat_ids[0] ?? 'satin-alim');

$id_suffix = $faq_sss_mode === 'full' ? '-full' : '';

$faq_sss_show_full_intro = isset($faq_sss_show_full_intro) ? (bool) $faq_sss_show_full_intro : true;

$faq_sss_section_labelledby = $faq_sss_mode === 'full'
  ? ($faq_sss_show_full_intro ? 'faq-sss-page-intro' : '')
  : 'faq-sss-heading';
$faq_sss_section_aria = ($faq_sss_mode === 'full' && !$faq_sss_show_full_intro)
  ? 'Sıkça Sorulan Sorular'
  : '';
?>
<section
  class="sec sec-faq-sss light<?php echo $faq_sss_mode === 'full' ? ' sec-faq-sss--full' : ''; ?>"
  id="faqSss"
  data-faq-sss-mode="<?php echo htmlspecialchars($faq_sss_mode, ENT_QUOTES, 'UTF-8'); ?>"
  <?php echo $faq_sss_section_aria !== '' ? 'aria-label="' . htmlspecialchars($faq_sss_section_aria, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>
  <?php echo $faq_sss_section_labelledby !== '' ? 'aria-labelledby="' . htmlspecialchars($faq_sss_section_labelledby, ENT_QUOTES, 'UTF-8') . '"' : ''; ?>
>
  <div class="sec-inner sec-inner--faq-sss<?php echo $faq_sss_mode === 'full' ? ' sec-inner--faq-sss-full' : ''; ?>">
    <?php if ($faq_sss_mode === 'full' && $faq_sss_show_full_intro) : ?>
    <p id="faq-sss-page-intro" class="lead lead--faq-sss lead--faq-sss-page-intro">
      Soldan konuyu seçin; soruların yanındaki <strong>+</strong> ile yanıtları açabilirsiniz.
    </p>
    <?php elseif ($faq_sss_mode === 'compact') : ?>
    <h2 id="faq-sss-heading" class="title title--faq-sss">Sıkça Sorulan Sorular</h2>
    <p class="lead lead--faq-sss">
      Merak ettiklerinizi konulara göre filtreleyin; her sorunun yanındaki <strong>+</strong> ile yanıtı açabilirsiniz.
    </p>
    <?php endif; ?>

    <div class="faq-sss-layout">
      <aside class="faq-sss-sidebar" aria-label="Soru konuları">
        <p class="faq-sss-sidebar-title">Konu seçin</p>
        <div class="faq-sss-cats" role="tablist" aria-orientation="vertical">
          <?php foreach ($sss_categories as $ci => $cat) :
            $cid = $cat['id'] ?? '';
            $label = $cat['label'] ?? '';
            $is_active = $ci === $initial_ci;
            ?>
          <button
            type="button"
            class="btn btn-ghost btn--faq-sss-cat<?php echo $is_active ? ' is-active' : ''; ?>"
            id="faq-sss-tab<?php echo htmlspecialchars($id_suffix, ENT_QUOTES, 'UTF-8'); ?>-<?php echo htmlspecialchars($cid, ENT_QUOTES, 'UTF-8'); ?>"
            role="tab"
            aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
            aria-controls="faq-sss-panel<?php echo htmlspecialchars($id_suffix, ENT_QUOTES, 'UTF-8'); ?>-<?php echo htmlspecialchars($cid, ENT_QUOTES, 'UTF-8'); ?>"
            tabindex="<?php echo $is_active ? '0' : '-1'; ?>"
            data-category="<?php echo htmlspecialchars($cid, ENT_QUOTES, 'UTF-8'); ?>"
          >
            <span class="faq-sss-cat-icon" aria-hidden="true">?</span>
            <span class="faq-sss-cat-label"><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></span>
          </button>
          <?php endforeach; ?>
        </div>
      </aside>

      <div class="faq-sss-main">
        <div class="faq-sss-main-surface">
          <?php foreach ($sss_categories as $ci => $cat) :
            $cid = $cat['id'] ?? '';
            $clist = $items_by_cat[$cid] ?? [];
            $panel_hidden = $ci !== $initial_ci;
            ?>
          <div
            class="faq-sss-panel"
            id="faq-sss-panel<?php echo htmlspecialchars($id_suffix, ENT_QUOTES, 'UTF-8'); ?>-<?php echo htmlspecialchars($cid, ENT_QUOTES, 'UTF-8'); ?>"
            data-category="<?php echo htmlspecialchars($cid, ENT_QUOTES, 'UTF-8'); ?>"
            role="tabpanel"
            <?php echo $panel_hidden ? ' hidden' : ''; ?>
            aria-labelledby="faq-sss-tab<?php echo htmlspecialchars($id_suffix, ENT_QUOTES, 'UTF-8'); ?>-<?php echo htmlspecialchars($cid, ENT_QUOTES, 'UTF-8'); ?>"
          >
            <div class="faq-sss-list">
              <?php foreach ($clist as $qi => $faq) :
                $qid = 'faq-sss-q' . $id_suffix . '-' . preg_replace('/[^a-z0-9_-]/i', '', $cid) . '-' . $qi;
                $aid = 'faq-sss-a' . $id_suffix . '-' . preg_replace('/[^a-z0-9_-]/i', '', $cid) . '-' . $qi;
                ?>
              <div class="faq-sss-item">
                <button
                  type="button"
                  class="faq-sss-trigger"
                  id="<?php echo htmlspecialchars($qid, ENT_QUOTES, 'UTF-8'); ?>"
                  aria-expanded="false"
                  aria-controls="<?php echo htmlspecialchars($aid, ENT_QUOTES, 'UTF-8'); ?>"
                >
                  <span class="faq-sss-qtext"><?php echo htmlspecialchars($faq['q'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                  <span class="faq-sss-icon" aria-hidden="true"></span>
                </button>
                <div
                  class="faq-sss-answer"
                  id="<?php echo htmlspecialchars($aid, ENT_QUOTES, 'UTF-8'); ?>"
                  role="region"
                  aria-labelledby="<?php echo htmlspecialchars($qid, ENT_QUOTES, 'UTF-8'); ?>"
                  hidden
                >
                  <div class="faq-sss-answer-inner">
                    <p><?php echo htmlspecialchars($faq['a'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                  </div>
                </div>
              </div>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endforeach; ?>

          <?php if ($faq_sss_mode === 'compact') : ?>
          <div class="faq-sss-more-wrap">
            <a
              class="btn btn-ghost btn--faq-sss-more"
              id="faqSssMore"
              href="sikca-sorulan-sorular.php?konu=<?php echo rawurlencode($initial_cid); ?>"
            >
              Daha fazla göster
            </a>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
