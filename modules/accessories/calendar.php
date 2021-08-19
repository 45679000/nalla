<?php
$path_to_root = "../../";
include $path_to_root . 'templates/header.php';
?>
<div class="my-3 my-md-5">
    <div class="container-fluid">
        <div class="page-header">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./chamu/views/dashboard.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tools</li>
            </ol>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-body">
                        <div id='calendar1'></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card">
                <div class="card-body">
                        <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="#top" id="back-to-top" style="display: inline;"><i class="fa fa-angle-up"></i></a>

<script src='../../assets/plugins/fullcalendar/moment.min.js'></script>
<script src='../../assets/js/vendors/jquery-3.2.1.min.js'></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../../assets/js/vendors/selectize.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
<script src='../../assets/plugins/fullcalendar/fullcalendar.min.js'></script>

<!-- Custom scroll bar Js-->
<script src="../../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Custom JS-->
<script src="../../assets/js/fullcalendar.js"></script>
<script src="../../assets/js/custom.js"></script>