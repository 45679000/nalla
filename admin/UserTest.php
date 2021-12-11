<?php
$path_to_root = "../";

define ('ROOT_DIR', substr( dirname(dirname(__FILE__)) . '/', strlen( $_SERVER[ 'DOCUMENT_ROOT' ] )));

// $path = substr( __FILE__, strlen( $_SERVER[ 'DOCUMENT_ROOT' ] ) );


include $path_to_root.'modules/mailer/sendEmail.php';
include $path_to_root.'database/connection.php';
include $path_to_root.'models/Model.php';

include $path_to_root.'controllers/UserController.php';

$db = new Database();
$conn = $db->getConnection();
$user = new UserController($conn);
$action = isset($_POST['action']) ? $_POST['action'] : '';
$sessionManager = $user->sessionManager;


echo  ROOT_DIR;

/*
    Examples:
*/

// We get the instance


// Let's display datas


