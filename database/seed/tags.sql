create table tags
(
    id          bigint unsigned auto_increment
        primary key,
    title       varchar(255)    not null,
    slug        varchar(255)    not null,
    description varchar(255)    null,
    user_id     bigint unsigned not null,
    created_at  timestamp       null,
    updated_at  timestamp       null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (4, 'Invoice', 'invoice', null, 1, '2025-09-25 17:40:16', '2025-09-25 17:41:25');
INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (5, 'Receipt', 'receipt', null, 1, '2025-09-25 17:40:22', '2025-09-25 17:40:22');
INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (6, 'Financial statements', 'financial-statements', null, 1, '2025-09-25 17:40:27', '2025-09-25 17:40:27');
INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (7, 'Purchase orderd', 'purchase-orderd', null, 1, '2025-09-25 17:40:48', '2025-09-25 17:40:48');
INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (8, 'Contract', 'contract', null, 1, '2025-09-25 17:40:58', '2025-09-25 17:40:58');
INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (9, 'Pay slip', 'pay-slip', null, 1, '2025-09-25 17:41:09', '2025-09-25 17:41:09');
INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (10, 'Native PDF', 'native-pdf', null, 1, '2025-09-25 17:42:13', '2025-09-25 17:42:13');
INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (11, 'Scanned PDF', 'scanned-pdf', null, 1, '2025-09-25 17:42:21', '2025-09-25 17:42:21');
INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (12, 'Picture', 'picture', 'PNG, JPG', 1, '2025-09-25 17:42:59', '2025-09-25 17:42:59');
INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (13, 'Digital', 'digital', null, 1, '2025-09-25 17:44:04', '2025-09-25 17:44:04');
INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (14, 'Handwritten', 'handwritten', null, 1, '2025-09-25 17:44:25', '2025-09-25 17:44:25');
INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (15, 'High-definition', 'high-definition', 'Specificare densità di pixel', 1, '2025-09-25 17:44:59', '2025-09-25 17:46:41');
INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (16, 'Low-definition', 'low-definition', 'Specificare densità pixel', 1, '2025-09-25 17:45:17', '2025-09-25 17:45:17');
INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (17, 'Distorted', 'distorted', 'Foto fatta male', 1, '2025-09-25 17:45:56', '2025-09-25 17:45:56');
INSERT INTO laravel.tags (id, title, slug, description, user_id, created_at, updated_at) VALUES (18, 'Noisy', 'noisy', 'Foto con rumore', 1, '2025-09-25 17:46:27', '2025-09-25 17:46:27');
