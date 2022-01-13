<?php 
	header("Access-Control-Allow-Origin: *");
    include_once('../../models/Model.php');
	include ('../grading/grading.php');
	require "../../vendor/autoload.php";
    include_once('../../database/page_init.php');
    include '../../controllers/StockController.php';
	include ('../../controllers/GradingController.php');    

    
    $db = new Database();
    $conn = $db->getConnection();
    $stock = new Stock($conn);
	$gradingController = new GradingController($conn);


    $filters = array();
    
    $filters['sale_no'] = "2021-20";
    $dataList = $stock->loadOpeningStock($filters);
    $stock->stockGrid($dataList);
