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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
                <div id="successToast" class="toast align-items-center text-bg-success border-0 position-fixed top-0 end-0 p-3 m-3" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            Produto excluído com sucesso!
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
                <?php if (isset($_GET['success']) && $_GET['success'] == 'true') : ?>
                    <script>
                        // Esse código irá mostrar o toast assim que a página carregar
                        window.onload = function() {
                            var toast = new bootstrap.Toast(document.getElementById('successToast'));
                            toast.show();
                        };
                    </script>
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
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="produtos_edit.php?id=<?=$produto['id_produto']?>" class="btn btn-primary bi bi-pencil-square" title="Editar"></a>
                                        <button type="button" class="btn btn-danger bi bi-trash" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="<?= $produto['id_produto'] ?>" data-nome="<?= htmlspecialchars($produto['produto'], ENT_QUOTES, 'UTF-8') ?>" title="Excluir"></button>
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
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir Produto?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Deseja realmente excluir o produto <span id="modal-product-name"></span>?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <a href="produtos_delete.php?id=<?=$produto['id_produto']?>" class="btn btn-danger">Excluir</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        // Esse código vai rodar quando o modal for aberto
        var myModal = document.getElementById('staticBackdrop');

        myModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // O botão que acionou o modal

            var productId = button.getAttribute('data-id'); // Obtém o ID do produto
            var productName = button.getAttribute('data-nome'); // Obtém o nome do produto

            // Atualiza o link de exclusão no modal com o ID correto
            var deleteLink = myModal.querySelector('.btn-danger');
            deleteLink.href = 'produtos_delete.php?id=' + productId;

            // Atualiza o nome do produto no modal
            var modalProductName = myModal.querySelector('#modal-product-name');
            modalProductName.textContent = productName;
        });

    </script>
    <script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>