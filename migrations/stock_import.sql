DROP TABLE stock_to_33;
CREATE TABLE stock_to_33(
    stock_id                        integer,
    sale_no	                        varchar(120),
    import_date	                    varchar(120),
    broker                          varchar(120),
    broker_invoice                  varchar(120),
	ware_house                      varchar(120),
	lot	                            varchar(120),
    origin                          varchar(120),
    mark                            varchar(120),
	grade                           varchar(120),
	invoice                         varchar(120),
 	pkgs                            varchar(120),
	net	                            varchar(120),
    kgs	                            varchar(120),
    sale_price	                    varchar(120),
    standard	                    varchar(120),
    code	                        varchar(120),
    warehouse	                    varchar(120),
    blend_si	                    varchar(120),
    pkgs_allocated	                varchar(120),
    yet_to_allocate	                varchar(120),
    shipped	                        varchar(120),
    awaiting_shippment              varchar(120)

);

WHERE closing_stock.sale_no = '2020-16'


INSERT INTO `shippments`(`si_no`, `pkgs_shipped`, `shipped_kgs`, `siType`, `shippedBy`, `instruction_id`, `stock_id`)
SELECT closing_stock.allocation, allocated_shipped, stock_to_33.net*stock_to_33.allocated_shipped, 'straight', 1, 001, closing_stock.stock_id
FROM closing_stock
LEFT JOIN stock_to_33 ON stock_to_33.lot = closing_stock.lot AND stock_to_33.sale_no = closing_stock.sale_no AND stock_to_33.broker = closing_stock.broker
WHERE closing_stock.sale_no = '2020-11';


INSERT INTO `shippments`(`si_no`, `pkgs_shipped`, `shipped_kgs`, `siType`, `shippedBy`, `instruction_id`, `stock_id`)
SELECT  closing_stock.allocation, allocated_shipped, stock_to_33.net*stock_to_33.allocated_shipped, 'straight', 1, 001, closing_stock.stock_id
FROM closing_stock
LEFT JOIN stock_to_33 ON stock_to_33.lot = closing_stock.lot AND stock_to_33.sale_no = closing_stock.sale_no AND stock_to_33.broker = closing_stock.broker
WHERE closing_stock.sale_no = '2020-16' AND allocated_shipped = closing_stock.pkgs
GROUP BY closing_stock.lot;


INSERT INTO `closing_stock`(`sale_no`, `broker`,  `comment`, `ware_hse`,  `lot`, `mark`, `grade`, `invoice`, `pkgs`,  `net`,  `kgs`,  `sale_price`, `standard`, `buyer_package`, `import_date`)
SELECT sale_no, broker, code, stock_to_33.ware_house, lot,  mark, grade, invoice, pkgs, net, kgs, sale_price, standard, 'CSS', import_date
FROM stock_to_33
WHERE stock_to_33.sale_no = '2020-19';

INSERT INTO `shippments`(`si_no`, `pkgs_shipped`, `shipped_kgs`, `siType`, `shippedBy`, `instruction_id`, `stock_id`)
SELECT  closing_stock.allocation, allocated_shipped, stock_to_33.net*stock_to_33.allocated_shipped, 'straight', 1, 001, closing_stock.stock_id
FROM closing_stock
LEFT JOIN stock_to_33 ON stock_to_33.lot = closing_stock.lot AND stock_to_33.sale_no = closing_stock.sale_no AND stock_to_33.broker = closing_stock.broker
WHERE closing_stock.sale_no = '2020-19' AND allocated_shipped = closing_stock.pkgs
GROUP BY closing_stock.lot;


INSERT INTO `closing_stock`(`sale_no`, `broker`,  `comment`, `ware_hse`,  `lot`, `mark`, `grade`, `invoice`, `pkgs`,  `net`,  `kgs`,  `sale_price`, `standard`, `buyer_package`, `import_date`)
SELECT sale_no, broker, code, stock_to_33.ware_house, lot,  mark, grade, invoice, pkgs, net, kgs, sale_price, standard, 'CSS', import_date
FROM stock_to_33
WHERE stock_to_33.sale_no = '2020-21';

INSERT INTO `shippments`(`si_no`, `pkgs_shipped`, `shipped_kgs`, `siType`, `shippedBy`, `instruction_id`, `stock_id`)
SELECT  closing_stock.allocation, allocated_shipped, stock_to_33.net*stock_to_33.allocated_shipped, 'straight', 1, 001, closing_stock.stock_id
FROM closing_stock
LEFT JOIN stock_to_33 ON stock_to_33.lot = closing_stock.lot AND stock_to_33.sale_no = closing_stock.sale_no AND stock_to_33.broker = closing_stock.broker
WHERE closing_stock.sale_no = '2020-21' AND allocated_shipped = closing_stock.pkgs
GROUP BY closing_stock.lot;


INSERT INTO `closing_stock`(`sale_no`, `broker`,  `comment`, `ware_hse`,  `lot`, `mark`, `grade`, `invoice`, `pkgs`,  `net`,  `kgs`,  `sale_price`, `standard`, `buyer_package`, `import_date`)
SELECT sale_no, broker, code, stock_to_33.ware_house, lot,  mark, grade, invoice, pkgs, net, kgs, sale_price, standard, 'CSS', import_date
FROM stock_to_33
WHERE stock_to_33.sale_no = '2020-24';

INSERT INTO `shippments`(`si_no`, `pkgs_shipped`, `shipped_kgs`, `siType`, `shippedBy`, `instruction_id`, `stock_id`)
SELECT  closing_stock.allocation, allocated_shipped, stock_to_33.net*stock_to_33.allocated_shipped, 'straight', 1, 001, closing_stock.stock_id
FROM closing_stock
LEFT JOIN stock_to_33 ON stock_to_33.lot = closing_stock.lot AND stock_to_33.sale_no = closing_stock.sale_no AND stock_to_33.broker = closing_stock.broker
WHERE closing_stock.sale_no = '2020-24' AND allocated_shipped = closing_stock.pkgs
GROUP BY closing_stock.lot;


INSERT INTO `closing_stock`(`sale_no`, `broker`,  `comment`, `ware_hse`,  `lot`, `mark`, `grade`, `invoice`, `pkgs`,  `net`,  `kgs`,  `sale_price`, `standard`, `buyer_package`, `import_date`)
SELECT sale_no, broker, code, stock_to_33.ware_house, lot,  mark, grade, invoice, pkgs, net, kgs, sale_price, standard, 'CSS', import_date
FROM stock_to_33
WHERE stock_to_33.sale_no IN('2020-32') AND lot NOT IN (SELECT lot FROM closing_stock WHERE sale_no IN('2020-32'));

INSERT INTO `shippments`(`si_no`, `pkgs_shipped`, `shipped_kgs`, `siType`, `shippedBy`, `instruction_id`, `stock_id`)
SELECT  closing_stock.allocation, allocated_shipped, stock_to_33.net*stock_to_33.allocated_shipped, 'straight', 1, 001, closing_stock.stock_id
FROM closing_stock
LEFT JOIN stock_to_33 ON stock_to_33.lot = closing_stock.lot AND stock_to_33.sale_no = closing_stock.sale_no AND stock_to_33.broker = closing_stock.broker
WHERE closing_stock.sale_no IN('2020-32') AND allocated_shipped = closing_stock.pkgs
GROUP BY closing_stock.lot;


INSERT INTO `closing_stock`(`sale_no`, `broker`,  `comment`, `ware_hse`,  `lot`, `mark`, `grade`, `invoice`, `pkgs`,  `net`,  `kgs`,  `sale_price`, `standard`, `buyer_package`, `import_date`)
SELECT sale_no, broker, code, stock_to_33.ware_house, lot,  mark, grade, invoice, pkgs, net, kgs, sale_price, standard, 'CSS', import_date
FROM stock_to_33
WHERE stock_to_33.sale_no IN('2020-33') AND lot NOT IN (SELECT lot FROM closing_stock WHERE sale_no IN('2020-33'));

INSERT INTO `shippments`(`si_no`, `pkgs_shipped`, `shipped_kgs`, `siType`, `shippedBy`, `instruction_id`, `stock_id`)
SELECT  closing_stock.allocation, allocated_shipped, stock_to_33.net*stock_to_33.allocated_shipped, 'straight', 1, 001, closing_stock.stock_id
FROM closing_stock
LEFT JOIN stock_to_33 ON stock_to_33.lot = closing_stock.lot AND stock_to_33.sale_no = closing_stock.sale_no AND stock_to_33.broker = closing_stock.broker
WHERE closing_stock.sale_no IN('2020-33') AND allocated_shipped = closing_stock.pkgs AND closing_stock.stock_id not in (SELECT stock_id from shippments)
GROUP BY closing_stock.lot;


INSERT INTO `closing_stock`(`sale_no`, `broker`,  `comment`, `ware_hse`,  `lot`, `mark`, `grade`, `invoice`, `pkgs`,  `net`,  `kgs`,  `sale_price`, `standard`, `buyer_package`, `import_date`)
SELECT sale_no, broker, code, stock_to_33.ware_house, lot,  mark, grade, invoice, pkgs, net, kgs, sale_price, standard, 'CSS', import_date
FROM stock_to_33
WHERE stock_to_33.sale_no IN('2020-34') AND lot NOT IN (SELECT lot FROM closing_stock WHERE sale_no IN('2020-34'));

INSERT INTO `shippments`(`si_no`, `pkgs_shipped`, `shipped_kgs`, `siType`, `shippedBy`, `instruction_id`, `stock_id`)
SELECT  closing_stock.allocation, allocated_shipped, stock_to_33.net*stock_to_33.allocated_shipped, 'straight', 1, 001, closing_stock.stock_id
FROM closing_stock
LEFT JOIN stock_to_33 ON stock_to_33.lot = closing_stock.lot AND stock_to_33.sale_no = closing_stock.sale_no AND stock_to_33.broker = closing_stock.broker
WHERE closing_stock.sale_no IN('2020-34') AND allocated_shipped = closing_stock.pkgs AND closing_stock.stock_id not in (SELECT stock_id from shippments)
GROUP BY closing_stock.lot;



INSERT INTO `closing_stock`(`sale_no`, `broker`,  `comment`, `ware_hse`,  `lot`, `mark`, `grade`, `invoice`, `pkgs`,  `net`,  `kgs`,  `sale_price`, `standard`, `buyer_package`, `import_date`)
SELECT sale_no, broker, code, stock_to_33.ware_house, lot,  mark, grade, invoice, pkgs, net, kgs, sale_price, standard, 'CSS', import_date
FROM stock_to_33
WHERE stock_to_33.sale_no IN('2020-35','2020-36','2020-37','2020-38','2020-39','2020-40','2020-41') AND lot NOT IN (SELECT lot FROM closing_stock WHERE sale_no IN('2020-35','2020-36','2020-37','2020-38','2020-39','2020-40','2020-41'));

INSERT INTO `shippments`(`si_no`, `pkgs_shipped`, `shipped_kgs`, `siType`, `shippedBy`, `instruction_id`, `stock_id`, `pkgs`)
SELECT  closing_stock.allocation, allocated_shipped, stock_to_33.net*stock_to_33.allocated_shipped, 'straight', 1, 001, closing_stock.stock_id, pkgs
FROM closing_stock
LEFT JOIN stock_to_33 ON stock_to_33.lot = closing_stock.lot AND stock_to_33.sale_no = closing_stock.sale_no AND stock_to_33.broker = closing_stock.broker
WHERE closing_stock.sale_no IN('2020-35','2020-36','2020-37','2020-38','2020-39','2020-40','2020-41') AND allocated_shipped = closing_stock.pkgs AND closing_stock.stock_id  not in (SELECT stock_id from shippments)
GROUP BY closing_stock.lot;



INSERT INTO `closing_stock`(`stock_id`, `sale_no`, `broker`,  `comment`, `ware_hse`,  `lot`, `mark`, `grade`, `invoice`, `pkgs`, `shipped_pkgs`, `net`,  `kgs`,  `sale_price`, `allocation`, `buyer_package`, `import_date`)
SELECT stock_id, sale_no, broker, code, stock_to_33.ware_house, lot,  mark, grade, invoice, pkgs, allocated_shipped,  net, kgs, sale_price, standard, 'CSS', import_date
FROM stock_to_33

INSERT INTO `shippments`(`si_no`, `pkgs_shipped`, `shipped_kgs`, `siType`, `shippedBy`, `instruction_id`, `stock_id`)
SELECT  a.allocation, a.pkgs_shipped, a.net*a.pkgs_shipped, 'straight', 1, '001', stock_id
FROM closing_stock a
WHERE pkgs_shipped = pkgs;


----- update 
ALTER TABLE stock_to_33 ADD COLUMN line_no varchar(100);
UPDATE stock_to_33 SET line_no = CONCAT(SUBSTRING(SUBSTRING('2020-18', 2, 3), 2, 3),  SUBSTRING(sale_no, 6, 2), source, LPAD(stock_id, 10, '0')) 
WHERE source = 'A';


UPDATE stock_to_33 SET line_no = CONCAT(SUBSTRING(SUBSTRING(sale_no, 2, 3), 2, 3), SUBSTRING(sale_no, 9, 10), source, LPAD(stock_id, 10, '0')) 
WHERE source = 'P';

UPDATE stock_to_33 SET line_no = CONCAT(SUBSTRING(SUBSTRING(sale_no, 2, 3), 2, 3), SUBSTRING(sale_no, 9, 10), source, LPAD(stock_id, 10, '0')) 
WHERE source = 'T';


DELETE FROM buying_list;
SET @row_number = 0; 
INSERT INTO `buying_list`(`buying_list_id`,`sale_no`, `broker`,  `comment`, `ware_hse`, `lot`,  `mark`, `grade`,  `invoice`, `pkgs`,  `net`,  `kgs`, `sale_price`, `standard`, `buyer_package`,  `auction_date`,  `allocated`, `added_to_plist`,  `target`,  `warehouse`, `broker_invoice`, `confirmed`,  `added_to_stock`, `source`) 
SELECT (@row_number:=@row_number + 1) AS num,
`sale_no`, `broker`,  `code`, `ware_house`, `lot`,  `mark`, `grade`,  `invoice`, SUM(`pkgs`),  `net`,  SUM(`kgs`),  `sale_price`, `standard`, 'CSS', `import_date`,  1, 
1, 1, `warehouse`, `broker_invoice`, 1,  1, `source` 
FROM `stock_to_33`
WHERE source = 'A' OR source = 'P'
GROUP BY lot, broker, sale_no, invoice
ORDER BY sale_no ASC;


UPDATE buying_list SET line_no = CONCAT(SUBSTRING(SUBSTRING(sale_no, 2, 3), 2, 3),  SUBSTRING(sale_no, 6, 2), source, LPAD(buying_list_id, 10, '0')) 
WHERE source = 'A';


UPDATE buying_list SET line_no = CONCAT(SUBSTRING(SUBSTRING(sale_no, 2, 3), 2, 3), SUBSTRING(sale_no, 9, 10), source, LPAD(buying_list_id, 10, '0')) 
WHERE source = 'P';




DELETE FROM `closing_stock`;
INSERT INTO `closing_stock`(stock_id, `sale_no`, `broker`,  `comment`, `ware_hse`,  `lot`, 
           `mark`, `grade`, `invoice`, `pkgs`,  `kgs`,  `net`,
             `sale_price`, `standard`, `buyer_package`, `import_date`)
             SELECT stock_id, `sale_no`, `broker`,  `code`, `stock_to_33`.`ware_house`,  `lot`,
            `mark`, `grade`,  `invoice`, `pkgs`,  `kgs`, `net`, 
            sale_price, `standard`, 'CSS',stock_to_33.import_date
            FROM `stock_to_33`;


UPDATE closing_stock
INNER JOIN buying_list ON closing_stock.lot = buying_list.lot 
AND buying_list.sale_no = closing_stock.sale_no
SET closing_stock.line_no = buying_list.line_no;


SET @row_number = 861; 

UPDATE `closing_stock` 
INNER JOIN (
    SELECT stock_id FROM closing_stock) a ON a.stock_id = closing_stock.stock_id
SET closing_stock.line_no = CONCAT(SUBSTRING(SUBSTRING(sale_no, 2, 3), 2, 3), SUBSTRING(sale_no, 9, 10), 'B', LPAD((@row_number:=@row_number + 1), 10, '0'))
WHERE broker = 'X';


UPDATE closing_stock
INNER JOIN stock_to_33 ON stock_to_33.stock_id = closing_stock.stock_id
SET closing_stock.shipped_pkgs = stock_to_33.shipped, 
closing_stock.allocation = stock_to_33.blend_si,
closing_stock.current_allocation = stock_to_33.awaiting_shippment;


INSERT INTO `shippments`(`si_no`, `pkgs_shipped`, `shipped_kgs`, `siType`, `shippedBy`, `instruction_id`, `stock_id`)
SELECT  a.allocation, a.pkgs_shipped, a.net*a.pkgs_shipped, 'straight', 1, '001', stock_id
FROM closing_stock a
WHERE pkgs_shipped = pkgs;


INSERT INTO `shippments`(`si_no`, `pkgs_shipped`, `shipped_kgs`, `siType`, `shippedBy`, `instruction_id`, `stock_id`)
SELECT  a.allocation, a.pkgs_shipped, a.net*a.pkgs_shipped, 'straight', 1, '001', stock_id
FROM closing_stock a
WHERE pkgs_shipped = pkgs;

INSERT INTO `buying_list`(`sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, `auction_date`, `imported`, `imported_by`, `allocated`, `added_to_plist`, `grading_comment`, `max_bp`, `target`, `allocation`, `warehouse`, `broker_invoice`, `confirmed`, `line_id`, `added_to_stock`, `source`) 
SELECT `sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`, `gross`, `kgs`, `tare`, `sale_price`, `standard`, `buyer_package`, `import_date`, `auction_date`, `imported`, `imported_by`, `allocated`, `added_to_plist`, `grading_comment`, `max_bp`, `target`, `allocation`, `warehouse`, `broker_invoice`, `confirmed`, `line_id`, `added_to_stock`, `source` 
FROM `buying_list_copy` WHERE sale_no = '2021-35';


SET @row_number = 1016; 
UPDATE `buying_list` 
INNER JOIN (
    SELECT buying_list_id FROM buying_list) a ON a.buying_list_id = buying_list.buying_list_id
SET buying_list.line_no = CONCAT(SUBSTRING(SUBSTRING(sale_no, 2, 3), 2, 3),  SUBSTRING(sale_no, 6, 2), 'A', LPAD((@row_number:=@row_number + 1), 10, '0'))
WHERE sale_no = '2021-35' 
ORDER BY lot ASC;
SELECT * FROM `buying_list` WHERE sale_no = '2021-35' AND added_to_plist = 1;


INSERT INTO `closing_stock`(`line_no`,`sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`, 
            `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `net`,  `kgs`,
             `sale_price`, `standard`, `buyer_package`, `import_date`)
             SELECT `line_no`, `sale_no`, `broker`, `category`, `comment`, `ware_hse`, `entry_no`, `value`, `lot`,
            `company`, `mark`, `grade`, `manf_date`, `ra`, `rp`, `invoice`, `pkgs`, `type`, `kgs`, `net`, 
            sale_price/100, `standard`, `buyer_package`, buying_list.auction_date
            FROM `buying_list`
            WHERE sale_no = '2021-35' AND added_to_plist = 1;







            https://vso.azurewebsites.net/api/CoachVisits/CoachVisitEndpoint.php?action=get-notes&access_token=687104627cc35378a1b906b609716d5f

            https://efl-portal.azurewebsites.net/uploads/Cohort 3 English Literacy Learners Workbook.pdf



            INSERT INTO `e_learning_media` (`id`, `class`, `file_name`, `file_size`, `file_url`, `file_type`, `session`, `description`, `uploaded_on`, `CohortId`, `category`) 
            VALUES (NULL, 'VSO TEST COHORT', ' Cohort 3 English Literacy Learners WorkBook ', '100000kb', 'https://efl-portal.azurewebsites.net/uploads/Cohort 3 English Literacy Learners Workbook.pdf'
', 'application/pdf', NULL, NULL, CURRENT_TIMESTAMP, '1', NULL);