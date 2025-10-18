create table documents
(
    id         bigint unsigned auto_increment
        primary key,
    title      varchar(255)    null,
    prompt_id  bigint unsigned null,
    user_id    bigint unsigned not null,
    created_at timestamp       null,
    updated_at timestamp       null
)
    collate = utf8mb4_unicode_ci;

