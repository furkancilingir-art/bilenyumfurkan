<?php
$heroSlides = [
  [
    'title_html' => 'Bilenyum\'da <span class="hero-title-accent">LGS Yaz Kampı</span> Başlıyor!',
    'lead_intro' => 'Yaz tatilinin tadını çıkarırken hedeflerinizden uzaklaşmayın.',
    'lead_bullets' => [
      'Matematik, Fen Bilimleri, Türkçe, Sosyal Bilgiler ve İngilizce — tam kapsamlı hızlandırma kampı.',
      'LGS\'ye online olarak, kesintisiz hazırlanın.',
      'Yeni döneme bir adım önde başlayın!',
    ],
    'cta' => [
      [
        'class' => 'btn btn-ghost',
        'href' => '#pricing',
        'label' => 'LGS Hızlandırma Paketini İncele',
        'aria' => 'LGS hızlandırma paketlerini görüntüle',
      ],
      [
        'class' => 'btn btn-primary',
        'href' => '#footer',
        'label' => 'Ücretsiz Deneme Dersine Katıl',
        'aria' => 'Ücretsiz deneme dersine kayıt veya iletişim',
      ],
    ],
  ],
  [
    'title_html' => '5. Sınıftan 8. Sınıfa <span class="hero-title-accent">Kesintisiz Başarı Yolculuğu</span>',
    'lead_intro' => 'Bilenyum sadece bir sınav hazırlık platformu değil, güvenilir bir yol arkadaşıdır.',
    'lead_bullets' => [
      'Ortaokul serüveninin başından LGS sonuna kadar yanınızdayız.',
      'Tüm kademelerde (5, 6, 7 ve 8. Sınıf) öğrenci ve velilerimize kesintisiz destek.',
      'Başarıyı tesadüfe bırakmıyoruz; adım adım birlikte inşa ediyoruz.',
    ],
    'cta' => [
      [
        'class' => 'btn btn-primary',
        'href' => '#journey',
        'label' => 'Eğitim Modelimizi Keşfet',
        'aria' => 'Eğitim modeli ve yolculuk bölümüne git',
      ],
    ],
  ],
  [
    'title_html' => 'Türkiye Yüzyılı Maarif Modeline <span class="hero-title-accent hero-title-accent--galactic">Tam Uyumlu</span> Yeni Nesil İçerikler',
    'lead_intro' => 'Uzman yazarlarımız tarafından titizlikle hazırlanan dijital içeriklerimizle öğrenmeyi derinleştiriyoruz:',
    'lead_bullets' => [
      [
        'label' => 'Kavram Temelli Öğrenim',
        'text' => 'Temeli sağlam atıp konuları ezberlemeden kavrayın.',
      ],
      [
        'label' => 'Bağlam Temelli Sorular',
        'text' => 'Yeni nesil sınav sisteminde ve Maarif Modelinde tam uzmanlık kazanın.',
      ],
      [
        'label' => 'Ders Sonu Özeti',
        'text' => 'Her dersten sonra işlenen konunun özet çalışma kaynağına anında ulaşın.',
      ],
    ],
    'bullet_style' => 'check',
    'cta' => [
      [
        'class' => 'btn btn-galactic',
        'href' => '#classroom',
        'label' => 'Dijital Kütüphanemizi İncele',
        'aria' => 'Örnek ders ve dijital içerik bölümüne git',
      ],
    ],
  ],
  [
    'title_html' => 'Dersteki Başarı Kadar <span class="hero-title-accent hero-title-accent--warm">Huzur da</span> Odak Noktamız',
    'slide_theme' => 'warm',
    'lead' => 'Öğrenciye iki haftada bir uzman PDR; velilere her ay webinarlar (akran zorbalığı, sınav kaygısı, ekran dengesi ve daha fazlası). Birlikte güçlü bir öğrenme ortamı.',
    'info_cards' => [
      [
        'title' => 'Uzman PDR',
        'text' => 'Birebir görüşme ve düzenli takip.',
      ],
      [
        'title' => 'Veli Akademisi',
        'text' => 'Aylık webinarlarla pedagojik destek.',
      ],
    ],
    'cta' => [
      [
        'class' => 'btn btn-warm',
        'href' => '#panel',
        'label' => 'PDR ve Rehberlik Sistemimiz',
        'aria' => 'Öğrenci ve veli panelleri bölümüne git',
      ],
    ],
  ],
  [
    'title_html' => 'Gelişimi <span class="hero-title-accent">Anlık İzleyin</span>: <span class="hero-title-accent hero-title-accent--panel">Kontrol Tamamen Sizde</span>',
    'lead_intro' => 'Kontrol tamamen sizde: devamsızlık, deneme sonuçları ve ilerlemeyi Veli Bilgilendirme Paneli üzerinden anlık izleyin.',
    'lead_bullets' => [
      'Her ay işlenen konuları kapsayan denemeler ve dönemlik Türkiye Geneli Deneme Sınavları ile başarı sürekli ölçülür.',
      'Öğrencinizin ilerleme durumu, sıralaması ve eksik kazanımları tek ekranda takip edilir.',
      'Devamsızlık ve deneme performansı şeffaf biçimde raporlanır.',
    ],
    'cta' => [
      [
        'class' => 'btn btn-primary',
        'href' => '#panel',
        'label' => 'Veli Paneli Özellikleri',
        'aria' => 'Veli bilgilendirme paneli ve özellikler bölümüne git',
      ],
    ],
  ],
];
?><div class="hero-pricing-bg"><section class="sec sec-hero" id="hero" data-screen-label="01 Hero">
  <?php include __DIR__ . '/hero-stars.php'; ?>

  <div class="sec-inner">
    <div class="hero-slider" id="heroSlider" aria-roledescription="carousel" aria-label="Hero tanıtım slaytları" data-autoplay-ms="5500">
      <div class="hero-grid hero-slider-grid">
        <div class="hero-slider-copy-col">
          <div class="hero-slider-stage">
            <button type="button" class="hero-slider-arrow hero-slider-prev" aria-controls="heroSliderViewport" aria-label="Önceki slayt">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
            </button>
            <div class="hero-slider-viewport" id="heroSliderViewport" tabindex="0">
              <div class="hero-slider-track" id="heroSliderTrack">
                <?php foreach ($heroSlides as $idx => $slide): ?>
                <?php
                  $heroSlideClasses = ['hero-slide'];
                  if (!empty($slide['lead_bullets']) && is_array($slide['lead_bullets'])) {
                    $heroSlideClasses[] = 'hero-slide--bullets';
                  }
                  if (!empty($slide['bullet_style'])) {
                    $heroSlideClasses[] = 'hero-slide--bullet-' . preg_replace('/[^a-z0-9_-]/i', '', (string) $slide['bullet_style']);
                  }
                  if (!empty($slide['slide_theme'])) {
                    $heroSlideClasses[] = 'hero-slide--' . preg_replace('/[^a-z0-9_-]/i', '', (string) $slide['slide_theme']);
                  }
                ?>
                <article class="<?php echo htmlspecialchars(implode(' ', $heroSlideClasses), ENT_QUOTES, 'UTF-8'); ?>" aria-roledescription="slide" <?php echo $idx === 0 ? 'aria-current="true"' : ''; ?>>
                  <h1 class="title"><?php echo $slide['title_html']; ?></h1>
                  <?php if (!empty($slide['lead_bullets']) && is_array($slide['lead_bullets'])): ?>
                    <?php if (!empty($slide['lead_intro'])): ?>
                      <p class="lead hero-lead-intro"><?php echo htmlspecialchars($slide['lead_intro'], ENT_QUOTES, 'UTF-8'); ?></p>
                    <?php endif; ?>
                    <ul class="hero-lead-list" role="list">
                      <?php foreach ($slide['lead_bullets'] as $bullet): ?>
                        <li>
                          <?php if (is_array($bullet) && isset($bullet['label'], $bullet['text'])): ?>
                            <span class="hero-bullet-label"><?php echo htmlspecialchars($bullet['label'], ENT_QUOTES, 'UTF-8'); ?></span>
                            <span class="hero-bullet-text"><?php echo htmlspecialchars($bullet['text'], ENT_QUOTES, 'UTF-8'); ?></span>
                          <?php else: ?>
                            <?php echo htmlspecialchars($bullet, ENT_QUOTES, 'UTF-8'); ?>
                          <?php endif; ?>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  <?php elseif (!empty($slide['info_cards']) && is_array($slide['info_cards'])): ?>
                    <p class="lead hero-slide-warm-lead"><?php echo htmlspecialchars($slide['lead'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                    <div class="hero-info-cards" role="list">
                      <?php foreach ($slide['info_cards'] as $card): ?>
                        <div class="hero-info-card" role="listitem">
                          <h3 class="hero-info-card-title"><?php echo htmlspecialchars($card['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?></h3>
                          <p class="hero-info-card-text"><?php echo htmlspecialchars($card['text'] ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  <?php else: ?>
                    <p class="lead"><?php echo htmlspecialchars($slide['lead'], ENT_QUOTES, 'UTF-8'); ?></p>
                  <?php endif; ?>
                  <div class="hero-cta">
                    <?php if (!empty($slide['cta']) && is_array($slide['cta'])): ?>
                      <?php foreach ($slide['cta'] as $cta): ?>
                        <a
                          class="<?php echo htmlspecialchars($cta['class'], ENT_QUOTES, 'UTF-8'); ?>"
                          href="<?php echo htmlspecialchars($cta['href'], ENT_QUOTES, 'UTF-8'); ?>"
                          <?php echo !empty($cta['aria']) ? ' aria-label="' . htmlspecialchars($cta['aria'], ENT_QUOTES, 'UTF-8') . '"' : ''; ?>
                        ><?php echo htmlspecialchars($cta['label'], ENT_QUOTES, 'UTF-8'); ?></a>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <button type="button" class="btn btn-primary">Deneme Dersine Katıl →</button>
                      <button type="button" class="btn btn-ghost">Öğretim Videolarımız</button>
                    <?php endif; ?>
                  </div>
                  <div class="hero-trust">
                    <div class="trust-badge">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 2L4 5v6c0 5 3.5 9.5 8 11 4.5-1.5 8-6 8-11V5l-8-3z"/>
                        <path d="M9 12l2 2 4-4"/>
                      </svg>
                      <span>Güvenli platform</span>
                    </div>
                    <div class="trust-badge">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M8 12l3 3 5-6"/>
                      </svg>
                      <span>MEB onaylı</span>
                    </div>
                    <div class="trust-badge">
                      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="9" r="6"/>
                        <path d="M9 14l-2 7 5-3 5 3-2-7"/>
                      </svg>
                      <span>Sertifikalı eğitim</span>
                    </div>
                  </div>
                </article>
                <?php endforeach; ?>
              </div>
            </div>
            <button type="button" class="hero-slider-arrow hero-slider-next" aria-controls="heroSliderViewport" aria-label="Sonraki slayt">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
            </button>
          </div>
          <div class="hero-slider-footer">
            <div class="hero-slider-progress" aria-hidden="true">
              <span class="hero-slider-progress-bar" id="heroSliderProgressBar"></span>
            </div>
            <p class="hero-slider-index" aria-live="polite" aria-atomic="true">
              <span id="heroSliderCurrent">1</span><span class="hero-slider-index-sep" aria-hidden="true">/</span><span id="heroSliderTotal"><?php echo count($heroSlides); ?></span>
            </p>
            <div class="hero-slider-dots" role="tablist" aria-label="Hero slaytları">
              <?php foreach ($heroSlides as $idx => $_slide): ?>
              <button type="button" class="hero-slider-dot<?php echo $idx === 0 ? ' is-active' : ''; ?>" role="tab" aria-selected="<?php echo $idx === 0 ? 'true' : 'false'; ?>" aria-label="Slayt <?php echo $idx + 1; ?>" data-slide="<?php echo (int) $idx; ?>"></button>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <?php include __DIR__ . '/hero-illus.php'; ?>
      </div>
    </div>
  </div>
</section>
<div class="space-divider space-divider--hero-pricing-bridge">
  <div class="geo-circle"></div>
  <div class="geo-dot d1"></div>
  <div class="geo-dot d2"></div>
  <div class="geo-line"></div>
  <div class="geo-tri"></div>
  <svg class="space-wave" viewBox="0 0 1440 200" preserveAspectRatio="none" aria-hidden="true">
    <path d="M0,120 C320,160 640,90 960,140 C1180,175 1320,115 1440,150 L1440,200 L0,200 Z" fill="rgba(62,58,142,0.22)"/>
    <path d="M0,150 C260,195 540,115 820,165 C1080,210 1300,140 1440,175 L1440,200 L0,200 Z" fill="rgba(230,8,123,0.22)"/>
    <path d="M0,175 C200,215 460,145 720,178 C960,208 1180,148 1440,178 L1440,200 L0,200 Z" fill="#ffffff"/>
  </svg>
</div>

<?php include __DIR__ . '/pricing-section.php'; ?>

<?php include __DIR__ . '/journey-section.php'; ?>

</div>

<div class="space-divider space-divider--journey-classroom-bridge">
  <div class="geo-circle"></div>
  <div class="geo-dot d1"></div>
  <div class="geo-dot d2"></div>
  <div class="geo-line"></div>
  <div class="geo-tri"></div>
  <svg class="space-wave" viewBox="0 0 1440 200" preserveAspectRatio="none" aria-hidden="true">
    <path d="M0,120 C320,160 640,90 960,140 C1180,175 1320,115 1440,150 L1440,200 L0,200 Z" fill="rgba(62,58,142,0.22)"/>
    <path d="M0,150 C260,195 540,115 820,165 C1080,210 1300,140 1440,175 L1440,200 L0,200 Z" fill="rgba(230,8,123,0.22)"/>
    <path d="M0,175 C200,215 460,145 720,178 C960,208 1180,148 1440,178 L1440,200 L0,200 Z" fill="#ffffff"/>
  </svg>
</div>

<?php include __DIR__ . '/classroom-section.php'; ?>

<?php include __DIR__ . '/student-stories-section.php'; ?>


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

<!-- ============== 05 · ÖĞRENCİ & VELİ PANELLERİ ============== -->
<section class="sec sec-panel light" id="panel" data-screen-label="04 Paneller">
  <div class="sec-inner">
    <h2 class="title" style="text-align:center; margin-left:auto; margin-right:auto;">Öğrenci ve Veli Panelleri</h2>
    <p class="lead" style="text-align:center; margin: 0 auto 8px;">
      Öğrenci kendi yolculuğunu yönetir, veli yanından destekler. Her iki taraf için
      özel tasarlanmış, senkron çalışan iki panel.
    </p>

    <div class="panel-tabs" role="tablist">
      <button class="panel-tab active" data-panel="student">Öğrenci Paneli</button>
      <button class="panel-tab" data-panel="parent">Veli Paneli</button>
    </div>

    <!-- Student Panel -->
    <div class="panel-grid panel-content student-panel" data-panel="student">
      <div>
        <h3 class="panel-content-title">Kendi sınıfı, kendi ritmi.</h3>
        <p class="panel-content-lead">
          Bugünün dersleri, ödevler, rozetler — hepsi tek ekranda. Öğrenci kendi
          ilerlemesini görür, tekrar etmek istediği dersi tek tıkla bulur.
        </p>

        <div class="panel-features">
          <div class="panel-feature">
            <div class="panel-icon">★</div>
            <div>
              <h4>Bugünün dersleri</h4>
              <p>Saatlik ders programı ve canlı sınıfa tek tıkla katılım.</p>
            </div>
          </div>
          <div class="panel-feature">
            <div class="panel-icon">★</div>
            <div>
              <h4>Ödevler ve alıştırmalar</h4>
              <p>Otomatik puanlama, anlık geri bildirim ve tekrar imkânı.</p>
            </div>
          </div>
          <div class="panel-feature">
            <div class="panel-icon">★</div>
            <div>
              <h4>Rozetler ve seviye</h4>
              <p>Seri ders ödülleri ve sınıf liderlik tablosu.</p>
            </div>
          </div>
          <div class="panel-feature">
            <div class="panel-icon">★</div>
            <div>
              <h4>Ders kayıtları</h4>
              <p>Kaçırılan dersi tekrar izle, önemli yerleri işaretle.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="panel-mock student-mock" aria-hidden="true">
        <div class="panel-mock-nav">
          <div class="item active"></div>
          <div class="item"></div>
          <div class="item"></div>
          <div class="item"></div>
          <div class="item"></div>
        </div>
        <div class="panel-mock-main">
          <div class="panel-mock-pills">
            <div class="panel-mock-pill"></div>
            <div class="panel-mock-pill"></div>
            <div class="panel-mock-pill"></div>
          </div>
          <div class="panel-mock-card chart">
            <div class="bar"></div><div class="bar"></div><div class="bar"></div>
            <div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div>
          </div>
          <div class="panel-mock-card" style="height: 56px;"></div>
        </div>
      </div>
    </div>

    <!-- Parent Panel -->
    <div class="panel-grid panel-content parent-panel" data-panel="parent" hidden>
      <div>
        <h3 class="panel-content-title">Çocuğunuzun yolculuğunu canlı izleyin.</h3>
        <p class="panel-content-lead">
          Devamlılık, gelişim ve öğretmen mesajları — tek komuta merkezinde.
          Telefonunuzdan her an erişebilirsiniz.
        </p>

        <div class="panel-features">
          <div class="panel-feature">
            <div class="panel-icon">★</div>
            <div>
              <h4>Canlı katılım takibi</h4>
              <p>Çocuğunuz hangi derste, kaç dakikadır başlığı tek bakışta görün.</p>
            </div>
          </div>
          <div class="panel-feature">
            <div class="panel-icon">★</div>
            <div>
              <h4>Haftalık gelişim grafiği</h4>
              <p>Konu kavrama, soru çözme ve katılım puanları geçmişle birlikte.</p>
            </div>
          </div>
          <div class="panel-feature">
            <div class="panel-icon">★</div>
            <div>
              <h4>Öğretmenle iletişim</h4>
              <p>Randevu beklemeden mesajlaşın, dönüş 24 saatte gelir.</p>
            </div>
          </div>
          <div class="panel-feature">
            <div class="panel-icon">★</div>
            <div>
              <h4>Ödev, ödül, telafi</h4>
              <p>Ödevleri görün, rozetleri kutlayın, dersi telafiye atayın.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="panel-mock parent-mock" aria-hidden="true">
        <div class="panel-mock-nav">
          <div class="item active"></div>
          <div class="item"></div>
          <div class="item"></div>
          <div class="item"></div>
          <div class="item"></div>
        </div>
        <div class="panel-mock-main">
          <div class="panel-mock-pills">
            <div class="panel-mock-pill"></div>
            <div class="panel-mock-pill"></div>
            <div class="panel-mock-pill"></div>
          </div>
          <div class="panel-mock-card chart">
            <div class="bar"></div><div class="bar"></div><div class="bar"></div>
            <div class="bar"></div><div class="bar"></div><div class="bar"></div><div class="bar"></div>
          </div>
          <div class="panel-mock-card" style="height: 56px;"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include __DIR__ . '/panel-app-cta.php'; ?>

<?php include __DIR__ . '/faq-sss-section.php'; ?>

<?php include __DIR__ . '/space-divider-light.php'; ?>

<!-- ============== Partnerlerimiz (koyu şerit — SSS / dalga sonrası) ============== -->
<section class="sec sec-partners" aria-labelledby="partners-title">
  <div class="partners-inner">
    <h2 id="partners-title" class="partners-heading">Partnerlerimiz</h2>
    <ul class="partners-row">
      <li class="partner-logo partner-logo--notion">
        <img class="partner-logo-img" src="../components/images/partners/notion.svg" width="26" height="26" alt="" decoding="async" loading="lazy" />
        <span class="partner-logo-text">Notion</span>
      </li>
      <li class="partner-logo partner-logo--slack">
        <img class="partner-logo-img" src="../components/images/partners/slack.svg" width="26" height="26" alt="" decoding="async" loading="lazy" />
        <span class="partner-logo-text">Slack</span>
      </li>
      <li class="partner-logo partner-logo--google">
        <img class="partner-logo-img" src="../components/images/partners/google-workspace.svg" width="26" height="26" alt="" decoding="async" loading="lazy" />
        <span class="partner-logo-text">Google Workspace</span>
      </li>
    </ul>
  </div>
</section>
