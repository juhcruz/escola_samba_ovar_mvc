<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Novo Sócio - Escola de Samba de Ovar</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <h1>Adicionar Novo Sócio - Escola de Samba de Ovar</h1>

    <?php if (isset($erro)): ?>
        <p style="color: red;"><?= htmlspecialchars($erro) ?></p>
    <?php endif; ?>

    <form action="index.php?acao=criar" method="POST">
        <label>Número de Sócio:</label><br>
        <input type="text" name="numero_socio" value="<?= isset($proximoNumero) ? htmlspecialchars($proximoNumero) : '' ?>" readonly style="width: 30%; background-color: #e9ecef;"><br><br>

        <label>Nome Completo:</label><br>
        <input type="text" name="nome_completo" required style="width: 30%;"><br><br>

        <label>Categoria:</label><br>
        <input type="text" name="categoria" required style="width: 30%;"><br><br>

        <label>Contacto:</label><br>
        <input type="text" name="contacto" required style="width: 30%;"><br><br>

        <label>Quota Regularizada:</label><br>
        <select name="quota_regularizada" style="width: 30%;">
            <option value="1">Regularizada</option>
            <option value="0">Em Atraso</option>
        </select><br><br>

        <button type="submit">Guardar Sócio</button>
        <a href="index.php?acao=listar">Cancelar</a>
    </form>
</body>
</html>