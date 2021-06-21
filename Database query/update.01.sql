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