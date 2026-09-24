<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Registo - Escola de Samba Juventude Vareira </title>
    <?php
    $scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $cssPath = str_contains($scriptPath, '/views/') ? '../css/main.css' : 'css/main.css';
    ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($cssPath, ENT_QUOTES, 'UTF-8') ?>">

</head>
<body>

    <div class="container">
        <div class="form-container">
            <h2 class="page-title">Novo Registo</h2>

            <?php if (isset($erro)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <form action="index.php?acao=registo" method="POST">
                <div class="form-group">
                    <label>Nome Completo:</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>E-mail:</label>
                    <input type="text" name="utilizador" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Palavra-passe:</label>
                    <input type="password" name="palavra_passe" class="form-control" required placeholder="Crie uma palavra-passe">
                </div>

                <button type="submit" class="btn btn-primary">Registar</button>
                <a href="index.php?acao=login" class="btn btn-secondary" style="margin-left: 10px;">Voltar ao Login</a>
            </form>
        </div>
    </div>

</body>
</html>