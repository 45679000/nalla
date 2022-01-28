<?php
Class ReportData extends Model{
    public $invoiceNo;

    public function proformaInvoiceData(){
        $this->query = "SELECT * FROM tea_invoices";
        $invoice_no = $this->invoiceNo;
        $this->query = "SELECT  tea_invoices.`id`, `buyer`, `consignee`, `address`,`invoice_no`, `invoice_type`, `invoice_category`, `port_of_delivery`, `port_of_discharge`,  tea_invoices.`payment_terms`, `buyer_contract_no`, `hs_code`, `final_destination`, `date_captured`,
        `pay_bank`, `pay_details`, `date_captured`, 0_debtors_master.address,  pay_details,
        tea_invoices.exporter, good_description, contract_no, other_references, terms_of_delivery, lot, mark_country.country, closing_stock.mark, grade, invoice, 
        (pkgs*1) AS pkgs, net, (kgs*1) As kgs, sale_price AS rate_per_kg, ROUND((sale_price* kgs),2) AS final_amount, container_no, shipping_marks, buyer_bank, tea_invoices.bl_no, tea_invoices.hs_code, tea_invoices.shipping_marks, tea_invoices.pay_details
        FROM `tea_invoices`
           INNER JOIN  0_debtors_master ON tea_invoices.buyer = 0_debtors_master.debtor_no 
           INNER JOIN  closing_stock ON closing_stock.profoma_invoice_no = tea_invoices.invoice_no 
           INNER JOIN mark_country ON mark_country.mark = closing_stock.mark
           WHERE tea_invoices.invoice_no =  '$invoice_no'
         GROUP BY lot  
        ORDER BY `tea_invoices`.`container_no`  DESC";

         $data = $this->executeQuery();

         return $data;

    }
    public function profomaNittyGritty(){
        $invoice_no = $this->invoiceNo;
        $this->query = "SELECT `id`, `buyer`, `consignee`, `invoice_no`, `invoice_type`, `invoice_category`, `port_of_delivery`, `buyer_bank`, `payment_terms`, `pay_bank`, `pay_details`, `date_captured`, `exporter`, `good_description`, `contract_no`, `other_references`, `terms_of_delivery`, `container_no`, `shipping_marks`, `buyer_contract_no`, `port_of_discharge`, `hs_code`, `final_destination`, `buyer_address`, `bank_id`, `bl_no` FROM `tea_invoices` WHERE tea_invoices.invoice_no = '$invoice_no'";

         $data = $this->executeQuery();

         return $data;
    }
    public function loadTeas(){
        $invoice_no = $this->invoiceNo;
        $this->query = "SELECT line_no, invoice_teas.id, invoice_teas.stock_id, sale_no, broker, closing_stock.mark, lot, grade, invoice, pkgs, net,
        kgs, invoice_teas.profoma_amount,  mark_country.country,ROUND((invoice_teas.profoma_amount* kgs),2) AS final_amount
        FROM invoice_teas
        INNER JOIN closing_stock ON closing_stock.stock_id = invoice_teas.stock_id
        LEFT JOIN mark_country ON  mark_country.mark = closing_stock.mark
        WHERE invoice_no = '$invoice_no'
        GROUP BY stock_id";
        
        $data = $this->executeQuery();
        return $data;
    }
}

?>