<?php

class Database
{
    private $host = "localhost";
    private $db_name = "escola_samba_ovar_mvc";
    private $username = "root";
    private $password = "";
    private $sqlite_path;
    public $conn;

    public function __construct()
    {
        $this->sqlite_path = __DIR__ . '/../database.sqlite';
    }

    // Obter a ligação à base de dados via PDO
    public function getConnection()
    {
        $this->conn = null;

        try {
            if (extension_loaded('pdo_mysql')) {
                $this->conn = new PDO(
                    "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                    $this->username,
                    $this->password
                );
            } else {
                $this->conn = new PDO('sqlite:' . $this->sqlite_path);
            }

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $this->initializeSchema();
        } catch (PDOException $exception) {
            echo "Erro na ligação à base de dados: " . $exception->getMessage();
        }

        return $this->conn;
    }

    private function initializeSchema()
    {
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS socios (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                numero_socio VARCHAR(20) NOT NULL UNIQUE,
                nome_completo VARCHAR(150) NOT NULL,
                categoria VARCHAR(50) NOT NULL,
                contacto VARCHAR(20) NOT NULL,
                quota_regularizada INTEGER DEFAULT 1,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP
            );
        ");

        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                nome VARCHAR(100) NOT NULL,
                utilizador VARCHAR(50) NOT NULL UNIQUE,
                palavra_passe VARCHAR(255) NOT NULL,
                created_at TEXT DEFAULT CURRENT_TIMESTAMP
            );
        ");
    }
}

?>