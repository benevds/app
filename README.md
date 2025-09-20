# SíndicoPro – Gestão Descomplicada de Condomínios

![Status](https://img.shields.io/badge/status-em%20desenvolvimento-yellow)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-8892BF?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?logo=mysql&logoColor=white)

## 📖 Sobre o Projeto

**SíndicoPro** é uma aplicação web completa para a gestão de condomínios, desenvolvida do zero com PHP e MySQL. O sistema foi projetado para ser uma ferramenta central para síndicos, permitindo o controle total sobre as finanças, a organização dos apartamentos e a gestão dos moradores, tudo em uma interface moderna, segura e responsiva.

O grande diferencial do projeto é seu **setup automatizado**, que cria o banco de dados e todas as tabelas necessárias no primeiro acesso, eliminando qualquer necessidade de configuração manual.

## ✨ Funcionalidades Implementadas

O sistema possui uma base sólida e segura, com módulos administrativos essenciais já em funcionamento.

### Segurança e Gestão de Acesso
✅ **Autenticação Segura:** Sistema de login completo com senhas criptografadas utilizando `password_hash()` do PHP, garantindo que as senhas nunca sejam armazenadas em texto puro.

✅ **Níveis de Acesso (Roles):** O sistema diferencia o **Síndico** (administrador com acesso total) do **Morador** (acesso limitado), preparando o terreno para um portal completo do condomínio.

✅ **Fluxo de Primeiro Acesso Controlado:** O síndico tem o poder de criar logins para novos moradores com senhas temporárias. No primeiro acesso, o morador é obrigado a definir uma nova senha pessoal, garantindo um processo de onboarding seguro e profissional.

### Módulos Administrativos do Síndico
✅ **Dashboard Central:** Painel de controle que exibe um resumo inteligente dos dados mais importantes, como saldo financeiro do mês, número de inadimplentes e manutenções pendentes.

✅ **Gestão de Apartamentos e Moradores:**
- Ferramenta completa para cadastrar todos os apartamentos, especificando detalhes como número, andar e valor.
- Sistema para cadastrar novos moradores e associá-los a uma unidade vaga, mantendo um registro organizado de quem mora onde.

✅ **Módulo Financeiro Completo:**
- Registro fácil de **Receitas** (pagamentos de condomínio) e **Despesas** (contas, manutenções).
- **Extrato Mensal Unificado** que exibe todas as transações de entrada (em verde) e saída (em vermelho) para um controle visual claro e imediato.

### Base Tecnológica
🚀 **Setup 100% Automatizado:** O script de conexão (`conexao.php`) detecta se o banco de dados e as tabelas existem. Se não existirem, ele os cria automaticamente na primeira execução. Nenhuma interação manual com o phpMyAdmin é necessária.

📱 **Design Moderno e Responsivo:** A interface foi construída com foco na experiência do usuário, utilizando uma paleta de cores (roxo e lilás) e um layout flexível que se adapta a desktops e dispositivos móveis.

## 🛠️ Pilha de Tecnologias (Tech Stack)

- **Backend:** PHP 8+
- **Banco de Dados:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Ícones:** Font Awesome

## 📁 Estrutura do Projeto

/sindico_pro/
├── css/
│   └── style.css
├── js/
│   └── script.js
├── php/
│   ├── auth/
│   │   ├── login_action.php
│   │   └── logout.php
│   ├── config/
│   │   ├── conexao.php
│   │   └── proteger.php
│   └── actions/
│       ├── cadastrar_apartamento.php
│       ├── cadastrar_morador.php
│       ├── registrar_pagamento.php
│       ├── registrar_despesa.php
│       └── salvar_nova_senha.php
├── assets/
├── login.php
├── dashboard.php
├── apartamentos.php
├── moradores.php
├── financas.php
└── trocar_senha.php


## 🚀 Como Executar o Projeto Localmente

### Pré-requisitos
- Um ambiente de desenvolvimento como XAMPP, WAMP ou MAMP (que inclua PHP e MySQL).
- Git (opcional, para clonagem).

### Passos
1.  **Baixe ou Clone o Projeto:** Coloque a pasta `sindico_pro` no diretório do seu servidor web (geralmente `htdocs` no XAMPP).

2.  **Configure a Conexão (Único Passo Manual):**
    - Abra o arquivo `php/config/conexao.php`.
    - Se necessário, altere as variáveis `$user` e `$pass` com as credenciais do seu MySQL.

3.  **Inicie o Servidor:**
    - Ligue os módulos Apache e MySQL no seu painel XAMPP.
    - **OU**, para uma abordagem mais moderna, abra o terminal na pasta `sindico_pro` e rode:
      ```bash
      php -S localhost:8000
      ```

4.  **Acesse e Veja a Mágica Acontecer:**
    - Abra seu navegador e acesse `http://localhost:8000/login.php`.
    - O banco de dados `sindico_pro_db` e todas as tabelas serão criados automaticamente.
    - Email e Senha de Login no Sistema: 

## 🔮 Próximos Passos (Roadmap)

O projeto está em pleno desenvolvimento. As próximas funcionalidades planejadas são:

- **Controle de Manutenção e Tarefas:** Permitir que o síndico registre e acompanhe o status de reparos e tarefas do condomínio.
- **Mural de Avisos Digital:** Ferramenta para o síndico publicar comunicados para todos os moradores.
- **CRUD Completo:** Implementar as funcionalidades de **Editar** e **Excluir** para apartamentos, moradores, e lançamentos financeiros.
- **Área do Morador:** Um dashboard exclusivo para o morador, onde ele poderá ver seu histórico de pagamentos e os avisos do mural.
- **Relatórios Financeiros:** Geração de relatórios mensais em PDF.