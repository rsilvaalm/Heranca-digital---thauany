<?php
// ═══════════════════════════════════════
// CONFIG — Conexão com o banco de dados
// Ajuste as credenciais conforme seu servidor
// ═══════════════════════════════════════

define('DB_HOST', 'localhost');
define('DB_NAME', 'heranca_digital');
define('DB_USER', 'root');       // altere para seu usuário
define('DB_PASS', '');           // altere para sua senha
define('DB_CHARSET', 'utf8mb4');

function db_connect(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }
    return $pdo;
}
