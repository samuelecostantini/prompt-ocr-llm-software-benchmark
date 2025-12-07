<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtractionResultResource\Pages;
use App\Models\Document;
use App\Models\ExtractionResult;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExtractionResultResource extends Resource
{
    protected static ?string $model = ExtractionResult::class;

    protected static ?string $slug = 'extraction-results';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-o-bars-arrow-down';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('result')
                    ->required(),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn (?ExtractionResult $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn (?ExtractionResult $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('result'),
                TextColumn::make('document_id')
                    ->getStateUsing(fn (?ExtractionResult $record) => Document::find($record->document_id)->name ?? '-'),
                TextColumn::make('prompt_id')
                    ->getStateUsing(fn (?ExtractionResult $record) => Document::find($record->prompt_id)->title ?? '-'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExtractionResults::route('/'),
            'create' => Pages\CreateExtractionResult::route('/create'),
            'edit' => Pages\EditExtractionResult::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
