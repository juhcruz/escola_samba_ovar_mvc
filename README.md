# Escola de Samba de Ovar

Aplicação MVC simples para gerir sócios, quotas e utilizadores da Escola de Samba de Ovar.

## Requisitos

- PHP 8.1 ou superior
- PDO com SQLite ou MySQL

## Executar localmente

1. Abra um terminal na pasta do projeto.
2. Inicie o servidor:

```bash
php -S localhost:8000 -t .
```

3. Abra `http://localhost:8000/index.php?acao=login`.
4. Crie o primeiro utilizador através de Registar e entre na aplicação.

Quando o driver `pdo_mysql` não estiver disponível, a aplicação usa automaticamente `database.sqlite` e cria as tabelas necessárias. Para MySQL, crie a base de dados `escola_samba_ovar_mvc` e ajuste as credenciais em `config/Database.php`.

## Funcionalidades

- Autenticação com passwords protegidas por hash.
- Gestão de sócios: criar, editar, listar e eliminar.
- Alteração rápida do estado das quotas.
- Proteção CSRF nos formulários e autenticação obrigatória na gestão.
- Layout responsivo para computador e telemóvel.

## Estrutura

- `config/`: ligação à base de dados.
- `controllers/`: autenticação e regras de cada fluxo.
- `models/`: acesso aos dados com PDO.
- `views/`: páginas HTML/PHP.
- `css/`: estilos da aplicação.
