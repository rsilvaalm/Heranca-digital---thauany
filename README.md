# Herança Digital


## Visão Geral

O projeto combina um site institucional com um sistema funcional de geração de testamentos digitais personalizados. O usuário responde um formulário inteligente de até 29 perguntas, preenche seus dados pessoais e recebe um PDF do modelo de testamento adequado ao seu perfil, com seus dados já inseridos no documento.

Cada download é registrado no banco de dados para fins administrativos.

---

## Funcionalidades

- **Site institucional** com seções: Hero, Sobre, O Tema, Produtos e Testamento
- **Carrossel de conteúdo** com 11 slides sobre herança digital no Brasil
- **FAQ accordion** com perguntas frequentes
- **Formulário inteligente** com fluxo adaptativo de até 29 perguntas
- **Etapa de dados pessoais** com validação e máscaras (CPF, telefone)
- **Geração de PDF dinâmica** com dados do usuário inseridos no modelo
- **18 modelos de testamento** nas versões particular e cerrado (36 no total)
- **Registro em banco de dados** a cada download realizado
- **Acessibilidade**: narração TTS via Web Speech API e suporte a Libras via VLibras
- **Tema escuro** como padrão, com identidade visual consistente
- **Design responsivo** para desktop e mobile

---

## Estrutura do Projeto

```
/
├── index.php                    # Ponto de entrada da aplicação
├── config.php                   # Configurações de banco de dados
│
├── parts/
│   ├── nav.php                  # Navegação principal
│   ├── footer.php               # Rodapé
│   └── accessibility.php        # Widget VLibras e barra TTS
│
├── sections/
│   ├── hero.php                 # Seção hero
│   ├── sobre.php                # Sobre a autora
│   ├── apresentacao.php         # Carrossel + FAQ sobre o tema
│   ├── produtos.php             # Cards de produtos para download
│   └── testamento.php           # CTA + Modal com formulário completo
│
├── testamento/
│   ├── gerar_pdf.php            # Geração do PDF + registro no banco
│   ├── direcionamento.php       # Mapeamento respostas → modelo correto
│   ├── modelos_texto.php        # Textos dos 36 modelos de testamento
│   └── lib/
│       └── fpdf.php             # Biblioteca FPDF
│
├── css/
│   ├── variables.css            # Tokens de tema (cores, espaçamentos)
│   ├── base.css                 # Reset, tipografia, botões, utilitários
│   ├── nav.css                  # Navegação e acessibilidade
│   ├── sections.css             # Estilos das seções do site
│   ├── apresentacao.css         # Carrossel paginado
│   └── testamento-form.css      # Modal e formulário de testamento
│
├── js/
│   ├── theme.js                 # Alternância de tema claro/escuro
│   ├── carousel.js              # Carrossel da seção de apresentação
│   ├── faq.js                   # Accordion de FAQ
│   ├── scroll-reveal.js         # Animações de entrada por scroll
│   ├── accessibility.js         # TTS e controle do VLibras
│   ├── leitura-progress.js      # Barra de progresso de leitura
│   └── testamento-form.js       # Lógica do formulário e modal
│
├── downloads/                   # PDFs dos produtos disponíveis
├── imgs/                        # Imagens do site
└── setup_db.sql                 # Script de criação do banco de dados
```

---

## Stack Tecnológica

| Camada | Tecnologia |
|---|---|
| Backend | PHP 8+ |
| Geração de PDF | [FPDF](http://www.fpdf.org/) |
| Banco de dados | MySQL / MariaDB |
| Frontend | HTML5, CSS3, JavaScript (Vanilla) |
| Tipografia | Google Fonts — Cormorant Garamond + Outfit |
| Acessibilidade | Web Speech API (TTS) + VLibras |

---

## Banco de Dados

Execute o script `setup_db.sql` para criar o banco e a tabela necessária.

```sql
CREATE DATABASE IF NOT EXISTS heranca_digital
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

### Tabela `testamentos`

| Campo | Tipo | Descrição |
|---|---|---|
| `id` | INT AUTO_INCREMENT | Identificador único |
| `nome` | VARCHAR(255) | Nome completo do testador |
| `nacionalidade` | VARCHAR(100) | Nacionalidade |
| `estado_civil` | VARCHAR(50) | Estado civil |
| `profissao` | VARCHAR(150) | Profissão |
| `cpf` | VARCHAR(20) | CPF |
| `rg` | VARCHAR(30) | RG |
| `data_nascimento` | DATE | Data de nascimento |
| `filiacao` | VARCHAR(255) | Nome dos pais |
| `endereco` | TEXT | Endereço completo |
| `email` | VARCHAR(255) | E-mail |
| `telefone` | VARCHAR(30) | Telefone |
| `modelo_chave` | VARCHAR(50) | Chave interna do modelo gerado |
| `modelo_nome` | VARCHAR(255) | Nome legível do modelo |
| `modalidade` | ENUM | `particular` ou `cerrado` |
| `ip` | VARCHAR(45) | IP de origem do download |
| `criado_em` | DATETIME | Timestamp do registro |

---

## Fluxo do Formulário

```
Abertura do modal
       │
       ▼
  Pergunta 1 — Modalidade (particular / cerrado / não sei)
       │
       ▼
  Pergunta 2 — Objetivo principal (16 opções)
       │
       ├─ Atalhos diretos para modelos específicos (fotos, vídeos, músicas etc.)
       │
       └─ Fluxo completo (até Pergunta 29) com ramificações:
            • Exclusão / Desaparecimento virtual   → Modelos 1, 2, 3
            • Bens econômicos                      → Modelo 4
            • Acervo completo                      → Modelo 5
            • Pessoa específica                    → Modelo 6
            • Contas conjuntas                     → Modelo 7
            • Direito autoral (geral)              → Modelos 8, 9
            • Ilustrações                          → Modelo 10
            • Fotografias                          → Modelo 11
            • Textos literários                    → Modelo 12
            • Vídeos                               → Modelo 13
            • Software / código-fonte              → Modelo 14
            • Músicas                              → Modelo 15
            • Pesquisa científica                  → Modelo 16
            • Inventariante digital                → Modelo 17
            • Memorial digital                     → Modelo 18
       │
       ▼
  Etapa de dados pessoais (validação + máscaras)
       │
       ▼
  Tela de resultado (título + descrição do modelo sugerido)
       │
       ▼
  Botão "Baixar Testamento"
       │
       ▼
  POST → testamento/gerar_pdf.php
       │
       ├─ Substitui placeholders do testador no texto do modelo
       ├─ Registra no banco de dados
       └─ Gera e faz download do PDF via FPDF
```

---

## Geração do PDF

O arquivo `testamento/gerar_pdf.php` realiza três operações em sequência:

**1. Substituição de placeholders**
Substitui apenas a frase de identificação do testador via regex:
```
Eu, [NOME COMPLETO DO TESTADOR], [nacionalidade], [estado civil], [profissão],
portador(a) do CPF nº [CPF] e do RG nº [RG], residente e domiciliado(a) na [endereço completo]
```
Todos os demais placeholders (herdeiros, testamenteiro, testemunhas) são preservados para preenchimento manual pelo usuário.

**2. Conversão de encoding**
A função `conv()` realiza mapeamento manual de caracteres Unicode problemáticos (en dash `–`, aspas tipográficas `"`, ordinais `º`, non-breaking spaces etc.) antes da conversão UTF-8 → ISO-8859-1 exigida pela FPDF.

**3. Renderização**
- Cabeçalho com nome do modelo em roxo (`#5B4FC0`) e linha decorativa
- Títulos de seção detectados por regex e renderizados em negrito centralizado
- Parágrafos justificados
- Quebra de página forçada quando `GetY() > 240mm` para evitar títulos orfãos
- Rodapé com aviso orientativo e número de página

---

## Modelos de Testamento

Cada tipo possui versão **particular** e **cerrado**, totalizando 36 modelos:

| # | Tipo | Particular | Cerrado |
|---|---|---|---|
| 1/2 | Negativo (não transmitir) | Modelo 1 | Modelo 2 |
| 3 | Desaparecimento virtual | Modelo 3 | Modelo 3.2 |
| 4 | Bens com valor econômico | Modelo 4 | Modelo 4.2 |
| 5 | Acervo digital completo | Modelo 5 | Modelo 5.2 |
| 6 | Transmissão a pessoa específica | Modelo 6 | Modelo 6.2 |
| 7 | Contas conjuntas/compartilhadas | Modelo 7 | Modelo 7.2 |
| 8/9 | Direito autoral (geral) | Modelo 8 | Modelo 9 |
| 10 | Ilustrações e desenhos | Modelo 10 | Modelo 10.2 |
| 11 | Fotografias autorais | Modelo 11 | Modelo 11.2 |
| 12 | Textos literários/científicos | Modelo 12 | Modelo 12.2 |
| 13 | Vídeos autorais | Modelo 13 | Modelo 13.2 |
| 14 | Programa de computador | Modelo 14 | Modelo 14.2 |
| 15 | Músicas e composições | Modelo 15 | Modelo 15.2 |
| 16 | Pesquisa científica | Modelo 16 | Modelo 16.2 |
| 17 | Nomeação de inventariante digital | Modelo 17 | Modelo 17.2 |
| 18 | Transformação em memorial digital | Modelo 18 | Modelo 18.2 |

---

## Acessibilidade

- **TTS (Text-to-Speech)**: narração completa da página via Web Speech API, com highlight visual do texto sendo lido e barra de progresso
- **VLibras**: integração com o widget oficial do governo brasileiro para tradução em Libras
- **Navegação por teclado**: suporte a `Escape` para fechar o modal, `ArrowLeft`/`ArrowRight` no carrossel
- **Semântica**: uso de `aria-hidden`, `aria-modal`, `aria-label` e `role` nos componentes interativos


## Autora

     **THAUANY FREIRE DOS SANTOS SILVA** — advogada, pesquisadora e mestranda no PROFNIT/UNIVASF, com pesquisa dedicada à Herança Digital no Brasil desde 2019.

---

*Herança Digital © 2026 — Todos os direitos reservados*
