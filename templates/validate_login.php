<?php
    if(!isset($_SESSION['role_id'])){ //if login in session is not set
        header("location:../views/login.php");
    
    }
?>