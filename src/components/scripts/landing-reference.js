  // Neden Biz — kurumsal kimlik: scroll ile fade-up
  (function () {
    const root = document.querySelector('.neden-manifesto');
    if (!root) return;

    let io = null;

    function reveal() {
      root.classList.add('is-in-view');
      if (io) {
        io.disconnect();
        io = null;
      }
    }

    if (!('IntersectionObserver' in window)) {
      reveal();
      return;
    }

    root.classList.add('neden-manifesto--await');

    io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          reveal();
        });
      },
      { rootMargin: '0px 0px -10% 0px', threshold: 0.08 }
    );

    io.observe(root);

    requestAnimationFrame(() => {
      const r = root.getBoundingClientRect();
      const vh = window.innerHeight || document.documentElement.clientHeight;
      if (r.top < vh * 0.92 && r.bottom > 0) {
        reveal();
      }
    });
  })();

  // SSS — kategori sekmeleri, ana sayfada ilk 5 + tam SSS sayfasına bağlantı, tam sayfada tüm sorular (akordeon +/−)
  (function initFaqSss() {
    const root = document.getElementById('faqSss');
    if (!root) return;

    const mode = root.getAttribute('data-faq-sss-mode') || 'compact';
    const isFull = mode === 'full';

    const panels = root.querySelectorAll('.faq-sss-panel');
    const tabs = root.querySelectorAll('.btn--faq-sss-cat');
    const moreLink = document.getElementById('faqSssMore');

    function getActivePanel() {
      return root.querySelector('.faq-sss-panel:not([hidden])');
    }

    function closeItem(item) {
      item.classList.remove('is-open');
      const trig = item.querySelector('.faq-sss-trigger');
      const ans = item.querySelector('.faq-sss-answer');
      if (trig) trig.setAttribute('aria-expanded', 'false');
      if (ans) ans.hidden = true;
    }

    function openItem(item) {
      item.classList.add('is-open');
      const trig = item.querySelector('.faq-sss-trigger');
      const ans = item.querySelector('.faq-sss-answer');
      if (trig) trig.setAttribute('aria-expanded', 'true');
      if (ans) ans.hidden = false;
    }

    function updateTrim() {
      if (isFull) return;
      const panel = getActivePanel();
      if (!panel || !moreLink) return;
      const catId = panel.dataset.category || '';
      const items = panel.querySelectorAll('.faq-sss-item');
      const limit = 5;
      items.forEach((el, i) => {
        el.hidden = i >= limit;
      });
      const total = items.length;
      moreLink.hidden = total <= limit;
      moreLink.setAttribute(
        'href',
        'sikca-sorulan-sorular.php?konu=' + encodeURIComponent(catId)
      );
    }

    function selectCategory(catId) {
      panels.forEach((p) => {
        const match = p.dataset.category === catId;
        if (match) p.removeAttribute('hidden');
        else p.setAttribute('hidden', '');
      });
      tabs.forEach((t) => {
        const on = t.dataset.category === catId;
        t.classList.toggle('is-active', on);
        t.setAttribute('aria-selected', on ? 'true' : 'false');
        t.setAttribute('tabindex', on ? '0' : '-1');
      });
      const active = getActivePanel();
      if (active) {
        active.querySelectorAll('.faq-sss-item.is-open').forEach(closeItem);
      }
      updateTrim();
    }

    tabs.forEach((t) => {
      t.addEventListener('click', () => selectCategory(t.dataset.category || ''));
    });

    root.querySelectorAll('.faq-sss-item').forEach((item) => {
      const trig = item.querySelector('.faq-sss-trigger');
      if (!trig) return;
      trig.addEventListener('click', () => {
        if (item.hidden) return;
        const open = item.classList.contains('is-open');
        if (open) closeItem(item);
        else openItem(item);
      });
    });

    updateTrim();
  })();

  // Video modal: öğrenci hikayeleri + örnek ders (classroom) ortak
  (function() {
    const DEFAULT_VIDEO = 'https://commondatastorage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4';
    const track = document.querySelector('.student-videos-track');
    if (track) {
      track.insertAdjacentHTML('beforeend', track.innerHTML);
    }
    const modal = document.getElementById('videoModal');
    if (!modal) return;
    const modalVideo = modal.querySelector('video');
    const modalAvatar = modal.querySelector('.video-modal-avatar');
    const modalName = modal.querySelector('.video-modal-name');
    const modalGrade = modal.querySelector('.video-modal-grade');
    const modalTitle = modal.querySelector('.video-modal-title');
    const closeBtn = modal.querySelector('.video-modal-close');
    const backdrop = modal.querySelector('.video-modal-backdrop');

    function resolveVideoUrl(url) {
      const s = url != null ? String(url).trim() : '';
      return s || DEFAULT_VIDEO;
    }

    function openVideoModal(opts) {
      const video = resolveVideoUrl(opts.video);
      modalVideo.src = video;
      if (modalAvatar) {
        modalAvatar.src = opts.avatar || '';
        modalAvatar.alt = opts.name ? `${opts.name}` : '';
      }
      if (modalName) modalName.textContent = opts.name || '';
      if (modalGrade) modalGrade.textContent = opts.grade || '';
      if (modalTitle) modalTitle.textContent = opts.title || '';
      modal.hidden = false;
      modal.setAttribute('aria-hidden', 'false');
      document.body.style.overflow = 'hidden';
      modalVideo.play().catch(() => {});
    }

    function closeModal() {
      modalVideo.pause();
      modalVideo.removeAttribute('src');
      modalVideo.load();
      modal.hidden = true;
      modal.setAttribute('aria-hidden', 'true');
      document.body.style.overflow = '';
    }

    document.querySelectorAll('.student-video-card').forEach(card => {
      card.addEventListener('click', () =>
        openVideoModal({
          video: card.dataset.video,
          avatar: card.querySelector('.student-avatar')?.src || '',
          name: card.dataset.name || '',
          grade: card.dataset.grade || '',
          title: card.dataset.title || '',
        })
      );
    });

    const sidePills = document.querySelectorAll('.classroom-stage > .classroom-side:first-child .level-pill');
    const teacherImg = document.querySelector('.teacher-image');
    const subjectEl = document.querySelector('.teacher-subject');
    const nameMetaEl = document.querySelector('.teacher-card-name');
    const branchEl = document.querySelector('.teacher-card-branch');
    const ratingEl = document.querySelector('.teacher-card-rating .rating-num');
    const lessonEmojiEl = document.querySelector('.lesson-emoji');
    const avatarImg = document.querySelector('.teacher-avatar-img');
    const meetingTitleEl = document.querySelector('.zoom-meeting-title');

    sidePills.forEach(pill => {
      pill.addEventListener('click', () => {
        sidePills.forEach(p => p.classList.remove('active'));
        pill.classList.add('active');
        const newSrc = pill.dataset.img;
        const newAvatar = pill.dataset.avatar;
        const tname = pill.dataset.teacher;
        const tsubject = pill.dataset.subject;
        if (teacherImg && newSrc) {
          teacherImg.classList.add('swapping');
          setTimeout(() => {
            teacherImg.src = newSrc;
            teacherImg.classList.remove('swapping');
          }, 200);
        }
        if (avatarImg && newAvatar) {
          avatarImg.classList.add('swapping');
          setTimeout(() => {
            avatarImg.src = newAvatar;
            avatarImg.classList.remove('swapping');
          }, 200);
        }
        const tbranch = pill.dataset.branch;
        const trating = pill.dataset.rating;
        const ticon = pill.dataset.icon;
        if (subjectEl && tsubject) subjectEl.textContent = tsubject;
        if (nameMetaEl && tname) nameMetaEl.textContent = tname;
        if (branchEl && tbranch) branchEl.textContent = tbranch;
        if (ratingEl && trating) ratingEl.textContent = trating;
        if (lessonEmojiEl && ticon) {
          lessonEmojiEl.classList.add('swapping');
          setTimeout(() => {
            lessonEmojiEl.textContent = ticon;
            lessonEmojiEl.classList.remove('swapping');
          }, 200);
        }
        if (meetingTitleEl && tsubject) meetingTitleEl.textContent = `Bilenyum · ${tsubject}`;
      });
    });

    document.querySelector('.classroom-main .video-play')?.addEventListener('click', e => {
      e.stopPropagation();
      const active = document.querySelector('.classroom-stage > .classroom-side:first-child .level-pill.active');
      if (!active) return;
      const pillLabel = active.querySelector('span')?.textContent?.trim() || 'Örnek ders önizlemesi';
      openVideoModal({
        video: active.dataset.video,
        avatar: active.dataset.avatar || '',
        name: active.dataset.teacher || '',
        grade: pillLabel,
        title: active.dataset.subject || '',
      });
    });

    closeBtn?.addEventListener('click', closeModal);
    backdrop?.addEventListener('click', closeModal);
    document.addEventListener('keydown', e => {
      if (e.key === 'Escape' && !modal.hidden) closeModal();
    });
  })();

  // Panel tabs (Öğrenci / Veli)
  document.querySelectorAll('.panel-tab').forEach(tab => {
    tab.addEventListener('click', () => {
      const target = tab.dataset.panel;
      document.querySelectorAll('.panel-tab').forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      document.querySelectorAll('.panel-content').forEach(p => {
        p.hidden = p.dataset.panel !== target;
      });
    });
  });

  function pricingEscapeHtml(text) {
    return String(text)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/"/g, '&quot;');
  }

  /** Tarayıcıda img src — PHP window.__pricingImgBase ile kök yolu düzeltir; ../ tek başına kırılmaz */
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

  /** Katalog: ../scripts/pricing-catalog.js → window.BILENYUM_PRICING_CATALOG */
  const PRICING_DATA = window.BILENYUM_PRICING_CATALOG || {};

  /**
   * Paket kartlarını DOM’a basar. CMS / PHP ile üretilen şablonda aşağıdaki sınıf hiyerarşisi ve
   * `.price-row` içeriği korunmalı; yerleşim `landing-reference.css` → `.price-row` (iki sütun grid).
   * @see docs/DEVELOPER-pricing-card-layout.md
   */
  function renderPricingCards(grade) {
    const grid = document.querySelector('.pricing-grid');
    if (!grid) return;
    const cards = PRICING_DATA[grade] || [];
    grid.innerHTML = cards
      .map((c) => {
        const themeClass = c.theme ? ` price-card--${c.theme}` : '';
        const feat = (c.features || [])
          .map((f) => `<li>${pricingEscapeHtml(f)}</li>`)
          .join('');
        const alt = pricingEscapeHtml(c.alt || c.name);
        const detailHref = `./paket-detay.html?paket=${encodeURIComponent(c.theme || '')}&sinif=${encodeURIComponent(grade)}`;
        const checkoutHref = `./odeme-bilgileri.php?paket=${encodeURIComponent(c.theme || '')}&sinif=${encodeURIComponent(grade)}`;
        return `
      <div class="price-card${themeClass}">
        <div class="price-card-image">
          <img src="${encodeURI(pricingImgUrl(c.img))}" width="800" height="320" alt="${alt}" loading="lazy" decoding="async" />
        </div>
        <div class="price-card-body">
          <h3 class="title">${pricingEscapeHtml(c.name)}</h3>
          <ul class="price-features">
            ${feat}
          </ul>
          <div class="price-row">
            <div class="price-amount"><span class="num">₺ ${pricingEscapeHtml(c.price)}</span><span class="per">/ ay</span></div>
            <div class="price-meta">
              <span>Toplam <strong>₺ ${pricingEscapeHtml(c.total)}</strong></span>
              <span class="price-installment">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                9 taksit imkanı
              </span>
            </div>
          </div>
          <div class="price-users">
            <div class="av-stack"><div class="av"></div><div class="av"></div><div class="av"></div></div>
            <span><strong>${pricingEscapeHtml(c.users)}</strong> öğrenci kullanıyor</span>
          </div>
          <div class="price-actions">
            <a href="${detailHref}" class="btn btn-ghost btn-sm">Paketi İncele</a>
            <a href="${checkoutHref}" class="btn btn-primary btn-sm">Satın Al</a>
          </div>
        </div>
      </div>`;
      })
      .join('');
    grid.scrollLeft = 0;
  }

  // Pricing grid: drag-to-scroll + arrow nav
  (function() {
    const grid = document.querySelector('.pricing-grid');
    if (!grid) return;
    const prevBtn = document.querySelector('.pricing-arrow.prev');
    const nextBtn = document.querySelector('.pricing-arrow.next');
    const stepFor = () => {
      const card = grid.querySelector('.price-card');
      return (card?.offsetWidth || 320) + 24;
    };
    if (prevBtn) prevBtn.addEventListener('click', () => grid.scrollBy({ left: -stepFor(), behavior: 'smooth' }));
    if (nextBtn) nextBtn.addEventListener('click', () => grid.scrollBy({ left: stepFor(), behavior: 'smooth' }));
    let isDown = false, startX = 0, scrollLeft = 0, hasMoved = false, capturedId = null;
    grid.addEventListener('pointerdown', (e) => {
      // Skip if clicking on a link, button, or other interactive element
      if (e.target.closest('a, button, input, label')) return;
      isDown = true; hasMoved = false;
      startX = e.pageX - grid.offsetLeft;
      scrollLeft = grid.scrollLeft;
    });
    grid.addEventListener('pointermove', (e) => {
      if (!isDown) return;
      const x = e.pageX - grid.offsetLeft;
      const walk = (x - startX) * 1.5;
      if (Math.abs(walk) > 4 && !hasMoved) {
        hasMoved = true;
        grid.classList.add('is-grabbing');
        try { grid.setPointerCapture(e.pointerId); capturedId = e.pointerId; } catch (_) {}
      }
      if (hasMoved) grid.scrollLeft = scrollLeft - walk;
    });
    const endDrag = (e) => {
      if (!isDown) return;
      isDown = false;
      grid.classList.remove('is-grabbing');
      if (capturedId !== null) {
        try { grid.releasePointerCapture(capturedId); } catch (_) {}
        capturedId = null;
      }
    };
    grid.addEventListener('pointerup', endDrag);
    grid.addEventListener('pointercancel', endDrag);
    grid.addEventListener('click', (e) => {
      if (hasMoved) { e.preventDefault(); e.stopPropagation(); hasMoved = false; }
    }, true);
  })();

  // Pricing tabs —' swap cards per grade
  document.querySelectorAll('.pricing-tab').forEach(b => {
    b.addEventListener('click', () => {
      document.querySelectorAll('.pricing-tab').forEach(x => x.classList.remove('active'));
      b.classList.add('active');
      const grade = b.dataset.grade;
      if (grade) renderPricingCards(grade);
    });
  });

  // Initial render: active grade
  (function() {
    const activeTab = document.querySelector('.pricing-tab.active');
    if (activeTab && activeTab.dataset.grade) {
      renderPricingCards(activeTab.dataset.grade);
    }
  })();

  // Kozmik yıldız parallax: yüzey = kapsayıcı (ana wrap / nav hero / kozmik bant), hedef = .stars (18 / 14 px, rAF).
  (function initStarsParallaxAll() {
    function bindSurfaceToStars(surface, stars) {
      let raf = null;
      let tx = 0;
      let ty = 0;
      const onMove = (e) => {
        const rect = surface.getBoundingClientRect();
        if (rect.width < 1 || rect.height < 1) return;
        const nx = ((e.clientX - rect.left) / rect.width - 0.5) * 2;
        const ny = ((e.clientY - rect.top) / rect.height - 0.5) * 2;
        tx = nx * 18;
        ty = ny * 14;
        if (!raf) {
          raf = requestAnimationFrame(() => {
            stars.style.transform = `translate3d(${tx}px, ${ty}px, 0)`;
            raf = null;
          });
        }
      };
      const onLeave = () => {
        stars.style.transform = '';
        surface.style.removeProperty('transform');
      };
      surface.addEventListener('mousemove', onMove, { passive: true });
      surface.addEventListener('mouseleave', onLeave);
    }

    function bindAll() {
      const home = document.querySelector('.hero-pricing-bg');
      if (home) {
        const stars = home.querySelector('.stars');
        if (stars) bindSurfaceToStars(home, stars);
      }

      document.querySelectorAll('.nav-page-hero, [data-cosmos-parallax]').forEach((surface) => {
        const stars = surface.querySelector('.stars');
        if (!stars) return;
        surface.style.removeProperty('transform');
        bindSurfaceToStars(surface, stars);
      });
    }

    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', bindAll);
    } else {
      bindAll();
    }
  })();
  (function() {
    const root = document.getElementById('heroSlider');
    const viewport = document.getElementById('heroSliderViewport');
    const prev = document.querySelector('.hero-slider-prev');
    const next = document.querySelector('.hero-slider-next');
    const dots = document.querySelectorAll('.hero-slider-dot');
    const progressBar = document.getElementById('heroSliderProgressBar');
    const slideCurrentEl = document.getElementById('heroSliderCurrent');
    const heroIllus = document.querySelector('.hero-illus');
    if (!root || !viewport || !prev || !next || !dots.length || !progressBar) return;

    const prefersReduced =
      typeof window.matchMedia === 'function' &&
      window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const autoplayMs = Math.max(
      3500,
      parseInt(root.getAttribute('data-autoplay-ms'), 10) || 5500
    );

    let storedIdx = 0;
    let autoplayTimer = null;
    let hoverPause = false;
    let focusPause = false;
    let slideTransitionGen = 0;

    // Only preserve: change planet theme by active slide index.
    const applyPlanetTheme = (idx) => {
      if (!heroIllus) return;
      heroIllus.setAttribute('data-slide', String(idx % 3));
    };

    const getIndex = () => {
      const w = viewport.clientWidth || 1;
      return Math.round(viewport.scrollLeft / w);
    };

    /** En uzun slaytın yüksekliği — slayt değişince sabit kalır, oklar zıplamaz. */
    let viewportHeightRetries = 0;
    const syncViewportHeight = () => {
      const slideEls = viewport.querySelectorAll('.hero-slide');
      if (!slideEls.length) return;
      viewport.style.removeProperty('height');
      void viewport.offsetHeight;
      let maxH = 0;
      slideEls.forEach((el) => {
        maxH = Math.max(maxH, el.scrollHeight);
      });
      if (maxH < 24 && viewportHeightRetries < 8) {
        viewportHeightRetries += 1;
        requestAnimationFrame(syncViewportHeight);
        return;
      }
      viewportHeightRetries = 0;
      viewport.style.height = `${Math.max(1, Math.ceil(maxH))}px`;
    };

    const syncUi = () => {
      const slides = dots.length;
      const idx = Math.min(Math.max(getIndex(), 0), slides - 1);
      storedIdx = idx;
      progressBar.style.marginLeft = '';
      progressBar.style.width = `${((idx + 1) / slides) * 100}%`;
      if (slideCurrentEl) {
        slideCurrentEl.textContent = String(idx + 1);
      }
      dots.forEach((d, di) => {
        const on = di === idx;
        d.classList.toggle('is-active', on);
        d.setAttribute('aria-selected', on ? 'true' : 'false');
      });
      viewport.querySelectorAll('.hero-slide').forEach((el, i) => {
        if (i === idx) el.setAttribute('aria-current', 'true');
        else el.removeAttribute('aria-current');
      });
      applyPlanetTheme(idx);
    };

    const clearAutoplay = () => {
      if (autoplayTimer !== null) {
        window.clearInterval(autoplayTimer);
        autoplayTimer = null;
      }
    };

    const scheduleAutoplay = () => {
      clearAutoplay();
      if (
        prefersReduced ||
        hoverPause ||
        focusPause ||
        (typeof document !== 'undefined' && document.hidden)
      ) {
        return;
      }
      autoplayTimer = window.setInterval(() => {
        goTo(storedIdx + 1);
      }, autoplayMs);
    };

    const updateAutoplayPause = () => {
      clearAutoplay();
      scheduleAutoplay();
    };

    const runSlideTransitionFx = (idx, changed) => {
      if (!changed || prefersReduced) return;
      const slidesNodes = viewport.querySelectorAll('.hero-slide');
      slidesNodes.forEach((el) => {
        el.classList.remove('hero-slide--transition-in');
      });
      const active = slidesNodes[idx];
      if (!active) return;
      void active.offsetWidth;
      active.classList.add('hero-slide--transition-in');
      const onEnd = (e) => {
        if (e.animationName !== 'heroSlideTransitionIn') return;
        active.classList.remove('hero-slide--transition-in');
        active.removeEventListener('animationend', onEnd);
      };
      active.addEventListener('animationend', onEnd, { once: true });
    };

    const goTo = (index) => {
      const slides = dots.length;
      const idx = ((index % slides) + slides) % slides;
      const fromIdx = Math.min(Math.max(getIndex(), 0), slides - 1);
      const changed = fromIdx !== idx;
      slideTransitionGen += 1;

      storedIdx = idx;
      const w = viewport.clientWidth;

      if (changed && !prefersReduced) {
        viewport.classList.add('hero-slider-viewport--transition-fx');
      }

      viewport.scrollTo({
        left: idx * w,
        behavior: prefersReduced ? 'auto' : 'smooth',
      });
      requestAnimationFrame(syncUi);
      scheduleAutoplay();
      requestAnimationFrame(() => {
        viewport.classList.remove('hero-slider-viewport--transition-fx');
        runSlideTransitionFx(idx, changed);
      });
    };

    prev.addEventListener('click', () => goTo(getIndex() - 1));
    next.addEventListener('click', () => goTo(getIndex() + 1));
    dots.forEach((d) => {
      d.addEventListener('click', () => goTo(parseInt(d.dataset.slide, 10)));
    });

    /** Otomatik kaydırma: yalnızca oklar, noktalar ve alt kontrol şeridinin üzerindeyken durur */
    const pauseTargets = root.querySelectorAll(
      '.hero-slider-prev, .hero-slider-next, .hero-slider-dot, .hero-slider-footer'
    );
    pauseTargets.forEach((el) => {
      el.addEventListener('mouseenter', () => {
        hoverPause = true;
        updateAutoplayPause();
      });
      el.addEventListener('mouseleave', () => {
        hoverPause = false;
        updateAutoplayPause();
      });
    });
    viewport.addEventListener('focusin', () => {
      focusPause = true;
      updateAutoplayPause();
    });
    viewport.addEventListener('focusout', () => {
      focusPause = false;
      updateAutoplayPause();
    });
    document.addEventListener('visibilitychange', updateAutoplayPause);

    let scrollTick = false;
    viewport.addEventListener(
      'scroll',
      () => {
        if (!scrollTick) {
          scrollTick = true;
          requestAnimationFrame(() => {
            syncUi();
            scrollTick = false;
          });
        }
      },
      { passive: true }
    );

    viewport.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowLeft') {
        e.preventDefault();
        goTo(getIndex() - 1);
      } else if (e.key === 'ArrowRight') {
        e.preventDefault();
        goTo(getIndex() + 1);
      }
    });

    window.addEventListener('resize', () => {
      const w = viewport.clientWidth;
      viewport.scrollTo({ left: storedIdx * w, behavior: 'auto' });
      requestAnimationFrame(() => {
        syncUi();
        syncViewportHeight();
      });
    });

    if (typeof ResizeObserver === 'function') {
      const ro = new ResizeObserver(() => {
        requestAnimationFrame(syncViewportHeight);
      });
      viewport.querySelectorAll('.hero-slide').forEach((el) => ro.observe(el));
    }

    syncUi();
    scheduleAutoplay();
    requestAnimationFrame(() => {
      requestAnimationFrame(syncViewportHeight);
    });
  })();

  // Bize Ulaşın — öneri formu (doğrulama + ön uç geri bildirimi)
  (function () {
    const form = document.getElementById('iletisim-feedback-form');
    if (!form) return;

    const elAd = document.getElementById('iletisim-ad');
    const elTel = document.getElementById('iletisim-tel');
    const elMail = document.getElementById('iletisim-mail');
    const elKonu = document.getElementById('iletisim-konu');
    const elMesaj = document.getElementById('iletisim-mesaj');
    const mesajHint = document.getElementById('iletisim-mesaj-hint');

    function clearInvalid(el) {
      if (el) el.classList.remove('iletisim-input--invalid');
    }

    function markInvalid(el) {
      if (el) el.classList.add('iletisim-input--invalid');
    }

    function digitsOnly(s) {
      return String(s || '').replace(/\D/g, '');
    }

    function validTrMobile(digits) {
      return digits.length === 11 && digits.indexOf('05') === 0;
    }

    function updateMesajCounter() {
      if (!elMesaj || !mesajHint) return;
      const n = elMesaj.value.length;
      const max = Number(elMesaj.getAttribute('maxlength')) || 4000;
      mesajHint.textContent = n + ' / ' + max + ' karakter (en az 15).';
    }

    [elAd, elTel, elMail, elKonu, elMesaj].forEach((el) => {
      if (!el) return;
      el.addEventListener('input', () => clearInvalid(el));
    });

    if (elTel) {
      elTel.addEventListener('input', () => {
        let d = digitsOnly(elTel.value).slice(0, 11);
        elTel.value = d;
      });
    }

    if (elMesaj) {
      elMesaj.addEventListener('input', updateMesajCounter);
      updateMesajCounter();
    }

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      [elAd, elTel, elMail, elKonu, elMesaj].forEach(clearInvalid);

      let firstBad = null;

      const ad = elAd ? elAd.value.trim() : '';
      if (ad.length < 2 || ad.length > 120) {
        markInvalid(elAd);
        firstBad = firstBad || elAd;
      }

      const telDigits = digitsOnly(elTel ? elTel.value : '');
      if (!validTrMobile(telDigits)) {
        markInvalid(elTel);
        firstBad = firstBad || elTel;
      }

      if (elMail && !elMail.checkValidity()) {
        markInvalid(elMail);
        firstBad = firstBad || elMail;
      }

      if (elKonu && !elKonu.value) {
        markInvalid(elKonu);
        firstBad = firstBad || elKonu;
      }

      const msg = elMesaj ? elMesaj.value.trim() : '';
      if (msg.length < 15 || msg.length > 4000) {
        markInvalid(elMesaj);
        firstBad = firstBad || elMesaj;
      }

      if (firstBad) {
        firstBad.focus();
        return;
      }

      const btn = form.querySelector('.iletisim-submit');
      const prev = btn ? btn.textContent : '';
      if (btn) {
        btn.disabled = true;
        btn.textContent = 'Gönderildi';
      }
      form.setAttribute('aria-label', 'Mesajınız için teşekkürler');
      window.setTimeout(() => {
        if (btn) {
          btn.disabled = false;
          btn.textContent = prev;
        }
        form.reset();
        [elAd, elTel, elMail, elKonu, elMesaj].forEach(clearInvalid);
        if (elTel) elTel.value = '';
        updateMesajCounter();
      }, 2400);
    });
  })();

