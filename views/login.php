<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Login - Escola de Samba de Ovar</title>
    <link rel="stylesheet" href="css/main_styles.css">
</head>
<body>
    <h1>Carnaval de Ovar - Autenticação</h1>

    <?php if (isset($erro)): ?>
        <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form action="index.php?acao=login" method="POST">
        <label>Utilizador / E-mail:</label><br>
        <input type="text" name="utilizador" required style="width: 30%;"><br><br>

        <label>Palavra-passe:</label><br>
        <input type="password" name="palavra_passe" required placeholder="Digite a palavra-passe"><br><br>

        <button type="submit">Entrar</button>
        <a href="index.php?acao=registo">Ainda não tem conta? Registar</a>
    </form>
</body>
</html>