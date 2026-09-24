<?php
// index.php - Ponto de Entrada / Router Principal

// Iniciar sessão para gerir autenticações se necessário
session_start();

// Incluir os controladores necessários
require_once 'controllers/SocioController.php';
require_once 'controllers/UtilizadorController.php';

// Instanciar os controladores
$socioController = new SocioController();
$utilizadorController = new UtilizadorController();

// Obter a ação vinda do URL (se não for especificada, assume 'listar' por defeito)
$acao = $_GET['acao'] ?? 'listar';

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
        $socioController->mudarStatus();
        break;
        
    case 'eliminar':
    case 'apagar':
        $socioController->apagar();
        break;

    // Gestão de Utilizadores / Autenticação
    case 'registo':
        $utilizadorController->registo();
        break;
        
    case 'login':
        $utilizadorController->login();
        break;
        
    default:
        echo "<h2 style='color: red; text-align: center; margin-top: 50px;'>Erro 404: Ação não encontrada no sistema.</h2>";
        echo "<p style='text-align: center;'><a href='index.php'>Voltar ao início</a></p>";
        break;
}
?>