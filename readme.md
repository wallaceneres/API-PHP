# 📌 API CRUD

**Descrição:**  
API criada com a finalidade de aprendizado, utilizando os  protocolos GET e POST e autenticação básica.

## 🚀 Tecnologias Utilizadas

- PHP 7
- MariaDB

## 📦 Instalação

Instale o Xampp 7.4.33: [XAMPP - Browse /XAMPP Windows/7.4.33 at SourceForge.net](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.4.33/)

Inicie os serviços Apache e MySQL

Clone o repositório na pasta Htdocs

```
https://github.com/wallaceneres/API-PHP.git
```

Importe o Banco de dados 

Configure o arquivo config.php no diretorio /api/inc utilizando os dados cadastrados (nome do bando, usuario do banco, senha).

Acesse 127.0.0.1 ou localhost no seu navegador para testar a aplicação.

## 📖 Endpoints da API

    Todos os endpoints funcionam através da index.php através do parâmetro endpoint, caso o parâmetro não for indicado ou o endpoint não existir, é retornado uma mensagem de erro.

    Para realizar a chamada na à API, utilize a URI localhost/index.php?

### 🔹 API

- **GET** `/index.php?endpoint=status`
  
  - Retorna o status da API
    
    ```
    {
      "method": "GET",
      "endpoint": "status",
      "data": {
        "status": "SUCCESS",
        "message": "API is running OK!",
        "results": null
      }
    }
    ```

### 🔹 Usuários

- **GET** `/index.php?endpoint=get_all_clients&limit=2&offset=1`
  
  - Retorna a lista completa de usuários cadastrados no banco de dados
    
    ```
    {
      "method": "GET",
      "endpoint": "get_all_clients",
      "data": {
        "status": "SUCCESS",
        "message": "",
        "total": "2",
        "pagina": 1,
        "paginas": 1,
        "results": [
          {
            "id_cliente": "1",
            "nome": "Teste",
            "email": "teste@sistema.com.br",
            "telefone": "31912345678",
            "created_at": "2025-01-23 18:39:30",
            "updated_at": "2025-01-23 18:39:30",
            "deleted_at": null
          },
          {
            "id_cliente": "2",
            "nome": "Teste 2",
            "email": "teste2@sistema.com.br",
            "telefone": "31923456789",
            "created_at": "2025-01-23 19:13:41",
            "updated_at": "2025-01-23 19:13:41",
            "deleted_at": "2025-01-24 14:26:13"
          }
        ]
      }
    }
    ```

- **GET** `/index.php?endpoint=get_all_active_clients&limit=2&offset=1`
  
  - Retorna apenas os clientes que estão ativos na base de dados.
    
    ```
    {
      "method": "GET",
      "endpoint": "get_all_clients",
      "data": {
        "status": "SUCCESS",
        "message": "",
        "total": "1",
        "pagina": 1,
        "paginas": 1,
        "results": [
          {
            "id_cliente": "1",
            "nome": "Teste",
            "email": "teste@sistema.com.br",
            "telefone": "31912345678",
            "created_at": "2025-01-23 18:39:30",
            "updated_at": "2025-01-23 18:39:30",
            "deleted_at": null
          }
        ]
      }
    }
    ```

- **GET** `/index.php?endpoing=get_all_inactive_clients`
  
  - Retorna apenas os clientes que estão inativos (excluidos via softdelete) na base de dados.
    
    ```
    {
      "method": "GET",
      "endpoint": "get_all_clients",
      "data": {
        "status": "SUCCESS",
        "message": "",
        "total": "1",
        "pagina": 1,
        "paginas": 1,
        "results": [
          {
            "id_cliente": "2",
            "nome": "Teste 2",
            "email": "teste2@sistema.com.br",
            "telefone": "31923456789",
            "created_at": "2025-01-23 19:13:41",
            "updated_at": "2025-01-23 19:13:41",
            "deleted_at": "2025-01-24 14:26:13"
          }
        ]
      }
    }
    ```

- **GET** `/index.php?endpoint=get_client&id={id}`
  
  - Retorna os dados de um usuario especifico.
    
    ```
    {
      "method": "GET",
      "endpoint": "get_client",
      "data": {
        "status": "SUCCESS",
        "message": "",
        "results": [
          {
            "id_cliente": "1",
            "nome": "Teste",
            "email": "teste@sistema.com.br",
            "telefone": "31912345678",
            "created_at": "2025-01-23 18:39:30",
            "updated_at": "2025-01-23 18:39:30",
            "deleted_at": null
          }
        ]
      }
    }
    ```

- **POST** `/index.php?endpoint=create_new_client`
  
  - Cadastra um novo usuário no banco de dados.
    
    **Parâmetros esperados (no corpo da requisição):**
    
    `endpoint`(string) - Endpoint
    
    `nome` (string) – Nome do cliente
    
    `email` (string) – E-mail do cliente
    
    `telefone` (string) – Telefone do cliente
    
    ```
    {
     "endpoint": "create_new_client"
     "nome": "cliente",
     "email": "cliente@email.com",
     "telefone": "11999999999"
    }
    ```

- **GET** `/index.php?endpoint=delete_client{id}`
  
  - Realiza um soft delete no cliente.
    
    ```
    {
      "method": "GET",
      "endpoint": "delete_client",
      "data": {
        "status": "SUCCESS",
        "message": "Client deleted with success.",
        "results": []
      }
    }
    ```

- **POST** `/index.php?endpoint=update_client`
  
  - Atualiza um cliente no banco de dados.
    
    **Parâmetros esperados (no corpo da requisição):**
    
    `endpoint`(string) - Endpoint
    
    `id` (string) – Id do produto
    
    `produto` (string) – Nome do produto
    
    `quantidade` (string) – quantidade em estoque
    
    ```
    {
     "endpoint": "update_client"
     "id_cliente": "id"
     "nome": "cliente",
     "email": "cliente@email.com",
     "telefone": "11999999999"
    }
    ```

### 🔹 Produtos

- **GET** `/index.php?endpoint=get_all_products&limit=2&offset=1`
  
  - Retorna a lista completa de produtos cadastrados no banco de dados
    
    ```
    {
      "method": "GET",
      "endpoint": "get_all_products",
      "data": {
        "status": "SUCCESS",
        "message": "",
        "total": "2",
        "pagina": 1,
        "paginas": 11,
        "results": [
          {
            "id_produto": "1",
            "produto": "Product1",
            "quantidade": "1",
            "created_at": null,
            "updated_at": null,
            "deleted_at": "2025-02-12 15:11:43"
          },
          {
            "id_produto": "2",
            "produto": "Product2",
            "quantidade": "0",
            "created_at": null,
            "updated_at": null,
            "deleted_at": null
          }
        ]
      }
    }
    ```

- **GET** `/index.php?endpoint=get_all_active_products&limit=1&offset=1`
  
  - Retorna apenas os produtos que estão ativos na base de dados.
    
    ```
    {
      "method": "GET",
      "endpoint": "get_all_active_products",
      "data": {
        "status": "SUCCESS",
        "message": "",
        "total": "1",
        "pagina": 1,
        "paginas": 1,
        "results": [
          {
            "id_produto": "2",
            "produto": "Product2",
            "quantidade": "0",
            "created_at": null,
            "updated_at": null,
            "deleted_at": null
          }
        ]
      }
    }
    ```

- **GET** `/index.php?endpoint=get_all_inactive_products&limit=1&offset=1`
  
  - Retorna apenas os produtos que estão inativos (excluidos via softdelete) na base de dados.
    
    ```
    {
      "method": "GET",
      "endpoint": "get_all_inactive_products",
      "data": {
        "status": "SUCCESS",
        "message": "",
        "total": "1",
        "pagina": 1,
        "paginas": 1,
        "results": [
          {
            "id_produto": "1",
            "produto": "Product1",
            "quantidade": "1",
            "created_at": null,
            "updated_at": null,
            "deleted_at": "2025-02-12 15:11:43"
          }
        ]
      }
    }
    ```

- **GET** `/index.php?endpoint=get_all_products_without_stock&limit=1&offset=1`
  
  - Retorna todos os produtos ativos e sem estoque
    
    ```
    {
      "method": "GET",
      "endpoint": "get_all_products_without_stock",
      "data": {
        "status": "SUCCESS",
        "message": "",
        "total": "2",
        "pagina": 1,
        "paginas": 11,
        "results": [
          {
            "id_produto": "2",
            "produto": "Product2",
            "quantidade": "0",
            "created_at": null,
            "updated_at": null,
            "deleted_at": null
          }
        ]
      }
    }
    ```

- **GET** `/index.php?endpoint=get_product&id={id}`
  
  - Retorna os dados de um produto especifico.
  
  ```
  {
    "method": "GET",
    "endpoint": "get_product",
    "data": {
      "status": "SUCCESS",
      "message": "",
      "results": [
        {
          "id_produto": "1",
          "produto": "Product",
          "quantidade": "1",
          "created_at": null,
          "updated_at": "2025-02-03 13:25:07",
          "deleted_at": "2025-02-11 14:03:51"
        }
      ]
    }
  }
  ```

- **GET** `/index.php?endpoint=delete_product{id}`
  
  - Realiza um soft delete no cliente.
    
    ```
    {
      "method": "GET",
      "endpoint": "delete_product",
      "data": {
        "status": "SUCCESS",
        "message": "Product deleted with success.",
        "results": []
      }
    }
    ```

- **POST** `/index.php?endpoint=create_new_product`
  
  - Cadastra um novo produto no banco de dados.
    
    **Parâmetros esperados (no corpo da requisição):**
    
    `endpoint`(string) - Endpoint
    
    `produto` (string) – Nome do produto
    
    `quantidade` (string) – quantidade em estoque
    
    ```
    {
     "endpoint": "create_new_product"
     "produto": "Produto",
     "quantidade": "12"
    }
    ```

- **POST** `/index.php?endpoint=update_product`
  
  - Atualiza um produto no banco de dados.
    
    **Parâmetros esperados (no corpo da requisição):**
    
    `endpoint`(string) - Endpoint
    
    `id` (string) – Id do produto
    
    `produto` (string) – Nome do produto
    
    `quantidade` (string) – quantidade em estoque
    
    ```
    {
     "endpoint": "update_product"
     "id": "id_produto"
     "produto": "Produto",
     "quantidade": "12"
    }
    ```
