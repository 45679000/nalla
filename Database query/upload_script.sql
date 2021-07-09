DELETE FROM closing_stock;
ALTER TABLE closing_stock AUTO_INCREMENT = 1;
INSERT INTO `closing_stock`(stock_id, `sale_no`, `broker`, `comment`, `ware_hse`, `lot`, `mark`, 
`grade`, `invoice`, `pkgs`, `net`, `kgs`, `sale_price`, `buyer_package`, `import_date`) 
SELECT stock_id, sale_no, broker, comment, company, closing_stock_import.lot, mark, grade, invoice, pkgs, 
net, kgs, sale_price, buyer_package, import_date FROM closing_stock_import 
INNER JOIN (SELECT lot, COUNT(*) c FROM closing_stock_import GROUP BY lot HAVING c =1 ) a ON a.lot = closing_stock_import.lot


INSERT IGNORE INTO `closing_stock`(`sale_no`, `broker`, `comment`, `ware_hse`, `lot`, `mark`, 
`grade`, `invoice`, `pkgs`, `net`, `kgs`, `sale_price`, `buyer_package`, `import_date`) 
SELECT sale_no, broker, comment, company, closing_stock_import.lot, mark, grade, invoice, pkgs, 
net, kgs, sale_price, buyer_package, import_date 
FROM closing_stock_import 
WHERE lot NOT IN(SELECT lot FROM closing_stock) AND closing_stock_import.pkgs>5;

INSERT INTO `stock_allocation`(`stock_id`, `client_id`, `standard`, `allocated_pkgs`, `warehouse`)
SELECT stock_id, value, standard, pkgs, 1
FROM closing_stock_import;
