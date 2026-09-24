<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Login - Escola de Samba Juventude Vareira</title>
    <link rel="stylesheet" href="/escola_samba_ovar_mvc/public/css/main.css">
</head>
<body class="login-page">

    <div class="login-container">
        <h2>Entrar</h2>

        <?php if (isset($erro)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form action="index.php?acao=login" method="POST">
            <div class="form-group">
                <label>E-mail / Utilizador:</label>
                <input type="text" name="utilizador" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Palavra-passe:</label>
                <input type="password" name="palavra_passe" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Entrar</button>
            <p style="margin-top: 15px; text-align: center;">
                Não tem conta? <a href="index.php?acao=registo" style="color: var(--rosa); font-weight: bold;">Registe-se aqui</a>
            </p>
        </form>
    </div>

</body>
</html>