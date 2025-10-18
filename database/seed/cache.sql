create table cache
(
    `key`      varchar(255) not null
        primary key,
    value      mediumtext   not null,
    expiration int          not null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO laravel.cache (`key`, value, expiration) VALUES ('laravel_cache_356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1760700999);
INSERT INTO laravel.cache (`key`, value, expiration) VALUES ('laravel_cache_356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1760700999;', 1760700999);
INSERT INTO laravel.cache (`key`, value, expiration) VALUES ('laravel_cache_livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3', 'i:2;', 1753953996);
INSERT INTO laravel.cache (`key`, value, expiration) VALUES ('laravel_cache_livewire-rate-limiter:a17961fa74e9275d529f489537f179c05d50c2f3:timer', 'i:1753953996;', 1753953996);
