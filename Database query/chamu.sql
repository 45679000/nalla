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
							
