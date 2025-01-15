<?php

//dependencies
require_once('inc/config.php');
require_once('inc/api_functions.php');

//lógica e regras de negocio
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
                <h1>Clientes</h1>
                <hr>
                <table class ="table">
                    <thead class="table-dark">
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Nome do cliente</td>
                            <td>E-mail do cliente</td>
                            <td>Telefone do cliente</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>