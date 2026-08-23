<?php
require_once 'models/Produto.php';

class ProdutoController
{

    // Verifica se está logado
    private function checarAutenticacao()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?route=login');
            exit;
        }
    }

    // Exibe o Dashboard
    public function index()
    {
        $this->checarAutenticacao();

        $produtoModel = new Produto();
        $metricas = $produtoModel->getMetricas();

        // NOVO: Captura a ordenação da URL (se não tiver, usa 'id_desc' como padrão)
        $ordem = $_GET['sort'] ?? 'id_desc';

        // Passa a variável $ordem para o Model
        $produtos = $produtoModel->listarTodos($ordem);

        // Busca as categorias para preencher o <select> do popup de edição
        require_once 'models/Categoria.php';
        $categoriaModel = new Categoria();
        $categorias = $categoriaModel->listarTodas();

        // Carrega a View
        require_once 'views/dashboard.php';
    }

    public function create()
    {
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

    public function update()
    {
        $this->checarAutenticacao();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Pega o nome da imagem antiga por padrão
            $imagemFinal = $_POST['imagem_antiga'] ?? null;

            // Verifica se o usuário enviou uma IMAGEM NOVA no popup
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
                $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));

                if (in_array($extensao, ['jpg', 'jpeg', 'png', 'webp'])) {
                    $novoNome = uniqid('prd_') . '.' . $extensao;
                    $destino = __DIR__ . '/../uploads/' . $novoNome;

                    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $destino)) {
                        $imagemFinal = $novoNome; // Atualiza para o novo nome da imagem

                        // Apaga a imagem antiga do servidor para economizar espaço
                        $imagemAntigaPath = __DIR__ . '/../uploads/' . $_POST['imagem_antiga'];
                        if (!empty($_POST['imagem_antiga']) && file_exists($imagemAntigaPath)) {
                            unlink($imagemAntigaPath);
                        }
                    }
                }
            }

            // Envia os dados e o nome da imagem final para o Model salvar
            $produtoModel = new Produto();
            $produtoModel->atualizar($_POST, $imagemFinal);

            header('Location: index.php?route=dashboard&status=editado');
            exit;
        }
    }

    public function delete()
    {
        $this->checarAutenticacao();
        if (isset($_GET['id'])) {
            $produtoModel = new Produto();
            $produtoModel->excluir((int)$_GET['id']);
            header('Location: index.php?route=dashboard&status=excluido');
            exit;
        }
    }
}
