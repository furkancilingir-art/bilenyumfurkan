<?php
/**
 * Bize Ulaşın — iletişim kanalları, form, harita, kurumsal şeffaflık.
 * $iletisimImgBase: pages’tan göreceli görsel kökü (örn. ../components/images/).
 */
$iletisim_emblem = ($iletisimImgBase ?? '../components/images/') . 'bilenyum-emblem.png';
?>
<div class="iletisim-cosmos-band">
  <div class="iletisim-cosmos-bg" aria-hidden="true">
    <div class="iletisim-cosmos-stars"></div>
    <div class="iletisim-cosmos-glow"></div>
  </div>

  <section class="sec sec-iletisim-channels" id="iletisim-kanallari" aria-labelledby="iletisim-kanallari-title">
    <div class="sec-inner sec-inner--iletisim">
      <h2 id="iletisim-kanallari-title" class="iletisim-section-title visually-hidden">İletişim kanalları</h2>
      <div class="iletisim-channel-grid">
        <article class="iletisim-channel-card">
          <div class="iletisim-channel-icon-wrap" aria-hidden="true">
            <svg class="iletisim-channel-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" fill="currentColor"/>
            </svg>
          </div>
          <h3 class="iletisim-channel-label">Çağrı Merkezi</h3>
          <p class="iletisim-channel-number">
            <a href="tel:+902125555555">0212 555 55 55</a>
          </p>
          <a class="iletisim-channel-btn iletisim-channel-btn--brand" href="tel:+902125555555">Hemen Ara</a>
        </article>

        <article class="iletisim-channel-card">
          <div class="iletisim-channel-icon-wrap" aria-hidden="true">
            <svg class="iletisim-channel-icon iletisim-channel-icon--wa" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill="currentColor" d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
            </svg>
          </div>
          <h3 class="iletisim-channel-label">WhatsApp Hattı</h3>
          <p class="iletisim-channel-number">
            <a href="https://wa.me/905555555555">0555 555 55 55</a>
          </p>
          <a class="iletisim-channel-btn iletisim-channel-btn--whatsapp" href="https://wa.me/905555555555" target="_blank" rel="noopener noreferrer">Mesaj Gönder</a>
        </article>

        <article class="iletisim-channel-card">
          <div class="iletisim-channel-icon-wrap" aria-hidden="true">
            <svg class="iletisim-channel-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M17 1H7c-1.1 0-2 .9-2 2v18c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V3c0-1.1-.9-2-2-2zm0 18H7V5h10v14zm-5-2h2v2h-2v-2z" fill="currentColor"/>
            </svg>
          </div>
          <h3 class="iletisim-channel-label">Mobil İletişim</h3>
          <p class="iletisim-channel-number">
            <a href="tel:+905325555555">0532 555 55 55</a>
          </p>
          <a class="iletisim-channel-btn iletisim-channel-btn--brand" href="tel:+905325555555">Hemen Ara</a>
        </article>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/space-divider-light.php'; ?>

  <section class="sec sec-iletisim-feedback" id="oneri-sikayet" aria-labelledby="iletisim-feedback-title">
    <div class="sec-inner sec-inner--iletisim">
      <div class="iletisim-feedback-panel">
        <header class="iletisim-feedback-header">
          <h2 id="iletisim-feedback-title" class="iletisim-feedback-title">Öneri, İstek ve Şikayet Bildirimi</h2>
          <p class="iletisim-feedback-sub">
            Görüşleriniz bizim için çok değerli. Eğitim kalitemizi artırmak için lütfen bize yazın.
          </p>
        </header>
        <form class="iletisim-form" id="iletisim-feedback-form" action="#" method="post" novalidate>
          <div class="iletisim-form-grid">
            <div class="iletisim-field">
              <label class="iletisim-label" for="iletisim-ad">Ad Soyad</label>
              <input
                class="iletisim-input"
                type="text"
                id="iletisim-ad"
                name="ad_soyad"
                autocomplete="name"
                placeholder="Adınız Soyadınız"
                minlength="2"
                maxlength="120"
                title="En az 2, en fazla 120 karakter."
              />
              <p class="iletisim-field-hint" id="iletisim-ad-hint">En fazla 120 karakter.</p>
            </div>
            <div class="iletisim-field">
              <label class="iletisim-label" for="iletisim-tel">Cep Telefonu</label>
              <input
                class="iletisim-input"
                type="tel"
                id="iletisim-tel"
                name="cep"
                autocomplete="tel"
                inputmode="numeric"
                placeholder="05XXXXXXXXX"
                maxlength="11"
                title="Türkiye cep: 05 ile başlayan 11 rakam (ör. 05555555555)."
              />
              <p class="iletisim-field-hint" id="iletisim-tel-hint">11 haneli 05 ile başlayan numara; yalnızca rakam.</p>
            </div>
            <div class="iletisim-field">
              <label class="iletisim-label" for="iletisim-mail">E-posta Adresi</label>
              <input
                class="iletisim-input"
                type="email"
                id="iletisim-mail"
                name="email"
                autocomplete="email"
                placeholder="ornek@mail.com"
                maxlength="254"
                title="Geçerli bir e-posta adresi girin."
              />
              <p class="iletisim-field-hint">En fazla 254 karakter.</p>
            </div>
            <div class="iletisim-field">
              <label class="iletisim-label" for="iletisim-konu">İlgili Konu</label>
              <div class="iletisim-select-wrap">
                <select class="iletisim-input iletisim-select" id="iletisim-konu" name="konu">
                  <option value="">Seçiniz</option>
                  <option value="genel">Genel bilgi</option>
                  <option value="teknik">Teknik destek</option>
                  <option value="fatura">Faturalandırma</option>
                  <option value="oneri">Öneri</option>
                  <option value="sikayet">Şikayet</option>
                  <option value="diger">Diğer</option>
                </select>
              </div>
            </div>
          </div>
          <div class="iletisim-field iletisim-field--full">
            <label class="iletisim-label" for="iletisim-mesaj">Mesajınız</label>
            <textarea
              class="iletisim-input iletisim-textarea"
              id="iletisim-mesaj"
              name="mesaj"
              rows="5"
              minlength="15"
              maxlength="4000"
              placeholder="Lütfen mesajınızı, önerinizi veya şikayetinizi detaylıca buraya yazın..."
              title="En az 15, en fazla 4000 karakter."
            ></textarea>
            <p class="iletisim-field-hint" id="iletisim-mesaj-hint" aria-live="polite">15–4000 karakter.</p>
          </div>
          <button type="submit" class="iletisim-submit">Gönder</button>
        </form>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/space-divider-light.php'; ?>

  <section class="sec sec-iletisim-map" id="harita" aria-labelledby="iletisim-map-title">
    <div class="sec-inner sec-inner--iletisim sec-inner--iletisim-map">
      <h2 id="iletisim-map-title" class="iletisim-section-heading">Merkez ofisimiz</h2>
      <p class="iletisim-map-lead">
        Esentepe Mah. Büyükdere Cad. No:199 Şişli / İstanbul
      </p>
      <div class="iletisim-map-frame">
        <iframe
          title="Bilenyum konumu — Şişli, İstanbul"
          src="https://www.google.com/maps?q=Esentepe+Mah.+B%C3%BCy%C3%BCkdere+Cad.+No%3A199+%C5%9Eisli+%C4%B0stanbul&amp;output=embed"
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"
          allowfullscreen=""
        ></iframe>
      </div>
    </div>
  </section>

  <?php include __DIR__ . '/space-divider-light.php'; ?>

  <section class="sec sec-iletisim-transparency" id="kurumsal-seffaflik" aria-labelledby="iletisim-transparency-title">
    <div class="sec-inner sec-inner--iletisim">
      <div class="iletisim-transparency-card">
        <header class="iletisim-transparency-head">
          <div class="iletisim-transparency-logo">
            <img
              src="<?php echo htmlspecialchars($iletisim_emblem, ENT_QUOTES, 'UTF-8'); ?>"
              alt=""
              width="128"
              height="128"
              class="iletisim-emblem-img"
              decoding="async"
            />
          </div>
          <div class="iletisim-transparency-head-text">
            <h2 id="iletisim-transparency-title" class="iletisim-transparency-title">Kurumsal Şeffaflık</h2>
          </div>
        </header>
        <div class="iletisim-transparency-grid">
          <div class="iletisim-transparency-col">
            <div class="iletisim-transparency-row">
              <span class="iletisim-transparency-k">Tescilli Marka Adı</span>
              <span class="iletisim-transparency-v">BİLENYUM</span>
            </div>
            <div class="iletisim-transparency-row">
              <span class="iletisim-transparency-k">Ticaret Sicil No</span>
              <span class="iletisim-transparency-v">123456-5 <span class="iletisim-transparency-note">(İstanbul Ticaret Odası)</span></span>
            </div>
            <div class="iletisim-transparency-row">
              <span class="iletisim-transparency-k">Kayıtlı E-posta (KEP)</span>
              <span class="iletisim-transparency-v"><a href="mailto:bilenyum@hs01.kep.tr">bilenyum@hs01.kep.tr</a></span>
            </div>
          </div>
          <div class="iletisim-transparency-col">
            <div class="iletisim-transparency-row">
              <span class="iletisim-transparency-k">Ticaret Ünvanı / İşletme Adı</span>
              <span class="iletisim-transparency-v">Bilenyum Eğitim Teknolojileri A.Ş.</span>
            </div>
            <div class="iletisim-transparency-row">
              <span class="iletisim-transparency-k">Vergi Dairesi / No</span>
              <span class="iletisim-transparency-v">Maslak V.D. / 123 456 7890</span>
            </div>
            <div class="iletisim-transparency-row">
              <span class="iletisim-transparency-k">Merkez Adres</span>
              <span class="iletisim-transparency-v">Esentepe Mah. Büyükdere Cad. No:199 Şişli / İstanbul</span>
            </div>
          </div>
          <div class="iletisim-transparency-col">
            <div class="iletisim-transparency-row">
              <span class="iletisim-transparency-k">MERSİS Numarası</span>
              <span class="iletisim-transparency-v">0123456789000001</span>
            </div>
            <div class="iletisim-transparency-row">
              <span class="iletisim-transparency-k">Kurumsal E-posta</span>
              <span class="iletisim-transparency-v"><a href="mailto:info@bilenyum.com">info@bilenyum.com</a></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
