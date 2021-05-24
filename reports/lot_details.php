<?php
    
        include '../models/Model.php';
        include '../database/connection.php';
        include '../modules/cataloguing/Catalogue.php';

    
        $db = new Database();
        $conn = $db->getConnection();
        $catalogue = new Catalogue($conn);
        
        
      
    

?>

<!doctype html>
<html>
<style>
    #outertable {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }

    #outertable td, #outertable th {
    border: 1px solid #ddd;
    padding: 8px;
    }

    #outertable tr:nth-child(even){background-color: #f2f2f2;}

    #outertable tr:hover {background-color: #ddd;}

    #outertable th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #4CAF50;
    color: white;
    }
</style>

<body>
    <table  style="width:100%; border:1px;">
        <tr>
            <td style="width:50%; text-align:center; background-color:aqua;">
               <p>CHAMU SUPPLIES LIMITED BLEND-SHEET 8112/11 -1 x 40 FCL ALMATY INVOICE ADE 21306</p>
            </td>
        </tr>
        <table id="outertable" style="width:100%; border:1px;">
            <td>Sale No</td>
            <td>DD/MM/YY</td>
            <td>Broker</td>
            <td>Warehouse</td>
            <td>Lot</td>
            <td>Origin</td>
            <td>Mark</td>
            <td>Grade</td>
            <td>Invoice</td>
            <td>Pkgs</td>
            <td>Net</td>
            <td>Kgs</td>
            <td>Auction Hammer Price per Kg(USD)</td>
            <td>Value Ex Auction</td>
            <td>Brokerage Amount 0.5 % on value(USD)</td>
            <td>Final Prompt Value Including Brokerage 0.5 % on value(USD)</td>
            <td>Witdholding Tax @ 5% Of Brokerage Amount Payable to Domestic Taxes Dept(USD)</td>
            <td>Prompt Payable to EATTA-TCA After Deduction of W.Tax</td>
            <td>Add on(Over Auction Hammer Price+ Brokerage) Per Kg (USD))</td>
            <td>Final Sales Invoice Price Per Kg(USD)</td>
            <td>Final Sales Invoice Value(USD)</td>
            <!-- <td>
                <table style="width:100%; text-align:center;">
                    <tr style="text-align:center;">
                        <td style="text-align:center;">ALLOCATION</td>
                    </tr>
                    <tr>
                        <td>Grade Code</td>
                        <td>Warehouse</td>
                        <td>SI/Blend No</td>
                    </tr>
                </table>
            </td> -->
<?php
    foreach($catalogue->stockList() as $dat){
       $row='<tr>';
       
            $brokerage = ($dat['value']*$dat['pkgs'])*(0.5/100);
            $value = $dat['value']*$dat['pkgs'];
            $totalamount = $brokerage+$value;
            $afterTax = ($totalamount)-(5/100)*$brokerage;
            $auctionHammer = ($dat['value']/$dat['kgs']);
            $addon = ($auctionHammer+$brokerage)/$dat['pkgs'];
            $totalPayable = $addon+$auctionHammer;

            $row.='<td>'.$dat['sale_no'].'</td>';
            $row.='<td>'.$catalogue->ExcelToPHP($dat['manf_date']).'</td>';
            $row.='<td>'.$dat['broker'].'</td>';
            $row.='<td>'.$dat['ware_hse'].'</td>';
            $row.='<td>'.$dat['lot'].'</td>';
            $row.='<td>KENYA</td>';
            $row.='<td>'.$dat['mark'].'</td>';
            $row.='<td>'.$dat['grade'].'</td>';
            $row.='<td>'.$dat['invoice'].'</td>'; 
            $row.='<td>'.$dat['pkgs'].'</td>'; //pkgs
            $row.='<td>'.$dat['kgs'].'</td>'; //net
            $row.='<td>'.$dat['net'].'</td>'; //kgs
            $row.='<td>'.($dat['value']/$dat['kgs']).'</td>'; //auction hammer
            $row.='<td>'.$value.'</td>'; //value ex auction
            $row.='<td>'.$brokerage.'</td>';// brokerage fee
            $row.='<td>'.$totalamount.'</td>'; //final prompt value
            $row.='<td>'.(5/100)*$brokerage.'</td>';
            $row.='<td>'.$afterTax.'</td>';
            $row.='<td>'.$addon.'</td>';
            $row.='<td>'.$totalPayable.'</td>';
            $row.='<td>'.$totalPayable*$dat['net'].'</td>';
       $row.='</tr>';
echo $row;
    }
    
?>
           

        </table>
        </table>
</body>

</html>