<?php

require_once 'config/Database.php';
require_once 'models/user.php';

class UtilizadorController
{
    private $db;
    private $user;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    // Processar o registo de um novo utilizador
    public function registo()
    {
        $erro = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            verificar_csrf();
            $data = [
                'nome' => trim($_POST['nome'] ?? ''),
                'utilizador' => trim($_POST['utilizador'] ?? ''),
                'palavra_passe' => $_POST['palavra_passe'] ?? ''
            ];

            if (mb_strlen($data['nome']) < 2 || mb_strlen($data['nome']) > 100) {
                $erro = 'Indique um nome entre 2 e 100 caracteres.';
            } elseif (strlen($data['utilizador']) > 50 || (!filter_var($data['utilizador'], FILTER_VALIDATE_EMAIL) && !preg_match('/^[a-zA-Z0-9._-]{3,50}$/', $data['utilizador']))) {
                $erro = 'Indique um e-mail válido ou um utilizador entre 3 e 50 caracteres.';
            } elseif (strlen($data['palavra_passe']) < 8) {
                $erro = 'A palavra-passe deve ter pelo menos 8 caracteres.';
            } else {
                if ($this->user->registo($data)) {
                    // Redirecionar para o login após registo bem-sucedido
                    header("Location: index.php?acao=login");
                    exit();
                } else {
                    $erro = "Erro ao efetuar o registo. O nome de utilizador poderá já estar a ser utilizado.";
                }
            }
        }

        // Carregar a vista de registo
        include 'views/registo.php';
    }

    // Processar a autenticação (Login)
    public function login()
    {
        $erro = null;

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            verificar_csrf();
            $utilizadorInput = $_POST['utilizador'] ?? '';
            $passwordInput = $_POST['palavra_passe'] ?? '';

            if (!empty($utilizadorInput) && !empty($passwordInput)) {
                $userData = $this->user->lerPorUtilizador($utilizadorInput);

                // Verificar se o utilizador existe e se a palavra-passe coincide com o hash
                if ($userData && password_verify($passwordInput, $userData['palavra_passe'])) {
                    session_regenerate_id(true);
                    // Guardar dados na sessão
                    $_SESSION['user_id'] = $userData['id'];
                    $_SESSION['user_nome'] = $userData['nome'];
                    $_SESSION['user_utilizador'] = $userData['utilizador'];

                    // Redirecionar para a listagem principal de sócios
                    header("Location: index.php?acao=listar");
                    exit();
                } else {
                    $erro = "Utilizador ou palavra-passe incorretos.";
                }
            } else {
                $erro = "Por favor, preencha todos os campos.";
            }
        }

        // Carregar a vista de login
        include 'views/login1.php';
    }

    // Terminar sessão (Logout)
    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: index.php?acao=login");
        exit();
    }
}

?>