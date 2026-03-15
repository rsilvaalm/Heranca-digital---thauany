/* ═══════════════════════════════════════
   MODAL TESTAMENTO — Wizard JS
   ═══════════════════════════════════════ */

document.addEventListener('DOMContentLoaded', function () {

  const modal    = document.getElementById('modal-testamento');
  const closeBtn = document.getElementById('modal-close-btn');
  const btnNext  = document.getElementById('modal-btn-next');
  const btnBack  = document.getElementById('modal-btn-back');
  const btnDownloadAgain = document.getElementById('btn-download-again');

  const panels   = [
    document.getElementById('panel-1'),
    document.getElementById('panel-2'),
    document.getElementById('panel-3'),
  ];
  const stepInds = [
    document.getElementById('step-ind-1'),
    document.getElementById('step-ind-2'),
    document.getElementById('step-ind-3'),
  ];

  const erroQ1           = document.getElementById('erro-q1');
  const erroQ2           = document.getElementById('erro-q2');
  const modeloNomeDisplay = document.getElementById('modelo-nome-display');
  const modeloNomeFinal   = document.getElementById('modelo-nome-final');
  const qAutoralGrupo     = document.getElementById('q-autoral-grupo');

  let currentStep = 0;
  let modeloAtual = { nome: '' };
  let lastFormData = null;

  // ── Delegação de evento: captura qualquer botão data-modal="testamento" ──
  document.addEventListener('click', function (e) {
    const btn = e.target.closest('[data-modal="testamento"]');
    if (btn) {
      e.preventDefault();
      abrirModal();
    }
  });

  // ── Fechar ──────────────────────────────────────────────────────
  if (closeBtn) closeBtn.addEventListener('click', fecharModal);
  if (modal)    modal.addEventListener('click', function (e) { if (e.target === modal) fecharModal(); });
  document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && modal.classList.contains('open')) fecharModal(); });

  function abrirModal() {
    if (!modal) return;
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
    irPara(0);
  }

  function fecharModal() {
    modal.classList.remove('open');
    document.body.style.overflow = '';
  }

  // ── Grupo autoral condicional ────────────────────────────────────
  document.querySelectorAll('input[name="objetivo"]').forEach(function (radio) {
    radio.addEventListener('change', function () {
      var val = document.querySelector('input[name="objetivo"]:checked');
      if (qAutoralGrupo) qAutoralGrupo.style.display = (val && val.value === 'obras_autorais') ? 'block' : 'none';
    });
  });

  // ── Navegação ────────────────────────────────────────────────────
  if (btnNext) btnNext.addEventListener('click', avancar);
  if (btnBack) btnBack.addEventListener('click', function () { irPara(currentStep - 1); });
  if (btnDownloadAgain) btnDownloadAgain.addEventListener('click', function () { submeterDados(lastFormData, true); });

  function irPara(idx) {
    panels.forEach(function (p, i) { if (p) p.classList.toggle('active', i === idx); });
    stepInds.forEach(function (s, i) {
      if (!s) return;
      s.classList.remove('active', 'done');
      if (i < idx) s.classList.add('done');
      if (i === idx) s.classList.add('active');
    });

    currentStep = idx;
    if (btnBack) btnBack.style.visibility = idx === 0 ? 'hidden' : 'visible';

    if (idx === 2) {
      if (btnNext) btnNext.style.display = 'none';
      if (btnBack) btnBack.style.visibility = 'hidden';
    } else {
      if (btnNext) {
        btnNext.style.display = 'flex';
        var label = btnNext.querySelector('.btn-label');
        if (label) label.textContent = idx === 1 ? 'Gerar e Baixar PDF' : 'Próximo →';
      }
    }
  }

  // ── Avançar ──────────────────────────────────────────────────────
  function avancar() {
    if (erroQ1) erroQ1.classList.remove('show');
    if (erroQ2) erroQ2.classList.remove('show');

    if (currentStep === 0) {
      if (!validarEtapa1()) return;
      calcularModelo();
      irPara(1);
    } else if (currentStep === 1) {
      if (!validarEtapa2()) return;
      submeterDados(coletarDados(), false);
    }
  }

  // ── Validações ───────────────────────────────────────────────────
  function validarEtapa1() {
    var objetivo = document.querySelector('input[name="objetivo"]:checked');
    if (!objetivo) { if (erroQ1) erroQ1.classList.add('show'); return false; }
    if (objetivo.value === 'obras_autorais') {
      var autoral = document.querySelector('input[name="tipo_autoral"]:checked');
      if (!autoral) { if (erroQ1) erroQ1.classList.add('show'); return false; }
    }
    return true;
  }

  function validarEtapa2() {
    var form = document.getElementById('form-dados');
    if (!form) return true;
    var inputs = form.querySelectorAll('[required]');
    var ok = true;
    inputs.forEach(function (inp) {
      if (!inp.value.trim()) { inp.style.borderColor = '#e05555'; ok = false; }
      else inp.style.borderColor = '';
    });
    if (!ok && erroQ2) erroQ2.classList.add('show');
    return ok;
  }

  // ── Calcular modelo ──────────────────────────────────────────────
  function calcularModelo() {
    var r         = coletarRespostas();
    var modalidade = r.modalidade;
    var objetivo   = r.objetivo;
    var autoral    = r.tipo_autoral;
    var sufixo     = modalidade === 'cerrado' ? ' (Cerrado)' : ' (Particular)';

    var mapa = {
      nao_transmitir:    'Testamento Digital Negativo',
      desaparecimento:   'Testamento para Desaparecimento Virtual',
      memorial:          'Testamento para Transformação de Redes em Memoriais',
      inventariante:     'Testamento Digital para Nomeação de Inventariante Digital',
      acervo_completo:   'Testamento para Transmissão de Acervo Digital Completo',
      pessoa_especifica: 'Testamento para Transmissão de Acervo Digital a Pessoa Específica',
      contas_conjuntas:  'Testamento Digital para Contas Conjuntas ou Compartilhadas',
      valor_economico:   'Testamento Digital para Bens com Valor Econômico',
    };

    var autoralMapa = {
      todas_obras: 'Testamento Digital para Bens Protegidos pelo Direito Autoral',
      ilustracoes:  'Testamento para Ilustrações e Desenhos Digitais',
      fotografias:  'Testamento para Fotografias Digitais',
      textos:       'Testamento para Textos Literários e Semelhantes',
      videos:       'Testamento para Vídeos Protegidos pelos Direitos Autorais',
      software:     'Testamento para Programas de Computador',
      musicas:      'Testamento para Músicas e Composições Digitais',
      pesquisa:     'Testamento para Pesquisa Científica e Acervo de Estudo',
    };

    var nome;
    if (objetivo === 'obras_autorais' && autoral) {
      nome = (autoralMapa[autoral] || 'Testamento Digital') + sufixo;
    } else {
      nome = (mapa[objetivo] || 'Testamento para Transmissão de Acervo Digital Completo') + sufixo;
    }

    modeloAtual.nome = nome;
    if (modeloNomeDisplay) modeloNomeDisplay.textContent = nome;
  }

  // ── Coletar dados ────────────────────────────────────────────────
  function coletarRespostas() {
    var mod = document.querySelector('input[name="modalidade"]:checked');
    var obj = document.querySelector('input[name="objetivo"]:checked');
    var aut = document.querySelector('input[name="tipo_autoral"]:checked');
    return {
      modalidade:   mod ? mod.value : 'particular',
      objetivo:     obj ? obj.value : '',
      tipo_autoral: aut ? aut.value : '',
    };
  }

  function coletarDados() {
    var form = document.getElementById('form-dados');
    var fd   = new FormData(form);
    fd.append('respostas', JSON.stringify(coletarRespostas()));
    return fd;
  }

  // ── Gerar PDF ────────────────────────────────────────────────────
  function submeterDados(fd, redownload) {
    if (!fd) return;
    lastFormData = fd;

    if (btnNext) { btnNext.classList.add('loading'); btnNext.disabled = true; }

    fetch('testamento/gerar_pdf.php', { method: 'POST', body: fd })
      .then(function (response) {
        if (!response.ok) return response.json().then(function (e) { throw new Error(e.erro || 'Erro ao gerar PDF'); });
        var ct = response.headers.get('content-type') || '';
        if (ct.includes('application/pdf')) return response.blob();
        return response.json().then(function (e) { throw new Error(e.erro || 'Erro'); });
      })
      .then(function (blob) {
        var url  = URL.createObjectURL(blob);
        var link = document.createElement('a');
        link.href = url;
        link.download = 'testamento_digital_' + Date.now() + '.pdf';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        URL.revokeObjectURL(url);
        if (modeloNomeFinal) modeloNomeFinal.textContent = modeloAtual.nome;
        if (!redownload) irPara(2);
      })
      .catch(function (err) {
        if (erroQ2) { erroQ2.textContent = 'Erro: ' + err.message; erroQ2.classList.add('show'); }
      })
      .finally(function () {
        if (btnNext) { btnNext.classList.remove('loading'); btnNext.disabled = false; }
      });
  }

}); // DOMContentLoaded
