<?php
if($type=='Blend Shippment'){
    $output ="";
    $blendList = $shippingCtrl->loadActiveBlend();
    if (sizeOf($blendList)> 0) {
            $output .='
        <table id="shippmentTeasBlend" class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th class="wd-15p">Blend No</th>
                <th class="wd-15p">Si Id</th>
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
                $output.='<td>'.$blend["si_no"].'</td>';
                $output.='<td>'.$blend["std_name"].'</td>';
                $output.='<td>'.$blend["Grade"].'</td>';
                $output.='<td>'.$blend["client_name"].'</td>';
                $output.='<td>'.$blend["nw"].'</td>';
                $output.='<td>'.$blend["output_pkgs"].'</td>';
                $output.='<td>'.$blend["output_pkgs"].'</td>'; 
                $output.='<td><a id="list" href="#">List</a></td>';
                if($blend["si_no"]!=null){
                    $output.='<td><button id="'.$si.'">SI attached</button></td>'; 
                }else{
                    $output.='<td><button id="'.$si.'">Attach SI</button></td>'; 
                } 
     
            $output.='</tr>';

            $output.='</tbody>
        </table>';
        }
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
        var sino = '<?php echo $si; ?>';

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
                location.reload(); 
            }   
        });   
  }
});
$('#next').click(function(){
    window.location.href = './index.php?view=documents';

});
$('#previous').click(function(){
    window.location.href = './index.php';

})
</script>


