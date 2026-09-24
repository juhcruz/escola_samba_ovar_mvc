<?php

class User
{
    private $conn;
    private $table_name = "users";

    public $id;
    public $nome;
    public $utilizador;
    public $palavra_passe;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Registar novo utilizador na base de dados
    public function registo($data)
    {
        $query = "INSERT INTO " . $this->table_name . " (nome, utilizador, palavra_passe) 
                  VALUES (:nome, :utilizador, :palavra_passe)";
        
        $stmt = $this->conn->prepare($query);

        // Criar o hash seguro da palavra-passe
        $hashed_password = password_hash($data['palavra_passe'], PASSWORD_DEFAULT);

        $stmt->bindParam(":nome", $data['nome']);
        $stmt->bindParam(":utilizador", $data['utilizador']);
        $stmt->bindParam(":palavra_passe", $hashed_password);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Procurar utilizador pelo nome de utilizador (útil para o login)
    public function lerPorUtilizador($utilizador)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE utilizador = :utilizador LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":utilizador", $utilizador);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>