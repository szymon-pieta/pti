<?php
include('config.php');

$sort = $_GET['sort'] ?? 'id';
$order = $_GET['order'] ?? 'ASC';

$columns = ['id', 'imie', 'ocena', 'umie_apache', 'muzyka', 'data_jakas'];
if (!in_array($sort, $columns)) {
    $sort = 'id';
}
if ($order != 'ASC' && $order != 'DESC') {
    $order = 'ASC';
}

$new_order = ($order == 'ASC') ? 'DESC' : 'ASC';

$sql = "SELECT * FROM $tableName ORDER BY $sort $order";
?>