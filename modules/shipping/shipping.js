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

function loadContracts(){
    $.ajax({
        url: "shipping_action.php",
        type: "POST",
        dataType: "html",
        data: {
            action: "si-template"
        },
        success: function(response) {
            $("#contract").html(response);
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
function contractChange(){
    $('#contract').change(function(){
        var id = $('#contract').val();
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
function viewSis(){
    $.ajax({
        url: "shipping_action.php",
        type: "POST",
        dataType: "html",
        data: {
            action: "load-sis",
        },
        success: function(data) {
            $("#sis").html(data);
            $("#contracts").DataTable({
                "scrollY": 400,
                "paging": false,
                    "bInfo": false,
                    "oLanguage": {
                        "sSearch": ""
                    }
            });

        }

    });
}

function addSi(){
    $('#si_form').submit(function(e){
        e.preventDefault();
        $("<input/>").attr("type", "hidden")
              .attr("name", "action")
              .attr("value", "add-si")
              .appendTo("#si_form");
        $.ajax({   
            type: "POST",
            data : $(this).serialize(),
            dataType: "json", 
            url: "shipping_action.php",   
            success: function(data){
                localStorage.setItem("siId", data.id);
                localStorage.setItem("siType", data.shipment_type);
                var sino = data.id;
                var siType = data.shipment_type;
                $.ajax({   
                    type: "POST",
                    data : {action:"generate", siId:data.id},
                    dataType: "html", 
                    success: function(data){
                        swal('Success');
                        window.location.href="index.php?view=shipment-teas&sino="+sino+"&type="+siType;
                        // $('#nextid').show();
                        // $("#next").attr("href", "index.php?view=shipment-teas&sino="+sino+"&type="+siType);
                    }  
                });   

              


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
    if(siType == "Blend Shippment"){
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
                    $("#direct_lot").DataTable({});
                    $("#straight").hide();
                    $("#blend").show();

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
                    $("#blend").hide();
                    $("#straight").show();
                    $('#straightTable').html(data);
                    $("#direct_lot").DataTable({});

                }   
            }); 

        });
    }
}
function refreshLots(section){
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
function refreshStraightLots(){
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
        refreshLots("straightTable");
        viewStraightSelectionSummary();
        viewBlendSelectionSummary();
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
            refreshLots("straightTable");
            viewStraightSelectionSummary();
            viewBlendSelectionSummary();
        },
        error: function (data) {
        
        },
    });

}
function viewStraightSelectionSummary(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "shipping_action.php",
        data: {action:"shippment-summary", type:"straight"},
    success: function (data) {
        $('#StotalLots').text(data.totalLots);
        $('#StotalPackages').text(data.totalkgs);
        $('#StotalKilos').text(data.totalpkgs);
        $('#StotalValue').text(data.totalAmount);
        $('#client').text(data.name);

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
function viewBlendSelectionSummary(){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "shipping_action.php",
        data: {action:"shippment-summary", type:"blend"},
    success: function (data) {
        $('#BtotalLots').text(data.totalLots);
        $('#BtotalPackages').text(data.totalkgs);
        $('#BtotalKilos').text(data.totalpkgs);
        $('#BtotalValue').text(data.totalAmount);
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
                type:type
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
        viewBlendSelectionSummary();
        console.log(data);
    },
    error: function (data) {

    },
});
}
function deAllocateBlend(id, pkgs){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "shipping_action.php",
        data: {action:"allocate-blend", id:id, pkgs:pkgs},
    success: function (data) {
        refreshBlendLots();
        viewBlendSelectionSummary();
        console.log(data);
    },
    error: function (data) {

    },
});
}
function deAllocateBlend(id, pkgs){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "shipping_action.php",
        data: {action:"unallocate", id:id},
        success: function (data) {
            refreshLots("straightTable");
            viewBlendSelectionSummary();
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

function PackingMaterial(){
    $.ajax({
        type: "POST",
        dataType: "html",
        url: "shipping_action.php",
        data: {action:"load-packing-materials"},
    success: function (data) {
        $('#packingMaterial').html(data);
        $("#packingMaterials").DataTable({});
    },
    error: function (data) {

    },
});
}

function allocateMaterial(id){
  
    
    alert(qty);
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "shipping_action.php",
        data: {action:"allocate-material", id:id, allocated:$('.a'+id).val()},
    success: function (data) {
        refreshBlendLots();
        viewBlendSelectionSummary();
        console.log(data);
    },
    error: function (data) {

    },
});


}
function loadAllocationSummaryForBlends(){
    $.ajax({   
        type: "POST",
        dataType:"html",
        data : {
                action:"load_blend_summary"
        },
        cache: true,  
        url: "shipping_action.php",   
            success: function(data){
                $('#blend_lots').html(data);
                $("#shippmentTeasSummary").DataTable({
                });
            }   
        }); 
}
function completeShippment(sino, notification){
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "shipping_action.php",
        data: {action:"send-to-warehouse", notification:notification, sino:sino},
    success: function (data) {
    },
    error: function (data) {

    },
});
}
function loadSelectionBlendList(){
    $.ajax({
        type: "POST",
        dataType: "html",
        url: "shipping_action.php",
        data: {action:"blendlist"},
    success: function (data) {
        $('#blendlist').html(data);
    },
    error: function (data) {

    },
});
}
function loadSelectionLotList(){
    $.ajax({
        type: "POST",
        dataType: "html",
        url: "shipping_action.php",
        data: {action:"contractnoList"},
    success: function (data) {
        $('#contactno').html(data);
    },
    error: function (data) {

    },
});
}
function loadClients(){
    $.ajax({
        type: "POST",
        dataType: "html",
        url: "shipping_action.php",
        data: {action:"clients"},
    success: function (data) {
        $('#buyerid').html(data);
    },
    error: function (data) {

    },
});
}




