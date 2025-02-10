<?php

class api_logic
{

    private $endpoint;
    private $params;

    public function __construct($endpoint, $params = null)
    {
        //define the object/class properties
        $this->endpoint = $endpoint;
        $this->params = $params;
    }



    public function endpoint_exists()
    {
        //check if the endpoint is a valid class method
        return method_exists($this, $this->endpoint);
    }

    public function error_response($error)
    {
        //returns an erro from the api
        return
            [
                'status' => 'ERROR',
                'message' => $error,
                'results' => []
            ];
    }

    public function status()
    {
        return
        [
            'status' => 'SUCCESS',
            'message' => 'API is running OK!',
            'results' => null
        ];
    }

    public function get_totals()
    {
        //returns total clients ad products

        $db = new database();

        $results = $db->EXE_QUERY("
            SELECT 'clientes', COUNT(*) Total FROM clientes WHERE deleted_at IS NULL UNION ALL
            SELECT 'produtos', COUNT(*) Total FROM produtos WHERE deleted_at IS NULL
        ");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    //CLIENTES

    public function get_all_clients()
    {

        $db = new database();

        $query = "SELECT * FROM clientes WHERE 1 ORDER BY nome";

        $page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1; // Se 0 ou não estiver definido, define como 1
        $limit = isset($_GET['limit']) && (int)$_GET['limit'] > 0 ? min((int)$_GET['limit'], 100) : 10; // Se 0 ou não estiver definido, define como 10 (máximo 100)

        $query .= " LIMIT " . $limit;

        $offset = ($page - 1) * $limit;

        /*
            Página   | Fórmula (page - 1) * limit | OFFSET resultante | Registros exibidos
            -----------------------------------------------------------------------------
            1        | (1 - 1) * 10 = 0           | 0                  | 1 - 10
            2        | (2 - 1) * 10 = 10          | 10                 | 11 - 20
            3        | (3 - 1) * 10 = 20          | 20                 | 21 - 30
            4        | (4 - 1) * 10 = 30          | 30                 | 31 - 40
            5        | (5 - 1) * 10 = 40          | 40                 | 41 - 50
        */

        $query .= " OFFSET " . $offset;

        $results = $db->EXE_QUERY("$query");

        $queryTotalClients = "SELECT count(*) AS total FROM clientes";
        $totalClients = $db->EXE_QUERY("$queryTotalClients")[0]['total'];

        $totalPages = ceil($totalClients/$limit);
        

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'total' => $totalClients,
            'pagina' => $page,
            'paginas' => $totalPages,
            'results' => $results
        ];
    }

    public function get_all_active_clients()
    {

        $db = new database();

        $results = $db->EXE_QUERY("SELECT * FROM clientes where deleted_at is null");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    public function get_all_inactive_clients()
    {

        $db = new database();

        $results = $db->EXE_QUERY("SELECT * FROM clientes where deleted_at is not null");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    public function get_client()
    {
        //returns of all data from a cartain client

        $sql = "SELECT * FROM clientes WHERE 1 ";

        //check if id exists

        if(key_exists('id', $this->params) && $this->params['id'] != null)
        {
            if(filter_var($this->params['id'], FILTER_VALIDATE_INT))
            {
                $sql .= "AND id_cliente = " . intval($this->params['id']);
            }
        }else
        {
            return $this->error_response('ID client not specified');
        }

        $db = new database();

        $results = $db->EXE_QUERY("$sql");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    //PRODUTOS
    
    public function get_all_products()
    {

        $db = new database();

        $results = $db->EXE_QUERY("SELECT * FROM produtos WHERE 1");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    public function get_all_active_products()
    {

        $db = new database();

        $results = $db->EXE_QUERY("SELECT * FROM produtos where deleted_at is null");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    public function get_all_inactive_products()
    {

        $db = new database();

        $results = $db->EXE_QUERY("SELECT * FROM produtos where deleted_at is not null");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    public function get_all_products_without_stock()
    {
        //returns all products with stock <= 0 in the database
        $db = new database();

        $results = $db->EXE_QUERY("SELECT * FROM produtos WHERE deleted_at IS NULL AND quantidade <=0");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    public function create_new_client()
    {

        //check if all data is avaliable

        if(!isset($this->params['nome']) || !isset($this->params['email']) || !isset($this->params['telefone']))
        {
            return $this->error_response('Insufficient client data');
        }

        //check if there is already another cliennte with the same name or email
        $db = new database();
        
        $params = [
            ':nome' => $this->params['nome'],
            ':email' => $this->params['email']
        ];

        $results = $db->EXE_QUERY("SELECT id_cliente FROM clientes
            WHERE 1
            AND (nome = :nome OR email = :email)
            AND deleted_at iS NULL
            ", $params);

        if(count($results) != 0)
        {
            return $this->error_response('Theres already another client with the same email or name');
        }

        // add new to client to the database
        $params = [
            ':nome' => $this->params['nome'],
            ':email' => $this->params['email'],
            ':telefone' => $this->params['telefone']
        ];

        $db->EXE_NON_QUERY("INSERT INTO clientes VALUES(
                0,
                :nome,
                :email,
                :telefone,
                NOW(),
                NOW(),
                NULL
            )", $params);

        return [
            'status' => 'SUCCESS',
            'message' => 'New client added with success.',
            'results' => []
        ];
    }
    
    public function get_product()
    {
        //returns of all data from a certain product

        $sql = "SELECT * FROM produtos WHERE 1 ";

        //check if id exists

        if(key_exists('id', $this->params) && $this->params['id'] != null)
        {
            if(filter_var($this->params['id'], FILTER_VALIDATE_INT))
            {
                $sql .= "AND id_produto = " . intval($this->params['id']);
            }
        }else
        {
            return $this->error_response('ID product not specified');
        }

        $db = new database();

        $results = $db->EXE_QUERY("$sql");

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => $results
        ];
    }

    public function delete_client()
    {

        //check if all data is avaliable

        if(!isset($this->params['id']))
        {
            return $this->error_response('Insufficient client data');
        }

        //hard delete client
        $db = new database();
        
        $params = [
            ':id_cliente' => $this->params['id']
        ];

        $db->EXE_NON_QUERY("UPDATE clientes SET deleted_at = now() WHERE id_cliente = :id_cliente", $params);

        return [
            'status' => 'SUCCESS',
            'message' => 'Client deleted with success.',
            'results' => []
        ];
    }

    public function delete_product()
    {

        //check if all data is avaliable

        if(!isset($this->params['id']))
        {
            return $this->error_response('Insufficient product data');
        }

        //delete product
        $db = new database();
        
        $params = [
            ':id_produto' => $this->params['id']
        ];

        $db->EXE_NON_QUERY("UPDATE produtos SET deleted_at = now() WHERE id_produto = :id_produto", $params);

        return [
            'status' => 'SUCCESS',
            'message' => 'Product deleted with success.',
            'results' => []
        ];
    }

    public function create_new_product()
    {

        //check if all data is avaliable

        if(!isset($this->params['produto']) || !isset($this->params['quantidade']))
        {
            return $this->error_response('Insufficient product data');
        }

        //check if there is already another product witch the same name
        $db = new database();
        
        $params = [
            ':produto' => $this->params['produto']
        ];

        $results = $db->EXE_QUERY("SELECT id_produto FROM produtos
            WHERE produto = :produto
            ", $params);

        if(count($results) != 0)
        {
            return $this->error_response('Theres already another product with the same name');
        }

        // add new to product to the database
        $params = [
            ':produto' => $this->params['produto'],
            ':quantidade' => $this->params['quantidade']
        ];

        $db->EXE_NON_QUERY("INSERT INTO produtos VALUES(
                0,
                :produto,
                :quantidade,
                NOW(),
                NOW(),
                NULL
            )", $params);

        return [
            'status' => 'SUCCESS',
            'message' => 'New product added with success.',
            'results' => []
        ];
    }

    public function update_client()
    {

        //check if all data is avaliable

        if(!isset($this->params['id_cliente']) || !isset($this->params['nome']) || !isset($this->params['email']) || !isset($this->params['telefone']))
        {
            return $this->error_response('Insufficient client data');
        }

        //check if there is already another cliente with the same name or email
        $db = new database();
        
        $params = [
            ':nome' => $this->params['nome'],
            ':email' => $this->params['email']
        ];

        $results = $db->EXE_QUERY("SELECT id_cliente FROM clientes
            WHERE 1
            AND (nome = :nome OR email = :email)
            AND deleted_at iS NULL
            ", $params);

        if(count($results) != 0)
        {
            return $this->error_response('Theres already another client with the same email or name');
        }

        // update client on the database
        $params = [
            ':id_cliente' => $this->params['id_cliente'],
            ':nome' => $this->params['nome'],
            ':email' => $this->params['email'],
            ':telefone' => $this->params['telefone']
        ];

        $db->EXE_NON_QUERY("UPDATE clientes 
        SET nome = :nome,
        email = :email,
        telefone = :telefone,
        updated_at = now()
        WHERE id_cliente = :id_cliente", $params);

        return [
            'status' => 'SUCCESS',
            'message' => 'Cliente updated with success.',
            'results' => []
        ];
    }

    public function update_product()
    {

        //check if all data is avaliable

        if(!isset($this->params['id_produto']) || !isset($this->params['produto']) || !isset($this->params['quantidade']))
        {
            return $this->error_response('Insufficient product data');
        }

        //check if there is already another cliente with the same name or email
        $db = new database();
        
        $params = [
            ':produto' => $this->params['produto']
        ];

        $results = $db->EXE_QUERY("SELECT id_produto FROM produtos
            WHERE 1
            AND produto = :produto
            AND deleted_at iS NULL
            ", $params);

        if(count($results) != 0)
        {
            return $this->error_response('Theres already another product with the same email or name');
        }

        // update client on the database
        $params = [
            ':id_produto' => $this->params['id_produto'],
            ':produto' => $this->params['produto'],
            ':quantidade' => $this->params['quantidade']
        ];

        $db->EXE_NON_QUERY("UPDATE produtos
        SET produto = :produto,
        quantidade = :quantidade,
        updated_at = now()
        WHERE id_produto = :id_produto", $params);

        return [
            'status' => 'SUCCESS',
            'message' => 'Product updated with success.',
            'results' => []
        ];
    }
}