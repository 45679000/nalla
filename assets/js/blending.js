function clientOptions() {
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "load-clients"
        },
        cache: true,
        url: "shipping_action.php",
        success: function (data) {
            $('#client').html(data);

        }
    });
}
function standardOptions() {
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "load-standard"
        },
        cache: true,
        url: "shipping_action.php",
        success: function (data) {
            $('#standard').html(data);

        }
    });
}
function loadUnallocated() {
    $.ajax({
        type: "POST",
        data: {
            action: "load-unallocated",
            type: "straight"
        },
        cache: true,
        url: "shipping_action.php",
        success: function (data) {
            $('#straightTable').html(data);
            $("#direct_lot").DataTable({});

        }
    });
}
function showClientAllocation(clientid){
    $.ajax({
        type: "POST",
        data: {
            action: "client-allocation",
            id: clientid
        },
        cache: true,
        url: "shipping_action.php",
        success: function (data) {
            $('#straightTable').html(data);
            $("#direct_lot").DataTable({});

        }
    });
}

function allocationSummary(clientId) {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "shipping_action.php",
        data: { action: "shippment-summary", clientId: clientId },
        success: function (data) {
            console.log(data.clientName);
            $('#totalLots').html(data.totalLots);
            $('#totalkgs').html(data.totalkgs);
            $('#totalPkgs').html(data.totalpkgs);
            $('#totalValue').html(data.totalAmount);
            $('#totalNet').html(data.totalNet);
            $('#clientName').html(data.clientName);
            $('#lotView').html(data.lotDetailsView);
            $('#lotEdit').html(data.lotDetailsEdit);
            $('#lotStatus').html(data.approvalStatus);

            $('.counter-value').each(function () {
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 20,
                    easing: 'swing',
                    step: function (now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });
        },
        error: function (data) {


        },
    });
}
function AllocationShippment(id, action, type, clientId){
    $.ajax({
        type: "POST",
        data: {
            action: action,
            type: type,
            clientId: clientId,            
            id: id

        },
        cache: true,
        url: "shipping_action.php",
        success: function (data) {
            allocationSummary(clientId);
            if(action=="allocate"){
                $('#'+id).removeClass('allocate');
                $('#'+id).addClass('deallocate');
                $('#'+id).html('<i class="fa fa-minus"></i>');

            }else{
                $('#'+id).removeClass('deallocate');
                $('#'+id).addClass('allocate');
                $('#'+id).html('<i class="fa fa-plus"></i>');



            }
        }
    });
}
function AllocationShippmentBlend(id, action, type, blendno){
    $.ajax({
        type: "POST",
        data: {
            action: action,
            type: type,
            blendno: blendno,            
            id: id

        },
        cache: true,
        url: "shipping_action.php",
        success: function (data) {
            allocationSummary(blendno);
            if(action=="allocate"){
                $('#'+id).removeClass('allocate');
                $('#'+id).addClass('deallocate');
                $('#'+id).html('<i class="fa fa-minus"></i>');

            }else{
                $('#'+id).removeClass('deallocate');
                $('#'+id).addClass('allocate');
                $('#'+id).html('<i class="fa fa-plus"></i>');



            }

        }
    });
}
function addApproval(element){
    $.ajax({
        type: "POST",
        data: {
            action: "add-workfow",
            id: localStorage.getItem("clientId"),
            event: 'stock_allocation',
            approve_person: '1',
            details: 'Request to approve lot details for shippment',
            status: 'Confirmed'
        },
        cache: true,
        url: "shipping_action.php",
        success: function (data) {
            allocationSummary(clientId);
            alert('Confirmed');

        }
    });
}
function loadGrades(){
    $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "load-grades"
        },
        cache: true,
        url: "shipping_action.php",
        success: function (data) {
            $('#standard').html(data);

        }
    });
    
}
function showBlend() {
    $.ajax({
        url: "blend_action.php",
        type: "POST",
        data: {
            action: "view",
            blendno: "BTH21906 STD 8230/11-8"
        },
        success: function(response) {
            $("#tableData").html(response);
        }

    });
}
function BlendAllocationSummary(blendno) {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "shipping_action.php",
        data: { action: "blend-shippment-summary", blendno: blendno },
        success: function (data) {
            console.log(data.clientName);
            $('#totalLots').html(data.totalLots);
            $('#totalkgs').html(data.totalkgs);
            $('#totalPkgs').html(data.totalpkgs);
            $('#totalValue').html(data.totalAmount);
            $('#totalNet').html(data.totalNet);
            $('#clientName').html(data.clientName);
            $('#lotView').html(data.lotDetailsView);
            $('#lotEdit').html(data.lotDetailsEdit);
            $('#lotStatus').html(data.approvalStatus);

            $('.counter-value').each(function () {
                $(this).prop('Counter', 0).animate({
                    Counter: $(this).text()
                }, {
                    duration: 20,
                    easing: 'swing',
                    step: function (now) {
                        $(this).text(Math.ceil(now));
                    }
                });
            });
        },
        error: function (data) {


        },
    });
}



