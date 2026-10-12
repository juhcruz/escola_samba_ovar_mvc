<?php

class Database
{
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

    public function __construct()
    {
        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->db_name = getenv('DB_NAME') ?: 'escola_samba_ovar_mvc';
        $this->username = getenv('DB_USERNAME') ?: 'root';
        $this->password = getenv('DB_PASSWORD') ?: '';
    }

    // Obter a ligação à base de dados via PDO
    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';charset=utf8mb4',
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );

            $this->conn->exec('CREATE DATABASE IF NOT EXISTS `' . str_replace('`', '``', $this->db_name) . '` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');

            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=utf8mb4',
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );

            $this->initializeSchema();
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            http_response_code(503);
            exit('O serviço está temporariamente indisponível.');
        }

        return $this->conn;
    }

    private function initializeSchema()
    {
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS socios (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                numero_socio VARCHAR(20) NOT NULL UNIQUE,
                nome_completo VARCHAR(150) NOT NULL,
                categoria VARCHAR(50) NOT NULL,
                contacto VARCHAR(20) NOT NULL,
                quota_regularizada TINYINT(1) DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(100) NOT NULL,
                utilizador VARCHAR(50) NOT NULL UNIQUE,
                palavra_passe VARCHAR(255) NOT NULL,
                role VARCHAR(20) NOT NULL DEFAULT 'user',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");

        try {
            $this->conn->query('SELECT role FROM users LIMIT 0');
        } catch (PDOException $exception) {
            $this->conn->exec("ALTER TABLE users ADD COLUMN role VARCHAR(20) NOT NULL DEFAULT 'user'");
        }
    }
}

?>