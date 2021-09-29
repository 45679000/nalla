<?php 
    use \koolreport\widgets\koolphp\Table;
    use \koolreport\widgets\google\BarChart;
?>

<div class="text-center">
    <h1>Stock Report By Sale No</h1>
</div>
<hr/>

<?php
    BarChart::create(array(
        "dataStore"=>$this->dataStore('sales_by_customer'),
        "width"=>"100%",
        "height"=>"500px",
        "columns"=>array(
            "sale_no"=>array(
                "label"=>"sale No"
            ),
            "pkgs"=>array(
                "type"=>"number",
                "label"=>"Pkgs",
                "prefix"=>"Pkgs",
            )
        ),
        "options"=>array(
            "title"=>"Stock View Per Sale No"
        )
    ));
?>
<?php
Table::create(array(
    "dataStore"=>$this->dataStore('sales_by_customer'),
        "columns"=>array(
            "sale_no"=>array(
                "label"=>"Sale No"
            ),
            "pkgs"=>array(
                "type"=>"number",
                "label"=>"Pkgs"
            )
        ),
    "cssClass"=>array(
        "table"=>"table table-hover table-bordered"
    )
));
?>
