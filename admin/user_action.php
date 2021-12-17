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
                            <th>Reset Password</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($activeusers AS $record){
                        $id = $record['user_id'];
                        $profile = $record["image"];
                        $html.= "<tr id=".$id.">";
                        $html.= "<td>".$record['user_id']."</td>";
                        $html.= "<td><span class='avatar brround ' style='background-image: url($profile)'></span></td>";
                        $html.= "<td>".$record['full_name']."</td>";
                        $html.= "<td>".$record['email']."</td>";
                        $html.= "<td>".$record['role_name']."</td>";
                        $html.= "<td>".$record['last_login']."</td>";
                        $html.= "<td>".$record['department_name']."</td>";
                        $html.= "<td><a class='fa fa-spinner text-info btn btn-success btn-sm password'>Generate</a></td>";

                        $html.= "<td>
                            <i class='fa fa-edit text-success editBtn'></i> &nbsp;&nbsp;&nbsp;

                            <i class='fa fa-close text-danger'></i> &nbsp;&nbsp;&nbsp;

                        </td>";

                        $html.= "</tr>";
                    }
                    $html.= '</tbody>
                </table>
    ';
    echo $html;

    }
    if($action == "create-user"){
   
        if($_FILES['image']['name']){
 
            move_uploaded_file($_FILES['image']['tmp_name'], "../images/profile/".$_FILES['image']['name']);
         
            $img = "../images/profile/".$_FILES['image']['name'];
            $_POST['image'] = $img;

        }
        unset($_POST['action']);
        $plainPassword = $user->generatePassword($length = 5);
        $passwordEncrypt = md5($plainPassword);
        $_POST['password'] = $passwordEncrypt;
        $_POST['user_name'] = $_POST['email'];
        if($_FILES['image']['name'] == null && $_POST["user_id"] != null){
            $id = $_POST["user_id"];
            $user->tablename = "users";
            $record = $user->selectOne($id, "user_id");
            $_POST['image'] = $record[0]["image"];

        }
        if($_POST["user_id"] == null){
                $mailer = new Mailer("<p>User Name: ".$_POST['email'] ."</p> Password:".$plainPassword, "", "Login Credentials");
                $is_sent = $mailer->sendEmail($_POST['email']);
            
        }
        $user->addUser($_POST);

    }
    if($action == "get-user"){
        $id = $_POST["id"];
        $user->tablename = "users";
        echo json_encode($user->selectOne($id, "user_id"));

    }
    if($action == "reset-password"){
        $id = $_POST["id"];
        $password = isset($_POST["password"]) ? $_POST["password"] : $user->generatePassword();
        $user->resetPassword($password, $id);

    }
    if($action == "list-departments"){
        $html = "";
        $departments = $user->getActiveDepartments();
        $html.= '
                <table class="table pt-3 card-table table-striped table-vcenter">
                    <thead class="bg-teal">
                        <tr>
                            <th>Id</th>
                            <th>Department Name</th>
                            <th>Department Leader</th>
                           
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($departments AS $record){
                        $id = $record['department_id'];
                        $html.= "<tr id=".$id.">";
                        $html.= "<td>".$record['department_id']."</td>";
                        $html.= "<td>".$record['department_name']."</td>";
                        $html.= "<td>".$record['full_name']."</td>";
                        $html.= "</tr>";
                    }
                    $html.= '</tbody>
                </table>
    ';
    echo $html;

    }


    


    