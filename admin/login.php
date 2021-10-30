<?php
session_start();
    $path_to_root ='../';
    include $path_to_root.'modules/user-auth/Users.php';
    include $path_to_root.'modules/mailer/sendEmail.php';
    include $path_to_root.'database/connection.php';

    $db = new Database();
    $conn = $db->getConnection();
    $user = new Users($conn);
    // $sessionExpired = isset($_GET['sessionExpired']) ? $_GET['sessionExpired'] : 'false';
    // $message = '<p>Enter Username And Password</p>';
    // if($sessionExpired=="true"){
    //     $message = '<p class="alert alert-danger" role="alert">Your Session Has Expired Login Again</p>'; 
    // }
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if($action=="login"){
        if($_POST['username'] !=null && $_POST['password']!==null){
            $user->username=$_POST['username'];
            $user->password=md5($_POST['password']);
            $user->authenticateUser();
            if(!$_SESSION["user_id"]){
                 echo json_encode(array("login"=>"fail", "message"=>"Wrong User Name or Password"));
            }else{
                echo json_encode(array("login"=>"success", "message"=>$_SESSION["message"]));
            }
        }
    }

    if($action=="validate_otp"){
        if($_POST['otp'] == $_SESSION['otp']){
            echo json_encode(array("otp"=>"success", "message"=>"redirecting", "role"=>$_SESSION['role_id']));
        }else{
            echo json_encode(array("otp"=>"failed", "message"=>"You have entered a wrong OTP"));
        }
    }
    if((isset($_POST['reset']))){
       // Finally, destroy the session.
        session_destroy();
    }
