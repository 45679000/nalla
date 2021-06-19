<?php
include '../database/connection.php';
include '../models/Model.php';
include '../controllers/GradingController.php';
include '../modules/grading/grading.php';


$db = new Database();
$conn = $db->getConnection();

$grading = new Grading($conn);
$offered = $grading->readOffers();
echo print_labels($offered);

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
                        <td><b>SALE: '.$offer['sale_no']. '</b></td>
                        <td>DATE: '.$offer['manf_date']. '</td> 
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
                        <td>WGHT: <b>'.$offer['net'].'</b></td>
                        <td>Invoice: <b>'.$offer['invoice'].'</b></td>
                    </tr>
                </table>
            </td>';
        }else{
            $cellsOdd.= '
            <td style="padding-left:30px; padding-bottom:30px; padding-top:10px;">
                    <table>
                    <tr>
                        <td><b>SALE: '.$offer['sale_no']. '</b></td>
                        <td>DATE: '.$offer['manf_date']. '</td> 
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
                        <td>WGHT: <b>'.$offer['net'].'</b></td>
                        <td>Invoice: <b>'.$offer['invoice'].'</b></td>
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
return $html;
}

function print_label_copy($offered){
    $html='';
    $rowCount = 0;
$html.='
<table>
    <tr>';
foreach($offered as $offer){
            if(($rowCount%2==0)){
                $html.='
                    <td>
                        <table>
                            <tr>
                                <td>SALE'.$offer['sale_no'].'</td>
                                <td>DATE'.$offer['manf_date'].'</td> 
                            </tr>
                            <tr>
                                <td>'.$offer['mark'].'</td>
                                <td>'.$offer['grade'].'</td>  
                            </tr> 
                            <tr>
                                <td>PKGS'.$offer['pkgs'].'</td>
                                <td>LOT#'.$offer['lot'].'</td>
                            </tr>
                            <tr>
                                <td>WGHT'.$offer['net'].'</td>
                                <td>Invoice'.$offer['invoice'].'</td>
                            </tr>
                        </table>
                    </td>
                   ';
            }else{
                $html .='
                    <td>
                        <table>
                            <tr>
                                <td>SALE'.$offer['sale_no'].'</td>
                                <td>DATE'.$offer['manf_date'].'</td> 
                            </tr>
                            <tr>
                                <td>'.$offer['mark'].'</td>
                                <td>'.$offer['grade'].'</td>  
                            </tr> 
                            <tr>
                                <td>PKGS'.$offer['pkgs'].'</td>
                                <td>LOT#'.$offer['lot'].'</td>
                            </tr>
                            <tr>
                                <td>WGHT'.$offer['net'].'</td>
                                <td>Invoice'.$offer['invoice'].'</td>
                            </tr>
                        </table>
                    </td>
                    ';
            }
            $html .= '
            </table>';
            
 $rowCount++;
}    
return $html;
}
?>