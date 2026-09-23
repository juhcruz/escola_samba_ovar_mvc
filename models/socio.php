<?php

class Noticia
{
    private $conn;
    private $table_name = "noticias";

    public $id;
    public $titulo;
    public $conteudo;
    public $ativo;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Listar todas as notícias
    public function lerTodos()
    {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY criado_em DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Inserir notícia
    public function inserir()
    {
        $query = "INSERT INTO " . $this->table_name .
                 " (titulo, conteudo, ativo)
                  VALUES (:titulo, :conteudo, 1)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":conteudo", $this->conteudo);

        return $stmt->execute();
    }

    // Buscar notícia pelo ID
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
            $this->titulo = $row['titulo'];
            $this->conteudo = $row['conteudo'];
            $this->ativo = $row['ativo'];

            return true;
        }

        return false;
    }

    // Atualizar notícia
    public function atualizar()
    {
        $query = "UPDATE " . $this->table_name . "
                  SET titulo = :titulo,
                      conteudo = :conteudo
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":conteudo", $this->conteudo);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Alterar estado da notícia
    public function alterarStatus($status)
    {
        $query = "UPDATE " . $this->table_name . "
                  SET ativo = :ativo
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":ativo", $status, PDO::PARAM_INT);
        $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Eliminar notícia
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
