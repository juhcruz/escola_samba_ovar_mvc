<?php

include_once 'config/Database.php';
include_once 'models/User.php'; // Ajustado para o nome standard do model de utilizador

class UtilizadorController
{
    private $db;
    private $utilizador;

    public function __construct($db)
    {
        $this->db = $db;
        $this->utilizador = new User($this->db);
    }

    // Ação: criar / registar utilizador
    public function registo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nome = trim($_POST['nome'] ?? '');
            $utilizador = trim($_POST['utilizador'] ?? '');
            $palavra_passe = $_POST['palavra_passe'] ?? '';

            if (!empty($nome) && !empty($utilizador) && !empty($palavra_passe)) {

                // Preparar os dados para enviar ao Model
                $data = [
                    'nome' => $nome,
                    'utilizador' => $utilizador,
                    'palavra_passe' => $palavra_passe
                ];

                // Registar utilizador (o hash já é tratado no Model ou aqui)
                if ($this->utilizador->registo($data)) {
                    header('Location: index.php?acao=login');
                    exit();
                } else {
                    $erro = "Erro ao criar utilizador.";
                    include 'views/auth/registo.php';
                }

            } else {
                $erro = "Todos os campos são obrigatórios.";
                include 'views/auth/registo.php';
            }
        } else {
            include 'views/auth/registo.php';
        }
    }
}

?>