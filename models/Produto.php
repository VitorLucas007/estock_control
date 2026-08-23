<?php
require_once __DIR__ . '/../config/conecta.php';

class Produto
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Conexao::getInstancia();
    }

    public function getMetricas(): array
    {
        $stmtTotal = $this->db->query("SELECT SUM(quantidade) as total FROM produtos");
        $total = $stmtTotal->fetch()['total'] ?? 0;
        $stmtItens = $this->db->query("SELECT COUNT(*) as total_itens FROM produtos");
        $totalItens = $stmtItens->fetch()['total_itens'] ?? 0;
        return ['total_estoque' => (int)$total, 'total_itens' => (int)$totalItens];
    }

    public function listarTodos(string $ordem = 'id_desc'): array
    {
        // Define a ordenação padrão
        $orderBy = 'id DESC';

        // Altera a ordenação baseada na escolha do usuário
        switch ($ordem) {
            case 'nome_asc':
                $orderBy = 'nome ASC';
                break;
            case 'nome_desc':
                $orderBy = 'nome DESC';
                break;
            case 'preco_asc':
                $orderBy = 'preco ASC';
                break;
            case 'preco_desc':
                $orderBy = 'preco DESC';
                break;
            case 'id_asc':
                $orderBy = 'id ASC'; // Mais antigos primeiro
                break;
            case 'id_desc':
            default:
                $orderBy = 'id DESC'; // Mais recentes primeiro
                break;
        }

        $stmt = $this->db->query("SELECT * FROM produtos ORDER BY $orderBy");
        return $stmt->fetchAll();
    }

    public function cadastrar(array $dados, ?array $file): bool
    {
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

    public function atualizar(array $dados, ?string $nomeImagem): bool
    {
        $sql = "UPDATE produtos SET 
                    codigo = :codigo,
                    nome = :nome, 
                    categoria_id = :categoria,
                    preco = :preco, 
                    quantidade = :quantidade, 
                    descricao = :descricao,
                    imagem = :imagem
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':codigo'     => $dados['codigo'],
            ':nome'       => $dados['nome'],
            ':categoria'  => $dados['categoria'],
            ':preco'      => $dados['preco'],
            ':quantidade' => $dados['quantidade'],
            ':descricao'  => $dados['descricao'],
            ':imagem'     => $nomeImagem,
            ':id'         => $dados['id']
        ]);
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM produtos WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
