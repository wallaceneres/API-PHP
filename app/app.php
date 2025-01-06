<?php

define('API_BASE', 'http://127.0.0.1/api/?option=');

echo '<p>Aplicação</p><hr>';

for($i=0; $i<10; $i++)
{
    $resultado = api_request('random');

    // verify if response is ok (success)

    if($resultado['status'] == 'ERROR')
    {
        die('Aconteceu um erro a minha chamada à API');
    }

    echo "O valor randomico: " . $resultado['data'] . "<br>";
}


echo "TERMINADO";

function api_request($option)
{
    $client = curl_init(API_BASE . $option);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($client);

    return json_decode($response, true);
}

