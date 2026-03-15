<?php
// ═══════════════════════════════════════
// DIRECIONAMENTO — Mapeia as respostas
// do formulário JS para a chave correta
// do modelo em modelos_texto.php
// ═══════════════════════════════════════

/**
 * Recebe o array de respostas enviado pelo formulário JS
 * e retorna ['chave' => 'modelo_XX', 'nome' => 'Testamento para ...']
 *
 * As chaves das respostas correspondem exatamente ao objeto A do JS:
 *   obj, modal, excl_acesso, excl_contas, desaparecer,
 *   tem_econ, gera_renda, transf_econ, pat_total, unico,
 *   p_esp, resp_p, conj, divide,
 *   cria, autoria, adm_obras, obras_unico,
 *   ilu, foto, texto, vid, soft, mus, pesq,
 *   inv, inv_resp, mem, mem_adm
 */
function determinar_modelo(array $r, string $modalidade = 'particular'): array
{
    $tipo = _resolver_tipo($r);
    return _chave_e_nome($tipo, $modalidade);
}

// ── Resolve o tipo interno (igual ao resolveType() do JS) ───────────────────
function _resolver_tipo(array $r): string
{
    $obj = $r['obj'] ?? '';

    // Atalhos diretos do objetivo
    if ($obj === 'memorial')    return 'memorial';
    if ($obj === 'fotos')       return 'fotografias';
    if ($obj === 'ilustracoes') return 'ilustracoes';
    if ($obj === 'textos')      return 'textos';
    if ($obj === 'videos')      return 'videos';
    if ($obj === 'software')    return 'software';
    if ($obj === 'musica')      return 'musicas';
    if ($obj === 'pesquisa')    return 'pesquisa';

    // Bloco exclusão / desaparecimento
    if ((_v($r,'desaparecer')) === 'sim')                                   return 'desaparecer';
    if (_v($r,'excl_acesso') === 'sim' || _v($r,'excl_contas') === 'sim')  return 'negativo';

    // Bloco econômico
    if (_v($r,'transf_econ') === 'sim') return 'economico';
    if (_v($r,'transf_econ') === 'nao') return 'negativo';

    // Bloco acervo total
    if (_v($r,'pat_total') === 'nenhum')  return 'negativo';
    if (_v($r,'pat_total') === 'so_econ') return 'economico';
    if (_v($r,'unico')     === 'sim')     return 'completo';

    // Bloco pessoa específica
    if (_v($r,'resp_p') === 'sim') return 'pessoa';

    // Bloco contas conjuntas
    if (_v($r,'divide') === 'sim') return 'conjunto';

    // Bloco obras autorais gerais
    if (_v($r,'obras_unico') === 'sim') return 'autoral';

    // Obras específicas
    if (_v($r,'ilu')   === 'sim') return 'ilustracoes';
    if (_v($r,'foto')  === 'sim') return 'fotografias';
    if (_v($r,'texto') === 'sim') return 'textos';
    if (_v($r,'vid')   === 'sim') return 'videos';
    if (_v($r,'soft')  === 'sim') return 'software';
    if (_v($r,'mus')   === 'sim') return 'musicas';
    if (_v($r,'pesq')  === 'sim') return 'pesquisa';

    // Inventariante
    if (_v($r,'inv_resp') === 'sim') return 'inventariante';

    // Memorial
    if (_v($r,'mem') === 'sim') return 'memorial';

    // Fallback
    return 'negativo';
}

function _v(array $r, string $k): string
{
    return $r[$k] ?? '';
}

// ── Mapa tipo → chave do modelo + nome legível ──────────────────────────────
function _chave_e_nome(string $tipo, string $modalidade): array
{
    // [tipo] => [chave_particular, chave_cerrada, nome]
    $mapa = [
        'negativo'     => ['modelo_01', 'modelo_02', 'Testamento Digital Negativo'],
        'desaparecer'  => ['modelo_03', 'modelo_03_2', 'Testamento para Desaparecimento Virtual'],
        'economico'    => ['modelo_04', 'modelo_04_2', 'Testamento para Bens Digitais com Valor Econômico'],
        'completo'     => ['modelo_05', 'modelo_05_2', 'Testamento para Acervo Digital Completo'],
        'pessoa'       => ['modelo_06', 'modelo_06_2', 'Testamento para Transmissão a Pessoa Específica'],
        'conjunto'     => ['modelo_07', 'modelo_07_2', 'Testamento para Contas Conjuntas ou Compartilhadas'],
        'autoral'      => ['modelo_08', 'modelo_09',   'Testamento para Bens Protegidos pelo Direito Autoral'],
        'ilustracoes'  => ['modelo_10', 'modelo_10_2', 'Testamento para Ilustrações e Desenhos Digitais'],
        'fotografias'  => ['modelo_11', 'modelo_11_2', 'Testamento para Fotografias Digitais Autorais'],
        'textos'       => ['modelo_12', 'modelo_12_2', 'Testamento para Textos Literários, Artísticos ou Científicos'],
        'videos'       => ['modelo_13', 'modelo_13_2', 'Testamento para Vídeos Digitais Autorais'],
        'software'     => ['modelo_14', 'modelo_14_2', 'Testamento para Programa de Computador'],
        'musicas'      => ['modelo_15', 'modelo_15_2', 'Testamento para Músicas e Composições Digitais'],
        'pesquisa'     => ['modelo_16', 'modelo_16_2', 'Testamento para Pesquisa Científica e Acervo de Estudo'],
        'inventariante'=> ['modelo_17', 'modelo_17_2', 'Testamento para Nomeação de Inventariante Digital'],
        'memorial'     => ['modelo_18', 'modelo_18_2', 'Testamento para Transformação de Redes Digitais em Memoriais'],
    ];

    if (!array_key_exists($tipo, $mapa)) {
        $tipo = 'negativo';
    }

    [$chave_part, $chave_cerr, $nome] = $mapa[$tipo];

    $chave = ($modalidade === 'cerrado') ? $chave_cerr : $chave_part;

    return ['chave' => $chave, 'nome' => $nome, 'tipo' => $tipo];
}
