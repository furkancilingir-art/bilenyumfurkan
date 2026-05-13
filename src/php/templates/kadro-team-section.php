<?php
/**
 * Kadro listesi + birim butonları + dikey kartlar (detay sayfasına link).
 */
$kadro_departments = require __DIR__ . '/../data/kadro-departments.php';
if (!is_array($kadro_departments)) {
    $kadro_departments = [];
}
$kadro_team = require __DIR__ . '/../data/kadro-team-data.php';
if (!is_array($kadro_team)) {
    $kadro_team = [];
}
$kadro_img_base = '../components/images/kadro/';
?>
<section class="sec sec-kadro-team kadro-team--surface light" id="kadro-listesi" aria-label="Eğitmen kadrosu">
  <div class="sec-inner sec-inner--kadro">
    <div class="kadro-filter-bar kadro-filter-bar--dark">
      <div class="kadro-filter-buttons" role="group" aria-label="Birime göre filtrele">
        <?php foreach ($kadro_departments as $dept_id => $label): ?>
          <button
            type="button"
            class="kadro-dept-btn kadro-dept-btn--dark<?php echo $dept_id === 'all' ? ' is-active' : ''; ?>"
            data-dept="<?php echo htmlspecialchars((string) $dept_id, ENT_QUOTES, 'UTF-8'); ?>"
            aria-pressed="<?php echo $dept_id === 'all' ? 'true' : 'false'; ?>"
          >
            <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
          </button>
        <?php endforeach; ?>
      </div>
    </div>

    <p class="kadro-empty kadro-empty--hidden kadro-empty--on-surface" id="kadro-empty-state" role="status" aria-live="polite">
      Bu birim için şimdilik kayıt görünmüyor. Başka bir birim seçebilirsiniz.
    </p>

    <div class="kadro-grid kadro-grid--vertical" id="kadro-grid">
      <?php foreach ($kadro_team as $member): ?>
        <?php
        $dept = $member['dept'] ?? '';
        $dept_label = $kadro_departments[$dept] ?? $dept;
        $detail_id = rawurlencode((string) ($member['id'] ?? ''));
        $mid = preg_replace('/[^a-z0-9_-]/i', '', (string) ($member['id'] ?? ''));
        $photo_src = $kadro_img_base . rawurlencode($mid) . '.jpg';
        $name_esc = htmlspecialchars((string) ($member['name'] ?? ''), ENT_QUOTES, 'UTF-8');
        ?>
        <article class="kadro-card kadro-card--vertical kadro-card--dark" data-dept="<?php echo htmlspecialchars((string) $dept, ENT_QUOTES, 'UTF-8'); ?>">
          <a class="kadro-card-link" href="kadro-detay.php?id=<?php echo htmlspecialchars($detail_id, ENT_QUOTES, 'UTF-8'); ?>">
            <div class="kadro-card-visual kadro-card-visual--dark">
              <div class="kadro-card-photo-frame">
                <img
                  class="kadro-card-photo"
                  src="<?php echo htmlspecialchars($photo_src, ENT_QUOTES, 'UTF-8'); ?>"
                  alt=""
                  width="400"
                  height="500"
                  loading="lazy"
                  decoding="async"
                />
              </div>
            </div>
            <div class="kadro-card-body kadro-card-body--dark">
              <h3 class="kadro-card-name"><?php echo $name_esc; ?></h3>
              <p class="kadro-card-role"><?php echo htmlspecialchars((string) ($member['title'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></p>
              <p class="kadro-card-dept"><span class="kadro-card-dept-label">Birim</span> <?php echo htmlspecialchars($dept_label, ENT_QUOTES, 'UTF-8'); ?></p>
              <span class="kadro-card-cta kadro-card-cta--btn">Detaylı incele</span>
            </div>
          </a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
