<?php
// ═══════════════════════════════════════
// GERAR TESTAMENTO — PDF dinâmico via FPDF
// Uso: gerar_testamento.php?tipo=desaparecer&modal=particular
// ═══════════════════════════════════════

require_once __DIR__ . '/fpdf/fpdf.php';
require_once __DIR__ . '/modelos_texto.php';

// ── Mapa tipo (JS) → chave(s) do modelo ─────────────────────────────────────
// Quando a modalidade é "ambos", usa o particular (modelo ímpar) como padrão.
// O segundo valor do array é a versão cerrada, se existir.
$mapa = [
    'negativo'     => ['particular' => 'modelo_01', 'cerrado' => 'modelo_02'],
    'desaparecer'  => ['particular' => 'modelo_03', 'cerrado' => 'modelo_03_2'],
    'economico'    => ['particular' => 'modelo_04', 'cerrado' => 'modelo_04_2'],
    'completo'     => ['particular' => 'modelo_05', 'cerrado' => 'modelo_05_2'],
    'pessoa'       => ['particular' => 'modelo_06', 'cerrado' => 'modelo_06_2'],
    'conjunto'     => ['particular' => 'modelo_07', 'cerrado' => 'modelo_07_2'],
    'autoral'      => ['particular' => 'modelo_08', 'cerrado' => 'modelo_09'],
    'ilustracoes'  => ['particular' => 'modelo_10', 'cerrado' => 'modelo_10_2'],
    'fotografias'  => ['particular' => 'modelo_11', 'cerrado' => 'modelo_11_2'],
    'textos'       => ['particular' => 'modelo_12', 'cerrado' => 'modelo_12_2'],
    'videos'       => ['particular' => 'modelo_13', 'cerrado' => 'modelo_13_2'],
    'software'     => ['particular' => 'modelo_14', 'cerrado' => 'modelo_14_2'],
    'musicas'      => ['particular' => 'modelo_15', 'cerrado' => 'modelo_15_2'],
    'pesquisa'     => ['particular' => 'modelo_16', 'cerrado' => 'modelo_16_2'],
    'inventariante'=> ['particular' => 'modelo_17', 'cerrado' => 'modelo_17_2'],
    'memorial'     => ['particular' => 'modelo_18', 'cerrado' => 'modelo_18_2'],
];

// ── Recebe parâmetros ────────────────────────────────────────────────────────
$tipo  = isset($_GET['tipo'])  ? trim($_GET['tipo'])  : '';
$modal = isset($_GET['modal']) ? trim($_GET['modal']) : 'particular';

// Valida tipo
if (!array_key_exists($tipo, $mapa)) {
    http_response_code(400);
    exit('Tipo de testamento inválido.');
}

// Resolve chave do modelo
$modalidade = ($modal === 'cerrado') ? 'cerrado' : 'particular';
$chave      = $mapa[$tipo][$modalidade];

// Busca o texto
if (!isset($modelos_texto[$chave])) {
    // Tenta fallback para a versão particular se a cerrada não existir
    $chave = $mapa[$tipo]['particular'];
    if (!isset($modelos_texto[$chave])) {
        http_response_code(404);
        exit('Modelo não encontrado.');
    }
}

$texto_bruto = $modelos_texto[$chave];

// ── Nome do arquivo para download ────────────────────────────────────────────
$nomes_arquivo = [
    'negativo'     => 'testamento_negativo',
    'desaparecer'  => 'testamento_desaparecimento_virtual',
    'economico'    => 'testamento_bens_economicos',
    'completo'     => 'testamento_acervo_completo',
    'pessoa'       => 'testamento_pessoa_especifica',
    'conjunto'     => 'testamento_contas_conjuntas',
    'autoral'      => 'testamento_direito_autoral',
    'ilustracoes'  => 'testamento_ilustracoes_desenhos',
    'fotografias'  => 'testamento_fotografias',
    'textos'       => 'testamento_textos_literarios',
    'videos'       => 'testamento_videos',
    'software'     => 'testamento_programa_computador',
    'musicas'      => 'testamento_musicas_composicoes',
    'pesquisa'     => 'testamento_pesquisa_cientifica',
    'inventariante'=> 'testamento_inventariante_digital',
    'memorial'     => 'testamento_memorial_digital',
];

$sufixo      = ($modalidade === 'cerrado') ? '_cerrado' : '';
$nome_pdf    = ($nomes_arquivo[$tipo] ?? 'testamento') . $sufixo . '.pdf';

// ── Converte encoding ────────────────────────────────────────────────────────
// FPDF trabalha com ISO-8859-1; o texto fonte está em UTF-8
function utf8_to_latin($str) {
    return iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $str);
}

// ── Classe PDF customizada ───────────────────────────────────────────────────
class TestamentoPDF extends FPDF {

    function Header() {
        // Linha decorativa no topo
        $this->SetDrawColor(91, 79, 192);
        $this->SetLineWidth(0.8);
        $this->Line(15, 12, 195, 12);
        $this->Ln(4);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Times', 'I', 8);
        $this->SetTextColor(150);
        $this->Cell(0, 10, utf8_to_latin('Herança Digital — Modelo orientativo. Não substitui assessoria jurídica profissional.'), 0, 0, 'C');
        // Linha decorativa no rodapé
        $this->SetDrawColor(91, 79, 192);
        $this->SetLineWidth(0.5);
        $this->Line(15, $this->GetY() - 1, 195, $this->GetY() - 1);
    }
}

// ── Processa o texto ─────────────────────────────────────────────────────────
// Quebra o texto em linhas e identifica títulos de seção (ex: "1. DAS DISPOSIÇÕES GERAIS")
function processar_linhas($texto) {
    $linhas = explode("\n", $texto);
    $resultado = [];
    foreach ($linhas as $linha) {
        $linha = trim($linha);
        $resultado[] = $linha; // mantém linhas vazias para espaçamento
    }
    return $resultado;
}

function e_titulo_secao($linha) {
    // Padrão: começa com número seguido de ponto (ex: "1.", "2.", "10.")
    return preg_match('/^\d+[\.\s]/', $linha) && mb_strtoupper($linha) === $linha;
}

function e_titulo_principal($linha) {
    // Linha toda em maiúsculas com "TESTAMENTO" ou "MODELO"
    return mb_strtoupper($linha) === $linha
        && mb_strlen($linha) > 5
        && (stripos($linha, 'TESTAMENTO') !== false || stripos($linha, 'MODELO') !== false);
}

// ── Gera o PDF ───────────────────────────────────────────────────────────────
$pdf = new TestamentoPDF('P', 'mm', 'A4');
$pdf->SetMargins(20, 18, 20);
$pdf->SetAutoPageBreak(true, 20);
$pdf->AddPage();
$pdf->SetCreator('Herança Digital');
$pdf->SetAuthor('Herança Digital');
$pdf->SetTitle(utf8_to_latin($nomes_arquivo[$tipo] ?? 'Testamento Digital'));

$linhas = processar_linhas($texto_bruto);

foreach ($linhas as $linha) {

    if ($linha === '') {
        $pdf->Ln(3);
        continue;
    }

    $linha_latin = utf8_to_latin($linha);

    if (e_titulo_principal($linha)) {
        // Título principal — centralizado, negrito, maior
        $pdf->SetFont('Times', 'B', 13);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(0, 7, $linha_latin, 0, 'C');
        $pdf->Ln(3);

    } elseif (e_titulo_secao($linha)) {
        // Título de seção — negrito
        $pdf->Ln(2);
        $pdf->SetFont('Times', 'B', 11);
        $pdf->SetTextColor(30, 30, 30);
        $pdf->MultiCell(0, 6, $linha_latin, 0, 'L');
        $pdf->Ln(1);

    } elseif (preg_match('/^\[.+\]$/', $linha)) {
        // Marcadores de instrução como [SE HOUVER] — itálico, cinza
        $pdf->SetFont('Times', 'I', 10);
        $pdf->SetTextColor(100, 100, 100);
        $pdf->MultiCell(0, 5.5, $linha_latin, 0, 'L');

    } elseif (preg_match('/^_+$/', $linha) || preg_match('/^_+\s*\[/', $linha) || strpos($linha, '___') !== false) {
        // Linhas de assinatura
        $pdf->SetFont('Times', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(0, 6, $linha_latin, 0, 'C');

    } elseif (preg_match('/^\d+\./', $linha) && !e_titulo_secao($linha)) {
        // Item de lista numerada
        $pdf->SetFont('Times', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(0, 6, $linha_latin, 0, 'L');

    } else {
        // Parágrafo normal — justificado
        $pdf->SetFont('Times', '', 11);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(0, 6, $linha_latin, 0, 'J');
    }
}

// ── Envia o PDF para download ────────────────────────────────────────────────
$pdf->Output('D', $nome_pdf);
exit;
