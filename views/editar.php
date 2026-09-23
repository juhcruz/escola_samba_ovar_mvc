<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Editar Notícia</title>
    <link rel="stylesheet" href="css/main_styles.css">
</head>

<body>

    <h1>Editar Notícia</h1>

    <form
        action="index.php?acao=editar&id=<?= (int)$this->noticia->id ?>"
        method="POST"
    >

        <label>Título:</label><br>

        <input
            type="text"
            name="titulo"
            value="<?= htmlspecialchars($this->noticia->titulo) ?>"
            required
            style="width: 50%;"
        >

        <br><br>

        <label>Conteúdo:</label><br>

        <textarea
            name="conteudo"
            rows="10"
            required
            style="width: 50%;"
        ><?= htmlspecialchars($this->noticia->conteudo) ?></textarea>

        <br><br>

        <button type="submit">Atualizar Notícia</button>

        <a href="index.php">Cancelar</a>

    </form>

</body>
</html>
