<?php
    
//import output.php

require_once('output.php');

//prepare response    
$data['status'] = 'ERROR';
$data['data'] = [];

//request
if(isset($_GET['option']))
{

    switch ($_GET['option'])
    {
        case 'status':
            api_status($data);
            break;

        case 'random':
            api_random($data);
            break;

        case 'hash':
            api_hash($data);
            break;
    }

}

// emitir a resposta da API

response($data);

?>