<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <title>Lista de Sócios - Escola de Samba de Ovar</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <h1>Gestão de Sócios - Escola de Samba Juventude Vareira</h1>
    
    <div style="margin-bottom: 20px;">
        <a href="index.php?acao=criar">Adicionar Novo Sócio</a> | 
        <a href="index.php?acao=registo">Registar Utilizador</a>
    </div>

    <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #f2f2f2;">
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
                            <?= ($socio['quota_regularizada'] == 1) ? '<span style="color: green;">Regularizada</span>' : '<span style="color: red;">Em Atraso</span>' ?>
                        </td>
                        <td>
                            <a href="index.php?acao=editar&id=<?= $socio['id'] ?>">Editar</a> | 
                            <a href="index.php?acao=eliminar&id=<?= $socio['id'] ?>" onclick="return confirm('Tem a certeza que deseja eliminar este sócio?');">Eliminar</a>
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
</body>
</html>