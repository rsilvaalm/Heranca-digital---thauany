/* ═══════════════════════════════════════
   CARROSSEL — Apresentação do tema
   Slide horizontal · bolinhas · setas
   ═══════════════════════════════════════ */

(function () {
  const track = document.getElementById('carousel-track');
  const dotsWrap = document.getElementById('carousel-dots');
  const prevBtn = document.getElementById('carousel-prev');
  const nextBtn = document.getElementById('carousel-next');
  const curPage = document.getElementById('cur-page');
  const curLabel = document.getElementById('cur-label');

  if (!track) return;

  const slides = track.querySelectorAll('.carousel-slide');
  const total = slides.length;
  let current = 0;

  const labels = [
    'Transformação digital',
    'Desafio jurídico',
    'Lacuna legislativa',
    'Direitos autorais',
    'Proteção legal',
    'Aplicação autoral',
    'Proteção post mortem',
    'Lacuna sucessória',
    'O testamento digital',
    'Este material',
    'Conclusão',
  ];

  // Cria bolinhas
  for (let i = 0; i < total; i++) {
    const d = document.createElement('button');
    d.className = 'dot' + (i === 0 ? ' active' : '');
    d.setAttribute('aria-label', 'Página ' + (i + 1));
    d.addEventListener('click', () => goTo(i));
    dotsWrap.appendChild(d);
  }

  function goTo(idx) {
    current = Math.max(0, Math.min(idx, total - 1));

    // Desliza
    track.style.transform = `translateX(-${current * 100}%)`;

    // Bolinhas
    dotsWrap.querySelectorAll('.dot').forEach((d, i) =>
      d.classList.toggle('active', i === current)
    );

    // Meta
    if (curPage) curPage.textContent = current + 1;
    if (curLabel) curLabel.textContent = labels[current] ?? '';

    // Setas
    prevBtn.disabled = current === 0;
    nextBtn.disabled = current === total - 1;

    // Scroll suave até o topo da seção
    /* const section = document.getElementById('apresentacao');
    if (section) {
      const top = section.getBoundingClientRect().top + window.scrollY - 80;
      window.scrollTo({ top, behavior: 'smooth' });
    } */
  }

  prevBtn.addEventListener('click', () => goTo(current - 1));
  nextBtn.addEventListener('click', () => goTo(current + 1));

  // Suporte a teclado quando o carrossel está em foco
  document.addEventListener('keydown', (e) => {
    const inSection = document.getElementById('apresentacao')
      ?.contains(document.activeElement);
    if (!inSection) return;
    if (e.key === 'ArrowRight') goTo(current + 1);
    if (e.key === 'ArrowLeft') goTo(current - 1);
  });

  // Swipe touch
  let touchStartX = 0;
  track.addEventListener('touchstart', (e) => {
    touchStartX = e.touches[0].clientX;
  }, { passive: true });

  track.addEventListener('touchend', (e) => {
    const diff = touchStartX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) goTo(diff > 0 ? current + 1 : current - 1);
  }, { passive: true });

  goTo(0);
})();
