create table sessions
(
    id            varchar(255)    not null
        primary key,
    user_id       bigint unsigned null,
    ip_address    varchar(45)     null,
    user_agent    text            null,
    payload       longtext        not null,
    last_activity int             not null
)
    collate = utf8mb4_unicode_ci;

create index sessions_last_activity_index
    on sessions (last_activity);

create index sessions_user_id_index
    on sessions (user_id);

INSERT INTO laravel.sessions (id, user_id, ip_address, user_agent, payload, last_activity) VALUES ('4hiQmw7tSa6hN7s45rENmPpEtGEmjpIRlrL6s4mj', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36 Edg/141.0.0.0', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiekFYWDRVd0tTR2JneW5sODY1STM3WjBKQVNoa3ZXUE1xYVZGRmYyaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9vY3Itc2Fhcy50ZXN0L2FkbWluL2RvY3VtZW50cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRnSE9xWUovcU0vY1dqdVQ0R1ZvRG11eDd2Qmh1L3pZckpTbzk4R2Zta2VFN3NSYmluZ0FmRyI7czo4OiJmaWxhbWVudCI7YTowOnt9fQ==', 1760701020);
