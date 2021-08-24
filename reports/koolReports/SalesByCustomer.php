<?php
require_once "koolreport/core/autoload.php";
use \koolreport\processes\Group;
use \koolreport\processes\Sort;
use \koolreport\processes\Limit;

class SalesByCustomer extends \koolreport\KoolReport
{
    public function settings()
    {
        return array(
            "dataSources"=>array(
                "sales"=>array(
                    "connectionString"=>"mysql:host=localhost;dbname=chamu",
                    "username"=>"chamu",
                    "password"=>"",
                    "charset"=>"utf8"
                )
            )
        );
    }

    public function setup()
    {
        $this->src('sales')
        ->query("SELECT sale_no, pkgs  FROM closing_stock")
        ->pipe(new Group(array(
            "by"=>"sale_no",
            "sum"=>"pkgs"
        )))
        ->pipe(new Sort(array(
            "sale_no"=>"desc"
        )))
        ->pipe($this->dataStore('sales_by_customer'));
    }
}