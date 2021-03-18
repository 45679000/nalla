<?php
session_start();
    $path_to_root ='../';
    include $path_to_root.'modules/user-auth/Users.php';
    include $path_to_root.'modules/mailer/sendEmail.php';
    include $path_to_r/'connection.php';

    //check login request
    $db = new Database();
    $conn = $db->getConnection();
    $user = new Users($conn);
    if(isset($_POST['login'])){
        if($_POST['username'] !=null && $_POST['password']!==null){
            $user->username=$_POST['username'];
            $user->password=md5($_POST['password']);
            $user->authenticateUser();
    
            if(!$_SESSION["user_id"]){
                $message = '<p class="alert alert-danger" role="alert">Wrong User Name or Password</p>';
            }else{
                $message = '<p class="alert alert-primary" role="alert">'.$_SESSION["message"].'</p>';
            }
        }
    }
    if(isset($_POST['otp'])){
        if($_POST['otp_verify'] == $_SESSION['otp']){
            $user->redirectUser($_SESSION['role_id']);
            unset($_SESSION['otp']);

        }
    }
    

?>
<html >
    <head  >
    <!-- <link rel="stylesheet" href="<?php echo $path_to_root ?>assets/css/login.css"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  </head>
<body class="bg">
<div class="container register">
                <div class="row">
                    <div class="col-md-3 register-left">
                        <img class="logo" src="<?php echo $path_to_root ?>images/logo.png" alt=""/>
                        <h3 style="font-weight:bold; color:blue;">CHAMU TIFMS</h3>
                        <p>Access Limited to authorised user</p>
                    </div>
                    <div class="col-md-9 register-right">
                        <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Admin</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                        <form method="post" action="">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <p class="register-heading"><?php if($message!= null){echo $message;}else{echo "Enter your Username and Password";}?></p>
                                <div class="row register-form">
                                    <div class="col-md-8">
                                    <?php if($_SESSION["otp"]==null) 
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
                                                     <input type="password" class="form-control" name="otp_verify" placeholder="Password *" value="" />
                                                </div> 
                                                <div class="col-md-8">
                                                     <input type="submit" name="otp" value="Verify"/><br/>
                                                </div>';
                                                
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