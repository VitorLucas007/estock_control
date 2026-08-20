<?php
require_once 'models/Usuario.php';

class AuthController {
    
    public function login() {
        // Se já estiver logado, manda pro dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: index.php?route=dashboard');
            exit;
        }

        $erro = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $senha = trim($_POST['senha'] ?? '');

            $usuarioModel = new Usuario();
            $usuario = $usuarioModel->autenticar($email, $senha);

            if ($usuario) {
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_nome'] = $usuario['nome'];
                header('Location: index.php?route=dashboard');
                exit;
            } else {
                $erro = true;
            }
        }

        require_once 'views/login.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php?route=login');
        exit;
    }

    public function cadastrarAdmin() {
        $mensagemErro = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = trim($_POST['nome'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $senha = trim($_POST['senha'] ?? '');
            
            if (strlen($senha) < 6) {
                $mensagemErro = "A senha deve ter pelo menos 6 caracteres.";
            } else {
                try {
                    $usuarioModel = new Usuario();
                    $usuarioModel->cadastrar($nome, $email, $senha);
                    header('Location: index.php?route=login&success=registered');
                    exit;
                } catch (Exception $e) {
                    $mensagemErro = $e->getMessage();
                }
            }
        }

        require_once 'views/cadastrar_admin.php';
    }
}