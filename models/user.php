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
        $query = "INSERT INTO " . $this->table_name . " (nome, utilizador, palavra_passe, role)
                  VALUES (:nome, :utilizador, :palavra_passe, 'user')";
        
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

    public function listarTodos()
    {
        $query = "SELECT id, nome, utilizador, role, created_at FROM " . $this->table_name . " ORDER BY id";
        return $this->conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function papelPorId(int $id): ?string
    {
        $stmt = $this->conn->prepare("SELECT role FROM " . $this->table_name . " WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $papel = $stmt->fetchColumn();

        return in_array($papel, ['admin', 'user'], true) ? $papel : null;
    }

    public function atualizarPapel(int $id, string $papel): bool
    {
        if (!in_array($papel, ['admin', 'user'], true)) {
            return false;
        }

        $this->conn->beginTransaction();
        try {
            $this->bloquearUtilizadores($id);
            $stmt = $this->conn->prepare("SELECT role FROM " . $this->table_name . " WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $papelAtual = $stmt->fetchColumn();
            if ($papelAtual === false) {
                $this->conn->rollBack();
                return false;
            }

            if ($papelAtual === 'admin' && $papel === 'user') {
                $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $this->table_name . " WHERE role = 'admin'");
                if ((int) $stmt->fetchColumn() <= 1) {
                    $this->conn->rollBack();
                    return false;
                }
            }

            $stmt = $this->conn->prepare("UPDATE " . $this->table_name . " SET role = :role WHERE id = :id");
            $sucesso = $stmt->execute([':role' => $papel, ':id' => $id]);
            $this->conn->commit();
            return $sucesso;
        } catch (Throwable $exception) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            throw $exception;
        }
    }

    public function apagar(int $id): bool
    {
        $this->conn->beginTransaction();
        try {
            $this->bloquearUtilizadores($id);
            $stmt = $this->conn->prepare("SELECT role FROM " . $this->table_name . " WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $papel = $stmt->fetchColumn();
            if ($papel === false) {
                $this->conn->rollBack();
                return false;
            }

            if ($papel === 'admin') {
                $stmt = $this->conn->query("SELECT COUNT(*) FROM " . $this->table_name . " WHERE role = 'admin'");
                if ((int) $stmt->fetchColumn() <= 1) {
                    $this->conn->rollBack();
                    return false;
                }
            }

            $stmt = $this->conn->prepare("DELETE FROM " . $this->table_name . " WHERE id = :id");
            $sucesso = $stmt->execute([':id' => $id]);
            $this->conn->commit();
            return $sucesso;
        } catch (Throwable $exception) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }
            throw $exception;
        }
    }

    private function bloquearUtilizadores(int $id): void
    {
        if ($this->conn->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql') {
            $this->conn->query("SELECT id FROM " . $this->table_name . " FOR UPDATE")->fetchAll(PDO::FETCH_COLUMN);
            return;
        }

        $stmt = $this->conn->prepare("UPDATE " . $this->table_name . " SET role = role WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }
}

?>