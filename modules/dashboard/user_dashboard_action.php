<?php
    $path_to_root ="../../";
	header("Access-Control-Allow-Origin: *");
    include_once($path_to_root.'models/Model.php');
    include_once($path_to_root.'database/page_init.php');
    include ($path_to_root.'controllers/UserController.php');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    $db = new Database();
    $conn = $db->getConnection();
    $user = new UserController($conn);
    $tag = isset($_POST['tag']) ? $_POST['tag'] : '';

    
    switch ($tag) {
        case 'totalusers':
            $totalusers = $user->getTotal("users", "user_id", "WHERE is_active = 1")["user_id"];
            $description = "Total Active Users";
            $icon = "mdi mdi-account-multiple-plus";
            $bg_color ="bg-success";
            echo get_card(number_format($totalusers), $description,  $icon, $bg_color);
            break;
        case 'totaInactivelusers':
            $totalusers = $user->getTotal("users", "user_id", "WHERE is_active = 0")["user_id"];
            $description = "Total InActive Users";
            $icon = "mdi mdi-account-alert";
            $bg_color ="bg-dark";
            echo get_card(number_format($totalusers), $description,  $icon, $bg_color);
            break;
        case 'totalDepartments':
            $totalDepartments = $user->getTotal("departments", "department_id", "WHERE is_active = 1")["department_id"];
            $description = "Total Departments";
            $icon = "mdi mdi-account-switch";
            $bg_color = "bg-info";
            echo get_card(number_format($totalDepartments), $description,  $icon, $bg_color);
            break;
        case 'sysNotifications':
            $sysNotifications = $user->getTotal("sys_notifications", "id", "WHERE 1")["id"];
            $description = "Total Notifications";
            $icon = "mdi mdi-alert-circle";
            $bg_color = "bg-danger";
            echo get_card(number_format($sysNotifications), $description,  $icon, $bg_color);
            break;
        case 'logedInToday':
            $usersActiveToday = $user->getTodaysActiveUserList();
            echo get_card_list($usersActiveToday);
        break;
        default:
            # code...
        break;
    }
    

    function get_card($total, $description,  $icon, $bg_color = "bg-success"){
       $output = '
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div class="col-5 p-0">
                        <div class="wrp icon-circle '.$bg_color.'">
                            <i class="'.$icon.' icons"></i>
                        </div>
                    </div>
                    <div class="col-7 p-0">
                        <div class="wrp text-wrapper">
                            <p>'.$total.'</p>
                            <p class="text-dark mt-1 mb-0">'.$description.'</p>
                        </div>
                    </div>
                </div>';
    return $output;
    }
    function get_pie_chart(){
        $output = '
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">3D Pie Chart</h3>
            </div>
            <div class="card-body">
                <div id="highchart3"></div>
            </div>
        </div>
    ';
     return $output;
     }
     function get_card_list($records){
        $html = "";
        $html.= '
        <div class="card">
        <div class="card-header">
            <h3 class="card-title">Users Login Today </h3>
        </div>
        <div class="">
            <div class="table-responsive border-top">
                <table class="table card-table table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th colspan="2">User</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Last Login</th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($records AS $record){
                        $profile = $record["image"];
                        $html.= "<tr>";
                        $html.= "<td>".$record['user_id']."</td>";
                        $html.= "<td><span class='avatar brround ' style='background-image: url(../assets/images/faces/male/$profile)'></span></td>";
                        $html.= "<td>".$record['full_name']."</td>";
                        $html.= "<td>".$record['email']."</td>";
                        $html.= "<td>".$record['role_name']."</td>";
                        $html.= "<td>".$record['last_login']."</td>";
                        $html.= "<td>".$record['department_name']."</td>";
                        $html.= "</tr>";
                    }
                    $html.= '</tbody>
                </table>
            </div>
        </div>
    </div>
    ';
     return $html;
     }



	





