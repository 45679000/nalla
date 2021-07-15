<?php if($_GET['type']=="Blend Shippment") {?>
<div id="blendedTea">
    <div class="row justify-content-center">
        <div class="col-md-6 well">
            <div class="form-group label-floating">
                <label class="control-label">Blends</label>
                <select id="blendlist" name="blend" class="form-control select2-show-search"><small>(required)</small>
                    <option disabled="" value="..." selected="">select</option>
                </select>
            </div>
        </div>
        <div id="attachButton" class="col-md-6 well">
            <div class="form-group label-floating">
                <button id="attachblendsheet" class="btn btn-success btn-xs"><i class="fa fa-plus">Attach Blend Sheet</i></button>
            </div>
        </div>
    </div>
    <div id="document">
    </div>
</div>
<?php }else{ ?>
<div id="straightLine">
    <div class="row justify-content-center">
        <div class="col-md-6 well">
            <div class="form-group label-floating">
                <label class="control-label">Lot Detail(Contract No)</label>
                <select id="contactno" name="blend" class="form-control select2-show-search"><small>(required)</small>
                    <option disabled="" value="..." selected="">select</option>
                </select>
            </div>
        </div>
        <div id="attachButton" class="col-md-6 well">
            <div class="form-group label-floating">
                <button id="attachSiStraight" class="btn btn-success btn-xs"><i class="fa fa-plus">Attach Lot Details</i></button>
            </div>
        </div>
    </div>
    <div id="document">
    </div>
</div>
<?php } ?>




<div class="text-center">
    <a id="previous" href="#" class="previous">&laquo; Previous</a>
    <a id="next" href="#" class="next">Next &raquo;</a>
</div>
<script src="shipping.js"></script>
<script src="../../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../../assets/js/vendors/selectize.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>

<!-- counter  -->
<script src="../../assets/plugins/counters/counterup.min.js"></script>
<script src="../../assets/plugins/counters/waypoints.min.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {

        $('#attachButton').hide();
        $(function() {
            var blendno;
            var sino = '<?php echo $_GET['sino']; ?>'
            $('.table tr').click(function(e) {
                var cell = $(e.target).get(0); // This is the TD you clicked
                var tr = $(this); // This is the TR you clicked
                $('td', tr).each(function(i, td) {
                    if (i == 0) {
                        blendno = $(td).text();
                        appendSi(blendno, sino);
                    }
                });
            });

        });
        $('#attachblendsheet').click(function() {
            var blendno = localStorage.getItem("blendno");
            var sino = '<?php echo $_GET['sino']; ?>'
            $.ajax({
                type: "POST",
                data: {
                    sino: sino,
                    blendno: blendno,
                    action: "attach-blend-si"
                },
                cache: false,
                url: "shipping_action.php",
                success: function(data) {
                    swal('Success', data.message, 'success');
                }
            });
        });

    });
    loadSelectionBlendList();
    loadSelectionLotList();
    $('#next').click(function() {
        var sino = '<?php echo $_GET['sino']; ?>'
        var type = '<?php echo $_GET['type']; ?>'

        window.location.href = './index.php?view=documents&sino=' + sino+'&type='+type;

    });
    $('#previous').click(function() {
        window.location.href = './index.php';

    });

    $("table").DataTable({
        order: [0, 'ASC']
    });
    $('#blendlist').change(function() {
        var blendno = $('#blendlist').val();
        localStorage.setItem("blendno", blendno);
        $('#attachButton').show();
        $('#document').html('<iframe class="frame" frameBorder="0" src="../../reports/blend_sheet.php?blendno='+blendno+'" width="100%" height="800px"></iframe>');
    })
    $('#contactno').change(function(){
        var contractno = $('#contactno').val().trim();
        localStorage.setItem("contractno", contractno);
        $('#attachButton').show();
        $('#document').html('<iframe class="frame" frameBorder="0" src="../../reports/straightline_lots.php?sino='+contractno+'" width="100%" height="800px"></iframe>');

    });

    $('#attachSiStraight').click(function(){
            var contractNo = localStorage.getItem("contractno");
            var sino = '<?php echo $_GET['sino']; ?>'
            $.ajax({
                type: "POST",
                data: {
                    sino: sino,
                    contractNo: contractNo,
                    action: "attach-straight-si"
                },
                cache: false,
                url: "shipping_action.php",
                success: function(data) {
                    swal('Success', data.message, 'SI Attached');
                    $('#document').html('<iframe class="frame" frameBorder="0" src="../../reports/straightline_lots.php?sino='+contractno+'" width="100%" height="800px"></iframe>');

                }
            });
    })


</script>