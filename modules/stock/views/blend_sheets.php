<style>
    .select2-container {
        width: 100% !important;
    }
    .allocate {
        background: green;
        width: 50px;
        color: white;
    }

    .pdfViewer {
        padding-bottom: var(--pdfViewer-padding-bottom);
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
        height: 60vH;
        overflow: auto;
    }

    .table-wrapper-scroll-y {
        display: block;
    }

    .horizontal-scrollable>.row {
        overflow-x: auto;
        white-space: nowrap;
    }

    .horizontal-scrollable>.row>.col-xs-4 {
        display: inline-block;
        float: none;
    }

    .clickable:hover {
        background-color: green;
        opacity: 0.3;
        color: white;
    }
    div.dataTables_wrapper div.dataTables_filter input {
    margin-left: 0.8em;
    display: inline-block;
    width: 100px !important;
}


    @media screen and (max-width:450) {
        .counter {
            margin-bottom: 10px;
        }
    }
</style>

<div class="col-md-12 col-lg-12">
    <div class="row">
        <div class="col-md-1 card p-2">
            <div class="table-responsive">
                <div class="card ">
                    <span><i class="fa fa-search card-header">Search Blend Sheet</i></span>
                </div>
                <div id="menuTable" style="height:85vH;" class="p-3">

                </div>
            </div>
        </div>
            <div class="col-md-11">
                <div class="card" style="height:85vH;">
                    <div class="card-status card-status-left bg-red br-bl-7 br-tl-7"></div>

                    <div class="card-header">
                        <span>Blend Sheets</span>
                    </div>
                    <div class="card-body">
                        <div id="blendSheetWrapper"></div>
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


<script>
    $("#issueTeaMenu").hide();
    $("#allocationContainer").hide();

    $(document).ready(function() {
        menu();
        $("body").on("click", ".contractBtn", function(e) {
            e.preventDefault();
            var contractno = $(this).attr("id");
            print_lotdetails(contractno);

        });

    });

    function menu() {
        $.ajax({
            url: "../blending/blend_action.php",
            type: "POST",
            dataType: "html",
            data: {
                action: "show-all",
            },
            success: function(response) {
                $("#menuTable").html(response);
                var table = $("#menuStraight").DataTable({
                    "paging": false,
                    "bInfo": false,
                    "dom": '<"top"f>rt<"bottom"lp><"clear">', // Positions table elements
                    "language": {
                        "search": "_INPUT_",            // Removes the 'Search' field label
                        "searchPlaceholder": "Search"   // Placeholder for the search box
                    }
                });
                $('#mySearchButton').on( 'keyup click', function () {
                    table.search($('#mySearchText').val()).draw();
                } );

            }

        });

    }

    function print_lotdetails(contractno) {
        $('#blendSheetWrapper').html('<iframe class="frame" frameBorder="0" src="../../reports/straightline_lots.php?sino=' + contractno + '" width="100%" height="800px"></iframe>');
    }













</script>