<style>
    .counter {
        font-family: 'Poppins', sans-serif;
        padding: 0.5px 0 0;
    }

    .card {
        max-height: 45%;
    }
    .table{
        background-color: white;
    }
    .counter .counter-value {
        color: black;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        line-height: 50px;
        width: 90px;
        height: 50px;
        box-shadow: 0 8px 8px rgba(0, 0, 0, 0.3);
        position: absolute;
        top: 0;
        left: 58%;
        margin-top: -20px;

    }

    .counter .counter-content {
        color: #771656;
        background: #fff;
        text-align: center;
        width: 80px;
        height: 50px;
        padding: 20px 1.5px 1.5px;
        margin: 0 auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
        overflow: hidden;
        position: relative;
        margin-top: -20px;
    }

    .counter .counter-content:before {
        content: "";
        background: linear-gradient(to bottom, #d23283, #771656);
        width: 100%;
        height: 90%;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
        position: absolute;
        top: -65px;
        left: 50%;
    }

    .counter h3 {
        font-size: 12px;
        font-weight: 500;
        text-transform: capitalize;
        line-height: 17px;
        margin: 0;
    }

    .counter.orange .counter-content {
        color: #e84a16;
    }

    .counter.orange .counter-value {
        background: linear-gradient(to top right, #f57312, #e84a16);
    }

    .counter.orange .counter-content:before {
        background: linear-gradient(to bottom, #f57312, #e84a16);
    }

    .counter.green .counter-content {
        color: #2c970d;
    }

    .counter.green .counter-value {
        background: linear-gradient(to top right, #80f80d, #2c970d);
    }

    .counter.green .counter-content:before {
        background: linear-gradient(to bottom, #80f80d, #2c970d);
    }

    .counter.blue .counter-content {
        color: #1c7ac0;
    }

    .counter.blue .counter-value {
        background: linear-gradient(to top right, #2ebef3, #1c7ac0);
    }

    .counter.blue .counter-content:before {
        background: linear-gradient(to bottom, #2ebef3, #1c7ac0);
    }

    @media screen and (max-width:450) {
        .counter {
            margin-bottom: 10px;
        }
    }
</style>
<div class="col-md-8 col-lg-10">
    <div class="card">
        <div class="card-body p-6">
            <div class="col-md-12">
                <div class="row" style="max-height:20%;">
                    <div class="col-md-3 col-sm-6">
                        <div class="counter">
                            <span id="StotalLots" class="counter-value">0</span>
                            <div class="counter-content">
                                <h3>Lots</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="counter orange">
                            <span id="StotalPackages" class="counter-value">0</span>
                            <div class="counter-content">
                                <h3>Packages</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="counter orange">
                            <span id="StotalKilos" class="counter-value">0</span>
                            <div class="counter-content">
                                <h3>Kilos</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="counter orange">
                            <span id="StotalValue" class="counter-value">0</span>
                            <div class="counter-content">
                                <h3>Amount USD</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="col-md-12">
        <div id="straightTable"></div>
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

<!-- counter  -->
<script src="../../assets/plugins/counters/counterup.min.js"></script>
<script src="../../assets/plugins/counters/waypoints.min.js"></script>

<script src="../../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script>
    $.ajax({
        type: "POST",
        data: {
            action: "load-unallocated",
            type: "straight"
        },
        cache: true,
        url: "shipping_action.php",
        success: function(data) {
            $('#straightTable').html(data);
            $("#direct_lot").DataTable({});

        }
    });
</script>