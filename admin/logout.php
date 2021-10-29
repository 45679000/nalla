<?php
  session_start();
  $action = isset($_POST['action']) ? $_POST['action'] :'';
  if($action=="logout"){
    $_SESSION = array();
    echo json_encode(array("logout"=>"success"));
  }

  ?>