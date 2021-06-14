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
<?php
$form->beginForm("si_form");
print '

<div  class="card-body" style="height:40% !important;">

    <div class="row">
        <div class="col-md-3 col-md-3">';
            $form->formField("text", "blend_no", "", "Blend No");
            $form->formField("text", "date_", "", "Date");
            $form->formField("dropdownlist", "client_name", "", "Client Name", array("BASU" => "BASU", "KARACHI" => "KARACHI"));           
            print '</div>
        <div class="col-md-3 col-md-3">';
            $form->formField("text", "std_name", "", "Std Name");
            $form->formField("dropdownlist", "Grade", "", "Grade", array("BP1" => "BP1", "PF1" => "PF1"));           
            $form->formField("text", "nw", "", "NW");
            print '</div>
        <div class="col-md-3 col-md-3">';
            $form->formField("dropdownlist", "sale_no", "", "Auction Week", "");           
            $form->formField("text", "output_pkgs", "", "Output Pkgs");
            $form->formField("text", "output_kgs", "", "Output Kgs");
            print '</div>
        <div class="col-md-3 col-md-3">';
            $form->formField("text-area", "comments", "", "comments");
            print '</div>';
        $form->addButtons('step1');
        print '
    </div>
</div>
';

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">

        </div>
    </div>
    <div class="row" style="max-height:20%;">
        <div class="col-md-3 col-sm-6">
            <div class="counter">
                <span id="totalLots" class="counter-value">0</span>
                <div class="counter-content">
                    <h3>Lots</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="counter orange">
                <span id="totalPackages" class="counter-value">10</span>
                <div class="counter-content">
                    <h3>Packages</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="counter orange">
                <span id="totalKilos" class="counter-value">0</span>
                <div class="counter-content">
                    <h3>Kilos</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="counter orange">
                <span id="totalValue" class="counter-value">0</span>
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