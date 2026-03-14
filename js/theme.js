/* ═══════════════════════════════════════
   TEMA — Alternância claro / escuro
          + Nav transparente no topo
   ═══════════════════════════════════════ */

(function () {
  const toggle = document.getElementById('themeToggle');
  const html   = document.documentElement;

  // Restaura preferência salva
  if (localStorage.getItem('theme') === 'light') {
    html.classList.add('light');
    toggle.checked = true;
  }

  toggle.addEventListener('change', () => {
    if (toggle.checked) {
      html.classList.add('light');
      localStorage.setItem('theme', 'light');
    } else {
      html.classList.remove('light');
      localStorage.setItem('theme', 'dark');
    }
  });

  // ── Nav: transparente no topo, fundo ao rolar ──
  const nav = document.getElementById('main-nav');

  function updateNav() {
    nav.classList.toggle('scrolled', window.scrollY > 40);
  }

  window.addEventListener('scroll', updateNav, { passive: true });
  updateNav();
})();
