<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Gestão de Utilizadores - Escola de Samba de Ovar</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-brand">
                <img class="header-logo" src="../images/logo.jpeg" alt="Logo da Escola de Samba de Ovar">
                <h1>Escola de Samba de Ovar</h1>
            </div>
            <div>
                <a href="index.php?acao=listar">Sócios</a>
                <a href="index.php?acao=registo">Registar Utilizador</a>
                <a href="index.php?acao=logout">Logout</a>
            </div>
        </header>

        <main class="table-container">
            <h2 class="page-title">Gestão de Utilizadores</h2>

            <?php if (($_GET['resultado'] ?? '') === 'erro'): ?>
                <div class="alert alert-danger">Não foi possível concluir a ação. Não pode remover a sua própria conta nem deixar o sistema sem administrador.</div>
            <?php elseif (in_array($_GET['resultado'] ?? '', ['atualizado', 'removido'], true)): ?>
                <div class="alert alert-success">Alterações guardadas.</div>
            <?php endif; ?>

            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Utilizador</th>
                        <th>Papel</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utilizadores as $utilizador): ?>
                        <tr>
                            <td><?= htmlspecialchars($utilizador['nome'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($utilizador['utilizador'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= $utilizador['role'] === 'admin' ? 'Administrador' : 'Utilizador' ?></td>
                            <td>
                                <?php if ((int) $utilizador['id'] !== (int) $_SESSION['user_id']): ?>
                                    <div class="table-actions">
                                        <form class="inline-form" action="index.php?acao=papel-utilizador" method="POST">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
                                            <input type="hidden" name="id" value="<?= (int) $utilizador['id'] ?>">
                                            <input type="hidden" name="papel" value="<?= $utilizador['role'] === 'admin' ? 'user' : 'admin' ?>">
                                            <button class="btn btn-primary" type="submit">
                                                <?= $utilizador['role'] === 'admin' ? 'Remover admin' : 'Promover a admin' ?>
                                            </button>
                                        </form>
                                        <form class="inline-form" action="index.php?acao=apagar-utilizador" method="POST" onsubmit="return confirm('Tem a certeza que deseja eliminar este utilizador?');">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>">
                                            <input type="hidden" name="id" value="<?= (int) $utilizador['id'] ?>">
                                            <button class="btn btn-danger" type="submit">Eliminar</button>
                                        </form>
                                    </div>
                                <?php else: ?>
                                    Sessão atual
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>