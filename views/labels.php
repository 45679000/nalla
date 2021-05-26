<div class="col-md-8 col-lg-10">
                <div class="card">
                    <div class="card-body p-6">
                        <div class="col-md-12">
                            <div class="expanel expanel-secondary">
                                <?php
                                $id = 2;
                                    $html='
                                    <div class="container-fluid">
                                        <div class="row">
                                        ';
                                        foreach($offered as $offer){
                                                $html.='
                                                <div class="col-md-3" style="padding:100px;">
                                                        <table>
                                                            <tr>
                                                                <td>SALE'.$offer['sale_no'].'</td>
                                                                <td>DATE'.$offer['manf_date'].'</td> 
                                                            </tr>
                                                            <tr>
                                                                <td>'.$offer['mark'].'</td>
                                                                <td>'.$offer['grade'].'</td>   
                                                            </tr>
                                                            <tr>
                                                                <td>PKGS'.$offer['pkgs'].'</td>
                                                                <td>LOT#'.$offer['lot'].'</td>
                                                            </tr>
                                                            <tr>
                                                                <td>WGHT'.$offer['net'].'</td>
                                                                <td>Invoice'.$offer['invoice'].'</td>
                                                            </tr>
                                                        </table>
                                                     </div>';
                                            }
                                            $html.='</div>
                                            </div>';
                                    echo $html;
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Dashboard js -->
<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../assets/js/vendors/selectize.min.js"></script>
<script src="../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../assets/js/vendors/circle-progress.min.js"></script>
<script src="../assets/plugins/rating/jquery.rating-stars.js"></script>
<!-- forn-wizard js-->
<script src="../assets/plugins/forn-wizard/js/material-bootstrap-wizard.js"></script>
<script src="../assets/plugins/forn-wizard/js/jquery.validate.min.js"></script>
<script src="../assets/plugins/forn-wizard/js/jquery.bootstrap.js"></script>
<!-- file import -->
<script src="../assets/plugins/fileuploads/js/dropify.min.js"></script>
<!-- Custom scroll bar Js-->
<script src=../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- counter  -->
<script src="../assets/plugins/counters/counterup.min.js"></script>
<script src="../assets/plugins/counters/waypoints.min.js"></script>
<!-- Custom Js-->
<script src="../assets/js/custom.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>

<script>
    $(function(e) {
        $('#tasting').DataTable();
    });
</script>

