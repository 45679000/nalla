<?php
    $path_to_root ='../';
    include $path_to_root.'models/Model.php';
    include $path_to_root.'controllers/UserController.php';
    include $path_to_root.'modules/mailer/sendEmail.php';
    include $path_to_root.'database/connection.php';

    $db = new Database();
    $conn = $db->getConnection();
    $user = new UserController($conn);
    $sessionManager = $user->sessionManager;

    $action = isset($_POST['action']) ? $_POST['action'] : '';

    if($action=="login"){
        if($_POST['username'] !=null && $_POST['password']!==null){
            $user->username=$_POST['username'];
            $user->password=md5($_POST['password']);
            $user->authenticateUser();
            
            if(!$sessionManager->user_id){
                 echo json_encode(array("login"=>"fail", "message"=>"Wrong User Name or Password"));
            }else{
                echo json_encode(array("login"=>"success", "message"=>$sessionManager->message));
            }
        }
    }

    if($action=="validate_otp"){
        if($_POST['otp'] == $sessionManager->otp){
            echo json_encode(array("otp"=>"success", "message"=>"redirecting", "role"=>$sessionManager->role_id));
        }else{
            echo json_encode(array("otp"=>"failed", "message"=>"You have entered a wrong OTP"));
        }
    }
    if((isset($_POST['reset']))){
       $sessionManager->destroy();
    }

    if($action == "logout"){
        $sessionManager->destroy();

    }
    if($action == "list-user"){
        $html = "";
        $activeusers = $user->getActiveUserList();
        $html.= '
                <table class="table pt-3 card-table table-striped table-vcenter">
                    <thead class="bg-teal">
                        <tr>
                            <th>Id</th>
                            <th colspan="2">User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Last Login</th>
                            <th>Department</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($activeusers AS $record){
                        $profile = $record["image"];
                        $html.= "<tr>";
                        $html.= "<td>".$record['user_id']."</td>";
                        $html.= "<td><span class='avatar brround ' style='background-image: url(../assets/images/faces/male/$profile)'></span></td>";
                        $html.= "<td>".$record['full_name']."</td>";
                        $html.= "<td>".$record['email']."</td>";
                        $html.= "<td>".$record['role_name']."</td>";
                        $html.= "<td>".$record['last_login']."</td>";
                        $html.= "<td>".$record['department_name']."</td>";
                        $html.= "<td>
                            <i class='fa fa-edit text-success'></i> &nbsp;&nbsp;&nbsp;

                            <i class='fa fa-close text-danger'></i> 

                        </td>";

                        $html.= "</tr>";
                    }
                    $html.= '</tbody>
                </table>
    ';

    echo $html;

    }


    