<?php 
 ob_start();
    $path_to_root = "../";
    $path_to_root1 = "../";
    include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
    include_once ($path_to_root1.'setting.php');

    $auction = "";
    $broker = "";

    $PHPJasperXML = new PHPJasperXML();
    if(isset($_GET['filter'])){

          $auction = trim($_GET['saleno']);
          $broker = trim($_GET['broker']);

          $PHPJasperXML = new PHPJasperXML();

          $PHPJasperXML->arrayParameter=array("sale_no"=>$auction, "broker"=>$broker);

          $PHPJasperXML->load_xml_file("jrxmlFiles/auction_targets.jrxml");
          $PHPJasperXML->debugsql = false;

          $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
          ob_end_clean();
          $PHPJasperXML->outpage("I");
        
    }

?>

       