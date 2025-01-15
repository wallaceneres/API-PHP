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

    //CLIENTES

    public function get_all_clients()
    {

        $db = new database();

        $results = $db->EXE_QUERY("SELECT * FROM clientes");

        return [
            'status' => 'SUCCESS',
            'message' => '',
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

        $results = $db->EXE_QUERY("SELECT * FROM produtos");

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

}