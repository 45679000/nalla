<style>
    .modal {
   position: absolute;
   top: 10px;
   right: 100px;
   bottom: 0;
   left: 0;
   z-index: 10040;
   overflow: auto;
   overflow-y: auto;
}
</style>
<div class="col-md-8 col-lg-10">
                <div class="card">
                    <div class="card-body p-6">
                        <div class="col-md-12">
                            <div class="expanel expanel-secondary">
                                <?php
                                echo '<div class="expanel-heading">
                                        <h3 class="expanel-title">Grading Codes</h3>
                                            </div>
                                        
                                            <div class="card-body">
                                            <div class="table-responsive">
                                                <table  class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="wd-15p">#</th>
                                                            <th class="wd-15p">Code</th>
                                                            <th class="wd-20p">Comment</th>                                        
                                                        </tr>
                                                    </thead>
                                                    <tbody>';
                                                    $html ="";
                                                    foreach ($comments as $comment){
                                                        $html.='<tr>';
                                                            $html.='<td>'.$comment["id"].'</td>';
                                                            $html.='<td>'.$comment["code"].'</td>';
                                                            $html.='<td>'.$comment["description"].'</td>';
                                                        $html.='</tr>';
                                                    }
                                            $html.= '</tbody>
                                                </table>
                                            </div>
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
<!-- Custom Js-->
<script src="../assets/js/custom.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>
            <script>
            $("table").DataTable({
                       
                    });
            </script>