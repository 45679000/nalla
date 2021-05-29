<?php

    echo '
    <div style="height:10% !important;" class="col-md-12">
    <form id="blend_save" class="card" style="height:10% !important;">
        <div class="card-header">
            <h3 class="card-title">BLEND MASTER</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="form-label">Blend No</label>
                        <input type="text" id="blend_no" class="form-control"  placeholder="" >
                    </div>
                </div>
                <div class="col-md-5">
                <div class="form-group">
                    <label class="form-label">Client Name</label>
                    <select id="client_name" class="form-control custom-select">
                        <option value="CEMM TRADERS LTD">CEMM TRADERS LTD</option>
                        <option value="BAHARI TEAWAREHOUSE LTD">BAHARI TEAWAREHOUSE LTD</option>
                        <option value="BASU TEEHANDELSGES.mbH i. Gr">BASU TEEHANDELSGES.mbH i. Gr</option>
                        <option value="BLUE OCEAN TEA CO. LTD">BLUE OCEAN TEA CO. LTD</option>
                    </select>
                </div>
            </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Std Name</label>
                        <input id="std_name" type="text" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Grade</label>
                        <input type="text" id="grade" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="col-sm-6 col-md-6">
                    <div class="form-group">
                        <label class="form-label">Pkgs</label>
                        <input id="pkgs" type="text" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">NW(PS)</label>
                        <input id="net_weight" type="text" class="form-control" placeholder="" >
                    </div>
                </div>
                <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <label class="form-label">Kilos</label>
                        <input type="text" id="kilos" class="form-control" placeholder="" >
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="form-group">
                        <label class="form-label">Blend By Date</label>
                        <input type="text" id="blend_by_date" class="form-control" fc-datepicker" placeholder="MM/DD/YYYY" type="text">
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                
                <div class="form-group">
                    <label class="form-label">Dispatch Date</label>
                    <input id="dispatch_date" class="form-control fc-datepicker" placeholder="MM/DD/YYYY" type="text">
                </div>
            </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label class="form-label">Auction Week</label>
                        <select id="sale_no" class="form-control custom-select">
                            <option value="0">--Select--</option>
                            <option value="2021-15">2021-15</option>
                            <option value="2021-16">2021-16</option>
                            <option value="2021-17">2021-17</option>
                            <option value="2021-18">2021-17</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group mb-0">
                        <label class="form-label">Comments</label>
                        <textarea rows="5" class="form-control" placeholder="Enter About your description" ></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button id="blend_save" class="btn btn-success">Save</button>
        </div>
    </form>
         ';
echo '<table id="scart" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th class="wd-15p">Lots No</th>
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
                    <th class="wd-25p">Actions</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>';

?>
<script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/plugins/sweet-alert/sweetalert.min.js"></script>


<script>
     $('#blend_save').show();
     $('#scart').show();

    $('#tab2').click(function(e) {
        swal('', 'This is a Blended Shipment', 'success');
        $.ajax({   
        type: "POST",
        data : {action:"load-unallocated"},
        cache: true,  
        url: "../../ajax/process_shipping.php",   
        success: function(data){
            if(data !=null && data !='undefined'){
                console.log(data);
                populateDataTable(data);
            }
        }   
    }); 
    });
    $('#blend_save').submit(function(e){
    e.preventDefault();

        var formData = {
            blend_no: $("#blend_no").val(),
            client_name: $("#client_name").val(),
            std_name: $("#std_name").val(),
            grade: $("#grade").val(),
            pkgs: $("#pkgs").val(),
            net_weight: $("#net_weight").val(),
            kilos: $("#kilos").val(),
            blend_by_date: $("#blend_by_date").val(),
            dispatch_date: $("#dispatch_date").val(),
            sale_no:$("#sale_no").val(),
            action:'blend'

        };
        $("<input />").attr("type", "hidden")
          .attr("name", "action")
          .attr("value", "blend")
          .appendTo("#blend_save");
        $.ajax({   
        type: "POST",
        data : formData,
        cache: true,  
        url: "../../ajax/process_shipping.php",   
        success: function(data){
            swal('', 'Saved', 'success');
            $('#blend_save').hide();
            $('#scart').show();


        }   
    });
    })
    function populateDataTable(data) {
    console.log("populating data table...");
    // clear the table before populating it with more data
    $("#scart").DataTable().clear();

    var length = Object.keys(data).length;
    for(var i = 1; i < length+1; i++) {
      var stock;
      stock = data[i];
      var action;
        if(stock.allocated==1){
            action = '<button id="'+data[i].closing_cat_import_id+'" onclick="unAllocateLot(this.id)" class="btn btn-danger action"><i class="fa fa-close action-icon"></i> Remove</button>';
        }else{
            action = '<button id="'+data[i].closing_cat_import_id+'" onclick="allocateLot(this.id)" class="btn btn-success action"><i class="fa fa-plus action-icon"></i> Add</button>'
        }
      // You could also use an ajax property on the data table initialization
     var table =  $('#scart').dataTable().fnAddData( [
        stock.lot,
        stock.ware_hse,
        stock.company,
        stock.mark,
        stock.grade,
        stock.invoice,
        '<input id="'+stock.closing_cat_import_id+'" onclick="splitLot(this.id)" class="packages" value="'+stock.pkgs+'"></input>',
        stock.type,
        stock.net,
        stock.gross,
        stock.kgs,
        stock.value,
        stock.comment,
        stock.standard,
        action

      ]);
    }
  }
    
</script>