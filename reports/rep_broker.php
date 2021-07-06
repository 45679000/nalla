<?php 

    $path_to_root = "../";
    $path_to_root1 = "../";
    include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
    include_once ($path_to_root1.'setting.php');

    $broker ="";
    $category = "";
    $auction = "";
    

  

    $import_date ="";
    
    if(isset($_GET['filter'])){
        $auction = trim($_GET['saleno']);
        $broker = trim($_GET['broker']);
        $PHPJasperXML = new PHPJasperXML();

        if(isset($_GET['category'])){
          $category = trim($_GET['category']);
          $PHPJasperXML->arrayParameter=array("sale_no"=>$auction, "broker"=>$broker);

          switch ($category) {
            case 'main':
              $PHPJasperXML->load_xml_file("jrxmlFiles/brokersCatalogueMain.jrxml");
              break;
            case 'sec':
              $PHPJasperXML->load_xml_file("jrxmlFiles/brokersCatalogueSec.jrxml");
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
        }else{
          $PHPJasperXML->arrayParameter=array("sale_no"=>$auction, "broker"=>$broker);

          $PHPJasperXML->load_xml_file("jrxmlFiles/brokersCatalogue.jrxml");

          $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
          $PHPJasperXML->outpage("I");  

        }
        
     
    }

?>

       