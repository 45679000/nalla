<?php 
 ob_start();

    $path_to_root = "../";
    $path_to_root1 = "../";
    include_once($path_to_root1."phpjasperxml/PHPJasperXML.inc.php");
    include '../database/connection.php';
    include_once ($path_to_root.'setting.php');
    include $path_to_root."vendor/autoload.php";

    use TNkemdilim\MoneyToWords\Converter;
  

    $converter = new Converter("", "cents");
    $row = getInvoiceTotals($_GET['invoiceno']);

    $amount_in_words = $converter->convert($row['profoma_amount']);
    $total_amount = $row['net_amount'];
    $total_tax = $row['profoma_tax'];
    $PHPJasperXML = new PHPJasperXML();
    $PHPJasperXML->debugsql = false;
    $PHPJasperXML->arrayParameter=array(
     "invoiceno"=>$_GET['invoiceno'],
     "amount_in_words"=>"Us Dollars ".$amount_in_words, 
     "total_amount"=>$total_amount, 
     "total_tax" =>$total_tax
    );
    $PHPJasperXML->load_xml_file("jrxmlFiles/profoma_invoice_straight.jrxml");
    $PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
    ob_end_clean();
    $PHPJasperXML->outpage("I");
    // if(isset($_GET['sino'])){
        
    // }




    function getInvoiceTotals($invoice){

        $db = new Database();
        $conn = $db->getConnection();


        $query = "SELECT SUM(profoma_amount*kgs) AS profoma_amount, SUM(profoma_amount*kgs) * 0.01 AS profoma_tax, 
        ((SUM(profoma_amount*kgs) * 0.01) + SUM(profoma_amount*kgs)) AS net_amount 
        FROM invoice_teas
        INNER JOIN closing_stock ON closing_stock.stock_id = invoice_teas.stock_id
        WHERE invoice_no = '$invoice'";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch();

        return $row;

    }
?>

       