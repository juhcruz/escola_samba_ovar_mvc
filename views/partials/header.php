<?php
$scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '/index.php');
$appBasePath = rtrim(dirname($scriptPath), '/');
$logoPath = ($appBasePath === '' || $appBasePath === '.')
    ? '/images/logo.jpeg'
    : $appBasePath . '/images/logo.jpeg';
$userRole = $_SESSION['user_role'] ?? '';
?>
<header class="header">
    <div class="header-brand">
        <img class="header-logo" src="<?= htmlspecialchars($logoPath, ENT_QUOTES, 'UTF-8') ?>" alt="Logo da Escola de Samba de Ovar">
        <h1>Escola de Samba de Ovar</h1>
    </div>
    <nav aria-label="Navegação principal">
        <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="index.php?acao=listar">Sócios</a>
            <?php if ($userRole === 'admin'): ?>
                <a href="index.php?acao=criar">Adicionar Sócio</a>
                <a href="index.php?acao=registo">Registar Utilizador</a>
                <a href="index.php?acao=utilizadores">Gerir Utilizadores</a>
            <?php endif; ?>
            <a href="index.php?acao=logout">Logout</a>
        <?php else: ?>
            <a href="index.php?acao=login">Login</a>
            <a href="index.php?acao=registo">Registar</a>
        <?php endif; ?>
    </nav>
</header>
