/**
 * Yumi — yerel (FAQ) platform asistanı. Anahtar kelime eşlemesi; gerçek zamanlı API yok.
 */
(function () {
  var fab = document.getElementById('yumiFab');
  var shell = document.querySelector('.yumi-fab-shell');
  var chat = document.getElementById('yumiChat');
  var closeBtn = document.getElementById('yumiClose');
  var newChatBtn = document.getElementById('yumiNewChat');
  var thread = document.getElementById('yumiThread');
  var input = document.getElementById('yumiInput');
  var send = document.getElementById('yumiSend');
  var quick = document.getElementById('yumiQuick');
  var charCountEl = document.getElementById('yumiCharCount');
  if (!fab || !chat || !closeBtn || !thread || !input || !send) return;

  var reduceMotion =
    typeof window !== 'undefined' &&
    window.matchMedia &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  var WELCOME_TEXT =
    'Merhaba, ben Yumi. Bilenyum’da paket ve ödeme, giriş ve hesap, deneme sonuçları, veli paneli, canlı dersler ve iletişim hakkında sorularınızı yanıtlayabilirim.';

  function norm(t) {
    return String(t || '')
      .toLowerCase()
      .replace(/ğ/g, 'g')
      .replace(/ü/g, 'u')
      .replace(/ş/g, 's')
      .replace(/ı/g, 'i')
      .replace(/ö/g, 'o')
      .replace(/ç/g, 'c')
      .replace(/İ/g, 'i')
      .replace(/Ğ/g, 'g')
      .replace(/Ü/g, 'u')
      .replace(/Ş/g, 's')
      .replace(/Ö/g, 'o')
      .replace(/Ç/g, 'c')
      .replace(/\s+/g, ' ')
      .trim();
  }

  var DEFAULT_REPLY =
    'Bu soruya tam eşleşen bir yanıt bulamadım. Üst menüden Eğitim Setleri ve iletişim bilgilerimize göz atabilir veya WhatsApp / destek hattımızdan yardım alabilirsiniz. Aşağıdaki önerilerden birini de deneyebilirsiniz.';

  var RULES = [
    {
      re: /satin|paket|odeme|ucret|fiyat|siparis|nasil al|odeme yap|taksit|kartla|hesaba odeme/,
      reply:
        'Paket ve satın alma\n\nEğitim setleri sayfasında sınıfınıza uygun paketi seçebilirsiniz. Satın Al ile önce ödeme bilgileri (ad, soyad, telefon ve aydınlatma metni onayı) adımına geçilir; ardından güvenli ödeme tamamlanır. Kampanya ve taksit için WhatsApp veya destek hattımızdan bilgi alabilirsiniz.',
    },
    {
      re: /giris|giris yap|login|oturum|sifre|hesap|uye ol|kayit ol|email|e-posta/,
      reply:
        'Giriş ve hesap\n\nKayıt olduğunuz e-posta ve şifre ile giriş yaparsınız. Şifre sıfırlama genelde giriş ekranındaki “Şifremi unuttum” bağlantısından yapılır. Giriş yapamıyorsanız doğru e-postayı kullandığınızdan emin olun; sorun sürerse destek ile iletişime geçin.',
    },
    {
      re: /deneme|sonuc|sinav|puan|rapor|basari|sonuclarima|test sonuc/,
      reply:
        'Deneme ve sınav sonuçları\n\nDeneme ve sınav sonuçları genelde öğrenci veya veli panelindeki ilgili bölümde listelenir. Veli hesabıyla giriş yaptığınızda gelişim raporu ve bildirimler üzerinden de takip edebilirsiniz. Menüde sonuçlar, raporlar veya denemeler benzeri bir sekme arayın; göremiyorsanız destekten oturum bilginizi doğrulatarak yardım isteyin.',
    },
    {
      re: /veli|panel|bildirim|gelisim|takip/,
      reply:
        'Veli paneli\n\nVeli panelinde canlı ders katılımı, kayıt izleme, gelişim özeti ve bildirimler tek yerde toplanır. Giriş yaptıktan sonra çocuğunuzun kayıtlı olduğu sınıf veya paket üzerinden detaylara inebilirsiniz.',
    },
    {
      re: /canli|yayin|kayit izle|telafi|ders saati|program|mufredat/,
      reply:
        'Dersler ve içerik\n\nPlatformda canlı yayınlar planlı saatlerde yapılır; kaçırdığınız oturumları kayıt arşivinden tekrar izleyebilir, telafi süreçleri hakkında veli panelindeki duyurulardan haberdar olabilirsiniz. İçerikler sınıf seviyesine göre yapılandırılmıştır.',
    },
    {
      re: /platform|ozellik|neler var|ne sun|bilenyum nedir|hizmet|icerik/,
      reply:
        'Bilenyum platformunda neler var?\n\nÖzetle: canlı dersler, kayıt arşivi, deneme ve ölçüm süreçleri, veli paneli ve şeffaf iletişim. Eğitim setleri sayfasında paketlere göre süre ve kapsamı görebilir; Kozmik gelişim yolculuğu bölümünde öğrenci yolculuğunun adımlarını inceleyebilirsiniz. Eğitmen Kadromuz sayfasından birime göre ekibi filtreleyebilir ve profilleri inceleyebilirsiniz.',
    },
    {
      re: /iletisim|whatsapp|destek|yardim|telefon|mail|musteri/,
      reply:
        'İletişim ve destek\n\nSayfa altındaki iletişim bilgileri, WhatsApp ve e-posta üzerinden destek alabilirsiniz. Teknik sorun veya hesap işlemleri için kullandığınız e-posta ve öğrenci bilgisi talep edilebilir.',
    },
  ];

  function answer(question) {
    var n = norm(question);
    if (!n) return DEFAULT_REPLY;
    for (var i = 0; i < RULES.length; i++) {
      if (RULES[i].re.test(n)) return RULES[i].reply;
    }
    return DEFAULT_REPLY;
  }

  function formatTime(d) {
    var dt = d || new Date();
    try {
      return dt.toLocaleTimeString('tr-TR', { hour: '2-digit', minute: '2-digit' });
    } catch (e) {
      return '';
    }
  }

  function fillBotContent(container, text) {
    container.innerHTML = '';
    var blocks = String(text || '').split(/\n\n+/);
    blocks.forEach(function (block) {
      var p = document.createElement('p');
      var lines = block.split('\n');
      lines.forEach(function (line, i) {
        if (i > 0) p.appendChild(document.createElement('br'));
        p.appendChild(document.createTextNode(line));
      });
      container.appendChild(p);
    });
  }

  function createTimeEl() {
    var time = document.createElement('time');
    time.className = 'yumi-msg-time';
    var now = new Date();
    try {
      time.setAttribute('datetime', now.toISOString());
    } catch (e) {}
    time.textContent = formatTime(now);
    return time;
  }

  function appendBotMessage(text) {
    var row = document.createElement('div');
    row.className = 'yumi-msg-row yumi-msg-row--bot';
    row.setAttribute('role', 'article');

    var av = document.createElement('div');
    av.className = 'yumi-msg-avatar';
    av.setAttribute('aria-hidden', 'true');
    var avIn = document.createElement('span');
    avIn.className = 'yumi-msg-avatar-inner';
    avIn.textContent = 'Y';
    av.appendChild(avIn);

    var stack = document.createElement('div');
    stack.className = 'yumi-msg-stack';

    var meta = document.createElement('div');
    meta.className = 'yumi-msg-meta';
    var sender = document.createElement('span');
    sender.className = 'yumi-msg-sender';
    sender.textContent = 'Yumi';
    meta.appendChild(sender);
    meta.appendChild(createTimeEl());

    var bubble = document.createElement('div');
    bubble.className = 'yumi-msg yumi-msg--bot';
    var content = document.createElement('div');
    content.className = 'yumi-msg-content';
    fillBotContent(content, text);
    bubble.appendChild(content);

    stack.appendChild(meta);
    stack.appendChild(bubble);
    row.appendChild(av);
    row.appendChild(stack);
    thread.appendChild(row);
    scrollThread();
  }

  function appendUserMessage(text) {
    var row = document.createElement('div');
    row.className = 'yumi-msg-row yumi-msg-row--user';
    row.setAttribute('role', 'article');

    var stack = document.createElement('div');
    stack.className = 'yumi-msg-stack yumi-msg-stack--user';

    var meta = document.createElement('div');
    meta.className = 'yumi-msg-meta yumi-msg-meta--user';
    var sender = document.createElement('span');
    sender.className = 'yumi-msg-sender';
    sender.textContent = 'Siz';
    meta.appendChild(sender);
    meta.appendChild(createTimeEl());

    var bubble = document.createElement('div');
    bubble.className = 'yumi-msg yumi-msg--user';
    var content = document.createElement('div');
    content.className = 'yumi-msg-content';
    var p = document.createElement('p');
    p.textContent = text;
    content.appendChild(p);
    bubble.appendChild(content);

    stack.appendChild(meta);
    stack.appendChild(bubble);
    row.appendChild(stack);
    thread.appendChild(row);
    scrollThread();
  }

  var typingEl = null;

  function removeTyping() {
    if (typingEl && typingEl.parentNode) typingEl.parentNode.removeChild(typingEl);
    typingEl = null;
  }

  function showTyping() {
    removeTyping();
    var row = document.createElement('div');
    row.className = 'yumi-msg-row yumi-msg-row--bot yumi-msg-row--typing';
    row.setAttribute('aria-hidden', 'true');

    var av = document.createElement('div');
    av.className = 'yumi-msg-avatar';
    av.setAttribute('aria-hidden', 'true');
    var avIn = document.createElement('span');
    avIn.className = 'yumi-msg-avatar-inner';
    avIn.textContent = 'Y';
    av.appendChild(avIn);

    var stack = document.createElement('div');
    stack.className = 'yumi-msg-stack';
    var bubble = document.createElement('div');
    bubble.className = 'yumi-typing-bubble';
    bubble.innerHTML =
      '<span class="yumi-typing-dot"></span><span class="yumi-typing-dot"></span><span class="yumi-typing-dot"></span>';
    stack.appendChild(bubble);
    row.appendChild(av);
    row.appendChild(stack);
    thread.appendChild(row);
    typingEl = row;
    scrollThread();
  }

  function scrollThread() {
    requestAnimationFrame(function () {
      thread.scrollTop = thread.scrollHeight;
    });
  }

  function resizeComposer() {
    if (!input || input.tagName !== 'TEXTAREA') return;
    input.style.height = 'auto';
    var max = 120;
    input.style.height = Math.min(input.scrollHeight, max) + 'px';
  }

  function updateCharCount() {
    if (!charCountEl) return;
    var n = (input.value || '').length;
    var max = Number(input.getAttribute('maxlength')) || 400;
    charCountEl.textContent = n + '/' + max;
  }

  function updateSendState() {
    var has = (input.value || '').trim().length > 0;
    send.disabled = !has;
  }

  function submitQuestion(q) {
    var raw = String(q || '')
      .trim()
      .slice(0, 400);
    if (!raw) return;
    appendUserMessage(raw);
    input.value = '';
    resizeComposer();
    updateCharCount();
    updateSendState();

    var reply = answer(raw);
    var delay = reduceMotion ? 80 : 420 + Math.floor(Math.random() * 280);

    showTyping();
    window.setTimeout(function () {
      removeTyping();
      appendBotMessage(reply);
    }, delay);
  }

  function resetConversation() {
    removeTyping();
    thread.innerHTML = '';
    appendBotMessage(WELCOME_TEXT);
  }

  function setOpen(open) {
    chat.classList.toggle('open', open);
    fab.setAttribute('aria-expanded', open ? 'true' : 'false');
    if (shell) {
      shell.classList.toggle('yumi-fab-shell--concealed', !!open);
    }
    if (open) {
      requestAnimationFrame(function () {
        input.focus();
        scrollThread();
        resizeComposer();
      });
    }
  }

  fab.addEventListener('click', function () {
    if (!chat.classList.contains('open')) {
      setOpen(true);
    }
  });
  closeBtn.addEventListener('click', function () {
    setOpen(false);
  });

  if (newChatBtn) {
    newChatBtn.addEventListener('click', function () {
      resetConversation();
      input.focus();
    });
  }

  send.addEventListener('click', function () {
    submitQuestion(input.value);
  });

  input.addEventListener('input', function () {
    resizeComposer();
    updateCharCount();
    updateSendState();
  });

  input.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' && !e.shiftKey) {
      e.preventDefault();
      submitQuestion(input.value);
    }
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && chat.classList.contains('open')) setOpen(false);
  });

  if (quick) {
    quick.querySelectorAll('.yumi-chip').forEach(function (chip) {
      chip.addEventListener('click', function () {
        var q = chip.getAttribute('data-q') || chip.textContent || '';
        submitQuestion(q);
      });
    });
  }

  resizeComposer();
  updateCharCount();
  updateSendState();
})();
