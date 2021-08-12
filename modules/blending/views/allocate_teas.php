<style>
    .select2-container {
        width: 100% !important;
    }
    table {
    display: block;
    overflow-x: auto;
    white-space: nowrap;
    background-color: white !important;
    }   
    #compositionTable tbody tr td{
        padding-bottom: 0px !important;
    }
    .allocate {
        background: green;
        width: 50px;
        color: white;
    }

    .pdfViewer {
        background-color: white !important;
    }

    .deallocate {
        background: red;
        width: 50px;
        color: white;
    }

    .frame {
        background-color: white;
    }
    .my-custom-scrollbar {
    position: relative;
    height: 600px;
    overflow: auto;
    }
    .table-wrapper-scroll-y {
    display: block;
    }

    @media screen and (max-width:450) {
        .counter {
            margin-bottom: 10px;
        }
    }
</style>
<?php
$blendno = isset($_GET['blendno']) ? $_GET['blendno'] : '';

?>
<div class="col-md-8 col-lg-10">
    <div id="contentwrapper">
        <div class="card ">
            <div class="card-body p-2">
                <div class="col-md-12" >
                    <div class="row" id="tableData" style="max-height:20%;">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div style="width:100% !important;">
                        <div style="width:100% !important;" class="card-header">
                            <div class="row">
                                <div class="col-md-3 input-group">
                                    <label for="saleno">Sale No</label>
                                    <select class="select2" data-placeholder="Select" name="saleno" id="saleno"></select>
                                </div>
                                <div class="col-md-3 input-group">
                                    <label for="mark">Mark</label>
                                    <select class="select2" data-placeholder="Select" name="mark" id="mark"></select>
                                </div>
                                <div class="col-md-3 input-group">
                                    <label for="grade">Grade</label>
                                    <select class="select2" data-placeholder="Select" name="grade" id="grade"></select>
                                </div>
                                <div class="col-md-3 input-group">
                                    <label for="mark">Lot</label>
                                    <input id="lot" type="text" name="lot" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
                            <div style="width:100%" id="blendTable"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div style="width:100% !important; height:200px;" class="card-header">
                        <div class="row">
                            <div style="width:60vH; height:150px !important;" id="composition" class="col-md-12">
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-wrapper-scroll-y my-custom-scrollbar">
                        <div id="selected"></div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</div>



<script src="../../assets/js/blending.js"></script>
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../../assets/js/vendors/selectize.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
<script src="../../assets/plugins/select2/select2.full.min.js"></script>
<script id="url" data-name="../../ajax/common.php" src="../../assets/js/common.js"></script>
<!-- counter  -->
<script src="../../assets/plugins/counters/counterup.min.js"></script>
<script src="../../assets/plugins/counters/waypoints.min.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script>
    $(document).ready(function() {
        var blendno = '<?php echo $blendno ?>'

        $('.select2').select2();
        $('#saleno').change(function(e) {
            var mark = $('#mark').val();
            var grade = $('#grade').val();
            var lot = $('#lot').val();
            var saleno = $('#saleno').val();
            loadUnallocated(mark, lot, grade, saleno);
        });
        $('#mark').change(function(e) {
            var mark = $('#mark').val();
            var grade = $('#grade').val();
            var lot = $('#lot').val();
            var saleno = $('#saleno').val();
            loadUnallocated(mark, lot, grade, saleno);
        });
        $('#grade').change(function(e) {
            var mark = $('#mark').val();
            var grade = $('#grade').val();
            var lot = $('#lot').val();
            var saleno = $('#saleno').val();
            loadUnallocated(mark, lot, grade, saleno);
        });
        $('#lot').focusout(function(e) {
            var mark = $('#mark').val();
            var grade = $('#grade').val();
            var lot = $('#lot').val();
            var saleno = $('#saleno').val();
            loadUnallocated(mark, lot, grade, saleno);
        });
        loadUnallocated("", "", "", "");
        viewAllocations();
        loadComposition(blendno)
        showBlend(blendno);
        BlendAllocationSummary(blendno);

    });



    function callAction(element) {
        var blendno = '<?php echo $blendno ?>'
        var allocationid = $(element).attr("id");
        var allocatedpackages = $('#' + allocationid + 'allocatedpkgs').text();
        var availablepackages = $('#' + allocationid + 'availablepkgs').text();
        var allocatedKgs = $('#' + allocationid + 'allocatedkgs').text();
        var allocatednet = $('#' + allocationid + 'net').text();

        var kgsToAllocate = allocatedpackages * allocatednet;
        $('#' + allocationid + 'allocatedkgs').text(kgsToAllocate);

        // alert(allocatedKgs);
        showBlend(blendno);

        method = $(element).attr("class");
        if (allocatedpackages > availablepackages) {
            alert("You cannot allocate more Packages than what is in stock" + allocatedpackages + " " + availablepackages, method, allocatedKgs);
        } else {
            if (method == "allocate") {
                if (allocatedpackages != availablepackages) {
                    var split = 1;
                    addLotToBlend(allocationid, "add-blend-teas", blendno, allocatedpackages, method, allocatedKgs, split);
                    BlendAllocationSummary(blendno)
                } else {
                    var split = 0;

                    addLotToBlend(allocationid, "add-blend-teas", blendno, allocatedpackages, method, allocatedKgs, split);
                    BlendAllocationSummary(blendno)
                }

            } else if (method == "deallocate") {
                removeLotFromBlend(allocationid, "remove-blend-teas", blendno);
                BlendAllocationSummary(blendno);

            } else if (method == "allocateremaining") {
                $('#' + allocationid + 'allocation').text("");
                $('#' + allocationid + 'availablepkgs').text(availablepackages - allocatedpackages);
                $('#' + allocationid).removeClass('deallocate');
                $('#' + allocationid).addClass('allocate');
                $('#' + allocationid).html('<i class="fa fa-plus"></i>');
                $('#' + allocationid + 'allocation').text("");
            }
        }
    }

    $('#lotEdit').click(function(e) {
        e.preventDefault();
        var clientid = localStorage.getItem("clientId");
        showClientAllocation(clientid);

    });

    function viewAllocations() {
        var blendno = '<?php echo $blendno ?>'
        currentAllocation(blendno);
    }

    function viewBlendSheet() {
        var blendno = '<?php echo $blendno ?>'

        $('#blendTable').html('<iframe class="frame" frameBorder="0" src="../../reports/blend_sheet.php?blendno=' + blendno + '" width="100%" height="800px"></iframe>');
    }

    function approveBlend() {
        var blendno = '<?php echo $blendno ?>'
        $.ajax({
            url: "blend_action.php",
            type: "POST",
            dataType: "html",
            data: {
                action: "approve-blend",
                blendno: blendno
            },
            success: function(response) {
                showBlend(blendno);
                Swal.fire({
                    icon: 'success',
                    title: 'Blend Confirmed Successfully',
                });
            }

        });

    }

    function editBlend() {
        var blendno = '<?php echo $blendno ?>'
        $.ajax({
            url: "blend_action.php",
            type: "POST",
            dataType: "html",
            data: {
                action: "edit-blend",
                blendno: blendno
            },
            success: function(response) {
                showBlend(blendno);
                location.reload()
            }

        });

    }
</script>