<?php /* ── MODAL TESTAMENTO ── */ ?>

<div id="modal-testamento" role="dialog" aria-modal="true" aria-labelledby="modal-titulo">

  <div class="modal-box">

    <!-- Fechar -->
    <button class="modal-close" id="modal-close-btn" aria-label="Fechar">&times;</button>

    <!-- Header -->
    <div class="modal-header">
      <h3 id="modal-titulo">Testamento Digital</h3>
      <p>Responda as perguntas abaixo para identificar o modelo ideal para você</p>
    </div>

    <!-- Steps -->
    <div class="modal-steps" aria-label="Etapas">
      <div class="modal-step active" id="step-ind-1">
        <div class="step-num">1</div>
        <span class="step-label">Questionário</span>
      </div>
      <div class="modal-step" id="step-ind-2">
        <div class="step-num">2</div>
        <span class="step-label">Seus dados</span>
      </div>
      <div class="modal-step" id="step-ind-3">
        <div class="step-num">3</div>
        <span class="step-label">Download</span>
      </div>
    </div>

    <!-- ── ETAPA 1: Questionário ── -->
    <div class="modal-body">
      <div class="modal-panel active" id="panel-1">

        <!-- Q1: Modalidade -->
        <div class="q-group">
          <label class="q-label">1. Qual modalidade de testamento você deseja?</label>
          <div class="q-options">
            <div class="q-option">
              <input type="radio" name="modalidade" id="mod-particular" value="particular" checked>
              <label for="mod-particular">
                <span class="q-dot"></span>
                <span><strong>Particular</strong> — Escrito e assinado pelo testador na presença de 3 testemunhas</span>
              </label>
            </div>
            <div class="q-option">
              <input type="radio" name="modalidade" id="mod-cerrado" value="cerrado">
              <label for="mod-cerrado">
                <span class="q-dot"></span>
                <span><strong>Cerrado</strong> — Conteúdo sigiloso, aprovado por tabelião em cartório</span>
              </label>
            </div>
          </div>
        </div>

        <!-- Q2: Objetivo principal -->
        <div class="q-group">
          <label class="q-label">2. Qual é o seu principal objetivo em relação aos seus bens digitais após a morte?</label>
          <div class="q-options" id="q-objetivo">
            <div class="q-option">
              <input type="radio" name="objetivo" id="obj-nao" value="nao_transmitir">
              <label for="obj-nao"><span class="q-dot"></span>Não desejo transmitir bens digitais</label>
            </div>
            <div class="q-option">
              <input type="radio" name="objetivo" id="obj-desap" value="desaparecimento">
              <label for="obj-desap"><span class="q-dot"></span>Quero apagar contas, perfis e rastros digitais (desaparecimento virtual)</label>
            </div>
            <div class="q-option">
              <input type="radio" name="objetivo" id="obj-memorial" value="memorial">
              <label for="obj-memorial"><span class="q-dot"></span>Transformar minhas redes sociais em páginas memoriais</label>
            </div>
            <div class="q-option">
              <input type="radio" name="objetivo" id="obj-economico" value="valor_economico">
              <label for="obj-economico"><span class="q-dot"></span>Transmitir bens digitais com valor econômico aos herdeiros</label>
            </div>
            <div class="q-option">
              <input type="radio" name="objetivo" id="obj-completo" value="acervo_completo">
              <label for="obj-completo"><span class="q-dot"></span>Transmitir todo o meu acervo digital (com e sem valor econômico)</label>
            </div>
            <div class="q-option">
              <input type="radio" name="objetivo" id="obj-pessoa" value="pessoa_especifica">
              <label for="obj-pessoa"><span class="q-dot"></span>Deixar meus bens digitais para uma pessoa específica</label>
            </div>
            <div class="q-option">
              <input type="radio" name="objetivo" id="obj-conjunta" value="contas_conjuntas">
              <label for="obj-conjunta"><span class="q-dot"></span>Regular contas digitais usadas em conjunto com outra pessoa</label>
            </div>
            <div class="q-option">
              <input type="radio" name="objetivo" id="obj-autoral" value="obras_autorais">
              <label for="obj-autoral"><span class="q-dot"></span>Dispor sobre criações intelectuais protegidas por direito autoral</label>
            </div>
            <div class="q-option">
              <input type="radio" name="objetivo" id="obj-inventariante" value="inventariante">
              <label for="obj-inventariante"><span class="q-dot"></span>Nomear inventariante digital para administrar meus bens</label>
            </div>
          </div>
        </div>

        <!-- Q3: Tipo de obra autoral (aparece condicionalmente) -->
        <div class="q-group" id="q-autoral-grupo" style="display:none">
          <label class="q-label">3. Que tipo de obra autoral digital você possui?</label>
          <span class="q-sublabel">Escolha a que melhor descreve seu principal acervo. Para múltiplas, escolha a de maior valor para você.</span>
          <div class="q-options">
            <div class="q-option">
              <input type="radio" name="tipo_autoral" id="aut-todas" value="todas_obras">
              <label for="aut-todas"><span class="q-dot"></span>Várias obras diferentes — quero um único instrumento para todas</label>
            </div>
            <div class="q-option">
              <input type="radio" name="tipo_autoral" id="aut-ilustra" value="ilustracoes">
              <label for="aut-ilustra"><span class="q-dot"></span>Ilustrações, artes visuais e desenhos digitais</label>
            </div>
            <div class="q-option">
              <input type="radio" name="tipo_autoral" id="aut-foto" value="fotografias">
              <label for="aut-foto"><span class="q-dot"></span>Fotografias digitais autorais</label>
            </div>
            <div class="q-option">
              <input type="radio" name="tipo_autoral" id="aut-texto" value="textos">
              <label for="aut-texto"><span class="q-dot"></span>Textos literários, artigos, livros, roteiros, coreografias</label>
            </div>
            <div class="q-option">
              <input type="radio" name="tipo_autoral" id="aut-video" value="videos">
              <label for="aut-video"><span class="q-dot"></span>Vídeos, obras audiovisuais, animações</label>
            </div>
            <div class="q-option">
              <input type="radio" name="tipo_autoral" id="aut-soft" value="software">
              <label for="aut-soft"><span class="q-dot"></span>Programas de computador, código-fonte, aplicativos</label>
            </div>
            <div class="q-option">
              <input type="radio" name="tipo_autoral" id="aut-mus" value="musicas">
              <label for="aut-mus"><span class="q-dot"></span>Músicas, composições e obras musicais</label>
            </div>
            <div class="q-option">
              <input type="radio" name="tipo_autoral" id="aut-pesq" value="pesquisa">
              <label for="aut-pesq"><span class="q-dot"></span>Pesquisas científicas, acervo acadêmico, banco de dados</label>
            </div>
          </div>
        </div>

        <div class="modal-erro" id="erro-q1">Por favor, responda todas as perguntas antes de continuar.</div>

      </div><!-- /panel-1 -->

      <!-- ── ETAPA 2: Dados pessoais ── -->
      <div class="modal-panel" id="panel-2">

        <div class="modelo-resultado" id="modelo-sugerido">
          <div class="modelo-resultado-label">Modelo recomendado</div>
          <div class="modelo-resultado-nome" id="modelo-nome-display">—</div>
          <div class="modelo-resultado-desc">Preencha seus dados para gerar o documento com suas informações.</div>
        </div>

        <div class="modal-erro" id="erro-q2">Preencha todos os campos obrigatórios.</div>

        <form id="form-dados" novalidate>
          <div class="form-grid">

            <div class="form-group full">
              <label class="form-label" for="f-nome">Nome completo *</label>
              <input class="form-input" type="text" id="f-nome" name="nome" placeholder="Como consta no documento oficial" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="f-nac">Nacionalidade *</label>
              <input class="form-input" type="text" id="f-nac" name="nacionalidade" placeholder="Ex: brasileiro(a)" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="f-ec">Estado civil *</label>
              <select class="form-input" id="f-ec" name="estado_civil" required>
                <option value="">Selecione...</option>
                <option>solteiro(a)</option>
                <option>casado(a)</option>
                <option>divorciado(a)</option>
                <option>viúvo(a)</option>
                <option>união estável</option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label" for="f-prof">Profissão *</label>
              <input class="form-input" type="text" id="f-prof" name="profissao" placeholder="Ex: advogado(a)" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="f-cpf">CPF *</label>
              <input class="form-input" type="text" id="f-cpf" name="cpf" placeholder="000.000.000-00" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="f-rg">RG *</label>
              <input class="form-input" type="text" id="f-rg" name="rg" placeholder="00.000.000-0" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="f-nasc">Data de nascimento *</label>
              <input class="form-input" type="date" id="f-nasc" name="data_nascimento" required>
            </div>

            <div class="form-group">
              <label class="form-label" for="f-tel">Telefone *</label>
              <input class="form-input" type="tel" id="f-tel" name="telefone" placeholder="(00) 00000-0000" required>
            </div>

            <div class="form-group full">
              <label class="form-label" for="f-fil">Filiação (nome dos pais) *</label>
              <input class="form-input" type="text" id="f-fil" name="filiacao" placeholder="Nome do pai e nome da mãe" required>
            </div>

            <div class="form-group full">
              <label class="form-label" for="f-end">Endereço de domicílio *</label>
              <input class="form-input" type="text" id="f-end" name="endereco" placeholder="Rua, número, bairro, cidade – UF, CEP" required>
            </div>

            <div class="form-group full">
              <label class="form-label" for="f-email">E-mail *</label>
              <input class="form-input" type="email" id="f-email" name="email" placeholder="seu@email.com" required>
            </div>

          </div>
        </form>

      </div><!-- /panel-2 -->

      <!-- ── ETAPA 3: Download / Sucesso ── -->
      <div class="modal-panel" id="panel-3">

        <div style="text-align:center; padding: 20px 0 8px;">
          <div style="font-size:3rem; margin-bottom:16px;">✓</div>
          <h4 style="font-family:'Cormorant Garamond',serif; font-size:1.4rem; font-weight:300; color:var(--fg); margin-bottom:12px;">
            Documento gerado com sucesso!
          </h4>
          <p style="font-size:0.85rem; color:var(--fg-muted); line-height:1.7; margin-bottom:24px; max-width:400px; margin-left:auto; margin-right:auto;">
            Seu testamento orientativo foi gerado e o download iniciará automaticamente. Lembre-se: este documento deve ser revisado por um advogado habilitado antes de ser assinado.
          </p>
          <div class="modelo-resultado" style="text-align:left; margin-bottom:20px;">
            <div class="modelo-resultado-label">Modelo gerado</div>
            <div class="modelo-resultado-nome" id="modelo-nome-final">—</div>
          </div>
          <button class="btn-modal-next" id="btn-download-again" style="margin:0 auto;">
            <span class="btn-label">⬇ Baixar novamente</span>
          </button>
        </div>

      </div><!-- /panel-3 -->

    </div><!-- /modal-body -->

    <!-- Footer -->
    <div class="modal-footer">
      <button class="btn-modal-back" id="modal-btn-back" style="visibility:hidden">
        ← Anterior
      </button>
      <button class="btn-modal-next" id="modal-btn-next">
        <span class="btn-label">Próximo →</span>
        <span class="btn-spinner"></span>
      </button>
    </div>

  </div><!-- /modal-box -->
</div><!-- /modal-testamento -->
