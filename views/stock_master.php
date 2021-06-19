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
                                                <td>Kgs</td>
                                                <td>Net</td>
                                                <td>Auction Hammer Price per Kg(USD)</td>
                                                <td>Value Ex Auction</td>
                                                <td>Brokerage Amount 0.5 % on value(USD)</td>
                                                <td>Final Prompt Value Including Brokerage 0.5 % on value(USD)</td>
                                                <td>Witdholding Tax @ 5% Of Brokerage Amount Payable to Domestic Taxes Dept(USD)</td>
                                                <td>Prompt Payable to EATTA-TCA After Deduction of W.Tax</td>
                                                <td>Add on(Over Auction Hammer Price+ Brokerage) Per Kg (USD))</td>
                                                <td>Final Sales Invoice Price Per Kg(USD)</td>
                                                <td>Final Sales Invoice Value(USD)</td>

											</tr>
										</thead>
                                        <tbody>';
                                        $html = "";
                                        $totalPkgs = 0;
                                        $totalLots = 0;
                                        $totalKgs = 0;
                                        $totalNet = 0;
                                        $totalHammer = 0;
                                        $totalValue = 0;
                                        $totalBrokerage = 0;
                                        $totalbrokerage =0;
                                        $totalAmount = 0;
                                        $totalAfterTax = 0;
                                        $totalAddon = 0;
                                        $totalpayable = 0;
                                        $totalPayableStock = 0;
                                        $totalLots=0;

                                        foreach ($stocks as $stock){ 
                                            $totalLots++; 
                                            $totalPkgs+=$stock['pkgs'];
                                            $totalKgs+=$stock['kgs'];
                                            $totalNet+=$stock['net'];

                                            $brokerage = round(($stock['value']*$stock['pkgs'])*(0.5/100), 2);
                                            $value = round($stock['value']*$stock['pkgs'],2);
                                            $totalamount = round($brokerage+$value,2);
                                            $afterTax = round(($totalamount)-(5/100)*$brokerage,2);
                                            $auctionHammer = round(($stock['value']/100),2);
                                            $addon = round(($auctionHammer+$brokerage)/$stock['pkgs'],2);
                                            $totalPayable = round($addon+$auctionHammer, 2);
                                            $hammerPrice = round($stock['value']/$stock['kgs'],2);

                                            $totalBrokerage+=$brokerage;
                                            $totalValue+=$value;
                                            $totalHammer+=$hammerPrice;
                                            $totalAmount += $totalamount;
                                            $totalbrokerage+=(5/100)*$brokerage;

                                            $totalAfterTax += $afterTax;
                                            $totalAddon +=$addon;
                                            $totalpayable+=$totalPayable;

                                            $totalPayableStock+=$totalPayable*$stock['net'];
                                
                                            $html.='<td>'.$stock['sale_no'].'</td>';
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
                                            $html.='<td>'.$value.'</td>'; //value ex auction
                                            $html.='<td>'.$brokerage.'</td>';// brokerage fee
                                            $html.='<td>'.$totalAmount.'</td>'; //final prompt value
                                            $html.='<td>'.(5/100)*$brokerage.'</td>';
                                            $html.='<td>'.$afterTax.'</td>';
                                            $html.='<td>'.$addon.'</td>';
                                            $html.='<td>'.$totalPayable.'</td>';
                                            $html.='<td>'.$totalPayable*$stock['net'].'</td>';
                                       $html.='</tr>';
                              
                                        }
                                $html.='<tr style="background-color:green; color:white; border:none;">';
                                
                                $html.='<td><b>TOTALS</td>';
                                $html.='<td></td>';
                                $html.='<td></td>';
                                $html.='<td></td>';
                                $html.='<td><b>'.$totalLots.'</b></td>';
                                $html.='<td></td>';
                                $html.='<td></td>';
                                $html.='<td></td>';
                                $html.='<td></td>'; 
                                $html.='<td><b>'.$totalPkgs.'</b></td>'; //pkgs
                                $html.='<td><b>'.$totalKgs.'</b></td>'; //net
                                $html.='<td><b>'.$totalNet.'</b></td>'; //kgs
                                $html.='<td><b>'.$totalHammer.'</b></td>'; //auction hammer
                                $html.='<td><b>'.$totalValue.'</b></td>'; //value ex auction
                                $html.='<td><b>'.$totalBrokerage.'</b></td>';// brokerage fee
                                $html.='<td><b>'.$totalAmount.'</b></td>'; //final prompt value
                                $html.='<td><b>'.$totalbrokerage.'</b></td>';
                                $html.='<td><b>'.$totalAfterTax.'</b></td>';
                                $html.='<td><b>'.$totalAddon.'</b></td>';
                                $html.='<td><b>'.$totalpayable.'</b></td>';
                                $html.='<td><b>'.$totalPayableStock.'</b></td>';
     
                                $html.='</tr>';
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
<script src="../assets/plugins/rating/jquery.rating-stars.js"></script>
<!-- forn-wizard js-->
<script src="../assets/plugins/forn-wizard/js/material-bootstrap-wizard.js"></script>
<script src="../assets/plugins/forn-wizard/js/jquery.validate.min.js"></script>
<script src="../assets/plugins/forn-wizard/js/jquery.bootstrap.js"></script>
<!-- file stock -->
<script src="../assets/plugins/fileuploads/js/dropify.min.js"></script>
<!-- Custom scroll bar Js-->
<script src=../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- counter  -->
<script src="../assets/plugins/counters/counterup.min.js"></script>
<script src="../assets/plugins/counters/waypoints.min.js"></script>
<!-- Custom Js-->
<script src="../assets/js/custom.js"></script>
<script src="../assets/js/common.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>


<script src="../assets/plugins/datatable/dataTables.buttons.min.js"></script>
<script src="../assets/plugins/datatable/jszip.min.js"></script>
<script src="../assets/plugins/datatable/pdfmake.min.js"></script>
<script src="../assets/plugins/datatable/vfs_fonts.js"></script>
<script src="../assets/plugins/datatable/buttons.html5.min.js"></script>
<script src="../assets/plugins/datatable/buttons.print.min.js"></script>


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
			$('.counter').countUp();
		</script>
        <!-- Data table js -->

        <script>
			$(function(e) {
				$('#closingstocks').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print',
                        {
                            extend: 'pdfHtml5',
                            orientation: 'landscape',
                            pageSize: 'LEGAL'
                        },
                        
                    ]
                });
			} );
		</script>
		
       
</html>

