<?php
        session_start();
        header("Access-Control-Allow-Origin: *");
        include '../models/Model.php';
        include '../database/connection.php';
        include '../controllers/ShippingController.php';
        include '../modules/cataloguing/Catalogue.php';
        require '../vendor/autoload.php';
        
        if(isset($_POST["action"]) && $_POST["action"] == "generate"){
            $siId = isset($_POST["siId"]) ? $_POST["siId"] : 0;

            $db = new Database();
            $conn = $db->getConnection();
            $action = isset($_POST['action']) ? $_POST['action'] : '';
            $shippingCtrl = new ShippingController($conn);

            $si = $shippingCtrl->fetchShippingInstruction($siId)[0];

            $teaStandard = $si['tea_standard_no'];
            $contactNo = $si['contract_no'];
            $siType = $si['shippment_type'];

            $stockList = $shippingCtrl->loadSelectedForshipment();
            $printData = print_lot_details($stockList, $conn, $teaStandard, $contactNo, $siType);
            $mpdf = new \Mpdf\Mpdf([
                'orientation' => 'L',
                'format' => 'A4', 
                'setAutoTopMargin' => 'stretch',
                'autoMarginPadding' => 0,
                'tempDir' => __DIR__ . 'files', 
                'default_font' => 'dejavusans']);
                $mpdf->SetHTMLFooter('<div style="text-align: center">{PAGENO} of {nbpg}</div>');
                $mpdf->useSubstitutions = false;
                $file = "files/si-lots/lot_details_".$siId.".pdf";

                $mpdf->shrink_tables_to_fit=0;
                $mpdf->WriteHTML($printData);
                $mpdf->Output($file, \Mpdf\Output\Destination::FILE);
            }


?>

<!doctype html>
<html>

    <?php
          function print_lot_details($stockList, $conn, $teaStandard, $contactNo, $siType){
                $catalogue = new Catalogue($conn);
                $title = "CHAMU SUPPLIES LIMITED LOT DETAILS ".$teaStandard." INVOICE ".$contactNo;
                if($siType=="Blend Shippment"){
                    $title = "CHAMU SUPPLIES LIMITED BLEND SHEET ".$teaStandard." INVOICE ".$contactNo;

                }
                $html = "
                <style>
                    #outertable {
                    font-family: Arial, Helvetica, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    }
                
                    #outertable td, #outertable th {
                    border: 1px solid;
                    padding: 4px;
                    }
                
                    #outertable th {
                    padding-top: 12px;
                    padding-bottom: 12px;
                    text-align: left;
                    background-color: #F5F5DC;
                    color: black;
                    }
                </style>
                ";
                $html.="
                <table style='width:100%; border:1px;'>
                <tr>
                    <td style='width:50%; text-align:center; background-color:aqua;'>
                       <p>".$title."</p>
                    </td>
                </tr>
                </table>
                <table id='outertable'>
                <tr>
                    <th>Sale No</th>
                    <th>DD/MM/YY</th>
                    <th>Broker</th>
                    <th>Warehouse</th>
                    <th>Lot</th>
                    <th>Origin</th>
                    <th>Mark</th>
                    <th>Grade</th>
                    <th>Invoice</th>
                    <th>Pkgs</th>
                    <th>Net</th>
                    <th>Kgs</th>
                    <th>MRP VALUE(PKR)</th> 
                    <th>Ware House</th>
                    <th>SI/Blend no.</th>           
                </tr>";
        
            foreach($stockList as $dat){
               $html.='<tr>';
                    $html.='<td>'.$dat['sale_no'].'</td>';
                    $html.='<td>'.$catalogue->ExcelToPHP($dat['manf_date']).'</td>';
                    $html.='<td>'.$dat['broker'].'</td>';
                    $html.='<td>'.$dat['ware_hse'].'</td>';
                    $html.='<td>'.$dat['lot'].'</td>';
                    $html.='<td>KENYA</td>';
                    $html.='<td>'.$dat['mark'].'</td>';
                    $html.='<td>'.$dat['grade'].'</td>';
                    $html.='<td>'.$dat['invoice'].'</td>'; 
                    $html.='<td>'.$dat['pkgs'].'</td>'; //pkgs
                    $html.='<td>'.$dat['net'].'</td>'; //kgs
                    $html.='<td>'.$dat['kgs'].'</td>'; //net
                    $html.='<td>2.4</td>'; 
                    $html.='<td>PHL</td>';
                    $html.='<td>TXP 21521</td>';
               $html.='</tr>';
                
            }
            $html.='</table>';


            return $html;

        }
    
?>
           

        