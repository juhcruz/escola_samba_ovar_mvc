<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Criar Registo - Escola de Samba</title>
    <link rel="stylesheet" href="/escola_samba_ovar_mvc/public/css/main.css">
</head>
<body>

    <div class="header">
        <h1>Escola de Samba</h1>
        <div>
            <a href="index.php?acao=listar">Voltar à Lista</a>
        </div>
    </div>

    <div class="container">
        <div class="form-container">
            <h2 class="page-title">Adicionar Novo Registo</h2>

            <form action="index.php?acao=guardar" method="POST">
                <div class="form-group">
                    <label>Nome:</label>
                    <input type="text" name="nome" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>E-mail:</label>
                    <input type="text" name="utilizador" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="index.php?acao=listar" class="btn btn-secondary" style="margin-left: 10px;">Cancelar</a>
            </form>
        </div>
    </div>

</body>
</html>