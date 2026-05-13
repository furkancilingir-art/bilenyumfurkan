<?php
/**
 * Aydınlatma metni gövdesi — tam sayfa ve ödeme modalında ortak.
 * @var bool $aydinlatma_show_back_link Tam sayfada “Geri” gösterilsin mi
 */
$aydinlatma_show_back_link = $aydinlatma_show_back_link ?? false;
?>
<div class="aydinlatma-metni-prose">
  <?php if (!empty($aydinlatma_show_back_link)) : ?>
    <a class="aydinlatma-back" href="javascript:history.back()">← Geri</a>
  <?php endif; ?>
  <h1>Kişisel verilerin işlenmesine ilişkin aydınlatma metni</h1>
  <p class="aydinlatma-meta">6698 sayılı Kişisel Verilerin Korunması Kanunu (“KVKK”) uyarınca, veri sorumlusu sıfatıyla Bilenyum tarafından hazırlanmıştır. Metin örnektir; yayından önce hukuk ve uyum ekiplerinizce güncellenmelidir.</p>

  <h2>1. Veri sorumlusu</h2>
  <p>Bilenyum (“Şirket”), KVKK md. 10 kapsamında veri sorumlusudur. İletişim kanalları web sitemizde ve sözleşmelerinizde yer alan adres bilgileri üzerinden sağlanır.</p>

  <h2>2. İşlenen kişisel veriler</h2>
  <p>Satın alma ve kayıt süreçlerinde kimlik ve iletişim verileriniz (ad-soyad, telefon, e-posta vb.) işlenebilir. Süreç kapsamında talep edilen diğer alanlar ürün ve hizmete göre değişebilir.</p>

  <h2>3. İşleme amaçları</h2>
  <ul>
    <li>Sözleşmenin kurulması ve ifası, eğitim hizmetinin sunulması</li>
    <li>Fatura ve muhasebe süreçleri, yasal yükümlülüklerin yerine getirilmesi</li>
    <li>Müşteri desteği, bilgilendirme ve güvenliğin sağlanması</li>
  </ul>

  <h2>4. Aktarım</h2>
  <p>Kanuni zorunluluklar ve hizmetin gerektirdiği ölçüde iş ortaklarına ve yetkili kamu kurumlarına KVKK’ya uygun şekilde aktarım yapılabilir.</p>

  <h2>5. Toplama yöntemi ve hukuki sebep</h2>
  <p>Veriler; web formları, çağrı merkezi ve elektronik ortamda otomatik veya kısmen otomatik yollarla toplanabilir. Hukuki sebepler arasında sözleşmenin ifası, meşru menfaat ve açık rıza (varsa) bulunur.</p>

  <h2>6. Haklarınız</h2>
  <p>KVKK md. 11 kapsamında; verilerinizin işlenip işlenmediğini öğrenme, düzeltme ve silme talepleri ile şikâyet hakkınız saklıdır. Başvurularınızı Şirket’in bildirdiği kanallar üzerinden iletebilirsiniz.</p>

  <p class="aydinlatma-footnote">Bu metin taslaktır. Üretim ortamında güncel ünvan, iletişim, veri işleme envanteri ve saklama süreleri eklenmelidir.</p>
</div>
