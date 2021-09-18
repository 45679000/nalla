<?php
	// Include config.php file
    include_once('../../models/Model.php');
    include_once('../../database/page_init.php');
    include_once('../../controllers/StraightLineController.php');

    $strCtrl = new StraightLineController($conn);

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
        $strCtrl->addLotStraight($id, $contract_no);
	}
    if (isset($_POST['action']) && $_POST['action'] == "remove-tea") {
        $contract_no = isset($_POST["contract_no"]) ? $_POST["contract_no"] : ''; 
        $id = isset($_POST["id"]) ? $_POST["id"] : ''; 
        $strCtrl->removeLotStraight($id, $contract_no);
	}
    if(isset($_POST['action']) && $_POST['action'] == "confirm-lots"){
        $contract_no = isset($_POST["contract_no"]) ? $_POST["contract_no"] : ''; 

    }
    
    