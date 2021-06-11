<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include '../database/connection.php';
include '../models/Model.php';
include '../controllers/GradingController.php';
include '../modules/grading/grading.php';
require "../vendor/autoload.php";



$db = new Database();
$conn = $db->getConnection();
$action = isset($_POST['action']) ? $_POST['action'] : '';
$gradingContr = new GradingController($conn);
if($action=='grading-codes'){
    $codes = $gradingContr->loadCodes();
    echo json_encode($codes);
}
if($action=='grading-standards'){
    $standards = $gradingContr->loadStandards();
    echo json_encode($standards);
}
if($action=='generate-lables'){
    $grading = new Grading($conn);
    $offered = $grading->readOffers();

    print_labels($offered);

   $labls= '<iframe src="../reports/files/labels.pdf" width="100%" height="800px">
         </iframe>';
    json_encode(array("response"=>$labls));
}
function ExcelToPHP($dateValue = 0) {
    $UNIX_DATE = ($dateValue - 25569) * 86400;
    return gmdate("d-m-Y", $UNIX_DATE);  

}
function print_labels($offered){


    $tableStart='<table>';
    $cellsOdd = '';
    $cellsEven = '';
    
    $rowsStart = '<tr>';
    $rowsEnd = '</tr>';
    
    $total = sizeof($offered);
        foreach($offered as $offer){
            if($total>3){
                $cellsEven.= '
                <td style="padding-left:30px; padding-bottom:30px; padding-top:10px;">
                    <table>
                        <tr>
                            <td><b>SALE:'.$offer['sale_no'].'</b></td>
                            <td>DATE: '.ExcelToPHP($offer['manf_date']). '</td> 
                        </tr>
                        <tr>
                            <td>'.$offer['mark'].'</td>
                            <td>'.$offer['grade'].'</td>  
                        </tr> 
                        <tr>
                            <td>PKGS: '.$offer['pkgs'].'</td>
                            <td><b>LOT#: '.$offer['lot'].'</b></td>
                        </tr>
                        <tr>
                            <td>WGHT:<b>'.$offer['net'].'</b></td>
                            <td>Invoice:<b>'.$offer['invoice'].'</b></td>
                        </tr>
                    </table>
                </td>';
            }else{
                $cellsOdd.= '
                <td style="padding-left:30px; padding-bottom:30px; padding-top:10px;">
                        <table>
                        <tr>
                            <td><b>SALE:'.$offer['sale_no'].'</b></td>
                            <td>DATE: '.ExcelToPHP($offer['manf_date']). '</td> 
                        </tr>
                        <tr>
                            <td>'.$offer['mark'].'</td>
                            <td>'.$offer['grade'].'</td>  
                        </tr> 
                        <tr>
                            <td>PKGS: '.$offer['pkgs'].'</td>
                            <td><b>LOT#: '.$offer['lot'].'</b></td>
                        </tr>
                        <tr>
                            <td>WGHT:<b>'.$offer['net'].'</b></td>
                            <td>Invoice:<b>'.$offer['invoice'].'</b></td>
                        </tr>
                    </table>
                </td> 
                ';
            }
                    
        $total--;
        } 
    $tableEnd ='</table>';   
    $html = $tableStart;
    $html.= $rowsStart;
    $html .=$cellsEven;
    $html.= $rowsEnd;
    $html.= $rowsStart;
    $html .=$cellsOdd;
    $html.= $rowsEnd;
    $html.=$tableEnd;
 
    ob_start();//Enables Output Buffering
    $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'tempDir' => __DIR__ . '../reports/files', 	'default_font' => 'dejavusans']);
    $mpdf->WriteHTML($html);
    ob_end_clean();//End Output Buffering
    $mpdf->Output("../reports/files/labels.pdf", "F");

    
}

?>

