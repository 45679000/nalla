<?php
$path_to_root = "../../";
include $path_to_root . 'templates/header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.22/datatables.min.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
</head>
<body>
    <div class="page-header">
       
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <div class="card">
                    <div class="expanel expanel-primary">
                        <div class="expanel-heading">
                            <h3 class="expanel-title">System Settings</h3>
                        </div>
                        <div class="expanel-body">
                            <div class="list-group list-group-transparent mb-0 mail-inbox">
                                <a href="./index.php?view=gardens" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-send"></i></span>Gardens
                                </a>
                                <a href="./index.php?view=brokers" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-send"></i></span>Brokers
                                </a>
                                <a href="./index.php?view=codes" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-send"></i></span>Grading Codes
                                </a>
                                <a href="./index.php?view=standards" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-send"></i></span>Tea Standards
                                </a>
                                <a href="./index.php?view=grades" class="list-group-item list-group-item-action d-flex align-items-center">
                                    <span class="icon mr-3"><i class="fe fe-send"></i></span>Tea Grades
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <?php 
                    if(isset($_GET['view'])){
                        $view=$_GET['view'];

                        switch($view){
                            case 'gardens':
                                include('views/gardens.php');
                                break;

                            case 'brokers':
                                include('views/brokers.php');
                                break;

                            case 'codes':
                                include('views/grading_codes.php');
                                break;

                            case 'standards':
                                include('views/grading_standards.php');
                                break;

                            case 'grades':
                                include('views/grades.php');
                                break;
                            
                            default:
                            include('views/gardens.php');

                        }
                            
                    }
                
                ?>
            </div>
        </div>
    </div>


    
</body>

</html>