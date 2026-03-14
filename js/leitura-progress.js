/* ═══════════════════════════════════════
   LEITURA — Barra de progresso da seção
             de apresentação do tema
   ═══════════════════════════════════════ */

(function () {
  const bar     = document.getElementById('leitura-progress');
  const section = document.getElementById('apresentacao');
  if (!bar || !section) return;

  function update() {
    const rect  = section.getBoundingClientRect();
    const total = section.offsetHeight - window.innerHeight;
    const scrolled = -rect.top;

    if (scrolled <= 0 || total <= 0) {
      bar.style.width = '0%';
      bar.classList.remove('active');
      return;
    }

    if (scrolled >= total) {
      bar.style.width = '100%';
      return;
    }

    bar.classList.add('active');
    bar.style.width = Math.min(100, (scrolled / total) * 100) + '%';
  }

  window.addEventListener('scroll', update, { passive: true });
  update();
})();
