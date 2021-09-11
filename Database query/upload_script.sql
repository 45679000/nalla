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

SELECT * FROM `closing_stock` WHERE sale_no LIKE '%PRVT%'; 

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


UPDATE blend_teas
INNER JOIN blend_master ON blend_teas.blend_no = blend_master.id
SET blend_teas.confirmed = 1;

UPDATE `closing_cat` 
INNER JOIN closing_stock ON closing_stock.lot = closing_cat.lot
AND closing_stock.sale_no = closing_cat.sale_no AND closing_cat.broker = closing_stock.broker
SET closing_cat.auction_date = closing_stock.import_date;

UPDATE closing_cat SET confirmed = 0 
WHERE sale_no = '2021-32';

DELETE FROM closing_stock WHERE sale_no = '2021-32';
DELETE FROM auction_activities;

SELECT a.broker, count(a.lot) AS totalLots, SUM(a.pkgs) AS totalPkgs, SUM(a.kgs) AS totalKgs
FROM closing_cat a 
INNER JOIN closing_cat b ON a.closing_cat_import_id = b.closing_cat_import_id
AND a.sale_no = max(b.sale_no)
GROUP BY broker;

INSERT INTO `closing_cat_import_template`(`closing_cat_import_id`, `sale_no`, `broker`, `category`,  `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, `imported`, `imported_by`, `allocated`, `added_to_stock`, `grading_comment`, `max_bp`, `target`, `allocation`, `warehouse`)
SELECT DISTINCT `closing_cat_import_id`,`sale_no`, `broker`, `category`,  `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, `imported`, `imported_by`, `allocated`, `added_to_stock`, `grading_comment`, `max_bp`, `target`, `allocation`, `warehouse` 
FROM `closing_cat` WHERE sale_no >='2021-28'



UPDATE closing_cat_import_template 
INNER JOIN  closing_cat ON closing_cat_import_template.lot = closing_cat.lot AND closing_cat.sale_no = closing_cat_import_template.sale_no
AND closing_cat_import_template.broker = closing_cat.broker
SET closing_cat_import_template.grading_comment = closing_cat.grading_comment
WHERE closing_cat.grading_comment IS NOT NULL;


UPDATE closing_cat_import_template 
INNER JOIN ( SELECT DISTINCT sale_no, lot, broker, grading_comment, comment 
            FROM closing_cat
           WHERE grading_comment IS NOT NULL LIMIT 10) AS a
ON a.lot = closing_cat_import_template.lot 
AND a.sale_no = closing_cat_import_template.sale_no
AND a.broker = closing_cat_import_template.broker
SET closing_cat_import_template.grading_comment = a.grading_comment
WHERE a.grading_comment IS NOT NULL;


UPDATE closing_cat_import_template 
INNER JOIN grading_comment ON 
grading_comment.sale_no = closing_cat_import_template.sale_no
AND grading_comment.broker = closing_cat_import_template.broker
AND grading_comment.lot = closing_cat_import_template.lot
AND grading_comment.grading_comment = closing_cat_import_template.grading_comment
SET closing_cat_import_template.grading_comment = grading_comment.grading_comment;


UPDATE closing_cat_import_template 
INNER JOIN grading_code ON 
grading_code.sale_no = closing_cat_import_template.sale_no
AND grading_code.broker = closing_cat_import_template.broker
AND grading_code.lot = closing_cat_import_template.lot
AND grading_code.grading_comment = closing_cat_import_template.grading_comment
SET closing_cat_import_template.comment = grading_code.comment;


UPDATE closing_cat_import_template 
SET closing_cat_import_template.sale_price = ROUND(closing_cat_import_template.sale_price,1)
WHERE sale_price LIKE '%.%'


INSERT INTO `closing_cat`(`closing_cat_import_id`, comment, `sale_no`, `broker`, `category`,  `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, `imported`, `imported_by`, `allocated`, `added_to_stock`, `grading_comment`, `max_bp`, `target`, `allocation`, `warehouse`)
SELECT  `closing_cat_import_id`,comment, `sale_no`, `broker`, `category`,  `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, `imported`, `imported_by`, `allocated`, `added_to_stock`, `grading_comment`, `max_bp`, `target`, `allocation`, `warehouse` 
FROM  closing_cat_import_template
GROUP BY sale_no, broker, lot


UPDATE closing_cat SET sale_price = sale_price*100 WHERE LENGTH(sale_price) =1 AND  sale_price != 0



CREATE TABLE garden_grade_cluster(
	cluster_id							integer AUTO_INCREMENT PRIMARY KEY,
    garden                              varchar(120),
    grade_id                            integer,
    code_id                             integer,
    description                         text
);

UPDATE `buying_list` SET gross = kgs  WHERE sale_no < '2021-35';

UPDATE `buying_list` SET kgs = net  WHERE sale_no < '2021-35';

UPDATE `buying_list` SET net = gross  WHERE sale_no < '2021-35';

CREATE TABLE straightlineteas(
	id             		integer primary key,
    contract_no      	varchar(120),
    client_id           integer,
    created_on			date default CURRENT_DATE,
    details             text
    
);