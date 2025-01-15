<?php

//dependencies
require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');

//lógica e regras de negocio
$results = api_request('get_all_clients', 'GET');

//analisar a informacao obtida
if($results['data']['status'] == 'SUCCESS')
{
    $clientes = $results['data']['results'];
}else
{
    $clientes = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Consumidora - Clientes</title>
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
                        <h1>Clientes</h1>
                    </div>
                    <div class="col text-end align-self-center">
                        <a href="clientes_novo.php" class = "btn btn-primary btn-sm">Adicionar cliente</a>
                    </div>
                </div>

                <?php if(count($clientes) == 0):?>
                    <p class ="text-center">Não existem clientes registrados.</p>
                <?php else :?>
                <table class ="table">
                    <thead class="table-dark">
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($clientes as $client): ?>
                            <tr>
                                <td><?= $client['nome']?></td>
                                <td><?= $client['email']?></td>
                                <td><?= $client['telefone']?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>


                </table>

                <p class="text-end">Total: <strong><?= count($clientes) ?></strong></p>
                <?php endif ?>
            </div>
        </div>
    </section>
</body>
</html>