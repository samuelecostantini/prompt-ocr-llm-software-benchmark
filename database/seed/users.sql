create table users
(
    id                bigint unsigned auto_increment
        primary key,
    name              varchar(255) not null,
    email             varchar(255) not null,
    email_verified_at timestamp    null,
    password          varchar(255) not null,
    remember_token    varchar(100) null,
    created_at        timestamp    null,
    updated_at        timestamp    null,
    constraint users_email_unique
        unique (email)
)
    collate = utf8mb4_unicode_ci;

INSERT INTO laravel.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) VALUES (1, 'admin', 'samuele.costantini@studenti.unipg.it', null, '$2y$12$gHOqYJ/qM/cWjuT4GVoDmux7vBhu/zYrJSo98GfmkeE7sRbingAfG', 'UpgUlHuoGKeQMFAQiEAIpjVFr50IR9IRtG47BfszHYYXbczBtTs5M6MRuaxs', '2025-07-31 09:25:14', '2025-07-31 09:25:14');
