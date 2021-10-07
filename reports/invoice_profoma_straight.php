<?php 
 ob_start();

    $path_to_root = "../";
    $path_to_root1 = "../";
    include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
    include_once ($path_to_root.'setting.php');
    
    $PHPJasperXML = new PHPJasperXML();
    $PHPJasperXML->debugsql = false;
    $PHPJasperXML->arrayParameter=array("invoiceno"=>$_GET['invoiceno']);
    $PHPJasperXML->load_xml_file("jrxmlFiles/profoma_invoice_straight.jrxml");
    $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
    ob_end_clean();
    $PHPJasperXML->outpage("I");
    // if(isset($_GET['sino'])){
        
    // }


    

?>

       