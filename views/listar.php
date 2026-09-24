<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Lista de Sócios - Escola de Samba de Ovar</title>
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
                <a href="index.php?acao=criar">Adicionar Sócio</a>
                <a href="index.php?acao=registo">Registar Utilizador</a>
                <a href="index.php?acao=login">Logout</a>
            </div>
        </header>

        <main class="table-container">
            <h2 class="page-title">Gestão de Sócios</h2>

            <?php if (isset($sucesso)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
            <?php endif; ?>

            <div style="margin-bottom: 20px;">
                <a class="btn btn-success" href="index.php?acao=criar">Adicionar Novo Sócio</a>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>Nº Sócio</th>
                        <th>Nome Completo</th>
                        <th>Categoria</th>
                        <th>Contacto</th>
                        <th>Quotas</th>

                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($socios)): ?>
                        <?php foreach ($socios as $socio): ?>
                            <tr>
                                <td><?= htmlspecialchars($socio['numero_socio']) ?></td>
                                <td><?= htmlspecialchars($socio['nome_completo']) ?></td>
                                <td><?= htmlspecialchars($socio['categoria']) ?></td>
                                <td><?= htmlspecialchars($socio['contacto']) ?></td>
                                <td>
                                    <?= ($socio['quota_regularizada'] == 1) ? '<span class="status status-ativo">Regularizada</span>' : '<span class="status status-inativo">Em Atraso</span>' ?>
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="index.php?acao=editar&id=<?= $socio['id'] ?>">Editar</a>
                                    <a class="btn btn-danger" href="index.php?acao=eliminar&id=<?= $socio['id'] ?>" onclick="return confirm('Tem a certeza que deseja eliminar este sócio?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center;">Nenhum sócio registado até o momento.</td>

                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </div>

</body>
</html>