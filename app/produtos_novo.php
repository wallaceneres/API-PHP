<?php

//dependencies
require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');

    $error_message = '';
    $success_message = '';

//lógica e regras de negocio

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $produto = $_POST['text_produto'];
    $quantidade = $_POST['text_quantidade'];

    $results = api_request('create_new_product', 'POST',[
        'produto' => $produto,
        'quantidade' => $quantidade,
    ]);

    //apresenta o resultado da operacao an API

    if($results['data']['status'] == 'ERROR')
    {
        $error_message = $results['data']['message'];
    }else if($results['data']['status'] == 'SUCCESS')
    {
        $success_message = $results['data']['message'];
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Consumidora</title>
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
</head>
<body>
    <script src="assets/bootstrap/bootstrap.bundle.js"></script>

    <?php include "inc/nav.php"?>

    <section  class="container">
        <div class="row row my-5">
            <div class="col-sm-6 offset-sm-3 card bg-light p-4">
                
                <form action="produtos_novo.php" method="post">

                    <div class="mb-3">
                        <label for="text_produto">Nome do Produto:</label>
                        <input type="text" id="text_produto" name="text_produto" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="text_quantidade">Quantidade:</label>
                        <input type="number" id="text_quantidade" name="text_quantidade" class="form-control">
                    </div>

                    <div class="mb-3 text-center">
                        <a href="produtos.php" class="btn btn-secondary btn-sm">Cancelar</a>
                        <input type="submit" value="Salvar" class="btn btn-primary btn-sm">
                    </div>

                    <?php if(!empty($error_message)) : ?>
                        <div class="alert alert-danger p-2 text-center">
                            <?=$error_message?>
                        </div>
                    <?php elseif(!empty($success_message)) : ?>
                        <div class="alert alert-success p-2 text-center">
                            <?=$success_message?>
                        </div>
                    <?php endif;?>



                </form>

            </div>
        </div>
    </section>
</body>
</html>