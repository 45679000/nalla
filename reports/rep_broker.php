<?php 
ob_start();//Enables Output Buffering

    $path_to_root = "../";
    $path_to_root1 = "../";
    // require_once $path_to_root.'templates/header.php';
    include $path_to_root.'models/Model.php';
    require $path_to_root."vendor/autoload.php";
    include $path_to_root.'modules/cataloguing/Catalogue.php';
    include $path_to_root1.'database/connection2.php';
    ini_set("pcre.backtrack_limit", "5000000");
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
        $mpdf = new \Mpdf\Mpdf(['orientation' => 'P', 'tempDir' => __DIR__ . 'files', 	'default_font' => 'dejavusans']);
        $mpdf->debug = true;
        $mpdf->shrink_tables_to_fit=0;
        $mpdf->WriteHTML($print);
        $mpdf->Output('files/rep.pdf', \Mpdf\Output\Destination::FILE);

    }   echo '
            <iframe frameBorder="0" src="files/rep.pdf" width="100%" height="800px">
            </iframe>
      ';
 
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
          font-family: arial, sans-serif;
          font-size:15px;
          border: 1px solid #000000;
          border-collapse: collapse;
          width: 100%;
          }

          td {
          border-bottom: 1px solid #000000;
          text-align: left;
          padding: 2px;
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
              font-size:60px;
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
          <th>
              Garden
              Grd
              Inv.
          </th>
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
                <td></td>
                <td></td>
                <td></td>
                <td style='text-align:right';>
                <div style='text-align:right';>
                    <h3>".$value['mark']."</h3>
                </div>
              </td>
                <td>
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
             </tr>";
             $html.= "<tr>
             <td style='border-right: 1px solid #000000;'>".$value['value']."</td>
             <td style='border-right: 1px solid #000000;'>
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
             <td style='border-right: 1px solid #000000;'>
                 <table style='border:none;';>
                     <tr style='border: none;'><td style='border: none;';><b>".$value['lot']."</b></td></tr>
                     <tr style='border: none;'><td style='border: none;';<b>>".$value['ra']."</b></td></tr>
                 </table>
              </td>
             <td style='border-right: 1px solid #000000;'>
               <table style='border:none;';>
                     <tr style='border: none;'><td style='border: none;';><b>".$value['mark']."</b></td></tr>
                      <tr style='border: none;'>
                      <td style='border: none;';><b>".$value['grade']."</b></td>
                      <td style='border: none;';><b>".$value['manf_date']."</b></td>
                      <td style='border-right: 1px solid #000000;'><b>".$value['invoice']."</b></td>
                    </tr>
                 </table>
             </td>
            
             <td style='border-right: 1px solid #000000;'>".$value['pkgs']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['type']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['net']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['net']/$value['pkgs']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['rp']."</td>
             <td style='border-right: 1px solid #000000;width:100px;'>".$value['comment']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['sale_price']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['sale_price']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['buyer_package']."</td>
 
             <tr>";
             $mark = $value['mark'];
 
         }else{
             $html.= "<tr>
             <td style='border-right: 1px solid #000000;'>".$value['value']."</td>
             <td style='border-right: 1px solid #000000;'>
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
 
              <td style='border-right: 1px solid #000000;'>
                 <table style='border:none;';>
                     <tr style='border: none;'><td style='border: none;';><b>".$value['lot']."</b></td></tr>
                     <tr style='border: none;'><td style='border: none;';><b>".$value['ra']."</b></td></tr>
                 </table>
             </td>
             <td style='border-right: 1px solid #000000;'>
                 <table style='border:none;';>
                     <tr style='border: none;'><td style='border: none;';><b>".$value['mark']."</b></td></tr>
                     <tr style='border: none;'>
                         <td style='border: none;';><b>".$value['grade']."</b></td>
                         <td style='border: none;';><b>".$value['manf_date']."</b></td>
                         <td style='border-right: 1px solid #000000;'><b>".$value['invoice']."</b></td>
                     </tr>
                 </table>
              </td>
             
             <td style='border-right: 1px solid #000000;'>".$value['pkgs']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['type']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['net']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['net']/$value['pkgs']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['rp']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['comment']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['sale_price']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['sale_price']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['buyer_package']."</td>
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
           
                </div>   
            </div>
            
        </div>
    </div>
</div>
       