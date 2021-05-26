<?php
define('ROOT_PATH', dirname(__DIR__) . '/');
$path_to_root = "../../";
include(ROOT_PATH . '../templates/header.php');
include(ROOT_PATH . '../widgets/_form.php');

$form = new Form();

?>
<style>
    .tab_list {
        width: 15% !important;
        border-left: 1px;
        ;
    }

    .content {
        min-height: 160%;
    }

    .tab_wrapper.left_side .content_wrapper {
        width: 85% !important;
        border: 1px solid #eaeaea;
        float: left;
    }

    .form-label {
        color: black !important;
    }

    .card {
        margin-top: 30px;
    }
</style>
<div class="container-fluid content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Shipping Process</h3>
        </div>
        <div class="card-body p-6">
            <div class="tab_wrapper second_tab">
                <ul id="tabs" class="tab_list">
                    <li>SHIPPING INSTRUCTIONS</li>
                    <li>ADD LOTS</li>
                    <li>SHIPMENT TEAS</li>
                    <li>PACKING MATERIALS</li>
                    <li>PRINT REQUIRED DOCUMENTS</li>
                    <li>CONFIRM SHIPMENT</li>

                </ul>

                <div class="content_wrapper">
                    <div id="si_tab" class="tab_content active">
                        <?php
                        include 'si_form.php';
                        ?>
                    </div>

                    <div class="tab_content">
                        <?php
                        if(isset($_SESSION['shipment-type'])){
                            if($_SESSION["shipment-type"]=="Blend Shippment"){
                                include 'blended_shipment.php';
                            }
                        }else{
                            include 'direct_shipment.php';
                        }
                        ?>
                    </div>


                    <div class="tab_content">
                    </div>

                    <div class="tab_content">
                    </div>

                    <div class="tab_content">
                    </div>

                    <div class="tab_content">
                    </div>


                </div>

            </div>

        </div>
    </div>

</div>
<?php
$path_to_root = "../../";
// include(ROOT_PATH . '../templates/footer.php');
// ?>
<script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="<?=$path_to_root ?>assets/plugins/tabs/jquery.multipurpose_tabcontent.js"></script>
<!-- Sweet alert Plugin -->
<script src="<?php echo $path_to_root ?>assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/js/sweet-alert.js"></script>


<!---Tabs scripts-->
<script>
    $(function(e) {
        $(".first_tab").champ();
        $(".accordion_example").champ({
            plugin_type: "accordion",
            side: "right",
            active_tab: "3",
            controllers: "true"
        });

        $(".second_tab").champ({
            plugin_type: "tab",
            side: "left",
            active_tab: "1",
            controllers: "false"
        });

    });
</script>

<script>
$('#si_form').submit(function(e){
    e.preventDefault();
    $("<input />").attr("type", "hidden")
          .attr("name", "action")
          .attr("value", "add-si")
          .appendTo("#si_form");
    $.ajax({   
        type: "POST",
        data : $(this).serialize(),
        cache: false,  
        url: "../../ajax/process_shipping.php",   
        success: function(data){
            swal('',data.message, 'success');
        }   
    });   
    return false;   
});

$('#si_tab').click(function(e){
    $.ajax({   
        type: "POST",
        data : $(this).serialize(),
        cache: false,  
        url: "../../ajax/process_shipping.php",   
        success: function(data){
            const keys = Object.keys(data);
            keys.forEach((key, index) => {
                console.log(`${key}: ${data[key]}`);
            });
        }   
    });   

});



</script>