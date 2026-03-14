/* ═══════════════════════════════════════
   FAQ — Accordion
   ═══════════════════════════════════════ */

function toggleFaq(el) {
  const answer = el.querySelector('.faq-answer');
  const isOpen = el.classList.contains('open');

  // Fecha todos
  document.querySelectorAll('.faq-item').forEach(item => {
    item.classList.remove('open');
    item.querySelector('.faq-answer').classList.remove('open');
  });

  // Abre o clicado (se estava fechado)
  if (!isOpen) {
    el.classList.add('open');
    answer.classList.add('open');
  }
}
