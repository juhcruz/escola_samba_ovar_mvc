<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Editar Sócio - Escola de Samba de Ovar</title>
    <?php
    $scriptPath = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
    $cssPath = str_contains($scriptPath, '/views/') ? '../css/main.css' : 'css/main.css';
    ?>
    <link rel="stylesheet" href="<?= htmlspecialchars($cssPath, ENT_QUOTES, 'UTF-8') ?>">
</head>
<body>
    <div class="container">
        <header class="header">
            <h1>Escola de Samba de Ovar</h1>
            <div>
                <a href="index.php?acao=listar">Listar Sócios</a>
                <a href="index.php?acao=logout">Logout</a>
            </div>
        </header>

        <main class="form-container">
            <h2 class="page-title">Editar Sócio</h2>

            <?php if (isset($erro)): ?>
                <p class="alert alert-danger"><?= htmlspecialchars($erro) ?></p>
            <?php endif; ?>

            <form action="index.php?acao=editar&id=<?= htmlspecialchars($this->socio->id) ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
                <div class="form-group">
                    <label for="numero_socio">Número de Sócio</label>
                    <input class="form-control" id="numero_socio" type="text" name="numero_socio" value="<?= htmlspecialchars($this->socio->numero_socio) ?>" required>
                </div>

                <div class="form-group">
                    <label for="nome_completo">Nome Completo</label>
                    <input class="form-control" id="nome_completo" type="text" name="nome_completo" value="<?= htmlspecialchars($this->socio->nome_completo) ?>" required>
                </div>

                <div class="form-group">
                    <label for="categoria">Categoria</label>
                    <input class="form-control" id="categoria" type="text" name="categoria" value="<?= htmlspecialchars($this->socio->categoria) ?>" required>
                </div>

                <div class="form-group">
                    <label for="contacto">Contacto</label>
                    <input class="form-control" id="contacto" type="text" name="contacto" value="<?= htmlspecialchars($this->socio->contacto) ?>" required>
                </div>

                <div class="form-group">
                    <label for="quota_regularizada">Quota Regularizada</label>
                    <select class="form-control" id="quota_regularizada" name="quota_regularizada">
                        <option value="1" <?= ($this->socio->quota_regularizada == 1) ? 'selected' : '' ?>>Regularizada</option>
                        <option value="0" <?= ($this->socio->quota_regularizada == 0) ? 'selected' : '' ?>>Em Atraso</option>
                    </select>
                </div>

                <button class="btn btn-primary" type="submit">Atualizar Sócio</button>
                <a class="btn btn-secondary" href="index.php?acao=listar">Cancelar</a>
            </form>
        </main>
    </div>

</body>
</html>