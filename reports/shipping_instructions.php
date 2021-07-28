<?php 
 ob_start();
    $path_to_root = "../";
    $path_to_root1 = "../";
    include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
    include_once ($path_to_root1.'setting.php');

    $PHPJasperXML = new PHPJasperXML();
    $PHPJasperXML->load_xml_file("jrxmlFiles/shipping_instruction.jrxml");
    $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
    ob_end_clean();
    $PHPJasperXML->outpage("I");

    // if(isset($_GET['filter'])){
    //     $auction = trim($_GET['saleno']);
    //       $PHPJasperXML = new PHPJasperXML();
    //       $PHPJasperXML->arrayParameter=array("sale_no"=>$auction);
    //       $PHPJasperXML->load_xml_file("jrxmlFiles/lot_details.jrxml");
    //       $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
    //       ob_end_clean();
    //       $PHPJasperXML->outpage("I");
        
    // }

?>

       