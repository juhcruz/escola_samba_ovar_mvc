<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Portal de Notícias</title>
    <link rel="stylesheet" href="css/main_styles.css">
</head>

<body>

    <h1>Portal de Notícias (MVC)</h1>

    <a href="index.php?acao=criar">
        <strong>+ Inserir Nova Notícia</strong>
    </a>

    <br><br>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Estado</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($noticias as $n): ?>

            <tr>
                <td>
                    <?= htmlspecialchars($n['id']) ?>
                </td>

                <td>
                    <strong>
                        <?= htmlspecialchars($n['titulo']) ?>
                    </strong>

                    <p style="font-size: 0.9em; color: #555;">
                        <?= nl2br(htmlspecialchars($n['conteudo'])) ?>
                    </p>
                </td>

                <td>
                    <?php if ($n['ativo'] == 1): ?>
                        <span style="color:green;">Ativo</span>
                    <?php else: ?>
                        <span style="color:red;">Inativo</span>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="index.php?acao=editar&id=<?= (int)$n['id'] ?>">
                        Editar
                    </a>

                    |

                    <?php if ($n['ativo'] == 1): ?>

                        <a
                            href="index.php?acao=status&id=<?= (int)$n['id'] ?>&status=0"
                            onclick="return confirm('Deseja inativar?')"
                        >
                            Inativar
                        </a>

                    <?php else: ?>

                        <a
                            href="index.php?acao=status&id=<?= (int)$n['id'] ?>&status=1"
                        >
                            Activar
                        </a>

                    <?php endif; ?>

                    |

                    <a
                        href="index.php?acao=eliminar&id=<?= (int)$n['id'] ?>"
                        onclick="return confirm('Deseja eliminar?')"
                    >
                        Eliminar
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>
    </table>

</body>
</html>
