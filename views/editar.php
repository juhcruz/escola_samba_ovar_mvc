<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Editar Sócio</title>
    <link rel="stylesheet" href="css/main_styles.css">
</head>

<body>

    <h1>Editar Sócio</h1>

    <form
        action="index.php?acao=editar&id=<?= (int)$this->socio->id ?>"
        method="POST"
    >

        <label>Número de Sócio:</label><br>
        <input
            type="text"
            name="numero_socio"
            value="<?= htmlspecialchars($this->socio->numero_socio) ?>"
            required
            style="width: 50%;"
        >

        <br><br>

        <label>Nome Completo:</label><br>
        <input
            type="text"
            name="nome_completo"
            value="<?= htmlspecialchars($this->socio->nome_completo) ?>"
            required
            style="width: 50%;"
        >

        <br><br>

        <label>Categoria:</label><br>
        <input
            type="text"
            name="categoria"
            value="<?= htmlspecialchars($this->socio->categoria) ?>"
            required
            style="width: 50%;"
        >

        <br><br>

        <label>Contacto:</label><br>
        <input
            type="text"
            name="contacto"
            value="<?= htmlspecialchars($this->socio->contacto) ?>"
            required
            style="width: 50%;"
        >

        <br><br>

        <label>Estado das Quotas:</label><br>
        <select name="quota_regularizada" style="width: 50%; padding: 5px;">
            <option value="1" <?= ($this->socio->quota_regularizada == 1) ? 'selected' : '' ?>>Regularizado</option>
            <option value="0" <?= ($this->socio->quota_regularizada == 0) ? 'selected' : '' ?>>Em Dívida</option>
        </select>

        <br><br>

        <button type="submit">Atualizar Sócio</button>

        <a href="index.php">Cancelar</a>

    </form>

</body>
</html>
