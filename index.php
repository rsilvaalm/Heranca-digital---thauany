<?php
// ═══════════════════════════════════════
// INDEX — Ponto de entrada da aplicação
// ═══════════════════════════════════════
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Advogada | Herança Digital</title>

  <!-- Fontes -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Outfit:wght@300;400;500;600&display=swap" rel="stylesheet">

  <!-- VLibras -->
  <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>

  <!-- CSS -->
  <link rel="stylesheet" href="css/variables.css">
  <link rel="stylesheet" href="css/base.css">
  <link rel="stylesheet" href="css/nav.css">
  <link rel="stylesheet" href="css/sections.css">
  <link rel="stylesheet" href="css/apresentacao.css">
  <link rel="stylesheet" href="css/accessibility.css">
</head>
<body>

  <?php include 'parts/nav.php'; ?>

  <?php include 'sections/hero.php'; ?>

  <div class="divider-full"></div>

  <?php include 'sections/sobre.php'; ?>

  <div class="divider-full"></div>

  <?php include 'sections/apresentacao.php'; ?>

  <div class="divider-full"></div>

  <?php include 'sections/produtos.php'; ?>

  <div class="divider-full"></div>

  <?php include 'sections/testamento.php'; ?>

  <?php include 'parts/footer.php'; ?>

  <?php include 'parts/accessibility.php'; ?>

  <!-- JS -->
  <script src="js/theme.js"></script>
  <script src="js/faq.js"></script>
  <script src="js/accessibility.js"></script>
  <script src="js/carousel.js"></script>
  <script src="js/scroll-reveal.js"></script>

</body>
</html>