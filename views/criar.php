<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <meta charset="UTF-8">
    <title>Inserir notícia</title>
    <link rel="stylesheet" href="css/main_styles.css">
</head>

<body>

    <h1>Inserir Nova Notícia</h1>

    <form action="index.php?acao=criar" method="POST">

        <label>Título:</label><br>

        <input
            type="text"
            name="titulo"
            required
            style="width:50%;"
        >

        <br><br>

        <label>Conteúdo:</label><br>

        <textarea
            name="conteudo"
            rows="10"
            required
            style="width:50%;"
        ></textarea>

        <br><br>

        <button type="submit">Guardar Notícia</button>

        <a href="index.php">Cancelar</a>

    </form>

</body>
</html>
