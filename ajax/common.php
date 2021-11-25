<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include '../database/connection.php';
include '../models/Model.php';
include '../controllers/CatalogController.php';
include '../controllers/FinanceController.php';
include '../controllers/ShippingController.php';
include '../controllers/WarehouseController.php';
include '../modules/grading/grading.php';




$db = new Database();
$conn = $db->getConnection();
$catalogue = new Catalogue($conn);
$grading = new Grading($conn);
$shipingCtr = new ShippingController($conn);
$warehouseCtr = new WarehouseController($conn);
$financeCtlr = new Finance($conn);

$model = new Model($conn);


if (isset($_POST['action']) && $_POST['action'] == "list-brokers") {
    $type = isset($_POST['filterType']) ? $_POST['filterType'] : 'Select';

    $output = "";

    $brokers = $catalogue->PrintBrokers();
            $output = '<option  value="'.$type.'" selected="">'.$type.'</option>';
    if ($catalogue->totalRowCount("brokers") > 0) {

         foreach($brokers as $broker){
            $output .= '<option value="'.$broker['code'].'">'.$broker['code'].'||'.$broker['name'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
}

if (isset($_POST['action']) && $_POST['action'] == "garden-list") {
    $type = isset($_POST['filterType']) ? $_POST['filterType'] : 'Select';

    $output = "";

    $gardens = $catalogue->PrintGardens();
    $output = '<option  value="'.$type.'" selected="">'.$type.'</option>';
    if ($catalogue->totalRowCount("brokers") > 0) {

         foreach($gardens as $garden){
            $output .= '<option value="'.$garden['mark'].'">'.$garden['mark'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
}

if (isset($_POST['action']) && $_POST['action'] == "grade-list") {
    $output = "";

    $grades= $catalogue->PrintGrades();
            $output = '<option disabled="" value="..." selected="">select</option>';
    if ($catalogue->totalRowCount("brokers") > 0) {

         foreach($grades as $grade){
            $output .= '<option value="'.$grade['name'].'">'.$grade['name'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
}
if (isset($_POST['action']) && $_POST['action'] == "standard-list") {
    $type = isset($_POST['filterType']) ? $_POST['filterType'] : 'Select';

    $output = "";

    $standard= $catalogue->PrintStandard();
    $output = '<option  value="'.$type.'" selected="">'.$type.'</option>';
    if (sizeOf($standard) > 0) {
         foreach($standard as $standard){
            $output .= '<option value="'.$standard['standard'].'">'.$standard['standard'].'</option>';

         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
    
}
if (isset($_POST['action']) && $_POST['action'] == "codes") {
    $type = isset($_POST['filterType']) ? $_POST['filterType'] : 'Select';

    $output = "";

    $codes= $catalogue->PrintGradingCodes();
    $output = '<option  value="'.$type.'" selected="">'.$type.'</option>';
    if (sizeOf($codes) > 0) {
         foreach($codes as $code){
            $output .= '<option value="'.$code['id'].'">'.$code['code'].'</option>';

         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
    
}

if (isset($_POST['action']) && $_POST['action'] == "lot-list") {
    $output = "";

    if(isset($_POST['id'])){
        $lots= $catalogue->PrintLots($_POST['id']);
        echo json_encode($lots);
    }else{
        $lots= $catalogue->PrintLots(0);

        $output = '<option disabled="" value="..." selected="">select</option>';
        if (sizeOf($lots) > 0) {
             foreach($lots as $lots){
                $output .= '<option value="
                 '.$lots['stock_id'].'">'.$lots['lot']. 
                "<b> ||GARDEN  </b>||".$lots['mark']."  
                GRADE || ".$lots['grade']. " || PACKAGES IN STOCK:".$lots['pkgs']."
                || INVOICE:".$lots['invoice'].'</option>';
             }
              echo $output;	
        }else{
            echo '<option disabled="" value="..." selected="">select</option>';
        }
    }
    
}

if (isset($_POST['action']) && $_POST['action'] == "update") {
    $output = "Allocated successfully";
    $tableName = isset($_POST['tableName']) ? $_POST['tableName'] : ''; 
    $value = isset($_POST['value']) ? $_POST['value'] : ''; 
    $id = isset($_POST['id']) ? $_POST['id'] : ''; 
    $columnName = isset($_POST['columnName']) ? $_POST['columnName'] : ''; 

    $catalogue->update($tableName, $value, $id, $columnName);

}
if (isset($_POST['action']) && $_POST['action'] == "add-remark") {
     $remark = $_POST['remark'];
     $lot = $_POST['lot'];
    $catalogue->insertRemarks($remark, $lot);

}
if (isset($_POST['action']) && $_POST['action'] == "remark-opt") {
   echo json_encode($catalogue->loadRemarks());

}
if (isset($_POST['action']) && $_POST['action'] == "clear") {
    $catalogue->clearOffers();
    echo json_encode("offers cleared");
 
 }
 if(isset($_POST['action']) && $_POST['action'] == "load-target"){
    $imports = array();
    $saleNo = isset($_POST['saleno']) ? $_POST['saleno'] : '';
    $broker = isset($_POST['broker']) ? $_POST['broker'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : 'All';

    if($saleNo!==''){
        $imports = $catalogue->closingCatalogue($saleNo, $broker, $category);
    }

    $html='<table id="closingimport" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th class="wd-15p">Lot No</th>
                    <th class="wd-15p">Ware Hse.</th>
                    <th class="wd-20p">Company</th>
                    <th class="wd-15p">Mark</th>
                    <th class="wd-10p">Grade</th>
                    <th class="wd-25p">Invoice</th>
                    <th class="wd-25p">Pkgs</th>
                    <th class="wd-25p">Net</th>
                    <th class="wd-25p">Code</th>
                    <th class="wd-25p">Comment</th>
                    <th class="wd-25p">Standard</th>

                </tr>
            </thead>
            <tbody>';
         
            foreach ($imports as $import){
                $comment = $import["grading_comment"];
                $id = $import["lot"];
                $html.='<tr>';
                    $html.='<td>'.$import["lot"].'</td>';
                    $html.='<td>'.$import["ware_hse"].'</td>';
                    $html.='<td>'.$import["company"].'</td>';
                    $html.='<td>'.$import["mark"].'</td>';
                    $html.='<td>'.$import["grade"].'</td>';
                    $html.='<td>'.$import["invoice"].'</td>';
                    $html.='<td>'.$import["pkgs"].'</td>';
                    $html.='<td>'.$import["net"].'</td>';
                    $html.='<td>'.$import["comment"].'</td>';
                    $html.='<td><input
                        name="remark"
                        id="'.$id.'"
                        list="remarks"
                        class="noedit"
                        onBlur="addRemark(this)"
                        onClick="toggleClass(this)"
                        value="'.$comment.'"
                        />
                        <datalist id="remarks">
                            <option>opt 1</option>
                            <option>opt 2</option>
                        </datalist>';
                    $html.= '<td>'.$import["standard"].'</td>';
                $html.='</tr>';
            }
        $html.= '</tbody>
        </table>';
        return $html;

 }
 if (isset($_POST['action']) && $_POST['action'] == "add-target") {
    if(isset($_POST['lot'])){
        $grading->addToBuyingList($_POST['lot'], $_POST['check'], "target");
    }  
 }
 if (isset($_POST['action']) && $_POST['action'] == "add-price") {
    if(isset($_POST['lot'])){
        $grading->grade($_POST['lot'], $_POST['maxPrice'], "max_bp");
    }  
 }
 if (isset($_POST['action']) && $_POST['action'] == "clients") {
    $output = "";

    $clients= $shipingCtr->fetchErpClients();
    $output = '<option disabled="" value="..." selected="">select</option>';
    if (sizeOf($clients) > 0) {
         foreach($clients as $clients){
            $output .= '<option name="'.$clients['address'].'" value="'.$clients['debtor_no'].'">'.$clients['debtor_ref'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
    
}
if (isset($_POST['action']) && $_POST['action'] == "client-opt") {
    $clients= $shipingCtr->fetchErpClients();
    echo json_encode($clients);
    
}
if (isset($_POST['action']) && $_POST['action'] == "warehouse") {
    $output = "";
    $model->tablename="warehouses";
    $warehouses= $model->selectMany();
    $output = '<option disabled="" value="..." selected="">select</option>';
    if (sizeOf($warehouses) > 0) {
         foreach($warehouses as $warehouse){
            $output .= '<option value="'.$warehouse['id'].'">'.$warehouse['name']."-".$warehouse['location'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
    
}
if (isset($_POST['action']) && $_POST['action'] == "sale_no") {
    $type = isset($_POST['filterType']) ? $_POST['filterType'] : 'Select';

    $output = "";
    $auctions= $catalogue->auctionList();
    $output = '<option  value="'.$type.'" selected="">'.$type.'</option>';
    if (sizeOf($auctions) > 0) {
         foreach($auctions as $auction){
            $output .= '<option value="'.$auction.'">'.$auction.'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
    
}
if (isset($_POST['action']) && $_POST['action'] == "payment-terms") {
    $output = "";
    $paymentterms= $financeCtlr->paymentTerms();
    $output = '<option disabled="" value="..." selected="">select</option>';
    if (sizeOf($paymentterms) > 0) {
         foreach($paymentterms as $terms){
            $output .= '<option value="'.$terms['terms'].'">'.$terms['terms'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
    
}
if (isset($_POST['action']) && $_POST['action'] == "buyers") {
    $output = "";

    $buyers= $financeCtlr->fetchErpClients();
    $output = '<option disabled="" value="..." selected="">select</option>';
    if (sizeOf($buyers) > 0) {
         foreach($buyers as $buyer){
            $output .= '<option name="'.$buyer['address'].'" value="'.$buyer['debtor_no'].'">'.$buyer['debtor_ref'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
    
}
if (isset($_POST['action']) && $_POST['action'] == "sale_no_prvt") {
    $output = "";
    $auctions= $catalogue->auctionList();
    $output = '<option disabled="" value="..." selected="">select</option>';
    if (sizeOf($auctions) > 0) {
         foreach($auctions as $auction){
            $output .= '<option value="PRVT-'.$auction.'">'.'PRVT-'.$auction.'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    } 
}
if (isset($_POST['action']) && $_POST['action'] == "bank_id") {
    $output = "";

    $banks= $financeCtlr->fetchErpBanks();
    $output = '<option disabled="" value="..." selected="">select</option>';
    if (sizeOf($banks) > 0) {
         foreach($banks as $bank){
            $output .= '<option name="'.$bank['bank_address'].'" value="'.$bank['account_code'].'">'.$bank['bank_account_name'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
    
}
if (isset($_POST['action']) && $_POST['action'] == "material_type") {
    $output = "";
    $model->tablename = "material_types";
    $materialTypes= $model->selectMany();
    $output = '<option disabled="" value="..." selected="">select</option>';
    if (sizeOf($materialTypes) > 0) {
         foreach($materialTypes as $types){
            $output .= '<option name="'.$types['name'].'" value="'.$types['id'].'">'.$types['name']."-".$types['description'].'</option>';
         }
          echo $output;	
    }else{
        echo '<option disabled="" value="..." selected="">select</option>';
    }
    
}
?>
