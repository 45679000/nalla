<?php
$path_to_root = "../";



$grading = new Grading($conn);
$offered = $grading->readOffers();
echo print_labels($offered);

function print_labels($offered)
{
    //    echo'<input type="button" id="create_pdf" value="Generate PDF">';  

    $html = '
            <div class="col-md-8 col-lg-10">
                <div class="card">
                    <div class="card-body p-6">
                        <div class="col-md-12">
                            <div style="text-align: center;">
                                <input type="button" id="create_pdf" value="Print to PDF">  
                            </div>
                            <div class="expanel expanel-secondary form">
                                <div class="row">';
    foreach ($offered as $offer) {
        $html .= '
                                            <div style="padding:10px;" class="col-md-4">
                                                <table>
                                                    <tr>
                                                        <td><b>SALE:' . $offer['sale_no'] . '</b></td>
                                                        <td>DATE:' . $offer['manf_date'] . '</td> 
                                                    </tr>
                                                    <tr>
                                                        <td>' . $offer['mark'] . '</td>
                                                        <td>' . $offer['grade'] . '</td>  
                                                    </tr> 
                                                    <tr>
                                                        <td>PKGS:' . $offer['pkgs'] . '</td>
                                                        <td><b>LOT#:' . $offer['lot'] . '</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td>WGHT:<b>' . $offer['net'] . '</b></td>
                                                        <td>Invoice:<b>' . $offer['invoice'] . '</b></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            ';
    }
    $html .= '
                                </div>
                            </div>
                        </div>
                     </div>
                 </div>
            </div>

';
    return $html;
}


?>


<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        /* padding:10px; */
    }

    td {
        padding-left: 3px;
    }
</style>

<script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.min.js"></script>
<script>
    (function() {
        var
            form = $('.form'),
            cache_width = form.width(),
            a4 = [595.28, 841.89]; // for a4 size paper width and height  

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
                        unit: 'px',
                        format: 'a4'
                    });
                doc.addImage(img, 'JPEG', 20, 20);
                doc.save('Bhavdip-html-to-pdf.pdf');
                form.width(cache_width);
            });
        }

        // create canvas object  
        function getCanvas() {
            form.width((a4[0] * 1.33333) - 80).css('max-width', 'none');
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
            html2canvas.scale = 1;
            html2canvas.logging = options && options.logging;
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
                $message = $('<div ></div>').html(msg).css({
                    margin: 0,
                    padding: 10,
                    background: "#fff",
                    opacity: 1,
                    position: "fixed",
                    top: 10,
                    right: 10,
                    fontFamily: 'Tahoma',
                    color: '#fff',
                    fontSize: 12,
                    borderRadius: 12,
                    width: 'auto',
                    height: 'auto',
                    textAlign: 'center',
                    textDecoration: 'none'
                }).hide().fadeIn().appendTo('body');
            }
        };
    })(jQuery);
</script>