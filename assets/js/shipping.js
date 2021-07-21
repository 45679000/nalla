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

function allocationSummary(siNo, clientId) {
    $.ajax({
        type: "POST",
        dataType: "html",
        url: "shipping_action.php",
        data: { action: "shippment-summary", siNo:siNo, clientId: clientId },
        success: function (data) {
            $('#summary').html(data);
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
            allocationSummary(allocationid, blendno);
            if(method=="allocate"){
                $('#'+allocationid).removeClass('allocate');
                $('#'+allocationid).addClass('deallocate');
                $('#'+allocationid).html('<i class="fa fa-minus"></i>');

            }else{
                $('#'+allocationid).removeClass('deallocate');
                $('#'+allocationid).addClass('allocate');
                $('#'+allocationid).html('<i class="fa fa-plus"></i>');



            }
        }
    });
}
function removeLotFromShippment(action, shipmentid, method, siNo, ){
    $.ajax({
        type: "POST",
        data: {
            action: action,
            id: shipmentid

        },
        cache: true,
        url: "shipping_action.php",
        success: function (data) {
            allocationSummary(siNo);
            if(method=="deallocate"){
                $('#'+shipmentid).removeClass('deallocate');
                $('#'+shipmentid).addClass('allocate');
                $('#'+shipmentid).html('<i class="fa fa-plus"></i>');
                $('#'+shipmentid+'allocation').text("");

            }
        }
    });
}

function AllocationShippment(allocationid, action, packages, siNo, method){
    $.ajax({
        type: "POST",
        data: {
            action: action,
            allocationid: allocationid,
            packages: packages,            
            siNo: siNo

        },
        cache: true,
        url: "shipping_action.php",
        success: function (data) {
            allocationSummary(siNo);
            if(method=="allocate"){
                $('#'+allocationid).removeClass('allocate');
                $('#'+allocationid).addClass('deallocate');
                $('#'+allocationid).html('<i class="fa fa-minus"></i>');
                $('#'+allocationid+'allocation').text(siNo);
            }else{
                $('#'+allocationid).removeClass('deallocate');
                $('#'+allocationidd).addClass('allocate');
                $('#'+allocationid).html('<i class="fa fa-plus"></i>');



            }

        }
    });
}
function addApproval(element){
    $.ajax({
        type: "POST",
        data: {
            action: "add-workfow",
            id: localStorage.getItem("blend_no_contract_no"),
            approve_person: '1',
            details: 'Request to approve lot details for shippment',
        },
        cache: true,
        url: "shipping_action.php",
        success: function (data) {
            allocationSummary(localStorage.getItem("blend_no_contract_no", localStorage.getItem("clientId"))); 
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
function updateMrp(element){
    var id = $(element).attr("id");
    var mrp = $(element).val();
    $.ajax({
        url: "shipping_action.php",
        type: "POST",
        dataType: "html",
        data: {
            action: "update-mrp",
            id:id,
            mrp:mrp
        },
        success: function(response) {
            $("#grade").html(response);
        }

    });
    alert()
}


