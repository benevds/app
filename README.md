# Projeto Bet App

Este é um simples aplicativo web de apostas desenvolvido em PHP.

## Estrutura do Projeto

```
bet_app/
├── config.php            # Configurações do banco de dados
├── index.php             # Página principal (após login)
├── login.php             # Página de login
├── logout.php            # Script de logout
├── profile.php           # Página de perfil do usuário
├── register.php          # Página de registro
├── css/
│   └── style.css         # Folha de estilos
├── includes/
│   ├── db.php            # Conexão com o banco de dados
│   ├── footer.php        # Rodapé comum das páginas
│   └── header.php        # Cabeçalho comum das páginas
└── js/
    └── script.js         # Scripts JavaScript
```

## Funcionalidades

*   Registro de usuário
*   Login e Logout de usuário
*   Página de perfil do usuário

## Como Configurar e Executar

### Pré-requisitos

*   Um servidor web com suporte a PHP (como Apache ou Nginx).
*   Um servidor de banco de dados MySQL.
*   (Opcional) Ferramentas como XAMPP, WAMP ou MAMP que já incluem o Apache, PHP e MySQL.

### Passos

1.  **Banco de Dados:**
    *   Crie um novo banco de dados no seu MySQL com o nome `bet_app`.
    *   Importe a estrutura das tabelas necessárias para o funcionamento do sistema (o arquivo SQL não está incluído neste repositório).

2.  **Configuração:**
    *   Abra o arquivo `config.php`.
    *   Altere as constantes `DB_SERVER`, `DB_USERNAME`, `DB_PASSWORD` e `DB_NAME` com as credenciais do seu banco de dados.

    ```php
    <?php
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'seu_usuario');
    define('DB_PASSWORD', 'sua_senha');
    define('DB_NAME', 'bet_app');
    ?>
    ```

3.  **Execução:**
    *   **Usando um servidor local (XAMPP, etc.):**
        *   Copie a pasta `bet_app` para o diretório raiz do seu servidor web (geralmente `htdocs` no XAMPP).
        *   Abra seu navegador e acesse `http://localhost/bet_app/register.php` para começar.
    *   **Usando o servidor embutido do PHP:**
        *   Navegue até a pasta do projeto pelo terminal.
        *   Execute o comando: `php -S localhost:8000`
        *   Abra seu navegador e acesse `http://localhost:8000/register.php`.


