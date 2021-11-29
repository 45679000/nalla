<?php
session_start();
error_reporting(1);
$path_to_root = "../../";
include('../../database/page_init.php');


if (isset($_GET['del']) && isset($_GET['name'])) {
	$id = $_GET['del'];
	$name = $_GET['name'];

	$sql = "delete from users WHERE user_id=:id";
	$query = $conn->prepare($sql);
	$query->bindParam(':id', $id, PDO::PARAM_STR);
	$query->execute();

	$sql2 = "insert into deleteduser (email) values (:name)";
	$query2 = $conn->prepare($sql2);
	$query2->bindParam(':name', $name, PDO::PARAM_STR);
	$query2->execute();

	$msg = "Data Deleted successfully";
}

if (isset($_REQUEST['unconfirm'])) {
	$aeid = intval($_GET['unconfirm']);
	$memstatus = 1;
	$sql = "UPDATE users SET is_active=:is_active WHERE  user_id=:aeid";
	$query = $conn->prepare($sql);
	$query->bindParam(':is_active', $memstatus, PDO::PARAM_STR);
	$query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
	$query->execute();
	$msg = "Changes Sucessfully";
}

if (isset($_REQUEST['confirm'])) {
	$aeid = intval($_GET['confirm']);
	$memstatus = 0;
	$sql = "UPDATE users SET is_active=:is_active WHERE  user_id=:aeid";
	$query = $conn->prepare($sql);
	$query->bindParam(':is_active', $memstatus, PDO::PARAM_STR);
	$query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
	$query->execute();
	$msg = "Changes Sucessfully";
}





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

	<title>Manage Users</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
	<style>
		.errorWrap {
			padding: 10px;
			margin: 0 0 20px 0;
			background: #dd3d36;
			color: #fff;
			-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
		}

		.succWrap {
			padding: 10px;
			margin: 0 0 20px 0;
			background: #5cb85c;
			color: #fff;
			-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
		}
	</style>

</head>

<body>
	<?php include($path_to_root . 'templates/header.php'); ?>
	<div class="ts-main-content">
		<div class="col-md-12">
			<h2 class="page-title">Manage Users</h2>
			<!-- Zero Configuration Table -->
			<div class="panel panel-default">
				<div class="panel-heading">List Users</div>
				<div class="panel-body">
					<?php if ($error) { ?><div class="errorWrap" id="msgshow"><?php echo htmlentities($error); ?> 
					</div>
					<?php } else if 
					($msg) { ?>
					<div class="succWrap" id="msgshow"><?php echo htmlentities($msg); ?> 
				</div><?php } ?>
					<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>#</th>
								<th>Username</th>
								<th>Name</th>
								<th>Email</th>
								<th>Gender</th>
								<th>Phone</th>
								<th>Department</th>
								<th>Account</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>

							<?php $sql = "SELECT user_id, user_name, full_name, email, gender, last_login, is_active, image, mobile, departments.department_name FROM `users` 
										  INNER JOIN departments ON CONCAT(0,departments.department_id) =  users.department_id
										  ORDER BY `full_name` ASC ";
							$query = $conn->prepare($sql);
							$query->execute();
							$results = $query->fetchAll(PDO::FETCH_OBJ);
							$cnt = 1;
							if ($query->rowCount() > 0) {
								foreach ($results as $result) {				?>
									<tr>
										<td><?php echo htmlentities($cnt); ?></td>
										<td><?php echo htmlentities($result->user_name); ?></td>
										<td><?php echo htmlentities($result->full_name); ?></td>
										<td><?php echo htmlentities($result->email); ?></td>
										<td><?php echo htmlentities($result->gender); ?></td>
										<td><?php echo htmlentities($result->mobile); ?></td>
										<td><?php echo htmlentities($result->department_name); ?>
										<td>

											<?php if ($result->is_active == 1) { ?>
												<a href="./index.php?view=users&confirm=<?php echo htmlentities($result->user_id); ?>" onclick="return confirm('Do you really want to Un-Confirm the Account')">Active <i class="fa fa-check-circle"></i></a>
											<?php } else { ?>
												<a href="./index.php?view=users&unconfirm=<?php echo htmlentities($result->user_id); ?>" onclick="return confirm('Do you really want to Confirm the Account')">Deactivated <i class="fa fa-times-circle"></i></a>
											<?php } ?>
										</td>
										</td>

										<td>
											<a href="./index.php?view=users&edit=<?php echo $result->user_id; ?>" onclick="return confirm('Do you want to Edit');">&nbsp; <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
											<a href="./index.php?view=users&del=<?php echo $result->user_id; ?>&name=<?php echo htmlentities($result->email); ?>" onclick="return confirm('Do you want to Delete');"><i class="fa fa-trash" style="color:red"></i></a>&nbsp;&nbsp;
										</td>
									</tr>
							<?php $cnt = $cnt + 1;
								}
							} ?>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			setTimeout(function() {
				$('.succWrap').slideUp("slow");
			}, 3000);
		});
	</script>

</body>

</html>