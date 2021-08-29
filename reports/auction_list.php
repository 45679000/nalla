<?php 
 ob_start();
    $path_to_root = "../";
    $path_to_root1 = "../";
    include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
    include_once ($path_to_root1.'setting.php');

    $auction = "";
    $broker = "";
    $category = "";

    $PHPJasperXML = new PHPJasperXML();
    if(isset($_GET['filter'])){

          $auction = trim($_GET['saleno']);
          $broker = trim($_GET['broker']);

          $PHPJasperXML = new PHPJasperXML();

          if(isset($_GET['category'])){
            $category = trim($_GET['category']);
            $PHPJasperXML->arrayParameter=array("sale_no"=>$auction, "broker"=>$broker);
            switch ($category) {
              case 'Sec':
                $PHPJasperXML->load_xml_file("jrxmlFiles/auction_targets_sec.jrxml");
              break;
              case 'dust':
                $PHPJasperXML->load_xml_file("jrxmlFiles/auction_targets_dust.jrxml");
              break;
              case 'leaf':
                $PHPJasperXML->load_xml_file("jrxmlFiles/auction_targets_leaf.jrxml");
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

       