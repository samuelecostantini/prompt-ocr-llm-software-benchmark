create table migrations
(
    id        int unsigned auto_increment
        primary key,
    migration varchar(255) not null,
    batch     int          not null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO laravel.migrations (id, migration, batch) VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (4, '2025_07_30_152729_create_document_details_table', 1);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (5, '2025_07_30_161146_create_documents_table', 1);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (6, '2025_07_30_164541_create_document_document_detail', 1);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (7, '2025_07_30_161820_create_media_table', 2);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (8, '2025_08_02_105628_change_nullable_on_document_details', 3);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (9, '2025_08_02_110138_set_nullable_all_columns_of_document_details', 4);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (10, '2025_08_02_114104_add_value_to_extracted_fields', 5);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (11, '2025_08_02_120628_add_timestamp_to_extracted_fields', 6);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (12, '2025_08_02_120903_add_id_to_extracted_fields', 7);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (13, '2025_08_02_190220_create_extraction_results_table', 8);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (14, '2025_08_02_192945_change_id_on_extracted_fields', 9);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (15, '2025_08_02_193819_change_value_to_extracted_fields', 10);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (16, '2025_09_20_165447_create_prompts_table', 11);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (17, '2025_09_20_165627_add_slug_to_prompts_table', 12);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (18, '2025_09_21_092037_add_prompt_id_to_extraction_results_table', 13);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (19, '2025_09_21_092304_add_document_id_to_extraction_result_table', 14);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (20, '2025_09_21_093806_add_outcome_to_extraction_results_table', 15);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (21, '2025_09_21_093807_add_outcome_to_extraction_results_table', 16);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (22, '2025_09_21_113202_add_prompt_id_to_documents_table', 17);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (23, '2025_09_21_161621_create_tags_table', 18);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (24, '2025_09_21_170928_create_document_tag_table', 19);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (25, '2025_09_21_173040_create_detail_sets_table', 20);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (26, '2025_09_24_153629_add_detail_set_id_to_document_details', 21);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (27, '2025_09_24_163857_add_detail_set_id_to_documents_table', 22);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (28, '2025_09_25_144442_create_notifications_table', 23);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (29, '2025_09_25_144453_create_imports_table', 23);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (30, '2025_09_25_144454_create_exports_table', 23);
INSERT INTO laravel.migrations (id, migration, batch) VALUES (31, '2025_09_25_144455_create_failed_import_rows_table', 23);
