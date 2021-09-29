<?php
	// Include config.php file
    include_once('../../models/Model.php');
    include_once('../../database/page_init.php');
    include_once('../../controllers/StraightLineController.php');
    include_once('../../controllers/StockController.php');


    $strCtrl = new StraightLineController($conn);
    $stockCtrl = new Stock($conn);


	// Insert Record	
	if (isset($_POST['action']) && $_POST['action'] == "show-all") {
        $straightlines = $strCtrl->fetchStraightline();
        $menu = "
        <table id='menuStraight' class='table table-sm table-responsive'>
            <thead>
                <tr>
                    <th>Contracts</th>
                </tr>
            </thead>
            <tbody>";
        foreach ($straightlines as $straightline) {
            $menu.='<tr>';
              $menu.='<td>
                <a class="contractBtn" id="'.$straightline["contract_no"].'" style="color:blue;"><i class="fa fa-folder-open-o"></i>'.$straightline["contract_no"].'</a>
              </td>';
            $menu.='</tr>';

        }
        $menu.="
        </tbody>
        </table>";

        echo $menu;
	}
    if (isset($_POST['action']) && $_POST['action'] == "create-contract") {
        $contract_no = isset($_POST["contract_no"]) ? $_POST["contract_no"] : ''; 
        $client_id = isset($_POST["client_id"]) ? $_POST["client_id"] : ''; 
        $details = isset($_POST["details"]) ? $_POST["details"] : ''; 

        $strCtrl->addStraightline($contract_no, $client_id, $details);
	}

    if (isset($_POST['action']) && $_POST['action'] == "allocated") {
        $contract_no = isset($_POST["contract_no"]) ? $_POST["contract_no"] : ''; 
        $allocatedLots = $strCtrl->allocationStraightline($contract_no);

        $output ='';

        if (sizeOf($allocatedLots)> 0) {
            $output .='
            <table id="alloc" class="table table-sm table-striped table-responsive table-bordered">
            <thead>
                <tr>
                    <th class="wd-15p">Lot</th>
                    <th class="wd-15p">Mark</th>
                    <th class="wd-25p">Net</th>
                    <th class="wd-25p">Pkgs</th>
                    <th class="wd-25p">Kgs</th>
                    <th class="wd-25p">Alloc</th>
                    <th class="wd-25p">Status</th>

                </tr>
            </thead>
            <tbody>';
            foreach ($allocatedLots as $allocated) {
                $output.='<tr>';
                
                    $output.='<td>'.$allocated["lot"].'</td>';
                    $output.='<td>'.$allocated["mark"].'</td>';
                    $output.='<td>'.$allocated["net"].'</td>';
                    $output.='<td>'.$allocated["pkgs"].'</td>';
                    $output.='<td>'.$allocated["kgs"].'</td>';
                    $output.='<td>'.$allocated["si_no"].'</td>'; 
                    if($allocated["confirmed"]==0){
                    $output.='<td> 
                    <a class="removeAlloc" id="'.$allocated["stock_id"].'" style="color:red" data-toggle="tooltip" data-placement="bottom" 
                    title="Remove" >
                    <i class="fa fa-close" ></i></a>
                    </td>'; 
                    }else{
                    $output.='<td> 
                    <a style="color:green">Confirmed</a>
                    </td>'; 
                    } 
                            
                    
                $output.='</tr>';
                    }

            $output.='</tbody>
        </table>';
                }
        echo $output;
	}
    if (isset($_POST['action']) && $_POST['action'] == "add-tea") {
        $contract_no = isset($_POST["contract_no"]) ? $_POST["contract_no"] : ''; 
        $id = isset($_POST["id"]) ? $_POST["id"] : ''; 
        $mrp_value = isset($_POST["mrp_value"]) ? $_POST["mrp_value"] : '';
        $strCtrl->addLotStraight($id, $contract_no, $mrp_value);
	}
    if (isset($_POST['action']) && $_POST['action'] == "remove-tea") {
        $contract_no = isset($_POST["contract_no"]) ? $_POST["contract_no"] : ''; 
        $id = isset($_POST["id"]) ? $_POST["id"] : ''; 
        $strCtrl->removeLotStraight($id, $contract_no);
	}
    if(isset($_POST['action']) && $_POST['action'] == "confirm-lots"){
        $contract_no = isset($_POST["contract_no"]) ? $_POST["contract_no"] : ''; 

    }
    if(isset($_POST['action']) && $_POST['action'] == 'load-unallocated'){

        $type = isset($_POST['type']) ? $_POST['type'] : '';
        $mark = isset($_POST['mark']) ? $_POST['mark'] : 'All';
        $lot = isset($_POST['lot']) ? $_POST['lot'] : 'All';
        $grade = isset($_POST['grade']) ? $_POST['grade'] : 'All';
        $saleno = isset($_POST['saleno']) ? $_POST['saleno'] : 'All';
      
      
        $filters = array();
        $filters['saleno'] = 'All';
        $filters['mark'] =  'All';
        $filters['lot'] =  'All';
        $filters['grade'] =  'All';
        $filters['broker'] = 'All';
        $filters['standard'] ='All';
        $filters['gradecode'] = 'All';
      
      
      
        $blendBalance = 0;
        $output ="";
        $stockList = $stockCtrl->readStock("", $filters);
        if (sizeOf($stockList)> 0) {
            $output .='
            <table id="direct_lot" class="table table-sm table-responsive table-striped table-bordered">
            <thead>
                <tr>
                    <th>Line No</th>
                    <th>Sale No</th>
                    <th>DD/MM/YY</th>
                    <th>Broker</th>
                    <th>Warehouse</th>
                    <th>Lot</th>
                    <th>Mark</th>
                    <th>Grade</th>
                    <th>Invoice</th>
                    <th>Code</th>
                    <th>Pkgs</th>
                    <th>Net</th>
                    <th>Kgs</th>
                    <th>Mrp Value</th>
                    <th>Actions</th>
      
                </tr>
            </thead>
            <tbody>';
            foreach ($stockList as $stock) {
                $output.='<tr>';
                    $output.='<td>'.$stock["line_no"].'</td>';
                    $output.='<td>'.$stock["sale_no"].'</td>';
                    $output.='<td>'.$stock['import_date'].'</td>';
                    $output.='<td>'.$stock["broker"].'</td>';
                    $output.='<td>'.$stock["ware_hse"].'</td>';
                    $output.='<td>'.$stock["lot"].'</td>';
                    $output.='<td>'.$stock["mark"].'</td>';
                    $output.='<td>'.$stock["grade"].'</td>';
                    $output.='<td>'.$stock["invoice"].'</td>';
                    $output.='<td>'.$stock["comment"].'</td>';
                    $output.='<td>'.$stock["pkgs"].'</td>';
                    $output.='<td>'.$stock["net"].'</td>';
                    $output.='<td>'.$stock["kgs"].'</td>';
                    $output.='<td class="mrp_value" onBlur="update_mrp(this)" id="'.$stock["stock_id"].'" contenteditable="true">'.$stock["mrp_value"].'</td>';
                    if($stock["allocated_contract"] != null){
                      $output.='<td><a style="font-size:8px;">'.$stock["allocated_contract"].'<a/>';
                      if($stock["confirmed"] == 0){
                        $output.='<a class="removeAlloc" id="'.$stock["stock_id"].'" style="color:red" data-toggle="tooltip" data-placement="bottom" 
                        title="Remove" >
                        <i class="fa fa-close" ></i></a>';
                      }
                    
                      $output.='</td>';
                
                    }else{
                        $output.='<td>';
                     $output.= '<a class="addTea" id="'.$stock["stock_id"].'" style="color:green" data-toggle="tooltip" data-placement="bottom" title="Use Tea" >
                      <i class="fa fa-arrow-right" ></i></a>&nbsp&nbsp&nbsp;
                      <a class="splitLot" id="'.$stock["stock_id"].'" style="color:red" data-toggle="tooltip" data-placement="bottom" title="Split Lot">
                      <i class="fa fa-scissors"></i></a>&nbsp&nbsp&nbsp;
                      
                    </td>'; 
                    }
                             
                $output.='</tr>';
                    
            }
            $output.='</tbody>
        </table>';
        }    
       echo $output;
      }else{
        
    }
    if(isset($_POST['action']) && $_POST['action'] == 'summaries'){
        $contract_no = isset($_POST["contract_no"]) ? $_POST["contract_no"] : ''; 

        $totals = $strCtrl->summary($contract_no);

        echo json_encode($totals);
    }
    if(isset($_POST['action']) && $_POST['action'] == 'approve'){
        $contract_no = isset($_POST["contract_no"]) ? $_POST["contract_no"] : ''; 
        $totals = $strCtrl->approveShippment($contract_no);
    }
    if(isset($_POST['action']) && $_POST['action'] == 'post-mrp'){
        $mrpvalue = isset($_POST["value"]) ? $_POST["value"] : ''; 
		$stockid = isset($_POST["stock_id"]) ? $_POST["stock_id"] : ''; 

        $strCtrl->updateMrp($mrpvalue, $stockid);
    }



    


    
    