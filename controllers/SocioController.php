<?php

include_once 'config/database.php';
include_once 'models/Utilizador.php';

class UtilizadorController
{
    private $db;
    private $utilizador;

    public function __construct()
    {
        $database = new Database();

        $this->db = $database->getConnection();

        $this->utilizador = new Utilizador($this->db);
    }

    // Ação: criar utilizador
    public function criar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = trim($_POST['utilizador'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $palavra_chave = $_POST['palavra_chave'] ?? '';

            if (
                !empty($nome) &&
                !empty($email) &&
                !empty($palavra_chave)
            ) {

                // Criar hash da palavra-passe
                $hashed_password = password_hash(
                    $palavra_chave,
                    PASSWORD_DEFAULT
                );

                // Enviar dados para o Model
                $this->utilizador->nome = $nome;
                $this->utilizador->email = $email;
                $this->utilizador->palavra_chave = $hashed_password;

                // Registar utilizador
                if ($this->utilizador->register()) {

                    header('Location: index.php?acao=login');
                    exit();

                } else {

                    echo "Erro ao criar utilizador.";
                }

            } else {

                echo "Todos os campos são obrigatórios.";
            }
        }

        include 'views/criar_utilizador.php';
    }
}

?>
