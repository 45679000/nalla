<style>
    .edit{
        background-color: aliceblue;
        outline: 1px solid black;
        box-shadow:  3px 3px 5px 6px #ccc;
    }
    .updated{
        border-bottom: 1px solid greenyellow;
    }

</style>

<div class="col-md-8 col-lg-10">
    <div class="card">

        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body text-center">
                        <form method="post">
                            <div class="row justify-content-center">
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <label class="control-label">AUCTION</label>
                                        <select id="saleno" name="saleno" class="form-control"><small>(required)</small>
                                            <option disabled="" value="..." selected="">select</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <label class="control-label">BROKER</label>
                                        <select id="broker" name="broker" class="form-control well"><small>(required)</small>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <label class="control-label">CATEGORY</label>
                                        <select id="category" name="category" class="form-control well"><small>(required)</small>
                                            <option value="All" selected="All">All</option>
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
                <table id="closingimport" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="wd-15p">Lot No</th>
                            <th class="wd-15p">Ware Hse.</th>
                            <th class="wd-15p">Mark</th>
                            <th class="wd-10p">Grade</th>
                            <th class="wd-25p">Invoice</th>
                            <th class="wd-25p">Pkgs</th>
                            <th class="wd-25p">Kgs</th>
                            <th class="wd-25p">Net</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($stocks as $import) {
                            $id = $import["stock_id"];
                            $lot = $import["lot"];
                            $ware_hse = $import["ware_hse"];
                            $mark = $import["mark"];
                            $grade = $import["grade"];
                            $invoice = $import["invoice"];
                            $pkgs = $import["pkgs"];
                            $kgs = $import["kgs"];
                            $net = $import["net"];
                        }
                        ?>
                        <td><div><?=$lot?></div></td>
                        <td><div><?=$ware_hse?></div></td>
                        <td><div><?=$mark?></div></td>
                        <td><div><?=$grade?></div></td>
                        <td><div><?=$invoice?></div></td>
                        <td><div name="pkgs" contenteditable="true" id="<?=$id?>" onblur = "updateValue(this);" onclick = "editColumn(this);" ><?=$pkgs?></div></td>
                        <td><div id="<?="K".$id?>" contenteditable="true" class="edit"><?=$kgs?></div></td>
                        <td><div id="<?="T".$id?>" class="edit"><?=$net*$pkgs?></div></td>
                    </tbody>
                </table>
            </div>
        </div>

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

<!-- Custom Js-->
<script src="../assets/js/custom.js"></script>
<script src="../assets/js/common.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>



<script>
   
    function editColumn(element){
        $(element).addClass("edit");  
          
    }
    function updateValue(element){
        $(element).removeClass("edit");
        $(element).addClass("updated");
        var id= element.id;
        var value= $(element).text();
        var column=$(element).attr('name');
        var pkgs = $("#T"+id).text();
        var net = $("#K"+id).text();
        $("#K"+id).text(pkgs*value);


        $.ajax({
        url: "../ajax/common.php",
        type: "POST",
        dataType: "json",
        data: {
            action: "update",
            tableName:"closing_stock",
            value:value,
            id:id,
            columnName:column
        },
        success: function(data) {
            $("#buyer_standard").html(data);

        }, 
    });

        
}
</script>


