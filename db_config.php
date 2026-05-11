<?php
/**
 * =====================================================
 * Cláusula Sólida — Configuração da Base de Dados
 * =====================================================
 *
 * Ficheiro de configuração para a ligação à base de dados
 * MySQL via PDO. Utiliza prepared statements para
 * proteção contra SQL Injection.
 *
 * IMPORTANTE: Em produção, mova este ficheiro para fora
 * do diretório público (public_html) ou proteja-o via
 * .htaccess.
 */

// =====================================================
// Constantes de Ligação à Base de Dados
// =====================================================
define('DB_HOST',     'localhost');
define('DB_NAME',     'clausula_solida');
define('DB_USER',     'root');           // Alterar em produção
define('DB_PASSWORD', '');               // Alterar em produção
define('DB_CHARSET',  'utf8mb4');

// =====================================================
// Modo de execução (true = desenvolvimento, false = produção)
// =====================================================
define('DEV_MODE', false);

/**
 * Obtém uma ligação PDO à base de dados.
 *
 * @return PDO Instância de ligação PDO
 * @throws PDOException Se a ligação falhar (apenas em modo dev)
 */
function obterConexao(): PDO
{
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        DB_HOST,
        DB_NAME,
        DB_CHARSET
    );

    $opcoes = [
        // Usar exceções para erros
        PDO::ATTR_ERRMODE            => DEV_MODE
            ? PDO::ERRMODE_EXCEPTION
            : PDO::ERRMODE_SILENT,
        // Retornar arrays associativos por defeito
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Desativar emulação de prepared statements (mais seguro)
        PDO::ATTR_EMULATE_PREPARES   => false,
        // Timeout de ligação (segundos)
        PDO::ATTR_TIMEOUT            => 5,
    ];

    try {
        $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $opcoes);
        return $pdo;
    } catch (PDOException $e) {
        if (DEV_MODE) {
            throw $e;
        }
        // Em produção, registar o erro e mostrar mensagem genérica
        error_log('Erro de ligação à BD: ' . $e->getMessage());
        http_response_code(500);
        die(json_encode([
            'sucesso' => false,
            'mensagem' => 'Erro interno do servidor. Tente novamente mais tarde.'
        ]));
    }
}


