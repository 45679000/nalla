<?php 
ob_start();//Enables Output Buffering

    $path_to_root = "../";
    $path_to_root1 = "../";
    // require_once $path_to_root.'templates/header.php';
    include $path_to_root.'models/Model.php';
    require $path_to_root."vendor/autoload.php";
    include $path_to_root.'modules/cataloguing/Catalogue.php';
    // include '../views/includes/auction_ids.php';
    include $path_to_root1.'database/connection2.php';
    
    $broker ="";
    $category = "";
    $auction = "";
    $data = [];

    $db2 = new Database2();
    $conn2 = $db2->getConnection2();

    $catalogue = new Catalogue($conn2);
    $import_date ="";

    // $auction = $_POST['saleno'];
    // $broker = $_POST['broker'];
    // $category = $_POST['category'];
    // $data = $catalogue->closingCatalogue($auction = '2021-12', $broker = 'ANJL', $category = 'Main');
    // $import_date = $catalogue->catalogueDate('2021-12')[0]['import_date'];
    // $import_date = date_format(date_create($import_date),"l jS  F Y");

  
    if(isset($_POST['filter'])){
        $auction = trim($_POST['saleno']);
        $broker = trim($_POST['broker']);
        $category = trim($_POST['category']);
        $data = $catalogue->closingCatalogue($auction, $broker, $category);

        $import_date = $catalogue->catalogueDate($auction)[0]['import_date'];
        $import_date = date_format(date_create($import_date),"l jS  F Y");
        $max = 170;
        $min = 180;


        $print = print_catalogue($data, $broker, $auction, $max, $min, $category, $import_date);
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'tempDir' => __DIR__ . '/files', 	'default_font' => 'dejavusans']);
        $mpdf->debug = true;
        $mpdf->shrink_tables_to_fit=0;
        $mpdf->WriteHTML($print);
        $mpdf->Output('files/rep.pdf', \Mpdf\Output\Destination::FILE);

    }   
 
    $date =date("l jS  F Y");

function convertDate($dateValue) {    

        $unixDate = ($dateValue - 25569) * 86400;
        return gmdate("Y-m-d", $unixDate);
        'where Y is YYYY, m is MM, and d is DD';
      
      }
function print_catalogue($data,  $broker, $auct, $maximum, $minmum, $cat, $impd){
  $mark="34";
    $html = "
    <html>
      <style>
          table {
          background-color:white;
          margin-left:12px;
          font-family: arial, sans-serif;
          font-size:10px;
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
            .body{
              font-size:40px;
            }

      </style>
      <body>
      <div>
   
      <p>
        <h4>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;".$broker."       ".$cat."&emsp;&emsp;Auction&emsp;&emsp;".$auct."</h4>
        <h4 style='text-align:left'>"."&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;".$impd." </h4>
      </p>
      </div>
      <table autosize='2.4'>
        <tr>
          <th style='max-width: 25px;'>Value</th>
          <th style='max-width: 20px;'>
              <table style='border: none; padding:0px;'>
              <tr>
                <td style='border: none;'>
                <b style='color:red';>Max</b>
                </td>
              </tr>
              <tr>
                <td style='border: none;'>
                <b style='color:green';>Low</b>
                </td>
              </tr>
            </table>
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
     foreach($data as $key=>$value){
         if($mark != $value['mark']){
             $html.="
             <tr>
                <td style='border-right: none;'></td>
                <td style='border-right: none;'></td>
                <td></td>
                <td style='text-align:left';>
                  <div style='position:relative; margin-left:50px;'>
                    <h3>".$value['mark']."</h3>
                  </div>
                </td> 
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>     
             </tr>";
             $html.= "<tr>
             <td>".$value['value']."</td>
             <td style='max-width: 10px;'>
                  <table style='border: none; padding:0px;'>
                    <tr>
                      <td style='border: none;'>
                      <b style='color:red';>".$maximum."</b>
                      </td>
                    </tr>
                    <tr>
                      <td style='border: none;'>
                      <b style='color:green';>".$minmum."</b>
                      </td>
                    </tr>
                  </table>
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
                         <td style='border: none;';>".$value['manf_date']."</td>
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
             <table style='border: none; padding:0px;'>
               <tr>
                 <td style='border: none;'>
                 <b style='color:red';>".$maximum."</b>
                 </td>
               </tr>
               <tr>
                 <td style='border: none;'>
                 <b style='color:green';>".$minmum."</b>
                 </td>
               </tr>
             </table>
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
                         <td style='border: none;';>".$value['manf_date']."</td>
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
      </table>
      </body>
    </html>
";
return $html;
}?>
<div class="col-md-8 col-lg-10">
    <div class="card">
        <div class="card-body p-6">
            <div class="col-md-12">
                <div class="expanel expanel-secondary">
                <?php
                        echo '<div class="expanel-heading">
                                    <h3 class="expanel-title">Print Catalogue</h3>
                                </div>
                                <div class="expanel-body">
                                    <form method="post" action="./index?rep=broker-catalog">
                                        <div class="row justify-content-center">
                                            <div class="col-md-3 well">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">AUCTION</label>
                                                    <select id="saleno" name="saleno" class="form-control" ><small>(required)</small>
                                                        <option disabled="" value="..." selected="">select</option>
                                                        <option value="2021-01"> 2021-01 </option>
                                                        <option value="2021-02"> 2021-02 </option>
                                                        <option value="2021-03"> 2021-03 </option>
                                                        <option value="2021-04"> 2021-04 </option>
                                                        <option value="2021-05"> 2021-05 </option>
                                                        <option value="2021-06"> 2021-06 </option>
                                                        <option value="2021-07"> 2021-07 </option>
                                                        <option value="2021-08"> 2021-08 </option>
                                                        <option value="2021-09"> 2021-09 </option>
                                                        <option value="2021-10"> 2021-10 </option>
                                                        <option value="2021-11"> 2021-11 </option>
                                                        <option value="2021-12"> 2021-12 </option>
                                                        <option value="2021-15"> 2021-15 </option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 well">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">BROKER</label>
                                                    <select id="broker" name="broker" class="form-control well" ><small>(required)</small>
                                                        <option disabled="" value="..." selected="">select</option>
                                                        <option value="ANJL"> ANJL </option>
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
                                            <div class="col-md-3 well">
                                                <div class="form-group label-floating">
                                                    <label class="control-label">CATEGORY</label>
                                                    <select id="category" name="category" class="form-control well" ><small>(required)</small>
                                                        <option disabled="" value="..." selected="">select</option>
                                                        <option value="Main">Main</option>
                                                        <option value="Sec">Sec</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 well">
                                                <button class="btn-btn success">Generate</button>
                                            </div>
                                        </div>
                                    </form>
                                    <iframe src="files/rep.pdf" width="100%" height="800px">
                                    </iframe>
                                </div>';
                ?>
                </div>   
            </div>
            
        </div>
    </div>
</div>
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
                filter:'filter',

            };

          $.ajax({
                type: "POST",
                dataType: "html",
                url: "rep_broker.php",
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