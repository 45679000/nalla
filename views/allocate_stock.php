<div class="col-md-8 col-lg-10">
                <div class="card">
                    <div class="card-body p-6">
                        <div class="col-md-12">
                            <div class="expanel expanel-secondary">
                                <?php
                                echo '<div class="expanel-heading">
                                                <h3 class="expanel-title">Filter Stock</h3>
                                            </div>
                                            <div class="expanel-body">
                                                <form method="post" class="filter">
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-3 well">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">AUCTION</label>
                                                                <select id="saleno" name="saleno" class="form-control" ><small>(required)</small>
                                                                    <option disabled="" value="..." selected="">select</option>
                                                                    ';
                                                                    loadAuction();
                                                                    echo '
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 well">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">BROKER</label>
                                                                <select id="broker" name="broker" class="form-control well" ><small>(required)</small>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 well">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">CATEGORY</label>
                                                                <select id="category" name="category" class="form-control well" ><small>(required)</small>
                                                                    <option disabled="" value="..." selected="">select</option>
                                                                    <option value="Main">Main</option>
                                                                    <option value="Sec">Sec</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 well">
                                                            <button type="submit" class="btn btn-primary">View</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            
                                            </div>
                           <div class="card-body">
                                <div class="table-responsive">
									<table id="closingstocks" class="table table-striped table-bordered" style="width:100%">
										<thead>
											<tr>
                                                <td>Sale No</td>
                                                <td>DD/MM/YY</td>
                                                <td>Broker</td>
                                                <td>Warehouse</td>
                                                <td>Lot</td>
                                                <td>Origin</td>
                                                <td>Mark</td>
                                                <td>Grade</td>
                                                <td>Invoice</td>
                                                <td>Pkgs</td>
                                                <td>Net</td>
                                                <td>Kgs</td>
                                                <td>Hammer Price per Kg(USD)</td>
                                                <td>MRP Value</td>

											</tr>
										</thead>
                                        <tbody>';
                                        $html = "";
                                   

                                        foreach ($stocks as $stock){ 
                                
                                            $hammerPrice = round($stock['value']/$stock['kgs'],2);
                                    
                                            $html.='<td><div>'.$stock['sale_no'].'</div></td>';
                                            $html.='<td>'.$catalogue->ExcelToPHP($stock['manf_date']).'</td>';
                                            $html.='<td>'.$stock['broker'].'</td>';
                                            $html.='<td>'.$stock['ware_hse'].'</td>';
                                            $html.='<td>'.$stock['lot'].'</td>';
                                            $html.='<td>KENYA</td>';
                                            $html.='<td>'.$stock['mark'].'</td>';
                                            $html.='<td>'.$stock['grade'].'</td>';
                                            $html.='<td>'.$stock['invoice'].'</td>'; 
                                            $html.='<td>'.$stock['pkgs'].'</td>'; //pkgs
                                            $html.='<td>'.$stock['kgs'].'</td>'; //net
                                            $html.='<td>'.$stock['net'].'</td>'; //kgs
                                            $html.='<td>'.$hammerPrice.'</td>'; //auction hammer
                                            $html.="<td><div class='editable' contenteditable='true'>".$hammerPrice."</div></td>"; 

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
</div>
</body>

<!-- Dashboard js -->
<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../assets/js/vendors/selectize.min.js"></script>
<script src="../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../assets/js/vendors/circle-progress.min.js"></script>


<script src=../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>


<script src="../assets/js/custom.js"></script>
<script src="../assets/js/common.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>



<script type="text/javascript">
            $('.dropify').dropify({
                messages: {
                    'default': 'Drag and drop a file here or click',
                    'replace': 'Drag and drop or click to replace',
                    'remove': 'Remove',
                    'error': 'Ooops, something wrong appended.'
                },
                error: {
                    'fileSize': 'The file size is too big (2M max).'
                }
            });
        </script>
        <script>
            $('.editable').click(function(e){
                alert($('.editable').html());
            });
		</script>
        <!-- Data table js -->

        <script>
			$(function(e) {
				$('#closingstocks').DataTable({
                });
			} );
		</script>
		
       
</html>

