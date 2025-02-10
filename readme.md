# 📌 API CRUD

**Descrição:**  
API criada com a finalidade de aprendizado, utilizando os  protocolos GET e POST e autenticação básica.

## 🚀 Tecnologias Utilizadas

- PHP 7
- Curl
- MariaDB

## 📦 Instalação

Instale o Xampp 7.4.33: [XAMPP - Browse /XAMPP Windows/7.4.33 at SourceForge.net](https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.4.33/)

Inicie os serviços Apache e MySQL

Clone o repositório na pasta Htdocs

```
https://github.com/wallaceneres/API-PHP-JOAORIBEIRO.git
```

Importe o Banco de dados 

Configure o arquivo config.php no diretorio /api/inc utilizando os dados cadastrados (nome do bando, usuario do banco, senha).

Acesse 127.0.0.1 ou localhost no seu navegador para testar a aplicação.



## 📖 Endpoints da API

    Todos os endpoints funcionam através da index.php através do parâmetro endpoint, caso o parâmetro não for indicado ou o endpoint não existir, é retornado uma mensagem de erro.

### 🔹 API

- **GET** `/index.php?endpoint=status`
  
  - 📤 **Resposta:**
    
    Retorna o status da API
    
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

- **GET** `/index.php?endpoint=get_all_clients`
  
  - Retorna a lista completa de usuários cadastrados no banco de dados
  - ```
    {
      "method": "GET",
      "endpoint": "get_all_clients",
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

- **GET** `/index.php?endpoint=get_all_active_clients`
  
  - Retorna apenas os clientes que estão ativos na base de dados.
    
    ```
    {
      "method": "GET",
      "endpoint": "get_all_clients",
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

- **GET** `/index.php?endpoing=get_all_inactive_clients`
  
  - Retorna apenas os clientes que estão inativos(excluidos via softdelete) na base de dados.
    
    ```
    {
      "method": "GET",
      "endpoint": "get_all_clients",
      "data": {
        "status": "SUCCESS",
        "message": "",
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
    
    
  - Retorna erro se parâmetro ID não for especificado ou estiver incorreto.
  - ```
    {
      "method": "GET",
      "endpoint": "get_client",
      "data": {
        "status": "ERROR",
        "message": "ID client not specified",
        "results": []
      }
    }
    ```


