# Sistema de Login e Registro em PHP

![Status](https://img.shields.io/badge/status-concluído-brightgreen)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-8892BF?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?logo=mysql&logoColor=white)

## 📖 Sobre o Projeto

Este é um sistema de autenticação de usuários completo e seguro, desenvolvido do zero com **PHP puro e PDO**. O projeto serve como uma fundação robusta e reutilizável para qualquer aplicação web que necessite de um controle de acesso seguro, desde o cadastro de novas contas até o login e proteção de páginas internas.

O grande diferencial deste projeto é sua **capacidade de autoconfiguração**. O script de conexão com o banco de dados é inteligente o suficiente para criar o banco de dados e as tabelas necessárias automaticamente, além de realizar "migrações" para atualizar a estrutura das tabelas se o código for atualizado. Isso elimina completamente a necessidade de qualquer configuração manual no phpMyAdmin.

## ✨ Funcionalidades Principais

### Segurança Avançada
✅ **Senhas Criptografadas:** Utilização do algoritmo `PASSWORD_DEFAULT` (`bcrypt`) através da função `password_hash()` do PHP. As senhas nunca são armazenadas em texto puro, garantindo a segurança máxima das credenciais dos usuários.

✅ **Proteção Contra SQL Injection:** Todas as interações com o banco de dados são feitas utilizando **Prepared Statements** do PDO, a principal e mais eficaz defesa contra ataques de injeção de SQL.

✅ **Controle de Acesso por Sessão:** As páginas internas são protegidas por um script (`proteger.php`) que verifica se o usuário possui uma sessão de login ativa, redirecionando visitantes não autorizados para a página de login.

### Fluxo de Usuário Completo
✅ **Cadastro de Novos Usuários:** Uma página de registro pública (`registro.php`) com validação de dados no backend, incluindo verificação de senhas coincidentes, formato de email e checagem para evitar emails duplicados.

✅ **Login de Usuários:** Uma página de login (`login.php`) que valida as credenciais do usuário contra os dados seguros no banco de dados usando `password_verify()`.

✅ **Área Protegida e Logout:** Uma página principal (`principal.php`) que só pode ser acessada após o login e um script de `logout.php` que destrói a sessão de forma segura.

### Base Tecnológica Inteligente
🚀 **Setup 100% Automatizado:** O script `conexao.php` cria o banco de dados e a tabela `usuarios` na primeira execução, se eles não existirem.

🧠 **Migrações Automáticas Simples:** O mesmo script é capaz de detectar se a estrutura da tabela `usuarios` está desatualizada (ex: faltando a coluna `nome`) e executa um comando `ALTER TABLE` para corrigir a estrutura automaticamente, garantindo que o código e o banco de dados estejam sempre em sincronia.

## 🛠️ Pilha de Tecnologias (Tech Stack)

- **Backend:** PHP 8+ (com PDO para conexão de banco de dados)
- **Banco de Dados:** MySQL
- **Frontend:** HTML5, CSS3

## 📁 Estrutura de Arquivos

/sindico_pro/
├── 📄 apartamentos.php
├── 📄 avisos.php          
├── 📄 dashboard.php
├── 📄 editar_apartamento.php  
├── 📄 financas.php
├── 📄 login.php
├── 📄 logout.php
├── 📄 manutencao.php       
├── 📄 moradores.php
├── 📄 trocar_senha.php
├── 📁 assets/
├── 📁 css/
│   └── 📄 style.css
├── 📁 js/
│   └── 📄 script.js
└── 📁 php/
    ├── 📁 actions/             <-- Para ações gerais
    │   ├── 📄 adicionar_aviso.php
    │   ├── 📄 adicionar_tarefa.php
    │   ├── 📄 atualizar_apartamento.php
    │   ├── 📄 atualizar_status_tarefa.php
    │   ├── 📄 cadastrar_apartamento.php
    │   ├── 📄 cadastrar_morador.php
    │   ├── 📄 excluir_apartamento.php
    │   ├── 📄 excluir_aviso.php
    │   ├── 📄 registrar_pagamento.php
    │   ├── 📄 registrar_despesa.php
    │   └── 📄 salvar_nova_senha.php
    ├── 📁 auth/                <-- Para autenticação
    │   ├── 📄 login_action.php
    │   └── 📄 logout.php
    └── 📁 config/
        ├── 📄 conexao.php
        └── 📄 proteger.php

## 🚀 Como Executar o Projeto

Este projeto foi desenhado para ser "plug-and-play".

### Pré-requisitos
- Um ambiente de desenvolvimento como XAMPP, WAMP ou MAMP (que inclua PHP e MySQL).

### Passos
1.  **Baixe ou Clone o Projeto:** Coloque a pasta do projeto no diretório do seu servidor web (geralmente `htdocs` no XAMPP).

2.  **Configure a Conexão (Único Passo Manual):**
    - Abra o arquivo `php/config/conexao.php`.
    - Altere a variável `$dbname` para o nome que você deseja para o seu banco de dados (ex: `meu_site_db`).
    - Se necessário, altere as variáveis `$user` e `$pass` com as credenciais do seu MySQL.

3.  **Inicie o Servidor:**
    - Ligue os módulos Apache e MySQL no seu painel XAMPP.
    - **OU**, para uma abordagem mais moderna, abra o terminal na pasta do projeto e rode:
      ```bash
      php -S localhost:8000
      ```

4.  **Acesse e Veja a Mágica Acontecer:**
    - Abra seu navegador e acesse `http://localhost:8000/registro.php`.
    - **Nenhuma Ação Manual no Banco de Dados é Necessária!** Ao acessar a página, o `conexao.php` será executado, criando o banco de dados e a tabela `usuarios` com a estrutura mais recente, tudo sozinho.

## 🔮 Próximos Passos (Roadmap)

Este projeto é uma base excelente. As próximas melhorias poderiam incluir:
- Implementar a funcionalidade de "Esqueci minha senha" com envio de email.
- Criar uma página de "Meu Perfil" onde o usuário possa alterar seu nome e senha.
- Adicionar mais campos à tabela de usuários (ex: data de nascimento, telefone).
- Integrar este sistema de login em uma aplicação maior e mais complexa.