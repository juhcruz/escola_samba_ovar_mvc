<?php
// index.php - Ponto de Entrada / Router Principal

// Iniciar sessão com opções seguras para autenticação e CSRF.
session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'
]);
session_start();

// Incluir os controladores necessários
require_once 'controllers/SocioController.php';
require_once 'controllers/UtilizadorController.php';

// Instanciar os controladores
$socioController = new SocioController();
$utilizadorController = new UtilizadorController();

// Obter a ação vinda do URL (se não for especificada, assume 'listar' por defeito)
$acao = $_GET['acao'] ?? 'listar';

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verificar_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';

    if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(419);
        exit('Pedido inválido. Atualize a página e tente novamente.');
    }
}

function exigir_autenticacao(): void
{
    if (empty($_SESSION['user_id'])) {
        header('Location: index.php?acao=login');
        exit();
    }
}

if (!in_array($acao, ['login', 'registo', 'logout'], true)) {
    exigir_autenticacao();
}

// Estrutura de decisão (Router) para direcionar cada pedido
switch ($acao) {
    // Gestão de Sócios
    case 'listar':
        $socioController->listar();
        break;
        
    case 'criar':
        $socioController->criar();
        break;
        
    case 'editar':
        $socioController->editar();
        break;
        
    case 'status':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Método não permitido.');
        }
        verificar_csrf();
        $socioController->mudarStatus();
        break;
        
    case 'eliminar':
    case 'apagar':
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit('Método não permitido.');
        }
        verificar_csrf();
        $socioController->apagar();
        break;

    // Gestão de Utilizadores / Autenticação
    case 'registo':
        $utilizadorController->registo();
        break;
        
    case 'login':
        $utilizadorController->login();
        break;

    case 'logout':
        $utilizadorController->logout();
        break;
        
    default:
        echo "<h2 style='color: red; text-align: center; margin-top: 50px;'>Erro 404: Ação não encontrada no sistema.</h2>";
        echo "<p style='text-align: center;'><a href='index.php'>Voltar ao início</a></p>";
        break;
}
?>