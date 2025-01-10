<?php

//dependencies
require_once('inc/config.php');
require_once('inc/api_functions.php');

$variables = 
[
    'nome' => 'Wallace',
    'apelido' => 'Neres'
];

//$results = api_request('status', 'GET', $variables);
$results = api_request('status', 'GET');

echo '<pre>';

print_r ($results);