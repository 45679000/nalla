<div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body p-6">
                        <div class="col-md-12">
                            <div class="expanel expanel-secondary">
                           <div class="row">
							<div class="col-md-12 col-lg-12">
								<div class="card">
									<div class="card-body text-center">
                                    <form method="post">
                                    <div class="row justify-content-center">
                                        <div class="col-md-3 well">
                                            <div class="form-group form-inline">
                                                <label class="control-label">Select Action from the list</label>
                                                <select id="saleno" name="saleno" class="form-control select2" ><small>(required)</small>
                                                    <option disabled="" value="..." selected="">select</option>
                                                    <?php
                                                        foreach(loadAuctionArray() as $auction_id){
                                                            echo '<option value="'.$auction_id.'">'.$auction_id.'</option>';
                                                        }
                                                   ?>
                                                </select>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-3 well">
                                        <div class="form-group label-floating">

                                            <button type="submit" id="search" value="filter" name="filter" class="btn btn-success btn-sm">Search Purchase List</button>

                                        </div>
                                    </div>
                                    </div>
                                </form>
									</div>
								</div>
							</div>
						</div>
                           <div class="card-body">
                                
                           </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
</body>


</html>

