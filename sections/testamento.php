<?php /* ── TESTAMENTO ── */ ?>
<section id="testamento">
  <div class="section-label"><span>Baixe seu Testamento</span></div>
  <div class="testamento-box fade-up">
    <h2>Proteja seu legado <em>digital</em> agora</h2>
    <p>Responda algumas perguntas e descubra qual modelo de testamento digital é ideal para a sua situação.</p>
    <div class="testamento-cta">
      <button class="btn-primary" onclick="tfModalOpen()">Encontrar meu modelo</button>
      <a href="#sobre" class="btn-outline">Saiba mais</a>
    </div>
  </div>
</section>

<!-- ══════════════════════════════════════
     MODAL — Formulário de Testamento Digital
══════════════════════════════════════ -->
<div id="tf-modal" class="tf-overlay" aria-hidden="true" onclick="tfOverlayClick(event)">
  <div class="tf-box" role="dialog" aria-modal="true" aria-label="Formulário de Testamento Digital">

    <!-- Cabeçalho fixo -->
    <div class="tf-header">
      <div class="tf-header-left">
        <div class="tf-tag">Herança Digital</div>
        <h2 class="tf-title">Encontre o seu <em>Testamento Digital</em></h2>
      </div>
      <button class="tf-close" onclick="tfModalClose()" aria-label="Fechar modal">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round">
          <path d="M2 2l14 14M16 2L2 16"/>
        </svg>
      </button>
    </div>

    <!-- Progress -->
    <div class="tf-prog-wrap" id="tf-prog-wrap">
      <div class="tf-prog-info">
        <span>Progresso</span>
        <span id="tf-prog-lbl">Pergunta 1</span>
      </div>
      <div class="tf-prog-bar"><div class="tf-prog-fill" id="tf-prog-fill"></div></div>
    </div>

    <!-- Corpo rolável -->
    <div class="tf-body" id="tf-body">

      <!-- P1 · MODALIDADE -->
      <div class="tf-step active" id="tf-s1">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 01 · Modalidade</div>
          <h3>Você deseja realizar o testamento de bens digitais na modalidade particular ou cerrado?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'modal','particular')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Testamento Particular</strong><div class="tf-osub">Modelos 1, 3, 4, 5, 6, 7, 8, 10, 11, 12, 13, 14, 15, 16, 17 e 18</div></div></button>
            <button class="tf-opt" onclick="tfPick(this,'modal','cerrado')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Testamento Cerrado</strong><div class="tf-osub">Modelos 2, 3.2, 4.2, 5.2, 6.2, 7.2, 9, 10.2, 11.2, 12.2, 13.2, 14.2, 15.2 e 16.2</div></div></button>
            <button class="tf-opt" onclick="tfPick(this,'modal','ambos')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não sei / Quero sugestão</strong><div class="tf-osub">O formulário indicará todas as opções disponíveis</div></div></button>
          </div>
          <p class="tf-err" id="tf-e1">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" disabled>← Anterior</button><button class="tf-next" onclick="tfAdv(1)">Próximo →</button></div>
      </div>

      <!-- P2 · OBJETIVO -->
      <div class="tf-step" id="tf-s2">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 02 · Objetivo Principal</div>
          <h3>Qual é o seu principal objetivo em relação aos seus bens digitais após sua morte?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'obj','nao_transmitir')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não desejo transmitir bens digitais</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','apagar')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Apagar contas, perfis, arquivos ou rastros digitais</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','memorial')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Que minhas contas sejam transformadas em páginas memoriais</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','economico')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Transmitir bens digitais com valor econômico aos meus herdeiros</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','completo')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Transmitir bens digitais com e sem valor econômico aos meus herdeiros</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','pessoa_esp')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Transmitir o meu acervo digital para uma pessoa específica</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','conjunto')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Regulamentar transmissão de contas conjuntas ou compartilhadas</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','autoral')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Dispor sobre a sucessão de obras digitais protegidas por direito autoral</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','inventariante')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Nomear inventariante digital para administrar meus bens digitais após minha morte</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','fotos')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Dispor especificamente sobre fotografias digitais protegidas pelos direitos autorais</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','ilustracoes')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Regular transmissão especificamente de ilustrações e desenhos digitais protegidos pelos direitos autorais</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','textos')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Regular transmissão de textos literários, artísticos ou científicos, coletâneas, compilações, antologias, enciclopédias, dicionários, coreografias digitais e semelhantes</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','videos')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Regular transmissão especificamente de vídeos armazenados no meio digital protegidos pelos direitos autorais</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','software')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Regular transmissão especificamente para Programa de Computador — código-fonte</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','musica')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Regular transmissão especificamente de músicas e composições digitais protegidas pelo direito autoral</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obj','pesquisa')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Transmitir Pesquisa Científica realizada no Meio Digital e/ou de Acervo de Estudo</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e2">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(2)">Próximo →</button></div>
      </div>

      <!-- P3 -->
      <div class="tf-step" id="tf-s3">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 03 · Acesso e Exclusão</div>
          <h3>Você deseja impedir o acesso de terceiros e determinar a exclusão do seu acervo digital?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'excl_acesso','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'excl_acesso','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e3">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(3)">Próximo →</button></div>
      </div>

      <!-- P4 -->
      <div class="tf-step" id="tf-s4">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 04 · Exclusão de Contas</div>
          <h3>Você deseja que determinadas contas, arquivos ou perfis sejam excluídos após sua morte?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'excl_contas','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'excl_contas','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e4">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(4)">Próximo →</button></div>
      </div>

      <!-- P5 -->
      <div class="tf-step" id="tf-s5">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 05 · Desaparecimento Virtual</div>
          <h3>Você deseja o "desaparecimento virtual" após a sua morte?</h3>
          <div class="tf-hint">Eliminação ampla da sua presença digital em redes, contas e serviços online após o falecimento.</div>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'desaparecer','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'desaparecer','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e5">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(5)">Próximo →</button></div>
      </div>

      <!-- P6 -->
      <div class="tf-step" id="tf-s6">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 06 · Bens com Valor Econômico</div>
          <h3>Você possui bens digitais com valor econômico?</h3>
          <div class="tf-hint">Bens digitais com valor econômico são aqueles capazes de gerar renda, como criptomoedas, canais monetizados, contas com saldo, domínios de sites, lojas virtuais, milhas aéreas, ativos em plataformas etc.</div>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'tem_econ','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'tem_econ','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'tem_econ','nao_sei')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não sei</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e6">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(6)">Próximo →</button></div>
      </div>

      <!-- P7 -->
      <div class="tf-step" id="tf-s7">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 07 · Geração de Renda</div>
          <h3>Esses bens digitais geram renda ou podem ser convertidos em dinheiro?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'gera_renda','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'gera_renda','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e7">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(7)">Próximo →</button></div>
      </div>

      <!-- P8 -->
      <div class="tf-step" id="tf-s8">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 08 · Transferência</div>
          <h3>Você deseja transferir esses bens a herdeiros ou legatários?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'transf_econ','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'transf_econ','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e8">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(8)">Próximo →</button></div>
      </div>

      <!-- P9 -->
      <div class="tf-step" id="tf-s9">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 09 · Patrimônio Digital</div>
          <h3>Você pretende transmitir todo o seu patrimônio digital — ativos com e sem valoração econômica?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'pat_total','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'pat_total','so_econ')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não, apenas bens com valor econômico</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'pat_total','nenhum')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não desejo a transmissão de nenhuma modalidade de bens digitais</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e9">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(9)">Próximo →</button></div>
      </div>

      <!-- P10 -->
      <div class="tf-step" id="tf-s10">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 10 · Instrumento Único</div>
          <h3>Você deseja organizar a transmissão de todos os seus bens digitais em um único instrumento?</h3>
          <div class="tf-hint">Incluindo arquivos pessoais, contas, documentos, mídias e acessos.</div>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'unico','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'unico','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e10">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(10)">Próximo →</button></div>
      </div>

      <!-- P11 -->
      <div class="tf-step" id="tf-s11">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 11 · Pessoa Específica</div>
          <h3>Você deseja deixar seus bens digitais ou parte deles para uma pessoa específica?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'p_esp','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'p_esp','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e11">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(11)">Próximo →</button></div>
      </div>

      <!-- P12 -->
      <div class="tf-step" id="tf-s12">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 12 · Responsável</div>
          <h3>Essa pessoa será responsável por receber e administrar perfis de redes sociais, arquivos, obras intelectuais, conta ou coleção digital?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'resp_p','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'resp_p','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e12">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(12)">Próximo →</button></div>
      </div>

      <!-- P13 -->
      <div class="tf-step" id="tf-s13">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 13 · Contas Conjuntas</div>
          <h3>Você possui contas digitais utilizadas em conjunto com outra pessoa?</h3>
          <div class="tf-hint">Exemplos: contas de streaming, nuvem familiar, e-mail empresarial compartilhado, redes sociais administradas por mais de uma pessoa.</div>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'conj','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'conj','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e13">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(13)">Próximo →</button></div>
      </div>

      <!-- P14 -->
      <div class="tf-step" id="tf-s14">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 14 · Senhas Compartilhadas</div>
          <h3>Você divide senhas, administração ou titularidade de algum ativo digital com outra pessoa?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'divide','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'divide','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e14">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(14)">Próximo →</button></div>
      </div>

      <!-- P15 -->
      <div class="tf-step" id="tf-s15">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 15 · Criações Intelectuais</div>
          <h3>Você possui criações intelectuais armazenadas em meio digital?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'cria','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'cria','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e15">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(15)">Próximo →</button></div>
      </div>

      <!-- P16 -->
      <div class="tf-step" id="tf-s16">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 16 · Autoria</div>
          <h3>Essas criações são de sua autoria?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'autoria','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'autoria','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'autoria','parcial')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Parcialmente</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e16">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(16)">Próximo →</button></div>
      </div>

      <!-- P17 -->
      <div class="tf-step" id="tf-s17">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 17 · Administração das Obras</div>
          <h3>Você deseja decidir quem poderá administrar, explorar economicamente ou preservar todas essas obras digitais?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'adm_obras','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'adm_obras','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e17">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(17)">Próximo →</button></div>
      </div>

      <!-- P18 -->
      <div class="tf-step" id="tf-s18">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 18 · Instrumento Único para Obras</div>
          <h3>Você deseja dispor a respeito da transmissão de todas as suas obras digitais em um mesmo instrumento?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'obras_unico','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obras_unico','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'obras_unico','especificas')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não, desejo regular obras digitais específicas</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e18">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(18)">Próximo →</button></div>
      </div>

      <!-- P19 -->
      <div class="tf-step" id="tf-s19">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 19 · Ilustrações e Desenhos</div>
          <h3>Você possui ilustrações, artes visuais, desenhos digitais ou obras gráficas digitais de sua autoria que deseja transmitir especificamente aos seus herdeiros ou legatários?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'ilu','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'ilu','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e19">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(19)">Próximo →</button></div>
      </div>

      <!-- P20 -->
      <div class="tf-step" id="tf-s20">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 20 · Fotografias</div>
          <h3>Você possui fotografias digitais autorais que deseja proteger ou transmitir para herdeiros e legatários?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'foto','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'foto','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e20">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(20)">Próximo →</button></div>
      </div>

      <!-- P21 -->
      <div class="tf-step" id="tf-s21">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 21 · Textos Literários</div>
          <h3>Você possui textos literários, artigos, obras artísticas, produções científicas, antologias, compilações, enciclopédias, dicionários, roteiros, coreografias digitais ou materiais semelhantes de sua autoria que deseja transmitir aos herdeiros ou legatários?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'texto','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'texto','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e21">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(21)">Próximo →</button></div>
      </div>

      <!-- P22 -->
      <div class="tf-step" id="tf-s22">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 22 · Vídeos</div>
          <h3>Você possui vídeos autorais armazenados em meio digital que deseja transmitir aos herdeiros ou legatários?</h3>
          <div class="tf-hint">Como aulas, documentários, vídeos artísticos, conteúdos para internet ou gravações criativas como coreografias autorais.</div>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'vid','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'vid','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e22">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(22)">Próximo →</button></div>
      </div>

      <!-- P23 -->
      <div class="tf-step" id="tf-s23">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 23 · Software</div>
          <h3>Você é autor(a) de software, aplicativo, sistema ou programa de computador cujo código-fonte deseja transmitir aos seus herdeiros ou legatários?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'soft','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'soft','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e23">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(23)">Próximo →</button></div>
      </div>

      <!-- P24 -->
      <div class="tf-step" id="tf-s24">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 24 · Músicas</div>
          <h3>Você possui músicas, letras, composições, partituras, fonogramas ou obras musicais digitais de sua autoria armazenadas em nuvem ou em plataformas digitais que deseja transmitir aos seus herdeiros ou legatários?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'mus','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'mus','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e24">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(24)">Próximo →</button></div>
      </div>

      <!-- P25 -->
      <div class="tf-step" id="tf-s25">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 25 · Pesquisa Científica</div>
          <h3>Você possui pesquisa científica, banco de dados, fichamentos, anotações, cadernos digitais, arquivos acadêmicos ou acervo de estudo que deseja transmitir para herdeiros, legatários ou fazer doações para instituições de ensino?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'pesq','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'pesq','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e25">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(25)">Próximo →</button></div>
      </div>

      <!-- P26 -->
      <div class="tf-step" id="tf-s26">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 26 · Inventariante Digital</div>
          <h3>Você deseja nomear uma pessoa especialista na área da tecnologia para administrar, acessar, organizar, cumprir instruções e dar destino aos seus bens digitais após sua morte?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'inv','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'inv','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e26">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(26)">Próximo →</button></div>
      </div>

      <!-- P27 -->
      <div class="tf-step" id="tf-s27">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 27 · Responsável Principal</div>
          <h3>Essa pessoa atuará como responsável principal pela execução das suas disposições digitais?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'inv_resp','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'inv_resp','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e27">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(27)">Próximo →</button></div>
      </div>

      <!-- P28 -->
      <div class="tf-step" id="tf-s28">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 28 · Memorial Digital</div>
          <h3>Você deseja que redes sociais, perfis ou páginas permaneçam ativos como memorial, em vez de serem apagados?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'mem','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'mem','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e28">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(28)">Próximo →</button></div>
      </div>

      <!-- P29 -->
      <div class="tf-step" id="tf-s29">
        <div class="tf-card">
          <div class="tf-snum">Pergunta 29 · Administração do Memorial</div>
          <h3>Você quer que familiares ou pessoa indicada administrem esse memorial digital?</h3>
          <div class="tf-opts">
            <button class="tf-opt" onclick="tfPick(this,'mem_adm','sim')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Sim</strong></div></button>
            <button class="tf-opt" onclick="tfPick(this,'mem_adm','nao')"><div class="tf-radio"></div><div class="tf-otxt"><strong>Não</strong></div></button>
          </div>
          <p class="tf-err" id="tf-e29">Selecione uma opção para continuar.</p>
        </div>
        <div class="tf-nav"><button class="tf-back" onclick="tfBack()">← Anterior</button><button class="tf-next" onclick="tfAdv(29)">Próximo →</button></div>
      </div>

      <!-- ══ ETAPA DE DADOS PESSOAIS ══ -->
      <div class="tf-step" id="tf-dados">
        <div class="tf-card">
          <div class="tf-snum">Última etapa · Seus dados</div>
          <h3>Preencha seus dados para gerar o testamento personalizado</h3>
          <p class="tf-dados-sub">Seus dados serão inseridos no documento e registrados com segurança. Não compartilhamos suas informações.</p>

          <div class="tf-fields">

            <div class="tf-field-row">
              <div class="tf-field tf-field-full">
                <label for="tf-nome">Nome completo <span>*</span></label>
                <input type="text" id="tf-nome" placeholder="Seu nome completo" autocomplete="name">
                <p class="tf-err" id="tf-nome-err">Campo obrigatório.</p>
              </div>
            </div>

            <div class="tf-field-row">
              <div class="tf-field">
                <label for="tf-nacionalidade">Nacionalidade <span>*</span></label>
                <input type="text" id="tf-nacionalidade" placeholder="Ex: brasileiro(a)" autocomplete="off">
                <p class="tf-err" id="tf-nacionalidade-err">Campo obrigatório.</p>
              </div>
              <div class="tf-field">
                <label for="tf-estado_civil">Estado civil <span>*</span></label>
                <select id="tf-estado_civil">
                  <option value="">Selecione</option>
                  <option value="solteiro(a)">Solteiro(a)</option>
                  <option value="casado(a)">Casado(a)</option>
                  <option value="divorciado(a)">Divorciado(a)</option>
                  <option value="viúvo(a)">Viúvo(a)</option>
                  <option value="união estável">União estável</option>
                </select>
                <p class="tf-err" id="tf-estado_civil-err">Campo obrigatório.</p>
              </div>
            </div>

            <div class="tf-field-row">
              <div class="tf-field">
                <label for="tf-profissao">Profissão <span>*</span></label>
                <input type="text" id="tf-profissao" placeholder="Sua profissão" autocomplete="organization-title">
                <p class="tf-err" id="tf-profissao-err">Campo obrigatório.</p>
              </div>
              <div class="tf-field">
                <label for="tf-data_nascimento">Data de nascimento <span>*</span></label>
                <input type="date" id="tf-data_nascimento">
                <p class="tf-err" id="tf-data_nascimento-err">Campo obrigatório.</p>
              </div>
            </div>

            <div class="tf-field-row">
              <div class="tf-field">
                <label for="tf-cpf">CPF <span>*</span></label>
                <input type="text" id="tf-cpf" placeholder="000.000.000-00" maxlength="14" oninput="tfMascaraCpf(this)" inputmode="numeric">
                <p class="tf-err" id="tf-cpf-err">Campo obrigatório.</p>
              </div>
              <div class="tf-field">
                <label for="tf-rg">RG <span>*</span></label>
                <input type="text" id="tf-rg" placeholder="Número do RG" maxlength="20">
                <p class="tf-err" id="tf-rg-err">Campo obrigatório.</p>
              </div>
            </div>

            <div class="tf-field-row">
              <div class="tf-field tf-field-full">
                <label for="tf-filiacao">Filiação <span>*</span></label>
                <input type="text" id="tf-filiacao" placeholder="Nome do pai e da mãe" autocomplete="off">
                <p class="tf-err" id="tf-filiacao-err">Campo obrigatório.</p>
              </div>
            </div>

            <div class="tf-field-row">
              <div class="tf-field tf-field-full">
                <label for="tf-endereco">Endereço completo <span>*</span></label>
                <input type="text" id="tf-endereco" placeholder="Rua, número, bairro, cidade, estado, CEP" autocomplete="street-address">
                <p class="tf-err" id="tf-endereco-err">Campo obrigatório.</p>
              </div>
            </div>

            <div class="tf-field-row">
              <div class="tf-field">
                <label for="tf-email">E-mail <span>*</span></label>
                <input type="email" id="tf-email" placeholder="seu@email.com" autocomplete="email">
                <p class="tf-err" id="tf-email-err">Campo obrigatório.</p>
              </div>
              <div class="tf-field">
                <label for="tf-telefone">Telefone <span>*</span></label>
                <input type="tel" id="tf-telefone" placeholder="(00) 00000-0000" maxlength="15" oninput="tfMascaraTel(this)" inputmode="tel">
                <p class="tf-err" id="tf-telefone-err">Campo obrigatório.</p>
              </div>
            </div>

          </div><!-- /tf-fields -->

          <p class="tf-err tf-err-block" id="tf-submit-err"></p>
        </div>

        <div class="tf-nav">
          <button class="tf-back" onclick="tfBackDados()">← Anterior</button>
          <button class="tf-next" id="tf-btn-submit" onclick="tfSubmitDados()">
            Ver resultado →
          </button>
        </div>
      </div>

      <!-- ══ TELA DE RESULTADO ══ -->
      <div id="tf-result" style="display:none">
        <div class="tf-res-card">
          <div class="tf-res-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
              <polyline points="14 2 14 8 20 8"/>
              <line x1="16" y1="13" x2="8" y2="13"/>
              <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
          </div>
          <div class="tf-res-tag">Resultado · Testamento Sugerido</div>
          <h2 id="tf-r-title"></h2>

          <!-- Botão de download -->
          <div class="tf-downloads">
            <button class="tf-btn-download" id="tf-btn-download" onclick="tfDownload()">
              <svg width="15" height="15" viewBox="0 0 14 14" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M7 1v8M4 6l3 3 3-3M2 11h10"/>
              </svg>
              Baixar Testamento
            </button>
            <p class="tf-err tf-err-block" id="tf-download-err"></p>
          </div>

          <p class="tf-res-desc" id="tf-r-desc"></p>
          <div class="tf-res-note">
            ⚠️ Este resultado possui caráter meramente orientativo e não substitui a análise individualizada por profissional qualificado, especialmente em casos mais complexos que envolvam expressivo valor patrimonial, obras intelectuais, monetização de conteúdo, direitos autorais ou potenciais conflitos entre herdeiros.
          </div>
          <div class="tf-res-actions">
            <button class="tf-btn-restart" onclick="tfRestart()">↩ Reiniciar formulário</button>
            <button class="tf-btn-close-res" onclick="tfModalClose()">Fechar</button>
          </div>
        </div>
      </div>

    </div><!-- /tf-body -->
  </div><!-- /tf-box -->
</div><!-- /tf-overlay -->
