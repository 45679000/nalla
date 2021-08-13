<div class="col-md-8 col-lg-10">
                <div class="card">
                <?php 
                           $html= '
                           <div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-body text-center">
                                    <form method="post">
                                    <div class="row justify-content-center">
                                        <div class="col-md-3 well">
                                            <div class="form-group label-floating">
                                                <label class="control-label">AUCTION</label>
                                                <select id="saleno" name="saleno" class="select2 form-control" ><small>(required)</small>
                                                    <option disabled="" value="..." selected="">select</option>';
                                                        foreach(loadAuctionArray() as $auction_id){
                                                            $html.= '<option value="'.$auction_id.'">'.$auction_id.'</option>';
                                                        }
                                                   $html.= '
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 well">
                                            <div class="form-group label-floating">
                                                <label class="control-label">BROKER</label>
                                                <select id="broker" name="broker" class="select2 form-control well" ><small>(required)</small>
                                                   
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 well">
                                            <div class="form-group label-floating">
                                                <label class="control-label">CATEGORY</label>
                                                <select id="category" name="category" class="select2 form-control well" ><small>(required)</small>
                                                    <option disabled="" value="..." selected="">select</option>
                                                    <option value="Main">Main</option>
                                                    <option value="Sec">Sec</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3 well">
                                        <div class="form-group label-floating">

                                            <button type="submit" id="search" value="filter" name="filter" class="btn btn-success btn-sm">Search Catalogue</button>

                                        </div>
                                    </div>
                                    </div>
                                </form>
									</div>
								</div>
							</div>
						</div>
                                            <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="tasting" class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                           <th class="wd-25p">Select</th>
                                                            <th class="wd-15p">Lot No</th>
                                                            <th class="wd-15p">Mark</th>
                                                            <th class="wd-10p">Grade</th>
                                                            <th class="wd-25p">Invoice</th>
                                                            <th class="wd-25p">Pkgs</th>
                                                            <th class="wd-25p">Type</th>
                                                            <th class="wd-25p">Net</th>
                                                            <th class="wd-25p">Kgs</th>
                                                            <th class="wd-25p">Value</th>
                                                            <th class="wd-25p">Code</th>
                                                            <th class="wd-25p">Standard</th>
                                                            <th class="wd-25p">Bid</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>';
                                                 
                                                    foreach ($imports as $import){
                                                        $maxPrice = $import["max_bp"];
                                                        $lot = $import["lot"];

                                                        $html.='<tr>';
                                                            if($import["target"]==0){
                                                                $html.='<td><input type="checkbox" id="unallocated" name="allocated" value="0"></td>';
                                                            }else{
                                                                $html.='<td><input type="checkbox" id="allocated" name="allocated" value="1" checked></td>';
                                                            }
                                                            $html.='<td>'.$import["lot"].'</td>';
                                                            $html.='<td>'.$import["mark"].'</td>';
                                                            $html.='<td>'.$import["grade"].'</td>';
                                                            $html.='<td>'.$import["invoice"].'</td>';
                                                            $html.='<td>'.$import["pkgs"].'</td>';
                                                            $html.='<td>'.$import["type"].'</td>';
                                                            $html.='<td>'.$import["net"].'</td>';
                                                            $html.='<td>'.$import["kgs"].'</td>';
                                                            $html.='<td>'.$import["value"].'</td>';
                                                            $html.='<td>'.$import["comment"].'</td>';
                                                            $html.='<td>'.$import["standard"].'</td>';
                                                            $html.='<td><input
                                                                        id="'.$lot.'" 
                                                                        onBlur = addMaxPrice(this) 
                                                                        class="noedit"
                                                                        value="'.$maxPrice.'">
                                                                        </input>
                                                                     </td>';

                                                        $html.='</tr>';
                                                    }
                                            $html.= '</tbody>
                                                </table>
                                            </div>
                                        </div>';
                                        echo $html;
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Dashboard js -->
<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../assets/js/vendors/selectize.min.js"></script>
<script src="../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../assets/js/vendors/circle-progress.min.js"></script>
<script src="../assets/plugins/rating/jquery.rating-stars.js"></script>


<!-- Custom scroll bar Js-->
<script src=../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>


<!-- Custom Js-->
<script src="../assets/js/custom.js"></script>
<script id="url" data-name="../ajax/common.php" src="../assets/js/common.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>

<script src="../assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="../assets/js/sweet-alert.js"></script>
<script src="../assets/plugins/select2/select2.full.min.js"></script>



<script>
var SubmitData = new Object();
var Comment = [],
    Standard = [],
    table = $('#tasting').DataTable({
        columnDefs: [{
            targets: [1],
            "className": "pk",
            visible: true
        },
    ],
    
    });
$('#tasting tbody').on('click', '#unallocated', function() {
        var thisCell = table.cell(this);
        SubmitData.lot = $(this).parents('tr').find("td:eq(1)").text();
        SubmitData.check = 1;
        SubmitData.action = "add-target";

        console.log(SubmitData);
        postData(SubmitData, "../ajax/common.php");

});
$('#tasting tbody').on('click', '#allocated', function() {
        var id =  $(this).parents('tr').find("td:eq(1)").text();
        var thisCell = table.cell(this);
        SubmitData.lot = $(this).parents('tr').find("td:eq(1)").text();
        SubmitData.check = 0;
        SubmitData.action = "add-target";

        console.log(SubmitData);
        postData(SubmitData, "../ajax/common.php");
        $('#'+id).removeClass('noedit');

});

function addMaxPrice(element){
    lot =  $(element).attr('id');
    SubmitData.lot = lot;
    SubmitData.maxPrice = $(element).val();
    SubmitData.action = "add-price";
    postData(SubmitData, "../ajax/common.php");
}


function postData(formData, PostUrl) {
          $.ajax({
                type: "POST",
                dataType: "html",
                url: PostUrl,
                data: formData,
            success: function (data) {
                console.log('Submission was successful.');
                // location.reload();
                console.log(data);
                return data;
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });


}
</script>

