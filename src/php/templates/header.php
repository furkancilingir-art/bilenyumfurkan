<?php
$nav_active = $nav_active ?? '';
?>
<header class="site-nav">
  <div class="nav-inner">
    <a href="landing-reference.php" class="logo" aria-label="Bilenyum ana sayfa">
      <picture>
        <source media="(max-width: 640px)" srcset="../components/images/bilenyum-emblem.png" />
        <img src="../../assets/logo.png" alt="Bilenyum" class="logo-img" decoding="async" />
      </picture>
    </a>
    <nav class="nav-links" aria-label="Ana menü">
      <a href="egitim-setleri.php" class="nav-link<?php echo $nav_active === 'egitim' ? ' is-active' : ''; ?>">Eğitim Setleri</a>
      <a href="ornek-videolar.php" class="nav-link<?php echo $nav_active === 'videolar' ? ' is-active' : ''; ?>">Örnek Videolar</a>
      <a href="kadromuz.php" class="nav-link<?php echo ($nav_active ?? '') === 'kadro' ? ' is-active' : ''; ?>">Eğitmen Kadromuz</a>
      <a href="neden-biz.php" class="nav-link<?php echo $nav_active === 'neden-biz' ? ' is-active' : ''; ?>">Neden Biz?</a>
      <a href="sikca-sorulan-sorular.php" class="nav-link<?php echo $nav_active === 'sss' ? ' is-active' : ''; ?>">SSS</a>
      <a href="bize-ulasin.php" class="nav-link<?php echo $nav_active === 'iletisim' ? ' is-active' : ''; ?>">İletişim</a>
    </nav>
    <div class="nav-cta">
      <a href="giris-kayit.php" class="btn btn-ghost btn-sm">Giriş yap veya kayıt ol</a>
      <a href="bize-ulasin.php" class="btn btn-primary btn-sm">Ücretsiz deneme dersi</a>
    </div>
  </div>
</header>
