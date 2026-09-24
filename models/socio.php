<?php

class Socio
{
    private $conn;
    private $table_name = "socios";

    public $id;
    public $numero_socio;
    public $nome_completo;
    public $categoria;
    public $contacto;
    public $quota_regularizada;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Listar todos os sócios
    public function lerTodos()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Inserir sócio
    public function inserir()
    {
        $query = "INSERT INTO " . $this->table_name .
                 " (numero_socio, nome_completo, categoria, contacto, quota_regularizada)
                  VALUES (:numero_socio, :nome_completo, :categoria, :contacto, :quota_regularizada)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":numero_socio", $this->numero_socio);
        $stmt->bindParam(":nome_completo", $this->nome_completo);
        $stmt->bindParam(":categoria", $this->categoria);
        $stmt->bindParam(":contacto", $this->contacto);
        $stmt->bindParam(":quota_regularizada", $this->quota_regularizada, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Buscar sócio pelo ID
    public function lerPorId()
    {
        $query = "SELECT * FROM " . $this->table_name .
                 " WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $this->id = $row['id'];
            $this->numero_socio = $row['numero_socio'];
            $this->nome_completo = $row['nome_completo'];
            $this->categoria = $row['categoria'];
            $this->contacto = $row['contacto'];
            $this->quota_regularizada = $row['quota_regularizada'];

            return true;
        }

        return false;
    }

    // Atualizar sócio
    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . "
                  SET numero_socio = :numero_socio,
                      nome_completo = :nome_completo,
                      categoria = :categoria,
                      contacto = :contacto,
                      quota_regularizada = :quota_regularizada
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":numero_socio", $this->numero_socio);
        $stmt->bindParam(":nome_completo", $this->nome_completo);
        $stmt->bindParam(":categoria", $this->categoria);
        $stmt->bindParam(":contacto", $this->contacto);
        $stmt->bindParam(":quota_regularizada", $this->quota_regularizada, PDO::PARAM_INT);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Alterar estado das quotas
    public function alterarStatus($status)
    {
        $query = "UPDATE " . $this->table_name . "
                  SET quota_regularizada = :status
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":status", $status, PDO::PARAM_INT);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Eliminar sócio
    public function eliminar()
    {
        $query = "DELETE FROM " . $this->table_name .
                 " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

?>