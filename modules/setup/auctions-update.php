<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$position = "";
$auction_id = "";
$created_by = "";
$created_on = "";
$is_deleted = "";
$updated_on = "";

$position_err = "";
$auction_id_err = "";
$created_by_err = "";
$created_on_err = "";
$is_deleted_err = "";
$updated_on_err = "";


// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

        // Prepare an update statement
        
        $position = trim($_POST["position"]);
		$auction_id = trim($_POST["auction_id"]);
		$created_by = trim($_POST["created_by"]);
		$created_on = trim($_POST["created_on"]);
		$is_deleted = trim($_POST["is_deleted"]);
		$updated_on = trim($_POST["updated_on"]);
		

        $dsn = "mysql:host=$db_server;dbname=$db_name;charset=utf8mb4";
        $options = [
          PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
          PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
        ];
        try {
          $pdo = new PDO($dsn, $db_user, $db_password, $options);
        } catch (Exception $e) {
          error_log($e->getMessage());
          exit('Something weird happened');
        }
        $stmt = $pdo->prepare("UPDATE auctions SET position=?,auction_id=?,created_by=?,created_on=?,is_deleted=?,updated_on=? WHERE id=?");

        if(!$stmt->execute([ $position,$auction_id,$created_by,$created_on,$is_deleted,$updated_on,$id  ])) {
                echo "Something went wrong. Please try again later.";
                header("location: error.php");
            } else{
                $stmt = null;
                header("location: auctions-read.php?id=$id");
            }
} else {
    // Check existence of id parameter before processing further
	$_GET["id"] = trim($_GET["id"]);
    if(isset($_GET["id"]) && !empty($_GET["id"])){
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM auctions WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Set parameters
            $param_id = $id;

            // Bind variables to the prepared statement as parameters
			if (is_int($param_id)) $__vartype = "i";
			elseif (is_string($param_id)) $__vartype = "s";
			elseif (is_numeric($param_id)) $__vartype = "d";
			else $__vartype = "b"; // blob
			mysqli_stmt_bind_param($stmt, $__vartype, $param_id);

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value

                    $position = $row["position"];
					$auction_id = $row["auction_id"];
					$created_by = $row["created_by"];
					$created_on = $row["created_on"];
					$is_deleted = $row["is_deleted"];
					$updated_on = $row["updated_on"];
					

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }

            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    <section class="pt-5">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">

                        <div class="form-group">
                            <label>num</label>
                            <input type="number" name="position" class="form-control" value="<?php echo $position; ?>">
                            <span class="form-text"><?php echo $position_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>Broker</label>
                            <input type="text" name="auction_id" maxlength="10"class="form-control" value="<?php echo $auction_id; ?>">
                            <span class="form-text"><?php echo $auction_id_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>created_by</label>
                            <input type="number" name="created_by" class="form-control" value="<?php echo $created_by; ?>">
                            <span class="form-text"><?php echo $created_by_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>created_on</label>
                            <input type="text" name="created_on" class="form-control" value="<?php echo $created_on; ?>">
                            <span class="form-text"><?php echo $created_on_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>is_deleted</label>
                            <input type="number" name="is_deleted" class="form-control" value="<?php echo $is_deleted; ?>">
                            <span class="form-text"><?php echo $is_deleted_err; ?></span>
                        </div>
						<div class="form-group">
                            <label>updated_on</label>
                            <input type="text" name="updated_on" class="form-control" value="<?php echo $updated_on; ?>">
                            <span class="form-text"><?php echo $updated_on_err; ?></span>
                        </div>

                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="auctions-index.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
