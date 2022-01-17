<?php
  include '../models/Session.php';
  $sessionManager = Session::getInstance();

?>

<style>
    body {
        color: #000;
        overflow-x: hidden !important;
        /* height: 100%; */

        background-image: linear-gradient(to right, #00c6ff, #95d343);
        background:cover;
    }

    input,
    textarea {
        background-color: #F3E5F5;
        border-radius: 50px !important;
        padding: 12px 15px 12px 15px !important;
        width: 100%;
        box-sizing: border-box;
        border: none !important;
        border: 1px solid #F3E5F5 !important;
        font-size: 16px !important;
        color: #000 !important;
        font-weight: 400
    }

    input:focus,
    textarea:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        border: 1px solid #D500F9 !important;
        outline-width: 0;
        font-weight: 400
    }

    button:focus {
        -moz-box-shadow: none !important;
        -webkit-box-shadow: none !important;
        box-shadow: none !important;
        outline-width: 0
    }

    /* .card {
        border-radius: 0 !important;
        border: none !important;
        margin-top: 11vH;
        margin-bottom: 11vH;
        margin-right: 70vH;
        margin-left: 70vH;
        
    } */

    #logo {
        width: 70px;
        height: 40px
    }

    .heading {
        margin-bottom: 60px !important
    }

    ::placeholder {
        color: #000 !important;
        opacity: 1
    }

    :-ms-input-placeholder {
        color: #000 !important
    }

    ::-ms-input-placeholder {
        color: #000 !important
    }

    .form-control-label {
        font-size: 12px;
        margin-left: 15px
    }

    .msg-info {
        padding-left: 15px;
        margin-bottom: 30px
    }

    .btn-color {
        border-radius: 50px;
        color: #fff;
        background-image: linear-gradient(to right, #FFD54F, #D500F9);
        padding: 15px;
        cursor: pointer;
        border: none !important;
        margin-top: 40px
    }

    .btn-color:hover {
        color: #fff;
        background-image: linear-gradient(to right, #D500F9, #FFD54F)
    }

    .btn-white {
        border-radius: 50px;
        color: #D500F9;
        background-color: #fff;
        padding: 8px 40px;
        cursor: pointer;
        border: 2px solid #D500F9 !important
    }

    .btn-white:hover {
        color: #fff;
        background-image: linear-gradient(to right, #FFD54F, #D500F9)
    }

    a {
        color: #000
    }

    a:hover {
        color: #000
    }

    .bottom {
        width: 100%;
        margin-top: 50px !important
    }

    .sm-text {
        font-size: 15px
    }
</style>

<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>TIFMS</title>
</head>
<div class="container" style="padding-top:5%; padding-right:13%; padding-left:13%;">
    <div class="card justify-content-center h-55">
        <div class="card-header">
            <div class="row justify-content-center px-3 mb-3">
                <img class="logo" src="../images/logo.png" alt="" />
             </div>
        </div>
        <div class="card-body" >
            <div class="row justify-content-center">
                <div class="col-md-10 col-8 mt-5">
                    <h6 class="msg-info">Enter Your Username</h6>
                    <div id="usernameDiv" class="form-group"> <label class="form-control-label text-muted">Username</label>
                        <input type="text" id="username" name="email" placeholder="Username" class="form-control">
                    </div>
                    <div  class="form-group"> <label class="form-control-label text-muted">Enter New Password</label>
                        <input type="password" id="newPassword" name="newpassword" placeholder="New Password" class="form-control">
                    </div>
                    <div id="passwordDiv" class="form-group"> <label class="form-control-label text-muted">Password</label>
                        <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" class="form-control">
                    </div>
                    
                   
                </div>
            </div>            
        </div>
        <div class="card-footer">
        <div class="row justify-content-center my-3 px-3"> 
             <button id="ResetPassword" class="btn-block btn-color">Reset Password</button>
        </div>
        </div>
    </div>
</div>


<script>

$(function () {
  
    $("#ResetPassword").click(function(e){
        e.preventDefault();
        $(".msg-info").html('<div class="spinner-grow text-primary" role="status"> <span class="sr-only">Loading...</span></div><div class="spinner-grow text-secondary" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div>');

        var username = $("#username").val();
        var npassword = $("#newPassword").val();
        var cpassword = $("#confirmPassword").val();
        var error = "";
        var password = "";

        if(npassword.trim()==cpassword.trim()){
            password = npassword;
        }else{
            error = "New Password and Confirm Password Should Match";
        }

        if(error ==""){
            $.ajax({
            type: "POST",
            data: {
                action: "forgot-password",
                username: username,
                password : password
            },
            cache: true,
            url:"user_action.php",
            dataType:"json",
            success: function(data) {
                if(data.success=="1"){
                    $(".msg-info").html('<p class="alert alert-success" role="alert">'+data.response+'</p><a href="./login.php">Go back to login page</a>');
                   
                }else{
                    $(".msg-info").html('<p class="alert alert-danger" role="alert">'+data.response+'</p>');

                }
            }

        });

        }else{
            $(".msg-info").html('<p class="alert alert-danger" role="alert">'+error+'</p>');

        }
 
    });

}); 
</script>


