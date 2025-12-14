<?php

namespace App\Filament\Pages;

use App\Filament\Resources\DocumentResource\RelationManagers\GroundTruthsRelationManager;
use App\Models\Document;
use Filament\Pages\Page;
use Filament\Resources\Pages\Concerns\HasRelationManagers;
use JetBrains\PhpStorm\NoReturn;

class BenchmarkConfiguration extends Page
{
    use HasRelationManagers;

    public Document $document;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.benchmark-configuration';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $this->document = Document::findOrFail(request('document_id'));
    }

    public function getRecord(): Document
    {
        return $this->document;
    }

    public function getRelationManagers(): array
    {
        return [
            GroundTruthsRelationManager::class,
        ];
    }
}
