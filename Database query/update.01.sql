CREATE TABLE mark_country(
    id               integer AUTO_INCREMENT primary key,
    mark             varchar(120),
    country          varchar(120)
);

CREATE TABLE stock_allocation(
	allocation_id            integer PRIMARY KEY AUTO_INCREMENT,
    stock_id                 integer REFERENCES closing_stock (stock_id),
    buyer_standard           integer REFERENCES grading_standard (id),
    allocated_pkgs           float NOT NULL,
    si_id                    integer DEFAULT NULL,
    shipped                  integer default 0,
    deallocated              integer default 0,
    max_offered_price        float DEFAULT 0.00,
    mrp_value                float DEFAULT 0.00
);
ALTER TABLE `stock_allocation` ADD UNIQUE( `stock_id`, `buyer_standard`, `allocated_pkgs`, `deallocated`); 

INSERT INTO `grades` (`id`, `name`, `description`, `deleted`) VALUES
(3, 'PF1', 'PEKOE FANNING 1', 0),
(4, 'BP1', 'Black Broken Pekoe 1(BP1) has the largest size\n particles. Liquors are light in color but have an encouraging flavoring characteristic.', 0),
(5, 'PF1', 'Black Pekoe Fanning 1 (PF1) made up of black grainy\n particles slightly smaller than the Broken Pekoe 1 (BP1) giving a strong tasting tea.', 0),
(6, 'PD', '�Pekoe Dust (PD) is often black and finer than the \nPF1 and has thick liquors and aroma.', 0),
(7, 'D1', 'Black Dust 1 (D1) is made up of the smallest particles \nand characterized by strong liquors.', 0);