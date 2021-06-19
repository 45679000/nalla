
<input type="button" id="create_pdf"  value="print" />
<?php
session_start();
header("Access-Control-Allow-Origin: *");
include '../database/connection.php';
include '../models/Model.php';
include '../controllers/ShippingController.php';

require '../vendor/autoload.php';



$db = new Database();
$conn = $db->getConnection();
$siId = 0;
$data = array();
if(isset($_POST["action"]) && $_POST["action"] == "generate"){
    $siId = isset($_POST["siId"]) ? $_POST["siId"] : 0;
    $shippingCtrl = new ShippingController($conn);
    $data = $shippingCtrl->fetchShippingInstruction($siId)[0];
    $file = 'files/si/instruction_'.$siId."pdf";

    $shippingCtrl->updateInstructionFile($file, $siId);
    $printData = print_shipping_instruction($data);
    $mpdf = new \Mpdf\Mpdf([
    'orientation' => 'P',
    'format' => 'A4', 
    'setAutoTopMargin' => 'stretch',
    'autoMarginPadding' => 0,
    'tempDir' => __DIR__ . 'files', 
    'default_font' => 'dejavusans']);
    $mpdf->SetHTMLFooter('<div style="text-align: center">{PAGENO} of {nbpg}</div>');
    $mpdf->useSubstitutions = false;

    $mpdf->shrink_tables_to_fit=0;
    $mpdf->WriteHTML($printData);
    $mpdf->SetFooter(
'
    <div style="text-align:center; padding-bottom:0px;">
        <div>
            <div style="width:40%; float:left; text-align:left">
                <hr style="text-align:left; height:3px;border-width:3px;color:#6a9832;background-color:gray"> 
            </div>
            <div style="width:16%; margin-top:-6px; text-align:center; float:left;">
                <p style="font-size:8px; color:#6a9832;">
                    Swafi House Plot No.I/268
                </p>
            </div>
            <div style="width:40%; margin-top:6px; text-align:right">
                <hr style="text-align:right; height:3px;border-width:3px;color:#6a9832;background-color:gray"> 
            </div>
        </div>
    </div>
    <div style="width:40%; margin-left:30%; margin-top:-20px; text-align:center;">
            <p style="text-align:center; font-size:8px; color:#6a9832;">
            Taveta Road (Off Grain House Office Main Gate), Shimanzi
                PO.BOX 86040-80100 Mombasa, Kenya
                Tel: +254 717 807 826 Email info@chamusupplies.com
                Website: www.chamusupplies.com
            </p> 
        </div>
');
$mpdf->Output($file, \Mpdf\Output\Destination::FILE);

}

function print_shipping_instruction($data){

    $html= '
    <head>
    <style>
    html {
        zoom: 0.5;
        }
        td{
            padding:1px;
        }
    
        #content{
            width: 1684;
            height: 1190px;
        }
        @page{
            size: auto;
            margin: 3mm;
          }
    </style>
    </head>
    <div id="content">
    <table style="width:100%; border:1px;">
    <tr>
        <td style="width:80%;">
            <hr style="height:3px;border-width:3px;color:#6a9832;background-color:gray"> 
        </td>
        <td style="width:20%; text-align:right;">
            <img style="height:50px; width:100px;" src="../images/logo.png" alt="">
        </td>
        
    </tr>
    </table>
    <table style="width:100%; border-collapse: collapse; border:1px solid;">
    <tr>
        <td style="width:50%; border:1px solid;"> SI No</td>
        <td style="width:50%; border:1px solid;">'.$data["contract_no"].'</td>
    </tr>
    <tr>
        <td style="width:50%; border:1px solid;"> SI Date</td>
        <td style="width:50%; border:1px solid;">'.$data["si_date"].'</td>
    </tr>
    <tr>
        <td style="width:50%; border:1px solid;"> Warehouse</td>
        <td style="width:50%; border:1px solid;">'.$data["ware_hse"].'</td>
    </tr>
    <tr>
        <td style="width:50%; border:1px solid;">Buyer</td>
        <td style="width:50%; border:1px solid;">Consignee</td>
    </tr>
    <tr>
        <td style="width:50%; border:1px solid; margin:0; padding:0; vertical-align: top">
        <div style="width:80%; margin:0; padding:0;">
                '.$data["buyer"].'
        </div>
        </td>
        <td style="width:50%; border:1px solid; margin:0; padding:0; vertical-align: top">
        <div style="width:80%; margin:0; padding:0;">
                '.$data["consignee"].'
            </div>
        </td>
    </tr>
</table>
    <table style="width:100%; border:1px solid;">
                <tr>
                    <td>Contract No</td>
                    <td>'.$data["contract_no"].'</td>
                </tr>
                <tr>
                    <td>Target Vessel</td>
                    <td>'.$data["target_vessel"].'</td>
                </tr>
                <tr>
                    <td>Packing Materials</td>
                    <td>'.$data["packing_materials"].'</td>
                </tr>
                <tr>
                    <td>Shipping Marks</td>
                    <td>'.$data["shipping_marks"].'</td>
                </tr>
                <tr>
                    <td>Tea Standard No</td>
                    <td>'.$data["tea_standard_no"].'</td>
                </tr>
                <tr>
                    <td>Type and Grade of Tea</td>
                    <td>'.$data["grade_type_of_tea"].'</td>
                </tr>
                <tr>
                    <td>Value of Consignment</td>
                    <td>'.$data["consignment_value"].'</td>
                </tr>
                <tr>
                    <td>Type of loading</td>
                    <td>'.$data["type_of_loading"].'</td>
                </tr>
                <tr>
                    <td>Each Nett per Package</td>
                    <td>'.$data["each_net_per_package"].'</td>
                </tr>
                <tr>
                    <td>Each Gross per Package</td>
                    <td>'.$data["each_gross_per_package"].'</td>
                </tr>
                <tr>
                    <td>Production date</td>
                    <td>'.$data["production_date"].'</td>
                </tr>
                <tr>
                    <td>Expiry Date</td>
                    <td>'.$data["expiry_date"].'</td>
                </tr>
                <tr>
                    <td>Total Nett Wt. Per Container</td>
                    <td>'.$data["total_net_weight_per_container"].'</td>
                </tr>
                <tr>
                    <td>Total Gross Wt. Per Container</td>
                    <td>'.$data["total_gross_weight_per_container"].'</td>
                </tr>
                <tr>
                    <td>Destination and Final Place of Deliver</td>
                    <td>'.$data["destination_total_place_of_delivery"].'</td>
                </tr>
                <tr>
                    <td>Shipper</td>
                    <td>'.$data["shipper"].'</td>
                </tr>
                <tr>
                    <td>Notify Party</td>
                    <td>'.$data["notify_party"].'</td>
                </tr>
                <tr>
                    <td>2nd Notify Party</td>
                    <td>'.$data["2nd_notify_party"].'</td>
                </tr>
         
                <tr>
                    <td>LC No.</td>
                    <td>'.$data["lc_no"].'</td>
                </tr>
                <tr>
                    <td>Date of Issue</td>
                    <td>'.$data["date_of_issue"].'</td>
                </tr>
                <tr>
                    <td>Negotiating Bank</td>
                    <td>'.$data["negotiating_bank"].'</td>
                </tr>
                <tr>
                    <td>Marine Insurance</td>
                    <td>'.$data["marine_insuarance"].'</td>
                </tr>
                <tr>
                    <td>QA & Inspection</td>
                    <td>'.$data["qa_inspection"].'</td>
                </tr>
                <tr>
                    <td>Additional Instructions</td>
                    <td>'.$data["additional_instructions"].'</td>
                </tr>
            </table>
    </div>';
    return $html;
}
?>   


</body>
<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
<script>

    (function() {
        var
            form = $('#content'),
            cache_width = form.width(),
            a4 = [595.28, 1000.89]; // for a4 size paper width and height  

        $('#create_pdf').on('click', function() {
            $('body').scrollTop(0);
            createPDF();
            autoPrint();
        });
        //create pdf  
        function createPDF() {
            getCanvas().then(function(canvas) {
                var
                    img = canvas.toDataURL("image/png"),
                    doc = new jsPDF({
                        unit: 'pt',
                        format: 'a4'
                    });
                doc.addImage(img, 'JPEG', 20, 20);
                doc.save('Bhavdip-html-to-pdf.pdf');
                form.width(cache_width);
            });
        }

        // create canvas object  
        function getCanvas() {
            form.width((a4[0] * 1.33333) - 90).css('max-width', 'none');
            return html2canvas(form, {
                imageTimeout: 2000,
                removeContainer: true
            });
        }

    }());
</script>
<script>
    /* 
     * jQuery helper plugin for examples and tests 
     */
    (function($) {
        $.fn.html2canvas = function(options) {
            var date = new Date(),
                $message = null,
                timeoutTimer = false,
                timer = date.getTime();
            html2canvas.scale = 2;
            html2canvas.mozImageSmoothingEnabled = false;
            html2canvas.Preload(this[0], $.extend({
                complete: function(images) {
                    var queue = html2canvas.Parse(this[0], images, options),
                        $canvas = $(html2canvas.Renderer(queue, options)),
                        finishTime = new Date();

                    $canvas.css({
                        position: 'absolute',
                        left: 0,
                        top: 0
                    }).appendTo(document.body);
                    $canvas.siblings().toggle();

                    $(window).click(function() {
                        if (!$canvas.is(':visible')) {
                            $canvas.toggle().siblings().toggle();
                            throwMessage("Canvas Render visible");
                        } else {
                            $canvas.siblings().toggle();
                            $canvas.toggle();
                            throwMessage("Canvas Render hidden");
                        }
                    });
                    throwMessage('Screenshot created in ' + ((finishTime.getTime() - timer) / 1000) + " seconds<br />", 4000);
                }
            }, options));

            function throwMessage(msg, duration) {
                window.clearTimeout(timeoutTimer);
                timeoutTimer = window.setTimeout(function() {
                    $message.fadeOut(function() {
                        $message.remove();
                    });
                }, duration || 2000);
                if ($message)
                    $message.remove();
                $message = $('<div></div>').html(msg).css({
                    margin: 0,
                    padding: 2,
                    background: "#fff",
                    opacity: 1,
                    position: "fixed",
                    top: 10,
                    right: 10,
                    fontFamily: 'arial',
                    color: '#fff',
                    fontSize: 8,
                    width: 'auto',
                    height: 'auto',
                    textAlign: 'center',
                    textDecoration: 'none'
                }).hide().fadeIn().appendTo('body');
            }
        };
    })(jQuery);
</script>

</html>