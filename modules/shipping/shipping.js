function siTemplate() {
    $.ajax({
        url: "shipping_action.php",
        type: "POST",
        dataType: "html",
        data: {
            action: "si-template"
        },
        success: function(response) {
            $("#si-templates").html(response);
        }

    });

}
function editData(){
    $('#si-templates').change(function(){
        var id = $('#si-templates').val();
        $.ajax({
            url: "shipping_action.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "edit-si",
                id: id
            },
            success: function(data) {
                for (const [key, value] of Object.entries(data[0])) {
                    $('#'+key).val(value);
                }

               
            }
    
        });
    });
}
function addSi(){
    $('#si_form').submit(function(e){
        e.preventDefault();
        $("<input />").attr("type", "hidden")
              .attr("name", "action")
              .attr("value", "add-si")
              .appendTo("#si_form");
        $.ajax({   
            type: "POST",
            data : $(this).serialize(),
            cache: false,  
            url: "shipping_action.php",   
            success: function(data){
                swal('Success',data.message, 'success');
            }   
        });   
        return false;   
    });
}
function addBlend(){
    $('#blendIt').click(function(e){
        e.preventDefault();
        var formData = {
            blend_no:$('#blend_no').val(),
            date_:$('#date_').val(),
            client_name:$('#client_name').val(),
            std_name:$('#std_name').val(),
            blend_no:$('#blend_no').val(),
            grade:$('#grade').val(),
            blend_no:$('#blend_no').val(),
            nw:$('#nw').val(),
            output_pkgs:$('#output_pkgs').val(),
            sale_no:$('#sale_no').val(),
            output_kgs:$('#output_kgs').val(),
            comments:$('#comments').val(),
            action:"add-blend"

        };
        $.ajax({   
            type: "POST",
            data : formData,
            cache: false,  
            url: "shipping_action.php",   
            success: function(data){
                swal('Success',data.message, 'success');
            }   
        });   
        return false;   
    });
}

function switchView(siType){
    if(siType == "blend"){
        $('#tab2').click(function(e) {
            $.ajax({   
            type: "POST",
            dataType:"html",
            data : {
                    action:"load-unallocated",
                    type:"blend"
            },
            cache: true,  
            url: "shipping_action.php",   
                success: function(data){
                    $('#blendTable').html(data);
                    $("#direct_lot").DataTable({
                    });
                }   
            }); 

        });
    }else{
        $('#tab2').click(function(e) {
            $.ajax({   
            type: "POST",
            data : {
                action:"load-unallocated",
                type:"straight"
            },
            cache: true,  
            url: "shipping_action.php",   
                success: function(data){
                    if(data !=null && data !='undefined'){
                        console.log(data);
                        populateDataTable(data);
                    }
                }   
            }); 

        });
    }
}
function refreshLots(){
    $.ajax({   
        type: "POST",
        dataType:"html",
        data : {
                action:"load-unallocated",
                type:"blend"
        },
        cache: true,  
        url: "shipping_action.php",   
            success: function(data){
                $('#blendTable').html(data);
                $("#direct_lot").DataTable({
                });
            }   
        }); 
}
function refreshBlendLots(){
    $.ajax({   
        type: "POST",
        dataType:"html",
        data : {
                action:"load-unallocated",
                type:"blend"
        },
        cache: true,  
        url: "shipping_action.php",   
            success: function(data){
                $('#blendTable').html(data);
                $("#direct_lot").DataTable({
                });
            }   
        }); 
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

function allocateForShippment(id){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "shipping_action.php",
        data: {action:"allocate", id:id},
    success: function (data) {
        refreshLots();
        viewSelectionSummary();
        console.log(data);
    },
    error: function (data) {

    },
});
}

function deAllocateForShippment(id){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "shipping_action.php",
        data: {action:"unallocate", id:id},
        success: function (data) {
            refreshLots();
            viewSelectionSummary();
        },
        error: function (data) {
        
        },
    });

}
function viewSelectionSummary(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "shipping_action.php",
        data: {action:"shippment-summary"},
    success: function (data) {
        $('#totalLots').text(data.totalLots);
        $('#totalPackages').text(data.totalkgs);
        $('#totalKilos').text(data.totalpkgs);
        $('#totalValue').text(data.totalAmount);
        $('.counter-value').each(function(){
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            },{
                duration: 20,
                easing: 'swing',
                step: function (now){
                    $(this).text(Math.ceil(now));
                }
            });
        });
    },
    error: function (data) {
       
    },
});
}

function shipmentTeas(type){
    $.ajax({   
        type: "POST",
        dataType:"html",
        data : {
                action:"shipment-teas",
                type:"blend"
        },
        cache: true,  
        url: "shipping_action.php",   
            success: function(data){
                $('#shippment_teas').html(data);
                $("#shippmentTeas").DataTable({
                });
            }   
        }); 
}

function splitLot(id) {
    swal("Do you wish to continue spliting the lot?");
    $('.packages').keypress(function (e) {
        if (e.which == 13) {
          id = $(this).attr("id");
          var pkgs = $(this).val();
          allocateBlend(id, pkgs)
          return false;    //<---- Add this line
        }
      });
}

function allocateBlend(id, pkgs){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "shipping_action.php",
        data: {action:"allocate-blend", id:id, pkgs:pkgs},
    success: function (data) {
        refreshBlendLots();
        viewSelectionSummary();
        console.log(data);
    },
    error: function (data) {

    },
});
}
function gradeList(){
    $.ajax({
        url: "../../ajax/common.php",
        type: "POST",
        dataType: "html",
        data: {
            action: "grade-list"
        },
        success: function(response) {
            $("#grade").html(response);
        }

    });
}
