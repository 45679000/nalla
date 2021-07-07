<?php 

    $path_to_root = "../";
    $path_to_root1 = "../";
    include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
    include_once ($path_to_root1.'setting.php');
    
    if(isset($_GET['filter'])){
        $summary = $_GET['filter'];
        $PHPJasperXML = new PHPJasperXML();

         switch ($summary) {
            case 'pstock':
                $PHPJasperXML->load_xml_file("jrxmlFiles/total_purchases.jrxml");
            break;
            case 'totalStock':
                $PHPJasperXML->load_xml_file("jrxmlFiles/total_stock.jrxml");
            break;
            case 'totalStockOriginal':
                $PHPJasperXML->load_xml_file("jrxmlFiles/total_stock_original.jrxml");
            break;
            case 'totalStockBlended':
                $PHPJasperXML->load_xml_file("jrxmlFiles/total_stock_blended.jrxml");
            break;
            case 'totalStockContractWise':
                $PHPJasperXML->load_xml_file("jrxmlFiles/total_stock_contractwise.jrxml");
            break;
            case 'totalStockAwaitingShipment':
                $PHPJasperXML->load_xml_file("jrxmlFiles/total_stock_awaiting_shippment.jrxml");
            break;
            case 'totalStockPaidUnallocated':
                $PHPJasperXML->load_xml_file("jrxmlFiles/total_stock_paid_unallocated.jrxml");
            break;
            case 'totalStockUnPaidUnallocated':
                $PHPJasperXML->load_xml_file("jrxmlFiles/total_stock_unpaid_unallocated.jrxml");
            break;
            default:
                $PHPJasperXML->load_xml_file("jrxmlFiles/total_stock.jrxml");
            break;
          }
          $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
          $PHPJasperXML->outpage("I");
        
        
     
    }

?>

       