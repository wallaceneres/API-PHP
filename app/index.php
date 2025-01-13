<?php

//dependencies
require_once('inc/config.php');
require_once('inc/api_functions.php');

echo '<pre>';

// $results = api_request('status', 'GET');
// print_r ($results);

// $results = api_request('get_all_clients', 'GET');
// print_r ($results);

// $results = api_request('get_all_products', 'GET');
// print_r ($results);

echo '<h3>CLIENTES TODOS  </h3>';

$results = api_request('get_all_clients', 'GET');

foreach($results['data']['results'] as $client)
{
    echo $client['nome'] . ' - ' . $client['email'] . '<br>';
}

echo '<hr>';

echo '<h3>CLIENTES INATIVOS</h3>';

$results = api_request('get_all_inactive_clients', 'GET');

foreach($results['data']['results'] as $client)
{
    echo $client['nome'] . ' - ' . $client['email'] . '<br>';
}

echo '<hr>';

echo '<h3>CLIENTES ATIVOS</h3>';

$results = api_request('get_all_active_clients', 'GET');

foreach($results['data']['results'] as $client)
{
    echo $client['nome'] . ' - ' . $client['email'] . '<br>';
}

echo '<hr>';



echo '<h3>PRODUTOS</h3>';

$results = api_request('get_all_products', 'GET');

foreach($results['data']['results'] as $products)
{
    echo $products['produto'] . ' - ' . $products['quantidade'] . '<br>';
}