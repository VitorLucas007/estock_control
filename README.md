# 📦 StockControl - Sistema de Gestão de Estoque

Um sistema web completo para gerenciamento de estoque e produtos, desenvolvido com **PHP Orientado a Objetos (POO)** e estruturado na **Arquitetura MVC** (Model-View-Controller).

## ✨ Funcionalidades

* **Autenticação Segura:** Login e cadastro de administradores utilizando `password_hash` nativo do PHP.
* **Proteção de Rotas:** Acesso ao dashboard e cadastro de produtos restrito a usuários autenticados.
* **Dashboard Dinâmico:** Visão geral do estoque com métricas reais (total de itens e quantidade em estoque) e listagem de produtos.
* **Gestão de Produtos:** Cadastro de novos itens com envio de imagens e descrição.
* **Categorias Integradas:** Produtos vinculados a categorias de forma dinâmica através de banco de dados relacional.
* **Padrão Singleton:** Conexão com o banco de dados otimizada e segura através de PDO.

## 🛠️ Tecnologias Utilizadas

* **Back-end:** PHP 8+ (POO, PDO)
* **Banco de Dados:** MariaDB / MySQL
* **Front-end:** HTML5, CSS3, Bootstrap 5
* **Arquitetura:** MVC com Front Controller (Roteador único)

## 📂 Estrutura do Projeto

A aplicação está dividida separando claramente as responsabilidades de Banco de Dados (Model), Exibição (View) e Lógica de Negócio (Controller).

```text
/sistema-estoque
│── config/
│   └── conecta.php             # Conexão PDO (Singleton)
│── controllers/
│   ├── AuthController.php      # Gerencia login, logout e registro
│   └── ProdutoController.php   # Gerencia exibição e cadastro de produtos
│── models/
│   ├── Categoria.php           # Operações da tabela categorias
│   ├── Produto.php             # Operações da tabela produtos
│   └── Usuario.php             # Operações e validações de usuários
│── views/
│   ├── cadastrar_admin.php     # Tela de novo administrador
│   ├── cadastro_produto.php    # Formulário de produtos
│   ├── dashboard.php           # Tela principal (Listagem e Métricas)
│   └── login.php               # Tela de acesso
│── uploads/                    # Diretório onde as imagens são salvas
│── index.php                   # Roteador Principal (Front Controller)
└── schema.sql                  # Script de criação do Banco de Dados
