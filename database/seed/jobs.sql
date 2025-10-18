create table jobs
(
    id           bigint unsigned auto_increment
        primary key,
    queue        varchar(255)     not null,
    payload      longtext         not null,
    attempts     tinyint unsigned not null,
    reserved_at  int unsigned     null,
    available_at int unsigned     not null,
    created_at   int unsigned     not null
)
    collate = utf8mb4_unicode_ci;

create index jobs_queue_index
    on jobs (queue);

