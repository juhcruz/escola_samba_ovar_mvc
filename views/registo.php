<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Registo - Escola de Samba Juventude Vareira </title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <h1> Novo Registo</h1>

    <?php if (isset($erro)): ?>
        <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form action="index.php?acao=registo" method="POST">
        <label>Nome Completo:</label><br>
        <input type="text" name="nome" required style="width: 30%;"><br><br>

        <label>E-mail:</label><br>
        <input type="text" name="utilizador" required style="width: 30%;"><br><br>

        <label>Palavra-passe:</label><br>
        <input type="password" name="palavra_passe" required placeholder="Crie uma palavra-passe"><br><br>

        <button type="submit">Registar</button>
        <a href="index.php?acao=login">Voltar ao Login</a>
    </form>
</body>
</html>