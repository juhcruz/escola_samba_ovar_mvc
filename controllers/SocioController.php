<?php

require_once 'config/Database.php';
require_once 'models/socio.php';

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
        $pesquisa = trim($_GET['pesquisa'] ?? '');
        $categoria = trim($_GET['categoria'] ?? '');
        $quotaFiltro = $_GET['quota'] ?? '';
        $quota = in_array($quotaFiltro, ['0', '1'], true) ? (int) $quotaFiltro : null;

        $stmt = $this->socio->lerTodos($pesquisa, $categoria, $quota);
        $socios = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $estatisticas = $this->socio->obterEstatisticas();
        $categorias = $this->socio->obterCategorias();

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
            verificar_csrf();
            $dados = $this->validarDados($_POST);

            if ($dados['erro']) {
                $erro = $dados['erro'];
            } else {
                $this->socio->numero_socio = $proximoNumero;
                $this->socio->nome_completo = $dados['nome_completo'];
                $this->socio->categoria = $dados['categoria'];
                $this->socio->contacto = $dados['contacto'];
                $this->socio->quota_regularizada = $dados['quota_regularizada'];

                if ($this->socio->criar()) {
                    header("Location: index.php?acao=listar");
                    exit();
                }
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

        if (!$this->socio->lerPorId($id)) {
            header("Location: index.php?acao=listar");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            verificar_csrf();
            $dados = $this->validarDados($_POST, false);

            if ($dados['erro']) {
                $erro = $dados['erro'];
            } else {
                $this->socio->numero_socio = trim($_POST['numero_socio'] ?? '');
                $this->socio->nome_completo = $dados['nome_completo'];
                $this->socio->categoria = $dados['categoria'];
                $this->socio->contacto = $dados['contacto'];
                $this->socio->quota_regularizada = $dados['quota_regularizada'];

                if ($this->socio->atualizar()) {
                    header("Location: index.php?acao=listar");
                    exit();
                }
                $erro = "Não foi possível atualizar o sócio.";
            }
        }

        include 'views/editar.php';
    }

    // Apagar sócio
    public function apagar()
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

        if ($id) {
            $this->socio->id = $id;
            $this->socio->apagar();
        }

        header("Location: index.php?acao=listar");
        exit();
    }

    public function mudarStatus()
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        if ($id && ($status === 0 || $status === 1)) {
            $this->socio->id = $id;
            $this->socio->alterarStatus($status);
        }

        header("Location: index.php?acao=listar");
        exit();
    }

    private function validarDados(array $dados, bool $numeroObrigatorio = true): array
    {
        $nome = trim($dados['nome_completo'] ?? '');
        $categoria = trim($dados['categoria'] ?? '');
        $contacto = trim($dados['contacto'] ?? '');
        $quota = filter_var($dados['quota_regularizada'] ?? null, FILTER_VALIDATE_INT);

        if (($numeroObrigatorio && empty($dados['numero_socio'])) || $nome === '' || $categoria === '' || $contacto === '') {
            return ['erro' => 'Preencha todos os campos obrigatórios.'];
        }
        if (mb_strlen($nome) > 150 || mb_strlen($categoria) > 50 || mb_strlen($contacto) > 20) {
            return ['erro' => 'Verifique o tamanho dos campos preenchidos.'];
        }
        if ($quota !== 0 && $quota !== 1) {
            return ['erro' => 'Estado das quotas inválido.'];
        }

        return ['erro' => null, 'nome_completo' => $nome, 'categoria' => $categoria, 'contacto' => $contacto, 'quota_regularizada' => $quota];
    }
}

?>