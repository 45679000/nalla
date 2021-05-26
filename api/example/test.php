<?php

$DB_HOST = 'localhost:3307';
    $DB_HOST_NAME = 'root';
    $DB_HOST_PASS = '';
    $DB_NAME = 'kampfms';

    $con = mysqli_connect($DB_HOST, $DB_HOST_NAME, $DB_HOST_PASS, $DB_NAME);
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
ini_set('max_execution_time', 0);
$sql = 'SELECT found,id FROM `upload` where uploaded=0';
$result = mysqli_query($con, $sql);


while ($row= mysqli_fetch_assoc($result)){
    $cus = $row['found'];
     $id = $row['id'];
    
 
  $ref = str_replace(' ', '', $cus);
  

         //  print_r($pieces[$i]);exit();
    echo $sql = "SELECT debtor_no FROM `0_debtors_master` where REPLACE(debtor_ref, ' ', '')= '".$ref."' or REPLACE(name, ' ', '')= '".$ref."' limit 1"; 
  //exit();
   $r = mysqli_query($con, $sql);
   
   if(mysqli_num_rows($r)>0){
       while ($row= mysqli_fetch_assoc($r)){
             $ref = $row['debtor_no'];
       }
      echo   $sql = "update upload set fid =$ref where id=".$id; 
           $r = mysqli_query($con, $sql);
          // break;
   
   }else{
       echo "not found";
   }
    
    
    
}

//exit();
