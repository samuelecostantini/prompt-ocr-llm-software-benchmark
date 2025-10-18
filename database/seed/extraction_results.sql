create table extraction_results
(
    id          bigint unsigned auto_increment
        primary key,
    result      varchar(255)    not null,
    created_at  timestamp       null,
    updated_at  timestamp       null,
    prompt_id   bigint unsigned null,
    document_id bigint unsigned null,
    outcome     varchar(255)    not null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO laravel.extraction_results (id, result, created_at, updated_at, prompt_id, document_id, outcome) VALUES (5, 'FAT-2023-000115 ottobre 2023Fornitori Elettronici S.p.A.IT01234567890Rivenditori Tech S.r.l.IT98765432101€2,500.00€500.0010', '2025-09-25 18:11:49', '2025-09-25 18:11:49', 1, 69, 'Default');
INSERT INTO laravel.extraction_results (id, result, created_at, updated_at, prompt_id, document_id, outcome) VALUES (6, '', '2025-09-25 18:25:43', '2025-09-25 18:25:43', 3, 70, 'Default');
INSERT INTO laravel.extraction_results (id, result, created_at, updated_at, prompt_id, document_id, outcome) VALUES (7, '', '2025-09-25 18:27:17', '2025-09-25 18:27:17', 3, 71, 'Default');
INSERT INTO laravel.extraction_results (id, result, created_at, updated_at, prompt_id, document_id, outcome) VALUES (8, 'F12345678915/09/2023Azienda S.r.l.12345678901Cliente S.p.A.98765432109€1.000,00€220,0010', '2025-10-17 11:33:07', '2025-10-17 11:33:07', 1, 75, 'Default');
INSERT INTO laravel.extraction_results (id, result, created_at, updated_at, prompt_id, document_id, outcome) VALUES (9, 'EXPLORA S.P.A.31-12-20204.795.93647.29147.291--------', '2025-10-17 11:36:11', '2025-10-17 11:36:11', null, 76, 'Default');
