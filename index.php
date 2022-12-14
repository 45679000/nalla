<?php 
  $path = substr( __DIR__, strlen( $_SERVER[ 'DOCUMENT_ROOT' ]));

  define('project_dir', dirname(__DIR__) . './');
  include 'models/Session.php';

  $sessionManager = Session::getInstance();
  $config = parse_ini_file("config.ini");

  $sessionManager->projectname ="Techsavanna teas";
  $sessionManager->project_root = $path;

  header("location:admin/login.php");
  exit();