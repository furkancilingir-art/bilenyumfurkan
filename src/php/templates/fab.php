<!-- Yumi — kompakt pill; sohbet paneli gelişmiş mesaj düzeni + composer -->
<div class="yumi-fab-shell">
  <button
    class="yumi-fab-launcher"
    id="yumiFab"
    type="button"
    aria-label="Yumi asistan: soru sor"
    aria-expanded="false"
    aria-controls="yumiChat"
  >
    <figure class="yumi-fab-mascot" aria-hidden="true">
      <img
        class="yumi-fab-mascot-img"
        src="../components/images/yumi-mascot.png"
        width="208"
        height="208"
        alt=""
        decoding="async"
      />
    </figure>
    <span class="yumi-fab-copy">
      <span class="yumi-fab-line yumi-fab-line--name">Ben Yumi</span>
      <span class="yumi-fab-line yumi-fab-line--cta">Bana soru sor</span>
    </span>
  </button>
</div>
<div
  class="yumi-chat"
  id="yumiChat"
  role="dialog"
  aria-modal="false"
  aria-labelledby="yumiChatTitle"
>
  <header class="yumi-chat-head">
    <div class="yumi-chat-head-top">
      <div class="yumi-chat-head-text">
        <div id="yumiChatTitle" class="yumi-chat-title">Yumi · Platform asistanı</div>
        <p class="yumi-chat-sub">
          Paketler, giriş, deneme sonuçları ve platform rehberi — yazın veya aşağıdan örnek seçin.
        </p>
      </div>
      <button class="yumi-chat-close" id="yumiClose" type="button" aria-label="Sohbeti kapat">×</button>
    </div>
    <div class="yumi-chat-head-bar">
      <span class="yumi-status-pill" title="Bu asistan tarayıcınızda çalışır; mesajlar sunucuya gönderilmez">
        <span class="yumi-status-dot" aria-hidden="true"></span>
        Yerel rehber · Anında yanıt
      </span>
      <button type="button" class="yumi-chat-reset" id="yumiNewChat">
        Yeni sohbet
      </button>
    </div>
  </header>
  <div class="yumi-chat-body">
    <div class="yumi-chat-body-inner">
      <div class="yumi-chat-thread-wrap">
        <div
          class="yumi-chat-thread"
          id="yumiThread"
          tabindex="-1"
          aria-label="Sohbet geçmişi"
          aria-live="polite"
          aria-relevant="additions"
        >
          <div class="yumi-msg-row yumi-msg-row--bot">
            <div class="yumi-msg-avatar" aria-hidden="true">
              <span class="yumi-msg-avatar-inner">Y</span>
            </div>
            <div class="yumi-msg-stack">
              <div class="yumi-msg-meta">
                <span class="yumi-msg-sender">Yumi</span>
                <time class="yumi-msg-time">Şimdi</time>
              </div>
              <div class="yumi-msg yumi-msg--bot">
                <div class="yumi-msg-content">
                  <p>
                    Merhaba, ben Yumi. Bilenyum’da paket ve ödeme, giriş ve hesap, deneme sonuçları, veli paneli,
                    canlı dersler ve iletişim hakkında sorularınızı yanıtlayabilirim.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="yumi-suggestions">
        <p class="yumi-quick-label" id="yumiQuickLabel">Önerilen sorular</p>
        <div class="yumi-quick-scroll" role="region" aria-labelledby="yumiQuickLabel">
          <div class="yumi-quick" id="yumiQuick">
            <button type="button" class="yumi-chip" data-q="Nasıl satın alabilirim?">Satın alma</button>
            <button type="button" class="yumi-chip" data-q="Giriş nasıl yapılır?">Giriş işlemleri</button>
            <button type="button" class="yumi-chip" data-q="Deneme sonuçlarıma nasıl ulaşırım?">Deneme sonuçları</button>
          </div>
        </div>
      </div>
      <footer class="yumi-chat-composer">
        <label class="visually-hidden" for="yumiInput">Mesajınız</label>
        <div class="yumi-chat-input-row">
          <textarea
            id="yumiInput"
            class="yumi-chat-field"
            rows="1"
            placeholder="Sorunuzu yazın…"
            autocomplete="off"
            maxlength="400"
            aria-describedby="yumiComposerHint"
          ></textarea>
          <button id="yumiSend" class="yumi-send-btn" type="button" aria-label="Gönder" disabled>
            <span class="yumi-send-icon" aria-hidden="true">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22 2 11 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22 2 15 22l-4-9-9-4 20-7z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </button>
        </div>
        <div class="yumi-composer-meta" id="yumiComposerHint">
          <span class="yumi-composer-hint"><kbd>Enter</kbd> gönderir · <kbd>Shift</kbd>+<kbd>Enter</kbd> yeni satır</span>
          <span class="yumi-char-count" id="yumiCharCount" aria-live="polite">0/400</span>
        </div>
      </footer>
    </div>
    <div class="yumi-chat-mascot-floor" aria-hidden="true">
      <img
        class="yumi-chat-mascot-img"
        src="../components/images/yumi-mascot.png"
        width="260"
        height="338"
        alt=""
        decoding="async"
      />
    </div>
  </div>
</div>
