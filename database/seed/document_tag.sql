create table document_tag
(
    id          bigint unsigned auto_increment
        primary key,
    document_id bigint unsigned not null,
    tag_id      bigint unsigned not null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (1, 66, 2);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (2, 66, 3);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (3, 67, 4);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (4, 67, 15);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (5, 67, 12);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (6, 67, 13);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (7, 67, 17);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (8, 68, 4);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (9, 68, 13);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (10, 68, 12);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (11, 68, 17);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (12, 68, 15);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (13, 69, 4);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (14, 69, 15);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (15, 69, 13);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (16, 69, 17);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (17, 69, 12);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (18, 74, 6);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (19, 74, 10);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (20, 74, 13);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (21, 74, 15);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (22, 75, 4);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (23, 75, 12);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (24, 75, 15);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (25, 75, 17);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (26, 75, 18);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (27, 76, 6);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (28, 76, 12);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (29, 76, 11);
INSERT INTO laravel.document_tag (id, document_id, tag_id) VALUES (30, 76, 15);
