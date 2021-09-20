<?php
define('ROOT_PATH', dirname(__DIR__) . '/');
$path_to_root = "../../";
include(ROOT_PATH . '../templates/header.php');
include(ROOT_PATH . '../widgets/_form.php');
include('../../includes/auction_ids.php');
include(ROOT_PATH . '../models/Model.php');
include(ROOT_PATH . '../controllers/ShippingController.php');
include(ROOT_PATH . '../controllers/BlendingController.php');

$form = new Form();
$si = isset($_GET['sino']) ?  $_GET['sino'] : '';
$type = isset($_GET['type']) ?  $_GET['type'] : '';
$shippingCtrl = new ShippingController($conn);
$blendingCtrl = new BlendingController($conn);

?>
<style>
 a {
  text-decoration: none;
  display: inline-block;
  padding: 8px 16px;
}

a:hover {
  background-color: #ddd;
  color: black;
}

.previous {
  background-color: #f1f1f1;
  color: black;
}

.next {
  background-color: #04AA6D;
  color: white;
}

.round {
  border-radius: 50%;
}

    form .error {
        color: #ffff;
    }

    .form-control {
        color: black !important;
        padding: 1px !important;
    }

</style>
<div class="container-fluid content">

    <div class="card" style="margin-top:20px;">
     
        <div class="card-body p-6">
            <?php
            $view = isset($_GET['view']) ? $_GET['view'] :'';
            switch ($view) {
                case 'shipment-teas':
                    include 'shipment_teas.php';
                    break;
                case 'si':
                    include 'si_form.php';
                    break;
                case 'documents':
                    include 'required_documents.php';
                    break;
                case 'summary':
                    include 'shipment_summary.php';
                    break;
                default:
                    include 'si_form.php';
                    break;
            }
            ?>
            
        </div>
    </div>
</div>

</div>
<script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="<?= $path_to_root ?>assets/plugins/tabs/jquery.multipurpose_tabcontent.js"></script>
<!-- Sweet alert Plugin -->
<script src="<?php echo $path_to_root ?>assets/plugins/sweet-alert/sweetalert.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/js/sweet-alert.js"></script>
<script src="shipping.js"></script>

<script src="<?php echo $path_to_root ?>assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/plugins/select2/select2.full.min.js"></script>

<!---Tabs scripts-->

<script>
    $('.select2').select2();

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

