<?php
require_once 'models/Produto.php';

class ProdutoController {
    
    // Verifica se está logado
    private function checarAutenticacao() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }
    }

    // Exibe o Dashboard
    public function index() {
        $this->checarAutenticacao();
        $produtoModel = new Produto();
        
        // Pega dados do Model
        $metricas = $produtoModel->getMetricas();
        $produtos = $produtoModel->listarTodos();
        
        // Carrega a View (as variáveis acima estarão disponíveis nela)
        require_once 'views/dashboard.php';
    }

    public function create() {
        $this->checarAutenticacao();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $produtoModel = new Produto();
            $produtoModel->cadastrar($_POST, $_FILES['imagem']);
            header('Location: index.php?route=dashboard&status=success');
            exit;
        }

        // Busca as categorias do banco
        require_once 'models/Categoria.php';
        $categoriaModel = new Categoria();
        $categorias = $categoriaModel->listarTodas();

        // Passa a variável $categorias para a View
        require_once 'views/cadastro_produto.php';
    }
}