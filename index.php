<?php 
  define('project_dir', dirname(__DIR__) . './');
  include 'models/Session.php';

  $sessionManager = Session::getInstance();
  $config = parse_ini_file("config.ini");
  $sessionManager->projectname = $config["projectname"];
  
  header("location:admin/login.php");
  exit();