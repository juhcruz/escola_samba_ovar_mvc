<?php

class Database
{
    private $host = "localhost";
    private $db_name = "escola_samba_ovar_mvc";
    private $username = "root";
    private $password = "";
    public $conn;

    // Obter a ligação à base de dados via PDO
    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8",
                $this->username,
                $this->password
            );
            // Configurar o modo de erro do PDO para exceções
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Erro na ligação à base de dados: " . $exception->getMessage();
        }

        return $this->conn;
    }
}

?>