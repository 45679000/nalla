ALTER TABLE users ADD COLUMN  `gender` VARCHAR(50);
ALTER TABLE users ADD COLUMN  `mobile` VARCHAR(50);
ALTER TABLE users ADD COLUMN  `image` VARCHAR(50);
ALTER TABLE users ADD COLUMN  `status` VARCHAR(50);
ALTER TABLE users ADD COLUMN  `designation` VARCHAR(50);


DROP TABLE update_purchase_list;
CREATE TABLE update_purchase_list(
    lot         varchar(10),
    pkgs        varchar(120),
    kgs         varchar(120),
    sale_price  varchar(120),
    net         varchar(120)
);
INSERT INTO update_purchase_list(lot, pkgs, sale_price, kgs) 
        
VALUES
(10058,  40, 2.86*100,   3160.0, 79),
(10078,  40, 2.57*100,   2476.0, 62),
(10080,  40, 2.59*100,   2480.0, 62),
(10140,  40, 2.58*100,   2480.0, 62),
(0386,   40, 1.28*100,   2316.0, 58),
(0390,   40, 1.24*100,   2316.0, 58),
(0391,   40, 1.26*100,   2316.0, 58),
(0398,   40, 1.42*100,   2396.0, 60),
(0399,   40, 1.40*100,   2396.0, 60),
(0459,   40, 1.28*100,   2600.0, 65),
(35366,  40, 1.49*100,   2680.0, 67),
(35368,  40, 1.50*100,   2680.0, 67),
(35385,  40, 1.40*100,   2560.0, 64),
(35386,  40, 1.40*100,   2560.0, 64),
(35503,  40, 2.02*100,   2476.0, 62),
(19612,  20, 1.17*100,   1498.0, 75),
(28441,  40, 2.68*100,   2480.0, 62),
(28598,  20, 1.36*100,   1196.0, 60),
(3820,   40, 2.47*100,   2800.0, 70),
(3902,   40, 1.42*100,   2396.0, 60),
(3904,   40, 1.40*100,   2396.0, 60),
(4259,   20, 2.17*100,   1236.0, 62),
(4267,   20, 1.48*100,   1496.0, 75),
(4274,   20, 2.08*100,   1096.0, 55),
(4280,   20, 1.99*100,   1196.0, 60),
(21493,  40, 2.58*100,   2480.0, 62),
(21508,  40, 2.64*100,   2476.0, 62),
(21509,  40, 2.66*100,   2476.0, 62),
(21510,  40, 2.66*100,   2480.0, 62),
(21548,  40, 2.55*100,   2480.0, 62),
(21554,  40, 2.67*100,   2480.0, 62),
(21584,  40, 2.70*100,   2480.0, 62),
(7020,   20, 0.95*100,   1400.0, 70),
(7055,   20, 1.94*100,   1200.0, 60),
(7056,   20, 1.69*100,   1200.0, 60),
(7156,   20, 0.65*100,   1300.0, 65),
(18230,  40, 2.65*100,   2476.0, 62),
(18232,  40, 2.66*100,   2480.0, 62),
(18448,  40, 1.20*100,   2596.0, 65);

UPDATE closing_cat 
INNER JOIN update_purchase_list ON update_purchase_list.lot = closing_cat.lot
SET closing_cat.pkgs = update_purchase_list.pkgs,
closing_cat.sale_price = update_purchase_list.sale_price,
closing_cat.net = update_purchase_list.kgs
WHERE sale_no = '2021-33' AND confirmed = 1;

DELETE FROM closing_stock WHERE closing_stock.stock_id IN (SELECT closing_stock.stock_id
FROM `closing_stock` 
LEFT JOIN shippments ON shippments.stock_id = closing_stock.stock_id
WHERE sale_no = '2021-28' AND shippments.id IS NULL AND import_date IS NULL);
