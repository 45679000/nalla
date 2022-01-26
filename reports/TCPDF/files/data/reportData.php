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
>>>>>>> af139fec1c03ede121782d5227f8c2dedfdff4c8

         $data = $this->executeQuery();

         return $data;

    }
    
}
// SELECT  tea_invoices.`id`, `buyer`, `consignee`, `address`,`invoice_no`, `invoice_type`, `invoice_category`, `port_of_delivery`, `port_of_discharge`,  tea_invoices.`payment_terms`, `buyer_contract_no`, `hs_code`, `final_destination`, `date_captured`,
//         `pay_bank`, `pay_details`, `date_captured`, 0_debtors_master.address,  pay_details,
//         tea_invoices.exporter, good_description, contract_no, other_references, terms_of_delivery, lot, mark_country.country, closing_stock.mark, grade, invoice, 
//         (pkgs*1) AS pkgs, net, (kgs*1) As kgs, sale_price AS rate_per_kg, ROUND((sale_price* kgs),2) AS final_amount, container_no, shipping_marks, buyer_bank, tea_invoices.bl_no, tea_invoices.hs_code, tea_invoices.shipping_marks, tea_invoices.pay_details
//         FROM `tea_invoices`
//            INNER JOIN  0_debtors_master ON tea_invoices.buyer = 0_debtors_master.debtor_no 
//            INNER JOIN  closing_stock ON closing_stock.profoma_invoice_no = tea_invoices.invoice_no 
//            INNER JOIN mark_country ON mark_country.mark = closing_stock.mark
//            WHERE tea_invoices.invoice_no =  'TXP 2389'
//          GROUP BY lot  
//         ORDER BY `tea_invoices`.`container_no`  DESC"



?>