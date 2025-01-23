<?php

//dependencies
require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');

//lógica e regras de negocio
$results = api_request('get_all_active_products', 'GET');

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
                <?php if(isset($_GET['success']) && $_GET['success'] == 'true') : ?>
                    <div class="alert alert-success p-2 text-center">
                        <p>Pruduto excluido com sucesso!</p>
                    </div>
                <?php endif; ?>
                <?php if(count($produtos) == 0):?>
                    <p class ="text-center">Não existem clientes registrados.</p>
                <?php else :?>


                <table class ="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th width="50%">Produto</th>
                            <th width="50%" class="text-end">Quantidade</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-striped-columns">
                        <?php foreach($produtos as $produto): ?>
                            <tr>
                                <td><?= $produto['produto']?></td>
                                <td class="text-end"><?= $produto['quantidade']?></td>
                                <td class="d-flex justify-content-center">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Deletar</button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir produto?</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Deseja realmente excluir o produto <?=$produto['produto']?> ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <a href="produtos_delete.php?id=<?=$produto['id_produto']?>" class="btn btn-danger">Excluir</a>
                                        </div>
                                        </div>
                                    </div>
                                    </div> 
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>


                </table>

                <p class="text-end">Total: <strong><?= count($produtos) ?></strong></p>
                <?php endif ?>
            </div>
        </div>
    </section>
    <script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>