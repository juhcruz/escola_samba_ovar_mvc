<?php

include_once 'config/Database.php';
include_once 'models/Socio.php';

class SocioController
{
    private $db;
    private $socio;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->socio = new Socio($this->db);
    }

    // Ação: listar sócios
    public function listar()
    {
        $stmt = $this->socio->lerTodos();
        $socios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include 'views/listar.php';
    }

    // Ação: criar sócio
    public function criar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $numero_socio = trim($_POST['numero_socio'] ?? '');
            $nome_completo = trim($_POST['nome_completo'] ?? '');
            $categoria = trim($_POST['categoria'] ?? '');
            $contacto = trim($_POST['contacto'] ?? '');
            $quota_regularizada = filter_input(INPUT_POST, 'quota_regularizada', FILTER_VALIDATE_INT);

            if ($numero_socio !== '' && $nome_completo !== '' && $categoria !== '' && $contacto !== '') {

                $this->socio->numero_socio = $numero_socio;
                $this->socio->nome_completo = $nome_completo;
                $this->socio->categoria = $categoria;
                $this->socio->contacto = $contacto;
                $this->socio->quota_regularizada = ($quota_regularizada !== false) ? $quota_regularizada : 1;

                if ($this->socio->inserir()) {
                    header("Location: index.php?acao=listar");
                    exit;
                }
            }
        }

        include 'views/criar.php';
    }

    // Ação: editar sócio
    public function editar()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header("Location: index.php?acao=listar");
            exit;
        }

        $this->socio->id = $id;

        if (!$this->socio->lerPorId()) {
            header("Location: index.php?acao=listar");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $numero_socio = trim($_POST['numero_socio'] ?? '');
            $nome_completo = trim($_POST['nome_completo'] ?? '');
            $categoria = trim($_POST['categoria'] ?? '');
            $contacto = trim($_POST['contacto'] ?? '');
            $quota_regularizada = filter_input(INPUT_POST, 'quota_regularizada', FILTER_VALIDATE_INT);

            if ($numero_socio !== '' && $nome_completo !== '' && $categoria !== '' && $contacto !== '') {

                $this->socio->numero_socio = $numero_socio;
                $this->socio->nome_completo = $nome_completo;
                $this->socio->categoria = $categoria;
                $this->socio->contacto = $contacto;
                $this->socio->quota_regularizada = ($quota_regularizada !== false) ? $quota_regularizada : 1;

                if ($this->socio->atualizar()) {
                    header("Location: index.php?acao=listar");
                    exit;
                }
            }
        }

        include 'views/editar.php';
    }

    // Ação: alterar status das quotas
    public function mudarStatus()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_GET, 'status', FILTER_VALIDATE_INT);

        if ($id && ($status === 0 || $status === 1)) {
            $this->socio->id = $id;
            $this->socio->alterarStatus($status);
        }

        header("Location: index.php?acao=listar");
        exit;
    }

    // Ação: eliminar sócio
    public function apagar()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            $this->socio->id = $id;
            $this->socio->eliminar();
        }

        header("Location: index.php?acao=listar");
        exit;
    }
}

?>