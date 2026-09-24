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
                <a href="index.php?acao=logout">Logout</a>
            </div>
        </header>

        <main class="table-container">
            <h2 class="page-title">Gestão de Sócios</h2>

            <?php if (isset($sucesso)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
            <?php endif; ?>

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
                                    <form action="index.php?acao=status" method="POST">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
                                        <input type="hidden" name="id" value="<?= (int) $socio['id'] ?>">
                                        <input type="hidden" name="status" value="<?= $socio['quota_regularizada'] == 1 ? 0 : 1 ?>">
                                        <button class="status <?= $socio['quota_regularizada'] == 1 ? 'status-ativo' : 'status-inativo' ?>" type="submit">
                                            <?= $socio['quota_regularizada'] == 1 ? 'Regularizada' : 'Em Atraso' ?>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <div class="table-actions">
                                        <a class="btn btn-primary" href="index.php?acao=editar&id=<?= (int) $socio['id'] ?>">Editar</a>
                                        <form class="inline-form" action="index.php?acao=eliminar" method="POST" onsubmit="return confirm('Tem a certeza que deseja eliminar este sócio?');">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
                                            <input type="hidden" name="id" value="<?= (int) $socio['id'] ?>">
                                            <button class="btn btn-danger" type="submit">Eliminar</button>
                                        </form>
                                    </div>
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