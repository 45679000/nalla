<?php
include '../database/connection.php';
include '../models/Model.php';
include '../controllers/GradingController.php';
include '../modules/grading/grading.php';
require '../vendor/autoload.php';


$db = new Database();
$conn = $db->getConnection();
$saleno = isset($_GET['invoice_no']) ? $_GET['invoice_no'] : '';
$grading = new Grading($conn);
$offered = $grading->readOffers($saleno);

$html="Hello world";

$mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'tempDir' => __DIR__ . '/files', 	'default_font' => 'dejavusans']);
$mpdf->WriteHTML($html);
$mpdf->Output();