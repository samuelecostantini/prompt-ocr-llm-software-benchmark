<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Docs extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Docs';

    protected static ?int $navigationSort = 20;

    protected static string $view = 'filament.pages.docs';
}