<?php 
 ob_start();

    $path_to_root = "../";
    $path_to_root1 = "../../";
    include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
    include_once ($path_to_root.'setting.php');
    
    $PHPJasperXML = new PHPJasperXML();
    $PHPJasperXML->debugsql = false;
    if(isset($_GET['blendno'])){
        $PHPJasperXML->arrayParameter=array("blend_no"=>$_GET['blendno']);
        $PHPJasperXML->load_xml_file("jrxmlFiles/blend_sheet.jrxml");
        $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }


    

?>

       