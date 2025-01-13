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
        

    // public function get_all_clients()

    // //returns all clients from our database, active or inactive
    // {

    //     $sql = "SELECT * FROM clientes WHERE 1 ";

    //     //check if only_active exist and is true

    //     if(key_exists('only_active', $this->params))
    //     {
    //         if(filter_var($this->params['only_active'], FILTER_VALIDATE_BOOLEAN) == true)
    //         {
    //             $sql .= "AND deleted_at IS NULL";
    //         }
    //     }

    //     $db = new database();

    //     $results = $db->EXE_QUERY($sql);

    //     return [
    //         'status' => 'SUCCESS',
    //         'message' => '',
    //         'results' => $results
    //     ];
    // }

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
}