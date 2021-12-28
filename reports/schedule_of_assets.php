<?php 
 ob_start();

    $path_to_root = "../";
    $path_to_root1 = "../";
    include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
    include_once ($path_to_root.'setting.php');
    
    $PHPJasperXML = new PHPJasperXML();
    $PHPJasperXML->debugsql = false;

    $PHPJasperXML->arrayParameter=array("id"=>$_GET['id']);
    $PHPJasperXML->load_xml_file("jrxmlFiles/schedule_of_assets.jrxml");
    $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
    ob_end_clean();
    $PHPJasperXML->outpage("I");
    


    

?>

       