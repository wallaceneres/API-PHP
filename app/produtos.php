<?php

//dependencies
require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');

//lógica e regras de negocio
$results = api_request('get_all_products', 'GET');

//analisar a informacao obtida
if($results['data']['status'] == 'SUCCESS')
{
    $produtos = $results['data']['results'];
}else
{
    $produtos = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Consumidora - Produtos</title>
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css">
</head>
<body>
    <script src="assets/bootstrap/bootstrap.bundle.js"></script>

    <?php include "inc/nav.php"?>

    <section class="container">
        <div class="row">
            <div class="col">

            <div class="row">
                    <div class="col">
                        <h1>Produtos</h1>
                    </div>
                    <div class="col text-end align-self-center">
                        <a href="produtos_novo.php" class = "btn btn-primary btn-sm">Adicionar produto</a>
                    </div>
                </div>

                <?php if(count($produtos) == 0):?>
                    <p class ="text-center">Não existem clientes registrados.</p>
                <?php else :?>
                <table class ="table">
                    <thead class="table-dark">
                        <tr>
                            <th width="50%">Produto</th>
                            <th width="50%" class="text-end">Quantidade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($produtos as $produto): ?>
                            <tr>
                                <td><?= $produto['produto']?></td>
                                <td class="text-end"><?= $produto['quantidade']?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>


                </table>

                <p class="text-end">Total: <strong><?= count($produtos) ?></strong></p>
                <?php endif ?>
            </div>
        </div>
    </section>
</body>
</html>