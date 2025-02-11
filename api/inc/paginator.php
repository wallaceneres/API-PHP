<?php

class Paginator {

    public static function get_paginated_results($baseQuery, $filters = '', $table)
    {
        $db = new database();

        $page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1; // Se 0 ou não estiver definido, define como 1
        $limit = isset($_GET['limit']) && (int)$_GET['limit'] > 0 ? min((int)$_GET['limit'], 100) : 10; // Se 0 ou não estiver definido, define como 10 (máximo 100)

        $offset = ($page - 1) * $limit;

        /*
            Página   | Fórmula (page - 1) * limit | OFFSET resultante | Registros exibidos
            -----------------------------------------------------------------------------
            1        | (1 - 1) * 10 = 0           | 0                  | 1 - 10
            2        | (2 - 1) * 10 = 10          | 10                 | 11 - 20
            3        | (3 - 1) * 10 = 20          | 20                 | 21 - 30
            4        | (4 - 1) * 10 = 30          | 30                 | 31 - 40
            5        | (5 - 1) * 10 = 40          | 40                 | 41 - 50
        */

        $query = "$baseQuery $filters LIMIT $limit OFFSET $offset";
        $results = $db->EXE_QUERY($query);

        $queryTotal = "SELECT COUNT(*) AS total FROM $table $filters";
        $totalRecords = $db->EXE_QUERY($queryTotal)[0]['total'];
        $totalPages = ceil($totalRecords / $limit);

        return [
            'status' => 'SUCCESS',
            'message' => '',
            'total' => $totalRecords,
            'pagina' => $page,
            'paginas' => $totalPages,
            'results' => $results
        ];

    }
}