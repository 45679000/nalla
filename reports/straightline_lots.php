<?php 
 ob_start();

    $path_to_root = "../";
    $path_to_root1 = "../../";
    include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
    include_once ($path_to_root.'setting.php');
    
    $PHPJasperXML = new PHPJasperXML();
    $PHPJasperXML->debugsql = false;
    if(isset($_GET['sino'])){
        $PHPJasperXML->arrayParameter=array("sino"=>$_GET['sino']);
        $PHPJasperXML->load_xml_file("jrxmlFiles/straightline_lots.jrxml");
        $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
        ob_end_clean();
        $PHPJasperXML->outpage("I");
    }


    

?>

       