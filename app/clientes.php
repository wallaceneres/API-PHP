<?php

//dependencies
require_once('inc/config.php');
require_once('inc/api_functions.php');
require_once('inc/functions.php');

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) && $_GET['limit'] > 0 ? (int)$_GET['limit'] : 10;

//lógica e regras de negocio
$results = api_request('get_all_active_clients', 'GET',[
    'page' => $page,
    'limit' => $limit
]);

//analisar a informacao obtida
if($results['data']['status'] == 'SUCCESS')
{
    $clientes = $results['data']['results'];
    $totalClients = $results['data']['total'];
}else
{
    $clientes = [];
    $totalClients = 0;
}

$totalPages = ceil($totalClients / $limit);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>App Consumidora - Clientes</title>
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
                        <h1>Clientes</h1>
                    </div>
                    <div class="col text-end align-self-center">
                        <a href="clientes_novo.php" class = "btn btn-primary btn-sm">Adicionar cliente</a>
                    </div>
                </div>
                <div id="successToast" class="toast align-items-center text-bg-success border-0 position-fixed top-0 end-0 p-3 m-3" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            Cliente excluído com sucesso!
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
                <?php if(count($clientes) == 0):?>
                    <p class ="text-center">Não existem clientes registrados.</p>
                <?php else :?>
                    <form action="" method="GET" class="mb-3">
                        <div class="row">
                            <div class="col-auto">
                                <label for="limit" class="form-label">Resultados por página:</label>
                            </div>
                            <div class="col-auto">
                                <select id="limit" name="limit" class="form-select" onchange="this.form.submit()">
                                    <option value="10" <?= (isset($_GET['limit']) && $_GET['limit'] == 10) ? 'selected' : ''; ?>>10</option>
                                    <option value="25" <?= (isset($_GET['limit']) && $_GET['limit'] == 25) ? 'selected' : ''; ?>>25</option>
                                    <option value="50" <?= (isset($_GET['limit']) && $_GET['limit'] == 50) ? 'selected' : ''; ?>>50</option>
                                </select>
                            </div>
                        </div>
                    </form>
                <div class="table-responsive">
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
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="clientes_edit.php?id=<?=$cliente['id_cliente']?>" class="btn btn-primary bi bi-pencil-square" title="Editar"></a>
                                            <button type="button" class="btn btn-danger bi bi-trash" data-bs-toggle="modal" data-bs-target="#staticBackdrop" data-id="<?= $cliente['id_cliente'] ?>" data-nome="<?= htmlspecialchars($cliente['nome'], ENT_QUOTES, 'UTF-8') ?>" title="Excluir"></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <p class="text-end">Total: <strong><?= $totalClients ?></strong></p>

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Excluir Usuário?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Deseja realmente excluir o cliente <span id="modal-product-name"></span>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <a href="clientes_delete.php?id=<?=$cliente['id_cliente']?>" class="btn btn-danger">Excluir</a>
                            </div>
                        </div>
                    </div>
                </div>            

                <!-- Paginação -->
                <nav aria-label="Navegação de páginas">
                    <ul class="pagination justify-content-center">
                        <!-- Botão Primeira Página -->
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=1&limit=<?= $limit ?>">Primeira</a>
                        </li>

                        <!-- Botão Anterior -->
                        <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page - 1 ?>&limit=<?= $limit ?>" tabindex="-1">Anterior</a>
                        </li>

                        <!-- Páginas (com até 5 páginas ao redor da página atual) -->
                        <?php
                            // Definir o intervalo de páginas a exibir (2 antes e 2 depois da página atual)
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);
                            
                            for ($i = $startPage; $i <= $endPage; $i++) :
                        ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Botão Próxima -->
                        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $page + 1 ?>&limit=<?= $limit ?>">Próxima</a>
                        </li>

                        <!-- Botão Última Página -->
                        <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                            <a class="page-link" href="?page=<?= $totalPages ?>&limit=<?= $limit ?>">Última</a>
                        </li>
                    </ul>
                </nav>

                <?php endif ?>
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
            deleteLink.href = 'clientes_delete.php?id=' + productId;

            // Atualiza o nome do produto no modal
            var modalProductName = myModal.querySelector('#modal-product-name');
            modalProductName.textContent = productName;
        });

    </script>
    <script src="assets/bootstrap/bootstrap.bundle.min.js"></script>
</body>
</html>