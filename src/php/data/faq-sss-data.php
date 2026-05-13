<?php
/**
 * Ana sayfa SSS — kategoriler ve soru/cevaplar (içerik düzenlenebilir).
 */
return [
  'categories' => [
    ['id' => 'satin-alim', 'label' => 'Satın Alım ile ilgili sorular'],
    ['id' => 'platform', 'label' => 'Bilenyum Eğitim Platformu ile ilgili sorular'],
    ['id' => 'veli-panel', 'label' => 'Veli paneli ile ilgili sorular'],
    ['id' => 'ogrenci-panel', 'label' => 'Öğrenci paneli ile ilgili sorular'],
    ['id' => 'icerik', 'label' => 'Eğitim içerikleri ile ilgili sorular'],
    ['id' => 'setler', 'label' => 'Eğitim setleri ile ilgili sorular'],
  ],
  'items' => [
    // Satın alım
    ['cat' => 'satin-alim', 'q' => 'Paket ücretlerini nasıl ödeyebilirim?', 'a' => 'Kredi kartı, banka kartı ve havale/EFT seçenekleriyle güvenli ödeme altyapısı üzerinden ödeme yapabilirsiniz. Taksit seçenekleri pakete göre değişebilir.'],
    ['cat' => 'satin-alim', 'q' => 'Satın alma sonrası ne zaman erişim başlar?', 'a' => 'Ödemeniz onaylandığında hesabınız kısa süre içinde aktifleştirilir; giriş bilgileri kayıtlı e-posta adresinize iletilir.'],
    ['cat' => 'satin-alim', 'q' => 'Fatura ve makbuz alabilir miyim?', 'a' => 'Kurumsal ve bireysel faturalandırma için panelden talep oluşturabilir veya destek hattımızdan yardım alabilirsiniz.'],
    ['cat' => 'satin-alim', 'q' => 'Paket değişikliği veya yükseltme mümkün mü?', 'a' => 'Evet. İlgili dönem ve kullanım koşullarına göre yükseltme veya geçiş talepleriniz değerlendirilir; detaylar için bizimle iletişime geçin.'],
    ['cat' => 'satin-alim', 'q' => 'İade ve iptal koşulları nelerdir?', 'a' => 'Mesafeli satış ve iç hizmet politikamız kapsamında iptal/iade süreçleri sözleşmede belirtilir. Özel durumlar için çağrı merkezimizi arayabilirsiniz.'],
    ['cat' => 'satin-alim', 'q' => 'Kampanya veya indirim kodu nasıl kullanılır?', 'a' => 'Ödeme adımında tanımlı indirim kodunuzu girerek geçerli kampanyalardan yararlanabilirsiniz.'],
    ['cat' => 'satin-alim', 'q' => 'Birden fazla öğrenci için toplu kayıt yapılabilir mi?', 'a' => 'Kurumsal ve çoklu kayıt talepleri için iletişim ekibimiz size özel teklif ve süreç sunabilir.'],
    ['cat' => 'satin-alim', 'q' => 'Ödeme planı veya taksit limiti nasıl öğrenilir?', 'a' => 'Sepet ve ödeme ekranında güncel taksit tablosunu görebilir veya destek hattından banka anlaşmalarımız hakkında bilgi alabilirsiniz.'],

    // Platform
    ['cat' => 'platform', 'q' => 'Bilenyum platformuna hangi cihazlardan girebilirim?', 'a' => 'Güncel tarayıcısı olan bilgisayar, tablet ve akıllı telefonlardan erişebilirsiniz. Mobil uygulamamızı da indirerek kullanabilirsiniz.'],
    ['cat' => 'platform', 'q' => 'Canlı derslere nasıl katılırım?', 'a' => 'Öğrenci panelinizdeki ders takviminden ilgili derse tıklayarak canlı oturuma bağlanırsınız. Bağlantılar ders saatinde aktifleşir.'],
    ['cat' => 'platform', 'q' => 'Teknik sorun yaşarsam ne yapmalıyım?', 'a' => 'Önce internet bağlantınızı ve tarayıcı güncellemesini kontrol edin. Sorun devam ederse destek hattı veya yardım merkezi üzerinden bize ulaşın.'],
    ['cat' => 'platform', 'q' => 'Ders kayıtlarına her zaman erişebilir miyim?', 'a' => 'Paket kapsamınız dahilinde kayıtlı ders arşivine panel üzerinden erişebilirsiniz; süre paket türüne göre değişebilir.'],
    ['cat' => 'platform', 'q' => 'Şifremi unuttum, nasıl sıfırlarım?', 'a' => 'Giriş ekranındaki “Şifremi unuttum” bağlantısından kayıtlı e-postanıza sıfırlama adımları gönderilir.'],
    ['cat' => 'platform', 'q' => 'Hesap güvenliği için önerileriniz nelerdir?', 'a' => 'Güçlü ve benzersiz şifre kullanın, oturumu paylaşmayın ve mümkünse ortak cihazlarda çıkış yapmayı unutmayın.'],
    ['cat' => 'platform', 'q' => 'Bildirimleri açıp kapatabilir miyim?', 'a' => 'Panel ayarlarından ders, ödev ve duyuru bildirim tercihlerinizi yönetebilirsiniz.'],
    ['cat' => 'platform', 'q' => 'Platform dilleri ve erişilebilirlik özellikleri nelerdir?', 'a' => 'Arayüz Türkçe olarak sunulur; metin ölçekleme ve kontrast için tarayıcı/istemci ayarlarınızı kullanabilirsiniz.'],

    // Veli paneli
    ['cat' => 'veli-panel', 'q' => 'Veli panelinde neleri görebilirim?', 'a' => 'Devamsızlık, deneme sonuçları, ders katılımı ve öğretmen mesajları gibi bilgileri takip edebilirsiniz.'],
    ['cat' => 'veli-panel', 'q' => 'Çocuğumun gelişim grafikleri güncellenir mi?', 'a' => 'Evet; ölçüm ve sınav verileri işlendikçe grafik ve raporlar güncellenir.'],
    ['cat' => 'veli-panel', 'q' => 'Öğretmenle nasıl iletişim kurarım?', 'a' => 'Veli paneli üzerinden mesajlaşma veya randevu kanalları kullanılabilir; süreler iç politikaya göre belirlenir.'],
    ['cat' => 'veli-panel', 'q' => 'Birden fazla öğrenciyi tek hesapta takip edebilir miyim?', 'a' => 'Birden fazla kayıt için hesap bağlantıları tanımlanabilir; detaylar destek ekibinden alınır.'],
    ['cat' => 'veli-panel', 'q' => 'Raporları PDF veya e-posta ile alabilir miyim?', 'a' => 'İlgili rapor sayfalarında dışa aktarma seçenekleri sunulabilir; sürüme göre değişiklik gösterebilir.'],
    ['cat' => 'veli-panel', 'q' => 'Veli paneli ücreti ayrı mı?', 'a' => 'Veli bilgilendirme paneli genellikle paket kapsamında sunulur; özel durumlar için satış ekibi bilgi verir.'],
    ['cat' => 'veli-panel', 'q' => 'Bildirimleri e-posta yerine SMS ile alabilir miyim?', 'a' => 'İletişim tercihleri hesap ayarlarından yönetilir; SMS desteği kampanya ve paket koşullarına bağlıdır.'],
    ['cat' => 'veli-panel', 'q' => 'Verilerim kimlerle paylaşılır?', 'a' => 'Kişisel verileriniz KVKK ve aydınlatma metnimiz kapsamında işlenir; üçüncü taraflarla paylaşım politikada belirtilir.'],

    // Öğrenci paneli
    ['cat' => 'ogrenci-panel', 'q' => 'Öğrenci panelinde hangi içeriklere ulaşırım?', 'a' => 'Günlük dersler, ödevler, tekrar materyalleri ve rozetler gibi öğrenme araçlarına erişirsiniz.'],
    ['cat' => 'ogrenci-panel', 'q' => 'Ödev teslim tarihlerini nasıl takip ederim?', 'a' => 'Panel takviminde ve ödev listesinde teslim tarihleri ve durumlar görüntülenir.'],
    ['cat' => 'ogrenci-panel', 'q' => 'Rozet veya başarı puanları nasıl çalışır?', 'a' => 'Katılım ve performansa bağlı gamification öğeleri dashboard üzerinden takip edilir.'],
    ['cat' => 'ogrenci-panel', 'q' => 'Canlı derse geç kaldım, katılabilir miyim?', 'a' => 'Oturum açıksa derse bağlanabilirsiniz; kaçırdığınız kısımlar için kayıt arşivini kullanın.'],
    ['cat' => 'ogrenci-panel', 'q' => 'Profil bilgilerimi güncelleyebilir miyim?', 'a' => 'İzin verilen alanlar için ayarlar bölümünden güncelleme yapılabilir; bazı alanlar yönetici onayı gerektirebilir.'],
    ['cat' => 'ogrenci-panel', 'q' => 'Arkadaşlarımla sıralamayı paylaşabilir miyim?', 'a' => 'Gizlilik ayarlarına bağlı olarak liderlik tabloları anonim veya sınıf içi olarak gösterilebilir.'],
    ['cat' => 'ogrenci-panel', 'q' => 'Mobil uygulama ile web panel aynı mı?', 'a' => 'Temel işlevler uyumludur; bazı gelişmiş raporlar web üzerinde daha geniş olabilir.'],
    ['cat' => 'ogrenci-panel', 'q' => 'Teknik bir hata bildirmek için ne yapmalıyım?', 'a' => 'Yardım veya destek bölümünden ekran görüntüsü ile bildirim açabilirsiniz.'],

    // İçerikler
    ['cat' => 'icerik', 'q' => 'Ders materyalleri MEB müfredatına uygun mu?', 'a' => 'İçeriklerimiz güncel müfredat ve sınav yapısına uyumlu olacak şekilde hazırlanır ve güncellenir.'],
    ['cat' => 'icerik', 'q' => 'Ek kaynak veya deneme setleri var mı?', 'a' => 'Paketinize bağlı olarak ek deneme, alıştırma ve tekrar setleri sunulabilir.'],
    ['cat' => 'icerik', 'q' => 'Konu anlatımları tekrar izlenebilir mi?', 'a' => 'Kayıtlı canlı dersler ve ön kayıtlı içerikler paket kapsamında arşivden izlenebilir.'],
    ['cat' => 'icerik', 'q' => 'Zorlandığım konular için ek destek alabilir miyim?', 'a' => 'Telafi dersleri, tekrar oturumları veya PDR/akademik destek kanalları paket ve dönem koşullarına göre sunulur.'],
    ['cat' => 'icerik', 'q' => 'İçerik güncellemeleri nasıl duyurulur?', 'a' => 'Panel duyuruları, e-posta ve uygulama bildirimleri ile paylaşılır.'],
    ['cat' => 'icerik', 'q' => 'Farklı sınıf seviyeleri için içerik ayrımı var mı?', 'a' => 'Evet; 5–8. sınıf ve branş bazlı içerik yolları ayrı ayrı yapılandırılmıştır.'],
    ['cat' => 'icerik', 'q' => 'Dijital içerikleri indirebilir miyim?', 'a' => 'Telif ve lisans koşullarına göre bazı materyaller yalnızca çevrimiçi görüntülenebilir.'],
    ['cat' => 'icerik', 'q' => 'İçerik önerisi veya geri bildirim verebilir miyim?', 'a' => 'Form ve destek kanalları üzerinden geri bildirim gönderebilirsiniz; içerik ekibi değerlendirir.'],

    // Setler
    ['cat' => 'setler', 'q' => 'Eğitim setleri arasındaki fark nedir?', 'a' => 'Setler; ders saati, içerik derinliği, panel özellikleri ve ek hizmetlere göre ayrılır.'],
    ['cat' => 'setler', 'q' => 'Set değişikliği ne zaman yapılabilir?', 'a' => 'Dönem ve kullanım koşullarına göre yükseltme veya geçiş mümkün olabilir; satış ekibi bilgilendirir.'],
    ['cat' => 'setler', 'q' => 'Hızlandırma veya birebir set nedir?', 'a' => 'Hızlandırma programları yoğun tempo sunar; birebir setlerde öğretmen öğrenci eşleşmesi farklıdır.'],
    ['cat' => 'setler', 'q' => 'Belirli bir branş için set seçebilir miyim?', 'a' => 'Sayısal, sözel veya tam paket seçenekleri ürün sayfasında listelenir.'],
    ['cat' => 'setler', 'q' => 'Set süresi ve dondurma hakkı var mı?', 'a' => 'Paket sözleşmesinde süre ve dondurma koşulları açıkça belirtilir.'],
    ['cat' => 'setler', 'q' => 'Deneme sınavları sete dahil mi?', 'a' => 'Çoğu sette Türkiye geneli deneme ve ölçüm oturumları yer alır; detaylar paket açıklamasında yer alır.'],
    ['cat' => 'setler', 'q' => 'Kardeş veya referans indirimi uygulanır mı?', 'a' => 'Dönemsel kampanyalar için güncel koşulları satış ekibinden veya web sitemizden öğrenebilirsiniz.'],
    ['cat' => 'setler', 'q' => 'Set içeriğini ücretsiz deneyebilir miyim?', 'a' => 'Deneme dersi veya tanıtım oturumu kampanyalara göre sunulabilir; iletişim formundan talep oluşturabilirsiniz.'],
  ],
];
