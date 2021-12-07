

<body class="">
    <div class="page">
        <div class="page-main">
            <div class="my-1 my-md-1">
                <div class="container-fluid">
                    <div class="row row-cards">
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="card widgets-cards" id="totalusers">
                            </div>
                        </div> 
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="card widgets-cards" id="totaInactivelusers">
                            </div>
                        </div> 
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="card widgets-cards" id="totalDepartments">
                            </div>
                        </div> 
                        <div class="col-sm-12 col-md-6 col-lg-3">
                            <div class="card widgets-cards" id="sysNotifications">
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-12" id="logedInToday">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to top -->
    <a href="#top" id="back-to-top" style="display: inline;"><i class="fa fa-angle-up"></i></a>
</body>

<script type="text/javascript">
    $(document).ready(function() {
		appendCard("totalusers", "../modules/dashboard/user_dashboard_action.php");
        appendCard("totaInactivelusers", "../modules/dashboard/user_dashboard_action.php");
        appendCard("totalDepartments", "../modules/dashboard/user_dashboard_action.php");
        appendCard("sysNotifications", "../modules/dashboard/user_dashboard_action.php");
        appendCard("logedInToday", "../modules/dashboard/user_dashboard_action.php");




		function appendCard(id, url){
			$.ajax({
				type: "POST",
				data: {
					tag: id
				},
				cache: true,
				url: url,
				success: function (data) {
					$("#"+id).html(data);
				}
			});
		}
		
        
    });
</script>
</html>

</html>