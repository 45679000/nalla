CREATE TABLE stock_to_33(
    stock_id                        integer,
    import_date	                    varchar(120),
    sale_no	                        varchar(120),
    broker                          varchar(120),
	ware_house                       varchar(120),
	lot	                            varchar(120),
    origin                            varchar(120),
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
    allocated_pkgs	                varchar(120),
    un_allocated	                varchar(120),
    allocated_shipped	            varchar(120),
    allocated_awaiting_shippment    varchar(120)

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
