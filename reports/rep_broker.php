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
    // error_reporting(0); 
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
        $brokerName = $data[0]['name'];

        $import_date = date_format(date_create($import_date),"l jS  F Y");
        $max = 170;
        $min = 180;


        $print = print_catalogue($data, $broker, $auction, $max, $min, $category, $import_date, $conn2);
        $mpdf = new \Mpdf\Mpdf([
          'orientation' => 'P',
          'format' => 'A4', 
          'setAutoTopMargin' => 'stretch',
          'autoMarginPadding' => 0,
          'tempDir' => __DIR__ . 'files', 
          'default_font' => 'dejavusans']);
          $mpdf->SetHTMLFooter('<div style="text-align: center">{PAGENO} of {nbpg}</div>');
          $mpdf->useSubstitutions = false;
          $mpdf->SetHTMLHeader("
          <div>
          <div style='text-align:center; margin:auto;'><h6>".$brokerName."</h6></div>
          <div style='text-align:center; margin:auto;'><h6>".$category."  AUCTION OF  ".$auction."  ".$import_date."</h6></div>
        </div>
        ");
        $mpdf->shrink_tables_to_fit=0;
        $mpdf->WriteHTML($print);
        $mpdf->Output('files/rep.pdf', \Mpdf\Output\Destination::FILE);

    }   echo '
            <iframe frameBorder="0" src="files/rep.pdf" width="100%" height="800px">
            </iframe>
      ';
 
    $date =date("l jS  F Y");


function print_catalogue($data,  $broker, $auct, $maximum, $minmum, $cat, $impd, $conn2){
  function convertDate($dateValue) {    
    if(is_numeric($dateValue)==1){
      $unixDate = ($dateValue - 25569) * 86400;
      return gmdate("Y-m-d", $unixDate);
      'where Y is YYYY, m is MM, and d is DD';
    }
    
  }
  $brokerName = "";
  if(sizeOf($data)>1){
    $brokerName = $data[0]['name'];
  }
  $catalogue = new Catalogue($conn2);
  $html="No records Found";
 
  $mark="34";
    $html = "
    <html>
      <style>
          table {
          background-color:white;
          font-size:12px;
          border: 1px solid #000000;
          border-collapse: collapse;
          width: 100%;
          }

          td {
          border-bottom: 1px solid #000000;
          text-align: left;
          padding-bottom: 2px;
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
    
      <table autosize='2.4'>
        <tr>
          <td style='max-width: 25px;'>Value</td>
          <td style='max-width: 20px;'>
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
          </td>
          <td style='max-width: 10px;'>LotNo</td>
          <td>
              Garden
              Grd
              Inv.
          </td>
          <td>Pkgs</td>
          <td>TP</td>
          <td>Kilos</td>
          <td>NW</td>
          <td>RP</td>
          <td style='padding-left:20px;'>Comment</td>
          <td style='padding-left:20px;'>Standard</td>
          <td style='padding-left:10px;'>Sale Price</td>
          <td>Buyer</td>
     </tr>";
     foreach($data as $key=>$value){
       $rp = "";
       if($value['kgs'] != ($value['net']/$value['pkgs'])){
        $rp = "R";
       }
         if($mark != $value['mark']){
             $html.="
             <tr>
                <td></td>
                <td></td>
                <td></td>
                <td style='text-align:right';>
                <div style='text-align:right; padding-bottom:5px;'>
                    <h3 style='height:115px;'>".$value['mark']."</h3>
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
                      <b style='color:red';>".$catalogue->maxLow($value['mark'], $value['grade'], $auct)[0]["min"]."</b>
                      </td>
                    </tr>
                    <tr>
                      <td style='border: none;'>
                      <b style='color:green';>".$catalogue->maxLow($value['mark'], $value['grade'], $auct)[1]["max"]."</b>
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
             <td>
               <table style='border:none;';>
                      <tr style='border: none;'>
                        <td style='border: none;';>".$value['mark']."</td>
                        <td style='border-right: 1px solid #000000;'>".$value['invoice']."</td>  
                      </tr>
                      <tr style='border: none;'>
                        <td style='border: none;';><h6>".$value['grade']."</h6></td>
                        <td style='border: none; font-size:10px;';>".convertDate($value['manf_date'])."</td>
                     </tr>
                 </table>
             </td>
            
             <td>".$value['pkgs']."</td>
             <td>".$value['type']."</td>
             <td>".$value['net']."</td>
             <td style='text-align: center;border-right: 1px solid #000000;'>".$value['kgs']."</td>
             <td style='border-right: 1px solid #000000;'><b style='color:red';>".$rp."</b></td>
             <td style='border-right: 1px solid #000000;width:100px;'>".$value['comment']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['standard']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['sale_price']."</td>
             <td style='padding-left:30px;' >".$value['buyer_package']."</td>
 
             <tr>";
             $mark = $value['mark'];
 
         }else{
             $html.= "<tr>
             <td style='border-right: 1px solid #000000;'>".$value['value']."</td>
             <td style='border-right: 1px solid #000000;'>
             <table style='border: none; padding:0px;'>
                    <tr>
                      <td style='border: none;'>
                      <b style='color:red';>".$catalogue->maxLow($value['mark'], $value['grade'], $auct)[0]["min"]."</b>
                      </td>
                    </tr>
                    <tr>
                      <td style='border: none;'>
                      <b style='color:green';>".$catalogue->maxLow($value['mark'], $value['grade'], $auct)[1]["max"]."</b>
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
             <td>
               <table style='border:none;';>
                      <tr style='border: none;'>
                        <td style='border: none;';>".$value['mark']."</td>
                        <td style='border-right: 1px solid #000000;'>".$value['invoice']."</td>  
                      </tr>
                      <tr style='border: none;'>
                        <td style='border: none;';><h6>".$value['grade']."</h6></td>
                        <td style='border: none;font-size:10px;';>".convertDate($value['manf_date'])."</td>
                     </tr>
                 </table>
             </td>
             <td>".$value['pkgs']."</td>
             <td>".$value['type']."</td>
             <td>".$value['net']."</td>
             <td style='text-align: center;border-right: 1px solid #000000;'>".$value['kgs']."</td>
             <td style='border-right: 1px solid #000000;'><b style='color:red';>".$rp."</b></td>
             <td style='border-right: 1px solid #000000;'>".$value['comment']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['standard']."</td>
             <td style='border-right: 1px solid #000000;'>".$value['sale_price']."</td>
             <td style='padding-left:30px;'> ".$value['buyer_package']."</td>
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
       