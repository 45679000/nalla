<?php
Class ReportData extends Model{
    public $invoiceNo;
    public $invoiceArray = array();

    public function proformaInvoiceData(){
        $this->query = "SELECT * FROM tea_invoices";
        $invoice_no = $this->invoiceNo;
        $this->query = "SELECT  tea_invoices.`id`, `buyer`, `consignee`, `address`,`invoice_no`, `invoice_type`, `invoice_category`, `port_of_delivery`, `port_of_discharge`,  tea_invoices.`payment_terms`, `buyer_contract_no`, `hs_code`, `final_destination`, `date_captured`,
        `pay_bank`, `pay_details`, `date_captured`, `min_tax`,0_debtors_master.address,  pay_details,
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
    public function loadBlendInvoice(){
        $invoice_no = $this->invoiceNo;
        $this->query = "SELECT `item` ,`invoice_no`, `total_net`, `p_cif_rate`, `c_vat_amt`, `description_of_goods`, `p_amount` FROM `blend_invoice_line_no` WHERE invoice_no = '$invoice_no'";
        
        $data = $this->executeQuery();
        return $data;
    }
    public function getData(){
        $invoiceArr = $this->invoiceArray;
        $this->query = "SELECT closing_stock.stock_id, closing_stock.`stock_id`, closing_stock.`sale_no`, `broker`,
        `comment`, closing_stock.`ware_hse`,  `value`, `lot`,  mark_country.`mark`, closing_stock.`grade`, `invoice`,
        shippments.shipped_kgs AS kgs,  country, (CASE WHEN shipping_instructions.contract_no IS NOT NULL THEN  shipping_instructions.contract_no ELSE shippments.si_no END) AS allocation,
        `type`, `net`, shippments.pkgs_shipped ,  `sale_price`, closing_stock.`standard`, `mrp_value`,
        DATE_FORMAT(`import_date`,'%d/%m/%y') AS import_date, closing_stock.allocated_whse AS warehouse,
        shippments.is_shipped,  shippments.pkgs_shipped AS pkgs, CONCAT('CHAMU SUPPLIES LTD - LOT DETAILS-', '  ',COALESCE(shippments.si_no, ''), ' - ',COALESCE(shipping_instructions.no_containers_type, '') ,' - ', COALESCE(0_debtors_master.debtor_ref,''), '-', COALESCE(destination_total_place_of_delivery, '')) AS header, shipping_instructions.shipping_marks, note FROM shippments
        INNER JOIN closing_stock ON closing_stock.stock_id = shippments.stock_id
        LEFT JOIN straightlineteas ON straightlineteas.contract_no = shippments.si_no
        LEFT JOIN 0_debtors_master ON straightlineteas.client_id = 0_debtors_master.debtor_no
        INNER JOIN mark_country ON  mark_country.mark = closing_stock.mark
        LEFT JOIN shipping_instructions ON shipping_instructions.instruction_id = shippments.instruction_id";
        // if(count($invoiceArr) > 1){
            $this->query .=" WHERE trim(si_no) IN (";
            $count = 0;
            $lastValue = count($invoiceArr);
            foreach($invoiceArr as $key => $item){
                $this->query .=" trim('$item') ";
                $count ++;
                if($count == $lastValue){
                    $this->query .="";
                }else {
                    $this->query .=", ";
                }

            }
            $this->query .= ") GROUP BY lot, closing_stock.stock_id";
        // }
        $data = $this->executeQuery();
        return $data;
    }
    public function getShippingData(){
        $invoiceArr = $this->invoiceArray;
        $this->query = "SELECT shipping_instructions.buyer,shipping_instructions.no_containers_type, shipping_instructions.destination_total_place_of_delivery, shipping_instructions.contract_no, shipping_instructions.shippment_type FROM `shipping_instructions` LEFT JOIN straightlineteas ON straightlineteas.contract_no = shipping_instructions.contract_no ";
        // if(count($invoiceArr) > 1){
            $this->query .=" WHERE shipping_instructions.contract_no IN (";
            $count = 0;
            $lastValue = count($invoiceArr);
            foreach($invoiceArr as $key => $item){
                $this->query .=" trim('$item') ";
                $count ++;
                if($count == $lastValue){
                    $this->query .="";
                }else {
                    $this->query .=", ";
                }

            }
            $this->query .= ")";
        // } 
        // else {
        //     $this->query .=" WHERE shipping_instructions.contract_no IN ('$invoiceArr[0]')";

        // }
        
        $data = $this->executeQuery();
        return $data;
    }
}

?>
