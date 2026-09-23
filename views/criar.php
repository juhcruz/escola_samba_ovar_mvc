<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <title>Registar Sócio</title>
    <link rel="stylesheet" href="css/main_styles.css">
</head>

<body>

    <h1>Registar Novo Sócio</h1>

    <form action="index.php?acao=criar" method="POST">

        <label>Número de Sócio:</label><br>
        <input
            type="text"
            name="numero_socio"
            required
            style="width:50%;"
        >

        <br><br>

        <label>Nome Completo:</label><br>
        <input
            type="text"
            name="nome_completo"
            required
            style="width:50%;"
        >

        <br><br>

        <label>Categoria:</label><br>
        <input
            type="text"
            name="categoria"
            required
            style="width:50%;"
        >

        <br><br>

        <label>Contacto:</label><br>
        <input
            type="text"
            name="contacto"
            required
            style="width:50%;"
        >

        <br><br>

        <label>Estado das Quotas:</label><br>
        <select name="quota_regularizada" required style="width:50%; padding: 5px;">
            <option value="1">Regularizado</option>
            <option value="0">Em Dívida</option>
        </select>

        <br><br>

        <button type="submit">Guardar Sócio</button>

        <a href="index.php">Cancelar</a>

    </form>

</body>
</html>
