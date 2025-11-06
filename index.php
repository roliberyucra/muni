<?php
session_start();

require_once __DIR__ . "/config/config.php";
require_once __DIR__ . "/app/controllers/MunicipioController.php";
require_once __DIR__ . "/app/controllers/ClienteController.php";
require_once __DIR__ . "/app/controllers/AuthController.php";
require_once __DIR__ . "/app/controllers/TokenController.php";

if (!isset($pdo)) die("No DB");

$municipioController = new MunicipioController($pdo);
$clienteController   = new ClienteController($pdo);
$authController      = new AuthController($pdo);
$tokenController     = new TokenController($pdo);

$action = $_GET['action'] ?? 'index';

switch ($action) {

    /* MUNICIPIOS */
    case 'index':
        if (!isset($_SESSION['user'])) header("Location: index.php?action=loginForm");
        $municipioController->index();
        break;

    case 'createForm':
        $municipioController->createForm();
        break;

    case 'store':
        $municipioController->store($_POST);
        break;

    /* CLIENTES */
    case 'clientes':
        $clienteController->index();
        break;

    case 'clienteCreateForm':
        $clienteController->createForm();
        break;

    case 'clienteStore':
        $clienteController->store($_POST);
        break;

    /* TOKENS */
    case 'tokens':
        $tokenController->index();
        break;

    case 'createTokenForm':
        $tokenController->createForm();
        break;

    case 'storeToken':
        $tokenController->store($_POST);
        break;

    /* AUTH */
    case 'loginForm':
        $authController->loginForm();
        break;

    case 'login':
        $authController->login($_POST);
        break;

    case 'logout':
        $authController->logout();
        break;

    default:
        echo "Acción no válida.";
}
