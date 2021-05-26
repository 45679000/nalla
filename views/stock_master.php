<div class="col-md-8 col-lg-10">
                <div class="card">
                    <div class="card-body p-6">
                        <div class="col-md-12">
                            <div class="expanel expanel-secondary">
                                <?php
                                $html ='<div class="expanel-heading">
                                                <h3 class="expanel-title">Filter Catalogue</h3>
                                            </div>
                                            <div class="expanel-body">
                                                <form method="post" class="filter">
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-3 well">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">AUCTION</label>
                                                                <select id="saleno" name="saleno" class="form-control" ><small>(required)</small>
                                                                    <option disabled="" value="..." selected="">select</option>
                                                                    <option value="2021-01"> 2021-01 </option>
                                                                    <option value="2021-02"> 2021-02 </option>
                                                                    <option value="2021-03"> 2021-03 </option>
                                                                    <option value="2021-04"> 2021-04 </option>
                                                                    <option value="2021-05"> 2021-05 </option>
                                                                    <option value="2021-06"> 2021-06 </option>
                                                                    <option value="2021-07"> 2021-07 </option>
                                                                    <option value="2021-08"> 2021-08 </option>
                                                                    <option value="2021-09"> 2021-09 </option>
                                                                    <option value="2021-10"> 2021-10 </option>
                                                                    <option value="2021-11"> 2021-11 </option>
                                                                    <option value="2021-12"> 2021-12 </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 well">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">BROKER</label>
                                                                <select id="broker" name="broker" class="form-control well" ><small>(required)</small>
                                                                    <option disabled="" value="..." selected="">select</option>
                                                                    <option value="ANGL"> ANGL </option>
                                                                    <option value="ATLC"> ATLC </option>
                                                                    <option value="BICL"> BICL </option>
                                                                    <option value="CENT"> CENT </option>
                                                                    <option value="CTBL"> CTBL </option>
                                                                    <option value="VENS"> VENS </option>
                                                                    <option value="UNTB"> UNTB </option>
                                                                    <option value="TBE"> TBE </option>
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
                                        foreach ($stocks as $stock){  
                                                
                                            $brokerage = round(($stock['value']*$stock['pkgs'])*(0.5/100), 2);
                                            $value = round($stock['value']*$stock['pkgs'],2);
                                            $totalamount = round($brokerage+$value,2);
                                            $afterTax = round(($totalamount)-(5/100)*$brokerage,2);
                                            $auctionHammer = round(($stock['value']/$stock['kgs']),2);
                                            $addon = round(($auctionHammer+$brokerage)/$stock['pkgs'],2);
                                            $totalPayable = round($addon+$auctionHammer, 2);
                                            $hammerPrice = round($stock['value']/$stock['kgs'],2);
                                
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
                                            $html.='<td>'.$totalamount.'</td>'; //final prompt value
                                            $html.='<td>'.(5/100)*$brokerage.'</td>';
                                            $html.='<td>'.$afterTax.'</td>';
                                            $html.='<td>'.$addon.'</td>';
                                            $html.='<td>'.$totalPayable.'</td>';
                                            $html.='<td>'.$totalPayable*$stock['net'].'</td>';
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
			$('.counter').countUp();
		</script>
        <!-- Data table js -->
		<script>
			$(function(e) {
				$('#closingstocks').DataTable();
			} );
		</script>
       
</html>

