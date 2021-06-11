<?php
    ob_start();//Enables Output Buffering
    $path_to_root = "../";
    require $path_to_root."vendor/autoload.php";
    $stylesheet = file_get_contents('css/bootstrap.min.css');

    $html = '
    <div class="container">
    <div>
      <div>
        One of three columns
      </div>
      <div>
        One of three columns
      </div>
      <div>
        One of three columns
      </div>
    </div>
  </div>';

    $mpdf = new \Mpdf\Mpdf(['orientation' => 'L', 'tempDir' => __DIR__ . '/files']);
    $mpdf->WriteHTML($stylesheet, 1); // CSS Script goes here.  
    $mpdf->WriteHTML($html, 2); //HTML Content goes here.
    ob_end_clean();//End Output Buffering
    $mpdf->Output();
         
    

    ?>
 
