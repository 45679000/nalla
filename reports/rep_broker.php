<?php 

    $path_to_root = "../";
    $path_to_root1 = "../";
<<<<<<< HEAD
    // require_once $path_to_root.'templates/header.php';
    include $path_to_root.'models/Model.php';
    require $path_to_root."vendor/autoload.php";
    include $path_to_root.'modules/cataloguing/Catalogue.php';
    include $path_to_root1.'database/connection2.php';
    ini_set("pcre.backtrack_limit", "5000000");
	ini_set('memory_limit', '500M'); 
=======
    include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
    include_once ($path_to_root1.'setting.php');

>>>>>>> 69b795014357d0cbcac01869cb69bf9a85f6f580
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
        
        //$PHPJasperXML->debugsql=true;
          //page output method I:standard output  D:Download file
        // $import_date = date_format(date_create($import_date),"l jS  F Y");
       
      // $date =date("l jS  F Y");

     
    }

?>

       