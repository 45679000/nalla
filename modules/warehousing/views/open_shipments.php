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
                <div class="card-header te">Lots marked shipped</div>
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
            openBlendShippments()
        })
        straightBtn.addEventListener('click',(e)=>{
            e.preventDefault()
            blendBtn.className = 'btn btn-primary'
            straightBtn.className = 'btn btn-success'
            openShippments()
        })
        openShippments();   
        function openShippments() {
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {
                    action: "open-shippments"
                },
                cache: true,
                url: "warehousing_action.php",
                success: function (data) {
                    $('#shippments').html(data)
                    $("#open-shippments").DataTable({})
                }
            })
        }
        function openBlendShippments() {
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {
                    action: "open-blend-shippments"
                },
                cache: true,
                url: "warehousing_action.php",
                success: function (data) {
                    $('#shippments').html(data)
                    $("#open-shippments").DataTable({})
                }
            })
        }
        $("body").on("click", ".setNotShip", function(e) {
            var stockId = $(this).attr("id");
            // console.log(contractno)
            document.querySelector('.loaderParent').style.opacity = 0.5

            changeShippmentStatus(stockId)
        });
        $("body").on("click", ".setNotShipBlend", function(e) {
            var stockId = $(this).attr("id");
            // console.log(contractno)
            document.querySelector('.loaderParent').style.opacity = 0.5

            changeShippmentStatus(stockId)
        });
        function changeShippmentStatus(stockId){
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {
                    action: "update-shippment",
                    stockId: stockId
                },
                url: "warehousing_action.php",
                success: function (data) {
                    alert(`Tea of Lot No. ${stockId} shipped status changed to not shipped`)
                    openShippments()
                    document.querySelector('.loaderParent').style.opacity = 1
                }
            })
        }
        function changeShippmentStatus(stockId){
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {
                    action: "update-blend-shippment",
                    stockId: stockId
                },
                url: "warehousing_action.php",
                success: function (data) {
                    alert(`Tea of Lot No. ${stockId} shipped status changed to not shipped`)
                    openBlendShippments()
                    document.querySelector('.loaderParent').style.opacity = 1
                }
            })
        }
    </script>

    </html>