<?php 
 ob_start();
    $path_to_root = "../";
    $path_to_root1 = "../";
    include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
    include_once ($path_to_root1.'setting.php');

    $PHPJasperXML = new PHPJasperXML();
    if(isset($_GET['filter'])){

          $PHPJasperXML = new PHPJasperXML();
          $PHPJasperXML->debugsql = false;

          if(isset($_GET['type'])){
            $type = trim($_GET['type']);
            switch ($type) {
              case 'private':
                $PHPJasperXML->load_xml_file("jrxmlFiles/provisional_plist.jrxml");
              break;
              case 'auction':
                $PHPJasperXML->load_xml_file("jrxmlFiles/auction_plist.jrxml");
              break;
              default:
                break;
            }
            $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
            ob_end_clean();
  
            $PHPJasperXML->outpage("I");
          }
        
    }

?>

       