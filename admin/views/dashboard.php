<?php
session_start();
$path_to_root = "../../../";
error_reporting(0);
include($path_to_root . 'templates/header.php');
?>
<!doctype html>
<html lang="en" class="no-js">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">

    <title>Admin Dashboard</title>

</head>

<body class="">
    <div id="global-loader"></div>
    <div class="page">
        <div class="page-main">
            <div class="my-1 my-md-1">
                <div class="container-fluid">
                    <div class="row row-cards">
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="card widgets-cards">
                                <div class="card-body d-flex justify-content-center align-items-center">
                                    <div class="col-5 p-0">
                                        <div class="wrp icon-circle bg-success">
                                            <i class="si si-basket-loaded icons"></i>
                                        </div>
                                    </div>
                                    <div class="col-7 p-0">
                                        <div class="wrp text-wrapper">
                                            <p>8954</p>
                                            <p class="text-dark mt-1 mb-0">Week Orders</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Users</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive border-top">
                                        <table class="table card-table table-striped table-vcenter">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th colspan="2">User</th>
                                                    <th>Feed back</th>
                                                    <th>Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>2345</td>
                                                    <td><span class="avatar brround "
                                                            style="background-image: url(assets/images/faces/male/1.jpg)"></span>
                                                    </td>
                                                    <td>Megan Peters</td>
                                                    <td>please check pricing Info </td>
                                                    <td class="text-nowrap">July 13, 2018</td>
                                                    <td class="w-1"><a href="#" class="icon"><i
                                                                class="fa fa-trash-o"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td>4562</td>
                                                    <td><span class="avatar brround"
                                                            style="background-image: url(assets/images/faces/female/1.jpg)"></span>
                                                    </td>
                                                    <td>Phil Vance</td>
                                                    <td>New stock</td>
                                                    <td class="text-nowrap">June 15, 2018</td>
                                                    <td><a href="#" class="icon"><i class="fa fa-trash-o"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td>8765</td>
                                                    <td><span class="avatar brround">AS</span></td>
                                                    <td>Adam Sharp</td>
                                                    <td>Daily updates</td>
                                                    <td class="text-nowrap">July 8, 2018</td>
                                                    <td><a href="#" class="icon"><i class="fa fa-trash-o"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td>2665</td>
                                                    <td><span class="avatar brround"
                                                            style="background-image: url(assets/images/faces/male/4.jpg)"></span>
                                                    </td>
                                                    <td>Samantha Slater</td>
                                                    <td>available item list</td>
                                                    <td class="text-nowrap">June 28, 2018</td>
                                                    <td><a href="#" class="icon"><i class="fa fa-trash-o"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td>8547</td>
                                                    <td><span class="avatar brround"
                                                            style="background-image: url(assets/images/faces/female/11.jpg)"></span>
                                                    </td>
                                                    <td>Joanne Nash</td>
                                                    <td>Provide Best Services</td>
                                                    <td class="text-nowrap">July 2, 2018</td>
                                                    <td><a href="#" class="icon"><i class="fa fa-trash-o"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td>3425</td>
                                                    <td><span class="avatar brround"
                                                            style="background-image: url(assets/images/faces/female/14.jpg)"></span>
                                                    </td>
                                                    <td>Ruby Wisely</td>
                                                    <td>Best stock</td>
                                                    <td class="text-nowrap">May 28, 2018</td>
                                                    <td><a href="#" class="icon"><i class="fa fa-trash-o"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td>1245</td>
                                                    <td><span class="avatar brround"
                                                            style="background-image: url(assets/images/faces/male/21.jpg)"></span>
                                                    </td>
                                                    <td>Daneil Smash</td>
                                                    <td>new trends</td>
                                                    <td class="text-nowrap">Apr 2, 2018</td>
                                                    <td><a href="#" class="icon"><i class="fa fa-trash-o"></i></a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Back to top -->
    <a href="#top" id="back-to-top" style="display: inline;"><i class="fa fa-angle-up"></i></a>



    <!-- Dashboard Core -->
    <script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
    <script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/vendors/jquery.sparkline.min.js"></script>
    <script src="../assets/js/vendors/selectize.min.js"></script>
    <script src="../assets/js/vendors/jquery.tablesorter.min.js"></script>
    <script src="../assets/js/vendors/circle-progress.min.js"></script>
    <script src="../assets/plugins/rating/jquery.rating-stars.js"></script>

    <script src="../assets/plugins/echarts/echarts.js"></script>
    <script src="../assets/js/index1.js"></script>
    <!--Morris.js Charts Plugin -->
    <script src="../assets/plugins/am-chart/amcharts.js"></script>
    <script src="../assets/plugins/am-chart/serial.js"></script>

    <!-- Custom scroll bar Js-->
    <script src="../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

    <!-- Custom Js-->
    <script src="../assets/js/custom.js"></script>

</body>

</html>