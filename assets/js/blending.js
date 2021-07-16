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
        url: "blend_action.php",
        success: function (data) {
            $('#blendTable').html(data);
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
function addLotToBlend(allocationid, action,  blendno, allocatedpackages, method){
    $.ajax({
        type: "POST",
        data: {
            action: action,
            allocationid: allocationid,
            blendno:blendno,
            allocatedpackages:allocatedpackages

        },
        cache: true,
        url: "blend_action.php",
        success: function (data) {
            showBlend(blendno);
            if(method=="allocate"){
                $('#'+allocationid).removeClass('allocate');
                $('#'+allocationid).addClass('deallocate');
                $('#'+allocationid).html('<i class="fa fa-minus"></i>');
                $('#'+allocationid+'allocation').text($('#'+blendno+'blend').text());
                
            }else{
                $('#'+allocationid).removeClass('deallocate');
                $('#'+allocationid).addClass('allocate');
                $('#'+allocationid).html('<i class="fa fa-plus"></i>');



            }
        }
    });
}
function removeLotFromBlend(allocationid, action,  blendno, allocatedpackages, method){
    $.ajax({
        type: "POST",
        data: {
            action: action,
            allocationid: allocationid,
            blendno:blendno,
            allocatedpackages:allocatedpackages

        },
        cache: true,
        url: "blend_action.php",
        success: function (data) {
            showBlend(blendno);
            if(method=="allocate"){
                $('#'+allocationid).removeClass('allocate');
                $('#'+allocationid).addClass('deallocate');
                $('#'+allocationid).html('<i class="fa fa-minus"></i>');

            }else{
                $('#'+allocationid).removeClass('deallocate');
                $('#'+allocationid).addClass('allocate');
                $('#'+allocationid).html('<i class="fa fa-plus"></i>');
                $('#'+allocationid+'allocation').text("");




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
function showBlend(blendno) {
    $.ajax({
        url: "blend_action.php",
        type: "POST",
        data: {
            action: "view",
            blendno: blendno
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
        url: "blend_action.php",
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
            $('#lotShow').html(data.blendNo);

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
function standardList(){
    $.ajax({
        url: "../../ajax/common.php",
        type: "POST",
        dataType: "html",
        data: {
            action: "standard-list"
        },
        success: function(data) {
            $("#standard").html(data);

        }

    });
    
}
function clientWithcodeList(){
    $.ajax({
        url: "../../ajax/common.php",
        type: "POST",
        dataType: "html",
        data: {
            action: "clients"
        },
        success: function(data) {
            $("#clientwithcode").html(data);

        }

    });
    
}
function gradeList() {
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

function currentAllocation(blendno){
    $.ajax({
        type: "POST",
        data: {
            action: "my-current-allocation",
            blendno:blendno

        },
        cache: true,
        url: "blend_action.php",
        success: function (data) {
            $("#blendTable").html(data);

        }
    });
}
function updateBlend(data){
    $('#standard').val(data.standard);
    $('#blendid').val(data.blendid);
    $('#clientwithcode').val(data.clientwithcode);
    $('#grade').val(data.grade);
    $('#pkgs').val(data.pkgs);
    $('#nw').val(data.nw);

}

