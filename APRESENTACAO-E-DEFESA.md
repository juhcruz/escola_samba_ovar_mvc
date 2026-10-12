# Guia de apresentação e defesa do projeto

## GRES Juventude Vareira — Sistema de Gestão de Sócios

Este documento serve de apoio ao estudo, à demonstração e à defesa do projeto. As descrições abaixo correspondem ao comportamento atualmente implementado.

## 1. Apresentação breve

O projeto é uma aplicação web para apoiar a gestão de sócios do GRES Juventude Vareira. Permite consultar e pesquisar sócios, acompanhar a situação das quotas e, para utilizadores administradores, criar, editar e remover registos e gerir contas de utilizador.

A aplicação foi desenvolvida em PHP, segundo uma organização MVC, e utiliza MySQL ou MariaDB para persistir os dados. A interface está em português, adapta-se a ecrãs de diferentes dimensões e usa uma identidade visual escura com verde e rosa.

### Proposta de apresentação oral

> O meu projeto é um sistema web de gestão de sócios para o GRES Juventude Vareira. O objetivo é centralizar os dados dos associados e facilitar tarefas como pesquisa, consulta das quotas e manutenção dos registos. Existem dois níveis de acesso: utilizador e administrador. A aplicação foi organizada segundo o padrão MVC, desenvolvida em PHP e ligada a uma base de dados MySQL/MariaDB.

## 2. Problema e objetivos

### Problema a resolver

A gestão de associados envolve dados pessoais e tarefas recorrentes, como localizar um sócio, verificar a categoria e confirmar se as quotas estão regularizadas. Um sistema centralizado torna estas operações mais organizadas do que a consulta dispersa de registos.

### Objetivos

- Manter os dados dos sócios num único sistema.
- Pesquisar por nome, número de sócio ou contacto.
- Filtrar por categoria e estado das quotas.
- Apresentar um resumo do total de sócios e das quotas.
- Restringir operações administrativas a contas com o papel de administrador.
- Proteger a autenticação e as operações que alteram dados.
- Disponibilizar uma interface utilizável em computador e telemóvel.

## 3. Funcionalidades implementadas

### Consulta de sócios

- Lista os sócios por ordem decrescente de registo.
- Permite pesquisa parcial por número, nome ou contacto.
- Permite filtrar por categoria e por estado das quotas.
- Apresenta indicadores do total de sócios, quotas regularizadas e quotas em atraso.
- Utilizadores normais podem consultar os dados, mas não veem as ações de administração.

### Operações administrativas sobre sócios

O administrador pode:

- Criar um sócio, com número sugerido automaticamente a partir dos números existentes.
- Editar os dados de um sócio.
- Alterar o estado das quotas.
- Eliminar um registo, após confirmação no interface.

Os dados são validados no servidor, incluindo campos obrigatórios, limites de tamanho e valores permitidos para o estado das quotas.

### Contas de utilizador

- Uma pessoa pode registar uma conta com nome, identificador e palavra-passe.
- O identificador pode ser um e-mail ou um nome de utilizador no formato aceite pelo sistema.
- As palavras-passe têm um mínimo de oito caracteres e são guardadas como hash.
- As contas criadas por registo recebem o papel `user`.
- O administrador pode consultar utilizadores, alterar o papel e eliminar outras contas.
- Não é permitido eliminar a própria conta através dessa gestão, nem remover ou despromover o último administrador.

## 4. Papéis e permissões

| Operação | Utilizador | Administrador |
|---|---:|---:|
| Iniciar e terminar sessão | Sim | Sim |
| Consultar e pesquisar sócios | Sim | Sim |
| Ver estatísticas de sócios e quotas | Sim | Sim |
| Criar, editar e eliminar sócios | Não | Sim |
| Alterar o estado das quotas | Não | Sim |
| Gerir contas e papéis | Não | Sim |

O papel é novamente consultado na base de dados quando se acede a uma página protegida. Se a conta já não existir ou não tiver um papel válido, a sessão é terminada.

## 5. Arquitetura MVC

MVC significa **Model-View-Controller**:

- **Model (modelo):** trata o acesso e as operações sobre os dados. Neste projeto, `models/socio.php` gere sócios e `models/user.php` gere utilizadores.
- **View (vista):** apresenta os formulários, tabelas e restantes páginas HTML/PHP. As vistas estão em `views/`.
- **Controller (controlador):** recebe o pedido, valida os dados e coordena modelos e vistas. Os controladores estão em `controllers/`.
- **Router / ponto de entrada:** `index.php` interpreta o parâmetro `acao`, verifica o acesso e encaminha o pedido para a operação adequada.
- **Configuração da base de dados:** `config/Database.php` estabelece a ligação PDO e inicializa as tabelas.
- **Estilos:** `css/main.css` contém a apresentação e as regras responsivas.

### Percurso de um pedido

1. O navegador envia um pedido para `index.php`, incluindo uma ação como `listar` ou `criar`.
2. O router identifica a ação e, nas páginas protegidas, exige uma sessão válida e consulta o papel do utilizador.
3. O controlador trata os parâmetros e valida os dados submetidos.
4. O modelo executa a operação na base de dados através de PDO.
5. O controlador inclui a vista adequada ou redireciona após uma operação bem-sucedida.

## 6. Modelo de dados

### Tabela `socios`

| Campo | Utilização |
|---|---|
| `id` | Identificador interno, chave primária e incremento automático |
| `numero_socio` | Número apresentado ao sócio; único |
| `nome_completo` | Nome do associado |
| `categoria` | Categoria do associado |
| `contacto` | Contacto registado |
| `quota_regularizada` | Estado da quota: regularizada ou em atraso |
| `created_at` | Data e hora de criação do registo |

### Tabela `users`

| Campo | Utilização |
|---|---|
| `id` | Identificador interno, chave primária e incremento automático |
| `nome` | Nome da pessoa utilizadora |
| `utilizador` | E-mail ou nome de utilizador; único |
| `palavra_passe` | Hash da palavra-passe, não a palavra-passe original |
| `role` | Papel de acesso (`user` ou `admin`) |
| `created_at` | Data e hora de criação da conta |

As tabelas usam InnoDB e codificação `utf8mb4`. A aplicação cria a base de dados e as tabelas se não existirem, desde que as credenciais de ligação tenham permissões para o fazer.

## 7. Tecnologias utilizadas

- **PHP 8.1 ou superior:** lógica do servidor, controladores, modelos e vistas.
- **PDO:** acesso à base de dados com consultas preparadas.
- **MySQL ou MariaDB:** armazenamento persistente dos dados.
- **HTML:** estrutura das páginas.
- **CSS:** identidade visual, formulários, tabelas e adaptação a ecrãs móveis.
- **Sessões PHP:** estado de autenticação e papel do utilizador.

## 8. Segurança e validação

- **Hash de palavras-passe:** usa `password_hash` e verifica a autenticação com `password_verify`.
- **Consultas preparadas:** os valores dos utilizadores são passados como parâmetros PDO nas operações da aplicação, reduzindo o risco de injeção SQL.
- **Proteção CSRF:** as operações POST protegidas incluem um token aleatório da sessão, verificado com `hash_equals`.
- **Autorização no servidor:** o router exige autenticação e valida o papel de administrador antes de executar ações restritas.
- **Regeneração do identificador de sessão:** o identificador é renovado após autenticação para reduzir riscos de fixação de sessão.
- **Cookies de sessão:** usam `HttpOnly`, `SameSite=Lax` e `Secure` quando a aplicação está servida por HTTPS.
- **Escape de conteúdo HTML:** os dados apresentados nas vistas são escapados com `htmlspecialchars`.
- **Validação de dados:** valida campos obrigatórios, formatos e limites de tamanho antes de persistir os dados.
- **Proteção do último administrador:** transações e bloqueio de registos impedem a remoção ou despromoção da última conta administradora.
- **Métodos HTTP:** operações que alteram registos são limitadas a POST e recusam outros métodos.

### Nota sobre o ambiente de produção

O servidor embutido de PHP é destinado a desenvolvimento local, não a produção. Uma instalação real deve usar um servidor web configurado com HTTPS, credenciais de base de dados com privilégios mínimos, cópias de segurança e gestão segura de configurações e erros.

## 9. Executar localmente

### Requisitos

- PHP 8.1 ou superior.
- Extensão `pdo_mysql` ativa.
- MySQL ou MariaDB em execução.

### Passos no Windows PowerShell

Na pasta do projeto:

```powershell
$env:DB_HOST = "localhost"
$env:DB_USERNAME = "root"
$env:DB_PASSWORD = ""
$env:DB_NAME = "escola_samba_ovar_mvc"
php -S localhost:8000 -t .
```

As variáveis podem ser ajustadas às credenciais locais. A conta indicada precisa das permissões necessárias para criar ou utilizar a base de dados e as tabelas.

Abrir no navegador:

```text
http://localhost:8000/index.php?acao=login
```

O registo público cria uma conta normal. A promoção inicial a administrador deve ser feita por um administrador já existente ou por um procedimento controlado diretamente na base de dados.

## 10. Roteiro sugerido para a demonstração

1. **Login:** mostrar o formulário e explicar que as credenciais são verificadas no servidor.
2. **Listagem:** apresentar os indicadores de sócios e quotas.
3. **Pesquisa e filtros:** pesquisar por nome ou número e filtrar por categoria ou estado da quota.
4. **Criar sócio:** preencher os campos e mostrar o número sugerido automaticamente.
5. **Editar e quotas:** atualizar dados e alternar o estado da quota, explicando que são operações de administrador.
6. **Gestão de utilizadores:** mostrar papéis e as opções disponíveis; explicar a proteção da própria conta e do último administrador.
7. **Interface responsiva:** reduzir a largura do browser ou abrir num telemóvel.
8. **Logout:** terminar a sessão e confirmar que páginas protegidas voltam a exigir autenticação.

### Dados para uma demonstração controlada

Antes da apresentação, preparar:

- Uma conta administradora funcional.
- Uma conta normal para demonstrar as permissões limitadas.
- Alguns sócios de teste com categorias e estados de quota diferentes.
- Uma base de dados sem informação pessoal real ou sensível.

Não apresentar credenciais reais nem dados pessoais de associados durante a defesa.

## 11. Perguntas prováveis e respostas

### Porque foi utilizado MVC?

O MVC separa acesso aos dados, controlo do fluxo e apresentação. Essa separação facilita a leitura, manutenção e evolução do projeto sem concentrar todas as responsabilidades num único ficheiro.

### Qual é a diferença entre autenticação e autorização?

Autenticação verifica quem iniciou sessão. Autorização verifica o que essa pessoa pode fazer. Neste projeto, uma sessão válida permite consultar sócios; as operações de manutenção e a gestão de utilizadores exigem o papel de administrador.

### Como são protegidas as palavras-passe?

Não são guardadas em texto simples. O sistema guarda um hash criado com `password_hash` e compara a palavra-passe submetida com esse hash através de `password_verify`.

### Para que serve o token CSRF?

Ajuda a confirmar que um pedido que altera dados foi submetido a partir de um formulário da sessão autenticada, dificultando pedidos forjados por outro site.

### Como se evita injeção SQL?

As consultas que recebem valores externos usam instruções preparadas PDO e parâmetros, em vez de concatenar esses valores diretamente no SQL.

### Porque existe um papel de utilizador normal?

Permite que alguém consulte a listagem sem poder alterar informação. Assim, as permissões administrativas ficam limitadas a contas autorizadas.

### Como funciona a pesquisa?

O modelo constrói condições para os filtros selecionados e liga os valores como parâmetros. A pesquisa textual procura correspondências parciais no número de sócio, nome completo ou contacto.

### O que acontece se os dados submetidos forem inválidos?

O controlador valida os dados no servidor. Se forem inválidos, não executa a operação e apresenta uma mensagem de erro na vista.

### O sistema está pronto para produção?

O projeto implementa os fluxos principais, mas a instalação demonstrada localmente não equivale a uma preparação completa para produção. Seriam necessários, entre outros cuidados, HTTPS, configuração de servidor de produção, cópias de segurança e uma revisão operacional de segurança.

## 12. Limitações atuais e evolução possível

Estas são ideias para trabalho futuro, não funcionalidades que devam ser apresentadas como já concluídas:

- Paginação da listagem para bases de dados maiores.
- Histórico de alterações e auditoria das ações administrativas.
- Exportação de listagens para CSV ou PDF.
- Recuperação de palavra-passe e verificação de e-mail.
- Regras de quotas com períodos, pagamentos e histórico financeiro.
- Testes automatizados para controladores, modelos e fluxos de autenticação.
- Gestão de categorias a partir da interface.
- Melhorias de acessibilidade verificadas com ferramentas dedicadas.
- Estratégia de cópias de segurança e configuração de produção documentada.

## 13. Fecho da apresentação

### Proposta de conclusão oral

> Em conclusão, o projeto implementa uma aplicação web para centralizar a gestão de sócios e o acompanhamento das quotas do GRES Juventude Vareira. A separação MVC organiza o código, os papéis distinguem consulta de administração e foram incluídas medidas de segurança como hashes de palavras-passe, consultas preparadas e proteção CSRF. Como evolução, gostaria de acrescentar histórico de alterações, paginação e testes automatizados.

## 14. Vocabulário para revisão

- **CRUD:** operações de criar, consultar, atualizar e eliminar dados.
- **PDO:** interface do PHP para comunicar com bases de dados.
- **Hash:** representação não reversível usada para verificar uma palavra-passe sem armazená-la diretamente.
- **Sessão:** mecanismo do servidor que mantém o estado de autenticação entre pedidos.
- **CSRF:** falsificação de pedidos entre sites.
- **Validação:** verificação de que os dados recebidos cumprem os requisitos antes de serem usados ou guardados.
- **Autorização:** decisão sobre as operações permitidas a um utilizador autenticado.
