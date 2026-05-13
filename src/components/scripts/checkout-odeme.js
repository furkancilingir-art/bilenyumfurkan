/**
 * Ödeme bilgileri — aydınlatma metni diyaloğu + istemci doğrulama (PHP ile aynı kurallar).
 */
(function () {
  function initAydinlatmaDialog() {
    const dialog = document.getElementById('checkoutAydinlatmaDialog');
    if (!dialog || typeof dialog.showModal !== 'function') return;

    let lastFocus = null;

    function openDialog(trigger) {
      lastFocus = trigger || document.activeElement;
      dialog.showModal();
      const closeBtn = dialog.querySelector('[data-close-aydinlatma]');
      if (closeBtn) closeBtn.focus();
    }

    function closeDialog() {
      dialog.close();
      if (lastFocus && typeof lastFocus.focus === 'function') {
        try {
          lastFocus.focus();
        } catch (_) {}
      }
    }

    document.querySelectorAll('[data-open-aydinlatma]').forEach((btn) => {
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        openDialog(btn);
      });
    });

    dialog.querySelectorAll('[data-close-aydinlatma]').forEach((el) => {
      el.addEventListener('click', () => closeDialog());
    });

    dialog.addEventListener('cancel', (e) => {
      e.preventDefault();
      closeDialog();
    });

    dialog.addEventListener('click', (e) => {
      if (e.target === dialog) closeDialog();
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && dialog.open) closeDialog();
    });
  }

  function showCheckoutPageLoading() {
    const el = document.getElementById('checkoutPageLoading');
    if (!el) return;
    el.hidden = false;
    el.setAttribute('aria-busy', 'true');
    document.body.classList.add('checkout-is-loading');
  }

  function bindRecapEditLoading() {
    document.querySelectorAll('a.checkout-recap-edit[href*="duzenle"]').forEach((link) => {
      link.addEventListener('click', (e) => {
        const href = link.getAttribute('href');
        if (!href) return;
        e.preventDefault();
        showCheckoutPageLoading();
        window.location.href = href;
      });
    });
  }

  function initStep2Form() {
    const form2 = document.querySelector('[data-checkout-form-step2]');
    if (!form2) return;

    const emailInput = form2.querySelector('#checkout-eposta');
    const sehirSelect = form2.querySelector('#checkout-sehir');

    function validateEmailClient(raw) {
      const email = String(raw).trim();
      if (email === '') return 'Lütfen e-posta adresinizi girin.';
      if (email.length > 254) return 'E-posta adresi çok uzun.';
      if (/\s/.test(email)) return 'E-posta adresinde boşluk kullanılamaz.';
      const ats = email.match(/@/g);
      if (!ats || ats.length !== 1) return 'E-posta adresinde tek bir @ işareti bulunmalıdır.';
      const i = email.indexOf('@');
      const local = email.slice(0, i);
      const domain = email.slice(i + 1);
      if (local.length < 1 || local.length > 64) return 'E-posta kullanıcı adı 1–64 karakter olmalıdır.';
      if (local.includes('..') || local.startsWith('.') || local.endsWith('.')) {
        return 'E-posta kullanıcı adında nokta kullanımı geçersiz.';
      }
      if (!/^[A-Za-z0-9.!#$%&'*+/=?^_`{|}~-]+$/.test(local)) {
        return 'Yalnızca İngilizce harf, rakam ve izin verilen özel karakterler kullanılabilir.';
      }
      if (!domain.includes('.') || domain.length > 253) return 'E-posta alan adı geçersiz görünüyor.';
      if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return 'Geçerli bir e-posta adresi girin.';
      return null;
    }

    form2.addEventListener('submit', (e) => {
      let ok = true;
      if (emailInput) {
        const wrap = emailInput.closest('.checkout-field');
        const err = wrap && wrap.querySelector('.checkout-field-error');
        const msg = validateEmailClient(emailInput.value);
        if (msg) {
          ok = false;
          if (wrap) wrap.classList.add('is-error');
          if (err) {
            err.textContent = msg;
            err.hidden = false;
          }
        } else {
          if (wrap) wrap.classList.remove('is-error');
          if (err) err.hidden = true;
        }
      }
      if (sehirSelect) {
        const wrap = sehirSelect.closest('.checkout-field');
        const err = wrap && wrap.querySelector('.checkout-field-error');
        const v = (sehirSelect.value || '').trim();
        const msg = v === '' ? 'Lütfen şehrinizi seçin.' : null;
        if (msg) {
          ok = false;
          if (wrap) wrap.classList.add('is-error');
          if (err) {
            err.textContent = msg;
            err.hidden = false;
          }
        } else {
          if (wrap) wrap.classList.remove('is-error');
          if (err) err.hidden = true;
        }
      }
      if (!ok) {
        e.preventDefault();
        return;
      }
      e.preventDefault();
      showCheckoutPageLoading();
      requestAnimationFrame(() => {
        requestAnimationFrame(() => {
          form2.submit();
        });
      });
    });
  }

  function setPaymentChevron(btn, expanded) {
    const plus = btn.querySelector('.checkout-payment-chev-plus');
    const minus = btn.querySelector('.checkout-payment-chev-minus');
    if (plus) plus.hidden = !!expanded;
    if (minus) minus.hidden = !expanded;
  }

  function initCheckoutPaymentAccordion() {
    const toggles = document.querySelectorAll('[data-checkout-payment-toggle]');
    if (!toggles.length) return;

    function closeAllExcept(currentBtn) {
      toggles.forEach((b) => {
        if (b === currentBtn) return;
        b.setAttribute('aria-expanded', 'false');
        const it = b.closest('.checkout-payment-item');
        const p = it && it.querySelector('.checkout-payment-panel');
        if (p) p.hidden = true;
        setPaymentChevron(b, false);
      });
    }

    toggles.forEach((btn) => {
      btn.addEventListener('click', () => {
        const expanded = btn.getAttribute('aria-expanded') === 'true';
        const open = !expanded;
        if (open) closeAllExcept(btn);
        btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        const item = btn.closest('.checkout-payment-item');
        const panel = item && item.querySelector('.checkout-payment-panel');
        if (panel) panel.hidden = !open;
        setPaymentChevron(btn, open);
      });
      setPaymentChevron(btn, btn.getAttribute('aria-expanded') === 'true');
    });
  }

  function fmtDotThousands(n) {
    return String(Math.max(0, Math.floor(n))).replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  }

  function initCheckoutCcPreview() {
    const numEl = document.getElementById('checkout-cc-num');
    const nameEl = document.getElementById('checkout-cc-name');
    const mm = document.getElementById('checkout-cc-mm');
    const yy = document.getElementById('checkout-cc-yy');
    const cvv = document.getElementById('checkout-cc-cvv');
    const previewCard = document.querySelector('[data-cc-preview-card]');
    const prevNum = document.querySelector('[data-cc-preview-num]');
    const prevName = document.querySelector('[data-cc-preview-name]');
    const prevExp = document.querySelector('[data-cc-preview-exp]');
    const prevCvv = document.querySelector('[data-cc-preview-cvv]');
    if (!numEl || !prevNum) return;

    function sync() {
      const raw = numEl.value.replace(/\D/g, '').slice(0, 16);
      const chunks = raw.match(/.{1,4}/g);
      prevNum.textContent = chunks ? chunks.join(' ') : '•••• •••• •••• ••••';
      if (prevName && nameEl) {
        const n = nameEl.value.trim();
        prevName.textContent = n ? n.toUpperCase() : 'AD SOYAD';
      }
      if (prevExp && mm && yy) {
        const m = mm.value || '••';
        const y = yy.value ? yy.value.slice(-2) : '••';
        prevExp.textContent = `${m} / ${y}`;
      }
      if (prevCvv && cvv) {
        const rawCvv = String(cvv.value || '').replace(/\D/g, '').slice(0, 4);
        prevCvv.textContent = rawCvv ? rawCvv.padEnd(3, '•') : '•••';
      }
    }
    numEl.addEventListener('input', sync);
    if (nameEl) nameEl.addEventListener('input', sync);
    if (mm) mm.addEventListener('change', sync);
    if (yy) yy.addEventListener('change', sync);
    if (cvv) {
      cvv.addEventListener('input', sync);
      cvv.addEventListener('focus', () => {
        if (previewCard) previewCard.classList.add('is-flipped');
      });
      cvv.addEventListener('blur', () => {
        if (previewCard) previewCard.classList.remove('is-flipped');
      });
    }
    sync();
  }

  function initCheckoutMultiRemain() {
    const root = document.querySelector('[data-checkout-payment-root]');
    const amtInput = document.getElementById('checkout-m1-amt');
    const out = document.querySelector('[data-checkout-multi-remain]');
    if (!root || !amtInput || !out) return;
    const total = parseInt(root.getAttribute('data-checkout-total-lira') || '0', 10) || 0;

    function sync() {
      let n = parseInt(String(amtInput.value).replace(/\D/g, ''), 10);
      if (isNaN(n)) n = 0;
      n = Math.max(0, Math.min(total, n));
      amtInput.value = String(n);
      const rem = Math.max(0, total - n);
      out.textContent = `2. kart için kalan tutar: ${fmtDotThousands(rem)} TL`;
    }
    amtInput.addEventListener('input', sync);
    sync();
  }

  function initCheckoutCvvFlipGeneric() {
    const cvvInputs = document.querySelectorAll('#checkout-cc-cvv, #checkout-m1-cvv');
    if (!cvvInputs.length) return;
    cvvInputs.forEach((input) => {
      const layout = input.closest('.checkout-cc-layout') || document;
      const previewCard = layout.querySelector('[data-cc-preview-card]');
      if (!previewCard) return;
      input.addEventListener('focus', () => previewCard.classList.add('is-flipped'));
      input.addEventListener('blur', () => previewCard.classList.remove('is-flipped'));
    });
  }

  function initCheckoutCopyButtons() {
    document.querySelectorAll('.checkout-copy-btn[data-copy]').forEach((btn) => {
      btn.addEventListener('click', async (e) => {
        e.preventDefault();
        const t = btn.getAttribute('data-copy');
        if (!t || !navigator.clipboard) return;
        try {
          await navigator.clipboard.writeText(t);
        } catch (_) {}
      });
    });
  }

  function initCheckoutLegalDialogs() {
    const d1 = document.getElementById('checkoutOnBilgilendirmeDialog');
    const d2 = document.getElementById('checkoutTicariDialog');
    if (!d1 && !d2) return;

    let lastFocus = null;

    function closeBoth() {
      if (d1 && d1.open) d1.close();
      if (d2 && d2.open) d2.close();
      if (lastFocus && typeof lastFocus.focus === 'function') {
        try {
          lastFocus.focus();
        } catch (_) {}
      }
    }

    function wire(dialog, closeSel, openSelectors) {
      if (!dialog || typeof dialog.showModal !== 'function') return;
      openSelectors.forEach((sel) => {
        document.querySelectorAll(sel).forEach((el) => {
          el.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            lastFocus = el;
            closeBoth();
            dialog.showModal();
            const c = dialog.querySelector(closeSel);
            if (c) c.focus();
          });
        });
      });
      dialog.querySelectorAll(closeSel).forEach((b) => {
        b.addEventListener('click', () => closeBoth());
      });
      dialog.addEventListener('cancel', (e) => {
        e.preventDefault();
        closeBoth();
      });
      dialog.addEventListener('click', (e) => {
        if (e.target === dialog) closeBoth();
      });
    }

    wire(d1, '[data-close-onbilgilendirme]', ['[data-open-onbilgilendirme]']);
    wire(d2, '[data-close-ticari]', ['[data-open-ticari]']);

    document.addEventListener('keydown', (e) => {
      if (e.key !== 'Escape') return;
      if (d1 && d1.open) closeBoth();
      if (d2 && d2.open) closeBoth();
    });
  }

  function initStep3Form() {
    const form3 = document.querySelector('[data-checkout-form-step3]');
    if (!form3) return;

    const mesafeli = form3.querySelector('input[name="mesafeli_onay"]');
    const legal = form3.querySelector('.checkout-step3-legal');

    form3.addEventListener('submit', (e) => {
      if (!mesafeli || !mesafeli.checked) {
        e.preventDefault();
        if (legal) legal.classList.add('is-error');
        return;
      }
      if (legal) legal.classList.remove('is-error');
      e.preventDefault();
      showCheckoutPageLoading();
      requestAnimationFrame(() => {
        requestAnimationFrame(() => {
          form3.submit();
        });
      });
    });
  }

  initAydinlatmaDialog();
  initStep2Form();
  initCheckoutPaymentAccordion();
  initCheckoutCcPreview();
  initCheckoutMultiRemain();
  initCheckoutCvvFlipGeneric();
  initCheckoutCopyButtons();
  initCheckoutLegalDialogs();
  initStep3Form();
  bindRecapEditLoading();

  const form = document.querySelector('[data-checkout-form]');
  if (!form) return;

  const nameInput = form.querySelector('#checkout-ad-soyad');
  const phoneInput = form.querySelector('#checkout-telefon');

  function namePartValid(p) {
    if (p.length < 2 || p.length > 40) return false;
    if (p.length === 2) return /^[\p{L}]{2}$/u.test(p);
    return /^[\p{L}][\p{L}'-]*[\p{L}]$/u.test(p);
  }

  function validateName(name) {
    const t = name.trim().replace(/\s+/g, ' ');
    if (!t) return 'Ad ve soyad zorunludur.';
    if (/\d/.test(t)) return 'Ad ve soyad alanında rakam kullanılamaz; yalnızca harf, tire ve apostrof kullanın.';
    if (t.length > 120) return 'Ad ve soyad toplamda en fazla 120 karakter olabilir.';
    const parts = t.split(/\s+/).filter(Boolean);
    if (parts.length < 2) {
      return 'Ad ve soyad en az iki kelime olmalıdır; kelimeler arasında boşluk kullanın (ör. Ayşe Yılmaz veya Mehmet Ali Yılmaz).';
    }
    if (parts.length > 8) return 'En fazla 8 kelime girebilirsiniz.';
    for (let i = 0; i < parts.length; i++) {
      if (!namePartValid(parts[i])) {
        return 'Her kelime 2–40 karakter olmalı, harf ile başlayıp harf ile bitmeli; ara karakter olarak yalnızca tire (-) veya apostrof (\') kullanılabilir.';
      }
    }
    return null;
  }

  function normalizePhone(raw) {
    let d = String(raw).replace(/\D/g, '');
    if (d === '') return null;
    if (d.length === 12 && d.startsWith('90')) {
      d = d.slice(2);
    } else if (d.length === 11 && d[0] === '0') {
      if (d[1] !== '5') return null;
      d = d.slice(1);
    } else if (d.length === 10) {
      // ulusal
    } else {
      return null;
    }
    if (d.length !== 10 || d[0] !== '5') return null;
    if (!/^5\d{9}$/.test(d)) return null;
    return d;
  }

  function validatePhone(raw) {
    if (normalizePhone(raw) !== null) return null;
    return 'Cep telefonu 10 hanedir, 5 ile başlar. Örnek: 5XX XXX XX XX (yapıştırmada 0 veya +90 kabul edilir).';
  }

  /** Görünüm: 5XX XXX XX XX (başta 0 yok) */
  function formatPhoneDisplay(ten) {
    if (!ten || ten.length !== 10 || ten[0] !== '5') return '';
    return (
      ten.slice(0, 3) + ' ' + ten.slice(3, 6) + ' ' + ten.slice(6, 8) + ' ' + ten.slice(8, 10)
    );
  }

  function nationalDigitsFromRaw(raw) {
    let d = String(raw).replace(/\D/g, '');
    if (d.startsWith('90')) {
      d = d.slice(2, 12);
    } else if (d.startsWith('0')) {
      d = d.slice(1, 11);
    } else {
      d = d.slice(0, 10);
    }
    return d;
  }

  function formatPartialTurkish(body) {
    const b = body.slice(0, 10);
    if (b.length === 0) return '';
    if (b.length <= 3) return b;
    if (b.length <= 6) return b.slice(0, 3) + ' ' + b.slice(3);
    if (b.length <= 8) return b.slice(0, 3) + ' ' + b.slice(3, 6) + ' ' + b.slice(6);
    return b.slice(0, 3) + ' ' + b.slice(3, 6) + ' ' + b.slice(6, 8) + ' ' + b.slice(8, 10);
  }

  if (phoneInput) {
    phoneInput.addEventListener('input', () => {
      const body = nationalDigitsFromRaw(phoneInput.value);
      const n = body.length === 10 && body[0] === '5' ? normalizePhone('0' + body) : null;
      if (n) {
        phoneInput.value = formatPhoneDisplay(n);
      } else {
        phoneInput.value = formatPartialTurkish(body);
      }
    });
    phoneInput.addEventListener('blur', () => {
      const n = normalizePhone(phoneInput.value);
      if (n) phoneInput.value = formatPhoneDisplay(n);
    });
  }

  if (nameInput) {
    nameInput.addEventListener('input', () => {
      const old = nameInput.value;
      const cur = nameInput.selectionStart ?? old.length;
      const v = old.replace(/\d/g, '');
      if (v !== old) {
        const removedBefore = [...old.slice(0, cur)].filter((ch) => /\d/.test(ch)).length;
        nameInput.value = v;
        const newPos = Math.max(0, cur - removedBefore);
        try {
          nameInput.setSelectionRange(newPos, newPos);
        } catch (_) {}
      }
    });
    nameInput.addEventListener('blur', () => {
      nameInput.value = nameInput.value.trim().replace(/\s+/g, ' ');
    });
  }

  form.addEventListener('submit', (e) => {
    let ok = true;
    if (nameInput) {
      const wrap = nameInput.closest('.checkout-field');
      const err = wrap && wrap.querySelector('.checkout-field-error');
      const msg = validateName(nameInput.value);
      if (msg) {
        ok = false;
        if (wrap) wrap.classList.add('is-error');
        if (err) {
          err.textContent = msg;
          err.hidden = false;
        }
      } else {
        if (wrap) wrap.classList.remove('is-error');
        if (err) err.hidden = true;
      }
    }
    if (phoneInput) {
      const wrap = phoneInput.closest('.checkout-field');
      const err = wrap && wrap.querySelector('.checkout-field-error');
      const msg = validatePhone(phoneInput.value);
      if (msg) {
        ok = false;
        if (wrap) wrap.classList.add('is-error');
        if (err) {
          err.textContent = msg;
          err.hidden = false;
        }
      } else {
        if (wrap) wrap.classList.remove('is-error');
        if (err) err.hidden = true;
      }
    }
    const kvkk = form.querySelector('#checkout-kvkk');
    const kvkkWrap = form.querySelector('.checkout-kvkk');
    const kvkkErr = form.querySelector('[data-checkout-kvkk-error]');
    if (kvkk && !kvkk.checked) {
      ok = false;
      if (kvkkWrap) kvkkWrap.classList.add('is-error');
      if (kvkkErr) {
        const d = kvkkErr.getAttribute('data-msg-default');
        if (d) kvkkErr.textContent = d;
        kvkkErr.hidden = false;
      }
    } else {
      if (kvkkWrap) kvkkWrap.classList.remove('is-error');
      if (kvkkErr) kvkkErr.hidden = true;
    }
    if (!ok) {
      e.preventDefault();
      return;
    }
    e.preventDefault();
    showCheckoutPageLoading();
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        form.submit();
      });
    });
  });
})();
