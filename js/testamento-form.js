/* ═══════════════════════════════════════
   TESTAMENTO — Modal + Formulário
   Inclui etapa de dados pessoais antes
   do resultado e POST para gerar_pdf.php
   ═══════════════════════════════════════ */

(function () {

  // ── MODAL ───────────────────────────
  window.tfModalOpen = function () {
    const overlay = document.getElementById('tf-modal');
    overlay.classList.add('open');
    overlay.setAttribute('aria-hidden', 'false');
    document.body.classList.add('tf-modal-open');
  };

  window.tfModalClose = function () {
    const overlay = document.getElementById('tf-modal');
    overlay.classList.remove('open');
    overlay.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('tf-modal-open');
  };

  window.tfOverlayClick = function (e) {
    if (e.target === document.getElementById('tf-modal')) tfModalClose();
  };

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') tfModalClose();
  });

  // ── ESTADO ──────────────────────────
  const A    = {};   // respostas do questionário
  const hist = [1];
  let cur    = 1;

  const KEY = {
    1:'modal', 2:'obj',
    3:'excl_acesso', 4:'excl_contas', 5:'desaparecer',
    6:'tem_econ', 7:'gera_renda', 8:'transf_econ',
    9:'pat_total', 10:'unico',
    11:'p_esp', 12:'resp_p',
    13:'conj', 14:'divide',
    15:'cria', 16:'autoria', 17:'adm_obras', 18:'obras_unico',
    19:'ilu', 20:'foto', 21:'texto', 22:'vid', 23:'soft', 24:'mus', 25:'pesq',
    26:'inv', 27:'inv_resp',
    28:'mem', 29:'mem_adm'
  };

  // ── SELECIONAR OPÇÃO ────────────────
  window.tfPick = function (el, key, val) {
    el.closest('.tf-opts').querySelectorAll('.tf-opt').forEach(o => o.classList.remove('sel'));
    el.classList.add('sel');
    A[key] = val;
    const e = document.getElementById('tf-e' + cur);
    if (e) e.classList.remove('show');
  };

  // ── AVANÇAR ─────────────────────────
  window.tfAdv = function (from) {
    const key = KEY[from];
    if (key && !A[key]) { document.getElementById('tf-e' + from).classList.add('show'); return; }
    const nx = tfNext(from);
    if (nx === 'dados') { tfShowDados(); return; }
    hist.push(nx);
    tfShowStep(nx);
  };

  // ── VOLTAR ──────────────────────────
  window.tfBack = function () {
    if (hist.length <= 1) return;
    hist.pop();
    tfShowStep(hist[hist.length - 1]);
  };

  // ── MOSTRAR PASSO ───────────────────
  function tfShowStep(n) {
    document.querySelectorAll('.tf-step').forEach(s => s.classList.remove('active'));
    const el = document.getElementById('tf-s' + n);
    if (el) el.classList.add('active');
    cur = n;
    const pct = Math.min(90, Math.round((hist.length / 14) * 90));
    const fill = document.getElementById('tf-prog-fill');
    const lbl  = document.getElementById('tf-prog-lbl');
    if (fill) fill.style.width = pct + '%';
    if (lbl)  lbl.textContent  = 'Pergunta ' + n;
    const body = document.getElementById('tf-body');
    if (body) body.scrollTop = 0;
  }

  // ── LÓGICA DE PRÓXIMO PASSO ─────────
  function tfNext(f) {
    if (f === 1) return 2;
    if (f === 2) {
      const o = A.obj;
      if (o === 'nao_transmitir') return 3;
      if (o === 'apagar')         return 3;
      if (o === 'memorial')       return 28;
      if (o === 'economico')      return 6;
      if (o === 'completo')       return 9;
      if (o === 'pessoa_esp')     return 11;
      if (o === 'conjunto')       return 13;
      if (o === 'autoral')        return 15;
      if (o === 'inventariante')  return 26;
      if (o === 'fotos')          return 20;
      if (o === 'ilustracoes')    return 19;
      if (o === 'textos')         return 21;
      if (o === 'videos')         return 22;
      if (o === 'software')       return 23;
      if (o === 'musica')         return 24;
      if (o === 'pesquisa')       return 25;
      return 3;
    }
    if (f === 3) return 4;
    if (f === 4) return 5;
    if (f === 5) {
      if (A.desaparecer === 'sim')                             return 'dados';
      if (A.excl_acesso === 'sim' || A.excl_contas === 'sim') return 'dados';
      return 6;
    }
    if (f === 6)  return A.tem_econ === 'nao' ? 9 : 7;
    if (f === 7)  return 8;
    if (f === 8)  return A.transf_econ === 'sim' ? 'dados' : 9;
    if (f === 9) {
      if (A.pat_total === 'nenhum')  return 'dados';
      if (A.pat_total === 'so_econ') return 'dados';
      return 10;
    }
    if (f === 10) return A.unico === 'sim' ? 'dados' : 11;
    if (f === 11) return A.p_esp  === 'nao' ? 13 : 12;
    if (f === 12) return A.resp_p === 'sim' ? 'dados' : 13;
    if (f === 13) return A.conj   === 'nao' ? 15 : 14;
    if (f === 14) return A.divide === 'sim' ? 'dados' : 15;
    if (f === 15) return A.cria    === 'nao' ? 26 : 16;
    if (f === 16) return A.autoria === 'nao' ? 26 : 17;
    if (f === 17) return 18;
    if (f === 18) return A.obras_unico === 'sim' ? 'dados' : 19;
    if (f === 19) return A.ilu   === 'sim' ? 'dados' : 20;
    if (f === 20) return A.foto  === 'sim' ? 'dados' : 21;
    if (f === 21) return A.texto === 'sim' ? 'dados' : 22;
    if (f === 22) return A.vid   === 'sim' ? 'dados' : 23;
    if (f === 23) return A.soft  === 'sim' ? 'dados' : 24;
    if (f === 24) return A.mus   === 'sim' ? 'dados' : 25;
    if (f === 25) return A.pesq  === 'sim' ? 'dados' : 26;
    if (f === 26) return A.inv      === 'nao' ? 28 : 27;
    if (f === 27) return A.inv_resp === 'sim' ? 'dados' : 28;
    if (f === 28) return A.mem === 'nao' ? 'dados' : 29;
    if (f === 29) return 'dados';
    return 'dados';
  }

  // ── ETAPA DE DADOS PESSOAIS ─────────
  function tfShowDados() {
    document.querySelectorAll('.tf-step').forEach(s => s.classList.remove('active'));
    const el = document.getElementById('tf-dados');
    if (el) el.classList.add('active');
    cur = 'dados';
    const fill = document.getElementById('tf-prog-fill');
    const lbl  = document.getElementById('tf-prog-lbl');
    if (fill) fill.style.width = '94%';
    if (lbl)  lbl.textContent  = 'Seus dados';
    const body = document.getElementById('tf-body');
    if (body) body.scrollTop = 0;
  }

  // ── VOLTAR DOS DADOS ────────────────
  window.tfBackDados = function () {
    document.getElementById('tf-dados').classList.remove('active');
    tfShowStep(hist[hist.length - 1]);
  };

  // ── VALIDAÇÃO DOS DADOS ─────────────
  window.tfSubmitDados = function () {
    const campos = [
      'tf-nome', 'tf-nacionalidade', 'tf-estado_civil', 'tf-profissao',
      'tf-cpf', 'tf-rg', 'tf-data_nascimento', 'tf-filiacao',
      'tf-endereco', 'tf-email', 'tf-telefone'
    ];

    let ok = true;
    campos.forEach(id => {
      const el = document.getElementById(id);
      const err = document.getElementById(id + '-err');
      if (!el) return;
      if (!el.value.trim()) {
        el.classList.add('tf-field-err');
        if (err) err.classList.add('show');
        ok = false;
      } else {
        el.classList.remove('tf-field-err');
        if (err) err.classList.remove('show');
      }
    });

    // Valida e-mail
    const emailEl = document.getElementById('tf-email');
    if (emailEl && emailEl.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailEl.value)) {
      emailEl.classList.add('tf-field-err');
      const err = document.getElementById('tf-email-err');
      if (err) { err.textContent = 'E-mail inválido.'; err.classList.add('show'); }
      ok = false;
    }

    if (!ok) return;

    // Dados válidos → vai para a tela de resultado
    tfShowResultado();
  };

  // ── ENVIO DO FORMULÁRIO ─────────────
  function tfEnviarFormulario() {
    const btn = document.getElementById('tf-btn-submit');
    if (btn) { btn.disabled = true; btn.textContent = 'Gerando PDF...'; }

    // Monta os dados
    const dados = new FormData();
    dados.append('nome',            document.getElementById('tf-nome').value.trim());
    dados.append('nacionalidade',   document.getElementById('tf-nacionalidade').value.trim());
    dados.append('estado_civil',    document.getElementById('tf-estado_civil').value.trim());
    dados.append('profissao',       document.getElementById('tf-profissao').value.trim());
    dados.append('cpf',             document.getElementById('tf-cpf').value.trim());
    dados.append('rg',              document.getElementById('tf-rg').value.trim());
    dados.append('data_nascimento', document.getElementById('tf-data_nascimento').value.trim());
    dados.append('filiacao',        document.getElementById('tf-filiacao').value.trim());
    dados.append('endereco',        document.getElementById('tf-endereco').value.trim());
    dados.append('email',           document.getElementById('tf-email').value.trim());
    dados.append('telefone',        document.getElementById('tf-telefone').value.trim());

    // Passa todas as respostas do questionário como JSON
    // Inclui o tipo resolvido para que o PHP não precise recalcular
    dados.append('respostas', JSON.stringify(A));

    const svgDownload = '<svg width="15" height="15" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M7 1v8M4 6l3 3 3-3M2 11h10"/></svg>';

    // Faz o POST — o PHP retorna o PDF binário para download
    fetch('testamento/gerar_pdf.php', {
      method: 'POST',
      body: dados
    })
    .then(res => {
      if (!res.ok) {
        return res.text().then(t => { throw new Error(t); });
      }
      // Pega o nome do arquivo do header Content-Disposition
      const cd = res.headers.get('Content-Disposition') || '';
      const match = cd.match(/filename="?([^"]+)"?/);
      const filename = match ? match[1] : 'testamento.pdf';
      return res.blob().then(blob => ({ blob, filename }));
    })
    .then(({ blob, filename }) => {
      // Força download no navegador
      const url  = URL.createObjectURL(blob);
      const link = document.createElement('a');
      link.href     = url;
      link.download = filename;
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
      URL.revokeObjectURL(url);

      // Reativa botão após download
      const btn = document.getElementById('tf-btn-download');
      if (btn) { btn.disabled = false; btn.innerHTML = svgDownload + ' Baixar Testamento'; }
    })
    .catch(err => {
      console.error('Erro ao gerar PDF:', err);
      const errEl = document.getElementById('tf-download-err');
      if (errEl) {
        errEl.textContent = 'Erro ao gerar o PDF. Tente novamente.';
        errEl.classList.add('show');
      }
      const btn = document.getElementById('tf-btn-download');
      if (btn) { btn.disabled = false; btn.innerHTML = svgDownload + ' Baixar Testamento'; }
    });
  }


  // ── DESCRIÇÕES DOS RESULTADOS ────────
  const INFO = {
    negativo:     { title:'Testamento Digital <em>Negativo</em>', desc:'Você optou por não transmitir seus bens digitais ou por impedir o acesso de terceiros ao seu acervo digital. Este modelo estabelece expressamente a vedação de acesso e a não transmissão dos bens digitais após a morte, preservando sua privacidade e intimidade.' },
    desaparecer:  { title:'Testamento para <em>"Desaparecimento Virtual"</em>', desc:'Indicado para quem deseja a eliminação ampla da sua presença digital após a morte — incluindo redes sociais, contas e serviços online. Proporciona o encerramento definitivo da identidade digital do titular.' },
    economico:    { title:'Testamento para Bens Digitais com <em>Valor Econômico</em>', desc:'Indicado para quem possui ativos digitais que geram renda ou podem ser convertidos em dinheiro — como criptomoedas, canais monetizados, domínios de sites, lojas virtuais, milhas aéreas e outros ativos de plataformas digitais.' },
    completo:     { title:'Testamento para <em>Acervo Digital Completo</em>', desc:'Adequado para quem deseja organizar a transmissão de todo o patrimônio digital em um único instrumento, abrangendo arquivos pessoais, contas, documentos, mídias, acessos e bens com e sem valor econômico.' },
    pessoa:       { title:'Testamento para Transmissão de Acervo Digital a <em>Pessoa Específica</em>', desc:'Indicado para quem deseja designar uma pessoa específica para receber e administrar perfis de redes sociais, arquivos, obras intelectuais, contas ou coleções digitais após a morte.' },
    conjunto:     { title:'Testamento Digital para <em>Contas Conjuntas ou Compartilhadas</em>', desc:'Adequado para quem possui contas ou ativos digitais utilizados em conjunto com outra pessoa — como streaming familiar, e-mail empresarial compartilhado ou redes sociais co-administradas.' },
    autoral:      { title:'Testamento Digital para Bens Protegidos pelo <em>Direito Autoral</em>', desc:'Indicado para quem possui obras intelectuais diversas armazenadas em meio digital e deseja dispor sobre sua transmissão, administração e exploração econômica pelos herdeiros em um único instrumento.' },
    ilustracoes:  { title:'Testamento para <em>Ilustrações e Desenhos Digitais</em>', desc:'Específico para quem possui artes visuais, ilustrações, desenhos digitais ou obras gráficas de sua autoria e deseja regular sua transmissão aos herdeiros ou legatários com proteção autoral.' },
    fotografias:  { title:'Testamento para <em>Fotografias Digitais Autorais</em>', desc:'Destinado a fotógrafos e autores de imagens digitais que desejam proteger e transmitir suas fotografias autorais com segurança jurídica aos seus herdeiros ou legatários.' },
    textos:       { title:'Testamento para <em>Textos Literários, Artísticos ou Científicos</em>', desc:'Adequado para escritores, pesquisadores e acadêmicos que possuem textos literários, artigos, compilações, enciclopédias, dicionários, coreografias digitais ou materiais similares e desejam transmiti-los com proteção autoral.' },
    videos:       { title:'Testamento para <em>Vídeos Digitais Autorais</em>', desc:'Indicado para criadores de conteúdo, cineastas e educadores que possuem vídeos autorais — aulas, documentários, produções artísticas ou vídeos para internet — e desejam transmiti-los com segurança jurídica.' },
    software:     { title:'Testamento para <em>Programa de Computador — Código-Fonte</em>', desc:'Específico para desenvolvedores e autores de software, aplicativos, sistemas e programas de computador que desejam transmitir seu código-fonte aos herdeiros ou legatários com proteção legal.' },
    musicas:      { title:'Testamento para <em>Músicas e Composições Digitais</em>', desc:'Destinado a músicos, compositores e autores de obras musicais digitais — letras, partituras, fonogramas e composições — que desejam transmiti-las com proteção do direito autoral.' },
    pesquisa:     { title:'Testamento para <em>Pesquisa Científica e Acervo de Estudo</em>', desc:'Indicado para pesquisadores e acadêmicos que possuem banco de dados, fichamentos, anotações, cadernos digitais ou acervos acadêmicos e desejam transmiti-los a herdeiros ou fazer doações a instituições de ensino.' },
    inventariante:{ title:'Testamento para Nomeação de <em>Inventariante Digital</em>', desc:'Indicado para quem deseja nomear uma pessoa especialista em tecnologia para administrar, acessar, organizar e dar destino ao acervo digital após a morte, atuando como responsável principal pela execução das disposições digitais.' },
    memorial:     { title:'Testamento para <em>Transformação de Redes Digitais em Memoriais</em>', desc:'Adequado para quem deseja que suas redes sociais, perfis ou páginas permaneçam ativos como memorial após a morte, com a indicação de pessoa responsável pela administração do espaço digital em memória.' }
  };

  // ── RESOLVER TIPO (espelho do PHP) ───
  // ── TELA DE RESULTADO (após dados) ──
  function tfShowResultado() {
    const type = _resolveType();

    // Preenche título e descrição
    const info = INFO[type];
    if (info) {
      const t = document.getElementById('tf-r-title');
      const d = document.getElementById('tf-r-desc');
      if (t) t.innerHTML  = info.title;
      if (d) d.textContent = info.desc;
    }

    // Esconde etapa de dados, mostra resultado
    document.getElementById('tf-dados').classList.remove('active');
    const fill = document.getElementById('tf-prog-fill');
    const lbl  = document.getElementById('tf-prog-lbl');
    const progWrap = document.getElementById('tf-prog-wrap');
    if (fill) fill.style.width = '100%';
    if (lbl)  lbl.textContent  = 'Concluído';
    if (progWrap) progWrap.style.display = 'none';
    const result = document.getElementById('tf-result');
    if (result) result.style.display = 'block';
    const body = document.getElementById('tf-body');
    if (body) body.scrollTop = 0;
  }

  // ── DOWNLOAD (chamado pelo botão na tela de resultado) ──
  window.tfDownload = function () {
    const btn = document.getElementById('tf-btn-download');
    if (btn) { btn.disabled = true; btn.textContent = 'Gerando PDF...'; }
    const errEl = document.getElementById('tf-download-err');
    if (errEl) errEl.classList.remove('show');

    tfEnviarFormulario();
  };

  // ── RESOLVE TIPO ATUAL ──────────────
  function _resolveType() {
    const o = A.obj;
    if (o === 'memorial')    return 'memorial';
    if (o === 'fotos')       return 'fotografias';
    if (o === 'ilustracoes') return 'ilustracoes';
    if (o === 'textos')      return 'textos';
    if (o === 'videos')      return 'videos';
    if (o === 'software')    return 'software';
    if (o === 'musica')      return 'musicas';
    if (o === 'pesquisa')    return 'pesquisa';
    if (A.desaparecer === 'sim')                            return 'desaparecer';
    if (A.excl_acesso === 'sim' || A.excl_contas === 'sim') return 'negativo';
    if (A.transf_econ === 'sim')   return 'economico';
    if (A.transf_econ === 'nao')   return 'negativo';
    if (A.pat_total === 'nenhum')  return 'negativo';
    if (A.pat_total === 'so_econ') return 'economico';
    if (A.unico === 'sim')         return 'completo';
    if (A.resp_p === 'sim')        return 'pessoa';
    if (A.divide === 'sim')        return 'conjunto';
    if (A.obras_unico === 'sim')   return 'autoral';
    if (A.ilu   === 'sim') return 'ilustracoes';
    if (A.foto  === 'sim') return 'fotografias';
    if (A.texto === 'sim') return 'textos';
    if (A.vid   === 'sim') return 'videos';
    if (A.soft  === 'sim') return 'software';
    if (A.mus   === 'sim') return 'musicas';
    if (A.pesq  === 'sim') return 'pesquisa';
    if (A.inv_resp === 'sim') return 'inventariante';
    if (A.mem === 'sim')   return 'memorial';
    return 'negativo';
  }

  // ── REINICIAR ───────────────────────
  window.tfRestart = function () {
    Object.keys(A).forEach(k => delete A[k]);
    hist.length = 0; hist.push(1);
    document.querySelectorAll('.tf-opt').forEach(o => o.classList.remove('sel'));
    document.querySelectorAll('.tf-err').forEach(e => e.classList.remove('show'));
    document.querySelectorAll('.tf-field-err').forEach(e => e.classList.remove('tf-field-err'));
    // Limpa campos
    document.querySelectorAll('#tf-dados input, #tf-dados select').forEach(el => el.value = '');
    const btnS = document.getElementById('tf-btn-submit');
    if (btnS) { btnS.disabled = false; btnS.textContent = 'Próximo →'; }
    const btnD = document.getElementById('tf-btn-download');
    if (btnD) { btnD.disabled = false; btnD.textContent = 'Baixar Testamento'; }
    const result = document.getElementById('tf-result');
    if (result) result.style.display = 'none';
    const dados = document.getElementById('tf-dados');
    if (dados) dados.classList.remove('active');
    const progWrap = document.getElementById('tf-prog-wrap');
    if (progWrap) { progWrap.style.display = 'block'; }
    const fill = document.getElementById('tf-prog-fill');
    if (fill) fill.style.width = '4%';
    const lbl = document.getElementById('tf-prog-lbl');
    if (lbl) lbl.textContent = 'Pergunta 1';
    tfShowStep(1);
  };

  // ── MÁSCARA CPF ─────────────────────
  window.tfMascaraCpf = function (el) {
    let v = el.value.replace(/\D/g, '').slice(0, 11);
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    el.value = v;
  };

  // ── MÁSCARA TELEFONE ────────────────
  window.tfMascaraTel = function (el) {
    let v = el.value.replace(/\D/g, '').slice(0, 11);
    if (v.length <= 10) {
      v = v.replace(/(\d{2})(\d)/, '($1) $2');
      v = v.replace(/(\d{4})(\d)/, '$1-$2');
    } else {
      v = v.replace(/(\d{2})(\d)/, '($1) $2');
      v = v.replace(/(\d{5})(\d)/, '$1-$2');
    }
    el.value = v;
  };

})();
