<?php
// Iniciar a ligação à base de dados e carregar controllers
require_once 'config/Database.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/SocioController.php';

$database = new Database();
$db = $database->getConnection();

$authController = new AuthController($db);
$socioController = new SocioController($db);


$acao = $_GET['acao'] ?? $_GET['action'] ?? 'login';

switch ($acao) {
    
    case 'login':
        $authController->login();
        break;

    case 'registo':
        $authController->registo();
        break;

    case 'logout':
        $authController->logout();
        break;

    
    case 'listar':
    case 'listar_socios':
        $socioController->listar(); // 
        break;

    case 'criar':
    case 'criar_socio':
        $socioController->criar();
        break;

    case 'editar':
    case 'editar_socio':
        $socioController->editar();
        break;

    case 'eliminar':
    case 'apagar_socio':
        $socioController->apagar();
        break;

    default:
        $authController->login();
        break;
}
?>