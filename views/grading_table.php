<div class="col-md-8 col-lg-10">
                <div class="card">
                    <div class="card-body p-6">
                        <div class="col-md-12">
                            <div class="expanel expanel-secondary">
                                <?php
                                echo '<div class="expanel-heading">
                                                <h3 class="expanel-title">Filter Catalogue</h3>
                                            </div>
                                            <div class="expanel-body">
                                                <form method="post" class="filter">
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-3 well">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">AUCTION</label>
                                                                <select id="saleno" name="saleno" class="form-control" ><small>(required)</small>
                                                                    <option disabled="" value="..." selected="">select</option>
                                                                    ';
                                                                        loadAuction();
                                                                    echo '
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 well">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">BROKER</label>
                                                                <select id="broker" name="broker" class="form-control well" ><small>(required)</small>
                                                                    <option disabled="" value="..." selected="">select</option>
                                                                    <option value="ANGL"> ANGL </option>
                                                                    <option value="ATLC"> ATLC </option>
                                                                    <option value="BICL"> BICL </option>
                                                                    <option value="CENT"> CENT </option>
                                                                    <option value="CTBL"> CTBL </option>
                                                                    <option value="VENS"> VENS </option>
                                                                    <option value="UNTB"> UNTB </option>
                                                                    <option value="TBE"> TBE </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 well">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">CATEGORY</label>
                                                                <select id="category" name="category" class="form-control well" ><small>(required)</small>
                                                                    <option disabled="" value="..." selected="">select</option>
                                                                    <option value="Main">Main</option>
                                                                    <option value="Sec">Sec</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 well">
                                                            <button type="submit" class="btn btn-primary">View</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            
                                            </div>
                                            <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="closingimports" class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="wd-15p">Lot No</th>
                                                            <th class="wd-15p">Ware Hse.</th>
                                                            <th class="wd-20p">Company</th>
                                                            <th class="wd-15p">Mark</th>
                                                            <th class="wd-10p">Grade</th>
                                                            <th class="wd-25p">Invoice</th>
                                                            <th class="wd-25p">Pkgs</th>
                                                            <th class="wd-25p">Type</th>
                                                            <th class="wd-25p">Net</th>
                                                            <th class="wd-25p">Gross</th>
                                                            <th class="wd-25p">Kgs</th>
                                                            <th class="wd-25p">Value</th>
                                                            <th class="wd-25p">Comment</th>
                                                            <th class="wd-25p">Standard</th>
            
                                                        </tr>
                                                    </thead>
                                                    <tbody>';
                                                    $html ="";
                                                    foreach ($imports as $import){
                                                        $html.='<tr>';
                                                            $html.='<td>'.$import["lot"].'</td>';
                                                            $html.='<td>'.$import["ware_hse"].'</td>';
                                                            $html.='<td>'.$import["company"].'</td>';
                                                            $html.='<td>'.$import["mark"].'</td>';
                                                            $html.='<td>'.$import["grade"].'</td>';
                                                            $html.='<td>'.$import["invoice"].'</td>';
                                                            $html.='<td>'.$import["pkgs"].'</td>';
                                                            $html.='<td>'.$import["type"].'</td>';
                                                            $html.='<td>'.$import["net"].'</td>';
                                                            $html.='<td>'.$import["gross"].'</td>';
                                                            $html.='<td>'.$import["tare"].'</td>';
                                                            $html.='<td>'.$import["value"].'</td>';
                                                            $html.='<td>'.$import["comment"].'</td>';
                                                            $html.='<td>'.$import["standard"].'</td>';
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
<!-- forn-wizard js-->
<script src="../assets/plugins/forn-wizard/js/material-bootstrap-wizard.js"></script>
<script src="../assets/plugins/forn-wizard/js/jquery.validate.min.js"></script>
<script src="../assets/plugins/forn-wizard/js/jquery.bootstrap.js"></script>
<!-- file import -->
<script src="../assets/plugins/fileuploads/js/dropify.min.js"></script>
<!-- Custom scroll bar Js-->
<script src=../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- counter  -->
<script src="../assets/plugins/counters/counterup.min.js"></script>
<script src="../assets/plugins/counters/waypoints.min.js"></script>
<!-- Custom Js-->
<script src="../assets/js/custom.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>

<script>
    $(function(e) {
        $('#closingimports').DataTable();
    });
</script>

<script>
var SubmitData = new Object();
var Comment = [],
    Standard = [],
    table = $('#closingimports').DataTable({
        columnDefs: [{
            targets: [0],
            "className": "pk",
            visible: true
        }, {
            targets: [12],
            "className": "position"
        }, {
            targets: [13],
            "className": "location"
        }],
        initComplete: function() {
            Comment.push("EB1");
            Comment.push("EB1+");
            Comment.push("EB1*");

            Standard.push("2016");
            Standard.push("2017");
            Standard.push("2018");

        }
    });


$('#closingimports tbody').on('click', '.position', function() {
    if (!$('#closingimports').hasClass("editing")) {
        $('#closingimports').addClass("editing");
        var thisCell = table.cell(this);

        SubmitData.pkey = $(this).parents('tr').find("td:eq(0)").text();

        thisCell.data($("<select></select>", {
            "class": "changePosition"
        }).append(Comment.map(v => $("<option></option>", {
            "text": v,
            "value": v,
            "selected": (v === thisCell.data())
        }))).prop("outerHTML"));

        $('select').on('change', function() {
            SubmitData.fieldValue = this.value;
            SubmitData.fieldName = 'comment';
            postData(SubmitData, "");
            console.log(SubmitData);

        });
    }
});
$('#closingimports tbody').on('click', '.location', function() {
    if (!$('#closingimports').hasClass("editing")) {
        $('#closingimports').addClass("editing");
        var thisCell = table.cell(this);
        thisCell.data($("<select></select>", {
            "class": "changeLocation"
        }).append(Standard.map(v => $("<option></option>", {
            "text": v,
            "value": v,
            "selected": (v === thisCell.data())
        }))).prop("outerHTML"));
    }
    $('select').on('change', function() {
            SubmitData.pkey = $(this).parents('tr').find("td:eq(0)").text();
            SubmitData.fieldName = 'standard';
            SubmitData.fieldValue = this.value;
            postData(SubmitData, "");
            console.log(SubmitData);

    });

});
$('#closingimports tbody').on("change", ".changePosition", () => {
    table.cell($(".changePosition").parents('td')).data($(".changePosition").val());
    $('#closingimports').removeClass("editing");
});
$('#closingimports tbody').on("change", ".changeLocation", () => {
    table.cell($(".changeLocation").parents('td')).data($(".changeLocation").val());
    $('#closingimports').removeClass("editing");
});
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
<script>
    $(function(e) {
        $('#closingimports').DataTable();
    });
</script>