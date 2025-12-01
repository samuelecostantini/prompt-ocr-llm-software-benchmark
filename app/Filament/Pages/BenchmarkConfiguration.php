<?php

namespace App\Filament\Pages;

use App\Models\Document;
use Filament\Pages\Page;
use JetBrains\PhpStorm\NoReturn;

class BenchmarkConfiguration extends Page
{
    public Document $document;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.benchmark-configuration';

    #[NoReturn]
    public function mount(): void
    {
        $this->document = Document::findOrFail(request('document_id'));
    }


}
