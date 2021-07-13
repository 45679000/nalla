<style>
/* Center the loader */
#loader {
  position: fixed;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 120px;
  height: 120px;
  margin: -76px 0 0 -76px;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}
.expanel-body .card{
    padding-bottom: 0px !important;
    padding-top: 0px !important;
}

</style>

<div class="col-md-8 col-lg-10">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="col-md-12">
                            <div class="expanel expanel-secondary">
                                
                                <div class="expanel-heading">
                                                <h3 class="expanel-title">Filter Stock</h3>
                                            </div>
                                            <div class="expanel-body">
                                                <form method="post" class="filter">
                                                    <div class="row justify-content-center">
                                                        <div class="col-md-2 well">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">AUCTION</label>
                                                                <select id="saleno" name="saleno" class="form-control" ><small>(required)</small>
                                                                    <option disabled="" value="..." selected="">select</option>
                                                                    <?php
                                                                        loadAuction();
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 well">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">BROKER</label>
                                                                <select id="broker" name="broker" class="form-control well" ><small>(required)</small>
                                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 well">
                                                            <div class="form-group label-floating">
                                                                <label class="control-label">Garden</label>
                                                                <select id="mark" name="category" class="form-control well" ><small>(required)</small>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 well">
                                                            <button type="submit" class="btn btn-primary">View</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            
                                            </div>
                           <div class="card-body">
                                <div id="stock-master" class="table-responsive">
                                <div id="loader"></div>

                                </div>
                            </div>
                
                        
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
</body>

<script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>
<script src="../assets/js/stock.js"></script>
<script src="../assets/js/common.js"></script>

<script src="../assets/plugins/datatable/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatable/dataTables.bootstrap4.min.js"></script>


<script src="../assets/plugins/datatable/dataTables.buttons.min.js"></script>
<script src="../assets/plugins/datatable/jszip.min.js"></script>
<script src="../assets/plugins/datatable/pdfmake.min.js"></script>
<script src="../assets/plugins/datatable/vfs_fonts.js"></script>
<script src="../assets/plugins/datatable/buttons.html5.min.js"></script>
<script src="../assets/plugins/datatable/buttons.print.min.js"></script>
<script>
loadMasterStock();


</script>
