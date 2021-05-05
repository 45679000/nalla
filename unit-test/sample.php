<?php
$path_to_root = "../";
$path_to_root1 = "../";

require_once $path_to_root.'templates/header.php';
include $path_to_root.'models/Model.php';
require_once $path_to_root.'modules/stock/Stock.php';
include $path_to_root1.'database/connection.php';
include $path_to_root1.'widgets/_form.php';
include $path_to_root1.'widgets/_grid.php';



$db = new Database();
$conn = $db->getConnection();
$stock = new Stock($conn);
$form = new Form();
$grid = new Grid();


$grid->_grid_start("Test", "Add");
$grid->_grid_table([]);


?>