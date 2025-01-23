<?php

//dependencies
require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');

//lógica e regras de negocio
//verificar se foi indicado um id(id-cliente)

if(!isset($_GET['id'])){
    header("Location: clientes.php");
    exit;
}

$id_cliente = $_GET['id'];

//buscar os dados do cliente à API

$results = api_request('get_client', 'GET', ['id' => $id_cliente]);


//verificar se foi encontrado o cliente que pretendemos eliminar
if(count($results['data']['results']) == 0){
    header("Location: clientes.php");
    exit;
}

//analisar a informacao obtida

if($results['data']['status'] == 'SUCCESS')
{
    $cliente = $results['data']['results'][0];
}else
{
    $cliente = [];
}

if(empty($cliente)){
    header("Location: clientes.php");
    exit;
}

api_request('delete_client', 'GET', ['id' => $id_cliente]);
    header("Location: clientes.php?success=true");
    exit;

?>