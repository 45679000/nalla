<?php
    $path_to_root = "../";
    require $path_to_root."vendor/autoload.php";

    class Report 

    {
        CONST report_path = 'files/rep.pdf';
        public $report_content = "";

        public function createReport($html){
            ob_start();//Enables Output Buffering
            $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'tempDir' => __DIR__ . '/files', 	'default_font' => 'dejavusans']);
            $mpdf->WriteHTML($html);
            ob_end_clean();//End Output Buffering
            $mpdf->Output(self::report_path, 'F');

        } 
        
    }

    ?>