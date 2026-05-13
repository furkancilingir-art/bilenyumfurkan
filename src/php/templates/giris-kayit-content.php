<?php
$giris_emblem = '../components/images/yumi-mascot.png';
?>
<div class="giris-cosmos-band">
  <section class="sec sec-giris-kayit" aria-labelledby="auth-section-title">
    <div class="sec-inner sec-inner--giris-kayit">
      <h2 id="auth-section-title" class="visually-hidden">Bilenyum hesabına erişim</h2>
      <div class="giris-kayit-grid">
        <aside class="auth-intro-card" aria-label="Bilgilendirme">
          <h3 class="auth-intro-title">Egitimde <span class="auth-intro-title-accent">Bilenyum</span> Cagina Hos Geldiniz</h3>
          <p class="auth-intro-lead">
            Geleceginize yon verecek essiz dijital egitim evrenine katilin.
            Ogrenciye ozel akademik ve psikolojik yol haritaniz burada basliyor.
          </p>
          <div class="auth-intro-emblem-wrap" aria-hidden="true">
            <img
              src="<?php echo htmlspecialchars($giris_emblem, ENT_QUOTES, 'UTF-8'); ?>"
              alt=""
              width="96"
              height="96"
              class="auth-intro-emblem"
              decoding="async"
            />
          </div>
        </aside>

        <section class="auth-panel" aria-label="Giriş ve kayıt formları">
          <input class="auth-tab-input" type="radio" name="auth-tab" id="auth-tab-login" checked />
          <input class="auth-tab-input" type="radio" name="auth-tab" id="auth-tab-register" />
          <input class="auth-tab-input" type="radio" name="auth-tab" id="auth-tab-trial" />

          <div class="auth-tab-controls" role="tablist" aria-label="Hesap işlemleri">
            <label class="auth-tab-control" for="auth-tab-login" role="tab" aria-controls="auth-login-panel">Giriş Yap</label>
            <label class="auth-tab-control" for="auth-tab-register" role="tab" aria-controls="auth-register-panel">Kayıt Ol</label>
            <label class="auth-tab-control" for="auth-tab-trial" role="tab" aria-controls="auth-trial-panel">Ücretsiz deneme dersi</label>
          </div>

          <div class="auth-panels">
            <form id="auth-login-panel" class="auth-form auth-form--login" action="#" method="post" novalidate>
              <div class="auth-field">
                <label class="auth-label" for="auth-login-email">E-posta adresiniz</label>
                <input class="auth-input" id="auth-login-email" name="email" type="email" autocomplete="email" placeholder="ornek@mail.com" maxlength="254" pattern="^[A-Za-z0-9.!#$%&'*+/=?^_`{|}~-]+@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)+$" title="Geçerli bir e-posta girin. Örnek: ornek@mail.com" data-auth-email required />
              </div>
              <div class="auth-field">
                <label class="auth-label" for="auth-login-password">Şifreniz</label>
                <input class="auth-input" id="auth-login-password" name="password" type="password" autocomplete="current-password" placeholder="********" minlength="8" maxlength="64" required />
              </div>
              <div class="auth-row">
                <label class="auth-check">
                  <input type="checkbox" name="remember" />
                  <span>Beni hatırla</span>
                </label>
                <a href="#" class="auth-link">Şifremi unuttum</a>
              </div>
              <button type="submit" class="auth-submit">Giriş Yap</button>
              <div class="auth-divider"><span>veya hızlı giriş</span></div>
              <div class="auth-socials">
                <a class="auth-social auth-social--google" href="#" aria-label="Google ile giriş yap">
                  <svg class="auth-social-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="#EA4335" d="M12 10.2v3.9h5.4c-.24 1.25-.96 2.3-2.04 3.01l3.3 2.56c1.92-1.77 3.03-4.38 3.03-7.49 0-.71-.06-1.39-.18-2.04H12z"/>
                    <path fill="#34A853" d="M12 22c2.73 0 5.01-.9 6.68-2.44l-3.3-2.56c-.91.61-2.07.98-3.38.98-2.6 0-4.8-1.75-5.59-4.11H3.02v2.64A10.08 10.08 0 0 0 12 22z"/>
                    <path fill="#4A90E2" d="M6.41 13.87a6.05 6.05 0 0 1 0-3.74V7.49H3.02a10.04 10.04 0 0 0 0 9.02l3.39-2.64z"/>
                    <path fill="#FBBC05" d="M12 6.02c1.49 0 2.83.51 3.89 1.51l2.91-2.91C17 2.99 14.72 2 12 2A10.08 10.08 0 0 0 3.02 7.49l3.39 2.64c.79-2.36 2.99-4.11 5.59-4.11z"/>
                  </svg>
                  <span>Google ile Giriş Yap</span>
                </a>
                <a class="auth-social auth-social--facebook" href="#" aria-label="Facebook ile giriş yap">
                  <svg class="auth-social-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="currentColor" d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.05V9.41c0-3.02 1.79-4.69 4.53-4.69 1.31 0 2.68.24 2.68.24v2.97h-1.51c-1.49 0-1.95.93-1.95 1.88v2.26h3.32l-.53 3.49h-2.79V24C19.61 23.1 24 18.1 24 12.07z"/>
                  </svg>
                  <span>Facebook ile Giriş Yap</span>
                </a>
              </div>
            </form>

            <form id="auth-trial-panel" class="auth-form auth-form--trial" action="#" method="post" novalidate>
              <div class="auth-grid auth-grid--2">
                <div class="auth-field">
                  <label class="auth-label" for="auth-trial-parent-name">Veli Ad Soyadı</label>
                  <input class="auth-input" id="auth-trial-parent-name" name="trial_parent_name" type="text" autocomplete="name" placeholder="Ad Soyad" minlength="2" maxlength="120" data-auth-name required />
                </div>
                <div class="auth-field">
                  <label class="auth-label" for="auth-trial-student-name">Öğrenci Ad Soyadı</label>
                  <input class="auth-input" id="auth-trial-student-name" name="trial_student_name" type="text" autocomplete="name" placeholder="Ad Soyad" minlength="2" maxlength="120" data-auth-name required />
                </div>
              </div>
              <div class="auth-grid auth-grid--2">
                <div class="auth-field">
                  <label class="auth-label" for="auth-trial-email">E-posta</label>
                  <input class="auth-input" id="auth-trial-email" name="trial_email" type="email" autocomplete="email" placeholder="ornek@mail.com" maxlength="254" pattern="^[A-Za-z0-9.!#$%&'*+/=?^_`{|}~-]+@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)+$" title="Geçerli bir e-posta girin. Örnek: ornek@mail.com" data-auth-email required />
                </div>
                <div class="auth-field">
                  <label class="auth-label" for="auth-trial-phone">Telefon</label>
                  <input class="auth-input" id="auth-trial-phone" name="trial_phone" type="tel" autocomplete="tel" inputmode="numeric" placeholder="05XX XXX XX XX" pattern="^05[0-9]{9}$" maxlength="11" data-auth-phone required />
                </div>
              </div>
              <div class="auth-field">
                <label class="auth-label" for="auth-trial-grade">Sınıf Seviyesi</label>
                <select class="auth-input" id="auth-trial-grade" name="trial_grade" required>
                  <option value="">Seçiniz</option>
                  <option value="5">5. Sınıf</option>
                  <option value="6">6. Sınıf</option>
                  <option value="7">7. Sınıf</option>
                  <option value="8">8. Sınıf</option>
                </select>
              </div>
              <div class="auth-field">
                <label class="auth-label" for="auth-trial-subject">Deneme Dersi İstenen Alan</label>
                <select class="auth-input" id="auth-trial-subject" name="trial_subject" required>
                  <option value="">Seçiniz</option>
                  <option value="matematik">Matematik</option>
                  <option value="fen">Fen Bilimleri</option>
                  <option value="turkce">Türkçe</option>
                  <option value="sosyal">Sosyal Bilgiler</option>
                  <option value="ingilizce">İngilizce</option>
                </select>
              </div>
              <button type="submit" class="auth-submit">Deneme Dersi Talebi Oluştur</button>
            </form>

            <form id="auth-register-panel" class="auth-form auth-form--register" action="#" method="post" novalidate>
              <div class="auth-grid auth-grid--2">
                <div class="auth-field">
                  <label class="auth-label" for="auth-register-name">Ad</label>
                  <input class="auth-input" id="auth-register-name" name="name" type="text" autocomplete="given-name" minlength="2" maxlength="60" data-auth-name required />
                </div>
                <div class="auth-field">
                  <label class="auth-label" for="auth-register-surname">Soyad</label>
                  <input class="auth-input" id="auth-register-surname" name="surname" type="text" autocomplete="family-name" minlength="2" maxlength="60" data-auth-name required />
                </div>
              </div>
              <div class="auth-grid auth-grid--2">
                <div class="auth-field">
                  <label class="auth-label" for="auth-register-email">E-posta adresiniz</label>
                  <input class="auth-input" id="auth-register-email" name="email" type="email" autocomplete="email" placeholder="ornek@mail.com" maxlength="254" pattern="^[A-Za-z0-9.!#$%&'*+/=?^_`{|}~-]+@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)+$" title="Geçerli bir e-posta girin. Örnek: ornek@mail.com" data-auth-email required />
                </div>
                <div class="auth-field">
                  <label class="auth-label" for="auth-register-phone">Cep telefonu</label>
                  <input class="auth-input" id="auth-register-phone" name="phone" type="tel" autocomplete="tel" inputmode="numeric" placeholder="05XX XXX XX XX" pattern="^05[0-9]{9}$" maxlength="11" data-auth-phone required />
                </div>
              </div>
              <div class="auth-grid auth-grid--2">
                <div class="auth-field">
                  <label class="auth-label" for="auth-register-password">Şifre</label>
                  <input class="auth-input" id="auth-register-password" name="password" type="password" autocomplete="new-password" placeholder="********" minlength="8" maxlength="64" required />
                </div>
                <div class="auth-field">
                  <label class="auth-label" for="auth-register-password-repeat">Şifre (tekrar)</label>
                  <input class="auth-input" id="auth-register-password-repeat" name="password_repeat" type="password" autocomplete="new-password" placeholder="********" minlength="8" maxlength="64" required />
                </div>
              </div>
              <label class="auth-check">
                <input type="checkbox" name="agreement" required />
                <span><button type="button" class="auth-link auth-link-btn" data-open-auth-legal aria-haspopup="dialog">Üyelik sözleşmesini</button> okudum ve kabul ediyorum.</span>
              </label>
              <button type="submit" class="auth-submit">Kayıt Ol</button>
              <div class="auth-divider"><span>veya hızlı kayıt</span></div>
              <div class="auth-socials">
                <a class="auth-social auth-social--google" href="#" aria-label="Google ile kayıt ol">
                  <svg class="auth-social-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="#EA4335" d="M12 10.2v3.9h5.4c-.24 1.25-.96 2.3-2.04 3.01l3.3 2.56c1.92-1.77 3.03-4.38 3.03-7.49 0-.71-.06-1.39-.18-2.04H12z"/>
                    <path fill="#34A853" d="M12 22c2.73 0 5.01-.9 6.68-2.44l-3.3-2.56c-.91.61-2.07.98-3.38.98-2.6 0-4.8-1.75-5.59-4.11H3.02v2.64A10.08 10.08 0 0 0 12 22z"/>
                    <path fill="#4A90E2" d="M6.41 13.87a6.05 6.05 0 0 1 0-3.74V7.49H3.02a10.04 10.04 0 0 0 0 9.02l3.39-2.64z"/>
                    <path fill="#FBBC05" d="M12 6.02c1.49 0 2.83.51 3.89 1.51l2.91-2.91C17 2.99 14.72 2 12 2A10.08 10.08 0 0 0 3.02 7.49l3.39 2.64c.79-2.36 2.99-4.11 5.59-4.11z"/>
                  </svg>
                  <span>Google ile Kayıt Ol</span>
                </a>
                <a class="auth-social auth-social--facebook" href="#" aria-label="Facebook ile kayıt ol">
                  <svg class="auth-social-icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path fill="currentColor" d="M24 12.07C24 5.4 18.63 0 12 0S0 5.4 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.05V9.41c0-3.02 1.79-4.69 4.53-4.69 1.31 0 2.68.24 2.68.24v2.97h-1.51c-1.49 0-1.95.93-1.95 1.88v2.26h3.32l-.53 3.49h-2.79V24C19.61 23.1 24 18.1 24 12.07z"/>
                  </svg>
                  <span>Facebook ile Kayıt Ol</span>
                </a>
              </div>
            </form>
          </div>
        </section>
      </div>
    </div>
  </section>
</div>

<dialog id="authLegalDialog" class="auth-legal-dialog" aria-labelledby="authLegalTitle">
  <div class="auth-legal-dialog-surface">
    <header class="auth-legal-dialog-header">
      <h2 id="authLegalTitle" class="auth-legal-dialog-title">Üyelik Sözleşmesi</h2>
      <button type="button" class="auth-legal-dialog-close" data-close-auth-legal aria-label="Kapat">×</button>
    </header>
    <div class="auth-legal-dialog-body">
      <p>
        Bilenyum hesabı oluşturarak platform kullanım kurallarını, dijital içerik erişim koşullarını ve KVKK kapsamındaki
        bilgilendirme hükümlerini kabul etmiş olursunuz.
      </p>
      <p>
        Hesap güvenliği kullanıcı sorumluluğundadır; şifrenin üçüncü kişilerle paylaşılmaması gerekir. Platformda sunulan
        içerikler kişisel kullanım içindir, ticari amaçla çoğaltılamaz.
      </p>
    </div>
  </div>
</dialog>
