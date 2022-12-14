<?php
	header("Access-Control-Allow-Origin: *");
    include_once('../../models/Model.php');
	include ('../grading/grading.php');
	require "../../vendor/autoload.php";
    include_once('../../database/page_init.php');
    include '../../controllers/StockController.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    $db = new Database();
    $conn = $db->getConnection();
    $stock = new Stock($conn);
    $tag = isset($_POST['tag']) ? $_POST['tag'] : '';

    $stock->query = "SELECT (CASE WHEN SUM(pkgs) IS NULL THEN 0 ELSE SUM(pkgs) END)  AS stock_pkgs
    FROM closing_stock"; 
    $totalStockPkgs = $stock->executeQuery();

    $stock->query = "SELECT (CASE WHEN SUM(pkgs_shipped) IS NULL THEN 0 ELSE SUM(pkgs_shipped) END) AS pkgs_shipped
    FROM shippments
    WHERE is_shipped = 1";
    $totalShipped = $stock->executeQuery();

    $stock->query = "SELECT (CASE WHEN SUM(pkgs) IS NULL THEN 0 ELSE SUM(pkgs) END) AS original_pkgs
    FROM closing_stock
    LEFT JOIN shippments ON shippments.stock_id = closing_stock.stock_id
    WHERE is_blend_balance = 0";
    $totalOriginalPkgs = $stock->executeQuery();

    $stock->query = "SELECT (CASE WHEN SUM(pkgs) IS NULL THEN 0 ELSE SUM(pkgs) END) AS blended_pkgs
    FROM closing_stock
    LEFT JOIN shippments ON shippments.stock_id = closing_stock.stock_id
    WHERE is_blend_balance = 1";
    $totalBlendedPkgs = $stock->executeQuery();

    $stock->query = "SELECT (CASE WHEN SUM(pkgs_shipped) IS NULL THEN 0 ELSE SUM(pkgs_shipped) END) AS pkgs_shipped 
    FROM  shippments 
    WHERE is_shipped = 0";
    $totalShippedPkgs = $stock->executeQuery();

    $stock->query = "SELECT (CASE WHEN SUM(pkgs_shipped) IS NULL THEN 0 ELSE SUM(pkgs_shipped) END) AS pkgs_allocated 
    FROM  shippments
    WHERE is_shipped = 0";
    $totalAllocationsPkgs = $stock->executeQuery();

    $stock->query = "SELECT (CASE WHEN SUM(pkgs) IS NULL THEN 0 ELSE SUM(pkgs) END) AS pkgs_shipped 
    FROM closing_stock 
    LEFT JOIN shippments ON closing_stock.stock_id = shippments.stock_id 
    WHERE shippments.id IS NULL";
    $totalUnAllocationsPkgs = $stock->executeQuery();


    $stock->query = "SELECT SUM(pkgs) AS pkgs, sale_no
    FROM buying_list 
    WHERE buying_list.buyer_package = 'CSS' AND buying_list.added_to_stock = 1 AND buying_list.sale_no like '%2022%'
    GROUP BY sale_no";
    $stockBySaleno = $stock->executeQuery();

    $stock->query = "SELECT shipping_instructions.contract_no, shipping_instructions.status, shipping_instructions.`updated_on`, 
    shipping_instructions.`sent_to_warehouse`, buyer, SUM(shippments.pkgs_shipped)  AS pkgs_shipped
    FROM shipping_instructions 
    INNER JOIN shippments ON shippments.instruction_id = shipping_instructions.instruction_id 
    LEFT JOIN 0_debtors_master ON 0_debtors_master.debtor_no = shipping_instructions.buyerid 
    GROUP BY shipping_instructions.contract_no ";

    $shippmentStatus = $stock->executeQuery();



    $totalStock = $totalStockPkgs[0]['stock_pkgs']-$totalShipped[0]['pkgs_shipped'];

    $totalShippments = $totalShipped[0]['pkgs_shipped'];
    $totalStockOriginalTeas =  $totalStock- $totalBlendedPkgs[0]['blended_pkgs'];
    $totalStockBlendedTeas = $totalStock-$totalStockOriginalTeas;
    $totalStockShipped = $totalShippedPkgs[0]["pkgs_shipped"];
    $totalStockAllocated = $totalAllocationsPkgs[0]["pkgs_allocated"];
    $totalStockUnAllocations =  $totalUnAllocationsPkgs[0]["pkgs_shipped"];
    $current_year = date("Y");

    switch ($tag) {
        case 'totalP':
            $total = $stock->getTotal("buying_list", "pkgs", "WHERE added_to_stock = 1 AND sale_no LIKE '%$current_year%'")["pkgs"];
            $description = "Total Purchases";
            $unit="Pkgs"; 
            $icon = "mdi mdi-arrow-collapse-all";
            $mdiText = "Total PKgs purchased";
            echo get_card(number_format($total), $description, $unit, $icon, $mdiText);
            break;
        case 'totalStck':
            $description = "Total Stock";
            $unit="Pkgs"; 
            $icon = "mdi mdi-apps";
            $mdiText = "Total Pkgs In stock";
           
            echo get_card(number_format($totalStock), $description, $unit, $icon, $mdiText);
            break;
            break;
        case 'totalShpd':
            $description = "Total PKgs Shipped";
            $unit="Pkgs"; 
            $icon = "mdi mdi-ferry";
            $mdiText = "Total PKgs Shipped";
            echo get_card(number_format($totalShippments), $description, $unit, $icon, $mdiText);
            break;
        case 'totalStckO':
            $description = "Total Original Teas";
            $unit="Pkgs"; 
            $icon = "mdi mdi-apple-keyboard-command";
            $mdiText = "Total Original Teas In stock";
            echo get_card(number_format($totalStockOriginalTeas+3313), $description, $unit, $icon, $mdiText);
            break;
        case 'totalStckB':
            $description = "Total Blended Teas";
            $unit="Pkgs"; 
            $icon = "mdi mdi-apple-keyboard-command";
            $mdiText = "Total Blended PKgs In stock";
           echo get_card(number_format($totalStockBlendedTeas-3313), $description, $unit, $icon, $mdiText);
            break;
        case 'totalStckAllc':
         
            $description = "Total Allocated Teas";
            $unit="Pkgs"; 
            $icon = "mdi mdi-basket-fill";
            $mdiText = "Total Allocated PKgs Awaiting Shippment";
           echo get_card(number_format($totalStockAllocated), $description, $unit, $icon, $mdiText);
            break;
        case 'totalStckUnAllc':
            $totalKgs = $stock->executeQuery();
            $description = "Total Unallocated Teas";
            $unit="Pkgs"; 
            $icon = "mdi mdi-basket-unfill";
            $mdiText = "Total Unallocated PKgs";
           echo get_card(number_format($totalStockUnAllocations), $description, $unit, $icon, $mdiText);
            break;
        case 'barChart0':
           echo json_encode($stockBySaleno);
        break;
        case 'shippmentStatus':
            echo get_table_card($shippmentStatus);
        break;
        default:
            # code...
        break;
    }
    

    function get_card($total, $description, $unit, $icon, $mdiText){
       $output = '
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-right">
                        <i class="'.$icon.' text-warning icon-size"></i>
                    </div>
                    <div class="float-left">
                        <p class="mb-0 text-left">'.$description.'</p>
                        <div class="">
                            <h3 id="purchases" class="font-weight-semibold text-left mb-0">
                               '.$total.' '.$unit. '
                            </h3>
                        </div>
                    </div>
                </div>
                <p class="text-muted mb-0">
                    <i class="mdi mdi-arrow-up-drop-circle text-success mr-1" aria-hidden="true"></i>
                    '.$mdiText.'
                </p>
            </div>
        </div>
    </div>';
    return $output;
    }
    function get_pie_chart(){
        $output = '
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">3D Pie Chart</h3>
            </div>
            <div class="card-body">
                <div id="highchart3"></div>
            </div>
        </div>
    ';
     return $output;
     }

     function get_table_card($shippmentStatus){
         $output = '<table class="table table-hover table-outline table-vcenter text-nowrap card-table">
         <thead>
             <tr>
                 <th></th>
                 <th>SI No</th>
                 <th>Pkgs</th>
                 <th>Status</th>
                 <th>Updated On</th>
             </tr>
         </thead>
         <tbody>';
         foreach($shippmentStatus as $shippment){
             $output.='<tr>';
             $output.='<td class="text-center">
                        <div class="avatar brround d-block" style="background-image: url(../images/shippments.jpg)">
                        </div>
                    </td>';
             $output.='<td>'.$shippment["contract_no"].'</td>';
             $output.='<td>'.$shippment["pkgs_shipped"].'</td>';
             $output.='<td>'.$shippment["status"].'</td>';
             $output.='<td>'.$shippment["updated_on"].'</td>';
             $output.='</tr>';

         }
         $output.='</tbody>
     </table>';

     return $output;
     }



	





