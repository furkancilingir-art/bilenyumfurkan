<?php
$nav_page_intro_title = isset($nav_page_intro_title) ? trim((string) $nav_page_intro_title) : '';
$nav_page_intro_lead = isset($nav_page_intro_lead) ? trim((string) $nav_page_intro_lead) : '';
?>
<section class="sec nav-page-hero" aria-labelledby="neden-hero-title">
  <?php include __DIR__ . '/hero-stars.php'; ?>
  <div class="sec-inner sec-inner--nav-hero">
    <p class="nav-page-hero-eyebrow">Kurumsal</p>
    <h1 id="neden-hero-title" class="title title--neden-page">Neden Bilenyum?</h1>
    <div class="neden-manifesto-brand" aria-hidden="true">
      <img
        src="../components/images/bilenyum-emblem.png"
        alt=""
        width="52"
        height="52"
        class="neden-manifesto-brand-img"
        decoding="async"
        loading="lazy"
      />
    </div>
    <p class="nav-page-hero-kicker">Vizyonumuz ve Misyonumuz</p>
    <p class="lead lead--nav-hero">
      Bilenyum'un neden var oldugunu ve gelecekte nerede olmak istedigini anlatan kurumsal manifestomuz;
      veliye guven, ogrenciye ilham verir. Platformumuz yalnizca bir sirket degil, yeni nesil egitim modeli ve
      dijital egitim evreni ideolojisinin ta kendisidir.
    </p>
  </div>
</section>
