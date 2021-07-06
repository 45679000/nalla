<style>
   a:focus {
  color: red;
};
</style>
<div class="col-md-3 col-lg-2">
    <div class="card">
        <div class="expanel expanel-primary">
            <div class="expanel-heading">
                <h3 class="expanel-title">Stock Listing</h3>
            </div>
            <div class="expanel-body">
                <div class="list-group list-group-transparent mb-0 mail-inbox">
                    <li class="list-group-item list-group-item-action d-flex align-items-center">
                        <a href="./stock_index.php?view=ppurchase-list" class="wave-effect"><i class="fa fa-window-restore mr-2"></i> Private Purchases</a>
                    </li>
                    <li class="list-group-item list-group-item-action d-flex align-items-center">
					    <a href="./stock_index.php?view=purchase-list" class=" wave-effect"><i class="fa fa-window-restore mr-2"></i> Purchase List</a>
					</li>
                    <li class="list-group-item list-group-item-action d-flex align-items-center">
                        <a href="#homeSubmenu" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
                            <span class="icon mr-3"><i class="fa fa-database"></i></span>Stock Master
                        </a>
                    </li>
                    <ul class="collapse list-unstyled list-group-item list-group-item-action " id="homeSubmenu" data-parent="#accordion">
                        <li>
                            <a href="./stock_index.php?view=stock-master" class="list-group-item list-group-item-action d-flex align-items-center">
                                <span class="icon mr-3"><i class="fa fa-database"></i></span>Stock Grid
                            </a>
                        </li>
                        <li>
                            <a href="./stock_index.php?view=summaries&summary=pstock" class="list-group-item list-group-item-action d-flex align-items-center">
                                <span class="icon mr-3"><i class="fa fa-database"></i></span>Total Purchases
                            </a>
                        </li>
                        <li>
                            <a href="./stock_index.php?view=summaries&summary=totalStock" class="list-group-item list-group-item-action d-flex align-items-center">
                                <span class="icon mr-3"><i class="fa fa-database"></i></span>Total Stock
                            </a>
                        </li>
                        <li>
                            <a href="./stock_index.php?view=summaries&summary=totalStockOriginal" class="list-group-item list-group-item-action d-flex align-items-center">
                                <span class="icon mr-3"><i class="fa fa-database"></i></span>Total Stock (Original Teas)
                            </a>
                        </li>
                        <li>
                            <a href="./stock_index.php?view=summaries&summary=totalStockBlended" class="list-group-item list-group-item-action d-flex align-items-center">
                                <span class="icon mr-3"><i class="fa fa-database"></i></span>Total Stock (Blended Teas)
                            </a>
                        </li>
                        <li>
                        <a href="./stock_index.php?view=summaries&summary=totalStockContractWise" class="list-group-item list-group-item-action d-flex align-items-center">
                                <span class="icon mr-3"><i class="fa fa-database"></i></span>Total Stock (Contract Wise)
                            </a>
                        </li>
                        <li>
                        <a href="./stock_index.php?view=summaries&summary=totalStockAwaitingShipment" class="list-group-item list-group-item-action d-flex align-items-center">
                                <span class="icon mr-3"><i class="fa fa-database"></i></span>Total Stock (Awaiting Shipment)
                            </a>
                        </li>
                        <li>
                        <a href="./stock_index.php?view=summaries&summary=totalStockPaidUnallocated" class="list-group-item list-group-item-action d-flex align-items-center">
                                <span class="icon mr-3"><i class="fa fa-database"></i></span>Paid (Unallocated)
                            </a>
                        </li>
                        <li>
                        <a href="./stock_index.php?view=summaries&summary=totalStockUnPaidUnallocated" class="list-group-item list-group-item-action d-flex align-items-center">
                                <span class="icon mr-3"><i class="fa fa-database"></i></span>Un Paid (Unallocated)
                            </a>
                        </li>
                       
                    </ul>

                </div>
            </div>
        </div>
        <div class="expanel expanel-primary">
            <div class="expanel-heading">
                <h3 class="expanel-title">Stock Management</h3>
            </div>
            <div class="expanel-body">
                <div class="list-group list-group-transparent mb-0 mail-inbox">
                    <li class="list-group-item list-group-item-action d-flex align-items-center">
					    <a href="./stock_index.php?view=allocate-stock" class=" wave-effect"><i class="fa fa-cubes mr-2"></i> Allocate Stock</a>
					</li>
                    <li class="list-group-item list-group-item-action d-flex align-items-center">
					    <a href="./stock_index.php?view=amend-stock" class=" wave-effect"><i class="fa fa-exchange mr-2"></i>Amend Stock</a>
					</li>
                    <li class="list-group-item list-group-item-action d-flex align-items-center">
					    <a href="../modules/blending/index.php" class=" wave-effect"><i class="fa fa-file mr-2"></i> Shippment Teas</a>
					</li>

                </div>
            </div>
        </div>

    </div>
</div>
