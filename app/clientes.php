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
                <table class ="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-striped-columns">
                        <?php foreach($clientes as $cliente): ?>
                            <tr>
                                <td><?= $cliente['nome']?></td>
                                <td><?= $cliente['email']?></td>
                                <td><?= $cliente['telefone']?></td>
                                <td class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Deletar</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir Usuário?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Deseja realmente excluir o usuário <?=$cliente['nome']?> ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <a href="clientes_delete.php?id=<?=$cliente['id_cliente']?>" class="btn btn-danger">Excluir</a>
                                        </div>
                                        </div>
                                    </div>
                                    </div> 
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <p class="text-end">Total: <strong><?= count($clientes) ?></strong></p>
                <?php endif ?>
            </div>
        </div>
    </section>      
    <script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>