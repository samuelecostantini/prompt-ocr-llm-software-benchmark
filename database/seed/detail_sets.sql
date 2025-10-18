create table detail_sets
(
    id         bigint unsigned auto_increment
        primary key,
    title      varchar(255) not null,
    slug       varchar(255) not null,
    created_at timestamp    null,
    updated_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO laravel.detail_sets (id, title, slug, created_at, updated_at) VALUES (2, 'Invoice', 'invoice', '2025-09-25 14:50:49', '2025-09-25 14:50:49');
INSERT INTO laravel.detail_sets (id, title, slug, created_at, updated_at) VALUES (3, 'Purchase orders', 'purchase-orders', '2025-09-25 14:51:27', '2025-09-25 14:51:27');
INSERT INTO laravel.detail_sets (id, title, slug, created_at, updated_at) VALUES (4, 'Receipt', 'receipt', '2025-09-25 14:51:40', '2025-09-25 14:51:40');
INSERT INTO laravel.detail_sets (id, title, slug, created_at, updated_at) VALUES (5, 'Contract', 'contract', '2025-09-25 14:52:02', '2025-09-25 14:52:02');
INSERT INTO laravel.detail_sets (id, title, slug, created_at, updated_at) VALUES (6, 'Pay slip', 'pay-slip', '2025-09-25 14:52:24', '2025-09-25 14:52:24');
INSERT INTO laravel.detail_sets (id, title, slug, created_at, updated_at) VALUES (7, 'Financial statements', 'financial-statements', '2025-09-25 14:53:02', '2025-09-25 14:53:02');
