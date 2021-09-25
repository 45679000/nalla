function loadUnclosedBlends() {
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "show-unclosed"
        },
        cache: true,
        url: "../modules/blending/blend_action.php",
        success: function (data) {
            $('#tableData').html(data);

        }
    });
}
function dashboardSummaryTotals(){
    $.ajax({
        type: "POST",
        dataType: "json",
        data: {
            action: "dashboard-summary-totals"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
            if(data.awaitingShipment==null){ $('#awaitingShipment').html("0 KGS");}else{$('#awaitingShipment').html(data.awaitingShipment);}
            if(data.shippedKgs==null){ $('#shipped').html("0 KGS");}else{$('#shipped').html(data.shippedKgs);}
            if(data.kgsInstock==null){ $('#availableStock').html("0 KGS");}else{$('#availableStock').html(data.kgsInstock);}
            if(data.unclosedBlends==null){ $('#unclosedBlend').html("0 KGS");}else{$('#unclosedBlend').html(data.unclosedBlends);}

        }
    });
}
function shipmentStatus(){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "shipments"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#shippmentStatus').html(data);
         $("#dashboard").DataTable({});

        }
    });
}
function updateStatus(element){
    var sino = $(element).attr("id");
    console.log(sino);
    localStorage.setItem("si_no", sino);
    
}
function loadWarehouses(){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "load-warehouses"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#warehouseTable').html(data);

        }
    });
}
function loadPackingMaterials(){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "load-packing-materials"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#packingMaterial').html(data);
         $("#packing-materials").DataTable({});

        }

    });
}

function shippment(){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "shipment"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#shippments').html(data);
         $("#shippment").DataTable({})

        }
    });
}
function loadOneShipment(sino){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "shipment",
            sino:sino
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#shippments').html(data);

        }
    });
}
function loadSiAllocation(sino){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "load-si-allocation",
            sino:sino
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#thisAllocation').html(data);
         $('#alloct').DataTable({});
        }
    });
}

function loadPackingMaterialsToAlloacate(){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "load-packing-materials-to-allocate"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#stock').html(data);

        }
    });
}
function showPackingMaterialAlloacated(){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "allocated-materials"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#materialAllocation').html(data);
         $('#alloctions').DataTable({});

        }
    });
}
