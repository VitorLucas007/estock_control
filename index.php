<?php
session_start();

require_once 'controllers/AuthController.php';
require_once 'controllers/ProdutoController.php';

$route = $_GET['route'] ?? 'dashboard';

$authController = new AuthController();
$produtoController = new ProdutoController();

switch ($route) {
    case 'login':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'cadastrar_admin':
        $authController->cadastrarAdmin();
        break;
    case 'dashboard':
        $produtoController->index();
        break;
    case 'cadastrar_produto':
        $produtoController->create();
        break;
    default:
        $produtoController->index();
        break;
}