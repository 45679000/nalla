<?php
    define ('ROOT_DIR', substr( dirname(dirname(__FILE__)) . '/', strlen( $_SERVER[ 'DOCUMENT_ROOT' ] )));

if(!isset($_SESSION["user_id"])){
    header("Location: ". ROOT_DIR ."admin/login.php");
}
?>