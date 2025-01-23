<?php

//dependencies
require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');

//lógica e regras de negocio
//verificar se foi indicado um id(id_produto)

if(!isset($_GET['id'])){
    header("Location: produtos.php");
    exit;
}

$id_produto = $_GET['id'];

//buscar os dados do produto à API

$results = api_request('get_product', 'GET', ['id' => $id_produto]);

//verificar se foi encontrado o produto que pretendemos eliminar
if(count($results['data']['results']) == 0){
    header("Location: produtos.php");
    exit;
}

//analisar a informacao obtida

if($results['data']['status'] == 'SUCCESS')
{
    $produto = $results['data']['results'][0];
}else
{
    $produto = [];
}

if(empty($produto)){
    header("Location: produtos.php");
    exit;
}

api_request('delete_product', 'GET', ['id' => $id_produto]);
    header("Location: produtos.php?success=true");
    exit;

?>