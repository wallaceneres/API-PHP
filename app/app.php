<?php

define('API_BASE', 'http://127.0.0.1/api/?option=');

echo '<p>Aplicação</p><hr>';

$resultado = api_request('status');

echo '<pre>';

print_r($resultado);

function api_request($option)
{
    $client = curl_init(API_BASE . $option);
    curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($client);

    return json_decode($response, true);
}

