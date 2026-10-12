# Escola de Samba Juventude Vareira

Aplicação MVC simples para gerir sócios, quotas e utilizadores da Escola de Samba Juventude Vareira.

## Requisitos

- PHP 8.1 ou superior
- PDO com o driver MySQL (`pdo_mysql`)
- MySQL ou MariaDB

## Executar localmente

1. Abra um terminal na pasta do projeto.
2. Certifique-se de que o MySQL/MariaDB está em execução. A aplicação cria automaticamente a base de dados `escola_samba_ovar_mvc` se ela ainda não existir.
3. Se precisar de configurar credenciais diferentes, defina variáveis de ambiente antes de iniciar:

```bash
set DB_HOST=localhost
set DB_USERNAME=root
set DB_PASSWORD=
set DB_NAME=escola_samba_ovar_mvc
```

4. Inicie o servidor:

```bash
php -S localhost:8000 -t .
```

5. Abra `http://localhost:8000/index.php?acao=login`.
6. Registe a conta que pretende usar como administrador ou, se quiser criar a conta administrativa a partir do início, use o primeiro registo como administrador após alterações manuais na base de dados.

As contas novas são utilizadores normais: podem consultar a lista de sócios, mas não podem criar, editar, apagar sócios ou alterar quotas, nem gerir utilizadores. Para dar acesso de administrador à primeira conta, atualize manualmente o papel da conta na base de dados e inicie sessão novamente:

```sql
UPDATE users SET role = 'admin' WHERE utilizador = 'email@exemplo.pt';
```

## Funcionalidades

- Autenticação com passwords protegidas por hash.
- Gestão de sócios: criar, editar, listar e eliminar.
- Gestão administrativa de utilizadores: alterar papéis e remover contas.
- Alteração rápida do estado das quotas.
- Proteção CSRF nos formulários e autenticação obrigatória na gestão.
- Layout responsivo para computador e telemóvel.

## Estrutura

- `config/`: ligação à base de dados.
- `controllers/`: autenticação e regras de cada fluxo.
- `models/`: acesso aos dados com PDO.
- `views/`: páginas HTML/PHP.
- `css/`: estilos da aplicação.
