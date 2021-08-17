<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/
$page_security = 'SA_GRN';
$path_to_root = "..";
include_once($path_to_root . "/purchasing/includes/po_class.inc");

include_once($path_to_root . "/includes/session.inc");
include_once($path_to_root . "/purchasing/includes/purchasing_db.inc");
include_once($path_to_root . "/purchasing/includes/purchasing_ui.inc");
include '../../database/page_init.php';
include '../../models/Model.php';
include '../../controllers/StockController.php';
page(_($help_context = "Confirm Lots Bought to Stock Test"), false, false, "", "");


$stock = new Stock($conn);
// $purchaseList = $stock->unconfrimedPurchaseList();
if((isset($_POST['lot']) && $_POST['lot'] != null) && isset($_POST['add']) && $_POST['add'] !=NULL){
    echo $add, $confirmed;
    $stock->addToStock($_POST['lot'], $_POST['add'], $_POST['confirm']);
}
if((isset($_POST['lot']) && $_POST['lot'] != null) && isset($_POST['confirm']) && $_POST['confirm'] !=NULL){
    echo $add, $confirmed;
    $stock->addToStock($_POST['lot'], $_POST['add'], $_POST['confirm']);
}
//---------------------------------------------------------------------------------------------------------------
echo '
    <style>
        #unallocated{
            background: #FF6347;
            cursor: pointer;
            border-top: solid 2px #eaeaea;
            border-left: solid 2px #eaeaea;
            border-bottom: solid 2px #777;
            border-right: solid 2px #777;
            padding: 5px 5px;
            width:60%;

        }
        #allocated{
            background: #00ff00;
            cursor: pointer;
            border-top: solid 2px #eaeaea;
            border-left: solid 2px #eaeaea;
            border-bottom: solid 2px #777;
            border-right: solid 2px #777;
            padding: 5px 5px;
            width:60%;

        }
        #confirm{
            background: #00ff00;
            cursor: pointer;
            border-top: solid 2px #eaeaea;
            border-left: solid 2px #eaeaea;
            border-bottom: solid 2px #777;
            border-right: solid 2px #777;
            padding: 5px 5px;
            width:20%;

        }
        .table{
            height:30% !important;
        }
      
    </style>

    <div id="purchaseList">

    </div>

';

//--------------------------------------------------------------------------------------------------


echo '
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/stock.js"></script
<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script>

$("#purchaseListTable tbody").on("click", "#allocated", function() {
    var thisCell = table.cell(this);
    SubmitData.lot = $(this).parents("tr").find("td:eq(0)").text();
    SubmitData.check = 0;
    console.log(SubmitData);
});

    </script>
';



