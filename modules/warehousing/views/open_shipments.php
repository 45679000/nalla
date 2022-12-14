<?php
$path_to_root = "../../";
// require_once $path_to_root . 'templates/header.php';
?>
<style>
    .modal {
        text-align: center;
    }

    @media screen and (min-width: 768px) {
        .modal:before {
            display: inline-block;
            vertical-align: middle;
            content: " ";
            height: 100%;
        }
    }

    .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
    }
    .open-shipment {
        cursor: pointer;
    }
    .container-fluid .card-header{
        font-size: 1.5rem;
        font-weight: bold;

    }
    .loader {
        position: absolute;
        top: 80px;
        right: 45%;
        z-index: 1;
        display: none;
        border: 16px solid #f3f3f3; /* Light grey */
        border-top: 16px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<body class="container-fluid">
    <div id="global-loader"></div>
    <div class="page">
        <div class="page-main">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-light">Shippments</h3>
                </div>
                <div class="card-header te">Shipped Teas</div>
                <div class="card-body p-6 loaderParent">
                    <div class="rows">
                        <button id="straighLine" class="btn btn-success">Straight Teas</button>
                        <button id="blendTeas" class="btn btn-primary">Blend Teas</button>
                    </div>
                    
                    <div class="loader"></div>
                    <div class="panel panel-primary">
                        <div class="panel-body tabs-menu-body">
                            <div class="tab-content">
                                <div class="tab-pane active " id="tab1">
                                    <div id="shippments" class="table-responsive">
                                    </div>
                                    <div style="display:none" class="card" id="allocations">
                                        <div class="card-header bg-teal">
                                            <button id="addMaterial" class="btn btn-success btn-sm pl-20">Add Material Used In 
                                                 <span id="si_no" class="pl-20"></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="thisAllocation" class="table-responsive"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog col-12" role="document">
            <div class="modal-content">
                <div class="" id="teasForShippment"></div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>


    <script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
    <script src="../../assets/js/vendors/circle-progress.min.js"></script>
    <!-- Custom Js-->
    <script src="../../assets/js/custom.js"></script>
    <script src="../../assets/js/warehousing.js"></script>

    <script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
    <script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
    <script src="../../assets/js/sweet_alert2.js"></script>

    <script>
        let blendBtn = document.getElementById('blendTeas')
        let straightBtn = document.getElementById('straighLine')
        blendBtn.addEventListener('click',(e)=>{
            e.preventDefault()
            blendBtn.className = 'btn btn-success'
            straightBtn.className = 'btn btn-primary'
            shippedBlendTeas()
        })
        straightBtn.addEventListener('click',(e)=>{
            e.preventDefault()
            blendBtn.className = 'btn btn-primary'
            straightBtn.className = 'btn btn-success'
            shippedStraightTeas()
        })
        shippedStraightTeas();   
        function shippedStraightTeas() {
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {
                    action: "shipped-teas",
                    type: 'Straight Line'
                },
                cache: true,
                url: "warehousing_action.php",
                success: function (data) {
                    $('#shippments').html(data)
                    document.getElementById('teaType').innerText = 'Straight Line'
                    $("#ShippedTeas").DataTable({})
                }
            })
        }
        // open blend shippments
        function shippedBlendTeas() {
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {
                    action: "shipped-teas",
                    type: 'Blend Shippment'
                },
                cache: true,
                url: "warehousing_action.php",
                success: function (data) {
                    $('#shippments').html(data)
                    document.getElementById('teaType').innerText = 'Blend Shippment'
                    $("#ShippedTeas").DataTable({})
                }
            })
        }
        $("body").on("click", ".viewTeas", function(e) {
            var contractNo = $(this).attr("id");
            console.log(contractNo)
            var type = document.getElementById('teaType').innerText
            viewTeas(contractNo, type)
        });
        $("body").on("click", ".reverseshippment", function(e) {
            var instructionId = $(this).attr("id");
            var type = document.getElementById('teaType').innerText
            // console.log(contractNo);
            if(instructionId.length > 1){
                let text = `You are about to change shippment status of contract Number ${instructionId}`;
                if (confirm(text) == true) {
                    changeShippmentStatus(instructionId,type)
                }
            } 
            else {
                alert('This shippment has no Contract number');
            }
        });
        function changeShippmentStatus(instructionId, type){
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {
                    action: "reverse-shippment",
                    instructionId: instructionId,
                    type: type 
                },
                url: "warehousing_action.php",
                success: function (data) {
                    console.log(data);
                    if(data = 'success'){
                        Swal.fire(
                            'Shippment status changed',
                            'Go to stock to confirm changes',
                            'success'
                        )
                    }
                    else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed',
                            text: 'Try again',
                            footer: '<p>If this persists contact the technical team</p>'
                        })
                    }
                }
            })
        }
        function viewTeas(contractNo, type) {
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {
                    action: "view-teas",
                    contractNo: contractNo,
                    type: type 
                },
                url: "warehousing_action.php",
                success: function (data) {
                    console.log(data);
                    $('#teasForShippment').html(data)
                    $("#viewShippedTeas").DataTable({})
                    // alert(`Tea of Lot No. ${stockId} shipped status changed to not shipped`)
                    // shippedStraightTeas()
                    // document.querySelector('.loaderParent').style.opacity = 1
                }
            })
        }
    </script>

    </html>