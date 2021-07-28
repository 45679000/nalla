<?php
header('Content-Type: application/json');

$input = filter_input_array(INPUT_POST);
include_once('../../models/Model.php');
include_once('../../database/page_init.php');
include 'Stock.php';

$db = new Database();
$conn = $db->getConnection();
$stock = new Stock($conn);

if ($input['action'] === 'edit') {
    $stock->allocateStock($input['id'], $input['buyer']);
} else if ($input['action'] === 'delete') {
    $mysqli->query("UPDATE users SET deleted=1 WHERE id='" . $input['id'] . "'");
} else if ($input['action'] === 'restore') {
    $mysqli->query("UPDATE users SET deleted=0 WHERE id='" . $input['id'] . "'");
}

echo json_encode($input);