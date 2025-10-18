create table media
(
    id                    bigint unsigned auto_increment
        primary key,
    model_type            varchar(255)                 not null,
    model_id              bigint unsigned              not null,
    uuid                  char(36)                     null,
    collection_name       varchar(255)                 not null,
    name                  varchar(255)                 not null,
    file_name             varchar(255)                 not null,
    mime_type             varchar(255)                 null,
    disk                  varchar(255)                 not null,
    conversions_disk      varchar(255)                 null,
    size                  bigint unsigned              not null,
    manipulations         longtext collate utf8mb4_bin not null
        check (json_valid(`manipulations`)),
    custom_properties     longtext collate utf8mb4_bin not null
        check (json_valid(`custom_properties`)),
    generated_conversions longtext collate utf8mb4_bin not null
        check (json_valid(`generated_conversions`)),
    responsive_images     longtext collate utf8mb4_bin not null
        check (json_valid(`responsive_images`)),
    order_column          int unsigned                 null,
    created_at            timestamp                    null,
    updated_at            timestamp                    null,
    constraint media_uuid_unique
        unique (uuid)
)
    collate = utf8mb4_unicode_ci;

create index media_model_type_model_id_index
    on media (model_type, model_id);

create index media_order_column_index
    on media (order_column);

