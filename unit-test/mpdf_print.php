<?php
    $path_to_root = "../";
    require $path_to_root."vendor/autoload.php";
    $rep = new Report();
    $rep->createReport('<p>Testing 1</p>');
    class Report 

    {
        function createReport($html){
            ob_start();//Enables Output Buffering
            $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'tempDir' => __DIR__ . '/files']);
            $mpdf->WriteHTML($html);
            ob_end_clean();//End Output Buffering
            $mpdf->Output('files/rep_'.'.pdf', 'F');
        }    
    }

    ?>
 
