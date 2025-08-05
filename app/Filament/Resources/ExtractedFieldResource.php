<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtractedFieldResource\Pages;
use App\Filament\Resources\ExtractedFieldResource\RelationManagers;
use App\Models\Document;
use App\Models\DocumentDetail;
use App\Models\ExtractedField;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Ufee\Sqlite3\Query\Select;

class ExtractedFieldResource extends Resource
{
    protected static ?string $model = ExtractedField::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('document_detail_id')
                    ->options(fn () => DocumentDetail::all()->pluck('name', 'id')),
                Forms\Components\Select::make('document_id')
                    ->options(fn () => Document::all()->pluck('title', 'id')),
                Forms\Components\TextInput::make('value'),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?Document $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?Document $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('document_id'),
                TextColumn::make('document_detail_id'),
                TextColumn::make('value'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExtractedFields::route('/'),
            'create' => Pages\CreateExtractedField::route('/create'),
            'edit' => Pages\EditExtractedField::route('/{record}/edit'),
        ];
    }
}
