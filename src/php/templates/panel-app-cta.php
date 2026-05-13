<?php
/**
 * Paneller bölümünün altında — mobil uygulama indirme şeridi (koyu zemin).
 * Mağaza URL’leri yayına göre güncellenmelidir.
 */
$app_ios_url = $GLOBALS['bilenyum_app_ios_url'] ?? '#bilenyum-ios-app';
$app_android_url = $GLOBALS['bilenyum_app_android_url'] ?? '#bilenyum-android-app';
?>


<section class="sec sec-panel-app" id="panel-app" aria-labelledby="panel-app-heading">
  <div class="sec-inner sec-inner--panel-app">
    <h2 id="panel-app-heading" class="panel-app-heading">Benzersiz Bir Öğrenme Deneyimi</h2>
    <p class="panel-app-lead">Şimdi Bilenyum mobil uygulamamızı indirin.</p>
    <p class="panel-app-lead panel-app-lead--accent">Benzersiz öğrenme deneyimine başlayın!</p>

    <div class="panel-app-stores">
      <a
        class="panel-app-store-btn"
        href="<?php echo htmlspecialchars((string) $app_ios_url, ENT_QUOTES, 'UTF-8'); ?>"
        <?php echo strpos((string) $app_ios_url, 'http') === 0 ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>
      >
        <span class="panel-app-store-icon panel-app-store-icon--apple" aria-hidden="true">
          <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.05 20.28c-.98.95-2.05.88-3.08.4-1.09-.5-2.08-.48-3.24 0-1.44.62-2.2.44-3.06-.4C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.55-1.31 3.07-2.53 4.08zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
          </svg>
        </span>
        <span class="panel-app-store-copy">
          <span class="panel-app-store-name">App Store</span>
          <span class="panel-app-store-from">'dan indir</span>
        </span>
      </a>
      <a
        class="panel-app-store-btn"
        href="<?php echo htmlspecialchars((string) $app_android_url, ENT_QUOTES, 'UTF-8'); ?>"
        <?php echo strpos((string) $app_android_url, 'http') === 0 ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>
      >
        <span class="panel-app-store-icon panel-app-store-icon--play" aria-hidden="true">
          <svg width="26" height="28" viewBox="0 0 24 28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 2.5v23L22.5 14 3 2.5z" fill="currentColor"/>
          </svg>
        </span>
        <span class="panel-app-store-copy">
          <span class="panel-app-store-name">Google Play</span>
          <span class="panel-app-store-from">'den indir</span>
        </span>
      </a>
    </div>
  </div>
</section>

<!-- Uygulama CTA (koyu) → Partner şeridi (açık): dalga köprüsü -->
<div class="space-divider space-divider--panel-app-bottom" aria-hidden="true">
  <div class="geo-circle-panel-app geo-circle-panel-app--bottom"></div>
  <div class="geo-dot-panel-app d1"></div>
  <div class="geo-dot-panel-app d2"></div>
  <div class="geo-line-panel-app"></div>
  <div class="geo-tri-panel-app"></div>
  <svg class="space-wave space-wave--panel-app-bottom" viewBox="0 0 1440 200" preserveAspectRatio="none" aria-hidden="true">
    <path d="M0,120 C320,160 640,90 960,140 C1180,175 1320,115 1440,150 L1440,200 L0,200 Z" fill="rgba(124,92,255,0.16)"/>
    <path d="M0,150 C260,195 540,115 820,165 C1080,210 1300,140 1440,175 L1440,200 L0,200 Z" fill="rgba(230,8,123,0.12)"/>
    <path d="M0,175 C200,215 460,145 720,178 C960,208 1180,148 1440,178 L1440,200 L0,200 Z" fill="#fafaff"/>
  </svg>
</div>
