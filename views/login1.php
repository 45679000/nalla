<?php
session_start();
    $path_to_root ='../';
    include $path_to_root.'modules/user-auth/Users.php';
    include $path_to_root.'modules/mailer/sendEmail.php';
    include $path_to_root.'database/connection.php';

    $db = new Database();
    $conn = $db->getConnection();
    $user = new Users($conn);
    $sessionExpired = isset($_GET['sessionExpired']) ? $_GET['sessionExpired'] : 'false';
    $message = '<p>Enter Username And Password</p>';
    if($sessionExpired=="true"){
        $message = '<p class="alert alert-danger" role="alert">Your Session Has Expired Login Again</p>'; 
    }

    if(isset($_POST['login'])){
        if($_POST['username'] !=null && $_POST['password']!==null){
            $user->username=$_POST['username'];
            $user->password=md5($_POST['password']);
            $user->authenticateUser();
    
            if(!$_SESSION["user_id"]){
                $message = '<p>Wrong User Name or Password</p>';
            }else{
                $message = '<p class="alert alert-success" role="alert">'.$_SESSION["message"].'</p>';
            }
        }
    }
    if((isset($_POST['otp'])) && isset($_SESSION['otp'])){
        if($_POST['otp_verify'] == $_SESSION['otp']){
            $user->redirectUser($_SESSION['role_id']);    
        }else{
            $message= '<p class="alert alert-danger" role="alert">The OTP you entered is Wrong</p>';
        }
    }
    if((isset($_POST['reset']))){
       // Finally, destroy the session.
        session_destroy();
    }

?>
<html>

<head>
    <link rel="stylesheet" href="<?php echo $path_to_root ?>assets/css/login.css">
    <link rel="stylesheet" href="<?php echo $path_to_root ?>assets/css/boostrap.min.css">
</head>

<body class="bg">
    <div class="container register">
        <div class="row">
            <div class="col-md-3 register-left">
                <img class="logo" src="<?php echo $path_to_root ?>images/logo.png" alt="" />
                <h3 style="font-weight:bold; color:blue;">Techsavanna teas TIFMS</h3>
                <p>Access Limited to authorised user</p>
            </div>
            <div class="col-md-7 register-right">
                <div style="padding-left:12Vh;" id="message"></div>

                <div class="tab-content" id="myTabContent">
                    <form method="post" action="">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row register-form">

                                <div class="col-md-8">
                                    <?php if(!isset($_SESSION["otp"])) 
                                        echo '  <div class="form-group">
                                                    <input type="text" class="form-control" name="username" placeholder="User Name *" value="" />
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" class="form-control" name="password" placeholder="Password *" value="" />
                                                </div>
                                                <div class="col-md-8">
                                                    <input type="submit" name="login" value="Login"/><br/>
                                                </div>
                                                ';
                                            else{
                                        echo '  <div class="form-group">
                                                     <input type="password" class="form-control" name="otp_verify" placeholder="otp *" value="" />
                                                </div> 
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <input type="submit" name="otp" value="Verify"/><br/>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="submit" name="reset" value="Reset"/><br/>
                                                    </div>
                                                 </div>

                                                ';
                                                
                                            }
                                    ?>
                                </div>

                            </div>
                        </div>

                </div>
                </form>
            </div>
        </div>

    </div>
</body>

</html>
<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>

<script>
$message = '<?php echo $message ?>';
$("#message").html($message);
$('.bg').css("background-image", "url(../images/login_background_2.jpeg)"); 
$(function () {
    var body = $('.bg');
    var backgrounds = [
      'url(../images/login_background_3.JPG)', 
      'url(../images/login_background_4.jpeg)',
      'url(../images/login_background_5.jpeg)'];
    var current = 0;

    function nextBackground() {
        body.css(
            'background',
        backgrounds[current = ++current % backgrounds.length]);

        setTimeout(nextBackground, 5000);
    }
    setTimeout(nextBackground, 5000);
    body.css('background', backgrounds[0]);
}); 
</script>