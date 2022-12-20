<?php
  include '../models/Session.php';
  $sessionManager = Session::getInstance();

?>

<style>
    body {
        padding: 0px;
        margin: 0px;
        box-sizing: border-box;
        height: 100%;
        width: 100%;
    }

    input,
    textarea {
        background-color: #F3E5F5;
        border-radius: 10px !important;
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

    .card {
        border-radius: 0 !important;
        border: none !important;
    }

    .card1 {
        width: 50%;
        /* padding: 40px 30px 10px 30px !important; */
    }

    .card2 {
        width: 50%;
        background-image: linear-gradient(to left, #00c6ff, #95d343);
        background-image: url("../images/login_background_3.JPG");

        /* background-image: linear-gradient(to right, #FFD54F, #D500F9) */
    }

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
        border-radius: 10px;
        color: black;
        /* background-image: linear-gradient(to right, #FFD54F, #D500F9); */
        padding: 15px;
        cursor: pointer;
        border: none !important;
        margin-top: 40px
    }

    .btn-color:hover {
        color: #fff;
        /* background-image: linear-gradient(to right, #D500F9, #FFD54F) */
    }

    .btn-white {
        border-radius: 10px;
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
    .login-wrap {
        color: #000;
        overflow-x: hidden !important;
        height: 100%;
        background-image: url('../assets/images/back-image.jpg');
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
    }
    .logo {
        height: 100px;
        width: 100px;
        background-image: url('https://cdn.shopify.com/s/files/1/0570/7150/1496/files/Footer_Logo_2x_45ab59d1-1213-4b2d-9e0f-824392d709e2_x120@2x.png?v=1621937858');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
    .login-card {
        background-color: black;
        /* filter: brightness(95%); */
        opacity: 0.9;
        color: #fff !important;
    }
    @media screen and (max-width: 992px) {
        .card1 {
            width: 100%;
            padding: 40px 30px 10px 30px
        }

        .card2 {
            width: 100%;
            display: none !important;
        }

        .right {
            margin-top: 100px !important;
            margin-bottom: 100px !important
        }
    }

    @media screen and (max-width: 768px) {
        .container {
            padding: 10px !important;
        }

        .card2 {
            padding: 50px
        }

        .right {
            margin-top: 50px !important;
            margin-bottom: 50px !important
        }
    }
</style>

<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>TIFMS</title>
</head>
<div class="col-12 row login-wrap">
    <div class="col-md-4 col-10 my-auto login-card ml-5">
        <div class="justify-content-center my-auto pt-3">
            <div class="logo mx-auto"></div>
            <div class="col-10 mt-2 mx-auto">
                <div class="row justify-content-center mb-3">
                    <!-- <img class="logo" src="../images/logo.png" alt="" /> -->
                </div>
                <h6 class="msg-info">Enter Your Username and Password To login</h6>
                <div id="usernameDiv" class="form-group"> <label class="form-control-label text-muted">Username</label>
                    <input type="text" id="username" name="email" placeholder="Username" class="form-control">
                </div>
                <div id="passwordDiv" class="form-group"> <label class="form-control-label text-muted">Password</label>
                    <input type="password" id="password" name="psw" placeholder="Password" class="form-control">
                </div>
                <p class="text-center">Forgot password?<a href="./forgot_password.php">Reset</a></p>
                <div id="otpDiv" style="display:none" class="form-group"> <label class="form-control-label text-muted">OTP</label>
                    <input type="password" id="otp" name="verification_code" placeholder="OTP" class="form-control">
                </div>
                <div class="row justify-content-center mt-3 mb-5 px-3"> 
                    <button id="loginBtn" class="btn-block btn-color">Login</button>
                    <button style="display:none" id="verify" class="btn-block btn-color">Verify</button>

                    </div>
            </div>
        </div>
        <!-- <div class="bottom text-center mb-5">
            <p href="#" class="sm-text mx-auto mb-3">Don't have an account?<button class="btn btn-white ml-2">Create new</button></p> 
        </div> -->
    </div>
</div>


<script>

$(function () {
  
    var txt = 'Bringing Automation To The Tea industry';
    var speed = 50;

    typeWriter(txt, speed);

    
    $("#loginBtn").click(function(e){
        e.preventDefault();
        $(".msg-info").html('<div class="spinner-grow text-primary" role="status"> <span class="sr-only">Loading...</span></div><div class="spinner-grow text-secondary" role="status"><span class="sr-only">Loading...</span></div><div class="spinner-grow text-success" role="status"><span class="sr-only">Loading...</span></div>');

        var username = $("#username").val();
        var password = $("#password").val();

        $.ajax({
            type: "POST",
            data: {
                action: "login",
                username: username,
                password : password
            },
            cache: true,
            url:"user_action.php",
            dataType:"json",
            success: function(data) {
                if(data.login=="success"){
                    $(".msg-info").html('<p class="alert alert-success" role="alert">'+data.message+'</p>');
                    window.location.href = "./dashboard.php";
                    // $("#loginBtn").hide();
                    // $("#usernameDiv").hide();
                    // $("#passwordDiv").hide();
                    // $("#otpDiv").show();
                    // $("#verify").show();

                }else{
                    $(".msg-info").html('<p class="alert alert-danger" role="alert">'+data.message+'</p>');

                }
            }

        });
    });
    $("#verify").click(function(e){
        e.preventDefault();
        var otp = $("#otp").val();
        $.ajax({
            type: "POST",
            data: {
                action: "validate_otp",
                otp: otp
            },
            cache: false,
            url:"user_action.php",
            dataType:"json",
            success: function(data) {
                if(data.otp=="success"){
                    window.location.href = "./dashboard.php";

                }else{
                    $(".msg-info").html('<p class="alert alert-danger" role="alert">'+data.message+'</p>');

                }
            }, 
            error: function(data){

            }

        });
    });
}); 
</script>

<script>
    function typeWriter(i, txt, speed) {
        var i = 0;
        if (i < txt.length) {
            document.getElementById("advrt").innerHTML += txt.charAt(i);
            i++;
            setTimeout(typeWriter, speed);
        }
    }
</script>

