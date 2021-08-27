<?php
include '../database/connection.php';
include '../models/Model.php';
include '../controllers/GradingController.php';
include '../modules/grading/grading.php';
require '../vendor/autoload.php';


$db = new Database();
$conn = $db->getConnection();
$saleno = isset($_GET['saleno']) ? $_GET['saleno'] : '';
$grading = new Grading($conn);
$offered = $grading->readOffers($saleno);
$html =  print_labels($offered);

$mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'tempDir' => __DIR__ . '/files', 	'default_font' => 'dejavusans']);
$mpdf->WriteHTML($html);
$mpdf->Output();

function print_labels($offered){
$total = sizeof($offered);
$html="
    <style>


    </style>

";
$html.="<table>";
$printed = 0;

    foreach($offered as $offer){
        if($printed==0){
            $html.='<tr>';
            $html.='<td style="padding-left:30px; padding-bottom:30px; padding-top:10px;">
                        <table>
                            <tr>
                                <td><b>SALE:'.$offer['sale_no']. '</b></td>
                                <td>DATE:'.$offer['manf_date']. '</td> 
                            </tr>
                            <tr>
                                <td>'.$offer['mark'].'</td>
                                <td>'.$offer['grade'].'</td>  
                            </tr> 
                            <tr>
                                <td>PKGS:'.$offer['pkgs'].'</td>
                                <td><b>LOT#:'.$offer['lot'].'</b></td>
                            </tr>
                            <tr>
                                <td>WGHT:<b>'.$offer['net'].'</b></td>
                                <td>Invoice:<b>'.$offer['invoice'].'</b></td>
                            </tr>
                        </table>
                    </td>';
        $printed++;

        }else if($printed==1){
            $html.='<td style="padding-left:30px; padding-bottom:30px; padding-top:10px;">
                        <table>
                            <tr>
                                <td><b>SALE:'.$offer['sale_no']. '</b></td>
                                <td>DATE:'.$offer['manf_date']. '</td> 
                            </tr>
                            <tr>
                                <td>'.$offer['mark'].'</td>
                                <td>'.$offer['grade'].'</td>  
                            </tr> 
                            <tr>
                                <td>PKGS:'.$offer['pkgs'].'</td>
                                <td><b>LOT#:'.$offer['lot'].'</b></td>
                            </tr>
                            <tr>
                                <td>WGHT:<b>'.$offer['net'].'</b></td>
                                <td>Invoice:<b>'.$offer['invoice'].'</b></td>
                            </tr>
                        </table>
                    </td>';
                $printed++;
        }else if($printed==2){
            $html.='<td style="padding-left:30px; padding-bottom:30px; padding-top:10px;">
                        <table>
                            <tr>
                                <td><b>SALE:'.$offer['sale_no']. '</b></td>
                                <td>DATE:'.$offer['manf_date']. '</td> 
                            </tr>
                            <tr>
                                <td>'.$offer['mark'].'</td>
                                <td>'.$offer['grade'].'</td>  
                            </tr> 
                            <tr>
                                <td>PKGS:'.$offer['pkgs'].'</td>
                                <td><b>LOT#:'.$offer['lot'].'</b></td>
                            </tr>
                            <tr>
                                <td>WGHT:<b>'.$offer['net'].'</b></td>
                                <td>Invoice:<b>'.$offer['invoice'].'</b></td>
                            </tr>
                        </table>
                     </td>';
            $html.='</tr>';
        $printed=0;
        }

    }
$html.="</table>";
return $html;
}



?>