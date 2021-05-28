 <script>
$(document).ready(function(){
  $('td').prop('contentEditable', true);

  

  $("#direct_lot").DataTable();
    var formData = {
        action:"load-unallocated"
    };

  $.ajax({   
        type: "POST",
        data : formData,
        cache: true,  
        url: "../../ajax/process_shipping.php",   
        success: function(data){
            if(data !=null && data !='undefined'){
                console.log(data);
                populateDataTable(data);
            }
        }   
    }); 
        $.ajax({   
                type: "POST",
                data : {action:"load-unallocated"},
                cache: true,  
                url: "../../ajax/process_shipping.php",   
                success: function(data){
                    var length = Object.keys(data).length;
                    for(var i = 1; i < length+1; i++) {
                        var stock = data[i];
                        $("#shippment_teas").find('tbody')
                        .append($('<tr>')
                            .append($('<td>')
                                .text(stock.lot)
                            )
                            .append($('<td>')
                                .text(stock.ware_hse)
                            )
                            .append($('<td>')
                                .text(stock.company)
                            )
                            .append($('<td>')
                                .text(stock.mark)
                            )
                            .append($('<td>')
                                .text(stock.grade)
                            )
                            .append($('<td>')
                                .text(stock.invoice)
                            )
                            .append($('<td>')
                                .text(stock.pkgs)
                            )
                            .append($('<td>')
                                .text(stock.type)
                            )
                            .append($('<td>')
                                .text(stock.net)
                            )
                            .append($('<td>')
                                .text(stock.gross)
                            )
                            .append($('<td>')
                                .text(stock.kgs)
                            )
                            .append($('<td>')
                                .text(stock.value)
                            )
                            .append($('<td>')
                                .text(stock.comment)
                            )      
                            .append($('<td>')
                                .text(stock.standard)
                            )
        
                        ); 
                    }
                }   
    }); 
    // var shippment = $("#shippment_teas").DataTable();
    // $(".dataTables_empty").empty();
    function populateDataTable(data) {
    console.log("populating data table...");
    // clear the table before populating it with more data
    $("#direct_lot").DataTable().clear();

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
     var table =  $('#direct_lot').dataTable().fnAddData( [
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
  
});   
</script>
<script>
function unAllocateLot(id) {
    $.ajax({   
        type: "POST",
        data : {action:"unallocate", id:id},
        cache: true,  
        url: "../../ajax/process_shipping.php",   
        success: function(data){
            alert("lot unallocated");
            $.ajax({   
            type: "POST",
            data : {action:"load-unallocated"},
            cache: true,  
            url: "../../ajax/process_shipping.php",   
            success: function(data){
                if(data !=null && data !='undefined'){
                    console.log(data);
                }
            }   
    }); 
        }   
    }); 
    
}
function allocateLot(id) {
    $.ajax({   
        type: "POST",
        data : {action:"allocate", id:id},
        cache: true,  
        url: "../../ajax/process_shipping.php",   
        success: function(data){
            alert("lot added");
            $.ajax({   
            type: "POST",
            data : {action:"load-unallocated"},
            cache: true,  
            url: "../../ajax/process_shipping.php",   
            success: function(data){
                if(data !=null && data !='undefined'){
                    console.log(data);
                }
            }   
    }); 
        }   
    }); 
    
}
function splitLot(id) {
    alert("Are you sure you want to split this lot?");
    
}



</script>