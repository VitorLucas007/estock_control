<?php
// config/conecta.php

date_default_timezone_set('America/Fortaleza');

class Conexao {
    private static $host = "127.0.0.1";
    private static $dbname = "sistema_estoque";
    private static $user = "root";
    private static $pass = ""; // Sua senha do MariaDB no HeidiSQL

    /**
     * Retorna uma instância de conexão com o banco de dados usando o padrão Singleton.
     */
    public static function getInstancia() {
        try {
            // Cria a conexão PDO com UTF-8 configurado nativamente
            $pdo = new PDO(
                "mysql:host=" . self::$host . ";dbname=" . self::$dbname . ";charset=utf8mb4",
                self::$user,
                self::$pass,
                [
                    // Dispara exceções em caso de erro no SQL
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    // Retorna os resultados como arrays associativos (ex: $linha['campo'])
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    // Força o uso de Prepared Statements reais para segurança contra SQL Injection
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            return $pdo;
        } catch (PDOException $e) {
            // Em caso de falha de conexão, responde com erro HTTP 500
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Erro interno: Não foi possível conectar ao banco de dados."
            ]);
            exit; // Interrompe o script imediatamente
        }
    }
}
?>