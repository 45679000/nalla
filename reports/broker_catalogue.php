<?php 
   
    $path_to_root = "../";
    $path_to_root1 = "../";
    require_once $path_to_root.'templates/header.php';
    include $path_to_root.'models/Model.php';
    require $path_to_root."vendor/autoload.php";
    require_once $path_to_root.'modules/cataloguing/Catalogue.php';
    include $path_to_root1.'database/connection.php';
    include 'Report.php';

    $db = new Database();
    $conn = $db->getConnection();
    $catalogue = new Catalogue($conn);
    echo '<pre>';
    $data = $catalogue->closingCatalogue($auction = "2021-12", $broker = "ANGL", $category = "Main");
    $broker ="ANJELI Limited";
    $category = "Main";
    $auction = "2021-12";
    $date =date("l jS  F Y");

    function convertDate($dateValue) {    

        $unixDate = ($dateValue - 25569) * 86400;
        return gmdate("Y-m-d", $unixDate);
        'where Y is YYYY, m is MM, and d is DD';
      
      }
    $html = "<html>
                    <style>
                    table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    }

                    td {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                    }

                    tr {
                        border-bottom: 2pt solid black;
                      }
                    .grademark{
                        border: 0px;

                    }

                    </style>
                
    ";
    $html .= "<table>
    <tr>
          <td colspan=100%><h3 style='text-align:center'>".$broker."</h3>
          <h4 style='text-align:left'>".$category."&emsp;&emsp;Auction&emsp;&emsp;".$auction."&emsp;&emsp; Of&emsp;".$date." </h4>
          </td>
     </tr>
     <tr>
        <th>Value</th>
        <th style='max-width: 10px;'>
                Max
                Low
         </th>
        <th style='max-width: 10px;'>LotNo</th>
        <th style='max-width: 50px;'>
            Garden
            Grd
        </th>
        <th>Inv.</th>
        <th>Pkgs</th>
        <th>TP</th>
        <th>Kilos</th>
        <th>NW</th>
        <th>RP</th>
        <th>Comment</th>
        <th>Standard</th>
        <th>Sale Price</th>
        <th>Buyer</th>
     </tr>";
     $mark="";
    foreach($data as $key=>$value){
        if($mark != $value['mark']){
            $html.="<tr><td colspan=100%><h3 style='text-align:center'>".$value['mark']."</h3></td></tr>";
            $html.= "<tr>
            <td>".$value['value']."</td>
            <td style='max-width: 10px;'>
                <b style='color:red';>".$catalogue->maxLow($value['mark'], $value['grade'], "2021-13")[0][0]."</b>
                <b style='color:green';>".$catalogue->maxLow($value['mark'], $value['grade'], "2021-13")[1][0]."</b>
            </td>
            <td style='max-width: 100px;'>
                <table style='border:none;';>
                    <tr style='border: none;'><td style='border: none;';>".$value['lot']."</td></tr>
                    <tr style='border: none;'><td style='border: none;';>".$value['ra']."</td></tr>
                </table>
             </td>
            <td style='max-width: 100px;'>
                <table style='border:none;';>
                    <tr style='border: none;'><td style='border: none;';>".$value['mark']."</td></tr>
                    <tr style='border: none;'>
                        <td style='border: none;';>".$value['grade']."</td>
                        <td style='border: none;';>".convertDate($value['manf_date'])."</td>
                    </tr>
                </table>
            </td>
            <td>".$value['invoice']."</td>
            <td>".$value['pkgs']."</td>
            <td>".$value['type']."</td>
            <td>".$value['net']."</td>
            <td>".$value['net']/$value['pkgs']."</td>
            <td>".$value['rp']."</td>
            <td>".$value['comment']."</td>
            <td>".$value['sale_price']."</td>
            <td>".$value['sale_price']."</td>
            <td>".$value['buyer_package']."</td>

            <tr>";
            $mark = $value['mark'];

        }else{
            $html.= "<tr>
            <td>".$value['value']."</td>
            <td style='max-width: 10px;'>
                <b style='color:red';>".$catalogue->maxLow($value['mark'], $value['grade'], "2021-13")[0][0]."</b>
                <b style='color:green';>".$catalogue->maxLow($value['mark'], $value['grade'], "2021-13")[1][0]."</b>
            </td>

             <td style='max-width: 100px;'>
                <table style='border:none;';>
                    <tr style='border: none;'><td style='border: none;';>".$value['lot']."</td></tr>
                    <tr style='border: none;'><td style='border: none;';>".$value['ra']."</td></tr>
                </table>
            </td>
            <td style='max-width: 100px;'>
                <table style='border:none;';>
                    <tr style='border: none;'><td style='border: none;';>".$value['mark']."</td></tr>
                    <tr style='border: none;'>
                        <td style='border: none;';>".$value['grade']."</td>
                        <td style='border: none;';>".convertDate($value['manf_date'])."</td>
                    </tr>
                </table>
             </td>
            <td>".$value['invoice']."</td>
            <td>".$value['pkgs']."</td>
            <td>".$value['type']."</td>
            <td>".$value['net']."</td>
            <td>".$value['net']/$value['pkgs']."</td>
            <td>".$value['rp']."</td>
            <td>".$value['comment']."</td>
            <td>".$value['sale_price']."</td>
            <td>".$value['sale_price']."</td>
            <td>".$value['buyer_package']."</td>
            <tr>";
        }
        
    }
$html.="

<table>
";

    echo '</pre>';
    

   
 echo $html;

    
?>


<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
                
<script type="text/javascript">

$(function() {

    $('select').on('change', function() {
         var saleno = $('#saleno').find(":selected").text();
         var broker = $('#broker').find(":selected").text();
         var category = $('#category').find(":selected").text();
         console.log("ready "+saleno+" broker "+broker+" category "+category);

         if(saleno !=='select' && broker !== 'select' && category !== 'select'){

            var formData = {
                saleno: saleno,
                broker: broker,
                category: category,
            };

          $.ajax({
                type: "POST",
                dataType: "html",
                url: "rep_broker_catalogue.php",
                data: formData,
            success: function (data) {
                console.log('Submission was successful.');
                location.reload();
                console.log(data);
            },
            error: function (data) {
                console.log('An error occurred.');
                console.log(data);
            },
        });

    }

    });

    



    
});
    
</script>
