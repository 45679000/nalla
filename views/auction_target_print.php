<style>
.pdfViewer{
    background-color: white !important;
}
</style>
<div class="col-md-8 col-lg-10">
    <div class="card">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body text-center">
                        <form method="post">
                            <div class="row justify-content-center">
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <label class="control-label">AUCTION</label>
                                        <select id="saleno" name="saleno" class="form-control"><small>(required)</small>
                                            <option disabled="" value="..." selected="">select</option>
                                            <?php
                                            foreach (loadAuctionArray() as $auction_id) {
                                                echo '<option value="' . $auction_id . '">' . $auction_id . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3 well">
                                    <div class="form-group label-floating">
                                        <button type="submit" id="search" value="filter" name="filter" class="btn btn-success btn-sm">Print Auction Targets</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="buyingList" class="col-md-12">
                <div class="card-body">
                    <div class="dimmer active">
                        <div class="lds-hourglass"></div>
                    </div>
                </div>
            </div>
        </div>

        <script src="../assets/js/vendors/jquery-3.2.1.min.js"></script>

        <script>
            $(document).ready(function() {
                $('.dimmer').hide();
                $("#search").click(function(e) {
                    $('.dimmer').show();
                    e.preventDefault();
                    var saleno = $("#saleno").val();
                    $("#buyingList").html('<iframe class="frame" frameBorder="0" src="../reports/auction_list.php?saleno=' + saleno + '&filter=true" width="100%" height="800px"></iframe>');
                    $('.dimmer').hide();

                });
            });

            $('.frame').ready(function() {
                $('.dimmer').hide();
            });
            $('.frame').load(function() {
                $('.dimmer').show();
            });
        </script>