<?php
$path_to_root = "../../";
require_once $path_to_root . 'templates/header.php';
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
    #allShippments {
        display: flex;
        flex-direction: row;
        gap: 2rem;
    }
</style>

<body class="container-fluid">
    <div id="global-loader"></div>
    <div class="page">
        <div class="page-main">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-light">Shippments' Supporting documents</h3>
                </div>
                <div class="col-md-6 my-5 ">
                    <form action="">
                        <input type="text" name="si-no" id="si-no" placeholder="Choose si No." class="form-control">
                        <input type="file" id="pdf" name="pdf" class="form-control">
                    </form>
                </div>
                <div class="card col-12 p-md-4" id="allShippments">
                    <div id="allShippments"class="col-md-6" ></div>
                    <div id="pdfPreview"class="col-md-6" ></div>
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
        $.ajax({
        type: "POST",
        dataType: "html",
        data: {
            action: "allShippmentsDocs"
        },
        cache: true,
        url: "warehousing_action.php",
        success: function (data) {
         $('#allShippments').html(data);
         $("#all-shipping-instructions").DataTable({})

        }
    });
        shippment();
        $("body").on("click", ".allocatem", function(e) {
            var sino = $(this).attr("id");
            localStorage.setItem("sino", sino);
            var contractno = $(this).parent().attr("id");
            $("#si_no").html(contractno);
            $("#shippments").hide();
            $("#allocations").show();
            $("#addMaterial").click(function(e) {
                $("#addModal").show();
                loadPackingMaterialsToAlloacate();
            });
            $(".close").click(function() {
                $("#addModal").hide();

            });
            loadSiAllocation(localStorage.getItem("sino"));
        });
        $("body").on("click", ".deleteBtn", function(e) {
            var id = $(this).attr("id");
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {
                    action: "unallocate-si",
                    id: id
                },
                cache: true,
                url: "warehousing_action.php",
                success: function(data) {
                    loadSiAllocation(localStorage.getItem("sino"));
                }
            });
        });

        $("body").on("click", ".allocate", function(e) {
            var id = $(this).attr("id");
            var value = $("#" + id + "selected").text();
            var type_id = $(this).parent().attr("class");
            $.ajax({
                type: "POST",
                dataType: "html",
                data: {
                    action: "allocate-material-si",
                    si_no: localStorage.getItem("sino"),
                    total: value,
                    material_id: id,
                    type_id: type_id,
                    event: "0",
                    source:"Si Allocation",
                    details:"Materials Allocated to SI:"+$("#si_no").text()

                },
                cache: true,
                url: "warehousing_action.php",
                success: function(data) {
                    loadSiAllocation(localStorage.getItem("sino"));

                }
            });

        });

        showPackingMaterialAlloacated();    
        </script>

    </html>