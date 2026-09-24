<?php

class User
{
    private $conn;
    private $table_name = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function registo($data)
    {
        $query = "INSERT INTO " . $this->table_name . " 
                  (nome, utilizador, palavra_passe) 
                  VALUES (:nome, :utilizador, :palavra_passe)";

        $stmt = $this->conn->prepare($query);

        // Encriptar a palavra-passe por segurança académica recomendada
        $passwordHash = password_hash($data['palavra_passe'], PASSWORD_DEFAULT);

        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':utilizador', $data['utilizador']);
        $stmt->bindParam(':palavra_passe', $passwordHash);

        return $stmt->execute();
    }
}
?>