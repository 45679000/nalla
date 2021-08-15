CREATE TABLE roles(
    role_id                       integer primary key AUTO_INCREMENT,
    role_name                     varchar(120),
    description                   varchar(120)
);
CREATE TABLE access_levels(
    access_level_id               integer primary key AUTO_INCREMENT,
    role_id                       integer references roles,
    menu_name                     text
);

CREATE TABLE users(
    user_id                       integer primary key AUTO_INCREMENT,
    user_name                     varchar(120),
    full_name                     varchar(120),
    role_id                       integer references roles,
    email                         varchar(120),
    password                      varchar(120),
    two_factor_auth_code          varchar(120),
    last_login                    timestamp,
    is_active                     boolean default true
);

CREATE TABLE closing_cat_import(
    closing_cat_import_id           integer primary key AUTO_INCREMENT,
    sale_no                         varchar(120),
    comment                         varchar(120),
    category                        varchar(100),
    empty_col1                      varchar(120),
    ware_hse                        varchar(120),
    entry_no                        varchar(120),
    value                           varchar(120),
    empty_col2                      varchar(120),
    lot                             varchar(120),
    company                         varchar(120),
    mark                            varchar(120),
    grade                           varchar(120),
    manf_date                       varchar(120),
    ra                              varchar(120),
    rp                              varchar(120),
    invoice                         varchar(120),
    pkgs                            varchar(120),
    type                            varchar(120),
    net                             varchar(120),
    gross                           varchar(120),
    kgs                             varchar(120),
    tare                            varchar(120),
    sale_price                      varchar(120),
    buyer_package                   varchar(120),
    import_date                     timestamp default current_timestamp,
    imported                        boolean default false,
    imported_by                     integer
);

CREATE TABLE closing_cat(
    closing_cat_import_id           integer primary key AUTO_INCREMENT,
    sale_no                         varchar(120),
    comment                         varchar(120),
    ware_hse                        varchar(120),
    entry_no                        varchar(120),
    value                           varchar(120),
    lot                             varchar(120),
    company                         varchar(120),
    mark                            varchar(120),
    grade                           varchar(120),
    manf_date                       varchar(120),
    ra                              varchar(120),
    rp                              varchar(120),
    invoice                         varchar(120),
    pkgs                            varchar(120),
    type                            varchar(120),
    net                             varchar(120),
    gross                           varchar(120),
    kgs                             varchar(120),
    tare                            varchar(120),
    sale_price                      varchar(120),
    buyer_package                   varchar(120),
    import_date                     timestamp default current_timestamp,
    imported                        boolean default false,
    imported_by                     integer
);	

CREATE TABLE auctions(
	id                              serial primary key,
    position                        integer,
    auction_id                      varchar(10),
    created_by                      integer REFERENCES users,
    created_on                      timestamp,
	is_deleted                      boolean default false,
    updated_on                      timestamp
    
);
DROP TABLE departments;
ALTER TABLE users ADD COLUMN department_id  integer;
CREATE TABLE departments(
	department_id     integer PRIMARY KEY,
    department_name   VARCHAR(120),
    department_leader integer
    
);
DELETE FROM departments;
INSERT INTO departments(department_id, department_name, department_leader)
VALUES(01, 'Tea Room', 4),
(02, 'Finance', 5),
(03, 'Stock', 16),
(04, 'Shipping', 13),
(05, 'Warehousing', 12);

CREATE TABLE activities(
    id 				integer PRIMARY KEY,
    activity        varchar(120),
    department_id   integer,
    number_of_days  integer,
    details         text,
    active          boolean default true  
);
DELETE FROM activities;
INSERT INTO activities(id, activity, department_id, number_of_days, details, active)
VALUES(001, 'closing catalogue import', 01, 1, 'Import closing catalogue in the system', true ),
(002, 'valuation catalogue import', 01, 1, 'Import valuation catalogue in the system', true ),
(003, 'post catalogue import', 01, 1, 'Import post catalogue in the system', true ),
(004, 'Confirm Lots', 01, 1, 'Confirm and amend Lots bought', true ),
(005, 'Confirm Purchase List', 01, 1, 'Confirm and amend Lots bought', true ),
(006, 'Allocate Stock To Buyers', 03, 1, 'Allocate Stock To Buyers', true ),
(007, 'Issue Teas', 03, 1, 'Issue Teas for shipping', true ),
(008, 'Create Shipping Instructions', 04, 1, 'Create Shipping Instructions', true ),
(009, 'Update SI status', 05, 1, 'Update status of the SI', true ),
(010, 'Allocate Materials Used', 05, 1, 'Allocated materials used with the SI', true ),
(011, 'Confirm Shippment', 05, 1, 'Confirm Shippment For SI', true ),
(012, 'Close Blends', 05, 1, 'Confirm Shippment For SI', true );


DROP TABLE auction_activities;
CREATE TABLE auction_activities(
    id 				integer PRIMARY KEY AUTO_INCREMENT,
    activity_id     integer,
    auction_no      varchar(50),
    user_id         integer,
    done_on         timestamp,
    details         text,
    completed       boolean default false,
    emailed         boolean default false
    
);
INSERT INTO auction_activities(id, activity_id, auction_no, done_on,  details, completed, emailed)
VALUES(1, 004, '2021-32', NULL, "Approve lots bought in sale 32", false, false);

