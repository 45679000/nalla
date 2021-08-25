
SELECT *FROM closing_stock WHERE lot NOT IN (30131,
    33924,
    30154,
    6681,
    17416,
    0099,
    0105,
    0113,
    0115,
    0120,
    0122,
    0131,
    0134,
    0136,
    0282,
    0283,
    0290,
    26558,
    4015,
    4117,
    4118,
    4207,
    21803,
    17327,
    17328,
    17344,
    17387,
    0634,
    0635,
    6563,
    6564,
    6566,
    6569,
    6594,
    6561,
    17498,
    17541,
    17544,
    17551,
    17556,
    17590,
    17592,
    17593,
    10540,
    0179,
    0181,
    0271,
    33969,
    33970,
    33982,
    33988,
    34015,
    4026,
    4090,
    4098,
    21790,
    6334,
    6363,
    16772,
    16865,
    0612,
    0620,
    0623,
    17431,
    17542,
    17543,
    17546,
    17547,
    17550,
    17552,
    17583,
    17584,
    17600,
    17605,
    17606,
    17608,
    17609,
    17401,
    17402,
    17403,
    17404,
    17405,
    17406,
    17407,
    17408,
    17409,
    17410
) AND sale_no = '2021-28';

SELECT *FROM closing_stock WHERE lot NOT IN(
    1246,
    1433,
    34490,
    4843,
    4892,
    5006,
    0955,
    34403,
    34470,
    30475,
    4611,
    4612,
    4860,
    7370,
    18334,
    0866,
    0875,
    0877,
    0880,
    0928,
    0930,
    0943,
    34346,
    34348,
    36376,
    26752,
    4656,
    4658,
    4753,
    4779,
    4792,
    7109,
    17820,
    17821,
    18214,
    18235,
    18236,
    18237,
    18239,
    34350,
    34354,
    1135,
    1141,
    18173,
    18174,
    18175,
    18177,
    18179,
    18181,
    18184,
    18185,
    18187,
    18188,
    18189
) AND sale_no = '2021-29';

UPDATE `closing_stock` SET client_id = 82 WHERE standard like 'TXP';

UPDATE `closing_stock` SET client_id = 82 WHERE standard like '%TXP%';

SELECT *FROM `closing_stock`;

UPDATE `closing_stock` SET client_id = 39 WHERE standard like '%TMK%'; 

UPDATE `closing_stock` SET allocation = standard WHERE CHAR_LENGTH(standard)>3 AND  REGEXP '([[:digit:]].*){7}';;


DELETE FROM closing_cat WHERE sale_no = '2021-34';
SELECT *
FROM closing_cat a
WHERE sale_no = '2021-34' AND a.broker = 'VENS' ORDER BY `auction_date`  ASC 

UPDATE closing_cat a
INNER JOIN closing_cat_import b ON a.lot = b.lot AND a.sale_no = b.sale_no AND a.broker = b.broker
SET a.value = b.value
WHERE b.value IS NOT NULL;

ALTER TABLE `closing_cat` ADD `line_id` VARCHAR(120) NOT NULL AFTER `confirmed`; 

UPDATE closing_cat a 
INNER JOIN closing_cat_import b ON (md5(CONCAT(trim(b.broker), trim(b.sale_no), trim(b.lot)))) COLLATE utf8mb4_unicode_ci = a.line_id 
SET a.value = b.value WHERE b.value IS NOT NULL

sudo apt install php php7.3-ldap php7.3-pdo php7.3-mbstring php7.3-tokenizer php7.3-curl php7.3-mysql php7.3-ldap php7.3-zip php7.3-fileinfo php7.3-gd php7.3-dom php7.3-mcrypt php7.3-bcmath php7.3-gd

UPDATE closing_cat a
INNER JOIN  (
              SELECT md5(CONCAT(trim(broker), trim(sale_no), trim(lot))) AS line_id, value, sale_price
                    FROM closing_cat_import
			) b ON  a.line_id = b.line_id          
SET a.sale_price = b.sale_price, 
    a.buyer_package = b.buyer_package 
WHERE b.sale_price IS NOT NULL


alter table closing_cat_import convert to character set utf8mb4 collate utf8mb4_unicode_ci;
alter table closing_cat convert to character set utf8mb4 collate utf8mb4_unicode_ci;


SELECT count(*) AS countLot, lot, sale_no
FROM `closing_stock` 
WHERE is_blend_balance = 0
GROUP BY lot, sale_no
HAVING countLot>1;


DELETE FROM closing_stock WHERE stock_id IN (SELECT stock_id FROM closing_stock
LEFT JOIN shippments ON shippments.stock_id = closing_stock.stock_id
WHERE sale_no = '2021-32' AND shippments.id IS NULL);

UPDATE `closing_stock` SET `import_date` = '2021-07-27' WHERE sale_no = '2021-32';