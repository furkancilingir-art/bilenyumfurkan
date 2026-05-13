/**
 * Paket detay \u2014 URL: ?paket=hizlandirma|tum-dersler|sayisal|sozel|birebir &sinif=8|7|6|5
 */
(function () {
  const CATALOG = window.BILENYUM_PRICING_CATALOG;
  if (!CATALOG) return;

  const VALID_THEMES = new Set(['hizlandirma', 'tum-dersler', 'sayisal', 'sozel', 'birebir']);
  const GRADE_LABEL = {
    '8': '8. S\u0131n\u0131f (LGS)',
    '7': '7. S\u0131n\u0131f',
    '6': '6. S\u0131n\u0131f',
    '5': '5. S\u0131n\u0131f',
  };
  const THEME_LEAD = {
    hizlandirma:
      'S\u0131nava yak\u0131n d\u00f6nemde yo\u011fun tekrar, bran\u015f bazl\u0131 peki\u015ftirme ve veli \u00f6zetleriyle hedefe odaklan\u0131n.',
    'tum-dersler':
      'M\u00fcfredat kapsam\u0131ndaki derslerde canl\u0131 yay\u0131n, kay\u0131t ar\u015fivi ve \u015feffaf veli paneli tek pakette.',
    sayisal:
      'Matematik ve fen bilimleri a\u011f\u0131rl\u0131kl\u0131 i\u00e7erik, deneme analizi ve net odakl\u0131 \u00e7al\u0131\u015fma \u00f6nerileri.',
    sozel:
      'T\u00fcrk\u00e7e, ink\u0131lap, din ve dil derslerinde paragraf, okuma ve yaz\u0131l\u0131 haz\u0131rl\u0131k i\u00e7erikleri.',
    birebir:
      'Size \u00f6zel ders saatleri, birebir \u00f6\u011fretmen e\u015fle\u015fmesi ve ki\u015fiselle\u015ftirilmi\u015f \u00f6dev / geli\u015fim takibi.',
  };

  function escapeHtml(text) {
    return String(text)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/"/g, '&quot;');
  }

  function pricingImgUrl(file) {
    let base =
      typeof window !== 'undefined' && window.__pricingImgBase
        ? String(window.__pricingImgBase).replace(/\/?$/, '/')
        : '../components/images/';
    const raw = String(file || '').trim();
    if (!raw) return base + 'pricing-tum-dersler.svg';
    if (/^https?:\/\//i.test(raw)) return raw;
    const stripped = raw
      .replace(/^\.\.\/components\/images\//, '')
      .replace(/^\/?components\/images\//, '')
      .replace(/^assets\/img\//, '')
      .replace(/^\/+/, '');
    return base + stripped;
  }

  const params = new URLSearchParams(window.location.search);
  let theme = params.get('paket') || 'tum-dersler';
  let grade = params.get('sinif') || '8';
  if (!VALID_THEMES.has(theme)) theme = 'tum-dersler';
  if (!CATALOG[grade]) grade = '8';

  let card = (CATALOG[grade] || []).find((c) => c.theme === theme);
  if (!card) {
    theme = 'tum-dersler';
    card = (CATALOG[grade] || []).find((c) => c.theme === theme);
  }
  if (!card) return;

  document.body.classList.remove(
    'paket-detail-theme--hizlandirma',
    'paket-detail-theme--tum-dersler',
    'paket-detail-theme--sayisal',
    'paket-detail-theme--sozel',
    'paket-detail-theme--birebir'
  );
  document.body.classList.add('paket-detail-theme', 'paket-detail-theme--' + theme);

  const gradeEyebrow = GRADE_LABEL[grade] || '8. S\u0131n\u0131f (LGS)';
  const leadLine = THEME_LEAD[theme] || THEME_LEAD['tum-dersler'];
  const heroLead = leadLine + ' ' + card.users + ' \u00f6\u011frenci bu paketi kullan\u0131yor.';

  document.title = card.name + ' \u2014 Bilenyum';

  const setText = (sel, text) => {
    const el = document.querySelector(sel);
    if (el) el.textContent = text;
  };

  setText('[data-pkg="breadcrumb"]', card.name);
  setText('[data-pkg="eyebrow"]', gradeEyebrow);
  setText('[data-pkg="title"]', card.name);
  setText('[data-pkg="lead"]', heroLead);
  setText('[data-pkg="price"]', '\u20ba ' + card.price);
  setText('[data-pkg="sticky-price-num"]', '\u20ba ' + card.price);
  setText('[data-pkg="rating-blurb"]', '\u2605 ' + card.users + ' \u00f6\u011frenci \u00b7 aktif paket');
  setText(
    '[data-pkg="features-lead"]',
    card.name + ' ile ihtiyac\u0131n\u0131z olan i\u00e7erikler tek pakette toplan\u0131r.'
  );
  setText(
    '[data-pkg="reviews-lead"]',
    'Bu paketi tercih eden ' + card.users + ' ailenin ger\u00e7ek deneyimi.'
  );
  setText('[data-pkg="purchase-title"]', card.name);
  setText(
    '[data-pkg="purchase-sub"]',
    gradeEyebrow.replace(/\s*\(LGS\)\s*$/, '') + ' \u00b7 12 ay s\u00fcreli \u00b7 Bilenyum online'
  );
  setText('[data-pkg="purchase-users"]', card.users);
  setText('[data-pkg="sticky-title"]', card.name);
  setText('[data-pkg="sticky-meta"]', gradeEyebrow + ' \u00b7 12 ay s\u00fcreli');
  setText('[data-pkg="sticky-total"]', 'Toplam \u20ba ' + card.total + ' \u00b7 9 taksit imk\u00e2n\u0131');

  const totalStrong = document.querySelector('[data-pkg="total-strong"]');
  if (totalStrong) totalStrong.textContent = '\u20ba ' + card.total;

  const purchasePrice = document.querySelector('[data-pkg="purchase-price"]');
  if (purchasePrice) purchasePrice.textContent = '\u20ba ' + card.price;

  const purchaseTotalLine = document.querySelector('[data-pkg="purchase-total-line"]');
  if (purchaseTotalLine) {
    purchaseTotalLine.innerHTML = '12 ay toplam: <strong>\u20ba ' + escapeHtml(card.total) + '</strong>';
  }

  const highlights = document.querySelector('[data-pkg="highlights"]');
  if (highlights && card.features) {
    highlights.innerHTML = card.features
      .map((f) => '<li><span>' + escapeHtml(f) + '</span></li>')
      .join('');
  }

  const grid = document.getElementById('pkgFeaturesGrid');
  if (grid && card.features) {
    grid.innerHTML = card.features
      .map(
        (f) =>
          '<div class="feature-card">' +
          '<div class="feature-icon">\u2713</div>' +
          '<p>' +
          escapeHtml(f) +
          '</p>' +
          '</div>'
      )
      .join('');
  }

  const heroImg = document.querySelector('[data-pkg="hero-img"]');
  if (heroImg && card.img) {
    heroImg.src = encodeURI(pricingImgUrl(card.img));
    heroImg.alt = card.alt || card.name;
  }

  const summaryCount = document.querySelector('[data-pkg="reviews-summary-count"]');
  if (summaryCount) summaryCount.textContent = card.users + ' de\u011ferlendirme';

  const q1 = document.querySelector('[data-pkg="review-quote-1"]');
  if (q1) {
    q1.textContent =
      '"' +
      card.name +
      ' ile hedefimize net \u015fekilde ilerledik; \u00f6\u011fretmenler \u00e7ok ilgili."';
  }

  const metaDesc = document.querySelector('meta[name="description"]');
  if (metaDesc) {
    metaDesc.setAttribute(
      'content',
      card.name + ': ' + ((card.features && card.features[0]) || 'Bilenyum online e\u011fitim paketi') + '.'
    );
  }

  const checkoutHref =
    'odeme-bilgileri.php?' +
    new URLSearchParams({ paket: theme, sinif: grade }).toString();
  document.querySelectorAll('[data-pkg-checkout]').forEach((el) => {
    el.setAttribute('href', checkoutHref);
  });
})();
