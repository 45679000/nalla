<?php
session_start();
session_destroy();

$path_to_root ='../';


?>
<html >
    <head  >
    <link rel="stylesheet" href="<?php echo $path_to_root ?>assets/css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  </head>
<body class="bg">
<div class="container register">
                <div class="row">
                    <div class="col-md-3 register-left">
                        <img class="logo" src="<?php echo $path_to_root ?>images/logo.png" alt=""/>
                        <h3 style="font-weight:bold; color:blue;">CHAMU TIFMS</h3>
                        <p>You Have Been Logged Out</p>
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
                                <p class="register-heading">Good Bye</p>
                                <div class="row register-form">
                                    <div class="col-md-8">
                                     <div class="form-group">
                                                </div>
                                                <div class="col-md-8">
                                                    <?php
                                                    echo' <a href="./login.php">Login Back Again</a>';
                                                    ?>
                                                </div>
                                               
                                            
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

