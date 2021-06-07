<?php
$path_to_root = "../";
$path_to_root1 = "../";
include $path_to_root.'templates/header.php';

?>
<style>
  
    .col-lg-10{
        margin: auto !important;

    }

</style>
<div class="my-3 my-md-5" style="margin-top:-20px;">
        <div class="container-fluid">
            <div class="page-header">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reports</li>
                </ol>
            </div>
            <div class="row">
                <div class="col-md-12">
                      <?php include 'rep_broker.php';?>
                </div>
            </div>
        </div>
</div>