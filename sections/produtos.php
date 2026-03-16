<?php /* ── PRODUTOS ── */ ?>
<section id="produtos">
  <div class="section-label"><span>Produtos</span></div>
  <div class="produtos-grid">

    <?php
    $produtos = [
      [
        "arquivo"  => "Produto-01-Compartilhar-e-legal-A-protecao-dos-direitos-autorais-nas-redes-sociais.pdf",
        "titulo"   => "Compartilhar é legal? A Proteção dos Direitos Autorais nas Redes Sociais.",
        "imagem"   => "produto_1.png",
      ],
      [
        "arquivo"  => "Produto-02-CARTILHA-ILUSTRADA-DIREITO-SUCESSORIO-HERANCA-DIGITAL-E-PROTECAO-LEGAL.pdf",
        "titulo"   => "Direito sucessório, Herança digital e Proteção legal",
        "imagem"   => "produto_2.png",
      ],
      [
        "arquivo"  => "Produto-03-Modelos-de-Testamento-de-bens-digitais.pdf",
        "titulo"   => "Modelo de testamento de bens digitais",
        "imagem"   => "produto_3.png",
      ],
    ];

    foreach ($produtos as $i => $p):
    ?>
    <div class="produto-card fade-up" style="transition-delay: <?= $i * 0.12 ?>s">

      <div class="produto-img-placeholder">
        <img src="imgs/<?= htmlspecialchars($p['imagem']) ?>" alt="<?= htmlspecialchars($p['titulo']) ?>">
      </div>

      <div class="produto-body">
        <div class="produto-num">0<?= $i + 1 ?></div>
        <h3><?= htmlspecialchars($p['titulo']) ?></h3>
        <a href="downloads/<?= urlencode($p['arquivo']) ?>"
           download="<?= htmlspecialchars($p['arquivo']) ?>"
           class="btn-download">
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
            <path d="M7 1v8M4 6l3 3 3-3M2 11h10"
                  stroke="currentColor" stroke-width="1.5"
                  stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          Baixar PDF
        </a>
      </div>

    </div>
    <?php endforeach; ?>

  </div>
</section>
