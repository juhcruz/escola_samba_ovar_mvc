<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Escola de Samba de Ovar - Gestão de Sócios</title>
    <link rel="stylesheet" href="css/main_styles.css">
</head>

<body>

    <h1>Escola de Samba de Ovar - Gestão de Sócios</h1>

    <a href="index.php?acao=criar">
        <strong>+ Registar Novo Sócio</strong>
    </a>

    <br><br>

    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Sócio / Contacto</th>
                <th>Categoria</th>
                <th>Quotas</th>
                <th>Ações</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($socios as $s): ?>

            <tr>
                <td>
                    <?= htmlspecialchars($s['id']) ?>
                </td>

                <td>
                    <strong>
                        Nº <?= htmlspecialchars($s['numero_socio']) ?> - <?= htmlspecialchars($s['nome_completo']) ?>
                    </strong>

                    <p style="font-size: 0.9em; color: #555;">
                        Contacto: <?= htmlspecialchars($s['contacto']) ?>
                    </p>
                </td>

                <td>
                    <?= htmlspecialchars($s['categoria']) ?>
                </td>

                <td>
                    <?php if ($s['quota_regularizada'] == 1): ?>
                        <span style="color:green;">Regularizado</span>
                    <?php else: ?>
                        <span style="color:red;">Em Dívida</span>
                    <?php endif; ?>
                </td>

                <td>
                    <a href="index.php?acao=editar&id=<?= (int)$s['id'] ?>">
                        Editar
                    </a>

                    |

                    <?php if ($s['quota_regularizada'] == 1): ?>

                        <a
                            href="index.php?acao=status&id=<?= (int)$s['id'] ?>&status=0"
                            onclick="return confirm('Deseja marcar as quotas como em dívida?')"
                        >
                            Marcar Dívida
                        </a>

                    <?php else: ?>

                        <a
                            href="index.php?acao=status&id=<?= (int)$s['id'] ?>&status=1"
                        >
                            Regularizar
                        </a>

                    <?php endif; ?>

                    |

                    <a
                        href="index.php?acao=eliminar&id=<?= (int)$s['id'] ?>"
                        onclick="return confirm('Deseja eliminar este sócio?')"
                    >
                        Eliminar
                    </a>
                </td>
            </tr>

        <?php endforeach; ?>

        <?php if (empty($socios)): ?>
            <tr>
                <td colspan="5" style="text-align: center;">Nenhum sócio registado.</td>
            </tr>
        <?php endif; ?>

        </tbody>
    </table>

</body>
</html>