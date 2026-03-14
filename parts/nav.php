<?php /* ── NAVEGAÇÃO ── */ ?>
<nav id="main-nav">
  <a href="#" class="nav-logo">Herança Digital</a>
  <ul>
    <li><a href="#sobre">Sobre mim</a></li>
    <li><a href="#apresentacao">O Tema</a></li>
    <li><a href="#produtos">Produtos</a></li>
    <li><a href="#testamento">Testamento</a></li>

    <!-- Acessibilidade -->
    <li class="nav-a11y-item">
      <button class="nav-a11y-btn" id="a11y-nav-btn" aria-expanded="false" aria-controls="a11y-dropdown" title="Acessibilidade">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="16" height="16">
          <circle cx="12" cy="5" r="1.5" fill="currentColor" stroke="none"/>
          <path d="M12 8v5"/>
          <path d="M9 10l-2 5"/>
          <path d="M15 10l2 5"/>
          <path d="M10 21l2-4 2 4"/>
        </svg>
        Acessibilidade
      </button>

      <!-- Dropdown -->
      <div class="a11y-dropdown" id="a11y-dropdown" role="group" aria-label="Opções de acessibilidade">
        <button class="a11y-opt" id="tts-btn" aria-pressed="false">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
            <path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/>
            <path d="M19 10v2a7 7 0 0 1-14 0v-2"/>
            <line x1="12" y1="19" x2="12" y2="23"/>
            <line x1="8"  y1="23" x2="16" y2="23"/>
          </svg>
          <span id="tts-label">Narrar página</span>
        </button>
        <button class="a11y-opt" id="libras-btn" aria-pressed="false">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
            <path d="M18 8h1a4 4 0 0 1 0 8h-1"/>
            <path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"/>
            <line x1="6"  y1="1" x2="6"  y2="4"/>
            <line x1="10" y1="1" x2="10" y2="4"/>
            <line x1="14" y1="1" x2="14" y2="4"/>
          </svg>
          Libras
        </button>
      </div>
    </li>

    <!-- Toggle de tema -->
    <!-- <li>
      <label class="theme-toggle" title="Alternar tema">
        <input type="checkbox" id="themeToggle" />
        <div class="toggle-track"></div>
        <div class="toggle-knob"></div>
        <div class="toggle-icons">
          <svg class="icon-moon" viewBox="0 0 24 24" fill="currentColor">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
          </svg>
          <svg class="icon-sun" viewBox="0 0 24 24" fill="currentColor">
            <circle cx="12" cy="12" r="5"/>
            <line x1="12" y1="1"  x2="12" y2="3"  stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <line x1="12" y1="21" x2="12" y2="23" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <line x1="4.22"  y1="4.22"  x2="5.64"  y2="5.64"  stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <line x1="1"  y1="12" x2="3"  y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <line x1="21" y1="12" x2="23" y2="12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <line x1="4.22"  y1="19.78" x2="5.64"  y2="18.36" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            <line x1="18.36" y1="5.64"  x2="19.78" y2="4.22"  stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
      </label>
    </li> -->
  </ul>
</nav>
