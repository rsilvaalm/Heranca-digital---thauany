<?php /* ── APRESENTAÇÃO DO TEMA ── */ ?>
<section id="apresentacao">
  <div class="section-label"><span>O Tema</span></div>

  <div class="apresentacao-intro">
    <h2 class="fade-up">O que é a <em>Herança Digital</em> e por que ela importa?</h2>
    <p class="apresentacao-intro-text fade-up" style="transition-delay: 0.15s">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus lacinia odio vitae vestibulum. Donec in efficitur leo, in commodo orci. Curabitur vel nisi at libero blandit dapibus non vel mi. Proin convallis felis nec feugiat ultrices. Integer dignissim pharetra sem, a ullamcorper felis dapibus nec.
    </p>
  </div>

  <div class="faq-list">
    <?php
    $faqs = [
      ["O que são bens digitais?",
       "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."],
      ["Bens digitais são herdáveis no Brasil?",
       "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore."],
      ["O que acontece com minhas redes sociais após a morte?",
       "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."],
      ["Como posso proteger meu patrimônio digital?",
       "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat."],
      ["O que é o testamento digital?",
       "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor."],
    ];
    foreach ($faqs as $i => $faq):
    ?>
    <div class="faq-item fade-up" onclick="toggleFaq(this)" style="transition-delay: <?= $i * 0.08 ?>s">
      <div class="faq-question">
        <h3><?= htmlspecialchars($faq[0]) ?></h3>
        <div class="faq-icon">+</div>
      </div>
      <div class="faq-answer">
        <p><?= htmlspecialchars($faq[1]) ?></p>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

</section>
