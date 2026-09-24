<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Lista de Registos - Escola de Samba</title>
    <link rel="stylesheet" href="/escola_samba_ovar_mvc/public/css/main.css">
</head>
<body>

    <!-- Cabeçalho do Sistema -->
    <div class="header">
        <h1>Escola de Samba - Painel</h1>
        <div>
            <a href="index.php?acao=criar">Novo Registo</a>
            <a href="index.php?acao=logout">Terminar Sessão</a>
        </div>
    </div>

    <div class="container">
        <h2 class="page-title">Lista de Registos</h2>

        <?php if (isset($sucesso)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
        <?php endif; ?>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Exemplo de loop PHP que você deve ter na sua tabela -->
                    <?php if (!empty($registos)): ?>
                        <?php foreach ($registos as $registo): ?>
                        <tr>
                            <td><?= $registo['id'] ?></td>
                            <td><?= htmlspecialchars($registo['nome']) ?></td>
                            <td><?= htmlspecialchars($registo['utilizador']) ?></td>
                            <td>
                                <a href="index.php?acao=editar&id=<?= $registo['id'] ?>" class="btn btn-warning" style="padding: 6px 12px; font-size: 12px;">Editar</a>
                                <a href="index.php?acao=eliminar&id=<?= $registo['id'] ?>" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;" onclick="return confirm('Tem a certeza que deseja eliminar?')">Eliminar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="text-align: center;">Nenhum registo encontrado.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>