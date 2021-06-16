<style>
    .counter {
        font-family: 'Poppins', sans-serif;
        padding: 7.5px 0 0;
    }

    .counter .counter-value {
        color: #fff;
        background: linear-gradient(to top right, #d23283, #771656);
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        line-height: 50px;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        box-shadow: 0 8px 8px rgba(0, 0, 0, 0.3);
        transform: translateX(-50%);
        position: absolute;
        top: 0;
        left: 50%;
        z-index: 1;
    }

    .counter .counter-content {
        color: #771656;
        background: #fff;
        text-align: center;
        width: 100px;
        height: 100px;
        padding: 54px 3.5px 3.5px;
        margin: 0 auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
        border-radius: 50%;
        overflow: hidden;
        position: relative;
    }

    .counter .counter-content:before {
        content: "";
        background: linear-gradient(to bottom, #d23283, #771656);
        width: 100%;
        height: 90%;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.6);
        transform: translateX(-50%);
        position: absolute;
        top: -65px;
        left: 50%;
    }

    .counter h3 {
        font-size: 17px;
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
<div style="height:40% !important;">
        <form id="blend_master" method="post">
        <div class="row">

            <div class="col-md-3 col-md-3">
                <div class="form-group"><label class="form-label">Blend No</label><input type="text" class="form-control" id="blend_no" name="blend_no" value=""></div>
                <div class="form-group"><label class="form-label">Date</label><input type="text" class="form-control" id="date_" name="date_" value=""></div>
                <div class="form-group"><label class="form-label">Client Name</label><select name="client_name" id="client_name" class="form-control  select2-show-search" data-placeholder="Select)"> Select2 with search box<option value="BASU">BASU</option>
                        <option value="KARACHI">KARACHI</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 col-md-3">
                <div class="form-group"><label class="form-label">Std Name</label><input type="text" class="form-control" id="std_name" name="std_name" value=""></div>
                <div class="form-group"><label class="form-label">Grade</label><select name="grade" id="grade" class="form-control  select2-show-search" data-placeholder="Select)">
                    </select>
                </div>
                <div class="form-group"><label class="form-label">NW</label><input type="text" class="form-control" id="nw" name="nw" value=""></div>
            </div>
            <div class="col-md-3 col-md-3">
                <div class="form-group"><label class="form-label">Auction Week</label><select name="sale_no" id="sale_no" class="form-control  select2-show-search" data-placeholder="Select)"> Select2 with search box<option value="2021-00">2021-00</option>

                    </select>
                </div>
                <div class="form-group"><label class="form-label">Output Pkgs</label><input type="text" class="form-control" id="output_pkgs" name="output_pkgs" value=""></div>
                <div class="form-group"><label class="form-label">Output Kgs</label><input type="text" class="form-control" id="output_kgs" name="output_kgs" value=""></div>
            </div>
            <div class="col-md-3 col-md-3">
                <div class="form-group"><label class="form-label">comments</label><textarea type="text-area" class="form-control" rows="5" cols="5" id="comments" name="comments" value=""></textarea></div>
            </div>
            <div style="text-align:center; margin:auto;">
                <button id="blendIt" class="btn btn-success"><i class="fa fa-hourglass"></i>Create Blend</button>

            </div>
        </div>
        </form>
    
   
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

        </div>
    </div>
    <div class="row" style="max-height:20%;">
        <div class="col-md-3 col-sm-6">
            <div class="counter">
                <span id="BtotalLots" class="counter-value">0</span>
                <div class="counter-content">
                    <h3>Lots</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="counter orange">
                <span id="BtotalPackages" class="counter-value">10</span>
                <div class="counter-content">
                    <h3>KGS</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="counter orange">
                <span id="BtotalKilos" class="counter-value">0</span>
                <div class="counter-content">
                    <h3>Packages</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="counter orange">
                <span id="BtotalValue" class="counter-value">0</span>
                <div class="counter-content">
                    <h3>Amount USD</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div id="blendTable"></div>
        </div>
    </div>
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
    addBlend();
    gradeList();
</script>