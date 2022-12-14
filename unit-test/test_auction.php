<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include '../database/connection.php';
include '../models/Model.php';
include '../controllers/CatalogController.php';
include '../controllers/FinanceController.php';
include '../controllers/ShippingController.php';
include '../controllers/WarehouseController.php';
include '../modules/grading/grading.php';
include '../controllers/UserController.php';
$path_to_root ='../';
include $path_to_root.'models/Model.php';
include $path_to_root.'controllers/UserController.php';
include $path_to_root.'modules/mailer/sendEmail.php';
include $path_to_root.'database/connection.php';

// $db = new Database();
// $conn = $db->getConnection();
// $user = new UserController($conn);
$sessionManager = $user->sessionManager;



$db = new Database();
$conn = $db->getConnection();
$catalogue = new Catalogue($conn);
// $catalogue->GenerateAuctionList();
$user = new UserController($conn);
$user->forgotPassword('kkip762@gmail.com', 'manemane');
print("holla mf");