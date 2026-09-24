<?php

require_once 'config/Database.php';
require_once 'models/Socio.php';

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

    // Listar todos os sócios
    public function listar()
    {
        $stmt = $this->socio->lerTodos();
        $socios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Incluir a vista de listagem
        include 'views/listar.php';
    }

    // Criar novo sócio com número gerado automaticamente
    public function criar()
    {
        // Gerar automaticamente o próximo número de sócio
        $stmt = $this->socio->lerTodos();
        $socios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $proximoNumero = 1; // Valor predefinido se não houver sócios
        if (!empty($socios)) {
            $numeros = array_column($socios, 'numero_socio');
            $numeros_inteiros = array_filter($numeros, 'is_numeric');
            if (!empty($numeros_inteiros)) {
                $proximoNumero = max($numeros_inteiros) + 1;
            } else {
                $proximoNumero = count($socios) + 1;
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Utiliza o número gerado automaticamente (ou o submetido pelo form)
            $this->socio->numero_socio = $_POST['numero_socio'] ?? $proximoNumero;
            $this->socio->nome_completo = $_POST['nome_completo'];
            $this->socio->categoria = $_POST['categoria'];
            $this->socio->contacto = $_POST['contacto'];
            $this->socio->quota_regularizada = $_POST['quota_regularizada'];

            if ($this->socio->criar()) {
                header("Location: index.php?acao=listar");
                exit();
            } else {
                $erro = "Não foi possível criar o sócio. O número poderá já existir.";
            }
        }

        include 'views/criar.php';
    }

    // Editar sócio existente
    public function editar()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header("Location: index.php?acao=listar");
            exit();
        }

        $this->socio->lerPorId($id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->socio->numero_socio = $_POST['numero_socio'];
            $this->socio->nome_completo = $_POST['nome_completo'];
            $this->socio->categoria = $_POST['categoria'];
            $this->socio->contacto = $_POST['contacto'];
            $this->socio->quota_regularizada = $_POST['quota_regularizada'];

            if ($this->socio->atualizar()) {
                header("Location: index.php?acao=listar");
                exit();
            } else {
                $erro = "Não foi possível atualizar o sócio.";
            }
        }

        include 'views/editar.php';
    }

    // Apagar sócio
    public function apagar()
    {
        $id = $_GET['id'] ?? null;

        if ($id) {
            $this->socio->id = $id;
            $this->socio->apagar();
        }

        header("Location: index.php?acao=listar");
        exit();
    }
}

?>