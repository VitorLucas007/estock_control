<?php
require_once __DIR__ . '/../config/conecta.php';

class Usuario {
    private PDO $db;

    public function __construct() {
        $this->db = Conexao::getInstancia();
    }

    public function cadastrar(string $nome, string $email, string $senha): bool {
        if ($this->buscarPorEmail($email)) {
            throw new Exception("Este e-mail já está cadastrado.");
        }
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (:nome, :email, :senha)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':nome' => $nome, ':email' => $email, ':senha' => $senhaHash]);
    }

    public function autenticar(string $email, string $senha): ?array {
        $usuario = $this->buscarPorEmail($email);
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            unset($usuario['senha']);
            return $usuario;
        }
        return null;
    }

    public function buscarPorEmail(string $email): ?array {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $resultado = $stmt->fetch();
        return $resultado ?: null;
    }
}