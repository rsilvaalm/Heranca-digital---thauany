/* ═══════════════════════════════════════
   ACESSIBILIDADE — TTS (Web Speech API)
                    + Libras (VLibras)
   Controles integrados na nav
   ═══════════════════════════════════════ */

(function () {
  // Inicializa VLibras
  new window.VLibras.Widget('https://vlibras.gov.br/app');

  // ── Dropdown de acessibilidade na nav ──
  const navBtn     = document.getElementById('a11y-nav-btn');
  const dropdown   = document.getElementById('a11y-dropdown');

  navBtn.addEventListener('click', (e) => {
    e.stopPropagation();
    const isOpen = dropdown.classList.toggle('open');
    navBtn.classList.toggle('open', isOpen);
    navBtn.setAttribute('aria-expanded', isOpen);
  });

  // Fecha ao clicar fora
  document.addEventListener('click', () => {
    dropdown.classList.remove('open');
    navBtn.classList.remove('open');
    navBtn.setAttribute('aria-expanded', false);
  });

  dropdown.addEventListener('click', (e) => e.stopPropagation());

  // ── TTS ──
  const ttsBtn      = document.getElementById('tts-btn');
  const ttsLabel    = document.getElementById('tts-label');
  const ttsProgress = document.getElementById('tts-progress');

  let ttsActive  = false;
  let utterances = [];
  let currentEl  = null;

  function getReadableElements() {
    const selectors = [
      '#hero h1', '#hero p',
      '#sobre .sobre-content p',
      '#apresentacao .carousel-slide p',
      '#produtos .produto-body h3',
      '#testamento h2', '#testamento p'
    ];
    return Array.from(document.querySelectorAll(selectors.join(',')))
      .filter(el => el.textContent.trim().length > 0);
  }

  function stopTTS() {
    window.speechSynthesis.cancel();
    ttsActive = false;
    ttsBtn.classList.remove('active');
    ttsBtn.setAttribute('aria-pressed', 'false');
    ttsLabel.textContent = 'Narrar página';
    if (ttsProgress) ttsProgress.style.width = '0%';
    if (currentEl) { currentEl.classList.remove('tts-reading'); currentEl = null; }
    utterances = [];
  }

  function startTTS() {
    if (!('speechSynthesis' in window)) {
      alert('Seu navegador não suporta leitura em voz alta.');
      return;
    }
    ttsActive = true;
    ttsBtn.classList.add('active');
    ttsBtn.setAttribute('aria-pressed', 'true');
    ttsLabel.textContent = 'Parar narração';

    const elements = getReadableElements();
    const total    = elements.length;

    elements.forEach((el, idx) => {
      const text = el.textContent.replace(/[^\w\sÀ-ÿ.,;:!?'"()\-–—]/g, ' ').trim();
      if (!text) return;

      const utter  = new SpeechSynthesisUtterance(text);
      utter.lang   = 'pt-BR';
      utter.rate   = 0.95;
      utter.pitch  = 1;

      utter.onstart = () => {
        if (currentEl) currentEl.classList.remove('tts-reading');
        currentEl = el;
        el.classList.add('tts-reading');
        el.scrollIntoView({ behavior: 'smooth', block: 'center' });
        if (ttsProgress) ttsProgress.style.width = ((idx / total) * 100) + '%';
      };

      utter.onend = () => {
        el.classList.remove('tts-reading');
        if (idx === total - 1) stopTTS();
      };

      utter.onerror = () => el.classList.remove('tts-reading');
      utterances.push(utter);
    });

    utterances.forEach(u => window.speechSynthesis.speak(u));
  }

  ttsBtn.addEventListener('click', () => ttsActive ? stopTTS() : startTTS());
  window.addEventListener('beforeunload', stopTTS);

  // ── VLibras ──
  const librasBtn = document.getElementById('libras-btn');

  librasBtn.addEventListener('click', () => {
    const vwBtn = document.querySelector('[vw-access-button]');
    if (vwBtn) {
      vwBtn.click();
      const isActive = librasBtn.classList.toggle('active');
      librasBtn.setAttribute('aria-pressed', isActive);
    }
  });

})();
