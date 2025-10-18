<?php

namespace App\Filament\Imports;

use App\Models\DocumentDetail;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class DocumentDetailImporter extends Importer
{
    protected static ?string $model = DocumentDetail::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->rules(['max:255']),
            ImportColumn::make('slug')
                ->rules(['max:255']),
            ImportColumn::make('type')
                ->rules(['max:255']),
            ImportColumn::make('nullable')
                ->rules(['max:255']),
            ImportColumn::make('user_id')
                ->rules(['max:255']),
            ImportColumn::make('detail_set_id')
                ->rules(['max:255']),
            ImportColumn::make('additional_info_for_prompt')
                ->rules(['max:255']),
        ];
    }

    public function resolveRecord(): ?DocumentDetail
    {
        // return DocumentDetail::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new DocumentDetail();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your document detail import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
