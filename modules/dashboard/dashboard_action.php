<?php
	header("Access-Control-Allow-Origin: *");
    include_once('../../models/Model.php');
	include ('../grading/grading.php');
	require "../../vendor/autoload.php";
    include_once('../../database/page_init.php');
    include '../../controllers/StockController.php';
    error_reporting(1);

    
    $db = new Database();
    $conn = $db->getConnection();
    $stock = new Stock($conn);
    $tag = isset($_POST['tag']) ? $_POST['tag'] : '';

    switch ($tag) {
        case 'totalP':
            $total = $stock->getTotal("buying_list", "pkgs", "WHERE added_to_plist = 1")["pkgs"];
            $description = "Total Purchases";
            $unit="Pkgs"; 
            $icon = "mdi mdi-arrow-collapse-all";
            $mdiText = "Total PKgs purchased";
            echo get_card(number_format($total), $description, $unit, $icon, $mdiText);
            break;
        case 'totalStck':
            $stock->query = "SELECT SUM(pkgs) AS pkgs
             FROM closing_stock
             WHERE SUBSTRING(sale_no, 1, 4) LIKE YEAR(CURRENT_DATE)"; 
           $totalKgs = $stock->executeQuery();


            $stock->query = "SELECT SUM(pkgs_shipped) AS pkgs_shipped
            FROM shippments
            WHERE is_shipped = 1";
            $totalShipped = $stock->executeQuery();

            $description = "Total Stock";
            $unit="Pkgs"; 
            $icon = "mdi mdi-apps";
            $mdiText = "Total Pkgs In stock";
            $totalStock = 0;
            if($totalShipped[0]['pkgs_shipped'] !=null){
                $totalStock = $totalKgs[0]['pkgs']-$totalShipped[0]['pkgs_shipped'];
            }
            else{
                $totalStock = $totalKgs[0]['pkgs'];
            }
            echo get_card(number_format($totalStock), $description, $unit, $icon, $mdiText);
            break;
            break;
        case 'totalShpd':
            $stock->query = "SELECT SUM(pkgs_shipped) AS pkgs_shipped
             FROM shippments WHERE is_shipped = 1";
            $totalKgs = $stock->executeQuery();


            $description = "Total PKgs Shipped";
            $unit="Pkgs"; 
            $icon = "mdi mdi-ferry";
            $mdiText = "Total PKgs Shipped";
            echo get_card(number_format($totalKgs[0]['pkgs_shipped']), $description, $unit, $icon, $mdiText);
            break;
        case 'totalStckO':

            $stock->query = "SELECT SUM(pkgs) AS pkgs
             FROM closing_stock";
            $totalKgs = $stock->executeQuery();

            $stock->query = "SELECT SUM(pkgs_shipped) AS pkgs_shipped
            FROM shippments
            WHERE is_shipped = 1";
            $totalShipped = $stock->executeQuery();

            $stock->query = "SELECT (CASE WHEN SUM(pkgs) IS NULL THEN 0 ELSE SUM(pkgs) END) AS pkgs
            FROM closing_stock
            WHERE is_blend_balance = 1";
            $totalOriginalPkgs = $stock->executeQuery();
            $totalStock = 0;

            if($totalShipped[0]['pkgs_shipped'] !=null){
                $totalStock = $totalKgs[0]['pkgs']-$totalShipped[0]['pkgs_shipped'];
            }
            else{
                $totalStock = $totalKgs[0]['pkgs'];
            }

           $totalOriginal = $totalStock - $totalOriginalPkgs["pkgs"];


            $description = "Total Original Teas";
            $unit="Pkgs"; 
            $icon = "mdi mdi-apple-keyboard-command";
            $mdiText = "Total Original Teas In stock";
            echo get_card(number_format($totalOriginal), $description, $unit, $icon, $mdiText);
            break;
        case 'totalStckB':
            $stock->query = "SELECT SUM(pkgs) AS pkgs
            FROM closing_stock";
            $totalKgs = $stock->executeQuery();

           $stock->query = "SELECT SUM(pkgs_shipped) AS pkgs_shipped
           FROM shippments
           WHERE is_shipped = 1";
           $totalShipped = $stock->executeQuery();

           $stock->query = "SELECT (CASE WHEN SUM(pkgs) IS NULL THEN 0 ELSE SUM(pkgs) END) AS pkgs
           FROM closing_stock
           WHERE is_blend_balance = 0";
           $totalBlendedPkgs = $stock->executeQuery();
           $totalStock = 0;

           if($totalShipped[0]['pkgs_shipped'] !=null){
               $totalStock = $totalKgs[0]['pkgs']-$totalShipped[0]['pkgs_shipped'];
           }
           else{
               $totalStock = $totalKgs[0]['pkgs'];
           }

          $totalBlended = $totalStock - $totalBlendedPkgs[0]["pkgs"];

            $description = "Total Blended Teas";
            $unit="Pkgs"; 
            $icon = "mdi mdi-apple-keyboard-command";
            $mdiText = "Total Blended PKgs In stock";
           echo get_card(number_format($totalBlendedPkgs["pkgs"]), $description, $unit, $icon, $mdiText);
            break;
        case 'totalStckAllc':
            $stock->query = "SELECT SUM(pkgs) AS pkgs
            FROM closing_stock 
            INNER JOIN shippments ON  shippments.stock_id = closing_stock.stock_id
            WHERE is_shipped = 0";
            $totalKgs = $stock->executeQuery();
            $description = "Total Allocated Teas";
            $unit="Pkgs"; 
            $icon = "mdi mdi-basket-fill";
            $mdiText = "Total Allocated PKgs Awaiting Shippment";
           echo get_card(number_format($totalKgs[0]['pkgs']), $description, $unit, $icon, $mdiText);
            break;
        case 'totalStckUnAllc':
            $stock->query = "SELECT SUM(pkgs) AS pkgs
            FROM closing_stock 
            LEFT JOIN shippments ON  shippments.stock_id = closing_stock.stock_id
            WHERE shippments.id IS NULL";

            $totalKgs = $stock->executeQuery();
            $description = "Total Unallocated Teas";
            $unit="Pkgs"; 
            $icon = "mdi mdi-basket-unfill";
            $mdiText = "Total Unallocated PKgs";
           echo get_card(number_format($totalKgs[0]['pkgs']), $description, $unit, $icon, $mdiText);
            break;
      
        case 'totalStckPAllc':
        break;
        case 'pvsvs':
            echo get_pie_chart();
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



	





