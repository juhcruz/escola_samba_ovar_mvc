<?php

include_once 'config/database.php';
include_once 'models/noticia.php';

class NoticiaController
{
    private $db;
    private $noticia;

    public function __construct()
    {
        $database = new Database();

        $this->db = $database->getConnection();

        $this->noticia = new Noticia($this->db);
    }

    // Ação: listar
    public function index()
    {
        $stmt = $this->noticia->lerTodos();

        $noticias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include 'views/listar.php';
    }

    // Ação: criar
    public function criar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $titulo = trim($_POST['titulo'] ?? '');
            $conteudo = trim($_POST['conteudo'] ?? '');

            if ($titulo !== '' && $conteudo !== '') {

                $this->noticia->titulo = $titulo;
                $this->noticia->conteudo = $conteudo;

                if ($this->noticia->inserir()) {
                    header("Location: index.php");
                    exit;
                }
            }
        }

        include 'views/criar.php';
    }

    // Ação: editar
    public function editar()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id) {
            header("Location: index.php");
            exit;
        }

        $this->noticia->id = $id;

        if (!$this->noticia->lerPorId()) {
            header("Location: index.php");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $titulo = trim($_POST['titulo'] ?? '');
            $conteudo = trim($_POST['conteudo'] ?? '');

            if ($titulo !== '' && $conteudo !== '') {

                $this->noticia->titulo = $titulo;
                $this->noticia->conteudo = $conteudo;

                if ($this->noticia->atualizar()) {
                    header("Location: index.php");
                    exit;
                }
            }
        }

        include 'views/editar.php';
    }

    // Ação: ativar / inativar
    public function alterarStatus()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_GET, 'status', FILTER_VALIDATE_INT);

        if ($id && ($status === 0 || $status === 1)) {

            $this->noticia->id = $id;
            $this->noticia->alterarStatus($status);
        }

        header("Location: index.php");
        exit;
    }

    // Ação: eliminar
    public function eliminar()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($id) {

            $this->noticia->id = $id;
            $this->noticia->eliminar();
        }

        header("Location: index.php");
        exit;
    }
}

?>
