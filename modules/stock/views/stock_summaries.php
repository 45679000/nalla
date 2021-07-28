<div class="col-md-8 col-lg-10">
    <div class="card">
        <div class="card-body p-6">
            <div class="col-md-12">
                <div class="expanel expanel-secondary">
                    <?php
                    if ($summary != '') {
echo '<iframe class="frame" frameBorder="0" src="../reports/stocklisting.php?filter='.$summary.'" width="100%" height="1000px"></iframe>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>