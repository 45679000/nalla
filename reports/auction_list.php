<?php 

    $path_to_root = "../";
    $path_to_root1 = "../";
    include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
    include_once ($path_to_root1.'setting.php');

    $auction = "";
    $PHPJasperXML = new PHPJasperXML();
    if(isset($_GET['filter'])){
        $auction = trim($_GET['saleno']);
          $PHPJasperXML = new PHPJasperXML();
          $PHPJasperXML->arrayParameter=array("sale_no"=>$auction);
          $PHPJasperXML->load_xml_file("jrxmlFiles/auction_targets.jrxml");
          $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
          $PHPJasperXML->outpage("I");
        
    }

?>

       