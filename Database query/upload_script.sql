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

34490,1818,5285,16284,16336,16407)

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


INSERT INTO `closing_stock`(`sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, 
`company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`,  `kgs`,
 `sale_price`, `standard`, `buyer_package`
 SELECT  `sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`,
`company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `kgs`, `net`, 
`sale_price`, `standard`, `buyer_package`
FROM `closing_cat`
WHERE confirmed = 1 AND lot NOT IN (SELECT lot FROM closing_stock WHERE sale_no = )


SELECT * FROM closing_stock WHERE stock_id NOT IN (SELECT stock_id FROM stock_allocation) AND sale_no !='2021-27'


SELECT 
    lot, sale_no, COUNT(lot)
FROM
    closing_stock
GROUP BY 
    lot, sale_no
HAVING 
    COUNT(lot) > 1;


    DELETE t1 FROM closing_stock t1
INNER JOIN closing_stock t2 
WHERE 
    t1.lot < t2.lot AND 
    t1.sale_no = t2.sale_no
    AND t1.stock_id NOT IN (SELECT stock_id FROM stock_allocation) AND t2.sale_no !='2021-27'


INSERT INTO `closing_stock_temp` 
SELECT * FROM closing_stock
WHERE sale_no>'2021-27' AND lot NOT IN(SELECT lot FROM closing_stock INNER JOIN stock_allocation ON stock_allocation.stock_id = closing_stock.stock_id AND sale_no>'2021-27')
GROUP BY sale_no, lot;

UPDATE `closing_stock` SET allocation = NULL
WHERE allocation REGEXP '^[0-9]{4}$';

UPDATE `closing_stock` SET standard = NULL
WHERE standard  ! REGEXP '^[0-9]{4}$';

SELECT DISTINCT standard FROM `closing_stock` 
WHERE standard REGEXP '^[0-9]{4}$' = 0 AND ((standard NOT LIKE '%8146%') OR (standard NOT LIKE '%8117%') OR (standard NOT LIKE '%8226%')
OR (standard NOT LIKE '%2016%') OR (standard NOT LIKE '%8193%')
); 

UPDATE closing_stock SET standard = NULL WHERE standard IN(SELECT DISTINCT standard FROM `closing_stock` 
WHERE standard REGEXP '^[0-9]{4}$' = 0 AND ((standard NOT LIKE '%8146%') AND (standard NOT LIKE '%8117%') AND (standard NOT LIKE '%8226%')
AND (standard NOT LIKE '%2016%') AND (standard NOT LIKE '%8193%')));


UPDATE blend_teas
INNER JOIN stock_allocation ON stock_allocation.allocation_id = blend_teas.allocation_id
INNER JOIN closing_stock ON stock_allocation.stock_id = closing_stock.stock_id
SET blend_teas.stock_id = closing_stock.stock_id;