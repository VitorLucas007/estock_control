<?php
require_once __DIR__ . '/../config/conecta.php';

class Categoria {
    private PDO $db;

    public function __construct() {
        $this->db = Conexao::getInstancia();
    }

    public function listarTodas(): array {
        $stmt = $this->db->query("SELECT * FROM categorias ORDER BY nome ASC");
        return $stmt->fetchAll();
    }
}