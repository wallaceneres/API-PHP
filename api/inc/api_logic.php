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

    public function status()
    {
        return
        [
            'status' => 'SUCCESS',
            'message' => 'API is running OK!',
            'results' => null
        ];
    }
        

    public function get_all_clients()
    {
        return [
            'status' => 'SUCCESS',
            'message' => '',
            'results' => [
                'joao','ana','pedro','antonio'
            ]
        ];
    }

    public function get_all_products()
    {

    }

}