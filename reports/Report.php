<?php
    $path_to_root = "../";
    require $path_to_root."vendor/autoload.php";

    class Report 

    {
        CONST report_path = 'files/rep.pdf';
        public $report_content = "";

        public function printReport($data){
            $this->createReport($this->brokerCatalogueContent($data));
            return self::report_path;
        }
        public function createReport($html){
            ob_start();//Enables Output Buffering
            $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'tempDir' => __DIR__ . '/files', 	'default_font' => 'dejavusans']);
            $mpdf->WriteHTML($html);
            ob_end_clean();//End Output Buffering
            $mpdf->Output(self::report_path, 'F');

        } 
        public function brokerCatalogueContent($data){
        
            $html = "<html>
            <style>
                table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
                }

                td, th {
                border: 0px solid #dddddd;
                text-align: left;
                padding: 8px;
                }

                tr:nth-child(even) {
                background-color: #dddddd;
                }
                </style>
            ";
            $html .="

            <h3 style='text-align:center'>Anjeli Limited</h3>
            <h4 style='text-align:left'>Main&emsp;&emsp;Auction&emsp;&emsp;2021-02&emsp;&emsp; Of   Tuesday, March 23rd 2021 </h4>
            <hr>
            <table>
            <tr>
              <th>Value</th>
              <th><pre>Max
               Low</pre></th>
              <th>LotNo</th>
              <th>Grade  Garden</th>
              <th>Inv.</th>
              <th>Pkgs  TP</th>
              <th>Kilos</th>
              <th>NW</th>
              <th>RP</th>
              <th>Comment</th>
              <th>Standard</th>
              <th>Sale Price</th>
              <th>Buyer</th>
            </tr>
            </table>
       
            <table>
            ";
            foreach ($data as $data){
                foreach($data['records'] as $record){
                //     $html.='<hr>
                // <tr> <h3 style="text-align:center">'.$record['mark'].'</h3> </tr>
                // <hr>';
                    $html.="<tr>";
                    $html.="<td>".$record['value']."</td>";
                    $html.="<td>"."max|172".  "low|170"."</td>";
                    $html.="<td>".$record['lot']."</td>";
                    $html.="<td>".$record['grade']." ".$record['mark']."</td>";
                    // $html.="<td>".$record['invoice']."</td>";
                    $html.="<td>".$record['pkgs']."</td>";
                    // $html.="<td>".$record['type']."</td>";
                    // $html.="<td>".$record['kgs']."</td>";
                    $html.="<td>70</td>";
                    $html.="<td>".$record['rp']."</td>";
                    $html.="<td>".$record['comment']."</td>";
                    $html.="<td></td>";
                    $html.="<td>".$record['sale_price']."</td>";
                    // $html.="<td>".$record['buyer_package']."</td>";
                    $html.="</tr>";
                }
                
        
            }
          $html .= "
          </table>
          </html>";

          return $html;


        }   
    }

    ?>