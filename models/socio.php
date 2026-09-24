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
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // Criar um novo sócio
    public function criar()
    {
        $query = "INSERT INTO " . $this->table_name . " (numero_socio, nome_completo, categoria, contacto, quota_regularizada) 
                  VALUES (:numero_socio, :nome_completo, :categoria, :contacto, :quota_regularizada)";
        
        $stmt = $this->conn->prepare($query);

        // Limpar e vincular dados
        $stmt->bindParam(":numero_socio", $this->numero_socio);
        $stmt->bindParam(":nome_completo", $this->nome_completo);
        $stmt->bindParam(":categoria", $this->categoria);
        $stmt->bindParam(":contacto", $this->contacto);
        $stmt->bindParam(":quota_regularizada", $this->quota_regularizada);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ler dados de um sócio específico pelo ID (usado na edição)
    public function lerPorId($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
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

    // Atualizar dados de um sócio
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
        $stmt->bindParam(":quota_regularizada", $this->quota_regularizada);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Apagar um sócio
    public function apagar()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function alterarStatus($status)
    {
        $query = "UPDATE " . $this->table_name . " SET quota_regularizada = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':status', $status, PDO::PARAM_INT);
        $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

?>