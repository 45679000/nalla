<?php

$DB_HOST = 'localhost:3307';
$DB_HOST_NAME = 'root';
$DB_HOST_PASS = '';
$DB_NAME = 'kampfms';
ini_set('max_execution_time', 0);

$con = mysqli_connect($DB_HOST, $DB_HOST_NAME, $DB_HOST_PASS, $DB_NAME);
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = 'SELECT id,fid, `transaction_date`, ref,`invoice_no`, `invoice_date`, `invoice_amount`, `found`, `description`, `credit`, `sr_amount`, `av_amount`, `kamp_sr`, `kamp_av`, `prisk_sr`, `prisk_av` FROM `upload4` where uploaded=0  order by id ';
$resultr = mysqli_query($con, $sql);

while ($row = mysqli_fetch_array($resultr)) {
 //   print_r(preg_replace('/[^A-Za-z0-9\.]/', '', $row['kamp_sr']));
    $d = $row['transaction_date'];

    if (strpos($d, '/') !== false) {

        $date = createDate($d, "m/d/Y");
    } else {
        $date = $row['transaction_date'];
    }
    
    echo $date."</br>";
    
    if (!is_numeric(preg_replace('/[^A-Za-z0-9\.-]/', '', $row['kamp_sr']))) {
        $sr = 0;
    } else {
        $sr =preg_replace('/[^A-Za-z0-9\.]/', '', $row['kamp_sr']);
    }
    if (!is_numeric(preg_replace('/[^A-Za-z0-9\.-]/', '', $row['kamp_av']))) {
        $av = 0;
    } else {
        $av =preg_replace('/[^A-Za-z0-9\.-]/', '', $row['kamp_av']);
    }

   $res = postKampp($row['fid'], $row['ref'], $row['description'], $date, '', '', '', 0, $date, $sr + $av, $date, $av, $row['description'], $sr, $row['description']);

    $r = json_decode($res, true);
    if (isset($r['Invoice'])) {
        $ree = postPayment($row['fid'], $row['ref'], $date, $sr + $av, $r['Invoice']);
        $cus = $row['id'];
        $rre = json_decode($ree, true);
        //  print_r($rre);
        //  if (isset($rre) && $rre['Success']==' Payment added') {

         $sql3 = "update upload4 set uploaded ='1' where id= " . "'$cus'";
        $result = mysqli_query($con, $sql3);
        // }
    }
}

function createDate($date, $format) {
    $dateObj = \DateTime::createFromFormat($format, $date);
    if (!$dateObj) {
        throw new \UnexpectedValueException("Could not parse the date: " . $date);
    }
    return $dateObj->format("Y-m-d");
}

function postKampp($customer, $ref, $comment, $orderDate, $deliveredto, $deliveryAddres, $contactPhone, $DeliveryCost, $DeliveryDate, $InvoiceTotal, $DueDate, $AVPrice, $AVDesc, $SRPrice, $SRDesc) {
    $curl = curl_init();
    if ($SRPrice > 0 && $AVPrice > 0) {
        $items = "{\"Item\":\"AV\",\"Quantity\":\"1\",\"UnitPrice\":\"$AVPrice\",\"Description\":\"$AVDesc\"},{\"Item\":\"SR\",\"Quantity\":\"1\",\"UnitPrice\":\"$SRPrice\",\"Description\":\"$SRDesc\"}";
    } else if ($SRPrice > 0 && $AVPrice == 0) {
        $items = "{\"Item\":\"SR\",\"Quantity\":\"1\",\"UnitPrice\":\"$SRPrice\",\"Description\":\"$SRDesc\"}";
    } else if ($SRPrice == 0 && $AVPrice > 0) {
        $items = "{\"Item\":\"AV\",\"Quantity\":\"1\",\"UnitPrice\":\"$AVPrice\",\"Description\":\"$AVDesc\"}";
    }
    $json = "[{\"CustId\":\"$customer\",\"RefNo\":\"$ref\",\"comments\":\"$comment\",\"OrderDate\":\"$orderDate\",\"DeliverTo\":\"\",\"DeliveryAddress\":\"\",\"ContactPhoneNo\":\"\",\"DeliveryCost\":\"0\",\"DeliveryDate\":\"$DeliveryDate\",\"InvoiceTotal\":\"$InvoiceTotal\",\"DueDate\":\"$DueDate\",\"items\":[$items]}]";

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://localhost/kamppriskfms/api/endpoints/invoice.php?action=add-invoice&company-id=KAMP",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $json,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic YWRtaW46YWRtaW4=",
            "Content-Type: application/json",
            "Cookie: PHPSESSID=14785d5e51b4c3e69"
        ),
    ));

    $response = curl_exec($curl);
    echo $response;
    curl_close($curl);
    return $response;
}

function postPayment($customer, $ref, $date, $amount, $inv) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://localhost/kamppriskfms/api/endpoints/payment.php?action=make-payment&company-id=KAMP",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "[{\"CustId\":\"$customer\",\"TransactionRef\":\"$ref\",\"TransDate\":\"$date\",\"BankAcct\":\"9\",\"Amount\":\"$amount\",\"Invoice\":\"$inv\"}]",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Basic YWRtaW46YWRtaW4=",
            "Content-Type: application/json",
            "Cookie: PHPSESSID=14785d5e51b4c3e69"
        ),
    ));

    $response = curl_exec($curl);
    $response;
    curl_close($curl);
     $response;
}
