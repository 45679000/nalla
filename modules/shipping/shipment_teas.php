<?php
if($type=='Blend Shippment'){
    $output ="";
    $blendList = $blendingCtrl->fetchBlends();
    if (sizeOf($blendList)> 0) {
            $output .='
        <table id="shippmentTeasBlend" class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th class="wd-15p">Blend No</th>
                <th class="wd-15p">STD Name</th>
                <th class="wd-15p">Grade</th>
                <th class="wd-20p">Client Name</th>
                <th class="wd-15p">NW</th>
                <th class="wd-10p">Output Pkgs</th>
                <th class="wd-25p">Input Pkgs</th>
                <th class="wd-25p">LIST<th/>
            </tr>
        </thead>
        <tbody>';
        foreach ($blendList as $blend) {
            $output.='<tr>';
                $output.='<td>'.$blend["blend_no"].'</td>';
                $output.='<td>'.$blend["std_name"].'</td>';
                $output.='<td>'.$blend["Grade"].'</td>';
                $output.='<td>'.$blend["client_name"].'</td>';
                $output.='<td>'.$blend["Pkgs"].'</td>';
                $output.='<td>'.$blend["nw"].'</td>';
                $output.='<td>'.$blend["Pkgs"]*$blend["nw"].'</td>'; 
                $output.='<td><a id="list" href="#">List</a></td>';
                if($blend["si_no"]!=null){
                    $output.='<td><button id="'.$si.'">SI attached</button></td>'; 
                }else{
                    $output.='<td><button id="'.$si.'">Attach SI</button></td>'; 
                } 
     
            $output.='</tr>';
        }
        $output.='</tbody>
        </table>';
    }
        echo $output;

}else{
    $contractNo = $shippingCtrl->getContractNo($si);
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $blendBalance = 0;
    $output ="";
    $stockList = $shippingCtrl->loadSelectedForshipment($contractNo[0]['contract_no']);
    if (sizeOf($stockList)> 0) {
        $output .='
        <table id="direct_lot" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class="wd-15p">Lot</th>
                <th class="wd-15p">Mark</th>
                <th class="wd-10p">Grade</th>
                <th class="wd-25p">Invoice</th>
                <th class="wd-25p">Pkgs</th>
                <th class="wd-25p">Net</th>
                <th class="wd-25p">Kgs</th>
                <th class="wd-25p">Code</th>
                <th class="wd-25p">Allocation</th>
  
            </tr>
        </thead>
        <tbody>';
        foreach ($stockList as $stock) {
            $output.='<tr>';
                $packagesToAllocate = $stock["shipped_packages"];
                $allocation = $stock["allocation"];
                $id=$stock["allocation_id"];
                if($stock["selected_for_shipment"]!= NULL){
                  $id=$stock["selected_for_shipment"];
                }
                if($stock["selected_for_shipment"]== NULL){
                  $packagesToAllocate = $stock["pkgs"];
                }
                if($stock["si_no"] !=null){
                  $allocation = $stock["si_no"];
                }
                $output.='<td>'.$stock["lot"].'</td>';
                $output.='<td>'.$stock["mark"].'</td>';
                $output.='<td>'.$stock["grade"].'</td>';
                $output.='<td>'.$stock["invoice"].'</td>';
                $output.='<td id="packages">'.$packagesToAllocate.'</td>';
                $output.='<td>'.$stock["net"].'</td>';
                $output.='<td>'.$stock["kgs"].'</td>';
                $output.='<td>'.$stock["comment"].'</td>';
                $output.='<td id="'.$id.'allocation">'.$allocation.'</td>';                
            $output.='</tr>';
                }
  
        $output.='</tbody>
    </table>';
            }
   echo $output;
}
?>
<div class="text-center">
<a id="previous" href="#" class="previous">&laquo; Previous</a>
<a id="next" href="#" class="next">Next &raquo;</a>
</div>
<script src="shipping.js"></script>
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../../assets/js/vendors/selectize.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>

<!-- counter  -->
<script src="../../assets/plugins/counters/counterup.min.js"></script>
<script src="../../assets/plugins/counters/waypoints.min.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script>
$(document).ready(function() {
    $(function() {
        var blendno;
        var sino = '<?php echo $_GET['sino']; ?>'
        $('.table tr').click(function(e){
        var cell = $(e.target).get(0); // This is the TD you clicked
        var tr = $(this); // This is the TR you clicked
        $('td', tr).each(function(i, td){
            if(i==0){
                blendno = $(td).text();
                appendSi(blendno, sino);
            }
        });
    });

});
  function appendSi(blendno, sino){
    $.ajax({   
            type: "POST",
            data : {
                sino:sino,
                blendno:blendno,
                action:"attach-blend-si"

            },
            cache: false,  
            url: "shipping_action.php",   
            success: function(data){
                swal('Success',data.message, 'success');
                // location.reload(); 
            }   
        });   
  }
});
$('#next').click(function(){
    var sino = '<?php echo $_GET['sino']; ?>'
    window.location.href = './index.php?view=documents&sino='+sino;

});
$('#previous').click(function(){
    window.location.href = './index.php';

});
$("table").DataTable({order: [0, 'ASC']});
</script>


