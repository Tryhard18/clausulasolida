<?php
/**
 * Cláusula Sólida — Processamento do Formulário de Contacto
 * Proteção: CSRF, Rate Limiting, Prepared Statements
 */

session_start();
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');

require_once __DIR__ . '/db_config.php';

define('MAX_PEDIDOS_POR_HORA', 5);
define('TAMANHO_MAX_MENSAGEM', 5000);

function responderJSON(bool $sucesso, string $mensagem, int $codigo = 200): void {
    http_response_code($codigo);
    echo json_encode(['sucesso' => $sucesso, 'mensagem' => $mensagem], JSON_UNESCAPED_UNICODE);
    exit;
}

function sanitizar(string $valor): string {
    return htmlspecialchars(trim($valor), ENT_QUOTES, 'UTF-8');
}

// 1. Verificar Método
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responderJSON(false, 'Método não permitido.', 405);
}

// 2. Verificar CSRF
$tokenRecebido = $_POST['csrf_token'] ?? '';
$tokenSessao   = $_SESSION['csrf_token'] ?? '';
if (empty($tokenRecebido) || empty($tokenSessao) || !hash_equals($tokenSessao, $tokenRecebido)) {
    responderJSON(false, 'Token de segurança inválido. Recarregue a página.', 403);
}

// 3. Rate Limiting
$agora = time();
if (!isset($_SESSION['contacto_tentativas'])) $_SESSION['contacto_tentativas'] = [];
$_SESSION['contacto_tentativas'] = array_filter($_SESSION['contacto_tentativas'], fn($t) => ($agora - $t) < 3600);
if (count($_SESSION['contacto_tentativas']) >= MAX_PEDIDOS_POR_HORA) {
    responderJSON(false, 'Limite de pedidos atingido. Tente mais tarde.', 429);
}

// 4. Sanitizar Dados
$nome     = sanitizar($_POST['nome'] ?? '');
$email    = sanitizar($_POST['email'] ?? '');
$telefone = sanitizar($_POST['telefone'] ?? '');
$assunto  = sanitizar($_POST['assunto'] ?? '');
$mensagem = sanitizar($_POST['mensagem'] ?? '');

// 5. Validação
$erros = [];
if (empty($nome) || mb_strlen($nome) < 2) $erros[] = 'Nome obrigatório (mín. 2 caracteres).';
if (mb_strlen($nome) > 100) $erros[] = 'Nome: máx. 100 caracteres.';
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $erros[] = 'E-mail inválido.';
if (!empty($telefone) && !preg_match('/^[\d\s\+\-\(\)]{7,20}$/', $telefone)) $erros[] = 'Telefone inválido.';
if (mb_strlen($assunto) > 200) $erros[] = 'Assunto: máx. 200 caracteres.';
if (empty($mensagem) || mb_strlen($mensagem) < 10) $erros[] = 'Mensagem obrigatória (mín. 10 caracteres).';
if (mb_strlen($mensagem) > TAMANHO_MAX_MENSAGEM) $erros[] = 'Mensagem: máx. ' . TAMANHO_MAX_MENSAGEM . ' caracteres.';
if (!empty($erros)) responderJSON(false, implode(' ', $erros), 422);

// 6. Inserir na BD (Prepared Statement)
try {
    $pdo = obterConexao();
    $sql = "INSERT INTO contactos (nome, email, telefone, assunto, mensagem, ip_address, user_agent) VALUES (:nome, :email, :telefone, :assunto, :mensagem, :ip, :ua)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nome' => $nome, ':email' => $email,
        ':telefone' => $telefone ?: null, ':assunto' => $assunto ?: null,
        ':mensagem' => $mensagem,
        ':ip' => $_SERVER['REMOTE_ADDR'] ?? 'desconhecido',
        ':ua' => mb_substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 255)
    ]);
    $_SESSION['contacto_tentativas'][] = $agora;
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    responderJSON(true, 'Mensagem enviada com sucesso! Entraremos em contacto brevemente.');
} catch (PDOException $e) {
    error_log('Erro ao inserir contacto: ' . $e->getMessage());
    responderJSON(false, 'Erro ao enviar. Tente novamente mais tarde.', 500);
}


