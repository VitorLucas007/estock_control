<?php
require_once __DIR__ . '/../config/conecta.php';

class Produto {
    private PDO $db;

    public function __construct() {
        $this->db = Conexao::getInstancia();
    }

    public function getMetricas(): array {
        $stmtTotal = $this->db->query("SELECT SUM(quantidade) as total FROM produtos");
        $total = $stmtTotal->fetch()['total'] ?? 0;
        $stmtItens = $this->db->query("SELECT COUNT(*) as total_itens FROM produtos");
        $totalItens = $stmtItens->fetch()['total_itens'] ?? 0;
        return ['total_estoque' => (int)$total, 'total_itens' => (int)$totalItens];
    }

    public function listarTodos(): array {
        $stmt = $this->db->query("SELECT * FROM produtos ORDER BY id DESC");
        return $stmt->fetchAll();
    }

    public function cadastrar(array $dados, ?array $file): bool {
        $nomeImagem = null;
        if ($file && $file['error'] === UPLOAD_ERR_OK) {
            $extensao = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (in_array($extensao, ['jpg', 'jpeg', 'png', 'webp'])) {
                $nomeImagem = uniqid('prd_') . '.' . $extensao;
                move_uploaded_file($file['tmp_name'], __DIR__ . '/../uploads/' . $nomeImagem);
            }
        }
        $sql = "INSERT INTO produtos (nome, codigo, categoria_id, preco, quantidade, imagem, descricao) 
                VALUES (:nome, :codigo, :categoria, :preco, :quantidade, :imagem, :descricao)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nome' => $dados['nome'] ?? '',
            ':codigo' => $dados['codigo'] ?? '',
            ':categoria' => $dados['categoria'] ?? 0,
            ':preco' => $dados['preco'] ?? 0,
            ':quantidade' => $dados['quantidade'] ?? 0,
            ':imagem' => $nomeImagem,
            ':descricao' => $dados['descricao'] ?? null,
        ]);
    }
}