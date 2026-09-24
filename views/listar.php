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

            <section class="cards" aria-label="Resumo dos sócios">
                <article class="card">
                    <h3>Total de sócios</h3>
                    <p class="number"><?= $estatisticas['total'] ?></p>
                </article>
                <article class="card">
                    <h3>Quotas regularizadas</h3>
                    <p class="number"><?= $estatisticas['regularizadas'] ?></p>
                </article>
                <article class="card">
                    <h3>Quotas em atraso</h3>
                    <p class="number"><?= $estatisticas['atraso'] ?></p>
                </article>
            </section>

            <form class="filter-bar" action="index.php" method="GET">
                <input type="hidden" name="acao" value="listar">
                <div class="filter-field">
                    <label for="pesquisa">Pesquisar</label>
                    <input class="form-control" id="pesquisa" type="search" name="pesquisa" value="<?= htmlspecialchars($pesquisa, ENT_QUOTES, 'UTF-8') ?>" placeholder="Nome, número ou contacto">
                </div>
                <div class="filter-field">
                    <label for="categoria-filtro">Categoria</label>
                    <select class="form-control" id="categoria-filtro" name="categoria">
                        <option value="">Todas</option>
                        <?php foreach ($categorias as $opcaoCategoria): ?>
                            <option value="<?= htmlspecialchars($opcaoCategoria, ENT_QUOTES, 'UTF-8') ?>" <?= $categoria === $opcaoCategoria ? 'selected' : '' ?>><?= htmlspecialchars($opcaoCategoria) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="filter-field">
                    <label for="quota-filtro">Estado das quotas</label>
                    <select class="form-control" id="quota-filtro" name="quota">
                        <option value="">Todos</option>
                        <option value="1" <?= $quotaFiltro === '1' ? 'selected' : '' ?>>Regularizadas</option>
                        <option value="0" <?= $quotaFiltro === '0' ? 'selected' : '' ?>>Em atraso</option>
                    </select>
                </div>
                <div class="filter-actions">
                    <button class="btn btn-primary" type="submit">Filtrar</button>
                    <a class="btn btn-secondary" href="index.php?acao=listar">Limpar</a>
                </div>
            </form>

            <p class="results-summary"><?= count($socios) ?> resultado(s) apresentado(s)</p>

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