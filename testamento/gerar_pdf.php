<?php
// ═══════════════════════════════════════
// GERAR PDF — Substitui placeholders,
// registra no banco e faz download
// ═══════════════════════════════════════

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/direcionamento.php';
require_once __DIR__ . '/modelos_texto.php';
require_once __DIR__ . '/lib/fpdf.php';

// ── Validação básica ──────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die(json_encode(['erro' => 'Método não permitido']));
}

// Sanitizar inputs
function limpar(string $v): string {
    return trim(htmlspecialchars_decode(strip_tags($v)));
}

$dados = [
    'nome'            => limpar($_POST['nome'] ?? ''),
    'nacionalidade'   => limpar($_POST['nacionalidade'] ?? ''),
    'estado_civil'    => limpar($_POST['estado_civil'] ?? ''),
    'profissao'       => limpar($_POST['profissao'] ?? ''),
    'cpf'             => limpar($_POST['cpf'] ?? ''),
    'rg'              => limpar($_POST['rg'] ?? ''),
    'data_nascimento' => limpar($_POST['data_nascimento'] ?? ''),
    'filiacao'        => limpar($_POST['filiacao'] ?? ''),
    'endereco'        => limpar($_POST['endereco'] ?? ''),
    'email'           => filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL),
    'telefone'        => limpar($_POST['telefone'] ?? ''),
];

// Respostas do questionário
$respostas = json_decode($_POST['respostas'] ?? '{}', true) ?? [];
$modalidade = in_array($respostas['modal'] ?? '', ['particular','cerrado'])
    ? $respostas['modal']
    : 'particular';

// Campos obrigatórios
$obrigatorios = ['nome','nacionalidade','estado_civil','profissao','cpf','rg','data_nascimento','filiacao','endereco','email','telefone'];
foreach ($obrigatorios as $campo) {
    if (empty($dados[$campo])) {
        http_response_code(400);
        die(json_encode(['erro' => "Campo obrigatório: $campo"]));
    }
}

// ── Determinar modelo ─────────────────────────────────────────────
$modelo = determinar_modelo($respostas, $modalidade);
$chave  = $modelo['chave'];
$nome_modelo = $modelo['nome'];

if (!isset($modelos_texto[$chave])) {
    http_response_code(500);
    die(json_encode(['erro' => "Modelo não encontrado: $chave"]));
}

// ── Substituir placeholders ───────────────────────────────────────
$texto = $modelos_texto[$chave];

// Data formatada
$data_nasc = '';
if ($dados['data_nascimento']) {
    $dt = DateTime::createFromFormat('Y-m-d', $dados['data_nascimento']);
    $data_nasc = $dt ? $dt->format('d/m/Y') : $dados['data_nascimento'];
}

$hoje = date('d') . ' de ' . nome_mes((int)date('m')) . ' de ' . date('Y');

// ── Substituições — apenas a frase de identificação do TESTADOR ──
//
// Estratégia: substituímos a frase "Eu, [NOME COMPLETO DO TESTADOR], ..."
// inteira de uma vez com regex, sem tocar em nenhum outro placeholder do
// documento ([endereço completo] dos herdeiros, [CPF] do testamenteiro etc.)
//
$frase_testador = '/Eu,\s*\[NOME COMPLETO DO TESTADOR\],'
    . '\s*\[nacionalidade\],'
    . '\s*\[estado civil\],'
    . '\s*\[profissão\],'
    . '\s*portador\(a\) do CPF n[°oº]\s*\[CPF\] e do RG n[°oº]\s*\[RG\],'
    . '\s*residente e domiciliado\(a\) na \[endereço completo\]/u';

$substituicao_testador = 'Eu, ' . mb_strtoupper($dados['nome']) . ', '
    . $dados['nacionalidade'] . ', '
    . $dados['estado_civil'] . ', '
    . $dados['profissao'] . ', '
    . 'portador(a) do CPF nº ' . $dados['cpf'] . ' e do RG nº ' . $dados['rg'] . ', '
    . 'residente e domiciliado(a) na ' . $dados['endereco'];

$texto = preg_replace($frase_testador, $substituicao_testador, $texto);

// Substitui apenas [NOME COMPLETO DO TESTADOR] onde aparecer isolado (assinatura)
$texto = str_replace('[NOME COMPLETO DO TESTADOR]', mb_strtoupper($dados['nome']), $texto);

// Data e local
$texto = str_replace(
    '[Local], [dia] de [mês] de [ano].',
    '_______________________, ' . $hoje . '.',
    $texto
);
$texto = str_replace(
    'Data de nascimento:__________________',
    'Data de nascimento: ' . $data_nasc,
    $texto
);
$texto = str_replace('[MODELO - TEXTO]', $nome_modelo, $texto);

// ── Registrar no banco ────────────────────────────────────────────
try {
    $pdo = db_connect();
    $stmt = $pdo->prepare("
        INSERT INTO testamentos
            (nome, nacionalidade, estado_civil, profissao, cpf, rg,
             data_nascimento, filiacao, endereco, email, telefone,
             modelo_chave, modelo_nome, modalidade, ip)
        VALUES
            (:nome, :nacionalidade, :estado_civil, :profissao, :cpf, :rg,
             :data_nascimento, :filiacao, :endereco, :email, :telefone,
             :modelo_chave, :modelo_nome, :modalidade, :ip)
    ");
    $stmt->execute([
        ':nome'            => $dados['nome'],
        ':nacionalidade'   => $dados['nacionalidade'],
        ':estado_civil'    => $dados['estado_civil'],
        ':profissao'       => $dados['profissao'],
        ':cpf'             => $dados['cpf'],
        ':rg'              => $dados['rg'],
        ':data_nascimento' => $dados['data_nascimento'],
        ':filiacao'        => $dados['filiacao'],
        ':endereco'        => $dados['endereco'],
        ':email'           => $dados['email'],
        ':telefone'        => $dados['telefone'],
        ':modelo_chave'    => $chave,
        ':modelo_nome'     => $nome_modelo,
        ':modalidade'      => $modalidade,
        ':ip'              => $_SERVER['REMOTE_ADDR'] ?? null,
    ]);
} catch (Exception $e) {
    error_log('Erro ao gravar testamento: ' . $e->getMessage());
}

// ── Gerar PDF ─────────────────────────────────────────────────────
class TestamentoPDF extends FPDF {
    private string $titulo_doc;

    public function __construct(string $titulo) {
        parent::__construct('P', 'mm', 'A4');
        $this->titulo_doc = $titulo;
    }

    public function Header(): void {
        $this->SetFont('Arial', 'B', 9);
        $this->SetTextColor(91, 79, 192);
        $this->Cell(0, 8, conv('HERANÇA DIGITAL | ' . mb_strtoupper($this->titulo_doc)), 0, 1, 'C');
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(91, 79, 192);
        $this->SetLineWidth(0.4);
        $this->Line(15, $this->GetY(), 195, $this->GetY());
        $this->Ln(3);
    }

    public function Footer(): void {
        $this->SetY(-12);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(150, 150, 150);
        $this->Cell(0, 5, conv('Modelo orientativo | não substitui análise jurídica especializada · Página ' . $this->PageNo()), 0, 0, 'C');
    }
}

$pdf = new TestamentoPDF($nome_modelo);
$pdf->SetMargins(20, 20, 20);
$pdf->SetAutoPageBreak(true, 18);
$pdf->AddPage();

// Corpo do testamento
$pdf->SetFont('Arial', '', 11);
$pdf->SetTextColor(0, 0, 0);

$linhas = explode("\n", $texto);
$prev_blank = false;

foreach ($linhas as $linha) {
    $linha = trim($linha);

    if ($linha === '') {
        if (!$prev_blank) $pdf->Ln(3);
        $prev_blank = true;
        continue;
    }
    $prev_blank = false;

    // Detectar títulos de seção (ex: "1. DAS DISPOSIÇÕES GERAIS")
    $e_titulo_secao = preg_match('/^\d+[\.\s]+[A-ZÁÀÂÃÉÊÍÓÔÕÚÇ\s]{6,}$/u', $linha)
                   || preg_match('/^TESTAMENTO\s/iu', $linha)
                   || (mb_strtoupper($linha, 'UTF-8') === $linha && mb_strlen($linha) > 8 && mb_strlen($linha) < 120);

    $linha_pdf = conv($linha);

    if ($e_titulo_secao) {
        if ($pdf->GetY() > 240) {
            $pdf->AddPage();
        } else {
            $pdf->Ln(4);
        }
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->MultiCell(0, 6, $linha_pdf, 0, 'C');
        $pdf->SetFont('Arial', '', 11);
        $pdf->Ln(2);
    } else {
        $pdf->MultiCell(0, 6, $linha_pdf, 0, 'J');
    }
}

// ── Enviar para download ──────────────────────────────────────────
$nome_arquivo = 'testamento_' . preg_replace('/[^a-z0-9]/i', '_', $chave) . '_' . date('Ymd') . '.pdf';

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . $nome_arquivo . '"');
header('Cache-Control: no-cache, no-store');

$pdf->Output('D', $nome_arquivo);
exit;

// ════════════════════════════════════════
// FUNÇÕES AUXILIARES
// ════════════════════════════════════════

/**
 * Converte UTF-8 → ISO-8859-1 com mapeamento manual dos caracteres
 * que o iconv/mb_convert_encoding costumam perder (–, —, ", ", ', ' etc.)
 */
function conv(string $str): string {
    // Mapeamento de caracteres Unicode problemáticos → equivalentes ISO
    $mapa = [
        "\u{2013}" => '-',   // en dash –
        "\u{2014}" => '-',   // em dash —
        "\u{201C}" => '"',   // aspas "
        "\u{201D}" => '"',   // aspas "
        "\u{2018}" => "'",   // aspas '
        "\u{2019}" => "'",   // aspas '
        "\u{2026}" => '...',  // reticências …
        "\u{00B0}" => 'o',   // grau °  (em "nº" vira "no")
        "\u{00BA}" => 'o',   // ordinal masculino º
        "\u{00AA}" => 'a',   // ordinal feminino ª
        "\u{00AD}" => '-',   // hífen suave
        "\u{2012}" => '-',   // figure dash
        "\u{2015}" => '-',   // horizontal bar
        "\u{00A0}" => ' ',   // non-breaking space
        "\u{2022}" => '-',   // bullet •
        "\u{00AB}" => '"',   // «
        "\u{00BB}" => '"',   // »
    ];

    $str = str_replace(array_keys($mapa), array_values($mapa), $str);

    // Converte o restante
    return mb_convert_encoding($str, 'ISO-8859-1', 'UTF-8');
}



function nome_mes(int $m): string {
    $meses = ['','janeiro','fevereiro','março','abril','maio','junho',
              'julho','agosto','setembro','outubro','novembro','dezembro'];
    return $meses[$m] ?? '';
}
