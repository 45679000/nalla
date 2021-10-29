<?php 
	session_start();
	include $path_to_root.'database/page_init.php';

	include $path_to_root.'templates/validate_login.php';
	// Turn off error reporting
	error_reporting(1);
	$user_full_name = $_SESSION["full_name"];
	$user_department = $_SESSION["user_department"];
?>
<!doctype html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="msapplication-TileColor" content="#0061da">
    <meta name="theme-color" content="#1643a3">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />

    <!-- Title -->
    <title>Chamu TIFMS</title>
    <link rel="stylesheet" href="<?=$path_to_root ?>assets/fonts/fonts/font-awesome.min.css">

    <!-- Font family -->
    <link href="<?=$path_to_root ?>assets/css/google_fonts.css" rel="stylesheet" />
    

    <!-- Dashboard Css -->
    <link href="<?=$path_to_root ?>assets/css/dashboard.css" rel="stylesheet" />

    <link href="<?=$path_to_root ?>assets/plugins/notify/css/jquery.growl.css" rel="stylesheet" />


    <!-- c3.js Charts Plugin -->
    <link href="<?=$path_to_root ?>assets/plugins/charts-c3/c3-chart.css" rel="stylesheet" />

    <!-- Custom scroll bar css-->
    <link href="<?=$path_to_root ?>assets/plugins/scroll-bar/jquery.mCustomScrollbar.css" rel="stylesheet" />

    <!---Font icons-->
    <link href="<?=$path_to_root ?>assets/plugins/iconfonts/plugin.css" rel="stylesheet" />

    <!-- forn-wizard css-->
    <link href="<?=$path_to_root ?>assets/plugins/forn-wizard/css/material-bootstrap-wizard.css" rel="stylesheet" />
    <link href="<?=$path_to_root ?>assets/plugins/forn-wizard/css/demo.css" rel="stylesheet" />

    <!-- file upload css -->
    <link href="<?=$path_to_root ?>assets/plugins/fileuploads/css/dropify.min.css" rel="stylesheet" type="text/css" />

    <!-- Data table css -->
    <link href="<?=$path_to_root ?>assets/plugins/datatable/dataTables.bootstrap4.min.css" rel="stylesheet" />

    <!-- select2 Plugin -->
    <link href="<?=$path_to_root ?>assets/plugins/select2/select2.min.css" rel="stylesheet" />
    <!-- Tabs Style -->
    <link href="<?=$path_to_root ?>assets/plugins/tabs/style.css" rel="stylesheet" />
    <link href="<?=$path_to_root ?>assets/plugins/sweet-alert/sweetalert.css" rel="stylesheet" />

    <link href="<?=$path_to_root ?>assets/plugins/accordion/accordion.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
    }

    .navbar {
        overflow: hidden;
        background-color: #333;
        font-family: Arial, Helvetica, sans-serif;
    }

    .navbar a {
        float: left;
        font-size: 16px;
        color: white;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
    }

 

    .dropdown .dropbtn {
        font-size: 16px;
        border: none;
        outline: none;
        color: white;
        padding: 14px 16px;
        background-color: inherit;
        font: inherit;
        margin: 0;
    }

    .navbar a:hover,
    .dropdown:hover .dropbtn {
        background-color: red;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f9f9f9;
        width: 100%;
        left: 0;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content .header {
        background: red;
        padding: 16px;
        color: white;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    /* Create three equal columns that floats next to each other */
    .column {
        float: left;
        width: 33.33%;
        padding: 10px;
        background-color: #ccc;
        height: 250px;
    }

    .column a {
        float: none;
        color: black;
        padding: 16px;
        text-decoration: none;
        display: block;
        text-align: left;
    }

    .column a:hover {
        background-color: #ddd;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    div.img-div {
        height: 70px;
        width: 85px;
        /* overflow:hidden; */
        border-radius: 50%;
        background-color: white;
    }

    .img-div img {
        -webkit-transform: translate(-50%);
        margin-left: 34px;
        height: 50px;
        width: 50px;
    }
	.header{
		margin-top: 0.5vh;
	}

    /* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
    @media screen and (max-width: 600px) {
        .column {
            width: 100%;
            height: auto;
        }
    }
    </style>

</head>
<div class="header py-1">
    <div class="container-fluid">
        <div class="d-flex">
            <div class="img-div">
                <img src="<?=$path_to_root ?>images/logo.png" class="img-fluid" alt="CHAMU TIFMS"> 
            </div>
            <div class="container-fluid">
                <div class="text-center pt-2" id="sys_notification">
                </div>
            </div>
           	<div class="d-flex order-lg-2 ml-auto">
								<div class="dropdown d-none d-md-flex mt-1" >
									<a  class="nav-link icon full-screen-link">
										<i class="fe fe-maximize floating"  id="fullscreen-button"></i>
									</a>
								</div>
								<div class="dropdown d-none d-md-flex mt-1">
									<a class="nav-link icon" data-toggle="dropdown">
										<i class="fe fe-bell floating"></i>
										<span class="nav-unread bg-danger"></span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a href="#" class="dropdown-item d-flex pb-3">
											<div class="notifyimg">
												<i class="fa fa-thumbs-o-up"></i>
											</div>
											<div>
												<strong>Catalogs For Sale 33 Have Been Uploaded.</strong>
												<div class="small text-muted">3 hours ago</div>
											</div>
										</a>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item text-center">View all Notification</a>
									</div>
								</div>
								<div class="dropdown d-none d-md-flex mt-1">
									<a class="nav-link icon" data-toggle="dropdown">
										<i class="fe fe-mail floating"></i>
										<span class=" nav-unread badge badge-warning  badge-pill">0</span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<a href="#" class="dropdown-item text-center">0 New Email</a>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item d-flex pb-3">
											<span class="avatar brround mr-3 align-self-center" style="background-image: url(assets/images/faces/male/41.jpg)"></span>
											<!-- <div>
												<strong>Madeleine</strong> Hey! there I' am available....
												<div class="small text-muted">3 hours ago</div>
											</div> -->
										</a>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item text-center">See all Messages</a>
									</div>
								</div>
								<div class="dropdown d-none d-md-flex mt-1">
									<a class="nav-link icon" data-toggle="dropdown">
										<i class="fe fe-grid floating"></i>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<ul class="drop-icon-wrap p-1">
											<li>
												<a href="../modules/emails/index.php" class="drop-icon-item">
													<i class="fe fe-mail text-dark"></i>
													<span class="block"> E-mail</span>
												</a>
											</li>
											<li>
												<a href="../modules/accessories/calendar.php" class="drop-icon-item">
													<i class="fe fe-calendar text-dark"></i>
													<span class="block">calendar</span>
												</a>
											</li>
											<li>
												<a href="maps.html" class="drop-icon-item">
													<i class="fe fe-map-pin text-dark"></i>
													<span class="block">map</span>
												</a>
											</li>
											
										</ul>
										<div class="dropdown-divider"></div>
										<a href="#" class="dropdown-item text-center">View all</a>
									</div>
								</div>
								<div class="dropdown mt-1">
									<a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
										<span class="avatar avatar-md brround" style="background-image: url(assets/images/faces/female/25.jpg)"></span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow ">
										<div class="text-center">
											<a id="username" href="#" class="dropdown-item text-center font-weight-sembold user"></a>
											<span id="department" class="text-center user-semi-title text-dark"></span>
											<div class="dropdown-divider"></div>
										</div>
										<a class="dropdown-item" href="#">
											<i class="dropdown-icon mdi mdi-account-outline "></i> Profile
										</a>
										<a id="logout" class="dropdown-item">
											<i  class="dropdown-icon mdi  mdi-logout-variant"></i> Sign out
										</a>
									</div>
								</div>
							</div>
            <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse"
                data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
            </a>
        </div>
    </div>
</div>
<div class="admin-navbar container-fluid" id="headerMenuCollapse">
    <div class="container-fluid">
        <ul class="nav">

            <?php include 'acl_menu.php'?>
        </ul>
    </div>
</div>

<script src="<?php echo $path_to_root ?>assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="<?php echo $path_to_root ?>assets/js/moment.js"></script>

<script>

$(function () {
	var user_full_name = '<?php echo $user_full_name ?>';
	var user_department = '<?php echo $user_department ?>';

    var rootpath = '<?php echo $path_to_root ?>';

	var now = moment().format("dddd, MMMM Do, YYYY, h:mm:ss A");

	var ndate = new Date();
    var hours = ndate.getHours();
    var greetings = hours < 12 ? ' Good Morning ' : hours < 18 ? ' Good Afternoon ' : ' Good Evening ';

    var section = $('#sys_notification');
    var texts = [
      '<h4 class="text-white h4 heading">'+greetings+  '  <i class="text-primary fa fa-user"></i>'  +user_full_name+ ' <i class="text-green fa fa-primary"></i> Department  '+ user_department+'</h4>', 
      '<h4 class="text-white h4 heading">CHAMU TIFMS</h4>', 
      '<h4 class="text-white h4 heading"><i class="text-primary fa fa-calendar"></i> '+now+'</h4>', ];
    var current = 0;

    function nextNotification() {
        section.html(texts[current = ++current % texts.length]);

        setTimeout(nextNotification, 6000);
    }
    setTimeout(nextNotification, 6000);
    section.html(texts[0]);

    $("#username").html(user_full_name);
    $("#department").html(user_department);
    $("#logout").click(function(e){
        e.preventDefault();
        $.ajax({
            type: "POST",
            data: {
                action: "logout"
            },
            cache: true,
            url: rootpath+"admin/logout.php",
            success: function(data) {
                setTimeout(function() {
                location.reload();
            }, 1000);
            }
        });
    });

}); 
    
</script>

