<?php
$path_to_root = "../";


include $path_to_root.'modules/mailer/sendEmail.php';

include $path_to_root.'database/connection.php';
include $path_to_root.'models/Model.php';

include $path_to_root.'controllers/UserController.php';

$db = new Database();
$conn = $db->getConnection();
$user = new UserController($conn);
$action = isset($_POST['action']) ? $_POST['action'] : '';
$sessionManager = $user->sessionManager;

echo $sessionManager->projectname;

/*
    Examples:
*/

// We get the instance


// Let's display datas
printf( '<p>My name is %s and I\'m %d years old.</p>' , $data->nickname , $data->age );