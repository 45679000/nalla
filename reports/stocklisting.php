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
                $PHPJasperXML->load_xml_file("jrxmlFiles/total_purchases.jrxml");
            break;
            case 'dust':
              $PHPJasperXML->load_xml_file("jrxmlFiles/brokersCatalogueDust.jrxml");
            break;
            case 'leaf':
              $PHPJasperXML->load_xml_file("jrxmlFiles/brokersCatalogueLeaf.jrxml");
            break;

            default:
              $PHPJasperXML->load_xml_file("jrxmlFiles/brokersCatalogue.jrxml");
              break;
          }
          $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
          $PHPJasperXML->outpage("I");
        
        
     
    }

?>

       