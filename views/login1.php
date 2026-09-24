<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Login - Escola de Samba de Ovar</title>
    <?php
    $scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $cssPath = str_contains($scriptPath, '/views/') ? '../css/main.css' : 'css/main.css';
    ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($cssPath, ENT_QUOTES, 'UTF-8') ?>">
</head>
<body class="login-page">
    <main class="login-container">
        <h2>Carnaval de Ovar - Autenticação</h2>

        <?php if (isset($erro)): ?>
            <p class="alert alert-danger"><?= htmlspecialchars($erro) ?></p>
        <?php endif; ?>

        <form action="index.php?acao=login" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
            <div class="form-group">
                <label for="utilizador">Utilizador / E-mail:</label>
                <input class="form-control" type="text" id="utilizador" name="utilizador" required>
            </div>

            <div class="form-group">
                <label for="palavra_passe">Palavra-passe:</label>
                <input class="form-control" type="password" id="palavra_passe" name="palavra_passe" required placeholder="Digite a palavra-passe">
            </div>

            <button class="btn btn-primary" type="submit">Entrar</button>
            <a class="form-link" href="index.php?acao=registo">Ainda não tem conta? Registar</a>
        </form>
    </main>

</body>
</html>