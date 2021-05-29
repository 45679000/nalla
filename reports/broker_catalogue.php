<?php 
   
    $path_to_root = "../";
    $path_to_root1 = "../";
    require_once $path_to_root.'templates/header.php';
    include $path_to_root.'models/Model.php';
    require $path_to_root."vendor/autoload.php";
    require_once $path_to_root.'modules/cataloguing/Catalogue.php';
    include '../views/includes/auction_ids.php';

    $broker ="";
    $category = "";
    $auction = "";
    $data = [];
    $catalogue = new Catalogue($conn);
    echo '<pre>';
    if(isset($_POST['filter'])){
        $auction = $_POST['saleno'];
        $broker = $_POST['broker'];
        $category = $_POST['category'];
        $data = $catalogue->closingCatalogue($auction = $_POST['saleno'], $broker = $_POST['broker'], $category = $_POST['category']);
      
    }
 
    $date =date("l jS  F Y");

    function convertDate($dateValue) {    

        $unixDate = ($dateValue - 25569) * 86400;
        return gmdate("Y-m-d", $unixDate);
        'where Y is YYYY, m is MM, and d is DD';
      
      }
      echo '
      <form method="post" class="filter" style="background-color:white; height:200px; overflow: hidden;">
      <div class="row justify-content-center">
          <div class="well">
              <div class="form-group label-floating">
                  <label class="control-label">AUCTION</label>
                  <select id="saleno" name="saleno" class="form-control" ><small>(required)</small>
                      <option disabled="" value="..." selected="">select</option>
                      ';
                      loadAuction();
                      echo '
                  </select>
              </div>
          </div>
          <div class="col-md-2 well">
              <div class="form-group label-floating">
                  <label class="control-label">BROKER</label>
                  <select id="broker" name="broker" class="form-control well" ><small>(required)</small>
                      <option disabled="" value="..." selected="">select</option>
                      <option value="ANGL"> ANGL </option>
                      <option value="ATLC"> ATLC </option>
                      <option value="BICL"> BICL </option>
                      <option value="CENT"> CENT </option>
                      <option value="CTBL"> CTBL </option>
                      <option value="VENS"> VENS </option>
                      <option value="UNTB"> UNTB </option>
                      <option value="TBE"> TBE </option>
                  </select>
              </div>
          </div>
          <div class="col-md-2 well">
              <div class="form-group label-floating">
                  <label class="control-label">CATEGORY</label>
                  <select id="category" name="category" class="form-control well" ><small>(required)</small>
                      <option disabled="" value="..." selected="">select</option>
                      <option value="Main">Main</option>
                      <option value="Sec">Sec</option>
                  </select>
              </div>
          </div>
          <div class="col-md-2 well">
              <button type="submit" name="filter" class="btn btn-primary">View</button>
          </div>
      </div>
  </form>
  
      
      ';
    $html = "<html>
                    <style>
                    table {
                    background-color:white;
                    margin-left:20px;
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
                    .print {
                        background-color: red;
                        color: white;
                        padding: 1em 1.5em;
                        text-decoration: none;
                        text-transform: uppercase;
                      }
                      
                      .print:hover {
                        background-color: #555;
                      }
                      
                      .print:active {
                        background-color: black;
                      }
                      
                      .print:visited {
                        background-color: #ccc;
                      }

                    </style>
                
    ";
    
    $html .= "
    <div>
    <a class='print' href='files/rep.pdf'>Print</a>
    <table>
    <tr>
          <td colspan=100%><h3 style='text-align:center'>".$broker."</h3>
          <h4 style='text-align:left'>".$category."&emsp;&emsp;Auction&emsp;&emsp;".$auction."&emsp;&emsp; Of&emsp;".$date." </h4>
          </td>
     </tr>
     <tr>
        <th>Value</th>
        <th style='max-width: 20px;'>
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
</div>
<table>
</html>
";

    echo '</pre>';
 
   
 echo $html;
 $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'tempDir' => __DIR__ . '/files', 	'default_font' => 'dejavusans']);
 $mpdf->WriteHTML("Failed to Print Check Memory Usage");
 $mpdf->Output('files/rep.pdf', 'F');
    
?>


<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
                
<script>
    var doc = new jsPDF();
    var specialElementHandlers = {
        '#editor': function (element, renderer) {
            return true;
        }
    };

    $('#cmd').click(function () {
        doc.fromHTML($('#content').html(), 15, 15, {
            'width': 170,
                'elementHandlers': specialElementHandlers
        });
        doc.save('sample-file.pdf');
    });

    // This code is collected but useful, click below to jsfiddle link.
</script>

