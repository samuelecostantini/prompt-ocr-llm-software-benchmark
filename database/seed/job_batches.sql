create table job_batches
(
    id             varchar(255) not null
        primary key,
    name           varchar(255) not null,
    total_jobs     int          not null,
    pending_jobs   int          not null,
    failed_jobs    int          not null,
    failed_job_ids longtext     not null,
    options        mediumtext   null,
    cancelled_at   int          null,
    created_at     int          not null,
    finished_at    int          null
)
    collate = utf8mb4_unicode_ci;

INSERT INTO laravel.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) VALUES ('9ff69f86-a2e6-4281-9c5c-76ba7ab9ac32', '', 1, 0, 0, '[]', 'a:2:{s:13:"allowFailures";b:1;s:7:"finally";a:1:{i:0;O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:3661:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:4:{s:9:"columnMap";a:7:{s:4:"name";s:4:"name";s:4:"slug";s:4:"slug";s:4:"type";s:4:"type";s:8:"nullable";s:8:"nullable";s:7:"user_id";s:7:"user_id";s:13:"detail_set_id";s:13:"detail_set_id";s:26:"additional_info_for_prompt";s:26:"additional_info_for_prompt";}s:6:"import";O:45:"Illuminate\\Contracts\\Database\\ModelIdentifier":5:{s:5:"class";s:38:"Filament\\Actions\\Imports\\Models\\Import";s:2:"id";i:1;s:9:"relations";a:0:{}s:10:"connection";s:5:"mysql";s:15:"collectionClass";N;}s:13:"jobConnection";N;s:7:"options";a:0:{}}s:8:"function";s:2925:"function () use ($columnMap, $import, $jobConnection, $options) {
                    $import->touch(\'completed_at\');

                    event(new \\Filament\\Actions\\Imports\\Events\\ImportCompleted($import, $columnMap, $options));

                    if (! $import->user instanceof \\Illuminate\\Contracts\\Auth\\Authenticatable) {
                        return;
                    }

                    $failedRowsCount = $import->getFailedRowsCount();

                    \\Filament\\Notifications\\Notification::make()
                        ->title($import->importer::getCompletedNotificationTitle($import))
                        ->body($import->importer::getCompletedNotificationBody($import))
                        ->when(
                            ! $failedRowsCount,
                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->success(),
                        )
                        ->when(
                            $failedRowsCount && ($failedRowsCount < $import->total_rows),
                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->warning(),
                        )
                        ->when(
                            $failedRowsCount === $import->total_rows,
                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->danger(),
                        )
                        ->when(
                            $failedRowsCount,
                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->actions([
                                \\Filament\\Notifications\\Actions\\Action::make(\'downloadFailedRowsCsv\')
                                    ->label(trans_choice(\'filament-actions::import.notifications.completed.actions.download_failed_rows_csv.label\', $failedRowsCount, [
                                        \'count\' => \\Illuminate\\Support\\Number::format($failedRowsCount),
                                    ]))
                                    ->color(\'danger\')
                                    ->url(route(\'filament.imports.failed-rows.download\', [\'import\' => $import], absolute: false), shouldOpenInNewTab: true)
                                    ->markAsRead(),
                            ]),
                        )
                        ->when(
                            ($jobConnection === \'sync\') ||
                                (blank($jobConnection) && (config(\'queue.default\') === \'sync\')),
                            fn (\\Filament\\Notifications\\Notification $notification) => $notification
                                ->persistent()
                                ->send(),
                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->sendToDatabase($import->user, isEventDispatched: true),
                        );
                }";s:5:"scope";s:36:"Filament\\Tables\\Actions\\ImportAction";s:4:"this";N;s:4:"self";s:32:"00000000000009210000000000000000";}";s:4:"hash";s:44:"2dJntvZBi6+c4E6A3ld9CcW4Wv/d2xxb3fFa7pga7SM=";}}}}', null, 1758815871, 1758815873);
INSERT INTO laravel.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) VALUES ('9ff6ae10-c533-4e7d-8e2d-c2b31f6bc54a', '', 1, 0, 0, '[]', 'a:2:{s:13:"allowFailures";b:1;s:7:"finally";a:1:{i:0;O:47:"Laravel\\SerializableClosure\\SerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Signed":2:{s:12:"serializable";s:3661:"O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:4:{s:9:"columnMap";a:7:{s:4:"name";s:4:"name";s:4:"slug";s:4:"slug";s:4:"type";s:4:"type";s:8:"nullable";s:8:"nullable";s:7:"user_id";s:7:"user_id";s:13:"detail_set_id";s:13:"detail_set_id";s:26:"additional_info_for_prompt";s:26:"additional_info_for_prompt";}s:6:"import";O:45:"Illuminate\\Contracts\\Database\\ModelIdentifier":5:{s:5:"class";s:38:"Filament\\Actions\\Imports\\Models\\Import";s:2:"id";i:2;s:9:"relations";a:0:{}s:10:"connection";s:5:"mysql";s:15:"collectionClass";N;}s:13:"jobConnection";N;s:7:"options";a:0:{}}s:8:"function";s:2925:"function () use ($columnMap, $import, $jobConnection, $options) {
                    $import->touch(\'completed_at\');

                    event(new \\Filament\\Actions\\Imports\\Events\\ImportCompleted($import, $columnMap, $options));

                    if (! $import->user instanceof \\Illuminate\\Contracts\\Auth\\Authenticatable) {
                        return;
                    }

                    $failedRowsCount = $import->getFailedRowsCount();

                    \\Filament\\Notifications\\Notification::make()
                        ->title($import->importer::getCompletedNotificationTitle($import))
                        ->body($import->importer::getCompletedNotificationBody($import))
                        ->when(
                            ! $failedRowsCount,
                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->success(),
                        )
                        ->when(
                            $failedRowsCount && ($failedRowsCount < $import->total_rows),
                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->warning(),
                        )
                        ->when(
                            $failedRowsCount === $import->total_rows,
                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->danger(),
                        )
                        ->when(
                            $failedRowsCount,
                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->actions([
                                \\Filament\\Notifications\\Actions\\Action::make(\'downloadFailedRowsCsv\')
                                    ->label(trans_choice(\'filament-actions::import.notifications.completed.actions.download_failed_rows_csv.label\', $failedRowsCount, [
                                        \'count\' => \\Illuminate\\Support\\Number::format($failedRowsCount),
                                    ]))
                                    ->color(\'danger\')
                                    ->url(route(\'filament.imports.failed-rows.download\', [\'import\' => $import], absolute: false), shouldOpenInNewTab: true)
                                    ->markAsRead(),
                            ]),
                        )
                        ->when(
                            ($jobConnection === \'sync\') ||
                                (blank($jobConnection) && (config(\'queue.default\') === \'sync\')),
                            fn (\\Filament\\Notifications\\Notification $notification) => $notification
                                ->persistent()
                                ->send(),
                            fn (\\Filament\\Notifications\\Notification $notification) => $notification->sendToDatabase($import->user, isEventDispatched: true),
                        );
                }";s:5:"scope";s:36:"Filament\\Tables\\Actions\\ImportAction";s:4:"this";N;s:4:"self";s:32:"00000000000009210000000000000000";}";s:4:"hash";s:44:"NsHUL8cdMCNIL9Zuwjnd+OzanVNv+d9ZZzyC8dqq7Ng=";}}}}', null, 1758818311, 1758818312);
