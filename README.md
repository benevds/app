# Bet App - Aplicação de Apostas

Bem-vindo ao Bet App, uma aplicação web para gerenciamento de apostas desenvolvida em PHP puro, seguindo as melhores práticas de segurança e estruturação de projetos.

## ✨ Funcionalidades

* **Autenticação Segura:** Sistema completo de Registro, Login e Logout de usuários com senhas criptografadas.
* **Gestão de Perfil:** Permite que usuários alterem seus dados cadastrais e senha de forma segura.
* **Estrutura Escalável:** Código organizado em pastas e arquivos reutilizáveis (`includes`) para fácil manutenção.
* **Setup Automatizado:** O sistema cria a tabela de usuários automaticamente no banco de dados no primeiro acesso.

## ⚙️ Estrutura do Projeto

bet_app/
├── config.php          # Credenciais do banco de dados
├── index.php           # Página principal (após login)
├── login.php           # Página de login
├── logout.php          # Script de logout
├── profile.php         # Página de perfil do usuário
├── register.php        # Página de registro
├── css/
│   └── style.css       # Folha de estilos
├── includes/
│   ├── db.php          # Conexão com o banco e criação automática da tabela
│   ├── footer.php      # Rodapé comum das páginas
│   └── header.php      # Cabeçalho comum das páginas
└── js/
    └── script.js       # Scripts JavaScript


## 🚀 Como Executar o Projeto

A maneira recomendada para desenvolvimento rápido é usar o servidor embutido do PHP.

### Pré-requisitos

* PHP (versão 7.4 ou superior)
* MySQL ou MariaDB
* Git (para clonar o repositório)

### Passos para Instalação

1.  **Clone o Repositório:**
    Abra seu terminal e execute o comando abaixo para clonar o projeto.
    ```bash
    git clone https://github.com/benevds/bet_app.git
    ```

2.  **Acesse a Pasta do Projeto:**
    ```bash
    cd bet_app
    ```

3.  **Configure o Banco de Dados:**
    * Crie um banco de dados vazio no seu MySQL com o nome `bet_app`.
    * Abra o arquivo `config.php` e altere as constantes `DB_USERNAME` e `DB_PASSWORD` com as suas credenciais do MySQL.
        ```php
        define('DB_SERVER', 'localhost');
        define('DB_USERNAME', 'seu_usuario_mysql'); // ex: 'root'
        define('DB_PASSWORD', 'sua_senha_mysql'); // ex: '' ou 'senha'
        define('DB_NAME', 'bet_app');
        ```
    * **A tabela `users` será criada automaticamente** na primeira execução.

### Executando o Projeto

1.  **Inicie o Servidor:**
    Com o terminal aberto na pasta do projeto, execute o comando:
    ```bash
    php -S localhost:8000
    ```

2.  **Acesse a Aplicação:**
    Abra seu navegador e acesse a URL:
    [http://localhost:8000/register.php](http://localhost:8000/register.php)

Para desligar o servidor, pressione `Ctrl + C` no terminal.
