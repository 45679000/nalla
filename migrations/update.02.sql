DROP TABLE material_types;
CREATE TABLE material_types(
	id            integer primary key AUTO_INCREMENT,
    name          varchar(120),
    uom           varchar(50),
    unit_cost     real,
    description   text,
    created_by    integer,
    created_on    timestamp DEFAULT CURRENT_TIMESTAMP,
    is_deleted    boolean default false,
    deleted_on    timestamp DEFAULT CURRENT_TIMESTAMP,
    deleted_by    integer
);

DELETE FROM packaging_materials;

ALTER TABLE `packaging_materials` CHANGE `category` `type_id` INT NULL DEFAULT NULL; 


INSERT INTO `brokers` (`code`, `name`, `deleted`) VALUES
('ANJL', 'ANJELI LIMITED', 1),
('ATLS', 'ATLAS TEA BROKERS LTD.', 1),
('TBEA ', 'Tea Brokers East Africa', 0),
('ATLS ', 'Atlas Tea Brokers ', 0),
('BICL', 'Bicorn Tea Brokers ', 0),
('CTBL', 'Choice Tea Brokers', 0),
('ANJL', 'Anjeli Limited', 0),
('CENT', 'Centreline Tea Brokers', 0),
('UNTB ', 'Union Tea Brokers', 0),
('ATBL', 'African Tea Brokers Limited', 0),
('VENS', 'Venus Tea Brokers Ltd', 0),
('COMK', 'Combrok Tea Brokers Limited', 0),
('PTBL ', 'Prudential Tea Brokers Ltd', 0),
('PRME', 'Prime Tea Brokers Ltd', 0),
('BTBL', 'Besty Tea Brokers Ltd', 0),
('KTDA', 'KENYA TEA DEVELOPMENT AGENCY', 0);