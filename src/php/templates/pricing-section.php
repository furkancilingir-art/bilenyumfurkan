<?php
/**
 * Ana sayfa ve egitim-setleri sayfasinda ortak paket grid'i.
 * Include oncesi opsiyonel: $pricing_section_title, $pricing_section_lead, $pricing_cta_variant ('single'|'dual'|'none').
 */
$pricing_section_title = $pricing_section_title ?? 'Bilenyum Eğitim Paketleri';
$pricing_section_lead = $pricing_section_lead ?? '';
$pricing_cta_variant = $pricing_cta_variant ?? 'single';
?>
<!-- ============== PAKETLER (ortak blok) ============== -->
<section class="sec sec-pricing" id="pricing" data-screen-label="Paketler">
  <div class="sec-inner">
    <h2 class="title"><?php echo htmlspecialchars($pricing_section_title, ENT_QUOTES, 'UTF-8'); ?></h2>
    <?php if ($pricing_section_lead !== ''): ?>
    <p class="lead pricing-section-lead"><?php echo htmlspecialchars($pricing_section_lead, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <div class="pricing-tabs" role="tablist">
      <button type="button" class="pricing-tab active" data-grade="8">8. Sınıf (LGS) Setleri</button>
      <button type="button" class="pricing-tab" data-grade="7">7. Sınıf Setleri</button>
      <button type="button" class="pricing-tab" data-grade="6">6. Sınıf Setleri</button>
      <button type="button" class="pricing-tab" data-grade="5">5. Sınıf Setleri</button>
    </div>

    <div class="pricing-wrap">
      <button type="button" class="pricing-arrow prev" aria-label="Önceki paket">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="15 18 9 12 15 6"/></svg>
      </button>
      <div class="pricing-grid" id="pricingGrid" aria-live="polite"></div>
      <button type="button" class="pricing-arrow next" aria-label="Sonraki paket">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="9 18 15 12 9 6"/></svg>
      </button>
    </div>

    <?php if ($pricing_cta_variant === 'dual'): ?>
    <div class="pricing-cta pricing-cta--dual">
      <a href="landing-reference.php" class="btn btn-ghost">← Ana sayfaya dön</a>
      <a href="#footer" class="btn btn-primary">Kayıt ve iletişim</a>
    </div>
    <?php elseif ($pricing_cta_variant === 'single'): ?>
    <div class="pricing-cta">
      <a href="egitim-setleri.php" class="btn btn-ghost">Tüm paketleri gör →</a>
    </div>
    <?php endif; ?>
  </div>
</section>
