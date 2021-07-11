DELETE FROM closing_stock;
ALTER TABLE closing_stock AUTO_INCREMENT = 1;
INSERT INTO `closing_stock`(stock_id, `sale_no`, `broker`, `comment`, `ware_hse`, `lot`, `mark`, 
`grade`, `invoice`, `pkgs`, `net`, `kgs`, `sale_price`, `buyer_package`, `import_date`) 
SELECT `sale_no`, `sale_date`, `broker`, `ware_hse`, `lot`, `origin`, `mark`, `grade`, `invoice`, `pkgs`, `net`, `kgs`, `sale_price`, `grade_code`, `aware_hse`, `si_blend_no`
 FROM `stock_import` 


INSERT IGNORE INTO `closing_stock`(`sale_no`, `broker`, `comment`, `ware_hse`, `lot`, `mark`, 
`grade`, `invoice`, `pkgs`, `net`, `kgs`, `sale_price`, `buyer_package`, `import_date`) 
SELECT sale_no, broker, comment, company, closing_stock_import.lot, mark, grade, invoice, pkgs, 
net, kgs, sale_price, buyer_package, import_date 
FROM closing_stock_import 
WHERE lot NOT IN(SELECT lot FROM closing_stock) AND closing_stock_import.pkgs>5;

INSERT INTO `stock_allocation`(`stock_id`, `client_id`, `standard`, `allocated_pkgs`, `warehouse`)
SELECT stock_id, value, standard, pkgs, 1
FROM closing_stock_import;



DELETE FROM closing_stock;
ALTER TABLE closing_stock AUTO_INCREMENT = 1;
INSERT INTO `closing_stock`(`sale_no`, `broker`, `comment`, `ware_hse`, `lot`, `mark`, 
`grade`, `invoice`, `pkgs`, `net`, `kgs`, `sale_price`,  `import_date`) 
SELECT `sale_no`,  `broker`, `grade_code`, `ware_hse`, `lot`,  `mark`, `grade`, `invoice`, `pkgs`, `net`, `kgs`, `sale_price`,  
`sale_date`
FROM `stock_import` where lot NOT IN(
    SELECT a.lot 
        FROM (SELECT lot, COUNT(*) c 
        FROM stock_import 
        GROUP BY lot HAVING c >1)AS a);

        DELETE FROM stock_import WHERE lot IN (SELECT lot FROM closing_stock);

        SELECT `sale_no`,  `broker`, `grade_code`, `ware_hse`, `lot`,  `mark`, `grade`, `invoice`, `pkgs` AS pkgs, `net`, `kgs`, `sale_price`,  
`sale_date`
FROM `stock_import` where lot IN(
    SELECT a.lot 
        FROM (SELECT lot, COUNT(*) c 
        FROM stock_import 
        GROUP BY lot HAVING c >1)AS a)
       
        ORDER BY lot ASC


ALTER TABLE closing_stock AUTO_INCREMENT = 574;

IN(16003, 18679, 2188, 35626, 4927);

UPDATE stock_import, closing_stock
SET stock_import.added_stock_id = closing_stock.stock_id
WHERE stock_import.lot = closing_stock.lot;


SELECT `client_id`, `si_blend_no`, `standard`
FROM `stock_import`  
ORDER BY `stock_import`.`standard` ASC

ALTER TABLE stock_allocation AUTO_INCREMENT = 1;
DELETE FROM stock_allocation;
INSERT INTO `stock_allocation`(`stock_id`, `client_id`, `standard`, `allocated_pkgs`, `warehouse`)
SELECT closing_stock.stock_id, stock_import.client_id, stock_import.standard, stock_import.pkgs, stock_import.aware_hse
FROM `closing_stock`
INNER JOIN stock_import ON stock_import.lot = closing_stock.lot